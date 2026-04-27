@extends('layouts.app')

@section('main-content')
<div class="container-fluid py-4" dir="rtl">

    <div class="mb-4">
        <h3 class="font-weight-bold">
            تقرير عهدة الكاشير
        </h3>
        <p class="text-muted">
            عرض المصروفات والمبالغ المسلمة للمدير والمبالغ المرحلة لكل كاشير.
        </p>
    </div>

    <div class="row mb-4">

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-muted mb-2">إجمالي المصروفات</div>
                    <h4 class="font-weight-bold text-danger">
                        {{ number_format($summary['expenses_total'] ?? 0, 2) }} ج.م
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-muted mb-2">إجمالي المسلم للمدير</div>
                    <h4 class="font-weight-bold text-primary">
                        {{ number_format($summary['sent_to_manager'] ?? 0, 2) }} ج.م
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-muted mb-2">إجمالي المرحل للشيفت التالي</div>
                    <h4 class="font-weight-bold text-success">
                        {{ number_format($summary['carryover_total'] ?? 0, 2) }} ج.م
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <div class="text-muted mb-2">عدد الشيفتات</div>
                    <h4 class="font-weight-bold">
                        {{ $summary['shifts_count'] ?? 0 }}
                    </h4>
                </div>
            </div>
        </div>

    </div>

    <form method="GET" class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-end">

                <div class="col-md-3 mb-2">
                    <label class="font-weight-bold">الكاشير</label>
                    <select name="user_id" class="form-control">
                        <option value="">كل الكاشير</option>
                        @foreach($cashiers as $cashier)
                            <option value="{{ $cashier->id }}" {{ request('user_id') == $cashier->id ? 'selected' : '' }}>
                                {{ $cashier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 mb-2">
                    <label class="font-weight-bold">الفرع</label>
                    <select name="branch_id" class="form-control">
                        <option value="">كل الفروع</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 mb-2">
                    <label class="font-weight-bold">من تاريخ</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control">
                </div>

                <div class="col-md-2 mb-2">
                    <label class="font-weight-bold">إلى تاريخ</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control">
                </div>

                <div class="col-md-2 mb-2">
                    <button class="btn btn-primary btn-block">
                        <i class="fas fa-search"></i>
                        بحث
                    </button>
                </div>

            </div>
        </div>
    </form>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <strong>تفاصيل كل كاشير</strong>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>الكاشير</th>
                        <th>عدد الشيفتات</th>
                        <th>إجمالي المصروفات</th>
                        <th>المسلم للمدير</th>
                        <th>المرحل للشيفت التالي</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($rows as $index => $row)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td class="font-weight-bold">
                                {{ $row['user']->name ?? '-' }}
                            </td>

                            <td>
                                {{ $row['shifts_count'] ?? 0 }}
                            </td>

                            <td class="text-danger font-weight-bold">
                                {{ number_format($row['expenses_total'] ?? 0, 2) }}
                            </td>

                            <td class="text-primary font-weight-bold">
                                {{ number_format($row['sent_to_manager'] ?? 0, 2) }}
                            </td>

                            <td class="text-success font-weight-bold">
                                {{ number_format($row['carryover_total'] ?? 0, 2) }}
                            </td>

                            <td>
                                <a href="{{ route('cashier-cash-reports.show', $row['user']->id) }}"
                                   class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                    عرض التفاصيل
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-muted py-5">
                                لا توجد بيانات متاحة حاليًا
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection