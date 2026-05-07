<?php

namespace App\Models;

use App\Traits\UserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;
    use \Spatie\Permission\Traits\HasRoles;
    use UserTrait;

    protected $fillable = [
        'name',
        'created_by',
        'email',
        'phone',
        'store_name',
        'image',
        'status',
        'password',
        'role',
        'branch_id',
        'business_type_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    protected static function booted()
    {
        static::deleting(function ($user) {
            foreach ($user->products as $product) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }

                $product->delete();
            }

            foreach ($user->categories as $category) {
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }

                $category->delete();
            }

            foreach ($user->sliders as $slider) {
                if ($slider->image) {
                    Storage::disk('public')->delete($slider->image);
                }

                $slider->delete();
            }

            $user->settings()->delete();
        });

        static::created(function ($user) {
            $defaultSettings = [
                'logo',
                'name',
                'description',
                'phone',
                'whatsapp',
                'address',
                'theme',
                'status',
                'facebook',
                'instagram',
                'copyright',
                'maincolor',
                'curency',
                'secondcolor',
                'maintextcolor',
                'secoundtextcolor',
                'thirdtextcolor',
            ];

            foreach ($defaultSettings as $key) {
                Setting::create([
                    'user_id' => $user->id,
                    'key' => $key,
                    'value' => null,
                ]);
            }
        });
    }

    public function setPhoneAttribute($value)
    {
        if (empty($value)) {
            $this->attributes['phone'] = null;

            return;
        }

        $this->attributes['phone'] = str_starts_with($value, '+2')
            ? $value
            : '+20'.ltrim($value, '0+');
    }

    public function getLogoUrlAttribute()
    {
        $logoPathFromSetting = $this->settings()->firstWhere('key', 'logo')?->value;

        return $logoPathFromSetting
            ? asset('storage/'.$logoPathFromSetting)
            : null;
    }

    /*
    |--------------------------------------------------------------------------
    | Basic Relations
    |--------------------------------------------------------------------------
    */

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function latestSubscription()
    {
        return $this->hasOne(Subscription::class)->latestOfMany();
    }

    public function activeSubscriptions()
    {
        return $this->hasMany(Subscription::class)
            ->where('status', 'active')
            ->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now());
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'branch_users')
            ->withPivot([
                'role',
                'is_primary_manager',
                'can_manage_permissions',
                'permissions',
                'assigned_by',
            ])
            ->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | Store Owner / Subscription Owner
    |--------------------------------------------------------------------------
    */

    public function storeOwner()
    {
        if ($this->role === 'super_admin') {
            return $this;
        }

        // لو المستخدم معمول بواسطة صاحب حساب، يبقى تابع له حتى لو role = admin
        if (!empty($this->created_by)) {
            return self::find($this->created_by);
        }

        // الأدمن الأساسي فقط هو صاحب الحساب
        return $this;
    }

    public function hasActiveSubscription(): bool
    {
        if ($this->role === 'super_admin') {
            return true;
        }

        $storeOwner = $this->storeOwner();

        if (!$storeOwner) {
            return false;
        }

        return $storeOwner->activeSubscriptions()->exists();
    }

    public function activePackages()
    {
        $storeOwner = $this->storeOwner();

        if (!$storeOwner) {
            return collect();
        }

        return Package::whereHas('subscriptions', function ($q) use ($storeOwner) {
            $q->where('user_id', $storeOwner->id)
                ->where('status', 'active')
                ->where('is_active', true)
                ->where('starts_at', '<=', now())
                ->where('ends_at', '>=', now());
        })->with('permissions', 'businessType')->get();
    }

    public function hasPackagePermission(string $permissionKey): bool
    {
        if ($this->role === 'super_admin') {
            return true;
        }

        $storeOwner = $this->storeOwner();

        if (!$storeOwner) {
            return false;
        }

        return $storeOwner->activeSubscriptions()
            ->whereHas('package.permissions', function ($q) use ($permissionKey) {
                $q->where('permission_key', $permissionKey);
            })
            ->exists();
    }

    public function hasBusinessType(string $slug): bool
    {
        if ($this->role === 'super_admin') {
            return true;
        }

        $storeOwner = $this->storeOwner();

        if (!$storeOwner) {
            return false;
        }

        return $storeOwner->activeSubscriptions()
            ->whereHas('package.businessType', function ($q) use ($slug) {
                $q->where('slug', $slug);
            })
            ->exists();
    }

    /*
    |--------------------------------------------------------------------------
    | Branch Permissions
    |--------------------------------------------------------------------------
    */

    public function branchPermissions($branchId = null): array
    {
        $branch = null;

        if ($branchId) {
            $branch = $this->branches()
                ->where('branches.id', $branchId)
                ->first();
        }

        if (!$branch && $this->branch_id) {
            $branch = $this->branches()
                ->where('branches.id', $this->branch_id)
                ->first();
        }

        if (!$branch) {
            $branch = $this->branches()->first();
        }

        if (!$branch) {
            return [];
        }

        $permissions = $branch->pivot->permissions ?? [];

        if (is_string($permissions)) {
            $permissions = json_decode($permissions, true) ?: [];
        }

        return $permissions;
    }

    public function hasBranchPermission(string $permission, $branchId = null): bool
    {
        if ($this->role === 'super_admin') {
            return true;
        }

        $permissions = $this->branchPermissions($branchId);

        return in_array('*', $permissions, true)
            || in_array($permission, $permissions, true);
    }

    public function canAccessFeature(string $permission, $branchId = null): bool
    {
        if ($this->role === 'super_admin') {
            return true;
        }

        return $this->hasPackagePermission($permission)
            && $this->hasBranchPermission($permission, $branchId);
    }
}
