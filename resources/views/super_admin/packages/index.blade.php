@extends('layouts.app')

@section('main-content')
    <div class="container-fluid px-4 py-3">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div
                    class="d-flex justify-content-between align-items-center bg-gradient-primary rounded-3 p-4 text-white shadow-sm">
                    <div>
                        <h2 class="mb-1 fw-bold">
                            <i class="fas fa-box-open me-2"></i>
                            إدارة الباقات
                        </h2>
                        <p class="mb-0 opacity-75">إدارة وتنظيم جميع باقات الخدمة</p>
                    </div>
                    <a href="{{ route('packages.create') }}" class="btn btn-light btn-lg shadow-sm hover-lift">
                        <i class="fas fa-plus me-2"></i>
                        إضافة باقة جديدة
                    </a>
                </div>
            </div>
        </div>

        <!-- Success Alert -->
        @if (session('success'))
            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Packages Cards Grid -->
        <div class="row gx-4 gy-5">
            @forelse($packages as $package)
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card h-100 border-0 shadow-sm hover-lift package-card">
                        <!-- Card Header -->
                        <div class="card-header bg-transparent border-0 pt-4 pb-0">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1 text-end">
                                    <h5 class="card-title text-dark fw-bold mb-3">
                                        {{ $package->name }}
                                    </h5>
                                </div>
                                <div class="ms-3">
                                    <span
                                        class="badge {{ $package->is_active ? 'bg-success' : 'bg-secondary' }} rounded-pill px-3 py-2">
                                        <i
                                            class="fas {{ $package->is_active ? 'fa-check-circle' : 'fa-pause-circle' }} me-2"></i>
                                        {{ $package->is_active ? 'مفعل' : 'معطل' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body pt-0">
                            <p class="text-muted mb-4 package-description text-end">
                                {{ $package->description ?? 'لا يوجد وصف متاح' }}
                            </p>

                            <!-- Package Details -->
                            <!-- Package Details -->
                            <div class="package-details mb-4">

                                <div class="detail-item detail-item-price mb-3 p-3 bg-light rounded-3">
                                    <div class="text-center">
                                        <small class="detail-title detail-title-price d-block mb-2 fw-bold"
                                            style="font-size: 35px;">السعر</small>
                                        <div class="detail-icon mb-2">
                                            <i class="fas fa-tag text-success fs-5"></i>
                                        </div>
                                        <span class="fw-bold text-dark fs-5">
                                            {{ number_format($package->price, 0) }} ج.م
                                        </span>
                                    </div>
                                </div>

                                <div class="detail-item detail-item-duration mb-3 p-3 bg-light rounded-3">
                                    <div class="text-center">
                                        <small class="detail-title detail-title-duration d-block mb-2 fw-bold"
                                            style="font-size: 35px;">المدة</small>
                                        <div class="detail-icon mb-2">
                                            <i class="fas fa-clock text-primary fs-5"></i>
                                        </div>
                                        <span class="fw-bold text-dark">
                                            {{ $package->duration }} يوم
                                        </span>
                                    </div>
                                </div>

                                <div class="detail-item detail-item-service mb-3 p-3 bg-light rounded-3">
                                    <div class="text-center">
                                        <small class="detail-title detail-title-service d-block mb-2 fw-bold"
                                            style="font-size: 35px;">نوع الخدمة</small>
                                        <div class="detail-icon mb-2">
                                            <i class="fas fa-users text-danger fs-5"></i>
                                        </div>
                                        <span class="fw-bold text-dark">
                                            {{ $package->businessType->name ?? 'غير محدد' }}
                                        </span>
                                    </div>
                                </div>

                                @if ($package->features->count() > 0)
                                    <div class="detail-item detail-item-features p-3 bg-light rounded-3">
                                        <div class="text-center mb-3">
                                            <small class="detail-title detail-title-features d-block mb-2 fw-bold"
                                                style="font-size: 35px;">المميزات</small>
                                            <i class="fas fa-star text-warning fs-5"></i>
                                        </div>

                                        <ul class="list-unstyled mb-0 features-list text-end">
                                            @foreach ($package->features as $feature)
                                                <li class="d-flex align-items-start justify-content-end mb-2">
                                                    <span class="text-dark me-2">{{ $feature->text }}</span>
                                                    <i class="fas fa-check-circle text-success mt-1"
                                                        style="font-size: 0.8rem;"></i>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                            </div>

                        </div>

                        <!-- Card Footer -->
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <div class="d-flex gap-2">
                                <a href="{{ route('packages.edit', $package->id) }}"
                                    class="btn btn-outline-warning flex-fill btn-sm hover-lift">
                                    <i class="fas fa-edit me-1"></i>
                                    تعديل
                                </a>

                                <button type="button" class="btn btn-outline-danger flex-fill btn-sm hover-lift"
                                    onclick="confirmDelete('{{ $package->id }}', '{{ $package->name }}')">
                                    <i class="fas fa-trash me-1"></i>
                                    حذف
                                </button>

                                <!-- Hidden Delete Form -->
                                <form id="delete-form-{{ $package->id }}"
                                    action="{{ route('packages.destroy', $package->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="col-12">
                    <div class="text-center py-5">
                        <div class="empty-state-icon mb-4">
                            <i class="fas fa-box-open text-muted" style="font-size: 4rem;"></i>
                        </div>
                        <h4 class="text-muted mb-3">لا توجد باقات متاحة</h4>
                        <p class="text-muted mb-4">ابدأ بإضافة باقة جديدة لعرضها هنا</p>
                        <a href="{{ route('packages.create') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus me-2"></i>
                            إضافة أول باقة
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Statistics Cards (Optional) -->
        @if ($packages->count() > 0)
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title text-muted mb-3">
                                <i class="fas fa-chart-bar me-2"></i>
                                إحصائيات سريعة
                            </h6>
                            <div class="row text-center">
                                <div class="col-md-4">
                                    <div class="stat-item">
                                        <h4 class="text-primary mb-1">{{ $packages->count() }}</h4>
                                        <small class="text-muted">إجمالي الباقات</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-item">
                                        <h4 class="text-success mb-1">{{ $packages->where('is_active', true)->count() }}
                                        </h4>
                                        <small class="text-muted">باقات مفعلة</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-item">
                                        <h4 class="text-secondary mb-1">
                                            {{ $packages->where('is_active', false)->count() }}</h4>
                                        <small class="text-muted">باقات معطلة</small>
                                    </div>
                                </div>
                                {{-- هنا كان فيه إجمالي المميزات واتشال --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>

    <!-- Custom Styles -->
    <style>
        .row.gx-4.gy-5>div {
            position: relative;
        }

        .package-card {
            transition: all 0.3s ease;
            border-radius: 15px !important;
            border: 5px solid #e9ecef !important;
        }

        .features-list li {
            line-height: 1.7;
            border-bottom: 1px dashed #e9ecef;
            padding-bottom: 6px;
        }

        .features-list li:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .package-card {
            transition: all 0.3s ease;
            border-radius: 15px !important;
        }

        .package-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.1) !important;
        }

        .package-description {
            line-height: 1.6;
            min-height: 48px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .icon-wrapper {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .detail-icon {
            min-width: 24px;
            text-align: center;
        }

        .detail-item {
            border-radius: 12px;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .detail-item:hover {
            background-color: #f8f9fa !important;
            border-color: #dee2e6;
            transform: translateY(-1px);
        }

        .features-list li {
            padding: 0.25rem 0;
            transition: all 0.2s ease;
        }

        .features-list li:hover {
            transform: translateX(5px);
        }

        .stat-item {
            padding: 1rem 0;
        }

        .empty-state-icon {
            opacity: 0.5;
        }

        .card {
            border-radius: 15px;
        }

        .btn {
            border-radius: 8px;
            font-weight: 500;
        }

        .alert {
            border-radius: 12px;
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .d-flex.justify-content-between {
                flex-direction: column;
                gap: 1rem;
            }

            .btn-lg {
                width: 100%;
            }

            .features-list li {
                font-size: 0.9rem;
            }
        }
    </style>

    <!-- JavaScript for Delete Confirmation -->
    <script>
        function confirmDelete(packageId, packageName) {
            if (confirm(`هل أنت متأكد من حذف الباقة "${packageName}"؟`)) {
                document.getElementById('delete-form-' + packageId).submit();
            }
        }

        // Add loading states
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function() {
                if (!this.classList.contains('btn-outline-danger')) {
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري التحميل...';
                    this.disabled = true;

                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.disabled = false;
                    }, 2000);
                }
            });
        });

        // Animate cards on page load
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.package-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
@endsection
