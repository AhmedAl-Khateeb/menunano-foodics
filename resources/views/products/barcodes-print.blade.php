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

        .no-print {
            padding: 10px;
            text-align: center;
        }

        .label {
            width: 50mm;
            height: 30mm;
            box-sizing: border-box;
            padding: 2mm;
            text-align: center;
            overflow: hidden;
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

        .barcode {
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
            .no-print {
                display: none;
            }

            .label {
                border: none;
            }
        }
    </style>
</head>
<body>

<div class="no-print">
    <button onclick="window.print()">طباعة</button>
</div>

@foreach ($items as $item)
    @for ($i = 0; $i < $qty; $i++)
        <div class="label">
            <div class="name">{{ $item['name'] }}</div>

            <svg class="barcode"
                 jsbarcode-format="CODE128"
                 jsbarcode-value="{{ $item['barcode'] }}"
                 jsbarcode-textmargin="0"
                 jsbarcode-fontsize="10"
                 jsbarcode-width="1.4"
                 jsbarcode-height="38"
                 jsbarcode-displayvalue="true">
            </svg>

            <div class="price">
                {{ number_format((float) $item['price'], 2) }} ج.م
            </div>
        </div>
    @endfor
@endforeach

<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>

<script>
    JsBarcode(".barcode").init();
</script>

</body>
</html>