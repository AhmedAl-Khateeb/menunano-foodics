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

        <div class="col-md-6 mb-3">
            <label>اسم المورد <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $supplier->name ?? '') }}"
                required>
        </div>

        <div class="col-md-6 mb-3">
            <label>كود المورد</label>
            <input type="text" name="code" class="form-control" value="{{ old('code', $supplier->code ?? '') }}">
        </div>

        <div class="col-md-4 mb-3">
            <label>اسم الاتصال</label>
            <input type="text" name="contact_name" class="form-control"
                value="{{ old('contact_name', $supplier->contact_name ?? '') }}">
        </div>

        <div class="col-md-4 mb-3">
            <label>الهاتف</label>
            <input type="text" name="phone" class="form-control"
                value="{{ old('phone', $supplier->phone ?? '') }}">
        </div>

        <div class="col-md-4 mb-3">
            <label>البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control"
                value="{{ old('email', $supplier->email ?? '') }}">
        </div>

        <div class="col-md-12 mb-2">
            <div class="form-check">
                <input type="checkbox" name="is_active" value="1" class="form-check-input"
                    id="is_active_{{ $supplier->id ?? 'create' }}"
                    {{ old('is_active', $supplier->is_active ?? true) ? 'checked' : '' }}>

                <label class="form-check-label" for="is_active_{{ $supplier->id ?? 'create' }}">
                    نشط
                </label>
            </div>
        </div>

    </div>

</div>
