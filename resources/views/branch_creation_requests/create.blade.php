@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0">طلب إنشاء فرع جديد</h1> --}}
                </div>
            </div>
        </div>
    </div>

    <section class="content" dir="rtl">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="card card-primary">
                        <div class="card-header bg-dark text-white">
                            <h3 class="mb-0 text-center w-100">بيانات الفرع المطلوب إنشاؤه</h3>
                        </div>

                        <form method="POST" action="{{ route('branch-creation-requests.store') }}">
                            @csrf

                            <div class="card-body text-right">

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="alert alert-info text-center">
                                    <i class="fas fa-info-circle ml-1"></i>
                                    سيتم إرسال الطلب إلى السوبر أدمن للمراجعة والموافقة قبل إنشاء الفرع فعليًا.
                                </div>

                                <div class="form-group">
                                    <label for="branch_name">اسم الفرع <span class="text-danger">*</span></label>
                                    <input type="text" name="branch_name" id="branch_name" class="form-control"
                                        placeholder="مثال: فرع التجمع" value="{{ old('branch_name') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="branch_code">كود الفرع</label>
                                    <input type="text" name="branch_code" id="branch_code" class="form-control"
                                        placeholder="مثال: BR-002" value="{{ old('branch_code') }}">
                                </div>

                                <div class="form-group">
                                    <label for="phone">هاتف الفرع</label>
                                    <input type="text" name="phone" id="phone" class="form-control"
                                        placeholder="أدخل رقم هاتف الفرع" value="{{ old('phone') }}">
                                </div>

                                <div class="form-group">
                                    <label for="address">عنوان الفرع</label>
                                    <input type="text" name="address" id="address" class="form-control"
                                        placeholder="أدخل عنوان الفرع" value="{{ old('address') }}">
                                </div>




                            </div>
                            <div class="card-footer clearfix">
                                <button type="submit" class="btn btn-primary float-right">
                                    <i class="fas fa-paper-plane ml-1"></i>
                                    إرسال الطلب
                                </button>

                                <a href="{{ route('branch-creation-requests.index') }}" class="btn btn-danger float-left">
                                    إلغاء
                                </a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
