@extends('layouts.app')
@section('title', 'Dashboard')
@section('content_header')
    <h1>مرحبا بك في لوحة التحكم الخاصة بك</h1>
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
                <div class="card-header bg-gradient-primary text-white text-center py-4">
                    <h3 class="mb-0">
                        <i class="fas fa-store ml-2"></i>
                        متجرك الإلكتروني
                    </h3>
                </div>

                <div class="card-body text-center py-5">
                    <!-- Store Link Section -->
                    <div class="mb-5">
                        <h4 class="text-primary mb-3">
                            <i class="fas fa-link ml-2"></i>
                            رابط متجرك الخاص
                        </h4>
                        <div class="input-group mb-3" dir="ltr">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-primary" type="button"
                                        onclick="copyToClipboard()" title="نسخ الرابط">
                                    <i class="fas fa-copy"></i>
                                </button>
                                <a href="{{ $storeUrl }}" target="_blank"
                                   class="btn btn-primary" title="زيارة المتجر">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            </div>
                            <input type="text" class="form-control form-control-lg text-center"
                                   id="storeUrl" value="{{ $storeUrl }}" readonly>
                        </div>
                        <small class="text-muted">يمكنك مشاركة هذا الرابط مع عملائك</small>
                    </div>

                    <!-- QR Code Section -->
                    <div class="mb-4">
                        <h4 class="text-primary mb-3">
                            <i class="fas fa-qrcode ml-2"></i>
                            رمز QR لمتجرك
                        </h4>
                        <div class="qr-container mb-3">
                            <div id="qrcode" class="d-inline-block p-3 bg-white rounded shadow-sm"></div>
                        </div>
                        <div class="qr-actions">
                            <button class="btn btn-success mx-2" onclick="downloadQR()" title="تحميل QR Code">
                                <i class="fas fa-download ml-2"></i>
                                تحميل الكود
                            </button>
                            <div class="btn-group mx-2" role="group">
                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-share-alt ml-2"></i>
                                    مشاركة
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#" onclick="shareWhatsApp()">
                                        <i class="fab fa-whatsapp text-success ml-2"></i>
                                        واتساب
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="shareTelegram()">
                                        <i class="fab fa-telegram text-info ml-2"></i>
                                        تيليجرام
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="shareEmail()">
                                        <i class="fas fa-envelope text-danger ml-2"></i>
                                        البريد الإلكتروني
                                    </a>
                                    <a class="dropdown-item" href="#" onclick="copyStoreLink()">
                                        <i class="fas fa-copy text-primary ml-2"></i>
                                        نسخ الرابط
                                    </a>
                                </div>
                            </div>
                        </div>
                        <small class="text-muted d-block mt-2">امسح الكود باستخدام كاميرا الهاتف للوصول السريع لمتجرك</small>
                    </div>
                </div>

                <div class="card-footer bg-light text-center py-3">
                    <div class="row">
                        <div class="col-4">
                            <div class="text-primary">
                                <i class="fas fa-mobile-alt fa-2x mb-2"></i>
                                <p class="small mb-0">متوافق مع الهواتف</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-success">
                                <i class="fas fa-shield-alt fa-2x mb-2"></i>
                                <p class="small mb-0">آمن ومحمي</p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-info">
                                <i class="fas fa-clock fa-2x mb-2"></i>
                                <p class="small mb-0">متاح 24/7</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast for notifications -->
<div class="toast-container position-fixed bottom-0 left-0 p-3">
    <div id="toast" class="toast hide" role="alert">
        <div class="toast-header">
            <i class="fas fa-check-circle text-success ml-2"></i>
            <strong class="ml-auto">نجح</strong>
            <button type="button" class="mr-2 mb-1 close" data-dismiss="toast">
                <span>&times;</span>
            </button>
        </div>
        <div class="toast-body" id="toast-message">
            تم نسخ الرابط بنجاح!
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(45deg, #007bff, #0056b3);
}

.qr-container {
    border: 2px dashed #dee2e6;
    border-radius: 10px;
    padding: 20px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

#qrcode {
    border-radius: 8px;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-5px);
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.input-group input {
    font-family: 'Courier New', monospace;
    font-size: 14px;
}

.card-footer .col-4:hover {
    transform: scale(1.05);
    transition: transform 0.2s ease;
}

/* تأكد من عرض الأزرار بشكل صحيح في RTL */
.input-group[dir="ltr"] .input-group-prepend .btn {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.input-group[dir="ltr"] .input-group-prepend .btn:last-child {
    border-left: 0;
}

.input-group[dir="ltr"] input {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

@media (max-width: 768px) {
    .qr-actions .btn, .qr-actions .btn-group {
        display: block;
        width: 100%;
        margin: 5px 0;
    }

    .qr-actions .btn-group .btn {
        width: 100%;
    }

    .input-group[dir="ltr"] {
        flex-direction: column;
    }

    .input-group[dir="ltr"] .input-group-prepend {
        width: 100%;
        margin-bottom: 10px;
        flex-direction: row;
    }

    .input-group[dir="ltr"] .input-group-prepend .btn {
        flex: 1;
        border-radius: 0.25rem;
        margin-left: 5px;
    }
    
    .input-group[dir="ltr"] .input-group-prepend .btn:first-child {
        margin-left: 0;
    }

    .input-group[dir="ltr"] input {
        border-radius: 0.25rem;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
let qrCode;

// Initialize QR Code
document.addEventListener('DOMContentLoaded', function() {
    const qrContainer = document.getElementById('qrcode');
    qrContainer.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="sr-only">جاري التحميل...</span></div>';

    setTimeout(() => {
        qrContainer.innerHTML = '';
        qrCode = new QRCode(qrContainer, {
            text: "{{ $storeUrl }}",
            width: 200,
            height: 200,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
    }, 500);
});

// Copy URL to clipboard
function copyToClipboard() {
    const urlInput = document.getElementById('storeUrl');
    urlInput.select();
    urlInput.setSelectionRange(0, 99999);

    try {
        document.execCommand('copy');
        showToast('تم نسخ الرابط بنجاح!', 'success');
    } catch (err) {
        // Fallback for modern browsers
        if (navigator.clipboard) {
            navigator.clipboard.writeText(urlInput.value).then(() => {
                showToast('تم نسخ الرابط بنجاح!', 'success');
            }).catch(() => {
                showToast('فشل في نسخ الرابط', 'error');
            });
        } else {
            showToast('فشل في نسخ الرابط', 'error');
        }
    }
}

// Download QR Code
function downloadQR() {
    const qrCanvas = document.querySelector('#qrcode canvas');
    if (qrCanvas) {
        const link = document.createElement('a');
        link.download = 'store-qr-code.png';
        link.href = qrCanvas.toDataURL();
        link.click();
        showToast('تم تحميل الكود بنجاح!', 'success');
    } else {
        showToast('فشل في تحميل الكود', 'error');
    }
}

// Share via WhatsApp
function shareWhatsApp() {
    const text = encodeURIComponent(`زر متجري الإلكتروني 🛍️\n\nيمكنك زيارة متجري من خلال الرابط التالي:\n{{ $storeUrl }}\n\nأو امسح الكود المرفق للوصول السريع 📱`);
    const url = `https://wa.me/?text=${text}`;
    window.open(url, '_blank');
    showToast('تم فتح واتساب للمشاركة!', 'success');
}

// Share via Telegram
function shareTelegram() {
    const text = encodeURIComponent(`زر متجري الإلكتروني 🛍️\n\nيمكنك زيارة متجري من خلال الرابط التالي:\n{{ $storeUrl }}`);
    const url = `https://t.me/share/url?url={{ urlencode($storeUrl) }}&text=${text}`;
    window.open(url, '_blank');
    showToast('تم فتح تيليجرام للمشاركة!', 'success');
}

// Share via Email
function shareEmail() {
    const subject = encodeURIComponent('زر متجري الإلكتروني 🛍️');
    const body = encodeURIComponent(`السلام عليكم ورحمة الله وبركاته

أدعوك لزيارة متجري الإلكتروني الجديد!

رابط المتجر: {{ $storeUrl }}

يمكنك أيضاً استخدام كاميرا هاتفك لمسح الكود المرفق للوصول السريع إلى المتجر.

شكراً لك ❤️`);

    const url = `mailto:?subject=${subject}&body=${body}`;
    window.location.href = url;
    showToast('تم فتح تطبيق البريد الإلكتروني!', 'success');
}

// Copy store link with formatted text
function copyStoreLink() {
    const shareText = `زر متجري الإلكتروني 🛍️

رابط المتجر: {{ $storeUrl }}

يمكنك زيارة المتجر مباشرة أو مسح الكود للوصول السريع!`;

    if (navigator.clipboard) {
        navigator.clipboard.writeText(shareText).then(() => {
            showToast('تم نسخ نص المشاركة مع الرابط!', 'success');
        }).catch(() => {
            fallbackCopy(shareText);
        });
    } else {
        fallbackCopy(shareText);
    }
}

// Fallback copy function for older browsers
function fallbackCopy(text) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed';
    textArea.style.left = '-9999px';
    document.body.appendChild(textArea);
    textArea.select();
    try {
        document.execCommand('copy');
        showToast('تم نسخ نص المشاركة مع الرابط!', 'success');
    } catch (err) {
        showToast('فشل في نسخ النص', 'error');
    }
    document.body.removeChild(textArea);
}

// Show toast notification
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toast-message');
    const toastHeader = toast.querySelector('.toast-header');

    // Update message
    toastMessage.textContent = message;

    // Update icon based on type
    const icon = toastHeader.querySelector('i');
    if (type === 'success') {
        icon.className = 'fas fa-check-circle text-success ml-2';
        toastHeader.querySelector('strong').textContent = 'نجح';
    } else {
        icon.className = 'fas fa-exclamation-circle text-danger ml-2';
        toastHeader.querySelector('strong').textContent = 'خطأ';
    }

    // Show toast
    $(toast).toast({
        delay: 3000
    }).toast('show');
}
</script>

@stop