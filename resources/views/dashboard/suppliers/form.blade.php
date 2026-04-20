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
            <label for="name">الاسم <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control"
                value="{{ old('name', $supplier->name ?? '') }}" required>
        </div>

        <div class="col-md-6 form-group">
            <label for="code">كود المورد</label>
            <input type="text" name="code" id="code" class="form-control"
                value="{{ old('code', $supplier->code ?? '') }}">
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 form-group">
            <label for="contact_name">اسم الاتصال</label>
            <input type="text" name="contact_name" id="contact_name" class="form-control"
                value="{{ old('contact_name', $supplier->contact_name ?? '') }}">
        </div>

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
    </div>

    <div class="form-group form-check text-right">
        <input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active"
            {{ old('is_active', $supplier->is_active ?? true) ? 'checked' : '' }}>
        <label class="form-check-label mr-4" for="is_active">نشط</label>
    </div>
</div>