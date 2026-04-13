@extends('layouts.app')

@section('main-content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">إدارة الطلبات</h3>
            <p class="text-muted mb-0">عرض جميع الطلبات مع الفلاتر</p>
        </div>
    </div>

    {{-- ====== FILTERS ====== --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" class="row">

                <div class="col-md-3 mb-2">
                    <input type="text" name="search" class="form-control"
                           placeholder="بحث (رقم / اسم / هاتف)"
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-2 mb-2">
                    <select name="status" class="form-control">
                        <option value="">كل الحالات</option>
                        <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                        <option value="served" {{ request('status')=='served' ? 'selected' : '' }}>Served</option>
                    </select>
                </div>

                <div class="col-md-2 mb-2">
                    <select name="type" class="form-control">
                        <option value="">كل الأنواع</option>
                        <option value="delivery" {{ request('type')=='delivery' ? 'selected' : '' }}>توصيل</option>
                        <option value="takeaway" {{ request('type')=='takeaway' ? 'selected' : '' }}>استلام</option>
                        {{-- <option value="table" {{ request('type')=='table' ? 'selected' : '' }}>طاولة</option> --}}
                        <option value="free_seating" {{ request('type')=='free_seating' ? 'selected' : '' }}>محلي</option>
                    </select>
                </div>

                <div class="col-md-2 mb-2">
                    <select name="source" class="form-control">
                        <option value="">كل المصادر</option>
                        <option value="web" {{ request('source')=='web' ? 'selected' : '' }}>Web</option>
                        <option value="app" {{ request('source')=='app' ? 'selected' : '' }}>App</option>
                        <option value="pos" {{ request('source')=='pos' ? 'selected' : '' }}>POS</option>
                    </select>
                </div>

                <div class="col-md-2 mb-2">
                    <select name="payment_method" class="form-control">
                        <option value="">كل وسائل الدفع</option>
                        <option value="cash" {{ request('payment_method')=='cash' ? 'selected' : '' }}>Cash</option>
                        <option value="card" {{ request('payment_method')=='card' ? 'selected' : '' }}>Card</option>
                    </select>
                </div>

                <div class="col-md-1 mb-2">
                    <button class="btn btn-primary w-100">بحث</button>
                </div>

            </form>
        </div>
    </div>

    {{-- ====== QUICK FILTER BUTTONS ====== --}}
    <div class="mb-3">
        <a href="{{ route('orders.index') }}" class="btn btn-dark">كل الطلبات</a>
        <a href="{{ route('orders.delivery', ['type'=>'delivery']) }}" class="btn btn-info">توصيل</a>
        <a href="{{ route('orders.pickup', ['type'=>'takeaway']) }}" class="btn btn-warning">استلام</a>
        {{-- <a href="{{ route('orders.index', ['type'=>'table']) }}" class="btn btn-success">طاولات</a> --}}
        <a href="{{ route('orders.local', ['type'=>'free_seating']) }}" class="btn btn-success">محلي</a>
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
                                @if($order->type=='delivery')
                                    <span class="badge badge-info">توصيل</span>
                                @elseif($order->type=='takeaway')
                                    <span class="badge badge-warning">استلام</span>
                                @elseif($order->type=='table')
                                <span class="badge badge-success">طاولة</span>
                                @else
                                <span class="badge badge-success">محلي</span>
                                @endif
                            </td>

                            <td>{{ strtoupper($order->source) }}</td>

                            <td>{{ $order->payment_method }}</td>

                            <td>{{ number_format($order->total_price,2) }}</td>

                            <td>
                                @if($order->status=='served')
                                    <span class="badge badge-success">تم</span>
                                @else
                                    <span class="badge badge-danger">انتظار</span>
                                @endif
                            </td>

                            <td>{{ $order->created_at->diffForHumans() }}</td>

                            <td>
                                <a href="{{ route('orders.show', $order->id) }}"
                                   class="btn btn-sm btn-info">
                                    عرض
                                </a>

                                @if($order->status != 'served')
                                    <form action="{{ route('orders.serve', $order->id) }}"
                                          method="POST" style="display:inline;">
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
        // Store mute state in sessionStorage
        let isMuted = sessionStorage.getItem('alarmMuted') === 'true';
        const audio = document.getElementById('pendingSound');
        const toggleBtn = document.getElementById('toggleAlarm');
        const alarmIcon = document.getElementById('alarmIcon');
        const alarmText = document.getElementById('alarmText');
        const reminder = document.getElementById('clickReminder');

        function updateAlarmUI() {
            if (isMuted) {
                alarmIcon.className = 'fa fa-bell-slash text-danger';
                alarmText.innerText = 'تنبيه صامت';
                toggleBtn.classList.remove('btn-light');
                toggleBtn.classList.add('btn-outline-danger');
                audio.pause();
            } else {
                alarmIcon.className = 'fa fa-bell text-success';
                alarmText.innerText = 'تنبيه مفعل';
                toggleBtn.classList.add('btn-light');
                toggleBtn.classList.remove('btn-outline-danger');
                runCheck();
            }
        }

        toggleBtn.addEventListener('click', () => {
            isMuted = !isMuted;
            sessionStorage.setItem('alarmMuted', isMuted);
            updateAlarmUI();
        });

        // Initialize UI
        updateAlarmUI();

        // Auto reload every 30 seconds
        setTimeout(function() {
            location.reload();
        }, 30000);

        function runCheck() {
            if (isMuted) return;

            const statusBadges = document.querySelectorAll('.status-check, .status-check-mobile');
            let hasPending = false;

            statusBadges.forEach(function(badge) {
                const text = badge.innerText.trim();
                if (text === 'قيد الانتظار' || text === 'Pending') {
                    hasPending = true;
                }
            });

            if (hasPending) {
                audio.play().catch(e => {
                    console.log("Waiting for user interaction to play sound...");
                    if (reminder && !sessionStorage.getItem('audioUnlocked')) {
                        reminder.style.display = 'block';
                    }
                });
            } else {
                audio.pause();
                audio.currentTime = 0;
            }
        }

        function enableAudioOnInteraction() {
            audio.play().then(() => {
                audio.pause();
                audio.currentTime = 0;
                sessionStorage.setItem('audioUnlocked', 'true');
                if (reminder) reminder.style.display = 'none';
                runCheck();
                document.removeEventListener('click', enableAudioOnInteraction);
                document.removeEventListener('keydown', enableAudioOnInteraction);
            }).catch(e => console.log("Still blocked..."));
        }

        document.addEventListener('click', enableAudioOnInteraction);
        document.addEventListener('keydown', enableAudioOnInteraction);

        window.onload = function() {
            if (sessionStorage.getItem('audioUnlocked') === 'true') {
                if (reminder) reminder.style.display = 'none';
                runCheck();
            }
        };

        setInterval(runCheck, 10000);
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
