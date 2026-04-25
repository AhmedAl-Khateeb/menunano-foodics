@extends('layouts.app')

@section('main-content')
    <div class="container my-5 px-2 px-md-4">
        <audio id="pendingSound" src="{{ asset('new-order.mp3') }}" preload="auto" loop></audio>

        <div id="clickReminder" class="audio-reminder">
            <div class="audio-reminder-icon">
                <i class="fas fa-bell-slash"></i>
            </div>

            <div class="audio-reminder-text">
                <strong>تفعيل صوت الطلبات</strong>
                <span>اضغط هنا لتشغيل جرس الإشعارات</span>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">إدارة الطلبات</h3>
                <p class="text-muted mb-0">عرض جميع الطلبات مع الفلاتر</p>
            </div>
        </div>

        {{-- ====== FILTERS ====== --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form method="GET" class="form-row align-items-center">

                    <div class="col-lg-2 col-md-4 mb-2">
                        <input type="text" name="search" class="form-control" placeholder="بحث بالاسم / الهاتف"
                            value="{{ request('search') }}">
                    </div>

                    <div class="col-lg-3 col-md-6 mb-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">من</span>
                            </div>

                            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">

                            <div class="input-group-prepend">
                                <span class="input-group-text">إلى</span>
                            </div>

                            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                        </div>
                    </div>

                    <div class="col-lg-1 col-md-4 mb-2">
                        <select name="status" class="form-control">
                            <option value="">الحالات</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="served" {{ request('status') == 'served' ? 'selected' : '' }}>Served</option>
                        </select>
                    </div>

                    <div class="col-lg-1 col-md-4 mb-2">
                        <select name="type" class="form-control">
                            <option value="">الأنواع</option>
                            <option value="delivery" {{ request('type') == 'delivery' ? 'selected' : '' }}>توصيل</option>
                            <option value="takeaway" {{ request('type') == 'takeaway' ? 'selected' : '' }}>استلام</option>
                            <option value="free_seating" {{ request('type') == 'free_seating' ? 'selected' : '' }}>محلي
                            </option>
                        </select>
                    </div>

                    <div class="col-lg-1 col-md-4 mb-2">
                        <select name="source" class="form-control">
                            <option value="">المصادر</option>
                            <option value="web" {{ request('source') == 'web' ? 'selected' : '' }}>Web</option>
                            <option value="app" {{ request('source') == 'app' ? 'selected' : '' }}>App</option>
                            <option value="pos" {{ request('source') == 'pos' ? 'selected' : '' }}>POS</option>
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6 mb-2">
                        <select name="payment_method" class="form-control">
                            <option value="">كل وسائل الدفع</option>
                            <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash
                            </option>
                            <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>Card
                            </option>
                        </select>
                    </div>

                    <div class="col-lg-1 col-md-6 mb-2">
                        <div class="d-flex">
                            <button class="btn btn-primary flex-fill mr-1">
                                بحث
                            </button>
                            <br>
                            <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- ====== QUICK FILTER BUTTONS ====== --}}
        <div class="mb-3">
            <a href="{{ route('orders.index') }}" class="btn btn-dark">كل الطلبات</a>
            <a href="{{ route('orders.delivery', ['type' => 'delivery']) }}" class="btn btn-info">توصيل</a>
            <a href="{{ route('orders.pickup', ['type' => 'takeaway']) }}" class="btn btn-warning">استلام</a>
            {{-- <a href="{{ route('orders.index', ['type'=>'table']) }}" class="btn btn-success">طاولات</a> --}}
            <a href="{{ route('orders.local', ['type' => 'free_seating']) }}" class="btn btn-success">محلي</a>
        </div>

        {{-- ====== TABLE ====== --}}
        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover text-center align-middle mb-0">

                    <thead class="bg-light">
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>الهاتف</th>
                            <th>العنوان</th>
                            <th>النوع</th>
                            <th>المصدر</th>
                            <th>الدفع</th>
                            <th>السعر</th>
                            <th>الحالة</th>
                            <th>التاريخ</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>

                                <td>{{ $order->name ?? '-' }}</td>

                                <td>{{ $order->phone ?? '-' }}</td>

                                <td>{{ $order->address ?? '-' }}</td>

                                <td>
                                    @if ($order->type == 'delivery')
                                        <span class="badge badge-info">توصيل</span>
                                    @elseif($order->type == 'takeaway')
                                        <span class="badge badge-warning">استلام</span>
                                    @elseif($order->type == 'table')
                                        <span class="badge badge-success">طاولة</span>
                                    @else
                                        <span class="badge badge-success">محلي</span>
                                    @endif
                                </td>

                                <td>{{ strtoupper($order->source) }}</td>

                                <td>{{ $order->payment_method }}</td>

                                <td>{{ number_format($order->total_price, 2) }}</td>

                                <td>
                                    @if ($order->status == 'served')
                                        <span class="badge badge-success status-check">تم</span>
                                    @else
                                        <span class="badge badge-danger status-check">انتظار</span>
                                    @endif
                                </td>

                                <td>{{ $order->created_at->format('Y-m-d') }}</td>

                                <td>
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                        عرض
                                    </a>

                                    @if ($order->status != 'served')
                                        <form action="{{ route('orders.serve', $order->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('PUT')

                                            <button class="btn btn-success btn-sm">
                                                تم التوصيل
                                            </button>
                                        </form>
                                    @endif
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="11" class="text-center text-muted py-4">
                                    لا توجد طلبات
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <div class="card-footer">
                {{ $orders->withQueryString()->links() }}
            </div>
        </div>

    </div>
@endsection



<script>
    document.addEventListener('DOMContentLoaded', function () {

        const audio = document.getElementById('pendingSound');
        const reminder = document.getElementById('clickReminder');

        let alarmEnabled = sessionStorage.getItem('alarmEnabled') === 'true';

        function hasPendingOrders() {
            const statusBadges = document.querySelectorAll('.status-check, .status-check-mobile');

            let hasPending = false;

            statusBadges.forEach(function (badge) {
                const text = badge.innerText.trim();

                if (
                    text === 'انتظار' ||
                    text === 'قيد الانتظار' ||
                    text === 'Pending'
                ) {
                    hasPending = true;
                }
            });

            return hasPending;
        }

        function updateReminderUI() {
            if (!reminder) return;

            reminder.style.display = 'flex';

            if (alarmEnabled) {
                reminder.classList.add('active');
                reminder.querySelector('strong').innerText = 'صوت الطلبات يعمل';
                reminder.querySelector('span').innerText = 'اضغط هنا لإيقاف جرس الإشعارات';
                reminder.querySelector('i').className = 'fas fa-bell';
            } else {
                reminder.classList.remove('active');
                reminder.querySelector('strong').innerText = 'تفعيل صوت الطلبات';
                reminder.querySelector('span').innerText = 'اضغط هنا لتشغيل جرس الإشعارات';
                reminder.querySelector('i').className = 'fas fa-bell-slash';
            }
        }

        function stopAlarm() {
            alarmEnabled = false;
            sessionStorage.setItem('alarmEnabled', 'false');

            if (audio) {
                audio.pause();
                audio.currentTime = 0;
            }

            updateReminderUI();
        }

        function startAlarm() {
            alarmEnabled = true;
            sessionStorage.setItem('alarmEnabled', 'true');

            updateReminderUI();
            runCheck();
        }

        function toggleAlarm() {
            if (alarmEnabled) {
                stopAlarm();
            } else {
                startAlarm();
            }
        }

        function runCheck() {
            if (!audio) return;

            if (!alarmEnabled) {
                audio.pause();
                audio.currentTime = 0;
                return;
            }

            if (hasPendingOrders()) {
                audio.muted = false;
                audio.volume = 1;

                audio.play().catch(function (error) {
                    console.log('Audio blocked:', error);
                });
            } else {
                audio.pause();
                audio.currentTime = 0;
            }
        }

        if (reminder) {
            reminder.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                toggleAlarm();
            });
        }

        updateReminderUI();

        setInterval(runCheck, 10000);

        setTimeout(function () {
            location.reload();
        }, 30000);

    });
</script>



<style>
    .rounded-2xl {
        border-radius: 1.5rem !important;
    }

    .rounded-xl {
        border-radius: 1rem !important;
    }

    .flex-grow-2 {
        flex-grow: 2;
    }

    .transition-all {
        transition: all 0.3s ease;
    }

    .badge-soft-info {
        background-color: #e0f7fa;
        color: #00838f;
    }

    .badge-success {
        background-color: #28a745 !important;
        color: white;
    }

    .badge-danger {
        background-color: #dc3545 !important;
        color: white;
    }

    .badge-info {
        background-color: #17a2b8 !important;
        color: white;
    }

    .order-card {
        background: #fff;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .order-card:active {
        transform: scale(0.98);
    }

    .border-right-pending {
        border-right: 5px solid #dc3545 !important;
    }

    .alert-warning {
        border: 0;
        background: #fff3cd;
        color: #856404;
        border-radius: 12px;
        font-weight: bold;
    }

    .audio-reminder {
        position: fixed;
        top: 90px;
        left: 25px;
        z-index: 9999;
        background: #ffffff;
        color: #111827;
        border-radius: 16px;
        padding: 14px 18px;
        min-width: 280px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.18);
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        border-right: 5px solid #ffc107;
        animation: slideIn 0.35s ease;
    }

    .audio-reminder-icon {
        width: 42px;
        height: 42px;
        background: #fff3cd;
        color: #d39e00;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .audio-reminder-text {
        display: flex;
        flex-direction: column;
        line-height: 1.5;
    }

    .audio-reminder.active {
        border-right-color: #28a745;
    }

    .audio-reminder.active .audio-reminder-icon {
        background: #d4edda;
        color: #28a745;
    }

    .audio-reminder-text strong {
        font-size: 15px;
        font-weight: 700;
    }

    .audio-reminder-text span {
        font-size: 13px;
        color: #6b7280;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .container {
            padding-top: 1rem !important;
        }

        .card-title {
            font-size: 1.25rem;
        }
    }
</style>
