<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

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
            // 🟢 احذف المنتجات مع الصور
            foreach ($user->products as $product) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $product->delete();
            }

            // 🟢 احذف الكاتيجوريز مع الصور
            foreach ($user->categories as $category) {
                if ($category->image) {
                    Storage::disk('public')->delete($category->image);
                }
                $category->delete();
            }

            // 🟢 احذف السلايدر مع الصور
            foreach ($user->sliders as $slider) {
                if ($slider->image) {
                    Storage::disk('public')->delete($slider->image);
                }
                $slider->delete();
            }

            // احذف الإعدادات
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
        $this->attributes['phone'] = str_starts_with($value, '+2')
            ? $value
            : '+20'.ltrim($value, '0+');
    }

    public function getLogoUrlAttribute()
    {
        // get logo from settings
        $logoPathFromSetting = $this->settings()->firstWhere('key', 'logo')?->value;

        return $logoPathFromSetting ? asset('storage/'.$logoPathFromSetting) : null;
    }


    // Relations subscriptions
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscriptions()
    {
        return $this->hasMany(Subscription::class)
            ->where('status', 'active')
            ->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now());
    }

    public function activePackages()
    {
        return Package::whereHas('subscriptions', function ($q) {
            $q->where('user_id', $this->id)
                ->where('status', 'active')
                ->where('is_active', true)
                ->where('starts_at', '<=', now())
                ->where('ends_at', '>=', now());
        })->with('permissions', 'businessType')->get();
    }

    public function hasPackagePermission(string $permissionKey): bool
    {
        return $this->activeSubscriptions()
            ->whereHas('package.permissions', function ($q) use ($permissionKey) {
                $q->where('permission_key', $permissionKey);
            })
            ->exists();
    }

    public function hasBusinessType(string $slug): bool
    {
        return $this->activeSubscriptions()
            ->whereHas('package.businessType', function ($q) use ($slug) {
                $q->where('slug', $slug);
            })
            ->exists();
    }
}
