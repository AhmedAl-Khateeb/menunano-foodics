@extends('layouts.app')

@section('main-content')
<div class="container my-5">
    <div id="clickReminder" class="alert alert-warning text-center shadow-sm">
        ⚠️ يرجى الضغط في أي مكان داخل الصفحة لمرة واحدة لتفعيل جرس إشعارات الطلبات تلقائياً.
    </div>

    <div class="card shadow-lg border-0 rounded-lg">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0 font-weight-bold text-center">قائمة الطلبات الجديدة</h3>
        </div>

        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover text-center align-middle" id="ordersTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>الهاتف</th>
                            <th>العنوان</th>
                            <th>السعر</th>
                            <th>الحالة</th>
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
                                    <a href="https://wa.me/{{ $phone }}" target="_blank" class="text-success font-weight-bold">
                                        <i class="fab fa-whatsapp"></i> {{ $order->phone }}
                                    </a>
                                </td>
                                <td>{{ $order->address }}</td>
                                <td>{{ number_format($order->total_price, 2) }} جنية</td>
                                <td>
                                    <span class="badge {{ $order->status == 'served' ? 'badge-success' : 'badge-danger' }} status-check">
                                        {{ $order->status == 'served' ? 'تم التوصيل' : 'قيد الانتظار' }}
                                    </span>
                                </td>
                                <td>{{ $order->created_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('order.show', $order->id) }}" class="btn btn-outline-info btn-sm">عرض</a>
                                    @if($order->status != 'served')
                                        <form action="{{ route('orders.serve', $order->id) }}" method="POST" style="display:inline">
                                            @csrf @method('PUT')
                                            <button class="btn btn-primary btn-sm">تم التوصيل</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center">لا توجد طلبات</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<audio id="pendingSound" preload="auto" loop>
    <source src="{{ asset('public/new-order.mp3') }}" type="audio/mpeg">
</audio>

<script>
    // 1. تحديث الصفحة تلقائياً كل 30 ثانية لجلب الطلبات الجديدة من السيرفر
    setTimeout(function(){
       location.reload();
    }, 30000);

    const audio = document.getElementById('pendingSound');
    const reminder = document.getElementById('clickReminder');

    // وظيفة فحص وجود طلبات "قيد الانتظار"
    function runCheck() {
        const statusBadges = document.querySelectorAll('.status-check');
        let hasPending = false;

        statusBadges.forEach(function(badge) {
            if (badge.innerText.trim() === 'قيد الانتظار') {
                hasPending = true;
            }
        });

        if (hasPending) {
            // محاولة تشغيل الصوت
            audio.play().catch(e => {
                console.log("المتصفح يمنع التشغيل التلقائي حتى الآن. يرجى التفاعل مع الصفحة.");
                if(reminder) reminder.style.display = 'block';
            });
        } else {
            audio.pause();
            audio.currentTime = 0;
        }
    }

    // تفعيل نظام الصوت عند أول نقرة للمستخدم في أي مكان (لفك حظر المتصفح)
    function enableAudioOnInteraction() {
        audio.play().then(() => {
            audio.pause();
            audio.currentTime = 0;
            sessionStorage.setItem('audioUnlocked', 'true');
            if(reminder) reminder.style.display = 'none';
            runCheck();
            console.log("تم فك حظر الصوت بنجاح.");
            // إزالة المستمع لعدم تكرار العملية
            document.removeEventListener('click', enableAudioOnInteraction);
            document.removeEventListener('keydown', enableAudioOnInteraction);
        }).catch(e => console.log("في انتظار تفاعل المستخدم..."));
    }

    document.addEventListener('click', enableAudioOnInteraction);
    document.addEventListener('keydown', enableAudioOnInteraction);

    // فحص الحالة عند تحميل الصفحة
    window.onload = function() {
        if (sessionStorage.getItem('audioUnlocked') === 'true') {
            if(reminder) reminder.style.display = 'none';
            runCheck();
        }
    };

    // فحص دوري كل 10 ثوانٍ للتأكد من حالة الطلبات
    setInterval(runCheck, 10000);

</script>

<style>
    .badge-success { background-color: #28a745 !important; color: white; padding: 10px; }
    .badge-danger { background-color: #dc3545 !important; color: white; padding: 10px; }
    .alert-warning { font-weight: bold; border-radius: 10px; display: block; }
</style>
@endsection