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
@if (session('success'))
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
<div
class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
<h3 class="card-title font-weight-bold text-dark">سجل الموظفين </h3>
<a href="{{ route('staff.create') }}"  data-toggle="modal"  data-target="#desc-add"   class="btn btn-primary btn-sm ms-auto shadow-sm">
<i class="fas fa-plus mr-1"></i> موظف جديد
</a>
</div>



<div class="modal fade flex-1 overflow-y-auto  py-4 space-y-2 text-right" id="desc-add" tabindex="-1" aria-labelledby="descAddLabel"
aria-hidden="true">



<div class="modal-dialog modal-dialog-centered">
<div class="modal-content rounded-lg shadow">

    <div class="card-header card card-primary text-right">
        <h3 class="card-title float-right">أضافات موظف </h3>
    </div>
    <form action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data">


        @csrf
        @method('POST')


        <div class="form-group mb-3 text-right">
            <label for="name">أسم موظف <span class="text-danger">*</span></label>
            <input type="text" name="Name" class="form-control " id="name"
                placeholder="أدخل اسم الموظف" value="" required="">
        </div>



        
        <div class="form-group mb-3 text-right">
            <label for="mobile">رقم موبيل <span class="text-danger">*</span></label>
            <input type="text" name="mobile" class="form-control " id="name"
                placeholder="أدخل رقم تليفون الموظف" value="" required="">
        </div>


        <div class="form-group mb-3 text-right">

            <label for="Number_of_days"> عدد أيام العمل  <span class="text-danger">*</span></label>
            <input type="number" name="Number_of_days" step="0.01" min="0" max="100"
                class="form-control  text-right" id="عدد أيام العمل " placeholder="أدخل عدد أيام العمل " value=""
                required="">
        </div>



        <div class="form-group mb-3 text-right">

            <label for="Number_of_hours"> عدد ساعات العمل  <span class="text-danger">*</span></label>
            <input type="number" name="Number_of_hours" step="0.01" min="0" max="100"
                class="form-control  text-right" id="عدد أيام العمل " placeholder="أدخل عدد ساعات العمل " value=""
                required="">
        </div>


        {{-- <div class="form-group mb-3 text-right">

            <label for="Academic_qualification"> المؤهلات الدراسية <span class="text-danger">*</span></label>
            <textarea type="text" name="Academic_qualification" class="form-control " id="name"
                placeholder="أدخل اسم الموهل الدراسي" value="" required=""> </textarea>
        </div> --}}

        <div class="form-group mb-3 text-right">

            <label for="upload">أرفاق ملف </label>
            <input type="file" name="upload" class="form-control  text-right" id="attach_File"
                placeholder='أرفاق ملف' value="">
        </div>

        <div class="form-group mb-3 text-right">
            <label for="Salary">المرتب</label>
            <input type="text" name="Salary" class="form-control  text-right" id=""
                placeholder="أدخل أجمالي المبلغ" value="">
        </div>


        <div class="form-group mb-3 text-right">
            <label for="Start_date">بداية التعاقد</label>
            <input type="datetime-local" name="Start_date" class="form-control text-right" id="Start_date"
                value="{{ old('Start_date') }}">
        </div>

        <div class="form-group mb-3 text-right">
            <label for="End_date">نهاية التعاقد</label>
            <input type="datetime-local" name="End_date" class="form-control text-right" id="End_date"
                value="{{ old('End_date') }}">
        </div>
        <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">حفظ البيانات</button>
            </div>  </form>

</div>
</div>



</div></div>









<div class="card-body p-0 mt-3">
<div class="table-responsive">
<table class="table table-hover align-middle">
<thead class="bg-light text-muted">
<tr>
<th class="border-top-0 pl-4">#</th>
{{-- <th class="border-top-0">رقم الفاتورة</th> --}}
<th class="border-top-0">أسم الموظف</th>

<th class="border-top-0">موبيل</th>

<th class="border-top-0">عدد أيام العمل </th>

<th class="border-top-0">عدد ساعات العمل </th>

<th class="border-top-0">تاريخ التعين</th>

<th class="border-top-0">تاريخ الاستقالة </th>

<th class="border-top-0">تاريخ التسجيل </th>

<th class="border-top-0">المرفقات</th>


<th class="border-top-0">المرتب</th>


<th class="border-top-0 text-center">الأجراءت</th>
{{--   <th class="border-top-0 text-center">الملاحظات</th>  --}}
</tr>
</thead>
<tbody>
@forelse ($staffs as $staff)
<tr>
<td class="pl-4 text-muted">{{ $loop->iteration }}</td>
{{-- <td class="font-weight-bold text-primary">{{ $staff->invoice_number ?? '-' }}</td> --}}
<td class="font-weight-bold text-dark">{{ $staff->Name }}</td>
<td class="font-weight-bold text-dark">{{ $staff->mobile }}</td>



<td class="font-weight-bold text-dark">{{ $staff->Number_of_days }}</td>


<td class="font-weight-bold text-dark">{{ $staff->Number_of_hours }}
</td>

<td class="font-weight-bold text-dark">{{ $staff->Start_date }}</td>


<td class="font-weight-bold text-dark">{{ $staff->End_date }}</td>

<td class="text-center text-muted" dir="ltr">
{{ $staff->created_at->format('Y-m-d') }}</td>

<td class="font-weight-bold text-dark">

<a href="Attachfile/staff/{{ $staff->attach_File }}"
data-lightbox="image-1" data-title="My caption">

<embed src="Attachfile/staff/{{ $staff->attach_File }}"
style="width:50px; height:50px;" /> </a>
</td>
<td class="text-center font-weight-bold">
{{ number_format($staff->Salary, 2) }} ج.م</td>
{{-- <td class="text-center text-success">{{ $staff->Notes}} </td> --}}
{{-- <td class="text-center">

</td> --}}
<td>
<div class="d-flex gap-2 justify-content-center">

<a href="{{ route('salary_m.index') }}?staff_id={{ $staff->id }}"
class="btn btn-light btn-sm text-info shadow-sm hover-bg-info"
title="حسابات شهرية للموظف">
<i class="fas fa-file-invoice-dollar  text-blue-500"></i>
</a>

<a href="{{ route('staff.show', $staff->id) }}"
class="btn btn-light btn-sm text-info shadow-sm hover-bg-info"
title="تعديل بيانات الموظف">
<i class="fa fa-edit"></i>
</a>


<form action="{{ route('staff.destroy', $staff->id) }}"
method="POST" style="display:inline-block;" class="m-0">
@csrf
@method('DELETE')
<button type="submit"
class="btn btn-light btn-sm text-danger shadow-sm hover-bg-danger"
onclick="return confirm('هل أنت متأكد من حذف سجل موظف  هذا؟')"
title="حذف (الموظفين (الكاشير">
<i class="fas fa-trash-alt"></i>
</button>
</form>
</div>
</td>
</tr>
@empty
<tr>
<td colspan="8" class="text-center text-muted py-5">
<i class="fas fa-file-invoice-dollar text-light block mb-3"
style="font-size: 3rem;"></i><br>
لا توجد بيانات موظفين مسجلة
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
.hover-bg-info:hover {
background-color: #17a2b8 !important;
color: white !important;
}

.hover-bg-danger:hover {
background-color: #dc3545 !important;
color: white !important;
}
</style>
@endsection
