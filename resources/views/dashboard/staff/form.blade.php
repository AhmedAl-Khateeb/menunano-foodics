<div class="form-group mb-3 text-right">
    <label>اسم الموظف</label>
    <input type="text" name="Name" class="form-control"
        value="{{ old('Name', $staff->Name ?? '') }}" required>
</div>

<div class="form-group mb-3 text-right">
    <label>رقم الموبايل</label>
    <input type="text" name="mobile" class="form-control"
        value="{{ old('mobile', $staff->mobile ?? '') }}">
</div>

<div class="form-group mb-3 text-right">
    <label>عدد أيام العمل</label>
    <input type="number" name="Number_of_days" class="form-control"
        value="{{ old('Number_of_days', $staff->Number_of_days ?? '') }}">
</div>

<div class="form-group mb-3 text-right">
    <label>عدد ساعات العمل</label>
    <input type="number" name="Number_of_hours" class="form-control"
        value="{{ old('Number_of_hours', $staff->Number_of_hours ?? '') }}">
</div>

<div class="form-group mb-3 text-right">
    <label>المرتب</label>
    <input type="text" name="Salary" class="form-control"
        value="{{ old('Salary', $staff->Salary ?? '') }}">
</div>

<div class="form-group mb-3 text-right">
    <label>بداية التعاقد</label>
    <input type="datetime-local" name="Start_date" class="form-control"
        value="{{ old('Start_date', isset($staff->Start_date) ? \Carbon\Carbon::parse($staff->Start_date)->format('Y-m-d\TH:i') : '') }}">
</div>

<div class="form-group mb-3 text-right">
    <label>نهاية التعاقد</label>
    <input type="datetime-local" name="End_date" class="form-control"
        value="{{ old('End_date', isset($staff->End_date) ? \Carbon\Carbon::parse($staff->End_date)->format('Y-m-d\TH:i') : '') }}">
</div>