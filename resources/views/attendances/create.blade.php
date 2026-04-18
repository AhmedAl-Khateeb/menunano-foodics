@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">إضافة سجل حضور وانصراف</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">الرئيسية</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('attendances.index') }}">الحضور والانصراف</a>
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
                            <h3 class="card-title">بيانات الحضور والانصراف</h3>
                        </div>

                        <form method="POST" action="{{ route('attendances.store') }}">
                            @csrf

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
                                                {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="shift_id">الشيفت</label>
                                    <select name="shift_id" id="shift_id" class="form-control">
                                        <option value="">بدون شيفت</option>
                                        @foreach ($shifts as $shift)
                                            <option value="{{ $shift->id }}"
                                                {{ old('shift_id') == $shift->id ? 'selected' : '' }}>
                                                #{{ $shift->id }} - {{ $shift->user->name ?? '---' }} -
                                                {{ $shift->status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="attendance_date">التاريخ</label>
                                    <input type="date" name="attendance_date" id="attendance_date" class="form-control"
                                        value="{{ old('attendance_date', now()->format('Y-m-d')) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="check_in">وقت الحضور</label>
                                    <input type="datetime-local" name="check_in" id="check_in" class="form-control"
                                        value="{{ old('check_in') }}">
                                </div>

                                <div class="form-group">
                                    <label for="check_out">وقت الانصراف</label>
                                    <input type="datetime-local" name="check_out" id="check_out" class="form-control"
                                        value="{{ old('check_out') }}">
                                </div>

                                <div class="form-group">
                                    <label for="status">الحالة</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="present" {{ old('status') == 'present' ? 'selected' : '' }}>حاضر
                                        </option>
                                        <option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>غائب
                                        </option>
                                        <option value="late" {{ old('status') == 'late' ? 'selected' : '' }}>متأخر
                                        </option>
                                        <option value="leave" {{ old('status') == 'leave' ? 'selected' : '' }}>إجازة
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="notes">ملاحظات</label>
                                    <textarea name="notes" id="notes" class="form-control" rows="4" placeholder="أدخل أي ملاحظات إضافية">{{ old('notes') }}</textarea>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">حفظ</button>
                                <a href="{{ route('attendances.index') }}" class="btn btn-default float-right">إلغاء</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
