@extends('layouts.app')

@section('main-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">طلبات الشراء</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                <h3 class="card-title mb-2 mb-md-0">قائمة طلبات الشراء</h3>

                <div class="d-flex flex-wrap gap-2">
                    <form action="{{ route('inventory.purchase-requests.index') }}" method="GET" class="d-flex flex-wrap gap-2">
                        <select name="status" class="form-control form-control-sm" style="width: 180px;">
                            <option value="">كل الحالات</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>مسودة</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>معتمد</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                        </select>

                        <button type="submit" class="btn btn-info btn-sm">
                            <i class="fas fa-search"></i> فلترة
                        </button>

                        <a href="{{ route('inventory.purchase-requests.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-times"></i>
                        </a>
                    </form>

                    <a href="{{ route('inventory.purchase-requests.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> إضافة طلب شراء
                    </a>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover text-center mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>رقم الطلب</th>
                                <th>تاريخ الطلب</th>
                                <th>عدد الأصناف</th>
                                <th>الحالة</th>
                                <th>المعتمد بواسطة</th>
                                <th>ملاحظات</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($purchaseRequests as $requestItem)
                                <tr>
                                    <td>{{ $purchaseRequests->firstItem() + $loop->index }}</td>
                                    <td>{{ $requestItem->request_number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($requestItem->request_date)->format('Y-m-d') }}</td>
                                    <td>{{ $requestItem->items->count() }}</td>
                                    <td>
                                        @php
                                            $statusMap = [
                                                'draft' => ['secondary', 'مسودة'],
                                                'approved' => ['success', 'معتمد'],
                                                'cancelled' => ['danger', 'ملغي'],
                                            ];
                                            $statusData = $statusMap[$requestItem->status] ?? ['secondary', $requestItem->status];
                                        @endphp
                                        <span class="badge badge-{{ $statusData[0] }}">
                                            {{ $statusData[1] }}
                                        </span>
                                    </td>
                                    <td>{{ $requestItem->approver->name ?? '-' }}</td>
                                    <td>{{ $requestItem->notes ?: '-' }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center flex-wrap" style="gap: 5px;">
                                            @if($requestItem->status === 'draft')
                                                <form action="{{ route('inventory.purchase-requests.approve', $requestItem->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm" title="اعتماد">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <button type="button"
                                                    class="btn btn-info btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#itemsModal{{ $requestItem->id }}"
                                                    title="عرض الأصناف">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal عرض الأصناف -->
                                <div class="modal fade" id="itemsModal{{ $requestItem->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content" dir="rtl">
                                            <div class="modal-header">
                                                <h5 class="modal-title">أصناف طلب الشراء - {{ $requestItem->request_number }}</h5>
                                                <button type="button" class="close ml-0 mr-auto" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered text-center">
                                                        <thead>
                                                            <tr>
                                                                <th>الصنف</th>
                                                                <th>الوحدة</th>
                                                                <th>الكمية المطلوبة</th>
                                                                <th>الكمية المعتمدة</th>
                                                                <th>ملاحظات</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($requestItem->items as $item)
                                                                <tr>
                                                                    <td>{{ $item->rawMaterial->name ?? '-' }}</td>
                                                                    <td>{{ $item->unit->name ?? '-' }}</td>
                                                                    <td>{{ number_format($item->requested_quantity, 3) }}</td>
                                                                    <td>{{ number_format($item->approved_quantity, 3) }}</td>
                                                                    <td>{{ $item->notes ?: '-' }}</td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="5">لا توجد أصناف</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="8">لا توجد بيانات حالياً</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-block d-md-none p-3">
                    @forelse($purchaseRequests as $requestItem)
                        <div class="card mb-3 shadow-none border">
                            <div class="card-body">
                                <h5 class="mb-2 text-primary">{{ $requestItem->request_number }}</h5>

                                <div class="small text-muted mb-2">
                                    <div>تاريخ الطلب: {{ \Carbon\Carbon::parse($requestItem->request_date)->format('Y-m-d') }}</div>
                                    <div>عدد الأصناف: {{ $requestItem->items->count() }}</div>
                                    <div>الحالة:
                                        @php
                                            $statusMap = [
                                                'draft' => ['secondary', 'مسودة'],
                                                'approved' => ['success', 'معتمد'],
                                                'cancelled' => ['danger', 'ملغي'],
                                            ];
                                            $statusData = $statusMap[$requestItem->status] ?? ['secondary', $requestItem->status];
                                        @endphp
                                        <span class="badge badge-{{ $statusData[0] }}">
                                            {{ $statusData[1] }}
                                        </span>
                                    </div>
                                    <div>المعتمد بواسطة: {{ $requestItem->approver->name ?? '-' }}</div>
                                </div>

                                <div class="d-flex flex-wrap" style="gap: 6px;">
                                    @if($requestItem->status === 'draft')
                                        <form action="{{ route('inventory.purchase-requests.approve', $requestItem->id) }}" method="POST" class="flex-fill">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm w-100">اعتماد</button>
                                        </form>
                                    @endif

                                    <button type="button"
                                            class="btn btn-info btn-sm flex-fill"
                                            data-toggle="modal"
                                            data-target="#itemsModalMobile{{ $requestItem->id }}">
                                        عرض الأصناف
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Modal -->
                        <div class="modal fade" id="itemsModalMobile{{ $requestItem->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content" dir="rtl">
                                    <div class="modal-header">
                                        <h5 class="modal-title">أصناف الطلب - {{ $requestItem->request_number }}</h5>
                                        <button type="button" class="close ml-0 mr-auto" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        @forelse($requestItem->items as $item)
                                            <div class="border rounded p-2 mb-2">
                                                <div><strong>الصنف:</strong> {{ $item->rawMaterial->name ?? '-' }}</div>
                                                <div><strong>الوحدة:</strong> {{ $item->unit->name ?? '-' }}</div>
                                                <div><strong>المطلوب:</strong> {{ number_format($item->requested_quantity, 3) }}</div>
                                                <div><strong>المعتمد:</strong> {{ number_format($item->approved_quantity, 3) }}</div>
                                                <div><strong>ملاحظات:</strong> {{ $item->notes ?: '-' }}</div>
                                            </div>
                                        @empty
                                            <div class="alert alert-info mb-0">لا توجد أصناف</div>
                                        @endforelse
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info text-center mb-0">لا توجد بيانات حالياً</div>
                    @endforelse
                </div>
            </div>

            <div class="card-footer clearfix">
                {{ $purchaseRequests->links() }}
            </div>
        </div>
    </div>
</section>
@endsection