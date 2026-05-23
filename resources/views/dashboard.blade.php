@extends('layouts.app')

@section('title', 'Nanocity')

@section('content_header')
    <h1>لوحة التحكم</h1>
@stop

@section('main-content')

@php
    $qrBaseUrl = env('QR_BASE_URL', config('app.url'));
    $storeName = auth()->user()->store_name;
    $storeUrl = $qrBaseUrl . '/' . $storeName;
@endphp

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <div class="card shadow-lg border-0 rounded-3">

                <!-- HEADER -->
                <div class="card-header bg-gradient-primary text-white text-center py-4">
                    <h3 class="mb-0">
                        <i class="fas fa-store ml-2"></i>
                        متجرك الإلكتروني
                    </h3>
                </div>

                <!-- BODY -->
                <div class="card-body text-center py-5">

                    <!-- LINK -->
                    <div class="mb-5">
                        <h4 class="text-primary mb-3">
                            <i class="fas fa-link ml-2"></i>
                            رابط متجرك الخاص
                        </h4>

                        <div class="input-group mb-3" dir="ltr">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-primary" type="button" onclick="copyToClipboard()">
                                    <i class="fas fa-copy"></i>
                                </button>

                                <a href="{{ $storeUrl }}" target="_blank" class="btn btn-primary">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>

                            <input type="text"
                                   class="form-control form-control-lg text-center"
                                   id="storeUrl"
                                   value="{{ $storeUrl }}"
                                   readonly>
                        </div>

                        <small class="text-muted">يمكنك مشاركة هذا الرابط مع عملائك</small>
                    </div>

                    <!-- QR -->
                    <div class="mb-4">
                        <h4 class="text-primary mb-3">
                            <i class="fas fa-qrcode ml-2"></i>
                            رمز QR لمتجرك
                        </h4>

                        <div class="qr-container mb-3">
                            <div id="qrcode" class="d-inline-block p-3 bg-white rounded shadow-sm"></div>
                        </div>

                        <button class="btn btn-success" onclick="downloadQR()">
                            <i class="fas fa-download ml-2"></i>
                            تحميل الكود
                        </button>

                        <div class="btn-group mx-2">
                            <button class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-share-alt ml-2"></i>
                                مشاركة
                            </button>

                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" onclick="shareWhatsApp()">واتساب</a>
                                <a class="dropdown-item" href="#" onclick="shareTelegram()">تيليجرام</a>
                                <a class="dropdown-item" href="#" onclick="copyToClipboard()">نسخ الرابط</a>
                            </div>
                        </div>

                        <small class="text-muted d-block mt-2">
                            امسح الكود للوصول السريع للمتجر
                        </small>
                    </div>

                </div>

                <!-- FOOTER -->
                <div class="card-footer bg-light text-center py-3">
                    <div class="row">
                        <div class="col-4">
                            <i class="fas fa-mobile-alt text-primary fa-2x"></i>
                            <p class="small mb-0">متوافق</p>
                        </div>
                        <div class="col-4">
                            <i class="fas fa-shield-alt text-success fa-2x"></i>
                            <p class="small mb-0">آمن</p>
                        </div>
                        <div class="col-4">
                            <i class="fas fa-clock text-info fa-2x"></i>
                            <p class="small mb-0">24/7</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(45deg, #007bff, #0056b3);
}

.qr-container {
    border: 2px dashed #ddd;
    padding: 15px;
    border-radius: 10px;
    background: #f8f9fa;
}

.card:hover {
    transform: translateY(-5px);
    transition: 0.3s;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    new QRCode(document.getElementById("qrcode"), {
        text: "{{ $storeUrl }}",
        width: 200,
        height: 200
    });
});

function copyToClipboard() {
    const input = document.getElementById("storeUrl");
    input.select();
    document.execCommand("copy");
}

function downloadQR() {
    const canvas = document.querySelector('#qrcode canvas');
    const link = document.createElement('a');
    link.download = 'qr.png';
    link.href = canvas.toDataURL();
    link.click();
}

function shareWhatsApp() {
    const text = encodeURIComponent("{{ $storeUrl }}");
    window.open(`https://wa.me/?text=${text}`, '_blank');
}

function shareTelegram() {
    const text = encodeURIComponent("{{ $storeUrl }}");
    window.open(`https://t.me/share/url?url=${text}`, '_blank');
}
</script>

@stop