@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">طلبات التحويل</h1>
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
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <h3 class="card-title mb-0">قائمة التحويلات</h3>

                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <form action="{{ route('inventory.transfer-requests.index') }}" method="GET"
                            class="d-flex flex-wrap gap-2">
                            <input type="text" name="search" class="form-control form-control-sm" style="width:220px;"
                                value="{{ request('search') }}" placeholder="بحث برقم التحويل ">

                            <div class="input-group input-group-sm" style="width: 190px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">من</span>
                                </div>
                                <input type="date" name="date_from" class="form-control"
                                    value="{{ request('date_from') }}">
                            </div>

                            <div class="input-group input-group-sm" style="width: 190px;">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">إلى</span>
                                </div>
                                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                            </div>


                            <select name="status" class="form-control form-control-sm" style="width:150px;">
                                <option value="">كل الحالات</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>مسودة</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>معتمد
                                </option>
                                <option value="received" {{ request('status') == 'received' ? 'selected' : '' }}>مستلم
                                </option>
                            </select>

                            <button type="submit" class="btn btn-info btn-sm">
                                <i class="fas fa-search"></i> بحث
                            </button>

                            <a href="{{ route('inventory.transfer-requests.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times"></i>
                            </a>
                        </form>

                        <a href="{{ route('inventory.transfer-requests.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> إضافة تحويل
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-hover text-center mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>رقم التحويل</th>
                                    <th>التاريخ</th>
                                    <th>عدد الأصناف</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transfers as $transfer)
                                    <tr>
                                        <td>{{ $transfers->firstItem() + $loop->index }}</td>
                                        <td>{{ $transfer->transfer_number }}</td>
                                        <td>{{ $transfer->created_at?->format('Y-m-d') }}</td>
                                        <td>{{ $transfer->items->count() }}</td>
                                        <td>
                                            @php
                                                $statusMap = [
                                                    'draft' => ['secondary', 'مسودة'],
                                                    'approved' => ['primary', 'معتمد'],
                                                    'received' => ['success', 'مستلم'],
                                                ];
                                                $statusData = $statusMap[$transfer->status] ?? [
                                                    'secondary',
                                                    $transfer->status,
                                                ];
                                            @endphp
                                            <span class="badge badge-{{ $statusData[0] }}">{{ $statusData[1] }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1 justify-content-center flex-wrap">
                                                @if ($transfer->status === 'draft')
                                                    <form
                                                        action="{{ route('inventory.transfer-requests.approve', $transfer->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success btn-sm">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                @if ($transfer->status === 'approved')
                                                    <form
                                                        action="{{ route('inventory.transfer-requests.receive', $transfer->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-inbox"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                                <a href="{{ route('inventory.transfer-requests.edit', $transfer->id) }}"
                                                    class="btn btn-info btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <form
                                                    action="{{ route('inventory.transfer-requests.destroy', $transfer->id) }}"
                                                    method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                        data-name="{{ $transfer->transfer_number }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">لا توجد بيانات حالياً</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    {{ $transfers->links() }}
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
