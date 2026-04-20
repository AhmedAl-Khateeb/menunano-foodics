@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">إضافة طلب تحويل</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                        {{-- <li class="breadcrumb-item"><a href="{{ route('inventory.transfer-requests.index') }}">طلبات
                                التحويل</a></li> --}}
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">بيانات التحويل</h3>
                </div>

                <form method="POST" action="{{ route('inventory.transfer-requests.store') }}">
                    @csrf
                    @include('dashboard.inventory.transfer_requests.form')

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">حفظ</button>
                        <a href="{{ route('inventory.transfer-requests.index') }}"
                            class="btn btn-default float-right">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
