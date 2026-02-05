@extends('layouts.app')

@section('title', 'إدارة الادمن')

@section('main-content')
    <div class="container-fluid mt-4">
        {{-- Header Section --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="mb-2 mb-md-0">
                        <h2 class="text-primary mb-1">
                            <i class="fas fa-users-cog me-2"></i>
                            قائمة المدراء
                        </h2>
                        <p class="text-muted mb-0">إدارة حسابات المديرين والصلاحيات</p>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('admins.create') }}" class="btn btn-primary btn-lg shadow-sm">
                            <i class="fas fa-plus me-2"></i>
                            إضافة مدير جديد
                        </a>

                        <form action="{{ route('admins.deactivateAll') }}" method="POST" class="d-inline"
                            onsubmit="return confirm('هل أنت متأكد من إيقاف جميع الحسابات؟')">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-lg shadow-sm">
                                <i class="fas fa-ban me-2"></i>
                                إيقاف جميع المديرين
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Alerts Section --}}
        <div class="row">
            <div class="col-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-3 fa-lg text-success"></i>
                            <div>
                                <strong>تم بنجاح!</strong>
                                <div>{{ session('success') }}</div>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle me-3 fa-lg text-danger"></i>
                            <div>
                                <strong>خطأ!</strong>
                                <div>{{ session('error') }}</div>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="row mb-4">
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0">إجمالي المديرين</h6>
                                <h2 class="mb-0">{{ $totalAdmins }}</h2>
                            </div>
                            <i class="fas fa-users fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card bg-success text-white shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0">المديرين المفعلين</h6>
                                <h2 class="mb-0">{{ $activeAdmins }}</h2>
                            </div>
                            <i class="fas fa-user-check fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card bg-warning text-white shadow">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-title mb-0">المديرين المعطلين</h6>
                                <h2 class="mb-0">{{ $inactiveAdmins }}</h2>
                            </div>
                            <i class="fas fa-user-times fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Search Section --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form action="{{ route('admins.index') }}" method="GET">
                            <div class="input-group input-group-lg">
                                <select name="status" class="form-select" style="max-width: 150px;"
                                    onchange="this.form.submit()">
                                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>الكل</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>مفعل
                                    </option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>معطل
                                    </option>
                                </select>
                                <input type="text" name="search" class="form-control"
                                    placeholder="ابحث باستخدام البريد الإلكتروني، رقم الهاتف أو اسم المتجر..."
                                    value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search me-2"></i>بحث
                                </button>
                                @if ((request()->has('search') && !empty(request('search'))) || (request()->has('status') && request('status') != 'all'))
                                    <a href="{{ route('admins.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>إلغاء الفلتر
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Main Table Card --}}
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-table me-2"></i>
                        جدول المديرين
                    </h5>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center py-3">#</th>
                                    <th class="py-3">
                                        <i class="fas fa-store me-2 text-primary"></i>
                                        اسم المتجر
                                    </th>
                                    <th class="py-3">
                                        <i class="fas fa-envelope me-2 text-primary"></i>
                                        البريد الإلكتروني
                                    </th>
                                    <th class="py-3">
                                        <i class="fas fa-phone me-2 text-primary"></i>
                                        الهاتف
                                    </th>
                                    <th class="text-center py-3">
                                        <i class="fas fa-box me-2 text-primary"></i>
                                        الباقة
                                    </th>
                                    <th class="text-center py-3">
                                        <i class="fas fa-hourglass-half me-2 text-primary"></i>
                                        المتبقي
                                    </th>
                                    <th class="text-center py-3">
                                        <i class="fas fa-toggle-on me-2 text-primary"></i>
                                        الحالة
                                    </th>
                                    <th class="text-center py-3">
                                        <i class="fas fa-cogs me-2 text-primary"></i>
                                        العمليات
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($admins as $index => $admin)
                                    <tr class="align-middle">
                                        <td class="text-center fw-bold">
                                            <span
                                                class="badge badge-light">{{ $index + 1 + ($admins->currentPage() - 1) * $admins->perPage() }}</span>
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <strong
                                                        class="text-dark">{{ $admin->store_name ?? 'غير محدد' }}</strong>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <span class="text-muted">{{ $admin->email }}</span>
                                        </td>

                                        <td>
                                            @if ($admin->phone)
                                                <a href="tel:{{ $admin->phone }}" class="text-decoration-none">
                                                    <i class="fas fa-phone-alt me-1"></i>
                                                    {{ $admin->phone }}
                                                </a>
                                            @else
                                                <span class="text-muted">غير محدد</span>
                                            @endif
                                        </td>

                                        {{-- <td class="text-center">
                                            @if ($admin->image)
                                                <img src="{{ asset('storage/'.$admin->image) }}"
                                                     alt="صورة المدير"
                                                     class="rounded-circle shadow-sm"
                                                     width="50" height="50"
                                                     style="object-fit: cover;">
                                            @else
                                                <img src="{{ asset('storage/images/default-user.png') }}"
                                                      alt="صورة افتراضية"
                                                      class="rounded-circle shadow-sm"
                                                      width="50" height="50"
                                                      style="object-fit: cover;">
                                            @endif
                                        </td> --}}
                                        <td class="text-center">
                                            @if ($admin->package)
                                                {{ $admin->package->name }}
                                            @else
                                                <span class="text-muted">لا توجد باقة</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            @if ($admin->subscription_end)
                                                @php
                                                    $endDate = \Carbon\Carbon::parse(
                                                        $admin->subscription_end,
                                                    )->endOfDay();
                                                    $isExpired = now()->gt($endDate);
                                                    $remainingDays = now()->diffInDays($endDate, false);
                                                @endphp

                                                @if (!$isExpired)
                                                    @if ($remainingDays < 1)
                                                        <span class="badge bg-warning text-dark">ينتهي اليوم</span>
                                                    @else
                                                        <span class="badge bg-info text-dark">{{ ceil($remainingDays) }}
                                                            يوم</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-danger">منتهي</span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <form action="{{ route('admins.toggleStatus', $admin->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="form-switch d-flex justify-content-center align-items-center">
                                                    <input type="checkbox" id="switch-{{ $admin->id }}"
                                                        name="status" value="1" onchange="this.form.submit()"
                                                        {{ $admin->status ? 'checked' : '' }}>
                                                    <label class="switch-slider me-2"
                                                        for="switch-{{ $admin->id }}"></label>
                                                    <span class="switch-label small">
                                                        @if ($admin->status)
                                                            <span class="badge bg-success">مفعل</span>
                                                        @else
                                                            <span class="badge bg-danger">معطل</span>
                                                        @endif
                                                    </span>
                                                </div>
                                            </form>
                                        </td>

                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admins.show', $admin->id) }}"
                                                    class="btn btn-outline-info btn-sm" data-bs-toggle="tooltip"
                                                    title="عرض">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admins.edit', $admin->id) }}"
                                                    class="btn btn-outline-warning btn-sm" data-bs-toggle="tooltip"
                                                    title="تعديل">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <form action="{{ route('admins.destroy', $admin->id) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('هل أنت متأكد من حذف هذا المدير؟');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger btn-sm" data-bs-toggle="tooltip"
                                                        title="حذف">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="fas fa-users fa-3x mb-3 opacity-25"></i>
                                                <h5>لا يوجد مديرين حتى الآن</h5>
                                                <p class="mb-0">قم بإضافة أول مدير للبدء</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Pagination --}}
                @if ($admins->hasPages())
                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                عرض {{ $admins->firstItem() ?? 0 }} إلى {{ $admins->lastItem() ?? 0 }} من إجمالي
                                {{ $admins->total() }} نتيجة
                            </div>
                            <div>
                                {{ $admins->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>

    {{-- Custom Styles --}}
    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        }

        .card {
            border-radius: 15px;
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .table th {
            border-top: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .btn-group .btn {
            margin: 0 1px;
        }

        .opacity-25 {
            opacity: 0.25;
        }

        .opacity-75 {
            opacity: 0.75;
        }

        @media (max-width: 768px) {
            .d-flex.gap-2 {
                flex-direction: column;
                width: 100%;
            }

            .d-flex.gap-2 .btn {
                margin-bottom: 0.5rem;
            }

            .btn-group {
                flex-direction: column;
                width: auto;
            }

            .btn-group .btn {
                margin-bottom: 2px;
                border-radius: 0.25rem !important;
            }
        }
    </style>

    {{-- Auto-hide Alerts Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide alerts after 4 seconds
            const alerts = document.querySelectorAll('.alert');

            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';

                    setTimeout(function() {
                        if (alert.parentNode) {
                            alert.remove();
                        }
                    }, 500);
                }, 2000); // 4 seconds
            });

            // Initialize tooltips if Bootstrap 5 is available
            if (typeof bootstrap !== 'undefined') {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            }
        });
    </script>
@endsection
