@extends('layouts.app')

@section('main-content')
    <div class="container my-5">
        <div class="card shadow-lg rounded-lg">
            <div
                class="card-header bg-gradient-primary text-white d-flex flex-wrap justify-content-between align-items-center gap-3">
                <h3 class="card-title mb-0 font-weight-bold" style="letter-spacing: 1px;">قائمة المنتجات</h3>

                <button type="button" class="btn btn-light btn-sm shadow-sm px-4" data-toggle="modal" data-target="#desc-add">
                    <i class="fa fa-plus mr-1"></i> إضافة جديد
                </button>

                {{-- <a href="{{ route('products.barcodes.print') }}" target="_blank" class="btn btn-dark">
                    طباعة باركود المنتجات
                </a> --}}

                <form action="{{ route('products.index') }}" method="GET"
                    class="d-flex gap-2 align-items-center flex-wrap">
                    <select name="category_id" class="form-control form-select-lg shadow-sm" required
                        style="min-width: 180px;">
                        <option value="" disabled selected>اختر فئة</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if (request('category') == $category->id) selected @endif>
                                {{ $category->name }}</option>
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
                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
                            novalidate>
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
                                        <input type="text" name="name" id="name"
                                            class="form-control @error('name') is-invalid @enderror" required autofocus>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="description">الوصف</label>
                                        <input type="textarea" name="description" id="description"
                                            class="form-control @error('description') is-invalid @enderror">
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="category_id">الفئة</label>
                                        <select name="category_id" id="category_id"
                                            class="form-control form-select-lg shadow-sm @error('category_id') is-invalid @enderror"
                                            required>
                                            <option value="" disabled selected>اختر فئة</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-md-6 mb-3">
                                        <label for="price">سعر الشراء</label>
                                        <input type="number" name="Purchase_price" id="Purchase_price"
                                            class="form-control @error('Purchase_price') is-invalid @enderror"
                                            step="0.01" min="0" value="{{ old('Purchase_price') }}">
                                        @error('Purchase_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-md-6 mb-3">
                                        <label for="price">سعر البيع</label>
                                        <input type="number" name="selling_price" id="selling_price"
                                            class="form-control @error('selling_price') is-invalid @enderror" step="0.01"
                                            min="0" value="{{ old('selling_price') }}">
                                        @error('selling_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-md-6 mb-3">
                                        <label for="cover">الصورة الرئيسية</label>
                                        <input type="file" name="cover" id="cover"
                                            class="form-control @error('cover') is-invalid @enderror" required
                                            accept="image/*">
                                        @error('cover')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <hr>
                                <h5>إضافة الأحجام</h5>

                                <div id="sizes-wrapper">

                                    <div class="row size-item mb-2 align-items-center">

                                        <div class="col-md-3">
                                            <input type="text" name="sizes[0][size]" class="form-control"
                                                placeholder="الحجم" required>
                                        </div>

                                        <div class="col-md-3">
                                            <input type="number" name="sizes[0][Purchase_price]" class="form-control"
                                                placeholder="سعر الشراء" required>
                                        </div>

                                        <div class="col-md-3">
                                            <input type="number" name="sizes[0][selling_price]" class="form-control"
                                                placeholder="سعر البيع" required>
                                        </div>

                                        <div class="col-md-2">
                                            <input type="number" name="sizes[0][quantity]" class="form-control"
                                                placeholder="الكمية" min="0" required>
                                        </div>

                                        <div class="col-md-1 d-flex align-items-center justify-content-center">
                                            <button type="button" class="btn btn-danger btn-sm remove-size">
                                                &times;
                                            </button>
                                        </div>

                                    </div>

                                </div>
                                <button type="button" id="add-size" class="btn btn-secondary btn-sm mt-2">+ إضافة حجم
                                    آخر</button>
                            </div>
                            <div class="modal-footer border-0 justify-content-between">
                                <button type="button" class="btn btn-outline-secondary px-4"
                                    data-dismiss="modal">إغلاق</button>
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
                                <th style="width: 10%;">الباركود</th>
                                <th style="width: 22%;">الوصف</th>
                                <th style="width: 13%;">الفئة</th>
                                <th style="width:10%;">سعرالشراء</th>
                                <th style="width:10%;">سعر بيع</th>
                                <th style="width:10%;">الكمية</th>
                                <th style="width: 14%;">الصورة</th>
                                <th style="width: 20%;">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr class="bg-white shadow-sm rounded-lg">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="font-weight-bold text-primary">{{ $product->name }}
                                        {{-- {{ $product->barcode }} --}}

                                    </td>
                                    <td>
                                        @if ($product->barcode)
                                            <div class="mt-1">
                                                <svg class="barcode-preview" data-barcode="{{ $product->barcode }}">
                                                </svg>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($product->description, 50) ?? '—' }}</td>
                                    <td>
                                        @if ($product->category)
                                            <span class="badge badge-info">{{ $product->category->name }}</span>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>
                                        {{ $product->Purchase_price !== null ? number_format($product->Purchase_price, 2) . '' : '—' }}
                                    </td>

                                    <td>
                                        {{ $product->selling_price !== null ? number_format($product->selling_price, 2) . '' : '—' }}
                                    </td>

                                    <td>
                                        {{ $product->sizes->sum('quantity') > 0 ? number_format($product->sizes->sum('quantity'), 0) : '—' }}
                                    </td>

                                    <td>
                                        @if ($product->cover)
                                            <img src="{{ asset('Attachfile/products/' . $product->cover) }}"
                                                alt="Cover Image" class="img-thumbnail rounded"
                                                style="width: 80px; height: 80px; object-fit: cover;">
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="product-actions-cell">

                                        <div class="actions-box">
                                            <form action="{{ route('products.barcodes.print') }}" method="GET"
                                                target="_blank" class="barcode-print-form">

                                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                                {{-- اختيار المقاس --}}
                                                @if ($product->sizes->isNotEmpty())
                                                    <select name="size_id"
                                                        class="form-control form-control-sm barcode-size mb-2">

                                                        <option value="">كل الأحجام</option>

                                                        @foreach ($product->sizes as $size)
                                                            <option value="{{ $size->id }}">
                                                                {{ $size->size }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                @endif

                                                {{-- اختيار إظهار السعر --}}
                                                <select name="show_price" class="form-control form-control-sm mb-2">

                                                    <option value="1">
                                                        طباعة بالسعر
                                                    </option>

                                                    <option value="0">
                                                        طباعة بدون سعر
                                                    </option>

                                                </select>

                                                <div class="print-row">

                                                    {{-- عدد النسخ --}}
                                                    <input type="number" name="qty" value="1" min="1"
                                                        max="200"
                                                        class="form-control form-control-sm text-center barcode-qty">

                                                    {{-- زر الطباعة --}}
                                                    <button type="submit" class="btn btn-dark btn-sm barcode-print-btn">

                                                        <i class="fa fa-barcode"></i>
                                                        طباعة

                                                    </button>

                                                </div>

                                            </form>

                                            <div class="main-actions-row">
                                                <button type="button" class="btn btn-outline-success btn-sm action-btn"
                                                    data-toggle="modal" data-target="#edit{{ $product->id }}">
                                                    <i class="fa fa-edit"></i> تعديل
                                                </button>

                                                <x-model name="delete-{{ $product->id }}" status="danger"
                                                    icon="fa fa-trash" title="حذف"
                                                    message="هل أنت متأكد من حذف {{ $product->name }}؟">
                                                    <form action="{{ route('products.destroy', $product->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm px-3">نعم،
                                                            احذف</button>
                                                    </form>
                                                </x-model>

                                                <a href="{{ route('products.show', $product->id) }}"
                                                    class="btn btn-outline-info btn-sm action-btn">
                                                    <i class="fa fa-eye"></i> عرض
                                                </a>
                                            </div>

                                        </div>

                                        {{-- مودال التعديل خليه بعد actions-box عادي --}}
                                        <div class="modal fade" id="edit{{ $product->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">

                                                    <form action="{{ route('products.update', $product->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="modal-header">
                                                            <h5 class="modal-title">تعديل المنتج
                                                            </h5>
                                                        </div>

                                                        <div class="modal-body">

                                                            <div class="row">

                                                                <div class="col-md-6">
                                                                    <label>الاسم</label>
                                                                    <input type="text" name="name"
                                                                        value="{{ $product->name }}"
                                                                        class="form-control">
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <label>الوصف</label>
                                                                    <input type="text" name="description"
                                                                        value="{{ $product->description }}"
                                                                        class="form-control">
                                                                </div>

                                                                <div class="col-md-6 mt-2">
                                                                    <label>الفئة</label>
                                                                    <select name="category_id" class="form-control">
                                                                        @foreach ($categories as $category)
                                                                            <option value="{{ $category->id }}"
                                                                                {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                                                {{ $category->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-6 mt-2">
                                                                    <label>سعر الشراء</label>
                                                                    <input type="number" name="Purchase_price"
                                                                        value="{{ $product->Purchase_price }}"
                                                                        class="form-control">
                                                                </div>

                                                                <div class="col-md-6 mt-2">
                                                                    <label>سعر البيع</label>
                                                                    <input type="number" name="selling_price"
                                                                        value="{{ $product->selling_price }}"
                                                                        class="form-control">
                                                                </div>



                                                                <div class="col-md-6 mt-2">
                                                                    <label>الصورة</label>
                                                                    <input type="file" name="cover"
                                                                        class="form-control">
                                                                    @if ($product->cover)
                                                                        <img src="{{ asset('Attachfile/products/' . $product->cover) }}"
                                                                            style="width:60px;height:60px;margin-top:5px;">
                                                                    @endif
                                                                </div>

                                                            </div>

                                                            <hr>
                                                            <h6>الأحجام</h6>

                                                            <div id="sizes-wrapper-edit-{{ $product->id }}">
                                                                @foreach ($product->sizes as $index => $size)
                                                                    <div class="row size-item mb-2">

                                                                        <div class="col-md-3">
                                                                            <input type="text"
                                                                                name="sizes[{{ $index }}][size]"
                                                                                value="{{ $size->size }}"
                                                                                class="form-control" placeholder="الحجم">
                                                                        </div>

                                                                        <div class="col-md-2">
                                                                            <input type="number"
                                                                                name="sizes[{{ $index }}][Purchase_price]"
                                                                                value="{{ $size->Purchase_price }}"
                                                                                class="form-control"
                                                                                placeholder="سعر الشراء">
                                                                        </div>

                                                                        <div class="col-md-2">
                                                                            <input type="number"
                                                                                name="sizes[{{ $index }}][selling_price]"
                                                                                value="{{ $size->selling_price }}"
                                                                                class="form-control"
                                                                                placeholder="سعر البيع">
                                                                        </div>

                                                                        <div class="col-md-1">
                                                                            <input type="number"
                                                                                name="sizes[{{ $index }}][quantity]"
                                                                                value="{{ $size->quantity ?? 0 }}"
                                                                                class="form-control" min="0"
                                                                                placeholder="الكميه">
                                                                        </div>

                                                                        <div class="col-md-2">
                                                                            <button type="button"
                                                                                class="btn btn-danger btn-sm remove-size">
                                                                                &times;
                                                                            </button>
                                                                        </div>

                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm add-size-btn"
                                                                data-target="#sizes-wrapper-edit-{{ $product->id }}">
                                                                + إضافة حجم
                                                            </button>

                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">حفظ</button>
                                                        </div>

                                                    </form>

                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">لا توجد
                                        منتجات لعرضها.</td>
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
        <div class="col-sm-6">
            <ol class="float-sm-right mb-0 p-0" style="list-style: none;">
                <li>
                    <a href="{{ route('dashboard') }}" class="btn btn-success"
                        style="color: #fff; transition: all 0.2s ease-in-out;"
                        onmouseover="this.style.backgroundColor='#007bff'; this.style.borderColor='#007bff'; this.style.color='#fff';"
                        onmouseout="this.style.backgroundColor=''; this.style.borderColor=''; this.style.color='#fff';">
                        الرئيسية
                    </a>
                </li>
            </ol>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <style>
        .size-item {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .size-item>div {
            flex: 1;
        }

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

        .product-actions-cell {
            width: 270px;
            min-width: 270px;
            vertical-align: middle !important;
        }

        .actions-box {
            width: 230px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 7px;
            align-items: stretch;
        }

        .barcode-print-form {
            width: 100%;
            margin: 0;
        }

        .barcode-size {
            width: 100%;
            height: 32px;
            font-size: 12px;
            margin-bottom: 6px;
        }

        .print-row {
            display: flex;
            align-items: center;
            gap: 6px;
            width: 100%;
        }

        .barcode-qty {
            width: 65px !important;
            height: 34px;
            font-size: 13px;
            font-weight: 700;
            padding: 3px;
        }

        .barcode-print-btn {
            flex: 1;
            height: 34px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            margin: 0 !important;
        }

        .main-actions-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
        }

        .main-actions-row .btn,
        .main-actions-row button,
        .main-actions-row a {
            width: 70px;
            height: 32px;
            padding: 4px 6px !important;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            gap: 4px;
            margin: 0 !important;
            border-radius: 5px;
            white-space: nowrap;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        let sizeIndex = 1;

        // إضافة حجم جديد في مودال الإضافة
        $('#add-size').click(function() {
            $('#sizes-wrapper').append(`
                               <div class="row size-item mb-2 align-items-center">

                              <div class="col-md-4">
                             <input type="text" name="sizes[${sizeIndex}][size]" class="form-control" placeholder="الحجم" required>
                             </div>

                              <div class="col-md-3">
                             <input type="number" name="sizes[${sizeIndex}][Purchase_price]" class="form-control"  placeholder="سعر الشراء" required>
                              </div>


                              <div class="col-md-3">
                              <input type="number" name="sizes[${sizeIndex}][selling_price]" class="form-control" placeholder="سعر البيع" required>
                              </div>

                              <div class="col-md-2">
                              <input type="number" name="sizes[${sizeIndex}][quantity]" class="form-control" placeholder="الكمية" min="0" required>
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
                                  <div class="row size-item mb-2 align-items-center">
                                   <div class="col-md-4">
                                    <input type="text" name="sizes[${newIndex}][size]" class="form-control" placeholder="الحجم" required>
                                    </div>


                                  <div class="col-md-3">
                                  <input type="number" name="sizes[${newIndex}][Purchase_price]" class="form-control" placeholder="سعر الشراء" required>
                                     </div>


                                   <div class="col-md-3">
                                   <input type="number" name="sizes[${newIndex}][selling_price]" class="form-control" placeholder="سعر البيع" required>
                                  </div>

                                  <div class="col-md-2">
                                  <input type="number" name="sizes[${newIndex}][quantity]" class="form-control" placeholder="الكمية" min="0" required>
                                   </div>

                                   <div class="col-md-1 d-flex align-items-center">
                                    <button type="button" class="btn btn-danger btn-sm remove-size">&times;</button>
                                   </div>
                                   </div>
                                     `);
        });
    </script>
@endsection
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.barcode-preview').forEach(function(barcode) {
            JsBarcode(barcode, barcode.dataset.barcode, {
                format: "CODE128",
                width: 1,
                height: 25,
                displayValue: true,
                fontSize: 9,
                margin: 0
            });
        });
    });
</script>
