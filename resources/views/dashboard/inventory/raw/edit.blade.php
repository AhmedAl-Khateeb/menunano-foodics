@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">تعديل مادة مخزن</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('inventory.materials.index') }}">مواد المخزن</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">بيانات المادة</h3>
                </div>

                <form method="POST" action="{{ route('inventory.materials.update', $material->id) }}">
                    @csrf
                    @method('PUT')
                    @include('dashboard.inventory.raw.form')

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">تحديث</button>
                        <a href="{{ route('inventory.materials.index') }}" class="btn btn-default float-right">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection