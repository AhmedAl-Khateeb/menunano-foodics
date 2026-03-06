@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">الموردين</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active">الموردين</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-lg">
                        <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                            <h3 class="card-title font-weight-bold text-dark">قائمة الموردين</h3>
                            <a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-sm ms-auto shadow-sm">
                                <i class="fas fa-plus mr-1"></i> إضافة مورد
                            </a>
                        </div>
                        <div class="card-body p-0 mt-3">
                            {{-- Desktop View --}}
                            <div class="table-responsive d-none d-md-block">
                                <table class="table table-hover align-middle">
                                    <thead class="bg-light text-muted">
                                        <tr>
                                            <th class="border-top-0 pl-4">#</th>
                                            <th class="border-top-0">الاسم</th>
                                            <th class="border-top-0">معلومات التواصل</th>
                                            <th class="border-top-0">الرصيد الافتتاحي (الرصيد)</th>
                                            <th class="border-top-0 text-center">الحالة</th>
                                            <th class="border-top-0 text-center">الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($suppliers as $supplier)
                                            <tr>
                                                <td class="pl-4 text-muted">{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="font-weight-bold text-dark">{{ $supplier->name }}</div>
                                                    @if($supplier->address)
                                                        <div class="small text-muted text-truncate" style="max-width: 200px;" title="{{ $supplier->address }}">
                                                            <i class="fas fa-map-marker-alt mr-1"></i> {{ $supplier->address }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($supplier->phone)
                                                        <div dir="ltr" class="text-right small text-dark"><i class="fas fa-phone-alt text-muted mr-1"></i> {{ $supplier->phone }}</div>
                                                    @endif
                                                    @if($supplier->email)
                                                        <div class="small text-muted"><i class="fas fa-envelope mr-1"></i> {{ $supplier->email }}</div>
                                                    @endif
                                                    @if(!$supplier->phone && !$supplier->email)
                                                        <span class="text-muted small">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="font-weight-bold text-{{ $supplier->balance > 0 ? 'danger' : ($supplier->balance < 0 ? 'success' : 'dark') }}">
                                                        {{ number_format($supplier->balance, 2) }} ج.م
                                                    </span>
                                                    <div class="small text-muted">
                                                        {{ $supplier->balance > 0 ? 'دائن (له)' : ($supplier->balance < 0 ? 'مدين (عليه)' : 'متزن') }}
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    @if($supplier->is_active)
                                                        <span class="badge badge-success px-2 py-1 shadow-sm">نشط</span>
                                                    @else
                                                        <span class="badge badge-secondary px-2 py-1 shadow-sm">غير نشط</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-light btn-sm text-primary shadow-sm hover-bg-primary" title="تعديل">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display:inline-block;" class="m-0">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-light btn-sm text-danger shadow-sm hover-bg-danger" onclick="return confirm('هل أنت متأكد من حذف هذا المورد؟')" title="حذف">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-5">
                                                    <i class="fas fa-boxes text-light block mb-3" style="font-size: 3rem;"></i><br>
                                                    لا يوجد موردين مضافين حتى الآن
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Mobile View --}}
                            <div class="d-block d-md-none p-3 bg-light">
                                @forelse ($suppliers as $supplier)
                                    <div class="card mb-3 border-0 shadow-sm rounded-lg">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <h5 class="mb-1 font-weight-bold text-dark">{{ $supplier->name }}</h5>
                                                    @if($supplier->address)
                                                        <div class="small text-muted">
                                                            <i class="fas fa-map-marker-alt text-primary mr-1 w-4 text-center"></i> {{ Str::limit($supplier->address, 30) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                @if($supplier->is_active)
                                                    <span class="badge badge-success px-2 py-1 shadow-sm">نشط</span>
                                                @else
                                                    <span class="badge badge-secondary px-2 py-1 shadow-sm">غير نشط</span>
                                                @endif
                                            </div>
                                            
                                            <div class="bg-light p-2 rounded mb-3">
                                                @if($supplier->phone)
                                                    <div class="mb-1 d-flex justify-content-between small">
                                                        <span class="text-muted"><i class="fas fa-phone-alt mr-1 w-4 text-center"></i> الهاتف:</span>
                                                        <span dir="ltr" class="font-weight-bold text-dark">{{ $supplier->phone }}</span>
                                                    </div>
                                                @endif
                                                @if($supplier->email)
                                                    <div class="mb-1 d-flex justify-content-between small">
                                                        <span class="text-muted"><i class="fas fa-envelope mr-1 w-4 text-center"></i> البريد:</span>
                                                        <span class="font-weight-bold text-dark">{{ $supplier->email }}</span>
                                                    </div>
                                                @endif
                                                <div class="d-flex justify-content-between small mt-2 pt-2 border-top">
                                                     <span class="text-muted"><i class="fas fa-wallet mr-1 w-4 text-center"></i> الرصيد:</span>
                                                     <span class="font-weight-bold text-{{ $supplier->balance > 0 ? 'danger' : ($supplier->balance < 0 ? 'success' : 'dark') }}">{{ number_format($supplier->balance, 2) }} ج.م</span>
                                                </div>
                                            </div>

                                            <div class="d-flex gap-2">
                                                <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-outline-primary btn-sm flex-grow-1">
                                                    <i class="fas fa-edit mr-1"></i> تعديل
                                                </a>
                                                <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="flex-grow-1" style="margin:0;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100" onclick="return confirm('هل أنت متأكد؟')">
                                                        <i class="fas fa-trash-alt mr-1"></i> حذف
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center text-muted py-5 border rounded bg-white">
                                        <i class="fas fa-boxes text-light block mb-3" style="font-size: 3rem;"></i><br>
                                        لا يوجد موردين مضافين
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .hover-bg-primary:hover { background-color: #007bff !important; color: white !important; }
        .hover-bg-danger:hover { background-color: #dc3545 !important; color: white !important; }
    </style>
@endsection
