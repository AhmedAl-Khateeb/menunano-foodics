@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">الشراء / الاستلام</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{-- <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li> --}}
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">سندات الاستلام</h3>
                   
                    <form action="{{ route('inventory.receipts.index') }}" method="GET"
                        class="d-flex flex-wrap gap-2">
                        <input type="text" name="search" class="form-control form-control-sm" style="width:180px;"
                            value="{{ request('search') }}" placeholder="بحث برقم السند \اسم المورد\ التاريخ">

                        <button type="submit" class="btn btn-info btn-sm">
                            <i class="fas fa-search"></i> بحث
                        </button>

                        <a href="{{ route('inventory.receipts.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-times"></i>
                        </a>
                    </form>
                     <a href="{{ route('inventory.receipts.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> إضافة استلام
                    </a>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover text-center mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>رقم السند</th>
                                    <th>المورد</th>
                                    <th>أمر الشراء</th>
                                    <th>التاريخ</th>
                                    <th>الإجمالي</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($receipts as $receipt)
                                    <tr>
                                        <td>{{ $receipts->firstItem() + $loop->index }}</td>
                                        <td>{{ $receipt->receipt_number }}</td>
                                        <td>{{ $receipt->supplier->name ?? '-' }}</td>
                                        <td>{{ $receipt->purchaseOrder->po_number ?? '-' }}</td>
                                        <td>{{ $receipt->receipt_date?->format('Y-m-d') }}</td>
                                        <td>{{ rtrim(rtrim(number_format($receipt->total ?? 0, 3, '.', ''), '0'), '.') }}
                                        </td>
                                        <td>
                                            <span
                                                class="badge badge-{{ $receipt->status === 'posted' ? 'success' : 'secondary' }}">
                                                {{ $receipt->status === 'posted' ? 'مرحّل' : 'مسودة' }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($receipt->status === 'draft')
                                                <form action="{{ route('inventory.receipts.post', $receipt->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fas fa-check"></i> ترحيل
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-success">تم الترحيل</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">لا توجد بيانات حالياً</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    {{ $receipts->links() }}
                </div>
            </div>
            <div class="col-sm-6">
                <ol class="float-sm-right mb-0 p-0" style="list-style: none;">
                    <li>
                        <a href="{{ route('dashboard') }}" class="btn btn-success"
                            style="color: #fff; transition: all 0.2s ease-in-out;"
                            onmouseover="this.style.backgroundColor='#007bff'; this.style.borderColor='#007bff'; this.style.color='#fff';"
                            onmouseout="this.style.backgroundColor=''; this.style.borderColor=''; this.style.color='#fff';">
                            الرئيسية
                        </a>
                    </li>
                </ol>
            </div>
        </div>
    </section>
@endsection
