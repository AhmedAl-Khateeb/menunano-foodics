<div class="form-group text-right">
    <label>الاسم</label>

    <input type="text" name="name" class="form-control text-right" value="{{ old('name', $user->name ?? '') }}" required>
</div>

<div class="form-group text-right">
    <label>البريد الإلكتروني</label>

    <input type="email" name="email" class="form-control text-right" value="{{ old('email', $user->email ?? '') }}" required>
</div>

<div class="form-group text-right">
    <label>كلمة المرور</label>

    <input type="password" name="password" class="form-control text-right" {{ isset($user) ? '' : 'required' }}>
</div>

<div class="form-group text-right">
    <label>تأكيد كلمة المرور</label>

    <input type="password" name="password_confirmation" class="form-control text-right" {{ isset($user) ? '' : 'required' }}>
</div>

<div class="form-group text-right">
    <label>الدور</label>

    <select name="role_id" class="form-control text-right" required>

        <option value="">اختر الدور</option>

        @foreach ($roles as $r)
            <option value="{{ $r->id }}"
                {{ old(
                    'role_id',
                    isset($user) ? $user->roles->first()?->id ?? ($user->role === 'cashier' ? 'cashier' : null) : null,
                ) == $r->id
                    ? 'selected'
                    : '' }}>

                {{ $r->name }}

            </option>
        @endforeach

    </select>
</div>

<div class="form-group text-right">
    <label>الفرع</label>

    <select name="branch_id" class="form-control text-right">

        <option value="">اختر الفرع</option>

        @foreach ($branches as $branch)
            <option value="{{ $branch->id }}"
                {{ old('branch_id', $user->branch_id ?? '') == $branch->id ? 'selected' : '' }}>

                {{ $branch->name }}

            </option>
        @endforeach

    </select>
</div>

<div class="form-group text-right">
    <label>الصورة</label>

    <input type="file" name="image" class="form-control text-right">
</div>
