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
                        @foreach ($staffs as $staff)
                            <li class="breadcrumb-item"><a href="{{ route('staff.update', $staff->id) }}">تعديل بيانات موظف
                                </a></li>
                        @endforeach
                        <li class="breadcrumb-item active">تعديل بيانات الموظف </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-primary">
                <div class="card-header text-right">
                    <h3 class="card-title float-right">تعديل بيانات موظف </h3>
                </div>

                @foreach ($staffs as $staff)
                    <form action="{{ route('staff.update', $staff->id) }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3 text-right">
                            <label for="name">أسم موظف <span class="text-danger">*</span></label>
                            <input type="text" name="Name" class="form-control " id="name"
                                placeholder="أدخل اسم الموظف" value="{{ $staff->Name }}" required="">
                        </div>


                        <div class="form-group mb-3 text-right">

                            <label for="BirthDay">تاريخ الميلاد <span class="text-danger">*</span></label>
                            <input type="date" name="BirthDay" step="0.01" min="0" max="100"
                                class="form-control  text-right" id="name" placeholder="أدخل اسم الموظف"
                                value="{{ $staff->BirthDay }}" required="">
                        </div>


                        <div class="form-group mb-3 text-right">

                            <label for="Academic_qualification"> المؤهلات الدراسية <span
                                    class="text-danger">*</span></label>
                            <textarea type="text" name="Academic_qualification" class="form-control " id="name"
                                placeholder="أدخل اسم الموهل الدراسي" value="" required="">  {{ $staff->Academic_qualification }} </textarea>
                        </div>

                        <div class="form-group mb-3 text-right">

                            <label for="upload">أرفاق ملف </label>
                            <input type="file" name="upload" class="form-control  text-right" id="attach_File"
                                placeholder='أرفاق ملف' value="">
                        </div>



                        <div class="form-group mb-3 text-right">
                            <label for="Salary">المرتب</label>
                            <input type="text" name="Salary" class="form-control  text-right" id=""
                                placeholder="أدخل أجمالي المبلغ" value="{{ number_format($staff->Salary, 2) }}">
                        </div>


                        <div class="form-group mb-3 text-right">
                            <label for="Start_date">بداية التعاقد</label>
                            <input type="datetime-local" name="Start_date" class="form-control text-right" id="Start_date"
                                value="{{ old('Start_date', $staff->Start_date ? \Carbon\Carbon::parse($staff->Start_date)->format('Y-m-d\TH:i') : '') }}"
                                required>
                        </div>

                        <div class="form-group mb-3 text-right">
                            <label for="End_date">نهاية التعاقد</label>
                            <input type="datetime-local" name="End_date" class="form-control text-right" id="End_date"
                                value="{{ old('End_date', $staff->End_date ? \Carbon\Carbon::parse($staff->End_date)->format('Y-m-d\TH:i') : '') }}"
                                required>
                        </div>

            </div>
        </div>
        <div class="card-footer text-right">
            <button type="submit" class="btn btn-primary">حفظ البيانات</button>
        </div>
        </form>
        @endforeach
        </div>


        </div>
    </section>
@endsection
