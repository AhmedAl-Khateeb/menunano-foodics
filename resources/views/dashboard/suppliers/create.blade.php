@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">إضافة مورد جديد</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('suppliers.index') }}">الموردين</a></li>
                        <li class="breadcrumb-item active">إضافة مورد</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card card-primary border-0 shadow-sm rounded-lg">
                        <div class="card-header bg-white border-bottom text-right">
                            <h3 class="card-title font-weight-bold text-dark mb-0 py-1 float-right">بيانات المورد الأساسية</h3>
                        </div>
                        <form action="{{ route('suppliers.store') }}" method="POST">
                            @csrf
                            <div class="card-body bg-light text-right">
                                <div class="row">
                                    <div class="col-md-12 form-group mb-3 text-right">
                                        <label for="name" class="font-weight-bold">الاسم <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control bg-white @error('name') is-invalid @enderror" id="name" placeholder="أدخل اسم المورد أو الشركة" value="{{ old('name') }}" required>
                                        @error('name') <span class="text-danger small font-weight-bold">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div class="col-md-6 form-group mb-3 text-right">
                                        <label for="phone" class="font-weight-bold">رقم الهاتف</label>
                                        <input type="text" name="phone" class="form-control bg-white @error('phone') is-invalid @enderror" id="phone" placeholder="أدخل رقم الهاتف" value="{{ old('phone') }}">
                                        @error('phone') <span class="text-danger small font-weight-bold">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-6 form-group mb-3 text-right">
                                        <label for="email" class="font-weight-bold">البريد الإلكتروني</label>
                                        <input type="email" name="email" class="form-control bg-white @error('email') is-invalid @enderror" id="email" placeholder="example@email.com" value="{{ old('email') }}">
                                        @error('email') <span class="text-danger small font-weight-bold">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-12 form-group mb-3 text-right">
                                        <label for="address" class="font-weight-bold">العنوان التفصيلي</label>
                                        <textarea name="address" class="form-control bg-white @error('address') is-invalid @enderror" id="address" rows="2" placeholder="أدخل عنوان المورد">{{ old('address') }}</textarea>
                                        @error('address') <span class="text-danger small font-weight-bold">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-12 form-group mb-3 text-right">
                                        <label label="balance" class="font-weight-bold">الرصيد الافتتاحي (ج.م)</label>
                                        <div class="input-group">
                                            <input type="number" step="0.01" name="balance" class="form-control bg-white @error('balance') is-invalid @enderror text-right" id="balance" placeholder="0.00" value="{{ old('balance', 0) }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text bg-white">ج.م</span>
                                            </div>
                                        </div>
                                        <small class="text-muted block mt-1"><i class="fas fa-info-circle"></i> أدخل قيمة موجبة إذا كان المورد دائن (له فلوس)، أو قيمة سالبة إذا كان مدين (عليه فلوس).</small>
                                        @error('balance') <span class="text-danger small font-weight-bold">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-md-12 form-group mb-0 mt-2 text-right">
                                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                                            <label class="custom-control-label font-weight-bold" style="cursor: pointer" for="is_active">تفعيل حساب المورد (يمكن التعامل معه)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-top text-right py-3">
                                <a href="{{ route('suppliers.index') }}" class="btn btn-light border font-weight-bold px-4 ml-2">إلغاء</a>
                                <button type="submit" class="btn btn-primary font-weight-bold px-4 shadow-sm"><i class="fas fa-save mr-1"></i> حفظ البيانات</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
