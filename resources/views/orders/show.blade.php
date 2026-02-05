@extends('layouts.app')

@section('main-content')
    <div class="container my-5">
        <div class="card shadow-lg rounded-lg">
            <div
                class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h3 class="mb-0 font-weight-bold" style="letter-spacing: 1px;">تفاصيل الطلب</h3>
                @if ($order->status != 'served')
                    <x-model name="serve-{{ $order->id }}" status="success" icon="fa fa-check" title="تأكيد التوصيل"
                        message="هل تم توصيل هذا الطلب؟">
                        <form action="{{ route('orders.serve', $order->id) }}" method="POST" class="mb-0">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-light btn-sm px-3 shadow-sm">
                                <i class="fa fa-check text-success"></i> نعم
                            </button>
                        </form>
                    </x-model>
                @endif
                <span class="badge badge-light text-secondary px-3 py-2" style="font-size: 0.9rem; border-radius: 20px;">
                    {{ $order->created_at->diffForHumans() }}
                </span>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <p><strong>الاسم:</strong> <span class="text-primary font-weight-bold">{{ $order->name }}</span>
                        </p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>رقم الهاتف:</strong> {{ $order->phone }}</p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>العنوان:</strong> {{ $order->address ?? '-' }}</p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>طريقة الدفع:</strong> <span
                                class="badge badge-info">{{ $order->payment_method == 'cash' ? 'دفع عند الاستلام' : $order->payment_method }}</span>
                        </p>
                    </div>
                </div>

                @if ($order->payment_proof)
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="mb-3 text-secondary font-weight-bold">إثبات الدفع:</h5>
                            <div class="border rounded p-2 d-inline-block bg-light shadow-sm">
                                <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="إثبات الدفع"
                                        class="img-fluid rounded" style="max-height: 250px; cursor: pointer;">
                                </a>
                                <div class="mt-2 text-center">
                                    <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="fa fa-expand"></i> عرض الحجم الكامل
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <h4 class="mb-3 border-bottom pb-2">تفاصيل الطلب</h4>
                <div class="table-responsive">
                    <table class="table table-hover text-center align-middle mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>المنتج</th>
                                <th>الحجم</th>
                                <th>السعر</th>
                                <th>الكمية</th>
                                <th>الإجمالي</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td class="font-weight-bold text-primary">{{ $item->product->name ?? '-' }}</td>
                                    <td>{{ $item->size ?? '-' }}</td>
                                    <td>{{ number_format($item->pivot->price, 2) }} ر.س</td>
                                    <td>{{ $item->pivot->quantity }}</td>
                                    <td>{{ number_format($item->pivot->price * $item->pivot->quantity, 2) }} ر.س</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end font-weight-bold">السعر الكلي</td>
                                <td class="font-weight-bold">{{ number_format($order->total_price, 2) }} ر.س</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-4 px-4 shadow-sm">
                    <i class="fa fa-arrow-left mr-2"></i> العودة
                </a>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
        }

        .table-hover tbody tr:hover {
            background: #e9f0ff !important;
            transition: background-color 0.3s ease;
        }

        .shadow-sm {
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            color: #fff;
        }

        .font-weight-bold {
            font-weight: 700 !important;
        }

        .card {
            border-radius: 15px;
        }

        .card-header {
            border-radius: 15px 15px 0 0;
        }
    </style>
@endsection
