@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">تعديل الشيفت</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">الرئيسية</a>
                        </li>
                        <li class="breadcrumb-item">
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">بيانات الشيفت</h3>
                        </div>

                        <form method="POST" action="{{ route('shifts.update', $shift->id) }}">
                            @csrf
                            @method('PUT')

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
                                    <label for="user_id">الموظف</label>
                                    <select name="user_id" id="user_id" class="form-control" required>
                                        <option value="">اختر الموظف</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ old('user_id', $shift->user_id) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="branch_id">المتجر</label>
                                    <select name="branch_id" id="branch_id" class="form-control" required>
                                        <option value="">اختر المتجر</option>
                                        @foreach ($branches as $branch)
                                            <option value="{{ $branch->id }}"
                                                {{ old('branch_id', $shift->branch_id) == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="starting_cash">رصيد البداية</label>
                                    <input type="number" step="0.01" min="0" name="starting_cash"
                                        id="starting_cash" class="form-control"
                                        value="{{ old('starting_cash', $shift->starting_cash) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="expected_cash">الكاش المتوقع</label>
                                    <input type="number" step="0.01" min="0" name="expected_cash"
                                        id="expected_cash" class="form-control"
                                        value="{{ old('expected_cash', $shift->expected_cash) }}">
                                </div>

                                <div class="form-group">
                                    <label for="ending_cash">رصيد النهاية</label>
                                    <input type="number" step="0.01" min="0" name="ending_cash" id="ending_cash"
                                        class="form-control" value="{{ old('ending_cash', $shift->ending_cash) }}">
                                </div>

                                <div class="form-group">
                                    <label for="start_time">وقت بداية الشيفت</label>
                                    <input type="datetime-local" name="start_time" id="start_time" class="form-control"
                                        value="{{ old('start_time', $shift->start_time ? $shift->start_time->format('Y-m-d\TH:i') : '') }}">
                                </div>

                                <div class="form-group">
                                    <label for="end_time">وقت نهاية الشيفت</label>
                                    <input type="datetime-local" name="end_time" id="end_time" class="form-control"
                                        value="{{ old('end_time', $shift->end_time ? $shift->end_time->format('Y-m-d\TH:i') : '') }}">
                                </div>

                                <div class="form-group">
                                    <label for="status">الحالة</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="active"
                                            {{ old('status', $shift->status) == 'active' ? 'selected' : '' }}>نشط</option>
                                        <option value="paused"
                                            {{ old('status', $shift->status) == 'paused' ? 'selected' : '' }}>موقوف
                                        </option>
                                        <option value="closed"
                                            {{ old('status', $shift->status) == 'closed' ? 'selected' : '' }}>مغلق</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="notes">ملاحظات</label>
                                    <textarea name="notes" id="notes" class="form-control" rows="4" placeholder="أدخل أي ملاحظات إضافية">{{ old('notes', $shift->notes) }}</textarea>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">تحديث</button>
                                <a href="{{ route('shifts.index') }}" class="btn btn-default float-right">إلغاء</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
