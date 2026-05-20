<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>طباعة الطلب #{{ $order->id }}</title>

    <style>
        @page {
            size: 80mm auto;
            margin: 0;
        }

        body * {
            visibility: hidden;
        }

        .receipt,
        .receipt * {
            visibility: visible;
        }

        .receipt {
            position: relative;
        }

        .page-break {
            page-break-before: always;
        }

        body {
            margin: 0;
            padding: 0;
            background: #fff;
            font-family: Tahoma, Arial, sans-serif;
            color: #000;
            font-size: 11px;
        }

        .receipt {
            width: 76mm;
            margin: 0 auto;
            padding: 8px 6px;
            background: #fff;
        }

        .center {
            text-align: center;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .badge {
            display: inline-block;
            background: #000;
            color: #fff;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 11px;
            margin-bottom: 6px;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 7px 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            margin: 3px 0;
        }

        .row span {
            flex: 1;
        }

        .row strong {
            flex: 1;
            text-align: left;
            direction: rtl;
        }

        .ltr {
            direction: ltr;
            unicode-bidi: embed;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            direction: ltr;
            text-align: center;
        }

        th {
            background: #111827;
            color: #fff;
            padding: 4px 2px;
            font-size: 10px;
            border: 1px solid #000;
        }

        td {
            padding: 4px 2px;
            font-size: 10px;
            border-bottom: 1px dashed #999;
            vertical-align: top;
        }

        .product-name {
            direction: rtl;
            text-align: right;
            font-weight: bold;
        }

        .muted {
            color: #444;
            font-size: 9px;
            font-weight: normal;
        }

        .total-box {
            margin-top: 8px;
            border: 1px solid #000;
        }

        .total-header {
            background: #111827;
            color: #fff;
            padding: 6px;
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            font-weight: bold;
        }

        .total-row {
            padding: 5px 6px;
            display: flex;
            justify-content: space-between;
            font-weight: bold;
        }

        .logo-box {
            text-align: center;
            margin-bottom: 4px;
        }

        .logo-img {
            width: 48px;
            height: 48px;
            object-fit: contain;
            margin-bottom: 3px;
        }

        .kitchen-title {
            font-size: 20px;
            font-weight: bold;
            border: 2px solid #000;
            padding: 6px;
            margin: 6px 0;
        }

        .kitchen-item {
            border-bottom: 1px dashed #000;
            padding: 8px 0;
        }

        .kitchen-item-name {
            font-size: 15px;
            font-weight: bold;
        }

        .kitchen-qty {
            font-size: 18px;
            font-weight: bold;
        }

        .note-box {
            border: 1px dashed #000;
            padding: 6px;
            margin: 7px 0;
            font-size: 11px;
            line-height: 1.6;
            text-align: right;
        }

        .note-title {
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 3px;
        }

        .kitchen-note {
            font-size: 13px;
            font-weight: bold;
        }

        .page-break {
            page-break-before: always;
            break-before: page;
            height: 0;
        }

        .no-print {
            text-align: center;
            margin: 15px;
        }

        .btn {
            background: #2563eb;
            color: #fff;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            margin: 5px;
        }

        .btn-dark {
            background: #111827;
        }

        @media print {
            body {
                background: #fff;
            }

            .no-print {
                display: none !important;
            }

            .receipt {
                margin: 0 auto;
                box-shadow: none;
            }
        }

        @media screen {
            body {
                background: #eee;
                padding: 15px;
            }

            .receipt {
                background: #fff;
                box-shadow: 0 0 8px rgba(0, 0, 0, 0.15);
                margin-bottom: 20px;
            }
        }
    </style>

</head>

<body>

    @php
        $items = $order->items ?? collect();

        $subtotal = (float) $order->subtotal;
        $discount = (float) $order->discount;
        $discountType = $order->discount_type;
        $discountAmount = (float) $order->discount_amount;
        $finalTotal = (float) $order->total_price;

        $deliveryFee = (float) ($order->delivery_fee ?? 0);
        $total = (float) ($order->total_price ?? 0);
        $paid = (float) ($order->paid_amount ?? 0);
        $change = (float) ($order->change_amount ?? 0);

        $orderTypeText = match ($order->type) {
            'takeaway' => 'تيك أواي',
            'table' => 'طاولة',
            'free_seating' => 'جلوس حر',
            'delivery' => 'توصيل',
            default => $order->type,
        };

        $paymentText = $order->payment_method === 'cash' ? 'نقدي' : 'فيزا / إلكتروني';

        $branchData = $branch ?? null;

        $placeNumber = $branchData->place_number ?? ($branchData->number ?? ($branchData->id ?? '-'));

        $placeName = $branchData->name ?? config('app.name', 'nanocity');

        $logoValue = $branchData->logo ?? (auth()->user()->logo ?? null);

        $settingsLogo = null;

        if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
            if (\Illuminate\Support\Facades\Schema::hasColumn('settings', 'logo')) {
                $settingsLogo = \Illuminate\Support\Facades\DB::table('settings')->value('logo');
            } elseif (\Illuminate\Support\Facades\Schema::hasColumn('settings', 'image')) {
                $settingsLogo = \Illuminate\Support\Facades\DB::table('settings')->value('image');
            }
        }

        $logoPath = null;

        $logoDirectory = storage_path('app/public/images/setting');

        if (is_dir($logoDirectory)) {
            $logoFiles = collect(\Illuminate\Support\Facades\File::files($logoDirectory))
                ->filter(function ($file) {
                    return in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp']);
                })
                ->sortByDesc(function ($file) {
                    return $file->getMTime();
                });

            $logoFile = $logoFiles->first();

            if ($logoFile) {
                $mimeType = mime_content_type($logoFile->getPathname());
                $logoBase64 = base64_encode(file_get_contents($logoFile->getPathname()));
                $logoPath = 'data:' . $mimeType . ';base64,' . $logoBase64;
            }
        }

        $orderNote =
            $order->notes ??
            ($order->note ?? ($order->order_note ?? ($order->customer_note ?? ($order->kitchen_note ?? ''))));
    @endphp

    {{-- فاتورة العميل --}}
    <div class="receipt">

        <div class="logo-box">
            @if (!empty($logoPath))
                <img src="{{ $logoPath }}" class="logo-img" alt="">
            @endif

            <div class="title">{{ $placeName }}</div>
            <div class="badge">فاتورة عميل</div>
        </div>



        <div class="center">
            <div>رقم المكان: {{ $placeNumber }}</div>
            <div>اسم المكان: {{ $placeName }}</div>
            <div>رقم الفاتورة: #{{ $order->id }}</div>
            <div class="ltr">{{ optional($order->created_at)->format('Y-m-d h:i A') }}</div>
        </div>

        <div class="line"></div>

        <div class="row">
            <span>نوع الطلب</span>
            <strong>{{ $orderTypeText }}</strong>
        </div>

        @if ($order->table)
            <div class="row">
                <span>الطاولة</span>
                <strong>{{ $order->table->name }}</strong>
            </div>
        @endif

        @if ($order->customer)
            <div class="row">
                <span>العميل</span>
                <strong>{{ $order->customer->name }}</strong>
            </div>

            <div class="row">
                <span>الهاتف</span>
                <strong class="ltr">{{ $order->customer->phone }}</strong>
            </div>
        @endif

        <div class="row">
            <span>طريقة الدفع</span>
            <strong>{{ $paymentText }}</strong>
        </div>
        @if ($discount > 0)
            <div class="row">
                <span>السعر قبل الخصم</span>
                <strong>{{ number_format($subtotal, 2) }} ج.م</strong>
            </div>

            <div class="row">
                <span>الخصم</span>
                <strong>
                    @if ($discountType === 'percent')
                        {{ $discount }} %
                    @else
                        {{ number_format($discount, 2) }} ج.م
                    @endif
                </strong>
            </div>

            <div class="row">
                <span>قيمة الخصم</span>
                <strong>
                    -{{ number_format($discountAmount, 2) }} ج.م
                </strong>
            </div>
        @endif

        <div class="line"></div>

        <table>
            <thead>
                <tr>
                    <th style="width: 42%;">الصنف</th>
                    <th style="width: 16%;">الكمية</th>
                    <th style="width: 20%;">السعر</th>
                    <th style="width: 22%;">الإجمالي</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($items as $item)
                    @php
                        $qty = (float) ($item->pivot->quantity ?? 1);
                        $price = (float) ($item->pivot->price ?? 0);
                        $lineTotal = $qty * $price;
                        $productName = $item->product->name ?? ($item->name ?? '-');
                        $sizeName = $item->size ?? null;
                    @endphp

                    <tr>
                        <td class="product-name">
                            {{ $productName }}
                            @if ($sizeName)
                                <br>
                                <span class="muted">{{ $sizeName }}</span>
                            @endif
                        </td>
                        <td>{{ number_format($qty, 0) }}</td>
                        <td>{{ number_format($price, 2) }}</td>
                        <td>{{ number_format($lineTotal, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">لا توجد منتجات</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="total-box">
            @if ($deliveryFee > 0)
                <div class="total-row">
                    <span>التوصيل</span>
                    <strong>{{ number_format($deliveryFee, 2) }} ج.م</strong>
                </div>
            @endif

            @if ($discount > 0)
                <div class="total-header">
                    <span>الإجمالي بعد الخصم</span>
                    <strong>{{ number_format($finalTotal, 2) }} ج.م</strong>
                </div>
            @else
                <div class="total-header">
                    <span>الإجمالي</span>
                    <strong>{{ number_format($total, 2) }} ج.م</strong>
                </div>
            @endif

            @if (!empty($order->charges_breakdown))
                @php
                    $charges = is_string($order->charges_breakdown)
                        ? json_decode($order->charges_breakdown, true)
                        : $order->charges_breakdown;
                @endphp

                @foreach ($charges as $charge)
                    <div class="total-row">
                        <span>
                            {{ $charge['name'] }}
                            ({{ $charge['type'] === 'percentage' ? $charge['value'] . '%' : 'ثابت' }})
                        </span>
                        <strong>
                            {{ number_format($charge['amount'], 2) }} ج.م
                        </strong>
                    </div>
                @endforeach
            @endif

            <div class="total-row">
                <span>المدفوع</span>
                <strong>{{ number_format($paid, 2) }} ج.م</strong>
            </div>

            <div class="total-row">
                <span>الباقي</span>
                <strong>{{ number_format($change, 2) }} ج.م</strong>
            </div>
        </div>

        <div class="line"></div>

        <div class="center">
            <strong>شكراً لزيارتكم</strong>
            <br>
            نتمنى لكم يوماً سعيداً
        </div>

    </div>

    <div class="page-break"></div>

    {{-- تيكت المطبخ --}}
    <div class="receipt">

        <div class="center">
            <div class="kitchen-title">تيكت المطبخ</div>
            <div>طلب رقم: #{{ $order->id }}</div>
            <div class="ltr">{{ optional($order->created_at)->format('Y-m-d h:i A') }}</div>
        </div>

        <div class="line"></div>

        <div class="row">
            <span>نوع الطلب</span>
            <strong>{{ $orderTypeText }}</strong>
        </div>

        @if ($order->table)
            <div class="row">
                <span>الطاولة</span>
                <strong>{{ $order->table->name }}</strong>
            </div>
        @endif

        @if ($order->customer && $order->type === 'delivery')
            <div class="row">
                <span>العميل</span>
                <strong>{{ $order->customer->name }}</strong>
            </div>
        @endif

        @if (!empty($orderNote))
            <div class="note-box kitchen-note">
                <div class="note-title">ملاحظة للمطبخ:</div>
                <div>{{ $orderNote }}</div>
            </div>
        @endif

        <div class="line"></div>

        @forelse ($items as $item)
            @php
                $qty = (float) ($item->pivot->quantity ?? 1);
                $productName = $item->product->name ?? ($item->name ?? '-');
                $sizeName = $item->size ?? null;
            @endphp

            <div class="kitchen-item">
                <div class="row">
                    <span class="kitchen-item-name">
                        {{ $productName }}
                        @if ($sizeName)
                            <br>
                            <span class="muted">{{ $sizeName }}</span>
                        @endif
                    </span>

                    <strong class="kitchen-qty">× {{ number_format($qty, 0) }}</strong>
                </div>
            </div>
        @empty
            <div class="center">لا توجد أصناف</div>
        @endforelse

        <div class="line"></div>

        <div class="center">
            <strong>يرجى تجهيز الطلب</strong>
        </div>

    </div>

    <div class="no-print">
        <a href="{{ route('pos.index') }}" class="btn btn-dark">الرجوع لنقطة البيع</a>
        <a href="#" onclick="window.print(); return false;" class="btn">طباعة مرة أخرى</a>
    </div>

    <script>
        window.addEventListener('load', function() {
            window.print();
        });

        window.onafterprint = function() {
            window.location.replace("{{ route('pos.index') }}");
        };
    </script>


</body>

</html>
