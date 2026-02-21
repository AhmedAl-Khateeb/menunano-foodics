@extends('layouts.app')

@section('title', 'المنتجات المركبة')

@section('main-content')
<div class="container-fluid py-4" dir="rtl">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
        <div class="text-center text-md-end w-100 w-md-auto">
            <h4 class="font-weight-bold mb-1">المنتجات المركبة</h4>
            <p class="text-muted small mb-0">إدارة المنتجات التي يتم تصنيعها من خامات (Recipes)</p>
        </div>
        <div class="d-flex gap-2 w-100 w-md-auto justify-content-center justify-content-md-end">
            <a href="{{ route('inventory.composite.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                <i class="fas fa-plus"></i>
                <span>منتج جديد</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @forelse($products as $product)
            <div class="col-12 col-sm-6 col-md-4 col-xl-3">
                <div class="card shadow-sm border-0 h-100 overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="font-weight-bold mb-0 text-truncate" style="max-width: 100%;">{{ $product->name }}</h6>
                        </div>
                        
                        <div class="mb-3">
                            <span class="badge bg-light text-dark text-xxs font-weight-normal border">
                                {{ $product->category->name ?? 'بدون قسم' }}
                            </span>
                        </div>

                        <div class="mb-3">
                            <label class="text-xxs text-uppercase text-muted font-weight-bold mb-1 d-block">المكونات الرئيسية ({{ $product->recipes->count() }}):</label>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($product->recipes->take(3) as $recipe)
                                    <span class="badge bg-gray-100 text-xs text-dark opacity-75 font-weight-normal">
                                        {{ $recipe->ingredient->name }} ({{ $recipe->quantity }})
                                    </span>
                                @endforeach
                                @if($product->recipes->count() > 3)
                                    <span class="text-xxs text-muted mt-1">+ {{ $product->recipes->count() - 3 }} آخرين</span>
                                @endif
                            </div>
                        </div>

                        <div class="bg-gray-50 border rounded-sm p-2 mb-0 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-calculator text-xxs text-muted"></i>
                                <span class="text-xs font-weight-bold">متاح للتصنيع:</span>
                            </div>
                            <span class="text-sm font-weight-bold text-dark">
                                {{ $product->max_production_quantity }} {{ $product->unit->name ?? 'وحدة' }}
                            </span>
                        </div>

                        <div class="mt-3 pt-3 border-top d-flex justify-content-between gap-1">
                            <a href="{{ route('inventory.composite.recipe.edit', $product->id) }}" class="btn btn-sm btn-outline-primary flex-grow-1 px-1">
                                <i class="fas fa-scroll"></i> الوصفة
                            </a>
                            <a href="{{ route('inventory.composite.edit', $product->id) }}" class="btn btn-sm btn-outline-secondary flex-grow-1 px-1">
                                <i class="fas fa-edit"></i> تعديل
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-mortar-pestle fa-4x text-gray-200"></i>
                </div>
                <p class="text-muted">لا توجد منتجات مركبة حالياً</p>
                <a href="{{ route('inventory.composite.create') }}" class="btn btn-primary btn-sm mt-3">ابدأ بتعريف منتج مركب</a>
            </div>
        @endforelse
    </div>

    @if($products->hasPages())
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    @endif
</div>

<style>
    .rounded-sm { border-radius: 12px; }
    .border-2 { border-width: 2px !important; }
</style>
@endsection
