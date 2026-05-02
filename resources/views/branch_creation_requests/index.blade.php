@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">طلبات إنشاء الفروع</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content" dir="rtl">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <h3 class="card-title mb-0">قائمة طلبات إنشاء الفروع</h3>

                                <div class="d-flex align-items-center flex-wrap gap-2 ms-auto">
                                    <form method="GET" class="d-flex align-items-center flex-wrap gap-2 mb-0">


                                        <div class="input-group input-group-sm" style="width: 190px;">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">من</span>
                                            </div>
                                            <input type="date" name="date_from" class="form-control"
                                                value="{{ request('date_from') }}">
                                        </div>

                                        <div class="input-group input-group-sm" style="width: 190px;">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">إلى</span>
                                            </div>
                                            <input type="date" name="date_to" class="form-control"
                                                value="{{ request('date_to') }}">
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-sm">
                                            بحث
                                        </button>

                                        <a href="{{ route('branch-creation-requests.index') }}"
                                            class="btn btn-secondary btn-sm">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </form>
                                </div>


                                @if (auth('web')->user()->role !== 'super_admin')
                                    <a href="{{ route('branch-creation-requests.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus-circle"></i>
                                        طلب إضافة فرع
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="card-body p-0">

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered text-center mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>مقدم الطلب</th>
                                            <th>اسم الفرع</th>
                                            <th>الكود</th>
                                            <th>الهاتف</th>
                                            <th>العنوان</th>

                                            <th>الحالة</th>
                                            <th>الفرع المنشأ</th>
                                            <th>تاريخ الطلب</th>
                                            @if (auth('web')->user()->role === 'super_admin')
                                                <th>الإجراءات</th>
                                            @endif
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($requests as $request)
                                            @php
                                                $statusClass = match ($request->status) {
                                                    'pending' => 'warning',
                                                    'paid' => 'info',
                                                    'approved' => 'success',
                                                    'rejected' => 'danger',
                                                    default => 'secondary',
                                                };

                                                $statusLabel = match ($request->status) {
                                                    'pending' => 'قيد المراجعة',
                                                    'paid' => 'مدفوع',
                                                    'approved' => 'مقبول',
                                                    'rejected' => 'مرفوض',
                                                    default => $request->status,
                                                };
                                            @endphp

                                            <tr>
                                                <td>{{ $loop->iteration }}</td>

                                                <td>
                                                    {{ $request->requester->name ?? '-' }}
                                                    <br>
                                                    <small class="text-muted">
                                                        {{ $request->requester->email ?? '' }}
                                                    </small>
                                                </td>

                                                <td class="font-weight-bold">
                                                    {{ $request->branch_name }}
                                                </td>

                                                <td>{{ $request->branch_code ?? '-' }}</td>

                                                <td>{{ $request->phone ?? '-' }}</td>

                                                <td>{{ $request->address ?? '-' }}</td>


                                                <td>
                                                    <span class="badge badge-{{ $statusClass }}">
                                                        {{ $statusLabel }}
                                                    </span>
                                                </td>

                                                <td>
                                                    @if ($request->createdBranch)
                                                        <span class="badge badge-success">
                                                            {{ $request->createdBranch->name }}
                                                        </span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                <td>
                                                    {{ $request->created_at?->format('Y-m-d h:i A') }}
                                                </td>

                                                @if (auth('web')->user()->role === 'super_admin')
                                                    <td>
                                                        @if (in_array($request->status, ['pending', 'paid']))
                                                            <div class="d-flex justify-content-center gap-1">

                                                                <form
                                                                    action="{{ route('branch-creation-requests.approve', $request->id) }}"
                                                                    method="POST" class="swal-confirm-form"
                                                                    data-title="تأكيد الموافقة"
                                                                    data-text="هل أنت متأكد من الموافقة على الطلب وإنشاء الفرع؟"
                                                                    data-icon="question" data-confirm-button="نعم، موافقة"
                                                                    style="display:inline-block;">
                                                                    @csrf

                                                                    <button type="submit" class="btn btn-success btn-sm">
                                                                        <i class="fas fa-check"></i>
                                                                        موافقة
                                                                    </button>
                                                                </form>

                                                                <form
                                                                    action="{{ route('branch-creation-requests.reject', $request->id) }}"
                                                                    method="POST" class="swal-confirm-form"
                                                                    data-title="تأكيد الرفض"
                                                                    data-text="هل أنت متأكد من رفض طلب إنشاء الفرع؟"
                                                                    data-icon="warning" data-confirm-button="نعم، رفض"
                                                                    style="display:inline-block;">
                                                                    @csrf

                                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                                        <i class="fas fa-times"></i>
                                                                        رفض
                                                                    </button>
                                                                </form>

                                                            </div>
                                                        @else
                                                            <span class="text-muted">لا يوجد إجراء</span>
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="{{ auth('web')->user()->role === 'super_admin' ? 10 : 9 }}"
                                                    class="text-muted py-4">
                                                    لا توجد طلبات إنشاء فروع
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="card-footer clearfix">
                            {{ $requests->links() }}
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
