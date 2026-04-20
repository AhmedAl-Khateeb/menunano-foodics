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
            <label>من فرع</label>
            <select name="from_branch_id" class="form-control" required>
                <option value="">اختر الفرع</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}"
                        {{ old('from_branch_id', $transfer_request->from_branch_id ?? '') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 form-group">
            <label>إلى فرع</label>
            <select name="to_branch_id" class="form-control" required>
                <option value="">اختر الفرع</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}"
                        {{ old('to_branch_id', $transfer_request->to_branch_id ?? '') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 form-group">
            <label>تاريخ التحويل</label>
            <input type="date" name="transfer_date" class="form-control"
                value="{{ old('transfer_date', isset($transfer_request) ? optional($transfer_request->transfer_date)->format('Y-m-d') : now()->format('Y-m-d')) }}"
                required>
        </div>
    </div>

    <div class="form-group">
        <label>ملاحظات</label>
        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $transfer_request->notes ?? '') }}</textarea>
    </div>

    <hr>
    <h5 class="mb-3">أصناف التحويل</h5>

    <div class="table-responsive">
        <table class="table table-bordered text-center" id="items-table">
            <thead>
                <tr>
                    <th>الصنف</th>
                    <th>الوحدة</th>
                    <th>الكمية المطلوبة</th>
                    <th>الكمية المرسلة</th>
                    <th>الكمية المستلمة</th>
                    <th>ملاحظات</th>
                    <th>حذف</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $oldItems = old('items');
                    $itemsSource = $oldItems ?? (isset($transfer_request) ? $transfer_request->items->toArray() : []);
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
                        <td><input type="number" step="0.001" min="0.001"
                                name="items[{{ $index }}][requested_quantity]" class="form-control"
                                value="{{ $item['requested_quantity'] ?? '' }}" required></td>
                        <td><input type="number" step="0.001" min="0"
                                name="items[{{ $index }}][sent_quantity]" class="form-control"
                                value="{{ $item['sent_quantity'] ?? 0 }}"></td>
                        <td><input type="number" step="0.001" min="0"
                                name="items[{{ $index }}][received_quantity]" class="form-control"
                                value="{{ $item['received_quantity'] ?? 0 }}"></td>
                        <td><input type="text" name="items[{{ $index }}][notes]" class="form-control"
                                value="{{ $item['notes'] ?? '' }}"></td>
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
                        </td>
                        <td>
                            <select name="items[0][unit_id]" class="form-control">
                                <option value="">اختر الوحدة</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" step="0.001" min="0.001" name="items[0][requested_quantity]"
                                class="form-control" required></td>
                        <td><input type="number" step="0.001" min="0" name="items[0][sent_quantity]"
                                class="form-control" value="0"></td>
                        <td><input type="number" step="0.001" min="0" name="items[0][received_quantity]"
                                class="form-control" value="0"></td>
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
                <td><input type="number" step="0.001" min="0.001" name="items[${rowIndex}][requested_quantity]" class="form-control" required></td>
                <td><input type="number" step="0.001" min="0" name="items[${rowIndex}][sent_quantity]" class="form-control" value="0"></td>
                <td><input type="number" step="0.001" min="0" name="items[${rowIndex}][received_quantity]" class="form-control" value="0"></td>
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
    });
</script>
