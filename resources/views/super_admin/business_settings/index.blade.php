@extends('layouts.app')

@section('main-content')
<div class="container py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1 class="h3 mb-1 text-primary">
                        <i class="fas fa-cog me-2"></i>إعدادات النشاط
                    </h1>
                    <p class="text-muted mb-0">قم بتحديث إعدادات نشاطك التجاري</p>
                </div>
                <div>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-right me-2"></i>العودة
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts Section -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>يرجى تصحيح الأخطاء التالية:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Main Form -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('business_settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <div class="row">
                            <!-- Video Links Section -->
                            <div class="col-12 mb-4">
                                <h5 class="text-secondary mb-3">
                                    <i class="fas fa-video me-2"></i>روابط الفيديوهات
                                </h5>

                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label for="video_link_1" class="form-label fw-bold">
                                            <i class="fas fa-play-circle me-2 text-primary"></i>لينك الفيديو الأول
                                        </label>
                                        <input type="url" name="video_link_1" id="video_link_1"
                                               class="form-control form-control-lg @error('video_link_1') is-invalid @enderror"
                                               placeholder="https://www.youtube.com/watch?v=..."
                                               value="{{ old('video_link_1', $settings['video_link_1'] ?? '') }}">
                                        @error('video_link_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                        <label for="video_link_2" class="form-label fw-bold">
                                            <i class="fas fa-play-circle me-2 text-primary"></i>لينك الفيديو الثاني
                                        </label>
                                        <input type="url" name="video_link_2" id="video_link_2"
                                               class="form-control form-control-lg @error('video_link_2') is-invalid @enderror"
                                               placeholder="https://www.youtube.com/watch?v=..."
                                               value="{{ old('video_link_2', $settings['video_link_2'] ?? '') }}">
                                        @error('video_link_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Description Section -->
                            <div class="col-12 mb-4">
                                <h5 class="text-secondary mb-3">
                                    <i class="fas fa-align-left me-2"></i>وصف النشاط
                                </h5>

                                <div class="form-floating">
                                    <textarea name="description" id="description"
                                              class="form-control @error('description') is-invalid @enderror"
                                              style="height: 120px"
                                              placeholder="اكتب وصف تفصيلي عن نشاطك التجاري...">{{ old('description', $settings['description'] ?? '') }}</textarea>
                                    <label for="description">
                                        <i class="fas fa-edit me-2"></i>الوصف التفصيلي
                                    </label>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Contact Information Section -->
                            <div class="col-12 mb-4">
                                <h5 class="text-secondary mb-3">
                                    <i class="fas fa-phone me-2"></i>معلومات الاتصال
                                </h5>

                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label for="whatsapp" class="form-label fw-bold">
                                            <i class="fab fa-whatsapp me-2 text-success"></i>واتساب
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-success text-white">
                                                <i class="fab fa-whatsapp"></i>
                                            </span>
                                            <input type="tel" name="whatsapp" id="whatsapp"
                                                   class="form-control form-control-lg @error('whatsapp') is-invalid @enderror"
                                                   placeholder="01xxxxxxxxx"
                                                   value="{{ old('whatsapp', $settings['whatsapp'] ?? '') }}">
                                            @error('whatsapp')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                        <label for="phone" class="form-label fw-bold">
                                            <i class="fas fa-phone me-2 text-info"></i>التليفون
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-info text-white">
                                                <i class="fas fa-phone"></i>
                                            </span>
                                            <input type="tel" name="phone" id="phone"
                                                   class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                                   placeholder="01xxxxxxxxx"
                                                   value="{{ old('phone', $settings['phone'] ?? '') }}">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
<!-- Currency Section -->
<div class="col-12 mb-4">
    <h5 class="text-secondary mb-3">
        <i class="fas fa-coins me-2"></i>العملة
    </h5>

    <div class="row">
        <div class="col-lg-6 mb-3">
            <label for="currency" class="form-label fw-bold">
                <i class="fas fa-money-bill-wave me-2 text-warning"></i>العملة الافتراضية
            </label>
            <input type="text" name="currency" id="currency"
                   class="form-control form-control-lg @error('currency') is-invalid @enderror"
                   placeholder="مثال: USD أو EGP"
                   value="{{ old('currency', $settings['currency'] ?? '') }}">
            @error('currency')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

                            <!-- Image Upload Section -->
                            <div class="col-12 mb-4">
                                <h5 class="text-secondary mb-3">
                                    <i class="fas fa-image me-2"></i>الصورة الرئيسية
                                </h5>

                                <div class="card bg-light border-2 border-dashed">
                                    <div class="card-body text-center p-4">
                                        <div class="row align-items-center">
                                            <!-- Current Image Display -->
                                            @if(isset($settings['main_image']) && !empty($settings['main_image']))
                                                <div class="col-md-4 mb-3 mb-md-0">
                                                    <div class="position-relative d-inline-block">
                                                        <img src="{{ asset('storage/' . $settings['main_image']) }}"
                                                             class="img-fluid rounded shadow-sm"
                                                             style="max-width: 200px; max-height: 150px; object-fit: cover;"
                                                             alt="الصورة الحالية">
                                                        <div class="position-absolute top-0 end-0 translate-middle">
                                                            <span class="badge bg-success rounded-pill">
                                                                <i class="fas fa-check"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <p class="text-muted mt-2 mb-0 small">الصورة الحالية</p>
                                                </div>
                                            @endif

                                            <!-- Upload Section -->
                                            <div class="{{ isset($settings['main_image']) && !empty($settings['main_image']) ? 'col-md-8' : 'col-12' }}">
                                                <div class="mb-3">
                                                    <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                                                    <h6 class="text-dark">اختر صورة جديدة</h6>
                                                    <p class="text-muted small mb-3">
                                                        اختر صورة بصيغة JPG, PNG أو GIF - الحد الأقصى 2MB
                                                    </p>
                                                </div>

                                                <input type="file" name="main_image" id="main_image"
                                                       class="form-control form-control-lg @error('main_image') is-invalid @enderror"
                                                       accept="image/*">
                                                @error('main_image')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="col-12">
                                <hr class="my-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <button type="submit" class="btn btn-primary btn-lg px-4 me-3">
                                            <i class="fas fa-save me-2"></i>حفظ التغييرات
                                        </button>
                                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-lg px-4">
                                            <i class="fas fa-times me-2"></i>إلغاء
                                        </a>
                                    </div>
                                    <div class="text-muted small">
                                        <i class="fas fa-info-circle me-1"></i>
                                        جميع الحقول اختيارية
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom Styles */
.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.card {
    transition: all 0.3s ease;
}

.input-group-text {
    border: none;
}

.form-floating > label {
    color: #6c757d;
}

.border-dashed {
    border-style: dashed !important;
}

.btn-lg {
    padding: 0.75rem 1.5rem;
}

.alert {
    border-radius: 0.75rem;
}

/* Image preview animation */
.card-body img {
    transition: transform 0.3s ease;
}

.card-body img:hover {
    transform: scale(1.05);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .container {
        padding-left: 15px;
        padding-right: 15px;
    }

    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }

    .btn-lg {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}
</style>
@endsection
