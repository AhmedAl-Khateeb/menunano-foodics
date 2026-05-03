@extends('layouts.app')

@section('main-content')
<div class="content-header">
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
<h1 class="m-0"></h1>
</div>
<div class="col-sm-6">
<ol class="breadcrumb float-sm-right">
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
<li class="breadcrumb-item active">(الموظفين )(الكاشير</li>
</ol>
</div>
</div>
</div>
</div>

<section class="content">
<div class="container-fluid">
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
<i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
@endif

<div class="row">
<div class="col-12">
<div class="card border-0 shadow-sm rounded-lg">
<div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
<h3 class="card-title font-weight-bold text-dark">سجل الموظفين </h3>


<a href="{{ route('staff.create') }}" class="btn btn-primary btn-sm ms-auto shadow-sm" data-toggle="modal" data-target="#desc-add">
<i class="fas fa-plus mr-1"></i> حساب شهري للموظف
</a>


</div>


<div class="modal fade" id="desc-add" tabindex="-1" aria-labelledby="descAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-lg shadow">

            <form action="{{ route('salary_m.store') }}" method="POST" enctype="multipart/form-data"
                novalidate>

                @csrf
                @method('POST')


                <input type="hidden" name="_token" value="zuPPPMo09ckMkKbY8mvcAePvb4bwnCf2wrz1BuQ2" autocomplete="off">                                <div class="modal-header border-0">
                    <h5 class="modal-title" id="descAddLabel">إضافة فئة جديدة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                        <span aria-hidden="true" style="font-size: 1.5rem;">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-dark">
                    <div class="form-group">
                        <label for="name">الخصومات</label>
                        <input type="text" name="penalties" id="penalties"
                            class="form-control "
                            value="" required autofocus>
                                                            </div>

                        <div class="form-group">
                            <label for="name">السلف</label>
                            <input type="text" name="Salary_advance" id="Salary_advance"
                                class="form-control "
                                value="" required autofocus>
                                                                </div>
                        <div class="form-group">
                            <label for="name">المكافات</label>
                            <input type="text" name="Rewards" id="Rewards"
                                class="form-control "
                                value="" required autofocus>
                                                                </div>

@foreach ($salary as $staff_salary)

                <div class="form-group">
                    <input  name="staff_id" id="staff_id"
                        class="form-control"  type="hidden"
                        value="{{ $staff_salary->staff->id }}" required autofocus>
                                                        </div>

    <div class="form-group">
        <input name="user_id" id="user_id"
            class="form-control"  type="hidden"
            value="{{ $staff_salary->staff->user_id }}" required autofocus>
                                            </div>


@endforeach
                </div>
                <div class="modal-footer border-0 justify-content-between">
                    <button type="button" class="btn btn-outline-secondary px-4"
                        data-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-success px-4">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>


<div class="card-body p-0 mt-3">
<div class="table-responsive">
<table class="table table-hover align-middle">
    <thead class="bg-light text-muted">
        <tr>
            <th class="border-top-0 pl-4">#</th>
            {{-- <th class="border-top-0">رقم الفاتورة</th> --}}
            <th class="border-top-0">أسم الموظف</th>

            <th class="border-top-0">المرتب</th>

            <th class="border-top-0">الخصومات</th>

            <th class="border-top-0">السلف</th>

            <th class="border-top-0">المكافات </th>


            <th class="border-top-0">صافي المرتب  </th>


            <th class="border-top-0">تاريخ التسجيل   </th>
        </tr>
    </thead>
    <tbody>
        @forelse ($salary as $staff_salary)
            <tr>
                <td class="pl-4 text-muted">{{ $loop->iteration }}</td>

                {{-- <td class="font-weight-bold text-primary">{{ $staff->invoice_number ?? '-' }}</td> --}}
                <td class="font-weight-bold text-dark">{{ $staff_salary->staff->Name }}</td>


                <td class="text-center font-weight-bold">{{ number_format($staff_salary->staff->Salary, 2) }} ج.م</td>


                <td class="font-weight-bold text-dark">{{ $staff_salary->penalties }}</td>

                <td class="font-weight-bold text-dark">{{ $staff_salary->Salary_advance }}</td>


                <td class="font-weight-bold text-dark">{{$staff_salary->Rewards }}</td>

                <td class="text-center text-muted" dir="ltr">{{number_format($staff_salary->staff->Salary+$staff_salary->Rewards-($staff_salary->penalties+$staff_salary->Salary_advance) ) }}    ج.م  </td>


                <td class="text-center">
                    {{ $staff_salary->created_at->format('Y-m-d') }}
                </td>

            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center text-muted py-5">
                    <i class="fas fa-file-invoice-dollar text-light block mb-3" style="font-size: 3rem;"></i><br>
                    لا توجد  بيانات موظفين   مسجلة
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
</section>

<style>
.hover-bg-info:hover { background-color: #17a2b8 !important; color: white !important; }
.hover-bg-danger:hover { background-color: #dc3545 !important; color: white !important; }
</style>
@endsection
