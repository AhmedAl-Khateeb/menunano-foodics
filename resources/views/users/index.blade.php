@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">المستخدمين</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                        {{-- <li class="breadcrumb-item active">المستخدمين</li> --}}
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">قائمة المستخدمين</h3>
                            <div class="card-tools">
                                <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> إضافة مستخدم
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            {{-- Desktop View --}}
                            <div class="table-responsive d-none d-md-block">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الاسم</th>
                                            <th>البريد الإلكتروني</th>
                                            <th>الدور</th>
                                            <th>الفروع</th>
                                            <th>أنشئ بواسطة</th>
                                            <th>الصورة</th>

                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ $user->role == 'admin' ? 'success' : ($user->role == 'super_admin' ? 'danger' : 'info') }}">
                                                        {{ $user->role }}
                                                    </span>
                                                </td>
                                                <td>{{ $user->branch->name ?? '-' }}</td>
                                                <td>
                                                    @if ($user->creator)
                                                        {{ $user->creator->name }}
                                                    @else
                                                        <span class="text-muted">نظام</span>
                                                    @endif
                                                </td>
                                                <td>
                                                <img src="{{ url('/storage/' . ltrim($user->image, '/')) }}"
                                                    alt="{{ $user->name }}" class="img-thumbnail rounded-circle"
                                                    width="45" height="45" style="object-fit: cover;">
                                            </td>

                                                <td>
                                                    <div class="d-flex gap-1 justify-content-center">
                                                        {{-- @if (auth()->user()->role === 'admin' && $user->id !== auth()->id())
                                                            <a href="{{ route('impersonate', $user->id) }}"
                                                                class="btn btn-warning btn-sm" title="دخول كـ المستخدم">
                                                                <i class="fas fa-user-secret"></i>
                                                            </a>
                                                        @endif --}}
                                                        <a href="{{ route('users.edit', $user->id) }}"
                                                            class="btn btn-info btn-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('users.destroy', $user->id) }}"
                                                            method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                onclick="return confirm('هل أنت متأكد؟')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    </tbody>
                                </table>
                            </div>

                            {{-- Mobile View --}}
                            <div class="d-block d-md-none p-3">
                                @foreach ($users as $user)
                                    <div class="card mb-3 border shadow-none rounded-lg">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h5 class="mb-0 font-weight-bold text-primary">{{ $user->name }}</h5>
                                                <span
                                                    class="badge badge-{{ $user->role == 'admin' ? 'success' : ($user->role == 'super_admin' ? 'danger' : 'info') }} px-2 py-1">
                                                    {{ $user->role }}
                                                </span>
                                            </div>

                                            <div class="text-muted small mb-3">
                                                <div class="mb-1">
                                                    <i class="fas fa-envelope mr-1 w-4 text-center"></i>
                                                    {{ $user->email }}
                                                </div>
                                                <div class="mb-1">
                                                    <i class="fas fa-user-plus mr-1 w-4 text-center"></i>
                                                    أنشئ بواسطة:
                                                    @if ($user->creator)
                                                        <span class="font-weight-bold">{{ $user->creator->name }}</span>
                                                    @else
                                                        <span class="text-muted">نظام</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="d-flex gap-2 border-top pt-3">
                                                @if (auth()->user()->role === 'admin' && $user->id !== auth()->id())
                                                    <a href="{{ route('impersonate', $user->id) }}"
                                                        class="btn btn-warning btn-sm flex-grow-1" title="دخول كـ المستخدم">
                                                        <i class="fas fa-user-secret"></i> دخول
                                                    </a>
                                                @endif
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    class="btn btn-info btn-sm flex-grow-1">
                                                    <i class="fas fa-edit"></i> تعديل
                                                </a>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    class="flex-grow-1">
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
                                @endforeach
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            {{ $users->links() }}
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>

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
