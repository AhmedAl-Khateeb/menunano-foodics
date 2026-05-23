@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">عمال التوصيل</h1>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title mb-0">قائمة عمال التوصيل</h3>
                            <button type="button" class="btn btn-primary btn-sm ms-auto" data-toggle="modal"
                                data-target="#createDeliveryManModal">
                                <i class="fas fa-plus"></i> إضافة عامل توصيل
                            </button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive d-none d-md-block">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الاسم</th>
                                            <th>الهاتف</th>
                                            <th>نسبة العمولة</th>
                                            <th>الحالة</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($deliveryMen as $man)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="font-weight-bold">{{ $man->name }}</td>
                                                <td dir="ltr" class="text-right">{{ $man->phone ?? '-' }}</td>
                                                <td>
                                                    <span
                                                        class="badge badge-info px-2 py-1">{{ $man->commission_percent }}%</span>
                                                </td>
                                                <td>
                                                    @if ($man->is_active)
                                                        <span class="badge badge-success">نشط</span>
                                                    @else
                                                        <span class="badge badge-secondary">معطل</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-1 justify-content-center">
                                                        <button type="button" class="btn btn-info btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#editDeliveryManModal{{ $man->id }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <form action="{{ route('delivery_men.destroy', $man->id) }}"
                                                            method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted py-4">لا يوجد عمال توصيل
                                                    مضافين</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Mobile View --}}
                            <div class="d-block d-md-none p-3">
                                @forelse ($deliveryMen as $man)
                                    <div class="card mb-3 border shadow-none rounded-lg">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h5 class="mb-0 font-weight-bold text-primary">{{ $man->name }}</h5>
                                                @if ($man->is_active)
                                                    <span class="badge badge-success px-2 py-1">نشط</span>
                                                @else
                                                    <span class="badge badge-secondary px-2 py-1">معطل</span>
                                                @endif
                                            </div>

                                            <div class="text-muted small mb-3">
                                                <div class="mb-1 d-flex justify-content-between">
                                                    <span><i class="fas fa-phone mr-1 w-4 text-center"></i> رقم
                                                        الهاتف:</span>
                                                    <span dir="ltr">{{ $man->phone ?? '-' }}</span>
                                                </div>
                                                <div class="mb-1 d-flex justify-content-between">
                                                    <span><i class="fas fa-percentage mr-1 w-4 text-center"></i>
                                                        العمولة:</span>
                                                    <span class="font-weight-bold">{{ $man->commission_percent }}%</span>
                                                </div>
                                            </div>

                                            <div class="d-flex gap-2 border-top pt-3">
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#editDeliveryManModal{{ $man->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('delivery_men.destroy', $man->id) }}" method="POST"
                                                    class="flex-grow-1" style="margin:0;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm w-100"
                                                        onclick="return confirm('هل أنت متأكد؟')">
                                                        <i class="fas fa-trash"></i> حذف
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center text-muted py-4 border rounded">لا يوجد عمال توصيل مضافين</div>
                                @endforelse
                            </div>
                        </div>
                         <div class="card-footer clearfix">
                            {{ $deliveryMen->links() }}
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
            </div>
        </div>
    </section>

    {{-- Create Delivery Man Modal --}}
    <div class="modal fade" id="createDeliveryManModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form action="{{ route('delivery_men.store') }}" method="POST">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">إضافة عامل توصيل</h5>

                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body text-right">
                        @include('dashboard.delivery_men.form')
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            إلغاء
                        </button>

                        <button type="submit" class="btn btn-primary">
                            حفظ
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>


    {{-- Edit Delivery Man Modal --}}
    @foreach ($deliveryMen as $man)
        <div class="modal fade" id="editDeliveryManModal{{ $man->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <form action="{{ route('delivery_men.update', $man->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title">تعديل عامل التوصيل</h5>

                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>

                        <div class="modal-body text-right">

                            {{-- نفس الفورم لكن مع بيانات --}}
                            <div class="form-group">
                                <label>الاسم</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $man->name) }}" required>
                            </div>

                            <div class="form-group">
                                <label>الهاتف</label>
                                <input type="text" name="phone" class="form-control"
                                    value="{{ old('phone', $man->phone) }}">
                            </div>

                            <div class="form-group">
                                <label>نسبة العمولة</label>
                                <input type="number" step="0.01" name="commission_percent" class="form-control"
                                    value="{{ old('commission_percent', $man->commission_percent) }}">
                            </div>

                            <div class="form-group">
                                <label>الحالة</label><br>
                                <input type="checkbox" name="is_active" {{ $man->is_active ? 'checked' : '' }}>
                                تفعيل
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                إلغاء
                            </button>

                            <button type="submit" class="btn btn-primary">
                                تحديث
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    @endforeach


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'تم بنجاح',
                text: @json(session('success')),
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                text: @json(session('error')),
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif
@endsection
