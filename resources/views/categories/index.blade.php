@extends('layouts.app')

@section('main-content')
    <div class="container my-5">
        <div class="card shadow-lg border-0 rounded-lg">
            <div
                class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center flex-wrap gap-3">
                <h3 class="card-title mb-0 font-weight-bold" style="letter-spacing: 1px;">قائمة الفئات</h3>
                <button type="button" class="btn btn-light btn-sm shadow-sm px-4" data-toggle="modal" data-target="#desc-add">
                    <i class="fa fa-plus mr-1"></i> إضافة جديد
                </button>

                {{-- مودال الإضافة --}}
                <div class="modal fade" id="desc-add" tabindex="-1" aria-labelledby="descAddLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-lg shadow">
                            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data"
                                novalidate>
                                @csrf
                                <div class="modal-header border-0">
                                    <h5 class="modal-title" id="descAddLabel">إضافة فئة جديدة</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                                        <span aria-hidden="true" style="font-size: 1.5rem;">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-dark">
                                    <div class="form-group">
                                        <label for="name">الاسم</label>
                                        <input type="text" name="name" id="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}" required autofocus>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="cover">الصورة</label>
                                        <input type="file" name="cover" id="cover"
                                            class="form-control @error('cover') is-invalid @enderror" required
                                            accept="image/*">
                                        @error('cover')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
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
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover text-center align-middle mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 40%;">الاسم</th>
                                <th style="width: 25%;">الصورة</th>
                                <th style="width: 30%;">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr class="bg-white shadow-sm rounded-lg">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="font-weight-bold text-primary">{{ $category->name }}</td>
                                    <td>
                                        @if ($category->cover)
                                            <img src="{{ asset('storage/' . $category->cover) }}" alt="Cover Image"
                                                class="img-thumbnail rounded"
                                                style="width: 80px; height: 80px; object-fit: cover;">
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- زر التعديل --}}
                                        <button type="button" class="btn btn-outline-success btn-sm mr-2 mb-1"
                                            data-toggle="modal" data-target="#edit{{ $category->id }}">
                                            <i class="fa fa-edit"></i> تعديل
                                        </button>

                                        {{-- مودال التعديل --}}
                                        <div class="modal fade" id="edit{{ $category->id }}" tabindex="-1"
                                            aria-labelledby="editLabel{{ $category->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content rounded-lg shadow">
                                                    <form action="{{ route('categories.update', $category->id) }}"
                                                        method="POST" enctype="multipart/form-data" novalidate>
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header border-0">
                                                            <h5 class="modal-title" id="editLabel{{ $category->id }}">تعديل
                                                                الفئة</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="إغلاق">
                                                                <span aria-hidden="true"
                                                                    style="font-size: 1.5rem;">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-dark">
                                                            <div class="form-group">
                                                                <label for="name-{{ $category->id }}">الاسم</label>
                                                                <input type="text" name="name"
                                                                    id="name-{{ $category->id }}"
                                                                    class="form-control @error('name') is-invalid @enderror"
                                                                    value="{{ old('name', $category->name) }}" required
                                                                    autofocus>
                                                                @error('name')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="cover-{{ $category->id }}">الصورة (اتركها
                                                                    فارغة للاحتفاظ بالصورة الحالية)</label>
                                                                <input type="file" name="cover"
                                                                    id="cover-{{ $category->id }}"
                                                                    class="form-control @error('cover') is-invalid @enderror"
                                                                    accept="image/*">
                                                                @error('cover')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-0 justify-content-between">
                                                            <button type="button" class="btn btn-outline-secondary px-4"
                                                                data-dismiss="modal">إغلاق</button>
                                                            <button type="submit"
                                                                class="btn btn-success px-4">تحديث</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- زر الحذف --}}
                                        <x-model name="delete-{{ $category->id }}" status="danger" icon="fa fa-trash"
                                            title="حذف" message="هل أنت متأكد من حذف {{ $category->name }}؟">
                                            <form action="{{ route('categories.destroy', $category->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm px-3">نعم،
                                                    احذف</button>
                                            </form>
                                        </x-model>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">لا توجد فئات لعرضها.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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

        .btn-outline-success {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-outline-success:hover {
            background-color: #28a745;
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
@endsection
