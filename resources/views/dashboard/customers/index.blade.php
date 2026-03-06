@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">العملاء</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active">العملاء</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline border-0 shadow-sm rounded-lg">
                        <div class="card-header bg-white border-bottom text-right">
                            <h3 class="card-title font-weight-bold text-dark mb-0 py-1 float-right">قائمة العملاء</h3>
                        </div>
                        <div class="card-body p-0 text-right">
                            {{-- Desktop View --}}
                            <div class="table-responsive d-none d-md-block">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-right">#</th>
                                            <th class="text-right">الاسم</th>
                                            <th class="text-right">رقم الهاتف</th>
                                            <th class="text-right">تاريخ الإضافة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($customers as $customer)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="font-weight-bold">{{ $customer->name }}</td>
                                                <td dir="ltr" class="text-right">{{ $customer->phone ?? '-' }}</td>
                                                <td>{{ $customer->created_at->format('Y-m-d') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-4">لا يوجد عملاء مضافين</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Mobile View --}}
                            <div class="d-block d-md-none p-3">
                                @forelse ($customers as $customer)
                                    <div class="card mb-3 border shadow-none rounded-lg text-right">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h5 class="mb-0 font-weight-bold text-primary">{{ $customer->name }}</h5>
                                            </div>
                                            
                                            <div class="text-muted small">
                                                <div class="mb-1 d-flex justify-content-between">
                                                    <span>رقم الهاتف:</span>
                                                    <span dir="ltr">{{ $customer->phone ?? '-' }}</span>
                                                </div>
                                                <div class="mb-1 d-flex justify-content-between">
                                                    <span>تاريخ الإضافة:</span>
                                                    <span>{{ $customer->created_at->format('Y-m-d') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center text-muted py-4 border rounded">لا يوجد عملاء مضافين</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
