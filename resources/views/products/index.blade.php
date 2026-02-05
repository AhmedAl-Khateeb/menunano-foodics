@extends('layouts.app')

@section('main-content')
<div class="container my-5">
    <div class="card shadow-lg rounded-lg">
        <div class="card-header bg-gradient-primary text-white d-flex flex-wrap justify-content-between align-items-center gap-3">
            <h3 class="card-title mb-0 font-weight-bold" style="letter-spacing: 1px;">قائمة المنتجات</h3>

            <button type="button" class="btn btn-light btn-sm shadow-sm px-4" data-toggle="modal" data-target="#desc-add">
                <i class="fa fa-plus mr-1"></i> إضافة جديد
            </button>

            <form action="{{ route('products.index') }}" method="GET" class="d-flex gap-2 align-items-center flex-wrap">
                <select name="category" class="form-control form-select-lg shadow-sm" required style="min-width: 180px;">
                    <option value="" disabled selected>اختر فئة</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if(request('category') == $category->id) selected @endif>{{ $category->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary px-4">بحث</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm shadow-sm px-4">إعادة تعيين</a>
            </form>
        </div>

        {{-- مودال الإضافة --}}
        <div class="modal fade" id="desc-add" tabindex="-1" aria-labelledby="descAddLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-lg shadow">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="modal-header border-0">
                            <h5 class="modal-title" id="descAddLabel">إضافة منتج جديد</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                                <span aria-hidden="true" style="font-size: 1.5rem;">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-dark">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name">الاسم</label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required autofocus>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="description">الوصف</label>
                                    <input type="textarea" name="description" id="description" class="form-control @error('description') is-invalid @enderror">
                                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="category_id">الفئة</label>
                                    <select name="category_id" id="category_id" class="form-control form-select-lg shadow-sm @error('category_id') is-invalid @enderror" required>
                                        <option value="" disabled selected>اختر فئة</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
    <label for="price">السعر (اختياري)</label>
    <input type="number" name="price" id="price"
           class="form-control @error('price') is-invalid @enderror"
           step="0.01" min="0" value="{{ old('price') }}">
    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

                                <div class="col-md-6 mb-3">
                                    <label for="cover">الصورة الرئيسية</label>
                                    <input type="file" name="cover" id="cover" class="form-control @error('cover') is-invalid @enderror" required accept="image/*">
                                    @error('cover') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <hr>
                            <h5>إضافة الأحجام</h5>
                            <div id="sizes-wrapper">
                                <div class="row size-item mb-2">
                                    <div class="col-md-4">
                                        <input type="text" name="sizes[0][size]" class="form-control" placeholder="الحجم" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="sizes[0][price]" class="form-control" placeholder="السعر" required>
                                    </div>
                                    <div class="col-md-1 d-flex align-items-center">
                                        <button type="button" class="btn btn-danger btn-sm remove-size" disabled>&times;</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="add-size" class="btn btn-secondary btn-sm mt-2">+ إضافة حجم آخر</button>
                        </div>
                        <div class="modal-footer border-0 justify-content-between">
                            <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">إغلاق</button>
                            <button type="submit" class="btn btn-success px-4">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- جدول المنتجات --}}
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover text-center align-middle mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 18%;">الاسم</th>
                            <th style="width: 22%;">الوصف</th>
                            <th style="width: 13%;">الفئة</th>
                            <th style="width:10%;">السعر</th>
                            <th style="width: 14%;">الصورة</th>
                            <th style="width: 20%;">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr class="bg-white shadow-sm rounded-lg">
                                <td>{{ $loop->iteration }}</td>
                                <td class="font-weight-bold text-primary">{{ $product->name }}</td>
                                <td>{{ Str::limit($product->description, 50) ?? '—' }}</td>
                                <td>
                                    @if($product->category)
                                        <span class="badge badge-info">{{ $product->category->name }}</span>
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>
    {{ $product->price !== null ? number_format($product->price, 2) . '' : '—' }}
</td>

                                <td>
                                    @if($product->cover)
                                        <img src="{{ asset('storage/'.$product->cover) }}" alt="Cover Image" class="img-thumbnail rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- زر التعديل --}}
                                    <button type="button" class="btn btn-outline-success btn-sm mr-2 mb-1" data-toggle="modal" data-target="#edit{{ $product->id }}">
                                        <i class="fa fa-edit"></i> تعديل
                                    </button>

                                    {{-- مودال التعديل --}}
                                    <div class="modal fade" id="edit{{ $product->id }}" tabindex="-1" aria-labelledby="editLabel{{ $product->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content rounded-lg shadow">
                                                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header border-0">
                                                        <h5 class="modal-title" id="editLabel{{ $product->id }}">تعديل المنتج</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                                                            <span aria-hidden="true" style="font-size: 1.5rem;">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-dark">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label for="name-{{ $product->id }}">الاسم</label>
                                                                <input type="text" name="name" id="name-{{ $product->id }}" value="{{ old('name', $product->name) }}" class="form-control @error('name') is-invalid @enderror" required autofocus>
                                                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="description-{{ $product->id }}">الوصف</label>
                                                                <input type="textarea" name="description" id="description-{{ $product->id }}" value="{{ old('description', $product->description) }}" class="form-control @error('description') is-invalid @enderror">
                                                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="category_id-{{ $product->id }}">الفئة</label>
                                                                <select name="category_id" id="category_id-{{ $product->id }}" class="form-control form-select-lg shadow-sm @error('category_id') is-invalid @enderror" required>
                                                                    @foreach ($categories as $category)
                                                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                                            {{ $category->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                            </div>
                                                            <div class="col-md-6 mb-3">
    <label for="price-{{ $product->id }}">السعر (اختياري)</label>
    <input type="number" name="price" id="price-{{ $product->id }}"
           class="form-control @error('price') is-invalid @enderror"
           step="0.01" min="0"
           value="{{ old('price', $product->price) }}">
    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

                                                            <div class="col-md-6 mb-3">
                                                                <label for="cover-{{ $product->id }}">الصورة (اتركها فارغة للاحتفاظ بالصورة الحالية)</label>
                                                                <input type="file" name="cover" id="cover-{{ $product->id }}" class="form-control @error('cover') is-invalid @enderror" accept="image/*">
                                                                @error('cover') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                            </div>
                                                        </div>

                                                        <hr>
                                                        <h5>تعديل الأحجام</h5>
                                                        <div id="sizes-wrapper-{{ $product->id }}">
                                                            @foreach ($product->sizes as $i => $size)
                                                                <div class="row size-item mb-2">
                                                                    <div class="col-md-4">
                                                                        <input type="text" name="sizes[{{ $i }}][size]" class="form-control" value="{{ $size->size }}" placeholder="الحجم" required>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <input type="text" name="sizes[{{ $i }}][price]" class="form-control" value="{{ $size->price }}" placeholder="السعر" required>
                                                                    </div>
                                                                    <div class="col-md-1 d-flex align-items-center">
                                                                        <button type="button" class="btn btn-danger btn-sm remove-size">&times;</button>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <button type="button" class="btn btn-secondary btn-sm mt-2 add-size-btn" data-target="#sizes-wrapper-{{ $product->id }}">+ إضافة حجم آخر</button>
                                                    </div>
                                                    <div class="modal-footer border-0 justify-content-between">
                                                        <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">إغلاق</button>
                                                        <button type="submit" class="btn btn-success px-4">تحديث</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- زر الحذف --}}
                                    <x-model name="delete-{{ $product->id }}" status="danger" icon="fa fa-trash" title="حذف" message="هل أنت متأكد من حذف {{ $product->name }}؟">
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm px-3">نعم، احذف</button>
                                        </form>
                                    </x-model>

                                    {{-- زر العرض --}}
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-info btn-sm ml-1 mb-1">
                                        <i class="fa fa-eye"></i> عرض
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">لا توجد منتجات لعرضها.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </div>
</div>

<style>
    .bg-gradient-primary {
        background: linear-gradient(45deg, #007bff, #0056b3);
    }
    .table-hover tbody tr:hover {
        background: #e9f0ff !important;
        transition: background-color 0.3s ease;
    }
    .shadow-sm {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .btn-outline-success:hover {
        background-color: #28a745;
        color: #fff;
    }
    .btn-outline-info:hover {
        background-color: #17a2b8;
        color: #fff;
    }
    .btn-danger {
        border-radius: 25px;
        padding: 5px 15px;
        font-weight: 600;
    }
    .btn-light {
        border-radius: 25px;
        padding: 5px 15px;
        font-weight: 600;
    }
    .card {
        border-radius: 15px;
    }
    .card-header {
        border-radius: 15px 15px 0 0;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    let sizeIndex = 1;

    // إضافة حجم جديد في مودال الإضافة
    $('#add-size').click(function() {
        $('#sizes-wrapper').append(`
            <div class="row size-item mb-2">
                <div class="col-md-4">
                    <input type="text" name="sizes[${sizeIndex}][size]" class="form-control" placeholder="الحجم" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="sizes[${sizeIndex}][price]" class="form-control" placeholder="السعر" required>
                </div>
                <div class="col-md-1 d-flex align-items-center">
                    <button type="button" class="btn btn-danger btn-sm remove-size">&times;</button>
                </div>
            </div>
        `);
        sizeIndex++;
    });

    // إزالة حجم عند الضغط على زر الحذف (في الإضافة والتعديل)
    $(document).on('click', '.remove-size', function() {
        $(this).closest('.size-item').remove();
    });

    // إضافة حجم جديد في مودالات التعديل
    $('.add-size-btn').click(function() {
        const targetId = $(this).data('target');
        const wrapper = $(targetId);
        let newIndex = wrapper.find('.size-item').length;

        wrapper.append(`
            <div class="row size-item mb-2">
                <div class="col-md-4">
                    <input type="text" name="sizes[${newIndex}][size]" class="form-control" placeholder="الحجم" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="sizes[${newIndex}][price]" class="form-control" placeholder="السعر" required>
                </div>
                <div class="col-md-1 d-flex align-items-center">
                    <button type="button" class="btn btn-danger btn-sm remove-size">&times;</button>
                </div>
            </div>
        `);
    });
</script>
@endsection