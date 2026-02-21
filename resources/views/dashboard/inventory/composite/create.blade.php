@extends('layouts.app')

@section('title', 'إضافة منتج مركب')

@section('main-content')
<div class="container-fluid py-4" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="font-weight-bold mb-0">إضافة منتج مركب جديد</h5>
                    <p class="text-muted small mb-0">المنتجات المركبة تتكون من عدة مكونات (مثل: سندوتش برجر، بيتزا).</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('inventory.composite.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label font-weight-bold text-end w-100">اسم المنتج</label>
                            <input type="text" name="name" 
                                   class="form-control form-control-lg border-2 shadow-none text-end @error('name') is-invalid @enderror" 
                                   placeholder="مثال: برجر لحم، بيتزا مارجريتا..." 
                                   value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback text-end">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label font-weight-bold text-end w-100">القسم</label>
                                <select name="category_id" class="form-select border-2 shadow-none text-end @error('category_id') is-invalid @enderror" required>
                                    <option value="">اختر القسم...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback text-end">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label font-weight-bold text-end w-100">سعر البيع</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="price" 
                                           class="form-control border-2 shadow-none text-end @error('price') is-invalid @enderror" 
                                           value="{{ old('price') }}" required placeholder="0.00">
                                    <span class="input-group-text border-2 bg-light">ج.م</span>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback text-end">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="alert alert-light border border-info border-2 rounded-3 text-end shadow-sm mb-4">
                            <div class="d-flex align-items-center gap-2 text-info">
                                <i class="fas fa-info-circle"></i>
                                <span class="font-weight-bold text-sm">ملاحظة هامة:</span>
                            </div>
                            <p class="text-xs text-muted mb-0 mt-1 me-4">
                                بعد حفظ البيانات الأساسية، سيتم توجيهك إلى شاشة <b>تكوين الوصفة</b> لإضافة المكونات واحتساب التكلفة.
                            </p>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('inventory.composite.index') }}" class="btn btn-link text-muted text-decoration-none">
                                <i class="fas fa-arrow-right ms-1"></i> إلغاء
                            </a>
                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">حفظ والمتابعة للوصفة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
