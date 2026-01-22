@extends('layouts.app')

@section('main-content')
    <div class="container my-5 px-2 px-md-4">
        <div id="clickReminder" class="alert alert-warning text-center shadow-sm mb-4" style="display: none;">
            ⚠️ يرجى الضغط في أي مكان داخل الصفحة لمرة واحدة لتفعيل جرس إشعارات الطلبات تلقائياً.
        </div>

        <div class="card shadow-lg border-0 rounded-lg overflow-hidden">
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0 font-weight-bold">قائمة الطلبات الجديدة</h3>
                    <div class="d-flex align-items-center gap-2">
                        <button id="toggleAlarm"
                            class="btn btn-light btn-sm rounded-pill px-3 shadow-sm border-0 d-flex align-items-center gap-2 transition-all">
                            <i id="alarmIcon" class="fa fa-bell"></i>
                            <span id="alarmText" class="d-none d-sm-inline">تنبيه مفعل</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body p-0 p-md-4">
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover text-center align-middle mb-0" id="ordersTable">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>الهاتف</th>
                                <th>العنوان</th>
                                <th>السعر</th>
                                <th>الحالة</th>
                                <th>نوع الدفع</th>
                                <th>التاريخ</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                @php
                                    $phone = preg_replace('/\D/', '', $order->phone);
                                    if (!str_starts_with($phone, '20')) {
                                        $phone = '20' . ltrim($phone, '0');
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="font-weight-bold text-primary">{{ $order->name }}</td>
                                    <td>
                                        <a href="https://wa.me/{{ $phone }}" target="_blank"
                                            class="text-success font-weight-bold">
                                            <i class="fab fa-whatsapp"></i> {{ $order->phone }}
                                        </a>
                                    </td>
                                    <td>{{ $order->address }}</td>
                                    <td class="font-weight-bold">{{ number_format($order->total_price, 2) }} ج.م</td>
                                    <td>
                                        <span
                                            class="badge {{ $order->status == 'served' ? 'badge-success' : 'badge-danger' }} status-check py-2 px-3">
                                            {{ $order->status == 'served' ? 'تم التوصيل' : 'قيد الانتظار' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-info py-2 px-3">
                                            {{ $order->payment_method == 'cash' ? 'كاش' : 'أونلاين' }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->diffForHumans() }}</td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="{{ route('order.show', $order->id) }}"
                                                class="btn btn-outline-info btn-sm">عرض</a>
                                            @if ($order->status != 'served')
                                                <form action="{{ route('orders.serve', $order->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <button class="btn btn-success btn-sm">تم التوصيل</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5 text-muted">لا توجد طلبات حالياً</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Mobile View: Cards --}}
                <div class="d-block d-md-none px-3 py-4">
                    @forelse($orders as $order)
                        @php
                            $phone = preg_replace('/\D/', '', $order->phone);
                            if (!str_starts_with($phone, '20')) {
                                $phone = '20' . ltrim($phone, '0');
                            }
                        @endphp
                        <div
                            class="card mb-4 border-0 shadow-sm rounded-2xl order-card {{ $order->status != 'served' ? 'border-right-pending' : '' }}">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h5 class="mb-1 font-weight-bold text-primary">{{ $order->name }}</h5>
                                        <small class="text-muted"><i class="fa fa-clock mr-1"></i>
                                            {{ $order->created_at->diffForHumans() }}</small>
                                    </div>
                                    <span
                                        class="badge {{ $order->status == 'served' ? 'badge-success' : 'badge-danger' }} status-check-mobile px-3 py-2 rounded-pill">
                                        {{ $order->status == 'served' ? 'تم التوصيل' : 'قيد الانتظار' }}
                                    </span>
                                </div>

                                <div class="mb-3">
                                    <p class="mb-1 text-secondary"><i class="fa fa-phone mr-2"></i> {{ $order->phone }}</p>
                                    <p class="mb-1 text-secondary"><i class="fa fa-map-marker-alt mr-2"></i>
                                        {{ $order->address ?? '-' }}</p>
                                    <p class="mb-0 text-secondary">
                                        <i class="fa fa-credit-card mr-2"></i>
                                        <span
                                            class="badge badge-soft-info">{{ $order->payment_method == 'cash' ? 'كاش' : 'أونلاين' }}</span>
                                    </p>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3 pt-3 border-top">
                                    <span class="text-secondary">المبلغ الإجمالي:</span>
                                    <span
                                        class="h5 mb-0 font-weight-bold text-dark">{{ number_format($order->total_price, 2) }}
                                        ج.م</span>
                                </div>

                                <div class="d-flex gap-2">
                                    <a href="{{ route('order.show', $order->id) }}"
                                        class="btn btn-outline-info flex-grow-1 py-2 rounded-xl">تفاصيل</a>
                                    <a href="https://wa.me/{{ $phone }}" target="_blank"
                                        class="btn btn-outline-success flex-grow-1 py-2 rounded-xl d-flex align-items-center justify-content-center gap-2">
                                        <i class="fab fa-whatsapp"></i> واتساب
                                    </a>
                                    @if ($order->status != 'served')
                                        <form action="{{ route('orders.serve', $order->id) }}" method="POST"
                                            class="flex-grow-2 w-100 mt-2">
                                            @csrf @method('PUT')
                                            <button class="btn btn-success w-100 py-2 rounded-xl">تأكيد التوصيل</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">لا توجد طلبات حالياً</div>
                    @endforelse
                </div>
            </div>

            @if ($orders->hasPages())
                <div class="card-footer bg-white py-3 d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>

    <audio id="pendingSound" preload="auto" loop>
        <source src="{{ asset('new-order.mp3') }}" type="audio/mpeg">
    </audio>

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
@endsection
