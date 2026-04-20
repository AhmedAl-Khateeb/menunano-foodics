@extends('layouts.app')

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">تفاصيل المورد</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">{{ $supplier->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            {{-- أزرار أعلى الصفحة --}}
            <div class="mb-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
                <a href="{{ route('inventory.suppliers.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-right"></i> رجوع
                </a>

                <div class="d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                        data-target="#editSupplierModal">
                        <i class="fas fa-edit"></i> تعديل المورد
                    </button>

                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                        data-target="#attachMaterialModal">
                        <i class="fas fa-link"></i> ربط مواد المخزون
                    </button>
                </div>
            </div>

            {{-- بيانات المورد --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h3 class="card-title mb-0 font-weight-bold">بيانات المورد</h3>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0 text-right">
                            <tbody>
                                <tr>
                                    <th class="bg-light" style="width: 18%;">الاسم</th>
                                    <td style="width: 32%;">{{ $supplier->name ?? '-' }}</td>

                                    <th class="bg-light" style="width: 18%;">اسم الاتصال</th>
                                    <td style="width: 32%;">{{ $supplier->contact_name ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <th class="bg-light">الهاتف</th>
                                    <td>{{ $supplier->phone ?? '-' }}</td>

                                    <th class="bg-light">البريد الإلكتروني</th>
                                    <td>{{ $supplier->email ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <th class="bg-light">كود المورد</th>
                                    <td>{{ $supplier->code ?? '-' }}</td>

                                    <th class="bg-light">الحالة</th>
                                    <td>
                                        <span class="badge badge-{{ $supplier->is_active ? 'success' : 'secondary' }}">
                                            {{ $supplier->is_active ? 'نشط' : 'موقوف' }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



            {{-- مواد المخزون --}}
            <div class="mt-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4 class="mb-0 font-weight-bold">مواد المخزون</h4>
                    <button type="button" class="btn btn-light btn-sm border" data-toggle="modal"
                        data-target="#attachMaterialModal">
                        ربط مواد المخزون
                    </button>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover text-center mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>وحدة</th>
                                        <th>كود التعريف</th>
                                        <th>اسم المادة</th>
                                        <th>كود الوحدة الخاص بالمورد</th>
                                        <th>وحدة الطلب</th>
                                        <th>كمية الطلب</th>
                                        <th>تكلفة الشراء</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($supplier->rawMaterials as $material)
                                        @php
                                            $pivotUnit = collect($units ?? [])->firstWhere(
                                                'id',
                                                $material->pivot->unit_id,
                                            );
                                        @endphp
                                        <tr>
                                            <td>{{ $material->unit->name ?? '-' }}</td>
                                            <td>{{ $material->sku ?? '-' }}</td>
                                            <td>{{ $material->name ?? '-' }}</td>
                                            <td>{{ $material->pivot->supplier_item_code ?? '-' }}</td>
                                            <td>{{ $pivotUnit->name ?? '-' }}</td>
                                            <td>{{ rtrim(rtrim(number_format($material->pivot->order_quantity ?? 0, 3, '.', ''), '0'), '.') }}
                                            </td>
                                            <td>
                                                {{ rtrim(rtrim(number_format($material->pivot->purchase_cost ?? 0, 3, '.', ''), '0'), '.') }}
                                                {{ config('app.currency', 'SAR') }}
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-1">
                                                    <button type="button" class="btn btn-primary btn-sm edit-material-btn"
                                                        data-toggle="modal" data-target="#editMaterialModal"
                                                        data-pivot-id="{{ $material->pivot->id }}"
                                                        data-material-name="{{ $material->name }}"
                                                        data-material-sku="{{ $material->sku }}"
                                                        data-unit-id="{{ $material->pivot->unit_id }}"
                                                        data-order-quantity="{{ $material->pivot->order_quantity }}"
                                                        data-conversion-factor="{{ $material->pivot->conversion_factor }}"
                                                        data-purchase-cost="{{ $material->pivot->purchase_cost }}"
                                                        data-supplier-item-code="{{ $material->pivot->supplier_item_code }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>

                                                    <form
                                                        action="{{ route('inventory.suppliers.materials.detach', [$supplier->id, $material->pivot->id]) }}"
                                                        method="POST" class="d-inline delete-link-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger btn-sm delete-link-btn"
                                                            data-name="{{ $material->name }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                لا توجد مواد مخزون مرتبطة بهذا المورد حالياً
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    {{-- مودال تعديل المورد --}}
    <div class="modal fade" id="editSupplierModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('inventory.suppliers.update', $supplier->id) }}" method="POST" class="modal-content">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">تعديل المورد</h5>
                    <button type="button" class="close ml-0 mr-auto" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body text-right">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>الاسم</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $supplier->name) }}" required>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>كود المورد</label>
                            <input type="text" name="code" class="form-control"
                                value="{{ old('code', $supplier->code) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>اسم الاتصال</label>
                            <input type="text" name="contact_name" class="form-control"
                                value="{{ old('contact_name', $supplier->contact_name) }}">
                        </div>

                        <div class="col-md-4 form-group">
                            <label>الهاتف</label>
                            <input type="text" name="phone" class="form-control"
                                value="{{ old('phone', $supplier->phone) }}">
                        </div>

                        <div class="col-md-4 form-group">
                            <label>البريد الإلكتروني</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $supplier->email) }}">
                        </div>
                    </div>

                    <div class="form-group form-check text-right">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                            {{ old('is_active', $supplier->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label mr-4" for="is_active">نشط</label>
                    </div>
                </div>

                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                    <button type="button" class="btn btn-light border" data-dismiss="modal">إغلاق</button>
                </div>
            </form>
        </div>
    </div>

    {{-- مودال ربط مادة مخزن --}}
    <div class="modal fade" id="attachMaterialModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('inventory.suppliers.materials.attach', $supplier->id) }}" method="POST"
                class="modal-content">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">ربط مادة مخزن بالمورد</h5>
                    <button type="button" class="close ml-0 mr-auto" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body text-right">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>مادة المخزن</label>
                            <select name="raw_material_id" class="form-control" required>
                                <option value="">اختر مادة المخزن</option>
                                @foreach ($materials as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }} {{ $item->sku ? '(' . $item->sku . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>وحدة الطلب</label>
                            <select name="unit_id" class="form-control">
                                <option value="">اختر الوحدة</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>كمية الطلب</label>
                            <input type="number" step="0.001" min="0.001" name="order_quantity"
                                class="form-control" value="1" required>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>معامل التحويل</label>
                            <input type="number" step="0.001" min="0.001" name="conversion_factor"
                                class="form-control" value="1" required>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>تكلفة الشراء</label>
                            <input type="number" step="0.001" min="0" name="purchase_cost"
                                class="form-control" value="0" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>كود الوحدة الخاص بالمورد</label>
                        <input type="text" name="supplier_item_code" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>ملاحظات</label>
                        <textarea name="notes" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="form-group form-check text-right">
                        <input type="checkbox" class="form-check-input" id="is_preferred_attach" name="is_preferred"
                            value="1">
                        <label class="form-check-label mr-4" for="is_preferred_attach">مورد أساسي لهذه المادة</label>
                    </div>
                </div>

                <div class="modal-footer justify-content-start">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                    <button type="button" class="btn btn-light border" data-dismiss="modal">إغلاق</button>
                </div>
            </form>
        </div>
    </div>

    {{-- مودال تحديث ربط مادة مخزن --}}
    <div class="modal fade" id="editMaterialModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="editMaterialForm" method="POST" class="modal-content">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="editMaterialModalTitle">تحديث وحدة المخزون</h5>
                    <button type="button" class="close ml-0 mr-auto" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body text-right">
                    <div class="form-group">
                        <label>وحدة الطلب</label>
                        <select name="unit_id" id="edit_unit_id" class="form-control">
                            <option value="">اختر الوحدة</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>معامل تحويل الوحدة بين الطلب والتخزين</label>
                        <input type="number" step="0.001" min="0.001" name="conversion_factor"
                            id="edit_conversion_factor" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>كمية الطلب</label>
                        <input type="number" step="0.001" min="0.001" name="order_quantity"
                            id="edit_order_quantity" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>تكلفة الشراء لكل وحدة</label>
                        <input type="number" step="0.001" min="0" name="purchase_cost"
                            id="edit_purchase_cost" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>كود الوحدة الخاص بالمورد</label>
                        <input type="text" name="supplier_item_code" id="edit_supplier_item_code"
                            class="form-control">
                    </div>

                    <div class="form-group form-check text-right">
                        <input type="checkbox" class="form-check-input" id="edit_is_preferred" name="is_preferred"
                            value="1">
                        <label class="form-check-label mr-4" for="edit_is_preferred">مورد أساسي لهذه المادة</label>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                    <button type="button" class="btn btn-light border" data-dismiss="modal">إغلاق</button>
                </div>
            </form>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'تم بنجاح',
                text: @json(session('success')),
                timer: 2500,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                text: @json(session('error')),
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.edit-material-btn');
            const editForm = document.getElementById('editMaterialForm');
            const modalTitle = document.getElementById('editMaterialModalTitle');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const pivotId = this.dataset.pivotId;
                    const materialName = this.dataset.materialName || '';
                    const materialSku = this.dataset.materialSku || '';
                    const unitId = this.dataset.unitId || '';
                    const orderQuantity = this.dataset.orderQuantity || '';
                    const conversionFactor = this.dataset.conversionFactor || '';
                    const purchaseCost = this.dataset.purchaseCost || '';
                    const supplierItemCode = this.dataset.supplierItemCode || '';

                    editForm.action =
                        "{{ url('inventory/suppliers/' . $supplier->id . '/materials') }}/" +
                        pivotId;

                    modalTitle.innerText = materialSku ?
                        `تحديث وحدة المخزون ${materialName} (${materialSku})` :
                        `تحديث وحدة المخزون ${materialName}`;

                    document.getElementById('edit_unit_id').value = unitId;
                    document.getElementById('edit_order_quantity').value = orderQuantity;
                    document.getElementById('edit_conversion_factor').value = conversionFactor;
                    document.getElementById('edit_purchase_cost').value = purchaseCost;
                    document.getElementById('edit_supplier_item_code').value = supplierItemCode;
                });
            });

            document.querySelectorAll('.delete-link-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    const form = this.closest('.delete-link-form');
                    const name = this.dataset.name || 'هذه المادة';

                    Swal.fire({
                        title: 'هل أنت متأكد؟',
                        text: `سيتم إلغاء ربط "${name}" من المورد`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'نعم، احذف',
                        cancelButtonText: 'إلغاء',
                        reverseButtons: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
