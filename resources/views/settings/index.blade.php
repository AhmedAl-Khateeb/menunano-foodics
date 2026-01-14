@extends('layouts.app')

@section('main-content')
    <div class="container">
        <div class="page-header mb-4">
            <h2 class="text-center text-primary font-weight-bold">إعدادات الموقع</h2>
            <p class="text-center text-muted">قم بتخصيص إعدادات موقعك من هنا</p>
        </div>
        
        <div class="row justify-content-center">
            @foreach($settings as $setting)
                @php
                    // تحديد الأسماء العربية للإعدادات
                    $arabicNames = [
                        'logo' => 'الشعار',
                        'maincolor' => 'اللون الأساسي',
                        'maintextcolor' => 'الخط الثانوي ',
                        'thirdtextcolor' => 'شرائط بداية ونهاية الصفحة',
                        'secondcolor' => 'لون خلفية الموقع',
                        'secoundtextcolor' => 'لون خلفية المنتجات',
                        'theme' => 'القالب',
                        'status' => 'حالة الموقع',
                        'site_name' => 'اسم الموقع',
                        'site_description' => 'وصف الموقع',
                        'contact_email' => 'البريد الإلكتروني',
                        'contact_phone' => 'رقم الهاتف',
                        'address' => 'العنوان'
                    ];
                    
                    $displayName = $arabicNames[$setting->key] ?? $setting->key;
                @endphp
                
               
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card setting-card shadow-hover h-100">
                        <div class="card-header bg-light border-0 d-flex justify-content-between align-items-center">
                            <h6 class="text-primary font-weight-bold mb-0 setting-title">
                                <i class="fas {{ $setting->key == 'logo' ? 'fa-image' : ($setting->key == 'theme' ? 'fa-palette' : ($setting->key == 'status' ? 'fa-power-off' : (in_array($setting->key, ['maincolor','maintextcolor','thirdtextcolor','secoundtextcolor','secondcolor']) ? 'fa-paint-brush' : 'fa-cog'))) }} me-2"></i>
                                {{ $displayName }}
                            </h6>
                            <button type="button" class="btn btn-outline-primary btn-sm edit-btn rounded-pill" 
                                    data-toggle="modal" data-target="#edit-setting-{{ $setting->id }}"
                                    title="تعديل {{ $displayName }}">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>

                        <div class="card-body text-center py-4">
                            @if($setting->key == 'logo')
                                <div class="image-container">
                                    <img src="{{ $setting->value }}" alt="شعار الموقع" class="setting-image">
                                </div>
                            @elseif(in_array($setting->key,['maincolor','maintextcolor','thirdtextcolor','secoundtextcolor','secondcolor']))
                                <div class="color-preview-container">
                                    <div class="color-box shadow-sm" style="background-color: {{ $setting->value }}"></div>
                                    <small class="color-code mt-2 d-block text-muted">{{ $setting->value }}</small>
                                </div>
                            @else
                                <div class="setting-value">
                                    @if ($setting->key == 'theme')
                                        @if ($setting->value == 1)
                                            <span class="badge badge-info badge-lg">القالب الأول</span>
                                        @elseif ($setting->value == 2)
                                            <span class="badge badge-success badge-lg">القالب الثاني</span>
                                        @else
                                            <span class="badge badge-warning badge-lg">القالب الثالث</span>
                                        @endif
                                    @elseif ($setting->key == 'status')
                                        @if ($setting->value == 1)
                                            <span class="badge badge-success badge-lg">
                                                <i class="fas fa-check-circle me-1"></i>مفتوح
                                            </span>
                                        @else
                                            <span class="badge badge-danger badge-lg">
                                                <i class="fas fa-times-circle me-1"></i>مغلق
                                            </span>
                                        @endif
                                    @else
                                        <p class="setting-text mb-0">{{ Str::limit($setting->value, 50) }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="edit-setting-{{ $setting->id }}" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header bg-gradient-primary text-white border-0">
                                <h5 class="modal-title font-weight-bold">
                                    <i class="fas fa-edit me-2"></i>
                                    تعديل {{ $displayName }}
                                </h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="إغلاق">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('settings.update', $setting->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body p-4">
                                    <input type="hidden" name="key" value="{{ $setting->key }}">
                                    <div class="form-group">
                                        <label class="form-label font-weight-bold text-dark">{{ $displayName }}</label>
                                        @if ($setting->key == 'logo')
                                            <div class="custom-file">
                                                <input type="file" name="value" class="custom-file-input" id="logo-{{ $setting->id }}" accept="image/*">
                                                <label class="custom-file-label" for="logo-{{ $setting->id }}">اختر صورة الشعار</label>
                                            </div>
                                            <small class="form-text text-muted">الصيغ المدعومة: JPG, PNG, GIF (الحد الأقصى: 2MB)</small>
                                        @elseif(in_array($setting->key,['maincolor','maintextcolor','thirdtextcolor','secoundtextcolor','secondcolor']))
                                            <input type="color" name="value" class="form-control form-control-color" 
                                                   value="{{ $setting->value }}" style="height: 50px;">
                                        @elseif($setting->key == 'theme')
                                            <select class="form-control custom-select" name="value">
                                                <option {{$setting->value == '1' ? 'selected' : ''}} value="1">القالب الأول</option>
                                                <option {{$setting->value == '2' ? 'selected' : ''}} value="2">القالب الثاني</option>
                                                <option {{$setting->value == '3' ? 'selected' : ''}} value="3">القالب الثالث</option>
                                            </select>
                                        @elseif($setting->key == 'status')
                                            <select class="form-control custom-select" name="value">
                                                <option {{$setting->value == '1' ? 'selected' : ''}} value="1">
                                                    <i class="fas fa-check-circle"></i> مفتوح
                                                </option>
                                                <option {{$setting->value == '0' ? 'selected' : ''}} value="0">
                                                    <i class="fas fa-times-circle"></i> مغلق
                                                </option>
                                            </select>
                                        @else
                                            <input type="text" name="value" class="form-control" 
                                                   value="{{ $setting->value }}" 
                                                   placeholder="أدخل {{ $displayName }}">
                                        @endif
                                    </div>
                                </div>
                                <div class="modal-footer border-0 bg-light">
                                    <button type="button" class="btn btn-secondary rounded-pill" data-dismiss="modal">
                                        <i class="fas fa-times me-1"></i>إلغاء
                                    </button>
                                    <button type="submit" class="btn btn-primary rounded-pill">
                                        <i class="fas fa-save me-1"></i>حفظ التغييرات
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            
            @endforeach
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        /* تحسينات عامة للصفحة */
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem;
            border-radius: 15px;
            color: white;
            margin-bottom: 2rem;
        }

        .page-header h2 {
            color: white !important;
            margin-bottom: 0.5rem;
        }

        /* تحسينات الكروت */
        .setting-card {
            border: none;
            border-radius: 15px;
            background: #ffffff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .setting-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(45deg, #667eea, #764ba2);
        }

        .shadow-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        .card-header {
            padding: 1rem 1.25rem;
            background: #f8f9fa !important;
        }

        .setting-title {
            font-size: 14px;
            font-weight: 600;
            color: #2c3e50;
            display: flex;
            align-items: center;
        }

        .setting-title i {
            color: #667eea;
            margin-left: 8px;
        }

        .edit-btn {
            border: 2px solid #667eea;
            color: #667eea;
            padding: 0.25rem 0.75rem;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .edit-btn:hover {
            background: #667eea;
            color: white;
            transform: scale(1.05);
        }

        /* تحسينات محتوى الكارت */
        .card-body {
            padding: 1.5rem;
        }

        .image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80px;
            margin-bottom: 0.5rem;
        }

        .setting-image {
            max-width: 80px;
            max-height: 80px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            object-fit: cover;
        }

        .color-preview-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .color-box {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            margin-bottom: 0.5rem;
        }

        .color-code {
            font-size: 11px;
            font-weight: 500;
            color: #6c757d;
            background: #f1f3f4;
            padding: 0.25rem 0.5rem;
            border-radius: 15px;
        }

        .setting-value {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .setting-text {
            font-size: 14px;
            color: #495057;
            font-weight: 500;
            line-height: 1.4;
        }

        .badge-lg {
            font-size: 13px;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
        }

        /* تحسينات المودال */
        .modal-content {
            border-radius: 15px;
            overflow: hidden;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }

        .modal-header {
            padding: 1.5rem;
        }

        .modal-body {
            background: #f8f9fa;
        }

        .form-label {
            color: #2c3e50;
            margin-bottom: 0.75rem;
        }

        .form-control, .custom-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .custom-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .form-control-color {
            width: 100%;
            cursor: pointer;
        }

        .custom-file-label {
            border-radius: 10px;
            border: 2px solid #e9ecef;
        }

        .btn.rounded-pill {
            border-radius: 25px !important;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
        }

        /* تحسينات الاستجابة */
        @media (max-width: 768px) {
            .page-header {
                padding: 1.5rem;
            }
            
            .setting-card {
                margin-bottom: 1rem;
            }
            
            .setting-title {
                font-size: 12px;
            }
            
            .card-body {
                padding: 1rem;
            }
        }

        /* إضافات للتحسين */
        .container {
            max-width: 1200px;
        }

        .row {
            margin: 0 -10px;
        }

        .col-lg-3, .col-md-4, .col-sm-6 {
            padding: 0 10px;
        }

        /* تأثيرات إضافية */
        .setting-card:hover .setting-title i {
            transform: rotate(360deg);
            transition: transform 0.5s ease;
        }

        .modal.fade .modal-dialog {
            transform: translate(0, -50px);
            transition: transform 0.3s ease-out;
        }

        .modal.show .modal-dialog {
            transform: none;
        }
    </style>

    <!-- JavaScript للتحسينات -->
    <script>
        // تحسين تجربة رفع الملفات
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName || 'اختر صورة الشعار');
        });

        // إضافة تأثيرات التفاعل
        $('.setting-card').hover(
            function() {
                $(this).find('.edit-btn').addClass('animate__pulse');
            },
            function() {
                $(this).find('.edit-btn').removeClass('animate__pulse');
            }
        );
    </script>
@endsection