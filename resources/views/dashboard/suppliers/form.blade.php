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
            <label for="name">اسم المورد</label>
            <input type="text" name="name" id="name" class="form-control"
                value="{{ old('name', $supplier->name ?? '') }}" required>
        </div>

        <div class="col-md-6 form-group">
            <label for="code">الكود</label>
            <input type="text" name="code" id="code" class="form-control"
                value="{{ old('code', $supplier->code ?? '') }}">
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 form-group">
            <label for="phone">الهاتف</label>
            <input type="text" name="phone" id="phone" class="form-control"
                value="{{ old('phone', $supplier->phone ?? '') }}">
        </div>

        <div class="col-md-4 form-group">
            <label for="email">البريد الإلكتروني</label>
            <input type="email" name="email" id="email" class="form-control"
                value="{{ old('email', $supplier->email ?? '') }}">
        </div>

        <div class="col-md-4 form-group">
            <label for="payment_terms">شروط الدفع</label>
            <input type="text" name="payment_terms" id="payment_terms" class="form-control"
                value="{{ old('payment_terms', $supplier->payment_terms ?? '') }}">
        </div>
    </div>

    <div class="form-group">
        <label for="address">العنوان</label>
        <textarea name="address" id="address" class="form-control" rows="2">{{ old('address', $supplier->address ?? '') }}</textarea>
    </div>

    <div class="row">
        <div class="col-md-4 form-group">
            <label for="tax_number">الرقم الضريبي</label>
            <input type="text" name="tax_number" id="tax_number" class="form-control"
                value="{{ old('tax_number', $supplier->tax_number ?? '') }}">
        </div>

        <div class="col-md-4 form-group">
            <label for="commercial_register">السجل التجاري</label>
            <input type="text" name="commercial_register" id="commercial_register" class="form-control"
                value="{{ old('commercial_register', $supplier->commercial_register ?? '') }}">
        </div>

        <div class="col-md-4 form-group">
            <label for="credit_limit">حد الائتمان</label>
            <input type="number" step="0.001" name="credit_limit" id="credit_limit" class="form-control"
                value="{{ old('credit_limit', $supplier->credit_limit ?? 0) }}">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 form-group">
            <label for="opening_balance">الرصيد الافتتاحي</label>
            <input type="number" step="0.001" name="opening_balance" id="opening_balance" class="form-control"
                value="{{ old('opening_balance', $supplier->opening_balance ?? 0) }}">
        </div>

        <div class="col-md-6 form-group">
            <label for="current_balance">الرصيد الحالي</label>
            <input type="number" step="0.001" name="current_balance" id="current_balance" class="form-control"
                value="{{ old('current_balance', $supplier->current_balance ?? 0) }}">
        </div>
    </div>

    <div class="form-group">
        <label for="notes">ملاحظات</label>
        <textarea name="notes" id="notes" class="form-control" rows="4">{{ old('notes', $supplier->notes ?? '') }}</textarea>
    </div>

    <div class="form-group form-check text-right">
        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active"
            {{ old('is_active', $supplier->is_active ?? true) ? 'checked' : '' }}>
        <label class="form-check-label mr-4" for="is_active">نشط</label>
    </div>
</div>
