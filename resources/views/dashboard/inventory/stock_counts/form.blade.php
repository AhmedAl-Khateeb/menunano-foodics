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
        <div class="col-md-6 form-group">
            <label>تاريخ الجرد</label>
            <input type="date" name="count_date" class="form-control"
                value="{{ old('count_date', isset($stock_count) ? optional($stock_count->count_date)->format('Y-m-d') : now()->format('Y-m-d')) }}"
                required>
        </div>

        <div class="col-md-6 form-group">
            <label>نوع الجرد</label>
            <select name="type" class="form-control" required>
                <option value="full" {{ old('type', $stock_count->type ?? 'full') == 'full' ? 'selected' : '' }}>جرد
                    كامل</option>
                <option value="spot" {{ old('type', $stock_count->type ?? '') == 'spot' ? 'selected' : '' }}>جرد جزئي
                </option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label>ملاحظات</label>
        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $stock_count->notes ?? '') }}</textarea>
    </div>

    <hr>
    <h5 class="mb-3">أصناف الجرد</h5>

    <div class="table-responsive">
        <table class="table table-bordered text-center" id="items-table">
            <thead>
                <tr>
                    <th>الصنف</th>
                    <th>رصيد النظام</th>
                    <th>الكمية الفعلية</th>
                    <th>الفرق</th>
                    <th>ملاحظات</th>
                    <th>حذف</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $oldItems = old('items');
                    $itemsSource = $oldItems ?? (isset($stock_count) ? $stock_count->items->toArray() : []);
                @endphp

                @forelse($itemsSource as $index => $item)
                    @php
                        $selectedInventory = $inventories->firstWhere('id', $item['inventory_id'] ?? null);
                        $systemQty = $item['system_quantity'] ?? ($selectedInventory->current_quantity ?? 0);
                        $physicalQty = $item['physical_quantity'] ?? 0;
                    @endphp
                    <tr>
                        <td>
                            <select name="items[{{ $index }}][inventory_id]"
                                class="form-control inventory-select" required>
                                <option value="">اختر الصنف</option>
                                @foreach ($inventories as $inventory)
                                    <option value="{{ $inventory->id }}"
                                        data-system="{{ $inventory->current_quantity }}"
                                        {{ ($item['inventory_id'] ?? null) == $inventory->id ? 'selected' : '' }}>
                                        {{ $inventory->inventoriable->name ?? 'غير معروف' }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control system-qty"
                                value="{{ number_format($systemQty, 3, '.', '') }}" readonly>
                        </td>
                        <td>
                            <input type="number" step="0.001" min="0"
                                name="items[{{ $index }}][physical_quantity]" class="form-control physical-qty"
                                value="{{ $physicalQty }}" required>
                        </td>
                        <td>
                            <input type="text" class="form-control diff-qty" readonly>
                        </td>
                        <td>
                            <input type="text" name="items[{{ $index }}][notes]" class="form-control"
                                value="{{ $item['notes'] ?? '' }}">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-row"><i
                                    class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>
                            <select name="items[0][inventory_id]" class="form-control inventory-select" required>
                                <option value="">اختر الصنف</option>
                                @foreach ($inventories as $inventory)
                                    <option value="{{ $inventory->id }}"
                                        data-system="{{ $inventory->current_quantity }}">
                                        {{ $inventory->inventoriable->name ?? 'غير معروف' }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="text" class="form-control system-qty" readonly></td>
                        <td><input type="number" step="0.001" min="0" name="items[0][physical_quantity]"
                                class="form-control physical-qty" required></td>
                        <td><input type="text" class="form-control diff-qty" readonly></td>
                        <td><input type="text" name="items[0][notes]" class="form-control"></td>
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
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let rowIndex = document.querySelectorAll('#items-table tbody tr').length;

        document.getElementById('add-row').addEventListener('click', function() {
            const row = `
            <tr>
                <td>
                    <select name="items[${rowIndex}][inventory_id]" class="form-control inventory-select" required>
                        <option value="">اختر الصنف</option>
                        @foreach ($inventories as $inventory)
                            <option value="{{ $inventory->id }}" data-system="{{ $inventory->current_quantity }}">
                                {{ $inventory->inventoriable->name ?? 'غير معروف' }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" class="form-control system-qty" readonly></td>
                <td><input type="number" step="0.001" min="0" name="items[${rowIndex}][physical_quantity]" class="form-control physical-qty" required></td>
                <td><input type="text" class="form-control diff-qty" readonly></td>
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
                }
            }
        });

        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('inventory-select')) {
                const row = e.target.closest('tr');
                const selected = e.target.options[e.target.selectedIndex];
                const system = parseFloat(selected.dataset.system || 0);
                row.querySelector('.system-qty').value = system.toFixed(3);
                updateDiff(row);
            }
        });

        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('physical-qty')) {
                updateDiff(e.target.closest('tr'));
            }
        });

        function updateDiff(row) {
            const system = parseFloat(row.querySelector('.system-qty')?.value || 0);
            const physical = parseFloat(row.querySelector('.physical-qty')?.value || 0);
            row.querySelector('.diff-qty').value = (physical - system).toFixed(3);
        }

        document.querySelectorAll('#items-table tbody tr').forEach(updateDiff);
    });
</script>
