@extends('layouts.app')

@section('main-content')
<div class="content-header">
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
<h1 class="m-0">المصروفات</h1>
</div>
<div class="col-sm-6">
<ol class="breadcrumb float-sm-right">
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
<li class="breadcrumb-item active">المصروفات</li>
</ol>
</div>
</div>
</div>
</div>

<section class="content">
<div class="container-fluid">
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
<i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
@endif

<div class="row">
<div class="col-12">
<div class="card border-0 shadow-sm rounded-lg">
<div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
<h3 class="card-title font-weight-bold text-dark">سجل المصروفات</h3>
<a href="{{ route('expenses.create') }}" class="btn btn-primary btn-sm ms-auto shadow-sm">
<i class="fas fa-plus mr-1"></i> مصروف جديد
</a>
</div>
<div class="card-body p-0 mt-3">
<div class="table-responsive">
<table class="table table-hover align-middle">
    <thead class="bg-light text-muted">
        <tr>
            <th class="border-top-0 pl-4">#</th>
            {{-- <th class="border-top-0">رقم الفاتورة</th> --}}
            <th class="border-top-0">أسم المصروف</th>
            <th class="border-top-0">المرفقات</th>

            <th class="border-top-0 text-center">التاريخ</th>
            <th class="border-top-0 text-center">المبلغ</th>
            {{-- <th class="border-top-0 text-center">المدفوع</th>
            <th class="border-top-0 text-center">الحالة</th> --}}
            <th class="border-top-0 text-center">الملاحظات</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($expenses as $expense)
            <tr>
                <td class="pl-4 text-muted">{{ $loop->iteration }}</td>
                {{-- <td class="font-weight-bold text-primary">{{ $expense->invoice_number ?? '-' }}</td> --}}
                <td class="font-weight-bold text-dark">{{  $expense->TITLE }}</td>
                <td class="font-weight-bold text-dark">

                    <a href="Attachfile/Expenses/{{ $expense->attach_File }}" data-lightbox="image-1"
                    data-title="My caption">

                    <embed src="Attachfile/Expenses/{{ $expense->attach_File }}"
                        style="width:50px; height:50px;" /> </a>   </td>
                <td class="text-center text-muted" dir="ltr">{{ $expense->created_at->format('Y-m-d') }}</td>
                <td class="text-center font-weight-bold">{{ number_format($expense->Amount, 2) }} ج.م</td>
                <td class="text-center text-success">{{ $expense->Notes}} </td>
                <td class="text-center">

                </td>
                <td>
                    <div class="d-flex gap-2 justify-content-center">
                       <a href="{{ route('expenses.show', $expense->id) }}" class="btn btn-light btn-sm text-info shadow-sm hover-bg-info" title="تعديل بيانات المصروف">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:inline-block;" class="m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-light btn-sm text-danger shadow-sm hover-bg-danger" onclick="return confirm('هل أنت متأكد من حذف سجل مصروفات  هذا؟')" title="حذف المصروفات">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center text-muted py-5">
                    <i class="fas fa-file-invoice-dollar text-light block mb-3" style="font-size: 3rem;"></i><br>
                    لا توجد مصروفات مسجلة
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
</section>

<style>
.hover-bg-info:hover { background-color: #17a2b8 !important; color: white !important; }
.hover-bg-danger:hover { background-color: #dc3545 !important; color: white !important; }
</style>
@endsection
