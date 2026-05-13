<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>طباعة باركود المنتجات</title>

    <style>
        @page {
            size: 50mm 30mm;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: #fff;
        }

        .label {
            width: 50mm;
            height: 30mm;
            padding: 2mm;
            text-align: center;
            box-sizing: border-box;
            page-break-inside: avoid;
            border: 1px dashed #ddd;
        }

        .name {
            font-size: 10px;
            font-weight: bold;
            height: 13px;
            overflow: hidden;
            white-space: nowrap;
        }

        .barcode-img {
            width: 44mm;
            height: 15mm;
            margin-top: 1mm;
        }

        .price {
            font-size: 10px;
            font-weight: bold;
            margin-top: 1mm;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>

@foreach ($items as $item)

    @for ($i = 0; $i < $qty; $i++)

        <div class="label">
       <div class="store-name">
    {{ $branchData->name ?? config('app.name', 'nanocity') }}
</div>

            <div class="name">
                {{ $item['name'] }}
            </div>

            <img class="barcode-img"
                 src="data:image/png;base64,{{ $item['barcode'] }}"
                 alt="barcode">

            @if($showPrice)
                <div class="price">
                    {{ number_format((float)$item['price'], 2) }} ج.م
                </div>
            @endif

        </div>

    @endfor

@endforeach

<script>
    window.onload = function () {
        window.print();
    };
</script>

</body>
</html>