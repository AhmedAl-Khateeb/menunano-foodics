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
            <label>الصنف المنتج</label>
            <select name="recipe_id" id="recipe_id" class="form-control" required>
                <option value="">اختر الصنف المنتج</option>
                @foreach ($recipes as $recipe)
                    @php
                        $recipeItems = $recipe->items
                            ->map(function ($item) {
                                return [
                                    'raw_material_id' => $item->raw_material_id,
                                    'unit_id' => $item->unit_id,
                                    'planned_quantity' => (float) $item->quantity,
                                    'consumed_quantity' => (float) $item->quantity,
                                ];
                            })
                            ->values()
                            ->toJson();
                    @endphp

                    <option value="{{ $recipe->id }}"
                        data-items="{{ e($recipeItems) }}"
                        {{ old('recipe_id', $production_order->recipe_id ?? '') == $recipe->id ? 'selected' : '' }}>
                        {{ $recipe->outputMaterial->name ?? $recipe->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 form-group">
            <label>تاريخ الإنتاج</label>
            <input type="date" name="production_date" class="form-control"
                value="{{ old('production_date', isset($production_order) ? optional($production_order->production_date)->format('Y-m-d') : now()->format('Y-m-d')) }}"
                required>
        </div>

        <div class="col-md-4 form-group">
            <label>الكمية المخططة</label>
            <input type="number" step="0.001" min="0.001" name="planned_quantity" class="form-control"
                value="{{ old('planned_quantity', $production_order->planned_quantity ?? 1) }}" required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 form-group">
            <label>الكمية المنتجة</label>
            <input type="number" step="0.001" min="0.001" name="produced_quantity" class="form-control"
                value="{{ old('produced_quantity', $production_order->produced_quantity ?? 1) }}" required>
        </div>
    </div>

    <div class="form-group">
        <label>ملاحظات</label>
        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $production_order->notes ?? '') }}</textarea>
    </div>

    <hr>
    <h5 class="mb-3">الخامات المستهلكة</h5>

    <div class="table-responsive">
        <table class="table table-bordered text-center" id="items-table">
            <thead>
                <tr>
                    <th>الخامة</th>
                    <th>الوحدة</th>
                    <th>الكمية المخططة</th>
                    <th>الكمية المستهلكة</th>
                    <th>حذف</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $oldItems = old('items');
                    $itemsSource = $oldItems ?? (isset($production_order) ? $production_order->items->toArray() : []);
                @endphp

                @forelse($itemsSource as $index => $item)
                    <tr>
                        <td>
                            <select name="items[{{ $index }}][raw_material_id]" class="form-control" required>
                                <option value="">اختر الخامة</option>
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
                                name="items[{{ $index }}][planned_quantity]" class="form-control"
                                value="{{ $item['planned_quantity'] ?? '' }}" required>
                        </td>
                        <td>
                            <input type="number" step="0.001" min="0.001"
                                name="items[{{ $index }}][consumed_quantity]" class="form-control"
                                value="{{ $item['consumed_quantity'] ?? '' }}" required>
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
                                <option value="">اختر الخامة</option>
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
                        <td>
                            <input type="number" step="0.001" min="0.001"
                                name="items[0][planned_quantity]" class="form-control" required>
                        </td>
                        <td>
                            <input type="number" step="0.001" min="0.001"
                                name="items[0][consumed_quantity]" class="form-control" required>
                        </td>
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
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let rowIndex = document.querySelectorAll('#items-table tbody tr').length;

    document.getElementById('add-row').addEventListener('click', function () {
        const row = `
            <tr>
                <td>
                    <select name="items[${rowIndex}][raw_material_id]" class="form-control" required>
                        <option value="">اختر الخامة</option>
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
                <td>
                    <input type="number" step="0.001" min="0.001"
                        name="items[${rowIndex}][planned_quantity]" class="form-control" required>
                </td>
                <td>
                    <input type="number" step="0.001" min="0.001"
                        name="items[${rowIndex}][consumed_quantity]" class="form-control" required>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-row">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        document.querySelector('#items-table tbody').insertAdjacentHTML('beforeend', row);
        rowIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-row')) {
            const rows = document.querySelectorAll('#items-table tbody tr');
            if (rows.length > 1) {
                e.target.closest('tr').remove();
            }
        }
    });

    const recipeSelect = document.getElementById('recipe_id');
    if (!recipeSelect) return;

    recipeSelect.addEventListener('change', function () {
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
                            <option value="">اختر الخامة</option>
                            @foreach ($materials as $material)
                                <option value="{{ $material->id }}" ${String(item.raw_material_id) === "{{ $material->id }}" ? 'selected' : ''}>
                                    {{ $material->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="items[${index}][unit_id]" class="form-control">
                            <option value="">اختر الوحدة</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}" ${String(item.unit_id) === "{{ $unit->id }}" ? 'selected' : ''}>
                                    {{ $unit->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" step="0.001" min="0.001"
                            name="items[${index}][planned_quantity]" class="form-control"
                            value="${item.planned_quantity}" required>
                    </td>
                    <td>
                        <input type="number" step="0.001" min="0.001"
                            name="items[${index}][consumed_quantity]" class="form-control"
                            value="${item.consumed_quantity}" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-row">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            tbody.insertAdjacentHTML('beforeend', row);
        });

        rowIndex = items.length;
    });
});
</script>