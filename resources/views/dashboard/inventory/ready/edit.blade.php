@extends('layouts.app')

@section('title', 'تعديل منتج جاهز')

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
    .image-preview { width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; }
    .btn-gradient { background: linear-gradient(135deg, #2563eb 0%, #4338ca 100%); color: white; border: none; border-radius: 10px; font-weight: 700; transition: transform 0.2s; }
    .btn-gradient:hover { transform: translateY(-2px); color: white; box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3); }
    .input-group { direction: ltr; }
    .input-group-text { border-radius: 10px 0 0 10px !important; border-right: none; }
    .form-control-modern.has-addon { border-radius: 0 10px 10px 0 !important; }
    .form-switch .form-check-input { float: right; margin-left: 0; margin-right: -2.5em; }
    .form-check-label { padding-right: 1rem; cursor: pointer; }
    .text-end { text-align: right !important; }
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
                    <h3 class="fw-bold text-dark mb-1">تعديل المنتج: {{ $product->name }}</h3>
                    <p class="text-muted small">قم بتحديث بيانات ومواصفات المنتج أدناه.</p>
                </div>
                <a href="{{ route('inventory.ready.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fas fa-arrow-right me-1"></i> العودة للقائمة
                </a>
            </div>

            <form action="{{ route('inventory.ready.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row g-4">
                    {{-- Right Column: Basic Info --}}
                    <div class="col-lg-7">
                        <div class="card card-modern h-100">
                            <div class="card-body p-4">
                                <h6 class="section-title fw-bold">البيانات الأساسية</h6>
                                
                                <div class="mb-4">
                                    <label class="form-label fw-bold">اسم المنتج <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control form-control-modern @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-bold">القسم <span class="text-danger">*</span></label>
                                        <select name="category_id" class="form-select form-control-modern @error('category_id') is-invalid @enderror" required>
                                            <option value="">اختر القسم...</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-4" id="base-price-container">
                                        <label class="form-label fw-bold">سعر البيع الأساسي <span class="text-danger">*</span></label>
                                        <div class="input-group" style="direction: ltr;">
                                            <span class="input-group-text bg-light border-right-0">ج.م</span>
                                            <input type="number" step="0.01" name="price" id="base-price-input" class="form-control form-control-modern @error('price') is-invalid @enderror" style="border-radius: 0 10px 10px 0;" value="{{ old('price', $product->price) }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4 d-flex align-items-center gap-3 bg-light p-3 rounded-lg border-dashed">
                                    <div class="form-check form-switch fs-5 pb-0">
                                        <input class="form-check-input" type="checkbox" id="has-sizes-toggle" name="has_sizes" value="1" {{ old('has_sizes', $product->sizes->count() > 0) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold ms-2" for="has-sizes-toggle">هذا المنتج له أحجام مختلفة</label>
                                    </div>
                                    <small class="text-muted"><i class="fas fa-info-circle ms-1"></i> فعل هذا الخيار إذا كان المنتج يتوفر بأحجام (كبير، وسط، إلخ).</small>
                                </div>

                                <div class="mb-0">
                                    <label class="form-label fw-bold">وصف المنتج (اختياري)</label>
                                    <textarea name="description" class="form-control form-control-modern" rows="4" placeholder="اكتب تفاصيل المنتج هنا...">{{ old('description', $product->description) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Left Column: Media & Actions --}}
                    <div class="col-lg-5">
                        <div class="card card-modern mb-4">
                            <div class="card-body p-4 text-center">
                                <h6 class="section-title fw-bold text-end">صورة المنتج</h6>
                                <label for="cover-input" class="image-upload-wrapper mt-3">
                                    @if($product->cover)
                                        <img id="cover-preview" src="{{ asset('storage/' . $product->cover) }}" class="image-preview">
                                        <div class="upload-placeholder d-none">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                                            <p class="text-xs text-muted">اضغط لتغيير الصورة</p>
                                        </div>
                                    @else
                                        <div class="upload-placeholder">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                                            <p class="text-xs text-muted">اضغط لرفع الصورة</p>
                                        </div>
                                        <img id="cover-preview" class="image-preview" style="display: none;">
                                    @endif
                                </label>
                                <input type="file" id="cover-input" name="cover" class="d-none" accept="image/*">
                            </div>
                        </div>

                        <div class="card card-modern border-warning border-start border-4">
                            <div class="card-body p-4">
                                <h6 class="section-title fw-bold">تحويل المنتج</h6>
                                <p class="text-xs text-muted mb-3 text-end">يمكنك تحويل هذا المنتج إلى "منتج مركب" لإدارة وصفته ومكوناته يدوياً.</p>
                                <button type="button" onclick="if(confirm('هل أنت متأكد من تحويل هذا المنتج؟')) document.getElementById('convertForm').submit()" class="btn btn-outline-warning w-100 fw-bold">
                                    <i class="fas fa-exchange-alt ms-2"></i> تحويل إلى منتج مركب
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Bottom: Sizes --}}
                    <div class="col-12" id="sizes-section" style="{{ $product->sizes->count() > 0 ? '' : 'display: none;' }}">
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
                                                <th class="py-3 px-4">اسم الحجم</th>
                                                <th class="py-3" style="width: 15%">سعر البيع</th>
                                                <th class="py-3" style="width: 15%">سعر التكلفة</th>
                                                <th class="py-3" style="width: 15%">المخزون الحالي</th>
                                                <th class="py-3" style="width: 20%">الوحدة</th>
                                                <th class="py-3 text-center" style="width: 5%">حذف</th>
                                            </tr>
                                        </thead>
                                        <tbody id="sizes-container">
                                            @php $index = 0; @endphp
                                            @foreach($product->sizes as $size)
                                                <tr class="size-row">
                                                    <td class="px-4">
                                                        <input type="text" name="sizes[{{ $index }}][size]" class="form-control form-control-modern" value="{{ $size->size }}" required>
                                                        <input type="hidden" name="sizes[{{ $index }}][id]" value="{{ $size->id }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" name="sizes[{{ $index }}][price]" class="form-control form-control-modern" value="{{ $size->price }}" required>
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" name="sizes[{{ $index }}][cost]" class="form-control form-control-modern" value="{{ $size->inventory->purchase_price ?? 0 }}">
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.001" name="sizes[{{ $index }}][quantity]" class="form-control form-control-modern" value="{{ $size->inventory->current_quantity ?? 0 }}">
                                                    </td>
                                                    <td>
                                                        <select name="sizes[{{ $index }}][unit_id]" class="form-select form-control-modern">
                                                            <option value="">الافتراضية</option>
                                                            @foreach($units as $unit)
                                                                <option value="{{ $unit->id }}" {{ ($size->inventory->purchase_unit_id ?? '') == $unit->id ? 'selected' : '' }}>
                                                                    {{ $unit->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-outline-danger btn-sm border-0 remove-size-btn">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @php $index++; @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if($product->sizes->isEmpty())
                                    <div id="no-sizes-msg" class="text-center py-4 bg-light border-dashed rounded-lg mt-2">
                                        <p class="text-muted mb-0">لا توجد أحجام لهذا المنتج. يتم التعامل معه كوحدة واحدة بالسعر الأساسي.</p>
                                    </div>
                                @endif
                                
                                <div class="alert alert-light border small text-end mt-4">
                                    <i class="fas fa-info-circle text-info ms-1"></i>
                                    عند وجود أحجام، سيتم استخدام أسعارها ومخزونها وتجاهل القيم الأساسية في الأعلى.
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-gradient px-5 py-3 fs-5">
                            <i class="fas fa-save me-2"></i> حفظ التغييرات والبيانات
                        </button>
                    </div>
                </div>
            </form>

            {{-- Hidden conversion form --}}
            <form id="convertForm" action="{{ route('inventory.ready.convert', $product->id) }}" method="POST" style="display: none;">
                @csrf
                @method('PUT')
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
        const hasSizesToggle = document.getElementById('has-sizes-toggle');
        const sizesSection = document.getElementById('sizes-section');
        const basePriceContainer = document.getElementById('base-price-container');
        const basePriceInput = document.getElementById('base-price-input');
        let sizeIndex = {{ $product->sizes->count() }};

        // Toggle Sizes Logic
        function toggleSizesMode() {
            if (hasSizesToggle.checked) {
                sizesSection.style.display = 'block';
                basePriceContainer.style.display = 'none';
                basePriceInput.required = false;
            } else {
                sizesSection.style.display = 'none';
                basePriceContainer.style.display = 'block';
                basePriceInput.required = true;
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
                const placeholder = document.querySelector('.upload-placeholder');
                if(placeholder) placeholder.style.display = 'none';
            }
        }

        addBtn.addEventListener('click', function() {
            const row = document.createElement('tr');
            row.className = 'size-row';
            row.innerHTML = `
                <td class="px-4">
                    <input type="text" name="sizes[${sizeIndex}][size]" class="form-control form-control-modern" placeholder="مثال: كبير" required>
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
            const noMsg = document.getElementById('no-sizes-msg');
            if(noMsg) noMsg.style.display = 'none';
            sizeIndex++;
        });

        container.addEventListener('click', function(e) {
            if (e.target.closest('.remove-size-btn')) {
                e.target.closest('tr').remove();
                if(container.querySelectorAll('.size-row').length === 0) {
                    const noMsg = document.getElementById('no-sizes-msg');
                    if(noMsg) noMsg.style.display = 'block';
                }
            }
        });
    });
</script>
@endpush
@endsection
