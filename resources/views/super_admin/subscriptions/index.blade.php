@extends('layouts.app')

@section('title', 'إدارة الاشتراكات')

@push('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 0 0 15px 15px;
    }
    
    .table-container {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    
    .table thead th {
        background: #f8f9fa;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
        color: #495057;
        padding: 1rem 0.75rem;
    }
    
    .table tbody tr {
        transition: background-color 0.2s ease;
    }
    
    .table tbody tr:hover {
        background-color: #f8f9ff;
    }
    
    .table tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
    }
    
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    
    .receipt-image {
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s ease;
    }
    
    .receipt-image:hover {
        transform: scale(1.05);
    }
    
    .btn-modern {
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .action-form {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .form-select {
        min-width: 120px;
    }
    
    .alert {
        border: none;
        border-radius: 10px;
        padding: 1rem 1.25rem;
    }
    
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border-left: 4px solid #28a745;
    }
</style>
@endpush

@section('main-content')
<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <h1 class="mb-0">
            <i class="fas fa-users-cog me-3"></i>
            إدارة طلبات الاشتراك
        </h1>
    </div>
</div>

<div class="container">
    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Table Container -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="6%">
                            <i class="fas fa-hashtag me-1"></i>
                            #
                        </th>
                       <th width="18%">
                         <i class="fas fa-envelope me-1"></i>
                            رقم الهاتف
                       </th>
                        <th width="16%">
                            <i class="fas fa-phone me-1"></i>
                            الايميل 
                        </th>
                        <th width="14%">
                            <i class="fas fa-box me-1"></i>
                            الباقة
                        </th>
                        <th width="14%">
                            <i class="fas fa-credit-card me-1"></i>
                            وسيلة الدفع
                        </th>
                        <th width="10%" class="text-center">
                            <i class="fas fa-image me-1"></i>
                            صورة التحويل
                        </th>
                        <th width="10%" class="text-center">
                            <i class="fas fa-flag me-1"></i>
                            الحالة
                        </th>
                        <th width="12%">
                            <i class="fas fa-cogs me-1"></i>
                            إجراء
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscriptions as $sub)
                        <tr>
                            <td>
                                <span class="badge bg-light text-dark fw-bold">#{{ $sub->id }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-mobile-alt text-primary me-2"></i>
                                    <strong>{{ $sub->phone }}</strong>
                                </div>
                            </td>
                            <td>
                <i class="fas fa-envelope text-secondary me-2"></i>
                {{ $sub->user->email ?? '---' }}
            </td>
                            <td>{{ $sub->package->name ?? '---' }}</td>
                            <td>{{ $sub->paymentMethod->name ?? '---' }}</td>
                            <td class="text-center">
                                @if($sub->receipt_image)
                                    <a href="{{ asset('storage/app/public/' . $sub->receipt_image) }}" target="_blank">
                                        <img src="{{ asset('storage/app/public/' . $sub->receipt_image) }}" 
                                             width="60" height="60" 
                                             class="receipt-image"
                                             style="object-fit: cover;"
                                             alt="صورة التحويل">
                                    </a>
                                @else
                                    <span class="text-muted">
                                        <i class="fas fa-image-slash"></i>
                                        <br><small>لا يوجد</small>
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge status-badge bg-{{ $sub->status == 'approved' ? 'success' : ($sub->status == 'rejected' ? 'danger' : 'warning') }}">
                                    <i class="fas fa-{{ $sub->status == 'approved' ? 'check' : ($sub->status == 'rejected' ? 'times' : 'clock') }} me-1"></i>
                                    @if($sub->status == 'approved')
                                        مقبول
                                    @elseif($sub->status == 'rejected')
                                        مرفوض
                                    @else
                                        قيد الانتظار
                                    @endif
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    {{-- تحديث الحالة --}}
                                    <form action="{{ route('subscriptions.updateStatus', $sub->id) }}" method="POST" class="action-form">
                                        @csrf
                                        <select name="status" class="form-select form-select-sm">
                                            <option value="pending" {{ $sub->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                            <option value="approved" {{ $sub->status == 'approved' ? 'selected' : '' }}>مقبول</option>
                                            <option value="rejected" {{ $sub->status == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm btn-modern">
                                            <i class="fas fa-save me-1"></i>
                                            تحديث
                                        </button>
                                    </form>

                                    {{-- زر الحذف --}}
                                    <form action="{{ route('subscriptions.destroy', $sub->id) }}" method="POST" 
                                          onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟')"
                                          class="ms-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-modern">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // تحسين تجربة المستخدم عند الإرسال
    document.querySelectorAll('form').forEach(function(form) {
        form.addEventListener('submit', function() {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn && !submitBtn.disabled) {
                submitBtn.disabled = true;
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                
                // إعادة تفعيل الزر بعد 3 ثوانٍ في حالة عدم تحديث الصفحة
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }, 3000);
            }
        });
    });
</script>
@endpush
@endsection