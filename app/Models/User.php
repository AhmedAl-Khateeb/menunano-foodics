<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, \Spatie\Permission\Traits\HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'created_by',
        'email',
        'phone',
        'store_name',
        'image',
        'status',
        'subscription_start',
        'subscription_end',
        'package_id',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'subscription_start' => 'date',
            'subscription_end' => 'date',
        ];
    }
    protected $dates = ['subscription_start', 'subscription_end'];

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
                \App\Models\Setting::create([
                    'user_id' => $user->id,
                    'key'     => $key,
                    'value'   => null,
                ]);
            }
        });
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'user_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }
    public function sliders()
    {
        return $this->hasMany(Slider::class);
    }
    public function settings()
    {
        return $this->hasMany(Setting::class, 'user_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = str_starts_with($value, '+2')
            ? $value
            : '+20' . ltrim($value, '0+');
    }

    public function setSubscriptionStart($startDate): bool
    {
        // إذا لا يوجد باقة، لا نفعل شيئاً
        if (! $this->package) {
            return false;
        }

        $start = Carbon::parse($startDate)->startOfDay();
        $end = (clone $start)->addDays((int) $this->package->duration);

        $this->subscription_start = $start->toDateString();
        $this->subscription_end   = $end->toDateString();
        $this->status = 1; // فعّل المستخدم عند إضافة بداية
        $this->save();

        return true;
    }

    public function checkSubscription()
    {
        // لو ما فيه تاريخ نهاية ما نعمل شيئًا
        if (! $this->subscription_end) {
            return;
        }

        // لو انتهى التاريخ (اليوم أكبر من تاريخ النهاية) نجعل الحالة 0
        if (now()->startOfDay()->gt(Carbon::parse($this->subscription_end))) {
            if ($this->status != 0) {
                $this->status = 0;
                $this->save();
            }
        }
    }
}
