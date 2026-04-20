@extends('layouts.app')

@section('main-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1 class="m-0">إضافة أمر إنتاج</h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                    {{-- <li class="breadcrumb-item"><a href="{{ route('inventory.production-orders.index') }}">الإنتاج</a></li> --}}
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header"><h3 class="card-title">بيانات الإنتاج</h3></div>

            <form method="POST" action="{{ route('inventory.production-orders.store') }}">
                @csrf
                @include('dashboard.inventory.production_orders.form')

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                    <a href="{{ route('inventory.production-orders.index') }}" class="btn btn-default float-right">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection