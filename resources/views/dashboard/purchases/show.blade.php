@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">تفاصيل فاتورة مشتريات</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('purchases.index') }}">المشتريات</a></li>
                        <li class="breadcrumb-item active">فاتورة #{{ $purchase->invoice_number ?? $purchase->id }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 text-right">
                    <div class="invoice p-4 rounded-lg shadow-sm border-0 mb-3 bg-white">
                        
                        <div class="row mb-4 pb-3 border-bottom">
                            <div class="col-12 d-flex justify-content-between align-items-center">
                                <h4>
                                    <i class="fas fa-file-invoice-dollar text-primary"></i> الفاتورة المستلمة
                                </h4>
                                <small class="text-muted font-weight-bold">تاريخ الإدخال: {{ $purchase->created_at->format('Y/m/d H:i') }}</small>
                            </div>
                        </div>

                        <div class="row invoice-info mb-4 bg-light p-3 rounded">
                            <div class="col-sm-4 invoice-col">
                                المورد
                                <address class="mt-2">
                                    <strong class="text-dark">{{ $purchase->supplier->name ?? 'غير محدد' }}</strong><br>
                                    @if($purchase->supplier && $purchase->supplier->phone)
                                        الهاتف: <span dir="ltr">{{ $purchase->supplier->phone }}</span><br>
                                    @endif
                                    @if($purchase->supplier && $purchase->supplier->address)
                                        العنوان: {{ $purchase->supplier->address }}
                                    @endif
                                </address>
                            </div>
                            <div class="col-sm-4 invoice-col border-right">
                                تفاصيل الفاتورة
                                <address class="mt-2">
                                    <strong>رقم الفاتورة المرجعي:</strong> {{ $purchase->invoice_number ?? '-' }}<br>
                                    <strong>تاريخ الفاتورة (الاستحقاق):</strong> {{ $purchase->due_date ? \Carbon\Carbon::parse($purchase->due_date)->format('Y/m/d') : '-' }}<br>
                                    <strong>الحالة:</strong> 
                                    @if($purchase->status == 'paid')
                                        <span class="text-success font-weight-bold">مدفوعة بالكامل</span>
                                    @elseif($purchase->status == 'partial')
                                        <span class="text-warning font-weight-bold">مدفوعة جزئياً</span>
                                    @else
                                        <span class="text-danger font-weight-bold">غير مدفوعة</span>
                                    @endif
                                </address>
                            </div>
                            <div class="col-sm-4 invoice-col border-right">
                                المبالغ
                                <address class="mt-2">
                                    <strong>الإجمالي:</strong> <span class="text-primary font-weight-bold">{{ number_format($purchase->total_amount, 2) }} ج.م</span><br>
                                    <strong>المدفوع:</strong> <span class="text-success font-weight-bold">{{ number_format($purchase->paid_amount, 2) }} ج.م</span><br>
                                    <strong>المتبقي:</strong> <span class="text-danger font-weight-bold">{{ number_format($purchase->total_amount - $purchase->paid_amount, 2) }} ج.م</span><br>
                                </address>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 table-responsive">
                                <h5>عناصر الفاتورة:</h5>
                                <table class="table table-striped table-bordered mt-2">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>#</th>
                                            <th>المنتج / المادة الخام (كود)</th>
                                            <th class="text-center">الكمية</th>
                                            <th class="text-center">التكلفة للتحويل (الوحدة)</th>
                                            <th class="text-center">الإجمالي (ج.م)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($purchase->items as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @if($item->inventory && $item->inventory->inventoriable)
                                                        <strong>{{ $item->inventory->inventoriable->name }}</strong>
                                                        <br><small class="text-muted">الوحدة: {{ $item->inventory->unit->name ?? '-' }}</small>
                                                    @else
                                                        <span class="text-danger">مادة محذوفة</span>
                                                    @endif
                                                </td>
                                                <td class="text-center font-weight-bold">{{ number_format($item->quantity, 3) }}</td>
                                                <td class="text-center">{{ number_format($item->unit_price, 2) }}</td>
                                                <td class="text-center bg-light font-weight-bold">{{ number_format($item->total, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">لا يوجد عناصر مسجلة</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if($purchase->notes)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <p class="lead mb-2">ملاحظات الفاتورة:</p>
                                    <p class="text-muted bg-light p-3 rounded border">{{ $purchase->notes }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="row no-print mt-4 border-top pt-3 text-left">
                            <div class="col-12">
                                <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST" class="float-right m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('هل أنت متأكد من الحذف التام للفاتورة؟ لن يتم استرجاع المخزون في هذه النسخة حالياً.')">
                                        <i class="fas fa-trash"></i> حذف الفاتورة
                                    </button>
                                </form>
                                <button type="button" class="btn btn-default float-left" onclick="window.print()"><i class="fas fa-print"></i> طباعة</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
