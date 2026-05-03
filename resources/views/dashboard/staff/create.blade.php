
@extends('layouts.app')

@section('main-content')
<div class="content-header">
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
<h1 class="m-0">إضافة موظف</h1>
</div>
<div class="col-sm-6">
<ol class="breadcrumb float-sm-right">
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
<li class="breadcrumb-item"><a href="{{ route('staff.create') }}">الموظف </a></li>
<li class="breadcrumb-item active">موظف جديد </li>
</ol>
</div>
</div>
</div>
</div>

<section class="content">
<div class="container-fluid">

<div class="card card-primary">
<div class="card-header text-right">
<h3 class="card-title float-right">أضافات موظف </h3>
</div>
<form action="{{ route('staff.store') }}"    method="POST"  enctype="multipart/form-data">


    @csrf
    @method('POST')


    <div class="form-group mb-3 text-right">
    <label for="name">أسم موظف <span class="text-danger">*</span></label>
    <input type="text" name="Name" class="form-control " id="name" placeholder="أدخل اسم الموظف" value="" required="">
                                    </div>


<div class="form-group mb-3 text-right">

<label for="BirthDay">تاريخ الميلاد <span class="text-danger">*</span></label>
<input type="date" name="BirthDay"  step="0.01"  min="0"  max="100"  class="form-control  text-right" id="name" placeholder="أدخل اسم الموظف" value="" required="">
                        </div>


<div class="form-group mb-3 text-right">

    <label for="Academic_qualification">    المؤهلات  الدراسية  <span class="text-danger">*</span></label>
    <textarea type="text" name="Academic_qualification" class="form-control " id="name" placeholder="أدخل اسم الموهل الدراسي" value="" required=""> </textarea>
                            </div>

<div class="form-group mb-3 text-right">

<label for="upload">أرفاق ملف </label>
<input type="file" name="upload"  class="form-control  text-right" id="attach_File" placeholder='أرفاق ملف' value="">
                    </div>



<div class="form-group mb-3 text-right">
    <label for="Salary">المرتب</label>
    <input type="text" name="Salary" class="form-control  text-right" id="" placeholder="أدخل أجمالي المبلغ" value="">
                                    </div>





<div class="form-group mb-3 text-right">
    <label for="Start_date">    بداية   التعاقد  </label>
    <input type="datetime-local"  name="Start_date"   step="0.01"  min="0"  max="100"  class="form-control  text-right" id="commission_percent" placeholder="أدخل نسبة العمولة" value="0">

                                    </div>



<div class="form-group mb-3 text-right">
    <label for="End_date">    نهاية  التعاقد  </label>
    <input type="datetime-local"  name="End_date"   step="0.01"  min="0"  max="100"  class="form-control  text-right" id="commission_percent" placeholder="أدخل نسبة العمولة" value="0">

                                    </div>

</div>
</div>
<div class="card-footer text-right">
<button type="submit" class="btn btn-primary">حفظ البيانات</button>
</div>
</form>
</div>


</div>
</section>
@endsection
