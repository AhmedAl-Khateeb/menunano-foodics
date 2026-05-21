@extends('layouts.app')

@section('main-content')
    <div class="container my-4">

        <div class="card border-0 shadow-lg rounded-lg">

            {{-- Header --}}
            <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center py-3">

                <h4 class="mb-0 font-weight-bold">
                    أحجام المنتج
                </h4>

                <a href="{{ route('products.index') }}" class="btn btn-light btn-sm shadow-sm">
                    ← الرئيسية
                </a>

            </div>

            {{-- Body --}}
            <div class="card-body p-4">

                @if ($product->sizes && $product->sizes->count())
                    <div class="table-responsive">

                        <table class="table table-hover text-center align-middle">

                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>الحجم</th>
                                    <th>سعر الشراء</th>
                                    <th>سعر البيع</th>
                                    <th>الكمية</th>
                                    <th> السعر الإجمالي </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($product->sizes as $size)
                                    <tr>

                                        <td>{{ $loop->iteration }}</td>

                                        <td class="font-weight-bold text-primary">
                                            {{ $size->product->name }}
                                        </td>

                                        <td class="font-weight-bold text-primary">
                                            {{ $size->size }}
                                        </td>

                                        <td>
                                            {{ number_format($size->Purchase_price ?? 0, 2) }}
                                        </td>

                                        <td>
                                            {{ number_format($size->selling_price ?? 0, 2) }}
                                        </td>

                                        {{-- ✔️ الكمية --}}
                                        <td class="font-weight-bold text-dark">
                                            {{ $size->quantity ?? 0 }}
                                        </td>

                                        {{-- ✔️ إجمالي القيمة --}}
                                        <td class="text-success font-weight-bold">
                                            {{ number_format(($size->selling_price ?? 0) * ($size->quantity ?? 0), 2) }}
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>

                        </table>

                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        لا توجد أحجام لهذا المنتج
                    </div>
                @endif

            </div>

        </div>
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
        }

        .table-hover tbody tr:hover {
            background: #f1f5ff !important;
        }

        .table th {
            font-size: 14px;
            font-weight: 700;
        }

        .table td {
            font-size: 14px;
        }

        .card {
            border-radius: 15px;
        }
    </style>
@endsection
