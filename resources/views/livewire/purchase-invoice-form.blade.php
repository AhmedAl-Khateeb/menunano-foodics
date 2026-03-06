<div>
    <div class="row">
        <!-- Main Form Details -->
        <div class="col-md-8 mx-auto">
            <div class="card card-primary border-0 shadow-sm rounded-lg mb-4">
                <div class="card-header bg-white border-bottom text-right">
                    <h3 class="card-title font-weight-bold text-dark mb-0 py-1 float-right">بيانات فاتورة المشتريات</h3>
                </div>
                
                <div class="card-body bg-light text-right">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="row">
                        <!-- Supplier -->
                        <div class="col-md-6 form-group mb-3 text-right">
                            <label class="font-weight-bold">المورد <span class="text-danger">*</span></label>
                            <select wire:model="supplier_id" class="form-control bg-white @error('supplier_id') is-invalid @enderror">
                                <option value="">-- اختر المورد --</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }} {{ $supplier->balance > 0 ? '(له متأخرات)' : '' }}</option>
                                @endforeach
                            </select>
                            @error('supplier_id') <span class="text-danger small font-weight-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Date -->
                        <div class="col-md-6 form-group mb-3 text-right">
                            <label class="font-weight-bold">تاريخ الاستحقاق / الفاتورة <span class="text-danger">*</span></label>
                            <input type="date" wire:model="due_date" class="form-control bg-white @error('due_date') is-invalid @enderror">
                            @error('due_date') <span class="text-danger small font-weight-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Invoice Number -->
                        <div class="col-md-12 form-group mb-3 text-right">
                            <label class="font-weight-bold">الرقم المرجعي (رقم الفاتورة من المورد)</label>
                            <input type="text" wire:model="invoice_number" class="form-control bg-white @error('invoice_number') is-invalid @enderror text-right" placeholder="مثال: INV-1234">
                            @error('invoice_number') <span class="text-danger small font-weight-bold">{{ $message }}</span> @enderror
                        </div>

                        <!-- Notes -->
                        <div class="col-md-12 form-group mb-3 text-right">
                            <label class="font-weight-bold">ملاحظات الفاتورة</label>
                            <textarea wire:model="notes" class="form-control bg-white text-right" rows="2" placeholder="أي ملاحظات حول الطلبية أو المورد..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Dynamic Table -->
            <div class="card border-0 shadow-sm rounded-lg mb-4">
                <div class="card-header bg-white border-bottom text-right">
                    <h3 class="card-title font-weight-bold text-dark mb-0 py-1 float-right">الأصناف (المنتجات / المواد)</h3>
                </div>
                <div class="card-body p-0">
                    <!-- Search Bar -->
                    <div class="p-3 bg-light border-bottom position-relative text-right">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" wire:model.live.debounce.300ms="searchQuery" class="form-control text-right" placeholder="ابحث عن اسم المنتج أو المادة واسم الصنف..." autocomplete="off">
                        </div>

                        <!-- Search Results Dropdown -->
                        @if(strlen($searchQuery) >= 2)
                            <div class="position-absolute w-100 bg-white shadow-lg rounded mt-1 border" style="z-index: 1000; max-height: 250px; overflow-y: auto; right: 0;">
                                @if(count($searchResults) > 0)
                                    <ul class="list-group list-group-flush">
                                        @foreach($searchResults as $result)
                                            <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" style="cursor: pointer" wire:click="addItem({{ json_encode($result) }})">
                                                <div>
                                                    <strong class="text-primary">{{ $result['name'] }}</strong>
                                                    <small class="text-muted d-block">سعر الشراء: {{ $result['purchase_price'] }} ج.م / {{ $result['unit'] }}</small>
                                                </div>
                                                <button class="btn btn-sm btn-outline-success"><i class="fas fa-plus"></i></button>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="p-3 text-center text-muted">لم يتم العثور على نتائج لمطابقة: "{{ $searchQuery }}"</div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Selected Items Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th style="width: 40%">اسم الصنف</th>
                                    <th class="text-center" style="width: 20%">الكمية</th>
                                    <th class="text-center" style="width: 20%">التكلفة (الوحدة)</th>
                                    <th class="text-center" style="width: 15%">الإجمالي</th>
                                    <th class="text-center" style="width: 5%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $index => $item)
                                    <tr>
                                        <td class="align-middle font-weight-bold text-dark">
                                            {{ $item['name'] }}
                                            <br><small class="text-muted">الوحدة: {{ $item['unit'] }}</small>
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" min="0.01" wire:model.live.debounce.500ms="items.{{ $index }}.quantity" class="form-control form-control-sm text-center font-weight-bold border-info">
                                        </td>
                                        <td>
                                            <input type="number" step="0.01" min="0" wire:model.live.debounce.500ms="items.{{ $index }}.unit_price" class="form-control form-control-sm text-center font-weight-bold border-success">
                                        </td>
                                        <td class="text-center align-middle bg-light font-weight-bold h5 mb-0 text-dark">
                                            {{ number_format($item['total'], 2) }}
                                        </td>
                                        <td class="text-center align-middle">
                                            <button type="button" wire:click="removeItem({{ $index }})" class="btn btn-sm btn-light text-danger hover-bg-danger" title="حذف">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-5 bg-light">
                                            <i class="fas fa-box-open text-gray-300 block mb-2" style="font-size: 2rem;"></i><br>
                                            الرجاء البحث وإضافة منتجات / مواد خام أعلاه لتسجيلها في الفاتورة.
                                        </td>
                                    </tr>
                                @endforelse
                                @error('items')
                                    <tr>
                                        <td colspan="5" class="text-center text-danger font-weight-bold border-danger py-2 bg-white">{{ $message }}</td>
                                    </tr>
                                @enderror
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Payment Details & Submit -->
            <div class="card border-0 shadow-sm rounded-lg mb-4 bg-light">
                <div class="card-body p-4 text-right">
                    <div class="row align-items-center">
                        <div class="col-md-5">
                            <h4 class="font-weight-bold text-dark mb-1">صافي قيمة الفاتورة</h4>
                            <p class="text-muted small mb-0">شامل الأصناف والتكلفة المضافة</p>
                        </div>
                        <div class="col-md-7 text-left">
                            <h2 class="font-weight-bold text-primary mb-0 border-bottom border-primary pb-2 d-inline-block">{{ number_format($this->invoiceTotal, 2) }} <small class="text-muted">ج.م</small></h2>
                        </div>
                    </div>

                    <div class="row align-items-center mt-4">
                        <div class="col-md-5">
                            <label class="font-weight-bold text-dark mb-1">المدفوع من الفاتورة (الكاش)</label>
                            <p class="text-muted small mb-0">لو الفاتورة آجلة أترك القيمة 0</p>
                        </div>
                        <div class="col-md-7">
                            <div class="input-group input-group-lg">
                                <input type="number" step="0.01" min="0" wire:model.live.debounce.300ms="paid_amount" class="form-control text-center font-weight-bold text-success" placeholder="0.00">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white">ج.م</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center mt-3 pt-3 border-top pb-3 text-right">
                        <div class="col-md-5">
                            <span class="font-weight-bold text-muted">حالة الفاتورة (تلقائي):</span>
                        </div>
                        <div class="col-md-7 text-left">
                            @if($this->status == 'paid')
                                <span class="badge badge-success px-3 py-2 h6 font-weight-bold mb-0">مدفوعة بالكامل</span>
                            @elseif($this->status == 'partial')
                                <span class="badge badge-warning px-3 py-2 h6 font-weight-bold mb-0">مدفوعة جزئياً (تضاف للآجل)</span>
                            @else
                                <span class="badge badge-danger px-3 py-2 h6 font-weight-bold mb-0">فاتورة آجلة (تضاف لرصيد المورد)</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <button type="button" wire:click="saveInvoice" class="btn btn-primary btn-lg btn-block font-weight-bold shadow shadow-hover transition-all pt-3 pb-3" wire:loading.attr="disabled">
                                <i class="fas fa-save mr-2"></i> حفظ الفاتورة وإضافة المشتريات للمخزون
                            </button>
                            <div wire:loading wire:target="saveInvoice" class="text-center mt-2 text-muted font-weight-bold w-100">
                                <i class="fas fa-spinner fa-spin mr-1"></i> يتم معالجة الفاتورة...
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <style>
        .hover-bg-danger:hover { background-color: #dc3545 !important; color: white !important; border-color: #dc3545 !important; }
        .shadow-hover:hover { box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important; transform: translateY(-1px); }
        .transition-all { transition: all 0.2s ease-in-out; }
    </style>
</div>
