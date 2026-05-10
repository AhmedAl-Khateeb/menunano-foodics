@extends('layouts.app')

@section('main-content')
    <div class="container my-5 px-2 px-md-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">الطلبات المرتجعة</h3>
                <p class="text-muted mb-0">عرض الطلبات التي تم تحويلها إلى مرتجع</p>
            </div>

            <a href="{{ route('orders.index') }}" class="btn btn-dark">
                العودة لكل الطلبات
            </a>
        </div>

        {{-- ====== FILTERS ====== --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form method="GET" class="form-row align-items-center">

                    <div class="col-lg-3 col-md-6 mb-2">
                        <input type="text" name="search" class="form-control"
                            placeholder="بحث بالاسم / الهاتف / رقم الطلب" value="{{ request('search') }}">
                    </div>

                    <div class="col-lg-4 col-md-6 mb-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">من</span>
                            </div>

                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">

                            <div class="input-group-prepend">
                                <span class="input-group-text">إلى</span>
                            </div>

                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>
                    </div>

                    <div class="col-lg-1 col-md-4 mb-2">
                        <select name="source" class="form-control">
                            <option value="">المصادر</option>
                            <option value="online" {{ request('source') == 'online' ? 'selected' : '' }}>Online</option>
                            <option value="cachire" {{ request('source') == 'cachire' ? 'selected' : '' }}>Cachire</option>
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-4 mb-2">
                        <select name="payment_method" class="form-control">
                            <option value="">كل وسائل الدفع</option>
                            <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                        </select>
                    </div>

                    <div class="col-lg-1 col-md-4 mb-2">
                        <div class="d-flex">
                            <button class="btn btn-primary flex-fill mr-1">
                                بحث
                            </button>

                            <a href="{{ route('orders.returned') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>

                </form>
            </div>
        </div>

        {{-- ====== TABLE ====== --}}
        <div class="card shadow-sm border-0">
            <div class="card-header  text-dark font-weight-bold text-center">
                قائمة المرتجعات
            </div>

            <div class="table-responsive">
                <table class="table table-hover text-center align-middle mb-0">

                    <thead class="bg-light">
                        <tr>
                            <th>NU</th>
                            <th>اسم الكاشير</th>
                            {{-- <th>الهاتف</th> --}}
                            <th>النوع</th>
                            <th>المصدر</th>
                            <th>الدفع</th>
                            <th>السعر</th>
                            <th>الحالة</th>
                            <th>تاريخ الطلب</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $order->cashier->name ?? '-' }}</td>

                                {{-- <td>{{ $order->phone ?? '-' }}</td> --}}

                                <td>
                                    @if ($order->type == 'delivery')
                                        <span class="badge badge-info">توصيل</span>
                                    @elseif($order->type == 'takeaway')
                                        <span class="badge badge-warning">استلام</span>
                                    @elseif($order->type == 'table')
                                        <span class="badge badge-success">طاولة</span>
                                    @else
                                        <span class="badge badge-success">محلي</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="dropdown">
                                        <button
                                            class="btn btn-sm dropdown-toggle
                                            {{ $order->source == 'online' ? 'btn-primary' : 'btn-dark' }}"
                                            type="button" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">

                                            @if ($order->source == 'online')
                                                Online
                                            @elseif ($order->source == 'cachire')
                                                Cachire
                                            @else
                                                {{ $order->source ?? '-' }}
                                            @endif
                                        </button>

                                        <div class="dropdown-menu text-center">

                                            <form action="{{ route('orders.updateSource', $order->id) }}" method="POST"
                                                class="swal-confirm-form" data-title="تغيير المصدر"
                                                data-text="هل تريد تغيير مصدر الطلب إلى Online؟" data-icon="question"
                                                data-confirm-button="نعم، تغيير" data-cancel-button="إلغاء"
                                                data-confirm-color="#007bff" data-cancel-color="#6c757d">
                                                @csrf
                                                @method('PUT')

                                                <input type="hidden" name="source" value="online">

                                                <button type="submit" class="dropdown-item">
                                                    Online
                                                </button>
                                            </form>

                                            <form action="{{ route('orders.updateSource', $order->id) }}" method="POST"
                                                class="swal-confirm-form" data-title="تغيير المصدر"
                                                data-text="هل تريد تغيير مصدر الطلب إلى Cachire؟" data-icon="question"
                                                data-confirm-button="نعم، تغيير" data-cancel-button="إلغاء"
                                                data-confirm-color="#343a40" data-cancel-color="#6c757d">
                                                @csrf
                                                @method('PUT')

                                                <input type="hidden" name="source" value="cachire">

                                                <button type="submit" class="dropdown-item">
                                                    Cachire
                                                </button>
                                            </form>

                                        </div>
                                    </div>
                                </td>

                                <td>{{ $order->payment_method ?? '-' }}</td>

                                <td>{{ number_format($order->total_price, 2) }}</td>

                                <td>
                                    @if ($order->type == 'delivery')
                                        <span class="badge badge-danger status-check">
                                            مرتجع دليفري
                                        </span>
                                    @else
                                        <span class="badge badge-info status-check">
                                            مرتجع
                                        </span>
                                    @endif
                                </td>

                                <td>{{ $order->created_at ? $order->created_at->format('Y-m-d') : '-' }}</td>

                                <td>
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-info mb-1">
                                        عرض
                                    </a>

                                    <form action="{{ route('orders.restoreReturned', $order->id) }}" method="POST"
                                        style="display:inline;" class="swal-confirm-form" data-title="إلغاء المرتجع"
                                        data-text="هل أنت متأكد من إرجاع هذا الطلب من المرتجع إلى الطلبات مرة أخرى؟"
                                        data-icon="question" data-confirm-button="نعم، إرجاع" data-cancel-button="إلغاء"
                                        data-confirm-color="#28a745" data-cancel-color="#6c757d">
                                        @csrf
                                        @method('PUT')

                                        <button type="submit" class="btn btn-success btn-sm mb-1">
                                            إرجاع للطلبات
                                        </button>
                                    </form>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">
                                    لا توجد طلبات مرتجعة
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <div class="card-footer">
                {{ $orders->withQueryString()->links() }}
            </div>
        </div>

    </div>
@endsection

<style>
    .badge-warning {
        background-color: #ffc107 !important;
        color: #212529 !important;
    }

    .badge-success {
        background-color: #28a745 !important;
        color: white;
    }

    .badge-info {
        background-color: #17a2b8 !important;
        color: white;
    }
</style>
