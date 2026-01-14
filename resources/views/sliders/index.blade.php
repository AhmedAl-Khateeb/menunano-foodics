@extends('layouts.app')

@section('main-content')
<div class="container my-5">
    <div class="card shadow-lg rounded-lg border-0">
        <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center flex-wrap gap-3">
            <h3 class="card-title mb-0 font-weight-bold" style="letter-spacing: 1px;">البانرات</h3>
            <button type="button" class="btn btn-light btn-sm shadow-sm px-4" data-toggle="modal" data-target="#addSliderModal">
                <i class="fa fa-plus mr-1"></i> إضافة صورة جديدة
            </button>

            {{-- مودال إضافة صورة --}}
            <div class="modal fade" id="addSliderModal" tabindex="-1" aria-labelledby="addSliderLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-lg shadow">
                        <form action="{{ route('sliders.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                            @csrf
                            <div class="modal-header border-0">
                                <h5 class="modal-title" id="addSliderLabel">إضافة صورة بانر جديدة</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                                    <span aria-hidden="true" style="font-size: 1.5rem;">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-dark">
                                <div class="form-group">
                                    <label for="image">اختر صورة</label>
                                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*" required>
                                    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="modal-footer border-0 justify-content-between">
                                <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">إغلاق</button>
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
                            <th style="width: 70%;">الصورة</th>
                            <th style="width: 25%;">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sliders as $slider)
                            <tr class="bg-white shadow-sm rounded-lg">
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($slider->image)
                                        <img src="{{ asset('storage/app/public/'.$slider->image) }}" alt="Banner Image" class="img-fluid rounded" style="max-height: 120px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">لا توجد صورة</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- زر التعديل --}}
                                    <button type="button" class="btn btn-outline-primary btn-sm mr-2 mb-1" data-toggle="modal" data-target="#editSliderModal{{ $slider->id }}">
                                        <i class="fa fa-edit"></i> تعديل
                                    </button>

                                    {{-- مودال التعديل --}}
                                    <div class="modal fade" id="editSliderModal{{ $slider->id }}" tabindex="-1" aria-labelledby="editSliderLabel{{ $slider->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content rounded-lg shadow">
                                                <form action="{{ route('sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header border-0">
                                                        <h5 class="modal-title" id="editSliderLabel{{ $slider->id }}">تعديل صورة البانر</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                                                            <span aria-hidden="true" style="font-size: 1.5rem;">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-dark">
                                                        <div class="form-group">
                                                            <label for="image-{{ $slider->id }}">اختر صورة جديدة (اتركها فارغة للاحتفاظ بالصورة الحالية)</label>
                                                            <input type="file" name="image" id="image-{{ $slider->id }}" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                                            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                        </div>
                                                        <div class="text-center mt-3">
                                                            <img src="{{ asset('storage/app/public/'.$slider->cover) }}" alt="Current Image" class="img-thumbnail" style="max-height: 150px;">
                                                        </div>
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
                                    <x-model name="delete-{{ $slider->id }}" status="danger" icon="fa fa-trash" title="حذف" message="هل أنت متأكد من حذف هذه الصورة؟">
                                        <form action="{{ route('sliders.destroy', $slider->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm px-3">نعم، احذف</button>
                                        </form>
                                    </x-model>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">لا توجد صور لعرضها.</td>
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
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }
    .btn-outline-primary:hover {
        background-color: #007bff;
        color: #fff;
    }
    .card {
        border-radius: 15px;
    }
    .card-header {
        border-radius: 15px 15px 0 0;
    }
</style>
@endsection