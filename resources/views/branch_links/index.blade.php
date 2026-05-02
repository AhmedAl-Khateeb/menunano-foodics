@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">ربط الفروع</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content" dir="rtl">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        {{-- <h3 class="mb-0 text-center w-100">روابط الفروع الحالية</h3> --}}

                        <a href="{{ route('branch-links.create') }}" class="btn btn-primary btn-sm mt-2">
                            <i class="fas fa-plus"></i>
                            إضافة ربط جديد
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>من فرع</th>
                                    <th>إلى فرع</th>
                                    <th>نوع الربط</th>
                                    <th>الحالة</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($links as $link)
                                    @php
                                        $typeLabel = match ($link->type) {
                                            'linked' => 'ربط إداري عام',
                                            'inventory_transfer' => 'تحويل مخزون',
                                            'shared_reports' => 'مشاركة تقارير',
                                            'main_sub_branch' => 'فرع رئيسي وتابع',
                                            default => $link->type,
                                        };
                                    @endphp

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>
                                            <strong>{{ $link->fromBranch->name ?? '-' }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                {{ $link->fromBranch->code ?? '' }}
                                            </small>
                                        </td>

                                        <td>
                                            <strong>{{ $link->toBranch->name ?? '-' }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                {{ $link->toBranch->code ?? '' }}
                                            </small>
                                        </td>

                                        <td>
                                            <span class="badge badge-info">
                                                {{ $typeLabel }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="badge badge-{{ $link->is_active ? 'success' : 'secondary' }}">
                                                {{ $link->is_active ? 'نشط' : 'متوقف' }}
                                            </span>
                                        </td>

                                        <td>
                                            {{ $link->created_at?->format('Y-m-d h:i A') }}
                                        </td>


                                        <td>
                                            <form action="{{ route('branch-links.destroy', $link->id) }}" method="POST"
                                                class="swal-delete-form" style="display:inline-block;"
                                                data-text="هل أنت متأكد من حذف هذا الربط بين الفروع؟">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-muted py-4">
                                            لا توجد روابط بين الفروع حتى الآن
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer clearfix">
                    {{ $links->links() }}
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
