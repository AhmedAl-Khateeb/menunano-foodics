<div>
    <div class="card border-0 shadow-sm rounded-lg mb-4">
        <div class="card-header bg-white border-bottom pt-4 pb-3 text-right">
            <h3 class="card-title font-weight-bold text-dark mb-0 float-right">الجرد والتسويات (مطابقة الأرصدة)</h3>
        </div>
        
        <div class="card-body bg-light text-right">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('info'))
                <div class="alert alert-info">{{ session('info') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row align-items-center mb-4">
                <div class="col-md-6 text-right">
                    <p class="text-muted mb-0">قم بإدخال "الكمية الفعلية" التي تم جردها في المخزن للمقارنة مع رصيد النظام وتصحيح الفروقات.</p>
                </div>
                <div class="col-md-6 text-left">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-white border-0 shadow-sm"><i class="fas fa-search text-muted"></i></span>
                        </div>
                        <input type="text" wire:model.live.debounce.300ms="searchQuery" class="form-control border-0 shadow-sm" placeholder="ابحث عن منتج، مادة خام، كود...">
                    </div>
                </div>
            </div>

            <div class="table-responsive bg-white rounded shadow-sm">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="border-top-0 border-bottom-0 pl-3">اسم الصنف (الكود)</th>
                            <th class="text-center border-top-0 border-bottom-0 w-25">رصيد النظام (الحالي)</th>
                            <th class="text-center border-top-0 border-bottom-0 w-25">الكمية الفعلية بالمخزن</th>
                            <th class="text-center border-top-0 border-bottom-0 w-25">الفرق (عجز / فائض)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            @php
                                $invId = $item['id'];
                                $systemQty = $item['system_qty'];
                                $physicalQty = isset($physicalCounts[$invId]) ? floatval($physicalCounts[$invId]) : $systemQty;
                                $diff = $physicalQty - $systemQty;
                            @endphp
                            <tr class="{{ round($diff, 3) != 0 ? 'bg-warning-light' : '' }}">
                                <td class="pl-3 font-weight-bold text-dark">
                                    {{ $item['name'] }}
                                    @if($item['sku'] !== '-')
                                        <br><small class="text-muted">{{ $item['sku'] }}</small>
                                    @endif
                                </td>
                                <td class="text-center bg-light">
                                    <span class="font-weight-bold h5 text-primary mb-0">{{ number_format($systemQty, 3) }}</span> <small class="text-muted">{{ $item['unit'] }}</small>
                                </td>
                                <td>
                                    <div class="input-group input-group-sm w-75 mx-auto">
                                        <input type="number" step="0.001" min="0" wire:model.live.debounce.800ms="physicalCounts.{{ $invId }}" class="form-control text-center font-weight-bold" style="font-size: 1.1rem; border: 2px solid {{ round($diff, 3) != 0 ? '#ffc107' : '#28a745' }};">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-white">{{ $item['unit'] }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center align-middle font-weight-bold h6 mb-0" style="color: {{ $diff > 0 ? '#28a745' : ($diff < 0 ? '#dc3545' : '#6c757d') }}">
                                    {{ number_format($diff, 3) }}
                                    <small class="d-block mt-1">{{ $diff > 0 ? '(فائض)' : ($diff < 0 ? '(عجز)' : 'مطابق') }}</small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    <i class="fas fa-box-open text-gray-300 block mb-3" style="font-size: 3rem;"></i><br>
                                    لم يتم العثور على أصناف للبحث: "{{ $searchQuery }}"
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-4 border-top pt-4">
                <button type="button" wire:click="saveReconciliation" class="btn btn-primary btn-lg px-5 shadow font-weight-bold rounded-pill" onclick="return confirm('هل أنت متأكد من حفظ التسوية الجردية؟ سيتم تحديث أرصدة النظام وتسجيل حركات التسوية')" wire:loading.attr="disabled">
                    <i class="fas fa-check-double mr-2"></i> اعتماد التسويات (تسجيل الجرد)
                </button>
                <div wire:loading wire:target="saveReconciliation" class="d-block mt-2 text-muted">جاري معالجة الفروقات وحفظ الأرصدة...</div>
            </div>
        </div>
    </div>

    <style>
        .bg-warning-light { background-color: rgba(255, 193, 7, 0.1) !important; }
    </style>
</div>
