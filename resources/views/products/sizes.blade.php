@extends('layouts.app')

@section('main-content')
    <div class="container">
        <div class="card shadow-lg mt-4">
            <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">Product Sizes List</h3>
            </div>

            {{-- Product Sizes Table --}}
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover text-center align-middle">
                        <thead class="text-dark">
                            <tr>
                                <th>#</th>
                                <th>Size</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($product->sizes as $size)
                                <tr class="bg-light">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-bold">{{ $size->size }}</td>
                                    <td class="fw-bold">{{ number_format($size->price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
        }

        .table-hover tbody tr:hover {
            background: #f8f9fa !important;
        }

        .shadow-sm {
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.15);
        }
    </style>
@endsection
