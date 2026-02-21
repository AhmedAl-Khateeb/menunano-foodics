@extends('layouts.app')

@section('title', 'تعديل منتج مركب')

@section('main-content')
<div class="container-fluid py-4" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="font-weight-bold mb-0">تعديل منتج مركب</h5>
                        <p class="text-muted small mb-0">يمكنك تعديل البيانات الأساسية هنا.</p>
                    </div>
                    <a href="{{ route('inventory.composite.recipe.edit', $product->id) }}" class="btn btn-warning btn-sm fw-bold">
                        <i class="fas fa-utensils ms-1"></i> تعديل الوصفة (Recipe)
                    </a>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('inventory.composite.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="form-label font-weight-bold text-end w-100">اسم المنتج</label>
                            <input type="text" name="name" 
                                   class="form-control form-control-lg border-2 shadow-none text-end @error('name') is-invalid @enderror" 
                                   placeholder="مثال: برجر لحم، بيتزا مارجريتا..." 
                                   value="{{ old('name', $product->name) }}" required>
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
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
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
                                           value="{{ old('price', $product->price) }}" required placeholder="0.00">
                                    <span class="input-group-text border-2 bg-light">ج.م</span>
                                </div>
                                @error('price')
                                    <div class="invalid-feedback text-end">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Sizes Section --}}
                        <hr class="my-4 border-secondary opacity-10">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="font-weight-bold mb-0 text-end text-primary">
                                <i class="fas fa-ruler-combined ms-2"></i> أحجام المنتج
                            </h6>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="add-size-btn">
                                <i class="fas fa-plus ms-1"></i> إضافة حجم
                            </button>
                        </div>
                        
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered align-middle text-end" dir="rtl" id="sizes-table">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-end">الحجم</th>
                                        <th class="text-end" style="width: 25%">السعر (للكاشير)</th>
                                        <th class="text-end" style="width: 10%">حذف</th>
                                    </tr>
                                </thead>
                                <tbody id="sizes-container">
                                    @foreach($product->sizes as $index => $size)
                                        <tr class="size-row">
                                            <td>
                                                <input type="text" name="sizes[{{ $index }}][size]" 
                                                       class="form-control form-control-sm border-2 shadow-none text-end" 
                                                       value="{{ $size->size }}" placeholder="مثال: كبير، وسط" required>
                                                <input type="hidden" name="sizes[{{ $index }}][id]" value="{{ $size->id }}">
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <input type="number" step="0.01" name="sizes[{{ $index }}][price]" 
                                                           class="form-control border-2 shadow-none text-end" 
                                                           value="{{ $size->price }}" placeholder="0.00" required>
                                                    <span class="input-group-text border-2 bg-light">ج.م</span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if($loop->first && $product->sizes->count() == 1)
                                                    <button type="button" class="btn btn-sm btn-light text-muted" disabled>
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-outline-danger remove-size-btn">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($product->sizes->isEmpty())
                            <div class="alert alert-info border-2 border-info small text-end" id="no-sizes-alert">
                                <i class="fas fa-info-circle ms-1"></i>
                                لا توجد أحجام مضافة لهذا المنتج حالياً. السعر الأساسي هو المستخدم.
                            </div>
                        @endif

                        <div class="alert alert-light border small text-end mb-4">
                            <i class="fas fa-lightbulb text-warning ms-1"></i>
                            <strong>ملاحظة:</strong> بعد حفظ الأحجام، ستتمكن من تحديد مكونات (Recipe) مختلفة لكل حجم من صفحة "تعديل الوصفة".
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('inventory.composite.index') }}" class="btn btn-link text-muted text-decoration-none">
                                <i class="fas fa-arrow-right ms-1"></i> إلغاء
                            </a>
                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold">حفظ التعديلات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('sizes-container');
        const addBtn = document.getElementById('add-size-btn');
        const noSizesAlert = document.getElementById('no-sizes-alert');
        let sizeIndex = {{ $product->sizes->count() }};

        addBtn.addEventListener('click', function() {
            const row = document.createElement('tr');
            row.className = 'size-row';
            row.innerHTML = `
                <td>
                    <input type="text" name="sizes[${sizeIndex}][size]" 
                           class="form-control form-control-sm border-2 shadow-none text-end" 
                           placeholder="مثال: كبير، وسط" required>
                </td>
                <td>
                    <div class="input-group input-group-sm">
                        <input type="number" step="0.01" name="sizes[${sizeIndex}][price]" 
                               class="form-control border-2 shadow-none text-end" 
                               placeholder="0.00" required>
                        <span class="input-group-text border-2 bg-light">ج.م</span>
                    </div>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-size-btn">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            container.appendChild(row);
            sizeIndex++;
            updateUI();
        });

        container.addEventListener('click', function(e) {
            if (e.target.closest('.remove-size-btn')) {
                e.target.closest('tr').remove();
                updateUI();
            }
        });

        function updateUI() {
            const rows = container.querySelectorAll('.size-row');
            if (rows.length === 0) {
                if (noSizesAlert) noSizesAlert.style.display = 'block';
            } else {
                if (noSizesAlert) noSizesAlert.style.display = 'none';
            }
        }
    });
</script>
@endpush
@endsection
