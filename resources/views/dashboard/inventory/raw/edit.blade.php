@extends('layouts.app')

@section('title', 'تعديل مادة خام')

@section('main-content')
<div class="container-fluid py-4" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="font-weight-bold mb-0">تعديل مادة خام</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('inventory.raw.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">اسم المادة الخام</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">القسم (اختياري)</label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                    <option value="">اختر القسم...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">سعر الشراء</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror" value="{{ old('purchase_price', $product->inventory->purchase_price ?? 0) }}" required>
                                    <span class="input-group-text">ج</span>
                                </div>
                                <small class="text-muted">هذا السعر يستخدم لحساب تكلفة الوصفات.</small>
                                @error('purchase_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label font-weight-bold">وحدة الشراء</label>
                                <select name="purchase_unit_id" class="form-select @error('purchase_unit_id') is-invalid @enderror" required>
                                    <option value="">اختر الوحدة...</option>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->id }}" {{ old('purchase_unit_id', $product->inventory->purchase_unit_id ?? '') == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                                @error('purchase_unit_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="alert alert-warning border-0 shadow-sm mt-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            لتعديل الكمية المخزنية، يرجى استخدام زر "تعديل المخزون" (تسوية) من القائمة الرئيسية.
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('inventory.raw.index') }}" class="btn btn-light">إلغاء</a>
                            <button type="submit" class="btn btn-primary px-4">حفظ التعديلات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
