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

    <div class="form-group">
        <label for="name">اسم المادة</label>
        <input type="text" name="name" id="name" class="form-control"
            value="{{ old('name', $material->name ?? '') }}" required>
    </div>

    <div class="row">
        <div class="col-md-6 form-group">
            <label for="sku">الكود / SKU</label>
            <input type="text" name="sku" id="sku" class="form-control"
                value="{{ old('sku', $material->sku ?? '') }}">
        </div>

        <div class="col-md-6 form-group">
            <label for="barcode">الباركود</label>
            <input type="text" name="barcode" id="barcode" class="form-control"
                value="{{ old('barcode', $material->barcode ?? '') }}">
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 form-group">
            <label for="inventory_category_id">الفئة</label>
            <select name="inventory_category_id" id="inventory_category_id" class="form-control">
                <option value="">اختر الفئة</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('inventory_category_id', $material->inventory_category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 form-group">
            <label for="default_supplier_id">المورد الافتراضي</label>
            <select name="default_supplier_id" id="default_supplier_id" class="form-control">
                <option value="">اختر المورد</option>
                @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}"
                        {{ old('default_supplier_id', $material->default_supplier_id ?? '') == $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 form-group">
            <label for="purchase_unit_id">الوحدة</label>
            <select name="purchase_unit_id" id="purchase_unit_id" class="form-control">
                <option value="">اختر الوحدة</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}"
                        {{ old('purchase_unit_id', $material->purchase_unit_id ?? '') == $unit->id ? 'selected' : '' }}>
                        {{ $unit->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 form-group">
            <label for="purchase_price">سعر الشراء</label>
            <input type="number" step="0.001" min="0" name="purchase_price" id="purchase_price"
                class="form-control" value="{{ old('purchase_price', $material->purchase_price ?? 0) }}">
        </div>

        <div class="col-md-4 form-group">
            <label for="avg_cost">متوسط التكلفة</label>
            <input type="number" step="0.001" min="0" name="avg_cost" id="avg_cost"
                class="form-control" value="{{ old('avg_cost', $material->avg_cost ?? 0) }}">
        </div>

        <div class="col-md-4 form-group">
            <label for="last_cost">آخر تكلفة</label>
            <input type="number" step="0.001" min="0" name="last_cost" id="last_cost"
                class="form-control" value="{{ old('last_cost', $material->last_cost ?? 0) }}">
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 form-group">
            <label for="reorder_level">حد إعادة الطلب</label>
            <input type="number" step="0.001" min="0" name="reorder_level" id="reorder_level"
                class="form-control" value="{{ old('reorder_level', $material->reorder_level ?? 0) }}">
        </div>

        <div class="col-md-4 form-group">
            <label for="min_quantity">الحد الأدنى</label>
            <input type="number" step="0.001" min="0" name="min_quantity" id="min_quantity"
                class="form-control" value="{{ old('min_quantity', $material->min_quantity ?? 0) }}">
        </div>

        <div class="col-md-4 form-group">
            <label for="max_quantity">الحد الأقصى</label>
            <input type="number" step="0.001" min="0" name="max_quantity" id="max_quantity"
                class="form-control" value="{{ old('max_quantity', $material->max_quantity ?? 0) }}">
        </div>
    </div>

    <div class="form-group">
        <label for="description">الوصف</label>
        <textarea name="description" id="description" class="form-control" rows="4"
            placeholder="أدخل وصف المادة">{{ old('description', $material->description ?? '') }}</textarea>
    </div>

    <div class="form-group form-check text-right">
        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active"
            {{ old('is_active', $material->is_active ?? true) ? 'checked' : '' }}>
        <label class="form-check-label mr-4" for="is_active">نشط</label>
    </div>
</div>

<hr>

<div class="card card-outline card-warning">
    <div class="card-header">
        <h3 class="card-title">مكونات الإنتاج</h3>
    </div>

    <div class="card-body">
        <div class="form-group form-check text-right">
            <input type="checkbox" name="is_produced" value="1" class="form-check-input" id="is_produced"
                {{ old('is_produced', $material->is_produced ?? false) ? 'checked' : '' }}>
            <label class="form-check-label mr-4" for="is_produced">هذا الصنف يُنتج وله مكونات تصنيع</label>
        </div>

        <div id="recipe-section" style="{{ old('is_produced', $material->is_produced ?? false) ? '' : 'display:none;' }}">
            <div class="row">
                <div class="col-md-4 form-group">
                    <label>كمية الناتج القياسية</label>
                    <input type="number" step="0.001" min="0.001" name="yield_quantity" class="form-control"
                        value="{{ old('yield_quantity', isset($material) && $material->recipe ? $material->recipe->yield_quantity : 1) }}">
                </div>

                <div class="col-md-4 form-group">
                    <label>وحدة الناتج</label>
                    <select name="yield_unit_id" class="form-control">
                        <option value="">اختر الوحدة</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}"
                                {{ old('yield_unit_id', isset($material) && $material->recipe ? $material->recipe->yield_unit_id : '') == $unit->id ? 'selected' : '' }}>
                                {{ $unit->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 form-group">
                    <label>ملاحظات التصنيع</label>
                    <input type="text" name="recipe_notes" class="form-control"
                        value="{{ old('recipe_notes', isset($material) && $material->recipe ? $material->recipe->notes : '') }}">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered text-center" id="recipe-items-table">
                    <thead>
                        <tr>
                            <th>الخامة</th>
                            <th>الوحدة</th>
                            <th>الكمية</th>
                            <th>الهالك %</th>
                            <th>ملاحظات</th>
                            <th>حذف</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $recipeItems = old('recipe_items', isset($material) && $material->recipe ? $material->recipe->items->toArray() : []);
                        @endphp

                        @forelse($recipeItems as $index => $item)
                            <tr>
                                <td>
                                    <select name="recipe_items[{{ $index }}][raw_material_id]" class="form-control">
                                        <option value="">اختر الخامة</option>
                                        @foreach ($materials ?? [] as $rm)
                                            <option value="{{ $rm->id }}"
                                                {{ ($item['raw_material_id'] ?? '') == $rm->id ? 'selected' : '' }}>
                                                {{ $rm->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="recipe_items[{{ $index }}][unit_id]" class="form-control">
                                        <option value="">اختر الوحدة</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}"
                                                {{ ($item['unit_id'] ?? '') == $unit->id ? 'selected' : '' }}>
                                                {{ $unit->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" step="0.001" min="0.001"
                                        name="recipe_items[{{ $index }}][quantity]" class="form-control"
                                        value="{{ $item['quantity'] ?? '' }}">
                                </td>
                                <td>
                                    <input type="number" step="0.01" min="0"
                                        name="recipe_items[{{ $index }}][waste_percent]" class="form-control"
                                        value="{{ $item['waste_percent'] ?? 0 }}">
                                </td>
                                <td>
                                    <input type="text" name="recipe_items[{{ $index }}][notes]" class="form-control"
                                        value="{{ $item['notes'] ?? '' }}">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-recipe-row">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td>
                                    <select name="recipe_items[0][raw_material_id]" class="form-control">
                                        <option value="">اختر الخامة</option>
                                        @foreach ($materials ?? [] as $rm)
                                            <option value="{{ $rm->id }}">{{ $rm->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="recipe_items[0][unit_id]" class="form-control">
                                        <option value="">اختر الوحدة</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="number" step="0.001" min="0.001" name="recipe_items[0][quantity]" class="form-control"></td>
                                <td><input type="number" step="0.01" min="0" name="recipe_items[0][waste_percent]" class="form-control" value="0"></td>
                                <td><input type="text" name="recipe_items[0][notes]" class="form-control"></td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm remove-recipe-row">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <button type="button" class="btn btn-secondary btn-sm" id="add-recipe-row">
                <i class="fas fa-plus"></i> إضافة مكوّن
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const producedCheckbox = document.getElementById('is_produced');
    const recipeSection = document.getElementById('recipe-section');
    let recipeRowIndex = document.querySelectorAll('#recipe-items-table tbody tr').length;

    function toggleRecipeSection() {
        recipeSection.style.display = producedCheckbox.checked ? '' : 'none';
    }

    producedCheckbox.addEventListener('change', toggleRecipeSection);
    toggleRecipeSection();

    document.getElementById('add-recipe-row')?.addEventListener('click', function () {
        const row = `
            <tr>
                <td>
                    <select name="recipe_items[${recipeRowIndex}][raw_material_id]" class="form-control">
                        <option value="">اختر الخامة</option>
                        @foreach ($materials ?? [] as $rm)
                            <option value="{{ $rm->id }}">{{ $rm->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="recipe_items[${recipeRowIndex}][unit_id]" class="form-control">
                        <option value="">اختر الوحدة</option>
                        @foreach ($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" step="0.001" min="0.001" name="recipe_items[${recipeRowIndex}][quantity]" class="form-control"></td>
                <td><input type="number" step="0.01" min="0" name="recipe_items[${recipeRowIndex}][waste_percent]" class="form-control" value="0"></td>
                <td><input type="text" name="recipe_items[${recipeRowIndex}][notes]" class="form-control"></td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-recipe-row">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;
        document.querySelector('#recipe-items-table tbody').insertAdjacentHTML('beforeend', row);
        recipeRowIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-recipe-row')) {
            const rows = document.querySelectorAll('#recipe-items-table tbody tr');
            if (rows.length > 1) {
                e.target.closest('tr').remove();
            }
        }
    });
});
</script>