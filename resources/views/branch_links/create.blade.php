@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1 class="m-0">إضافة ربط بين فرعين</h1> --}}
                </div>
            </div>
        </div>
    </div>

    <section class="content" dir="rtl">
        <div class="container-fluid">

            <div class="card card-primary">
                <div class="card-header bg-dark text-white">
                    <h3 class="mb-0 text-center w-100">
                        إضافة ربط بين فرعين
                    </h3>
                </div>

                <form method="POST" action="{{ route('branch-links.store') }}">
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

                        <div class="form-group">
                            <label>من فرع <span class="text-danger">*</span></label>
                            <select name="from_branch_id" class="form-control" required>
                                <option value="">-- اختر الفرع المصدر --</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                        {{ old('from_branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }} - {{ $branch->code ?? 'بدون كود' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>إلى فرع <span class="text-danger">*</span></label>
                            <select name="to_branch_id" class="form-control" required>
                                <option value="">-- اختر الفرع الهدف --</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}"
                                        {{ old('to_branch_id') == $branch->id ? 'selected' : '' }}>
                                        {{ $branch->name }} - {{ $branch->code ?? 'بدون كود' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>نوع الربط <span class="text-danger">*</span></label>
                            <select name="type" class="form-control" required>
                                <option value="linked" {{ old('type') == 'linked' ? 'selected' : '' }}>
                                    ربط إداري عام
                                </option>
                                <option value="inventory_transfer"
                                    {{ old('type') == 'inventory_transfer' ? 'selected' : '' }}>
                                    تحويل مخزون
                                </option>
                                <option value="shared_reports" {{ old('type') == 'shared_reports' ? 'selected' : '' }}>
                                    مشاركة تقارير
                                </option>
                                <option value="main_sub_branch" {{ old('type') == 'main_sub_branch' ? 'selected' : '' }}>
                                    فرع رئيسي وتابع
                                </option>
                            </select>
                        </div>

                        <div class="border rounded p-3 bg-light">
                            <label class="d-flex align-items-center justify-content-start mb-0">
                                <input type="checkbox" name="is_active" value="1"
                                    {{ old('is_active', 1) ? 'checked' : '' }} style="margin-left: 8px;">
                                <span>الربط نشط</span>
                            </label>
                        </div>

                        <div class="alert alert-info mt-3 mb-0 text-center">
                            <i class="fas fa-info-circle ml-1"></i>
                            لا يمكن ربط الفرع بنفسه. ويمكن استخدام نوع الربط لاحقًا في التحويلات أو التقارير.
                        </div>
                    </div>

                    <div class="card-footer clearfix">
                        <button type="submit" class="btn btn-primary float-right">
                            <i class="fas fa-link ml-1"></i>
                            حفظ الربط
                        </button>

                        <a href="{{ route('branch-links.index') }}" class="btn btn-danger float-left">
                            إلغاء
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </section>
@endsection
