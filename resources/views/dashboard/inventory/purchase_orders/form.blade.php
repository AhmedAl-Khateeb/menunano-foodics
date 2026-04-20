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
            <select name="supplier_id" class="form-control" required>
                <option value="">اختر المورد</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}"
                        {{ old('supplier_id', $purchase_order->supplier_id ?? '') == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 form-group">
            <label>طلب الشراء</label>
            <select name="purchase_request_id" class="form-control">
                <option value="">بدون طلب شراء</option>
                @foreach ($purchaseRequests as $purchaseRequest)
                    @php
                        $requestItemsJson = $purchaseRequest->items
                            ->map(function ($item) {
                                return [
                                    'raw_material_id' => $item->raw_material_id,
                                    'unit_id' => $item->unit_id,
                                    'quantity' =>
                                        (float) ($item->approved_quantity > 0
                                            ? $item->approved_quantity
                                            : $item->requested_quantity),
                                    'unit_price' => 0,
                                    'notes' => $item->notes,
                                ];
                            })
                            ->values()
                            ->toJson();
                    @endphp

                    <option value="{{ $purchaseRequest->id }}" data-items="{{ e($requestItemsJson) }}"
                        {{ old('purchase_request_id', $purchase_order->purchase_request_id ?? '') == $purchaseRequest->id ? 'selected' : '' }}>
                        {{ $purchaseRequest->request_number }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 form-group">
            <label>تاريخ الأمر</label>
            <input type="date" name="po_date" class="form-control"
                value="{{ old('po_date', isset($purchase_order) ? optional($purchase_order->po_date)->format('Y-m-d') : now()->format('Y-m-d')) }}"
                required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 form-group">
            <label>التاريخ المتوقع</label>
            <input type="date" name="expected_date" class="form-control"
                value="{{ old('expected_date', isset($purchase_order) && $purchase_order->expected_date ? $purchase_order->expected_date->format('Y-m-d') : '') }}">
        </div>

        <div class="col-md-4 form-group">
            <label>الخصم</label>
            <input type="number" step="0.001" min="0" name="discount" id="discount"
                class="form-control calc-input" value="{{ old('discount', $purchase_order->discount ?? 0) }}">
        </div>

        <div class="col-md-4 form-group">
            <label>الضريبة</label>
            <input type="number" step="0.001" min="0" name="tax" id="tax"
                class="form-control calc-input" value="{{ old('tax', $purchase_order->tax ?? 0) }}">
        </div>
    </div>

    <div class="form-group">
        <label>ملاحظات</label>
        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $purchase_order->notes ?? '') }}</textarea>
    </div>

    <hr>
    <h5 class="mb-3">أصناف أمر الشراء</h5>

    <div class="table-responsive">
        <table class="table table-bordered text-center" id="items-table">
            <thead>
                <tr>
                    <th>الصنف</th>
                    <th>الوحدة</th>
                    <th>الكمية</th>
                    <th>سعر الوحدة</th>
                    <th>الإجمالي</th>
                    <th>ملاحظات</th>
                    <th>حذف</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $oldItems = old('items');
                    $itemsSource = $oldItems ?? (isset($purchase_order) ? $purchase_order->items->toArray() : []);
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
                        <td>
                            <input type="number" step="0.001" min="0.001"
                                name="items[{{ $index }}][quantity]" class="form-control item-qty"
                                value="{{ $item['quantity'] ?? '' }}" required>
                        </td>
                        <td>
                            <input type="number" step="0.001" min="0"
                                name="items[{{ $index }}][unit_price]" class="form-control item-price"
                                value="{{ $item['unit_price'] ?? '' }}" required>
                        </td>
                        <td>
                            <input type="text" class="form-control item-total" readonly
                                value="{{ number_format(($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0), 3, '.', '') }}">
                        </td>
                        <td>
                            <input type="text" name="items[{{ $index }}][notes]" class="form-control"
                                value="{{ $item['notes'] ?? '' }}">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-row">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
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
                        <td><input type="number" step="0.001" min="0" name="items[0][unit_price]"
                                class="form-control item-price" required></td>
                        <td><input type="text" class="form-control item-total" readonly></td>
                        <td><input type="text" name="items[0][notes]" class="form-control"></td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-row">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
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
            <label>الإجمالي قبل الخصم والضريبة</label>
            <input type="number" step="0.001" min="0" name="subtotal" id="subtotal"
                class="form-control" readonly value="{{ old('subtotal', $purchase_order->subtotal ?? 0) }}">
        </div>

        <div class="col-md-4 form-group">
            <label>الإجمالي النهائي</label>
            <input type="number" step="0.001" min="0" name="total" id="total" class="form-control"
                readonly value="{{ old('total', $purchase_order->total ?? 0) }}">
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let rowIndex = document.querySelectorAll('#items-table tbody tr').length;

        document.getElementById('add-row').addEventListener('click', function() {
            const row = `
                <tr>
                    <td>
                        <select name="items[${rowIndex}][raw_material_id]" class="form-control" required>
                            <option value="">اختر الصنف</option>
                            @foreach ($materials as $material)
                                <option value="{{ $material->id }}">{{ $material->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="items[${rowIndex}][unit_id]" class="form-control">
                            <option value="">اختر الوحدة</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" step="0.001" min="0.001" name="items[${rowIndex}][quantity]" class="form-control item-qty" required></td>
                    <td><input type="number" step="0.001" min="0" name="items[${rowIndex}][unit_price]" class="form-control item-price" required></td>
                    <td><input type="text" class="form-control item-total" readonly></td>
                    <td><input type="text" name="items[${rowIndex}][notes]" class="form-control"></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                </tr>
            `;
            document.querySelector('#items-table tbody').insertAdjacentHTML('beforeend', row);
            rowIndex++;
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-row')) {
                const rows = document.querySelectorAll('#items-table tbody tr');
                if (rows.length > 1) {
                    e.target.closest('tr').remove();
                    calculateTotals();
                }
            }
        });

        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('item-qty') ||
                e.target.classList.contains('item-price') ||
                e.target.classList.contains('calc-input')) {
                calculateTotals();
            }
        });

        function calculateTotals() {
            let subtotal = 0;

            document.querySelectorAll('#items-table tbody tr').forEach(row => {
                const qty = parseFloat(row.querySelector('.item-qty')?.value || 0);
                const price = parseFloat(row.querySelector('.item-price')?.value || 0);
                const total = qty * price;

                const totalInput = row.querySelector('.item-total');
                if (totalInput) {
                    totalInput.value = total.toFixed(3);
                }

                subtotal += total;
            });

            const discount = parseFloat(document.getElementById('discount')?.value || 0);
            const tax = parseFloat(document.getElementById('tax')?.value || 0);
            const finalTotal = subtotal - discount + tax;

            document.getElementById('subtotal').value = subtotal.toFixed(3);
            document.getElementById('total').value = finalTotal.toFixed(3);
        }

        calculateTotals();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const purchaseRequestSelect = document.querySelector('select[name="purchase_request_id"]');
        if (!purchaseRequestSelect) return;

        purchaseRequestSelect.addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            const itemsJson = selected.dataset.items;
            if (!itemsJson) return;

            const items = JSON.parse(itemsJson);
            const tbody = document.querySelector('#items-table tbody');
            tbody.innerHTML = '';

            items.forEach((item, index) => {
                const row = `
                <tr>
                    <td>
                        <select name="items[${index}][raw_material_id]" class="form-control" required>
                            <option value="">اختر الصنف</option>
                            @foreach ($materials as $material)
                                <option value="{{ $material->id }}" ${item.raw_material_id == {{ $material->id }} ? 'selected' : ''}>
                                    {{ $material->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="items[${index}][unit_id]" class="form-control">
                            <option value="">اختر الوحدة</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}" ${item.unit_id == {{ $unit->id }} ? 'selected' : ''}>
                                    {{ $unit->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" step="0.001" min="0.001" name="items[${index}][quantity]" class="form-control item-qty" value="${item.quantity}" required></td>
                    <td><input type="number" step="0.001" min="0" name="items[${index}][unit_price]" class="form-control item-price" value="${item.unit_price}" required></td>
                    <td><input type="text" class="form-control item-total" readonly></td>
                    <td><input type="text" name="items[${index}][notes]" class="form-control" value="${item.notes ?? ''}"></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button></td>
                </tr>
            `;
                tbody.insertAdjacentHTML('beforeend', row);
            });

            if (typeof calculateTotals === 'function') {
                calculateTotals();
            }
        });
    });
</script>
