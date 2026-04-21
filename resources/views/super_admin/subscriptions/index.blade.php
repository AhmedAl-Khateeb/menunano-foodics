@extends('layouts.app')

@section('title', 'إدارة الاشتراكات')

@push('styles')
    <style>
        .subscriptions-page {
            direction: rtl;
        }

        .subscriptions-header {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: #fff;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 20px;
            box-shadow: 0 8px 25px rgba(78, 115, 223, 0.18);
        }

        .subscriptions-header h1 {
            margin: 0;
            font-size: 30px;
            font-weight: 700;
        }

        .subscriptions-header p {
            margin: 8px 0 0;
            opacity: .9;
            font-size: 14px;
        }

        .stats-card {
            border: 0;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            transition: .2s ease-in-out;
            height: 100%;
        }

        .stats-card:hover {
            transform: translateY(-3px);
        }

        .stats-card .card-body {
            padding: 18px;
        }

        .stats-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #fff;
        }

        .stats-label {
            color: #6c757d;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .stats-value {
            font-size: 28px;
            font-weight: 700;
            line-height: 1;
            color: #212529;
        }

        .subscriptions-table-card {
            border: 0;
            border-radius: 16px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .subscriptions-table-card .card-header {
            background: #fff;
            border-bottom: 1px solid #eef1f4;
            padding: 18px 20px;
        }

        .subscriptions-table-card .card-title {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            color: #212529;
        }

        .subscriptions-table {
            margin-bottom: 0;
        }

        .subscriptions-table thead th {
            background: #f8f9fc;
            color: #495057;
            font-weight: 700;
            border-bottom: 1px solid #e9ecef;
            white-space: nowrap;
            vertical-align: middle;
            padding: 14px 12px;
            font-size: 14px;
        }

        .subscriptions-table tbody td {
            vertical-align: middle;
            padding: 14px 12px;
            border-top: 1px solid #f1f3f5;
        }

        .subscriptions-table tbody tr:hover {
            background: #fafbff;
        }

        .sub-id {
            display: inline-block;
            min-width: 44px;
            text-align: center;
            background: #eef2ff;
            color: #3f51b5;
            border-radius: 999px;
            padding: 5px 10px;
            font-weight: 700;
            font-size: 12px;
        }

        .user-meta {
            line-height: 1.6;
        }

        .user-meta .main {
            font-weight: 700;
            color: #212529;
        }

        .user-meta .sub {
            color: #6c757d;
            font-size: 12px;
        }

        .package-box {
            background: #f8f9fc;
            border-radius: 10px;
            padding: 8px 12px;
            display: inline-block;
            min-width: 120px;
        }

        .package-box .name {
            font-weight: 700;
            color: #212529;
            font-size: 13px;
        }

        .package-box .type {
            color: #6c757d;
            font-size: 12px;
        }

        .receipt-thumb {
            width: 62px;
            height: 62px;
            border-radius: 12px;
            object-fit: cover;
            border: 1px solid #e9ecef;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            transition: .2s ease-in-out;
        }

        .receipt-thumb:hover {
            transform: scale(1.06);
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-pill.pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-pill.active {
            background: #d4edda;
            color: #155724;
        }

        .status-pill.rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .action-stack {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .action-stack form {
            margin: 0;
        }

        .action-stack .input-group,
        .action-stack .d-flex {
            gap: 8px;
        }

        .action-stack .form-control,
        .action-stack .custom-select {
            height: 36px;
            border-radius: 8px;
        }

        .action-btn {
            border-radius: 8px;
            font-weight: 600;
            white-space: nowrap;
        }

        .page-back {
            margin-top: 18px;
        }

        .page-back .btn {
            border-radius: 10px;
            font-weight: 700;
        }

        .empty-box {
            padding: 50px 20px;
            text-align: center;
            color: #6c757d;
        }

        .empty-box i {
            font-size: 48px;
            margin-bottom: 14px;
            color: #ced4da;
        }

        @media (max-width: 991.98px) {
            .action-stack {
                min-width: 150px;
            }

            .subscriptions-header {
                padding: 18px;
            }

            .subscriptions-header h1 {
                font-size: 24px;
            }
        }
    </style>
@endpush

@section('main-content')
    @php
        $totalSubscriptions = $subscriptions->count();
        $pendingSubscriptions = $subscriptions->where('status', 'pending')->count();
        $activeSubscriptions = $subscriptions->where('status', 'active')->count();
        $rejectedSubscriptions = $subscriptions->where('status', 'rejected')->count();
    @endphp

    <section class="content subscriptions-page">
        <div class="container-fluid">

            <div class="subscriptions-header">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h1>
                            <i class="fas fa-users-cog ml-2"></i>
                            إدارة طلبات الاشتراك
                        </h1>
                        <p>متابعة الطلبات واعتمادها أو رفضها بشكل منظم وواضح</p>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stats-card">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <div class="stats-label">إجمالي الطلبات</div>
                                <div class="stats-value">{{ $totalSubscriptions }}</div>
                            </div>
                            <div class="stats-icon" style="background:#4e73df;">
                                <i class="fas fa-layer-group"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stats-card">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <div class="stats-label">قيد الانتظار</div>
                                <div class="stats-value">{{ $pendingSubscriptions }}</div>
                            </div>
                            <div class="stats-icon" style="background:#f6c23e;">
                                <i class="fas fa-clock"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stats-card">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <div class="stats-label">المقبولة</div>
                                <div class="stats-value">{{ $activeSubscriptions }}</div>
                            </div>
                            <div class="stats-icon" style="background:#1cc88a;">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card stats-card">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <div class="stats-label">المرفوضة</div>
                                <div class="stats-value">{{ $rejectedSubscriptions }}</div>
                            </div>
                            <div class="stats-icon" style="background:#e74a3b;">
                                <i class="fas fa-times"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card subscriptions-table-card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    <h3 class="card-title">
                        <i class="fas fa-list-ul ml-1"></i>
                        قائمة الطلبات
                    </h3>
                </div>

                <div class="card-body p-0">
                    @if ($subscriptions->count())
                        <div class="table-responsive">
                            <table class="table subscriptions-table text-center">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>المستخدم</th>
                                        <th>رقم الهاتف</th>
                                        <th>الباقة</th>
                                        <th>وسيلة الدفع</th>
                                        <th>صورة الإيصال</th>
                                        <th>الحالة</th>
                                        <th>الإجراء</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subscriptions as $sub)
                                        <tr>
                                            <td>
                                                <span class="sub-id">#{{ $sub->id }}</span>
                                            </td>

                                            <td>
                                                <div class="user-meta text-right">
                                                    <div class="main">{{ $sub->user->name ?? '---' }}</div>
                                                    <div class="sub">{{ $sub->user->email ?? 'لا يوجد بريد' }}</div>
                                                </div>
                                            </td>

                                            <td>
                                                <strong>{{ $sub->phone ?? '---' }}</strong>
                                            </td>

                                            <td>
                                                <div class="package-box text-right">
                                                    <div class="name">{{ $sub->package->name ?? '---' }}</div>
                                                    <div class="type">
                                                        {{ $sub->package->businessType->name ?? 'غير محدد' }}</div>
                                                </div>
                                            </td>

                                            <td>
                                                {{ $sub->paymentMethod->name ?? '---' }}
                                            </td>

                                            <td>
                                                @if ($sub->receipt_image)
                                                    <a href="{{ asset('storage/' . $sub->receipt_image) }}"
                                                        target="_blank">
                                                        <img src="{{ asset('storage/' . $sub->receipt_image) }}"
                                                            class="receipt-thumb" alt="صورة الإيصال">
                                                    </a>
                                                @else
                                                    <span class="text-muted">لا يوجد</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($sub->status === 'active')
                                                    <span class="status-pill active">
                                                        <i class="fas fa-check-circle"></i>
                                                        مقبول
                                                    </span>
                                                @elseif($sub->status === 'rejected')
                                                    <span class="status-pill rejected">
                                                        <i class="fas fa-times-circle"></i>
                                                        مرفوض
                                                    </span>
                                                @else
                                                    <span class="status-pill pending">
                                                        <i class="fas fa-clock"></i>
                                                        قيد الانتظار
                                                    </span>
                                                @endif
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center justify-content-center flex-wrap"
                                                    style="gap: 8px;">
                                                    <form action="{{ route('subscriptions.updateStatus', $sub->id) }}"
                                                        method="POST" class="mb-0">
                                                        @csrf
                                                        <div class="d-flex align-items-center" style="gap: 8px;">
                                                            <select name="status" class="form-control form-control-sm"
                                                                style="min-width: 130px;">
                                                                <option value="pending"
                                                                    {{ $sub->status == 'pending' ? 'selected' : '' }}>قيد
                                                                    الانتظار</option>
                                                                <option value="active"
                                                                    {{ $sub->status == 'active' ? 'selected' : '' }}>مفعل
                                                                </option>
                                                                <option value="rejected"
                                                                    {{ $sub->status == 'rejected' ? 'selected' : '' }}>
                                                                    مرفوض</option>
                                                                <option value="cancelled"
                                                                    {{ $sub->status == 'cancelled' ? 'selected' : '' }}>
                                                                    ملغي</option>
                                                                <option value="expired"
                                                                    {{ $sub->status == 'expired' ? 'selected' : '' }}>منتهي
                                                                </option>
                                                            </select>

                                                            <button type="submit"
                                                                class="btn btn-primary btn-sm action-btn">
                                                                <i class="fas fa-save ml-1"></i>
                                                                تحديث
                                                            </button>
                                                        </div>
                                                    </form>

                                                    <form action="{{ route('subscriptions.destroy', $sub->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟')"
                                                        class="mb-0">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-danger btn-sm action-btn">
                                                            <i class="fas fa-trash ml-1"></i>
                                                            حذف الطلب
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-box text-center">
                            <div class="w-100 d-flex justify-content-center mb-3">
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <h5 class="text-center">لا توجد طلبات اشتراك حاليًا</h5>
                            <p class="text-center mb-0">عند وصول طلبات جديدة ستظهر هنا</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="page-back text-right">
                <a href="{{ route('dashboard') }}" class="btn btn-success"
                    onmouseover="this.style.backgroundColor='#007bff'; this.style.borderColor='#007bff';"
                    onmouseout="this.style.backgroundColor=''; this.style.borderColor='';">
                    الرئيسية
                </a>
            </div>

        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'تم بنجاح',
                text: @json(session('success')),
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                text: @json(session('error')),
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

@endsection
