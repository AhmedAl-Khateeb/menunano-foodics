@extends('layouts.app')

@section('title', 'إضافة منتج جاهز')

@section('main-content')
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    body, .font-cairo { font-family: 'Cairo', sans-serif !important; }
    .card-modern { border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    .section-title { font-size: 1.1rem; border-right: 4px solid #2563eb; padding-right: 12px; margin-bottom: 1.5rem; color: #333; text-align: right; }
    .form-control-modern { border-radius: 10px; border: 2px solid #edf2f7; padding: 0.6rem 1rem; transition: all 0.2s; text-align: right; direction: rtl; }
    .form-control-modern:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); outline: none; }
    .form-label { display: block; text-align: right; margin-bottom: 0.5rem; width: 100%; }
    .image-upload-wrapper { position: relative; width: 100%; height: 200px; border: 2px dashed #cbd5e0; border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden; background: #f8fafc; cursor: pointer; }
    .image-upload-wrapper:hover { border-color: #2563eb; }
    .image-preview { width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; display: none; }
    .btn-gradient { background: linear-gradient(135deg, #2563eb 0%, #4338ca 100%); color: white; border: none; border-radius: 10px; font-weight: 700; transition: transform 0.2s; }
    .btn-gradient:hover { transform: translateY(-2px); color: white; box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3); }
    .input-group { direction: ltr; } /* Keep currency symbol correctly positioned in LTR-style input but content is RTL */
    .input-group-text { border-radius: 10px 0 0 10px !important; border-right: none; }
    .form-control-modern.has-addon { border-radius: 0 10px 10px 0 !important; }
    .form-switch .form-check-input { float: right; margin-left: 0; margin-right: -2.5em; }
    .form-check-label { padding-right: 1rem; cursor: pointer; }
    .text-end { text-align: right !important; }
    .flex-row-reverse-rtl { flex-direction: row-reverse !important; }
    .ms-auto-rtl { margin-right: auto !important; margin-left: 0 !important; }
    .me-auto-rtl { margin-left: auto !important; margin-right: 0 !important; }
</style>

<div class="container-fluid py-4 font-cairo" dir="rtl">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4 rounded-lg" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4 rounded-lg" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold text-dark mb-1">إضافة منتج جاهز جديد</h3>
                    <p class="text-muted small">قم بتعبئة البيانات أدناه لتعريف منتجك الجديد في النظام.</p>
                </div>
                <a href="{{ route('inventory.ready.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fas fa-arrow-right me-1"></i> العودة للقائمة
                </a>
            </div>

            <form action="{{ route('inventory.ready.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row g-4">
                    {{-- Right Column: Basic Info --}}
                    <div class="col-lg-7">
                        <div class="card card-modern h-100">
                            <div class="card-body p-4">
                                <h6 class="section-title fw-bold">البيانات الأساسية</h6>
                                
                                <div class="mb-4">
                                    <label class="form-label fw-bold">اسم المنتج <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control form-control-modern @error('name') is-invalid @enderror" placeholder="مثال: بيبسي، كوكا كولا..." value="{{ old('name') }}" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-bold">القسم <span class="text-danger">*</span></label>
                                        <select name="category_id" class="form-select form-control-modern @error('category_id') is-invalid @enderror" required>
                                            <option value="">اختر القسم...</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-4" id="base-price-container">
                                        <label class="form-label fw-bold" id="base-price-label">سعر البيع الأساسي <span class="text-danger">*</span></label>
                                        <div class="input-group" style="direction: ltr;">
                                            <span class="input-group-text bg-light border-right-0">ج.م</span>
                                            <input type="number" step="0.01" name="price" id="base-price-input" class="form-control form-control-modern @error('price') is-invalid @enderror" style="border-radius: 0 10px 10px 0;" value="{{ old('price', 0) }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4 d-flex align-items-center gap-3 bg-light p-3 rounded-lg border-dashed">
                                    <div class="form-check form-switch fs-5 pb-0">
                                        <input class="form-check-input" type="checkbox" id="has-sizes-toggle" name="has_sizes" value="1" {{ old('has_sizes') ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold ms-2" for="has-sizes-toggle">هذا المنتج له أحجام مختلفة</label>
                                    </div>
                                    <small class="text-muted"><i class="fas fa-info-circle ms-1"></i> فعل هذا الخيار إذا كان المنتج يتوفر بأحجام (كبير، وسط، إلخ).</small>
                                </div>

                                <div class="mb-0">
                                    <label class="form-label fw-bold">وصف المنتج (اختياري)</label>
                                    <textarea name="description" class="form-control form-control-modern" rows="4" placeholder="اكتب تفاصيل المنتج هنا...">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Left Column: Media & Stock --}}
                    <div class="col-lg-5">
                        <div class="card card-modern mb-4">
                            <div class="card-body p-4 text-center">
                                <h6 class="section-title fw-bold text-end">صورة المنتج</h6>
                                <label for="cover-input" class="image-upload-wrapper mt-3">
                                    <div class="upload-placeholder">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                                        <p class="text-xs text-muted">اضغط لرفع الصورة (Max 2MB)</p>
                                    </div>
                                    <img id="cover-preview" class="image-preview">
                                </label>
                                <input type="file" id="cover-input" name="cover" class="d-none" accept="image/*">
                            </div>
                        </div>

                        <div class="card card-modern" id="main-stock-section">
                            <div class="card-body p-4">
                                <h6 class="section-title fw-bold">إعدادات المخزون</h6>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">وحدة القياس</label>
                                    <select name="unit_id" class="form-select form-control-modern">
                                        <option value="">اختر الوحدة...</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-0">
                                    <label class="form-label fw-bold">الرصيد الافتتاحي</label>
                                    <input type="number" step="0.001" name="current_quantity" id="main-stock-input" class="form-control form-control-modern" value="{{ old('current_quantity', 0) }}" placeholder="0.000">
                                    <p class="text-xs text-info mt-1 mb-0 text-end"><i class="fas fa-info-circle ms-1"></i> سيتم تعطيله إذا تم إضافة أحجام بالأسفل.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Bottom: Sizes --}}
                    <div class="col-12" id="sizes-section" style="display: none;">
                        <div class="card card-modern">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h6 class="section-title fw-bold mb-0">إدارة الأحجام والمخزون</h6>
                                    <button type="button" class="btn btn-sm btn-light border rounded-pill px-3" id="add-size-btn">
                                        <i class="fas fa-plus ms-1" style="color: #2563eb;"></i> إضافة حجم جديد
                                    </button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover align-middle border-top" id="sizes-table">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="py-3 px-4">اسم الحجم (مثال: Small)</th>
                                                <th class="py-3" style="width: 15%">سعر البيع</th>
                                                <th class="py-3" style="width: 15%">سعر التكلفة</th>
                                                <th class="py-3" style="width: 15%">الرصيد الافتتاحي</th>
                                                <th class="py-3" style="width: 20%">الوحدة</th>
                                                <th class="py-3 text-center" style="width: 5%">حذف</th>
                                            </tr>
                                        </thead>
                                        <tbody id="sizes-container">
                                            {{-- Dynamic Rows --}}
                                        </tbody>
                                    </table>
                                </div>
                                <div id="no-sizes-msg" class="text-center py-4 bg-light border-dashed rounded-lg mt-2">
                                    <p class="text-muted mb-0">لم يتم تعيين أحجام بعد. سيتم التعامل مع المنتج كقطعة واحدة.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-gradient px-5 py-3 fs-5">
                            <i class="fas fa-save me-2"></i> حفظ المنتج والبيانات
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const coverInput = document.getElementById('cover-input');
        const coverPreview = document.getElementById('cover-preview');
        const container = document.getElementById('sizes-container');
        const addBtn = document.getElementById('add-size-btn');
        const mainStockInput = document.getElementById('main-stock-input');
        const noSizesMsg = document.getElementById('no-sizes-msg');
        const hasSizesToggle = document.getElementById('has-sizes-toggle');
        const sizesSection = document.getElementById('sizes-section');
        const basePriceContainer = document.getElementById('base-price-container');
        const basePriceInput = document.getElementById('base-price-input');
        const mainStockSection = document.getElementById('main-stock-section'); // Using main-stock-section for the card
        let sizeIndex = 0;

        // Toggle Sizes Logic
        function toggleSizesMode() {
            if (hasSizesToggle.checked) {
                sizesSection.style.display = 'block';
                basePriceContainer.style.display = 'none';
                basePriceInput.required = false;
                mainStockSection.style.display = 'none'; // Hide the main stock section
                mainStockInput.required = false;
            } else {
                sizesSection.style.display = 'none';
                basePriceContainer.style.display = 'block';
                basePriceInput.required = true;
                mainStockSection.style.display = 'block'; // Show the main stock section
                mainStockInput.required = false; // Stock is optional if no sizes
            }
        }

        hasSizesToggle.addEventListener('change', toggleSizesMode);
        toggleSizesMode(); // Initial state

        // Image Preview
        coverInput.onchange = evt => {
            const [file] = coverInput.files;
            if (file) {
                coverPreview.src = URL.createObjectURL(file);
                coverPreview.style.display = 'block';
                document.querySelector('.upload-placeholder').style.display = 'none';
            }
        }

        function updateUI() {
            const rows = container.querySelectorAll('.size-row');
            if (rows.length > 0) {
                mainStockInput.disabled = true;
                mainStockInput.classList.add('bg-light');
                noSizesMsg.style.display = 'none';
            } else {
                mainStockInput.disabled = false;
                mainStockInput.classList.remove('bg-light');
                noSizesMsg.style.display = 'block';
            }
        }

        addBtn.addEventListener('click', function() {
            const row = document.createElement('tr');
            row.className = 'size-row';
            row.innerHTML = `
                <td class="px-4">
                    <input type="text" name="sizes[${sizeIndex}][size]" class="form-control form-control-modern" placeholder="كبير، وسط..." required>
                </td>
                <td>
                    <input type="number" step="0.01" name="sizes[${sizeIndex}][price]" class="form-control form-control-modern" value="0" required>
                </td>
                <td>
                    <input type="number" step="0.01" name="sizes[${sizeIndex}][cost]" class="form-control form-control-modern" value="0">
                </td>
                <td>
                    <input type="number" step="0.001" name="sizes[${sizeIndex}][quantity]" class="form-control form-control-modern" value="0">
                </td>
                <td>
                    <select name="sizes[${sizeIndex}][unit_id]" class="form-select form-control-modern">
                        <option value="">الافتراضية</option>
                        @foreach($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm border-0 remove-size-btn">
                        <i class="fas fa-trash-alt"></i>
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

        updateUI();
    });
</script>
@endpush
@endsection
