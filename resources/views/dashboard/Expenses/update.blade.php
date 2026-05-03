@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">إضافة مصروفات</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                        @foreach ($expenses as $expense)
                            <li class="breadcrumb-item"><a href="{{ route('expenses.update', $expense->id) }}">تعديل بيانات
                                    مصروفات </a></li>
                        @endforeach
                        <li class="breadcrumb-item active">تعديل بيانات المصروف </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="card card-primary">
                <div class="card-header text-right">
                    <h3 class="card-title float-right">تعديل بيانات مصروفات </h3>
                </div>

                @foreach ($expenses as $expense)
                    <form action="{{ route('expenses.update', $expense->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3 text-right">
                            <label for="name">أسم مصروف <span class="text-danger">*</span></label>
                            <input type="text" name="expanse_name" class="form-control " id="name"
                                placeholder="أدخل اسم المصروف" value="{{ $expense->TITLE }}" required="">
                        </div>

                        <div class="form-group mb-3 text-right">

                            <label for="upload">أرفاق ملف </label>
                            <input type="file" name="upload" class="form-control  text-right" id="attach_File"
                                placeholder='أرفاق ملف' value="">
                        </div>



                        <div class="form-group mb-3 text-right">
                            <label for="Amount">المبلغ</label>
                            <input type="text" name="Amount" class="form-control  text-right" id="Amount"
                                placeholder="أدخل أجمالي المبلغ" value="{{ $expense->Amount }}">
                        </div>


                        <div class="form-group mb-3 text-right">
                            <label for="notes"> ملاحظات </label>
                            <textarea type="textarea" name="notes" step="0.01" min="0" max="100" class="form-control  text-right"
                                id="commission_percent" placeholder="أدخل نسبة العمولة" value="0">
                    </textarea>
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
