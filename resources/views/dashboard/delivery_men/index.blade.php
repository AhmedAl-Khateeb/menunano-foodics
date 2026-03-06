@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">عمال التوصيل</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active">عمال التوصيل</li>
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
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title mb-0">قائمة عمال التوصيل</h3>
                            <a href="{{ route('delivery_men.create') }}" class="btn btn-primary btn-sm ms-auto">
                                <i class="fas fa-plus"></i> إضافة عامل توصيل
                            </a>
                        </div>
                        <div class="card-body p-0">
                            {{-- Desktop View --}}
                            <div class="table-responsive d-none d-md-block">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الاسم</th>
                                            <th>الهاتف</th>
                                            <th>نسبة العمولة</th>
                                            <th>الحالة</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($deliveryMen as $man)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="font-weight-bold">{{ $man->name }}</td>
                                                <td dir="ltr" class="text-right">{{ $man->phone ?? '-' }}</td>
                                                <td>
                                                    <span class="badge badge-info px-2 py-1">{{ $man->commission_percent }}%</span>
                                                </td>
                                                <td>
                                                    @if($man->is_active)
                                                        <span class="badge badge-success">نشط</span>
                                                    @else
                                                        <span class="badge badge-secondary">معطل</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1 justify-content-center">
                                                        <a href="{{ route('delivery_men.edit', $man->id) }}" class="btn btn-info btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('delivery_men.destroy', $man->id) }}" method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">لا يوجد عمال توصيل مضافين</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Mobile View --}}
                            <div class="d-block d-md-none p-3">
                                @forelse ($deliveryMen as $man)
                                    <div class="card mb-3 border shadow-none rounded-lg">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h5 class="mb-0 font-weight-bold text-primary">{{ $man->name }}</h5>
                                                @if($man->is_active)
                                                    <span class="badge badge-success px-2 py-1">نشط</span>
                                                @else
                                                    <span class="badge badge-secondary px-2 py-1">معطل</span>
                                                @endif
                                            </div>
                                            
                                            <div class="text-muted small mb-3">
                                                <div class="mb-1 d-flex justify-content-between">
                                                    <span><i class="fas fa-phone mr-1 w-4 text-center"></i> رقم الهاتف:</span>
                                                    <span dir="ltr">{{ $man->phone ?? '-' }}</span>
                                                </div>
                                                <div class="mb-1 d-flex justify-content-between">
                                                     <span><i class="fas fa-percentage mr-1 w-4 text-center"></i> العمولة:</span>
                                                     <span class="font-weight-bold">{{ $man->commission_percent }}%</span>
                                                </div>
                                            </div>

                                            <div class="d-flex gap-2 border-top pt-3">
                                                <a href="{{ route('delivery_men.edit', $man->id) }}" class="btn btn-info btn-sm flex-grow-1">
                                                    <i class="fas fa-edit"></i> تعديل
                                                </a>
                                                <form action="{{ route('delivery_men.destroy', $man->id) }}" method="POST" class="flex-grow-1" style="margin:0;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('هل أنت متأكد؟')">
                                                        <i class="fas fa-trash"></i> حذف
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center text-muted py-4 border rounded">لا يوجد عمال توصيل مضافين</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
