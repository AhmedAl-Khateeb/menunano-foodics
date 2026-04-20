<div class="card-body text-right">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4 form-group">
            <label>المورد</label>
            <select name="supplier_id" id="supplier_id" class="form-control" required>
                <option value="">اختر المورد</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}"
                        {{ old('supplier_id', $receipt->supplier_id ?? '') == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 form-group">
            <label>أمر الشراء</label>
            <select name="purchase_order_id" id="purchase_order_id" class="form-control">
                <option value="">بدون أمر شراء</option>

                @foreach ($purchaseOrders as $order)
                    @php
                        $orderItemsJson = $order->items
                            ->map(function ($item) {
                                return [
                                    'purchase_order_item_id' => $item->id,
                                    'raw_material_id' => $item->raw_material_id,
                                    'raw_material_name' => $item->rawMaterial->name ?? '',
                                    'unit_id' => $item->unit_id,
                                    'unit_name' => $item->unit->name ?? '',
                                    'quantity' => (float) ($item->quantity - $item->received_quantity),
                                    'unit_cost' => (float) $item->unit_price,
                                ];
                            })
                            ->values()
                            ->toJson();
                    @endphp

                    <option value="{{ $order->id }}" data-supplier="{{ $order->supplier_id }}"
                        data-items='{{ $orderItemsJson }}'
                        {{ old('purchase_order_id', $receipt->purchase_order_id ?? '') == $order->id ? 'selected' : '' }}>
                        {{ $order->po_number }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 form-group">
            <label>تاريخ الاستلام</label>
            <input type="date" name="receipt_date" class="form-control"
                value="{{ old('receipt_date', isset($receipt) ? optional($receipt->receipt_date)->format('Y-m-d') : now()->format('Y-m-d')) }}"
                required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 form-group">
            <label>الخصم</label>
            <input type="number" step="0.001" min="0" name="discount" id="discount"
                class="form-control calc-input" value="{{ old('discount', $receipt->discount ?? 0) }}">
        </div>

        <div class="col-md-4 form-group">
            <label>الضريبة</label>
            <input type="number" step="0.001" min="0" name="tax" id="tax"
                class="form-control calc-input" value="{{ old('tax', $receipt->tax ?? 0) }}">
        </div>

        <div class="col-md-4 form-group">
            <label>الإجمالي قبل الخصم والضريبة</label>
            <input type="number" step="0.001" name="subtotal" id="subtotal" class="form-control" readonly
                value="{{ old('subtotal', $receipt->subtotal ?? 0) }}">
        </div>
    </div>

    <div class="form-group">
        <label>ملاحظات</label>
        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $receipt->notes ?? '') }}</textarea>
    </div>

    <hr>
    <h5 class="mb-3">أصناف الاستلام</h5>

    <div class="table-responsive">
        <table class="table table-bordered text-center" id="items-table">
            <thead>
                <tr>
                    <th>الصنف</th>
                    <th>الوحدة</th>
                    <th>الكمية</th>
                    <th>تكلفة الوحدة</th>
                    <th>الإجمالي</th>
                    <th>حذف</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $oldItems = old('items');
                    $itemsSource = $oldItems ?? (isset($receipt) ? $receipt->items->toArray() : []);
                @endphp

                @forelse($itemsSource as $index => $item)
                    <tr>
                        <td>
                            <select name="items[{{ $index }}][raw_material_id]" class="form-control" required>
                                <option value="">اختر الصنف</option>
                                @foreach ($materials as $material)
                                    <option value="{{ $material->id }}"
                                        {{ ($item['raw_material_id'] ?? null) == $material->id ? 'selected' : '' }}>
                                        {{ $material->name }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="items[{{ $index }}][purchase_order_item_id]"
                                value="{{ $item['purchase_order_item_id'] ?? '' }}">
                        </td>
                        <td>
                            <select name="items[{{ $index }}][unit_id]" class="form-control">
                                <option value="">اختر الوحدة</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}"
                                        {{ ($item['unit_id'] ?? null) == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" step="0.001" min="0.001"
                                name="items[{{ $index }}][quantity]" class="form-control item-qty"
                                value="{{ $item['quantity'] ?? '' }}" required></td>
                        <td><input type="number" step="0.001" min="0"
                                name="items[{{ $index }}][unit_cost]" class="form-control item-cost"
                                value="{{ $item['unit_cost'] ?? '' }}" required></td>
                        <td><input type="text" class="form-control item-total" readonly></td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-row"><i
                                    class="fas fa-trash"></i></button></td>
                    </tr>
                @empty
                    <tr>
                        <td>
                            <select name="items[0][raw_material_id]" class="form-control" required>
                                <option value="">اختر الصنف</option>
                                @foreach ($materials as $material)
                                    <option value="{{ $material->id }}">{{ $material->name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="items[0][purchase_order_item_id]">
                        </td>
                        <td>
                            <select name="items[0][unit_id]" class="form-control">
                                <option value="">اختر الوحدة</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" step="0.001" min="0.001" name="items[0][quantity]"
                                class="form-control item-qty" required></td>
                        <td><input type="number" step="0.001" min="0" name="items[0][unit_cost]"
                                class="form-control item-cost" required></td>
                        <td><input type="text" class="form-control item-total" readonly></td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-row"><i
                                    class="fas fa-trash"></i></button></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <button type="button" class="btn btn-secondary btn-sm mb-3" id="add-row">
        <i class="fas fa-plus"></i> إضافة سطر
    </button>

    <div class="row">
        <div class="col-md-4 form-group">
            <label>الإجمالي النهائي</label>
            <input type="number" step="0.001" name="total" id="total" class="form-control" readonly
                value="{{ old('total', $receipt->total ?? 0) }}">
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let rowIndex = document.querySelectorAll('#items-table tbody tr').length;

        function recalc() {
            let subtotal = 0;
            document.querySelectorAll('#items-table tbody tr').forEach(row => {
                const qty = parseFloat(row.querySelector('.item-qty')?.value || 0);
                const cost = parseFloat(row.querySelector('.item-cost')?.value || 0);
                const total = qty * cost;
                const totalInput = row.querySelector('.item-total');
                if (totalInput) totalInput.value = total.toFixed(3);
                subtotal += total;
            });

            const discount = parseFloat(document.getElementById('discount')?.value || 0);
            const tax = parseFloat(document.getElementById('tax')?.value || 0);
            const finalTotal = subtotal - discount + tax;

            document.getElementById('subtotal').value = subtotal.toFixed(3);
            document.getElementById('total').value = finalTotal.toFixed(3);
        }

        function buildRow(index, item = null) {
            return `
            <tr>
                <td>
                    <select name="items[${index}][raw_material_id]" class="form-control" required>
                        <option value="">اختر الصنف</option>
                        @foreach ($materials as $material)
                            <option value="{{ $material->id }}" ${item && item.raw_material_id == {{ $material->id }} ? 'selected' : ''}>
                                {{ $material->name }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="items[${index}][purchase_order_item_id]" value="${item?.purchase_order_item_id ?? ''}">
                </td>
                <td>
                    <select name="items[${index}][unit_id]" class="form-control">
                        <option value="">اختر الوحدة</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}" ${item && item.unit_id == {{ $unit->id }} ? 'selected' : ''}>
                                {{ $unit->name }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" step="0.001" min="0.001" name="items[${index}][quantity]" class="form-control item-qty" value="${item?.quantity ?? ''}" required></td>
                <td><input type="number" step="0.001" min="0" name="items[${index}][unit_cost]" class="form-control item-cost" value="${item?.unit_cost ?? ''}" required></td>
                <td><input type="text" class="form-control item-total" readonly></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
            </tr>
        `;
        }

        document.getElementById('add-row')?.addEventListener('click', function() {
            document.querySelector('#items-table tbody').insertAdjacentHTML('beforeend', buildRow(
                rowIndex));
            rowIndex++;
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-row')) {
                const rows = document.querySelectorAll('#items-table tbody tr');
                if (rows.length > 1) {
                    e.target.closest('tr').remove();
                    recalc();
                }
            }
        });

        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('item-qty') ||
                e.target.classList.contains('item-cost') ||
                e.target.classList.contains('calc-input')) {
                recalc();
            }
        });

        document.getElementById('purchase_order_id')?.addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            const supplierId = selected.dataset.supplier;
            const itemsJson = selected.dataset.items;

            if (supplierId) {
                document.getElementById('supplier_id').value = supplierId;
            }

            if (itemsJson) {
                const items = JSON.parse(itemsJson);
                const tbody = document.querySelector('#items-table tbody');
                tbody.innerHTML = '';

                items.forEach((item, idx) => {
                    tbody.insertAdjacentHTML('beforeend', buildRow(idx, item));
                });

                rowIndex = items.length;
                recalc();
            }
        });

        recalc();
    });
</script>
