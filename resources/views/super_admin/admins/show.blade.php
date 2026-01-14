@extends('layouts.app')

@section('main-content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- Card Container --}}
            <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
                {{-- Card Header --}}
                <div class="card-header bg-gradient-primary text-white py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-user-cog me-2"></i>
                            تفاصيل المدير
                        </h4>
                        <a href="{{ route('admins.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>
                            رجوع
                        </a>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="card-body p-4">
                    {{-- الصورة --}}
                    <div class="text-center mb-4">
                        <div class="avatar-wrapper position-relative d-inline-block">
                            @if($admin->image )
                                <img src="{{ asset('storage/app/public/' . $admin->image) }}"
                                     alt="صورة المدير"
                                     class="rounded-circle shadow-sm border border-4 border-white"
                                     width="140" height="140"
                                     style="object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center shadow-sm border border-4 border-white"
                                     style="width: 140px; height: 140px;">
                                    <i class="fas fa-user text-white fa-3x"></i>
                                </div>
                            @endif
                        </div>
                        {{-- حالة المدير تحت الصورة --}}
                        <div class="mt-2">
                            <span class="badge bg-{{ $admin->status == 1 ? 'success' : 'danger' }} rounded-pill px-3 py-2">
                                <i class="fas {{ $admin->status == 1 ? 'fa-check-circle' : 'fa-ban' }} me-1"></i>
                                {{ $admin->status == 1 ? 'نشط' : 'محظور' }}
                            </span>
                        </div>
                    </div>

                    {{-- معلومات المدير --}}
                    <div class="row">
                        {{-- العمود الأول --}}
                        <div class="col-md-6">
                            <div class="info-card mb-3 p-3 bg-light rounded-3">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="icon-wrapper bg-primary rounded-circle p-2 me-3">
                                        <i class="fas fa-envelope text-white"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block">البريد الإلكتروني</small>
                                        <strong class="text-dark">{{ $admin->email }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="info-card mb-3 p-3 bg-light rounded-3">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="icon-wrapper bg-success rounded-circle p-2 me-3">
                                        <i class="fas fa-phone text-white"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block">رقم الهاتف</small>
                                        <strong class="text-dark">{{ $admin->phone ?? 'غير محدد' }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="info-card mb-3 p-3 bg-light rounded-3">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="icon-wrapper bg-info rounded-circle p-2 me-3">
                                        <i class="fas fa-calendar text-white"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block">تاريخ الإنشاء</small>
                                        <strong class="text-dark">{{ $admin->created_at->format('Y-m-d') }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- العمود الثاني --}}
                        <div class="col-md-6">
                            {{-- اسم المتجر مع الرابط --}}
                            <div class="info-card mb-3 p-3 bg-light rounded-3">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="icon-wrapper bg-warning rounded-circle p-2 me-3">
                                        <i class="fas fa-store text-white"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block">اسم المتجر</small>
                                        <strong class="text-dark">{{ $admin->store_name ?? 'غير محدد' }}</strong>

                                        {{-- رابط المتجر --}}
                                        @if($admin->store_name)
                                        @php
                                            $baseUrl = config('app.qr_base_url');
                                            $storeUrl = $baseUrl . '/' . $admin->store_name;
                                        @endphp
                                        <div class="mt-2 d-flex align-items-center">
                                            <a href="{{ $storeUrl }}"
                                               target="_blank"
                                               class="text-decoration-none text-primary me-2">
                                                <i class="fas fa-external-link-alt me-1"></i>
                                                زيارة المتجر
                                            </a>
                                            <button class="btn btn-sm btn-outline-secondary copy-link"
                                                    data-url="{{ $storeUrl }}"
                                                    title="نسخ الرابط">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="info-card mb-3 p-3 bg-light rounded-3">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="icon-wrapper bg-secondary rounded-circle p-2 me-3">
                                        <i class="fas fa-gift text-white"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block">الباقة</small>
                                        <strong class="text-dark">{{ optional($admin->package)->name ?? 'بدون' }}</strong>
                                    </div>
                                </div>
                            </div>

                            <div class="info-card mb-3 p-3 bg-light rounded-3">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="icon-wrapper {{ $admin->status == 1 ? 'bg-success' : 'bg-danger' }} rounded-circle p-2 me-3">
                                        <i class="fas fa-circle text-white"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block">الحالة</small>
                                        <span class="badge bg-{{ $admin->status == 1 ? 'success' : 'danger' }} rounded-pill px-3 py-2">
                                            {{ $admin->status == 1 ? 'نشط' : 'محظور' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- معلومات الاشتراك --}}
                    @if($admin->subscription_start || $admin->subscription_end)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3 text-muted">
                                <i class="fas fa-calendar-check me-2"></i>
                                معلومات الاشتراك
                            </h5>
                        </div>

                        {{-- بدء الاشتراك --}}
                        @if($admin->subscription_start)
                        <div class="col-md-6">
                            <div class="info-card mb-3 p-3 bg-light rounded-3">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="icon-wrapper bg-purple rounded-circle p-2 me-3">
                                        <i class="fas fa-play text-white"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block">بدء الاشتراك</small>
                                        <strong class="text-dark">
                                            {{ \Carbon\Carbon::parse($admin->subscription_start)->format('Y-m-d') }}
                                        </strong>
                                        <small class="text-muted d-block mt-1">
                                            {{ \Carbon\Carbon::parse($admin->subscription_start)->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- نهاية الاشتراك --}}
                        @if($admin->subscription_end)
                        <div class="col-md-6">
                            <div class="info-card mb-3 p-3 bg-light rounded-3">
                                <div class="d-flex align-items-center mb-2">
                                    @php
                                        $subscriptionEnd = \Carbon\Carbon::parse($admin->subscription_end);
                                        $isExpired = $subscriptionEnd->isPast();
                                        $iconColor = $isExpired ? 'bg-danger' : 'bg-purple';
                                        $icon = $isExpired ? 'fa-stop' : 'fa-calendar-times';
                                    @endphp
                                    <div class="icon-wrapper {{ $iconColor }} rounded-circle p-2 me-3">
                                        <i class="fas {{ $icon }} text-white"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <small class="text-muted d-block">نهاية الاشتراك</small>
                                        <strong class="text-dark">
                                            {{ $subscriptionEnd->format('Y-m-d') }}
                                        </strong>
                                        <small class="text-{{ $isExpired ? 'danger' : 'muted' }} d-block mt-1">
                                            @if($isExpired)
                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                منتهي الصلاحية منذ {{ $subscriptionEnd->diffForHumans() }}
                                            @else
                                                {{ $subscriptionEnd->diffForHumans() }}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- حالة الاشتراك --}}
                        @if($admin->subscription_start && $admin->subscription_end)
                        <div class="col-12">
                            <div class="alert alert-{{ \Carbon\Carbon::parse($admin->subscription_end)->isPast() ? 'danger' : 'success' }} rounded-3 d-flex align-items-center">
                                @php
                                    $subscriptionEnd = \Carbon\Carbon::parse($admin->subscription_end);
                                    $isExpired = $subscriptionEnd->isPast();
                                @endphp
                                <i class="fas {{ $isExpired ? 'fa-times-circle' : 'fa-check-circle' }} me-2"></i>
                                <div>
                                    <strong>
                                        {{ $isExpired ? 'الاشتراك منتهي الصلاحية' : 'الاشتراك نشط' }}
                                    </strong>
                                    @if(!$isExpired)
                                        <small class="d-block">
                                            ينتهي في {{ $subscriptionEnd->diffForHumans() }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif

                    {{-- أزرار الإجراءات --}}
                    <div class="d-flex gap-2 justify-content-center mt-4 pt-3 border-top">
                        <a href="{{ route('admins.edit', $admin->id) }}"
                           class="btn btn-primary px-4">
                            <i class="fas fa-edit me-2"></i>
                            تعديل
                        </a>

                        <a href="{{ route('admins.index') }}"
                           class="btn btn-outline-secondary px-4">
                            <i class="fas fa-list me-2"></i>
                            القائمة
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Custom Styles --}}
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-purple {
    background-color: #6f42c1 !important;
}

.avatar-wrapper {
    position: relative;
}

.icon-wrapper {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.info-card {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.info-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.1);
}

.rounded-3 {
    border-radius: 1rem !important;
}

.card {
    border: none;
    border-radius: 1.5rem;
}

.btn {
    border-radius: 0.75rem;
    font-weight: 500;
}

.badge {
    font-size: 0.85em;
}

.copy-link {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

.alert {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

@media (max-width: 768px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .col-md-6 {
        margin-bottom: 1rem;
    }

    .d-flex.gap-2 {
        flex-direction: column;
    }

    .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}
</style>

{{-- JavaScript for Copy Link --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // نسخ الرابط
    const copyButtons = document.querySelectorAll('.copy-link');

    copyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const url = this.getAttribute('data-url');

            // نسخ إلى الحافظة
            navigator.clipboard.writeText(url).then(() => {
                // تغيير الأيقونة مؤقتاً
                const originalIcon = this.innerHTML;
                this.innerHTML = '<i class="fas fa-check"></i>';
                this.classList.add('btn-success');
                this.classList.remove('btn-outline-secondary');

                // إعادة الأيقونة الأصلية بعد ثانيتين
                setTimeout(() => {
                    this.innerHTML = originalIcon;
                    this.classList.remove('btn-success');
                    this.classList.add('btn-outline-secondary');
                }, 2000);

            }).catch(err => {
                console.error('Failed to copy: ', err);
                alert('فشل في نسخ الرابط');
            });
        });
    });

    // التأكد من أن الصور موجودة
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        img.addEventListener('error', function() {
            this.style.display = 'none';
            const defaultAvatar = this.nextElementSibling;
            if (defaultAvatar && defaultAvatar.classList.contains('rounded-circle')) {
                defaultAvatar.style.display = 'flex';
            }
        });
    });
});
</script>
@endsection