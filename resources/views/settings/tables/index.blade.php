@extends('layouts.app')

@section('main-content')
<div class="min-h-screen bg-gray-50/50" 
     x-data="{ 
        activeTab: localStorage.getItem('dining_active_tab') || 'areas', 
        selectedAreaId: new URLSearchParams(window.location.search).get('area') || 'all',
        updateUrl() {
            const url = new URL(window.location);
            if(this.selectedAreaId === 'all') url.searchParams.delete('area');
            else url.searchParams.set('area', this.selectedAreaId);
            window.history.replaceState({}, '', url);
        }
     }" 
     x-init="$watch('activeTab', val => localStorage.setItem('dining_active_tab', val)); $watch('selectedAreaId', () => updateUrl())">
    
    <!-- Hero / Header Section -->
    <div class="bg-white border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm flex-shrink-0">
                        <i class="fas fa-layer-group text-lg md:text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl md:text-2xl font-black text-gray-900 tracking-tight font-sans">
                            إدارة الصالات
                        </h1>
                        <p class="text-xs md:text-sm font-medium text-gray-500">
                            توزيع المساحات والطاولات
                        </p>
                    </div>
                </div>

                <!-- Modern Tabs -->
                <div class="bg-gray-100/80 p-1.5 rounded-xl grid grid-cols-2 md:flex md:items-center gap-1 w-full md:w-auto">
                    <button @click="activeTab = 'areas'" 
                            :class="{ 'bg-blue-600 text-white shadow-md': activeTab === 'areas', 'bg-white text-gray-600 hover:text-gray-800 hover:bg-gray-50': activeTab !== 'areas' }"
                            class="px-4 md:px-6 py-2.5 rounded-lg text-xs md:text-sm font-bold transition-all duration-200 focus:outline-none flex items-center justify-center gap-2">
                        <i class="fas fa-map-marker-alt" :class="{ 'text-white': activeTab === 'areas', 'text-gray-400': activeTab !== 'areas' }"></i>
                        <span class="truncate">الصالات</span>
                    </button>
                    <button @click="activeTab = 'tables'" 
                            :class="{ 'bg-blue-600 text-white shadow-md': activeTab === 'tables', 'bg-white text-gray-600 hover:text-gray-800 hover:bg-gray-50': activeTab !== 'tables' }"
                            class="px-4 md:px-6 py-2.5 rounded-lg text-xs md:text-sm font-bold transition-all duration-200 focus:outline-none flex items-center justify-center gap-2">
                        <i class="fas fa-chair" :class="{ 'text-white': activeTab === 'tables', 'text-gray-400': activeTab !== 'tables' }"></i>
                        <span class="truncate">الطاولات</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Dining Areas Content -->
        <div x-show="activeTab === 'areas'" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0">
            
            <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-4 mb-6">
                <div>
                     <h2 class="text-lg font-bold text-gray-800">نظرة عامة على الصالات</h2>
                     <p class="text-xs text-gray-400 mt-1">لديك {{ $diningAreas->count() }} مساحة مضافة</p>
                </div>
                <button @click="$dispatch('open-modal', 'add-area-modal')" 
                        class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-indigo-200 transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2 active:scale-95">
                    <i class="fas fa-plus"></i>
                    <span>إضافة صالة</span>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @forelse($diningAreas as $area)
                    <div class="group bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 hover:border-indigo-100 transition-all duration-300 relative overflow-hidden h-full flex flex-col">
                        
                        <!-- Background decoration -->
                        <div class="absolute -right-10 -top-10 w-32 h-32 bg-gradient-to-br from-indigo-50/80 to-blue-50/80 rounded-full blur-3xl group-hover:bg-indigo-100/60 transition-colors"></div>

                        <div class="relative z-10 flex-1 flex flex-col">
                            <div class="flex justify-between items-start mb-6">
                                <div class="w-14 h-14 rounded-2xl bg-indigo-50/80 text-indigo-600 flex items-center justify-center text-xl shadow-sm ring-4 ring-white">
                                    <i class="fas fa-couch"></i>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button @click="$dispatch('open-modal', 'edit-area-modal-{{ $area->id }}')" 
                                            class="w-9 h-9 rounded-xl flex items-center justify-center text-gray-400 hover:text-indigo-600 hover:bg-white hover:shadow-sm border border-transparent hover:border-gray-100 transition-all">
                                        <i class="fas fa-pen text-xs"></i>
                                    </button>
                                    <button @click="$dispatch('open-modal', 'delete-area-modal-{{ $area->id }}')" 
                                            class="w-9 h-9 rounded-xl flex items-center justify-center text-gray-400 hover:text-red-600 hover:bg-white hover:shadow-sm border border-transparent hover:border-gray-100 transition-all">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mt-auto">
                                <h3 class="text-xl font-black text-gray-900 mb-2 group-hover:text-indigo-700 transition-colors truncate leading-tight">
                                    {{ $area->name }}
                                </h3>
                                
                                <div class="flex flex-wrap items-center gap-2.5 mt-4 pt-4 border-t border-gray-50">
                                    <span class="px-3 py-1.5 rounded-xl bg-gray-50 border border-gray-100 text-xs font-bold text-gray-600 flex items-center gap-2 cursor-pointer hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-100 transition-all"
                                          @click="activeTab = 'tables'; selectedAreaId = '{{ $area->id }}'">
                                        <i class="fas fa-chair text-gray-400 text-[10px]"></i>
                                        {{ $area->tables->count() }} طاولة
                                    </span>
                                    <span class="px-3 py-1.5 rounded-xl {{ $area->is_active ? 'bg-green-50 text-green-700 border-green-100' : 'bg-red-50 text-red-700 border-red-100' }} border text-xs font-bold flex items-center gap-2">
                                        <span class="relative flex h-2 w-2">
                                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $area->is_active ? 'bg-green-400' : 'bg-red-400' }} opacity-75"></span>
                                          <span class="relative inline-flex rounded-full h-2 w-2 {{ $area->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                        </span>
                                        {{ $area->is_active ? 'نشط' : 'معطل' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Area Modal -->
                    <div x-data="{ show: false }" x-show="show" x-cloak 
                         @open-modal.window="if ($event.detail === 'edit-area-modal-{{ $area->id }}') show = true" 
                         class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                                 class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="show = false" aria-hidden="true"></div>
                            
                            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-10 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-10 sm:scale-95" 
                                 class="inline-block align-bottom bg-white rounded-2xl text-right overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full border border-gray-100">
                                
                                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 px-6 py-4 flex justify-between items-center">
                                    <h3 class="text-white font-bold text-lg">تعديل الصالة</h3>
                                    <button @click="show = false" class="text-white/80 hover:text-white transition-colors">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                
                                <form action="{{ route('dining-areas.update', $area->id) }}" method="POST" class="p-6">
                                    @csrf @method('PUT')
                                    <div class="mb-5">
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">اسم الصالة</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                                                <i class="fas fa-tag"></i>
                                            </div>
                                            <input type="text" name="name" value="{{ $area->name }}" class="w-full pl-4 pr-10 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none text-sm font-bold text-gray-800" required>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-6 flex items-center gap-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ $area->is_active ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                                        </label>
                                        <div>
                                            <label class="block text-sm font-bold text-gray-800">حالة الصالة</label>
                                            <p class="text-xs text-gray-500">تفعيل أو تعطيل استقبال الطلبات في هذه الصالة</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3 pt-2">
                                        <button type="button" @click="show = false" class="flex-1 py-3 rounded-xl text-gray-500 font-bold hover:bg-gray-50 transition-colors text-sm border border-gray-200">إلغاء</button>
                                        <button type="submit" class="flex-[2] py-3 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all active:scale-95 text-sm">حفظ التغييرات</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Area Modal -->
                    <div x-data="{ show: false }" x-show="show" x-cloak 
                         @open-modal.window="if ($event.detail === 'delete-area-modal-{{ $area->id }}') show = true" 
                         class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                                 class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="show = false" aria-hidden="true"></div>
                            
                            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-10 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-10 sm:scale-95" 
                                 class="inline-block align-bottom bg-white rounded-2xl text-center overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm w-full border border-gray-100">
                                
                                <div class="p-6">
                                    <div class="w-16 h-16 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center mx-auto mb-4 scale-100 animate-pulse">
                                        <i class="fas fa-exclamation-triangle text-2xl"></i>
                                    </div>
                                    <h3 class="text-xl font-black text-gray-900 mb-2">حذف الصالة؟</h3>
                                    <p class="text-sm text-gray-500 leading-relaxed mb-6">
                                        هل أنت متأكد من حذف "<strong>{{ $area->name }}</strong>"؟ <br>
                                        <span class="text-red-500 font-bold text-xs">تنبيه: سيتم حذف جميع الطاولات المرتبطة بهذه الصالة.</span>
                                    </p>
                                    
                                    <form action="{{ route('dining-areas.destroy', $area->id) }}" method="POST" class="flex flex-col gap-2">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-full py-3 rounded-xl bg-red-500 text-white font-bold hover:bg-red-600 shadow-lg shadow-red-200 transition-all active:scale-95 text-sm">نعم، حذف نهائي</button>
                                        <button type="button" @click="show = false" class="w-full py-3 rounded-xl text-gray-500 font-bold hover:bg-gray-50 transition-colors text-sm">تراجع</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="col-span-full py-16 flex flex-col items-center justify-center text-center">
                        <div class="w-32 h-32 bg-gray-50 rounded-full flex items-center justify-center mb-6 shadow-inner relative">
                            <i class="fas fa-map-marked-alt text-5xl text-gray-300"></i>
                            <div class="absolute bottom-2 right-4 w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center text-white text-xs border-4 border-white">
                                <i class="fas fa-plus"></i>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">القائمة فارغة</h3>
                        <p class="text-gray-500 text-sm max-w-md mx-auto mb-8">لم تقم بإضافة أي صالات أو مساحات بعد. ابدأ بإضافة الصالات لتقسيم مطعمك بشكل منظم.</p>
                        <button @click="$dispatch('open-modal', 'add-area-modal')" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all hover:-translate-y-1">
                            إضافة صالة جديدة
                        </button>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Tables Content -->
        <div x-show="activeTab === 'tables'" style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0">
            
             <div class="flex flex-col gap-6 mb-8">
                <!-- Row 1: Title and Add Action -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                         <h2 class="text-lg font-bold text-gray-800">إدارة الطاولات</h2>
                         <p class="text-xs text-gray-400 mt-1">لديك {{ $tables->count() }} طاولة موزعة</p>
                    </div>
                
                    <button @click="$dispatch('open-modal', { name: 'add-table-modal', areaId: selectedAreaId })" 
                            class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-indigo-200 transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2 active:scale-95">
                        <i class="fas fa-plus"></i>
                        <span>إضافة طاولة</span>
                    </button>
                </div>

                <!-- Row 2: Filter Tabs -->
                <div class="w-full relative group">
                    <!-- Scroll Right Button -->
                    <button @click="$refs.chipsContainer.scrollBy({ left: 200, behavior: 'smooth' })" 
                            class="absolute right-0 top-1/2 -translate-y-1/2 z-10 w-8 h-8 rounded-full bg-white shadow-md border border-gray-100 flex items-center justify-center text-gray-400 hover:text-indigo-600 transition-all opacity-0 group-hover:opacity-100 hidden sm:flex">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </button>

                    <!-- Modern Chips Filter -->
                    <div x-ref="chipsContainer" class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1 w-full px-2 scroll-smooth">
                         <!-- All Filter -->
                         <button @click="selectedAreaId = 'all'"
                                 :class="selectedAreaId === 'all' ? 'bg-gray-900 text-white shadow-lg shadow-gray-200' : 'bg-white text-gray-500 hover:bg-gray-50 hover:text-gray-700 border border-gray-200'"
                                 class="px-5 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition-all duration-200 flex-shrink-0">
                             الكل
                         </button>
                         
                         <!-- Areas Loop -->
                         @foreach($diningAreas as $area)
                             <button @click="selectedAreaId = '{{ $area->id }}'"
                                     :class="selectedAreaId == '{{ $area->id }}' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-white text-gray-500 hover:bg-gray-50 hover:text-gray-700 border border-gray-200'"
                                     class="px-5 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap transition-all duration-200 flex-shrink-0 relative">
                                 {{ $area->name }}
                                 @if($area->tables->count() > 0)
                                    <span class="ml-1 opacity-60 text-[10px]">({{ $area->tables->count() }})</span>
                                 @endif
                             </button>
                         @endforeach
                    </div>

                    <!-- Scroll Left Button -->
                    <button @click="$refs.chipsContainer.scrollBy({ left: -200, behavior: 'smooth' })" 
                            class="absolute left-0 top-1/2 -translate-y-1/2 z-10 w-8 h-8 rounded-full bg-white shadow-md border border-gray-100 flex items-center justify-center text-gray-400 hover:text-indigo-600 transition-all opacity-0 group-hover:opacity-100 hidden sm:flex">
                        <i class="fas fa-chevron-left text-xs"></i>
                    </button>
                </div>
            </div>

            @if($tables->isEmpty())
                <div class="bg-white rounded-3xl p-12 text-center border border-dashed border-gray-300">
                    <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-4 text-indigo-400">
                        <i class="fas fa-chair text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">لا توجد طاولات</h3>
                    <p class="text-gray-500 text-sm mt-1 mb-6">قم بإضافة الطاولات وربطها بالصالات المتوفرة</p>
                    <button @click="$dispatch('open-modal', 'add-table-modal')" class="text-indigo-600 font-bold hover:underline text-sm">
                        + إضافة أول طاولة
                    </button>
                </div>
            @else
                <!-- Tables Grid Layout (Unified for all screens) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    @foreach($tables as $table)
                        <div x-show="selectedAreaId == 'all' || selectedAreaId == '{{ $table->dining_area_id }}'" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg hover:border-indigo-100 transition-all duration-300 relative overflow-hidden flex flex-col h-full">
                            
                            <!-- Card Header & Actions -->
                            <div class="p-4 pb-2 flex justify-between items-start relative z-10">
                                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shadow-inner">
                                    <i class="fas fa-chair"></i>
                                </div>
                                <div class="flex items-center gap-1 bg-gray-50 rounded-lg p-1 border border-gray-100">
                                    <button @click="$dispatch('open-modal', 'edit-table-modal-{{ $table->id }}')" 
                                            class="w-8 h-8 rounded-md flex items-center justify-center text-gray-400 hover:text-indigo-600 hover:bg-white transition-all" title="تعديل">
                                        <i class="fas fa-pen text-xs"></i>
                                    </button>
                                    <div class="w-px h-4 bg-gray-200"></div>
                                    <button @click="$dispatch('open-modal', 'delete-table-modal-{{ $table->id }}')" 
                                            class="w-8 h-8 rounded-md flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-white transition-all" title="حذف">
                                        <i class="fas fa-trash text-xs"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="px-4 py-2 flex-1">
                                <h4 class="font-black text-gray-900 text-lg mb-1 truncate" title="{{ $table->name }}">
                                    {{ $table->name }}
                                </h4>
                                <div class="h-0.5 w-8 bg-indigo-500 rounded-full mb-3"></div>
                                
                                <div class="space-y-2">
                                    <!-- Area Info -->
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-400 font-medium text-xs">صالة / مكان:</span>
                                        <span class="font-bold text-gray-700 bg-gray-50 px-2 py-0.5 rounded border border-gray-100 truncate max-w-[120px]">
                                            {{ $table->diningArea->name ?? 'غير محدد' }}
                                        </span>
                                    </div>
                                    <!-- Capacity Info -->
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-400 font-medium text-xs">السعة:</span>
                                        <div class="flex items-center gap-1 font-bold text-gray-700">
                                            <span>{{ $table->capacity ?? '0' }}</span>
                                            <span class="text-[10px] text-gray-400">أفراد</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Decorative Bottom -->
                            <div class="mt-3 px-4 pb-4">
                                <div class="w-full bg-gray-50 rounded-lg p-2 flex items-center justify-center gap-2 group-hover:bg-indigo-50 transition-colors">
                                    <span class="w-2 h-2 rounded-full {{ $table->diningArea ? 'bg-green-400' : 'bg-gray-300' }}"></span>
                                    <span class="text-[10px] font-bold {{ $table->diningArea ? 'text-green-600' : 'text-gray-400' }}">
                                        {{ $table->diningArea ? 'متاح للطلب' : 'غير جاهز' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Iterate Modals for Tables -->
                @foreach($tables as $table)
                     <!-- Edit Table Modal -->
                     <div x-data="{ show: false }" x-show="show" x-cloak 
                        @open-modal.window="if ($event.detail === 'edit-table-modal-{{ $table->id }}') show = true" 
                        class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                                class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="show = false" aria-hidden="true"></div>
                            
                            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-10 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-10 sm:scale-95" 
                                class="inline-block align-bottom bg-white rounded-2xl text-right overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full border border-gray-100">
                                
                                <div class="bg-gray-50 border-b border-gray-100 px-6 py-4 flex justify-between items-center">
                                    <h3 class="text-gray-900 font-bold text-lg">تعديل الطاولة</h3>
                                    <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                
                                <form action="{{ route('tables.update', $table->id) }}" method="POST" class="p-6">
                                    @csrf @method('PUT')
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">اسم الطاولة</label>
                                            <input type="text" name="name" value="{{ $table->name }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none text-sm font-bold text-gray-800" required>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">صالة / مكان</label>
                                                <select name="dining_area_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none text-sm font-bold text-gray-800" required>
                                                    @foreach ($diningAreas as $diningArea)
                                                        <option value="{{ $diningArea->id }}" {{ $table->dining_area_id == $diningArea->id ? 'selected' : '' }}>{{ $diningArea->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">السعة</label>
                                                <input type="number" name="capacity" value="{{ $table->capacity }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none text-sm font-bold text-gray-800" min="1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 pt-6">
                                        <button type="button" @click="show = false" class="flex-1 py-3 rounded-xl text-gray-500 font-bold hover:bg-gray-50 transition-colors text-sm border border-gray-200">إلغاء</button>
                                        <button type="submit" class="flex-[2] py-3 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all active:scale-95 text-sm">حفظ</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                
                    <!-- Delete Table Modal -->
                     <div x-data="{ show: false }" x-show="show" x-cloak 
                        @open-modal.window="if ($event.detail === 'delete-table-modal-{{ $table->id }}') show = true" 
                        class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                                class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="show = false" aria-hidden="true"></div>
                            
                            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-10 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-10 sm:scale-95" 
                                class="inline-block align-bottom bg-white rounded-2xl text-center overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm w-full border border-gray-100">
                                
                                <div class="p-6">
                                    <div class="w-12 h-12 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-trash-alt text-xl"></i>
                                    </div>
                                    <h3 class="text-xl font-black text-gray-900 mb-2">حذف الطاولة؟</h3>
                                    <p class="text-sm text-gray-500 mb-6">
                                        هل أنت متأكد من حذف "<strong>{{ $table->name }}</strong>"؟
                                    </p>
                                    
                                    <form action="{{ route('tables.destroy', $table->id) }}" method="POST" class="flex flex-col gap-2">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-full py-3 rounded-xl bg-red-500 text-white font-bold hover:bg-red-600 shadow-lg shadow-red-200 transition-all active:scale-95 text-sm">نعم، حذف</button>
                                        <button type="button" @click="show = false" class="w-full py-3 rounded-xl text-gray-500 font-bold hover:bg-gray-50 transition-colors text-sm">تراجع</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<!-- Add Area Modal -->
<div x-data="{ show: false }" x-show="show" x-cloak 
    @open-modal.window="if ($event.detail === 'add-area-modal') show = true" 
    class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
            class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="show = false" aria-hidden="true"></div>
        
        <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-10 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-10 sm:scale-95" 
            class="inline-block align-bottom bg-white rounded-2xl text-right overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full border border-gray-100">
            
            <div class="bg-gray-50 border-b border-gray-100 px-6 py-4 flex justify-between items-center">
                <h3 class="text-gray-900 font-bold text-lg">إضافة صالة جديدة</h3>
                <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form action="{{ route('dining-areas.store') }}" method="POST" class="p-6">
                @csrf
                <div class="mb-5">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">اسم الصالة / المكان</label>
                    <input type="text" name="name" placeholder="مثال: الصالة الرئيسية، التراس" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none text-sm font-bold text-gray-800" required>
                </div>
                <div class="flex items-center gap-3 pt-2">
                    <button type="button" @click="show = false" class="flex-1 py-3 rounded-xl text-gray-500 font-bold hover:bg-gray-50 transition-colors text-sm border border-gray-200">إلغاء</button>
                    <button type="submit" class="flex-[2] py-3 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all active:scale-95 text-sm">إضافة الصالة</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Table Modal -->
<div x-data="{ show: false, preSelectedAreaId: '' }" x-show="show" x-cloak 
    @open-modal.window="if ($event.detail === 'add-table-modal' || $event.detail.name === 'add-table-modal') { show = true; preSelectedAreaId = $event.detail.areaId || ''; }" 
    class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
            class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" @click="show = false" aria-hidden="true"></div>
        
        <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-10 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-10 sm:scale-95" 
            class="inline-block align-bottom bg-white rounded-2xl text-right overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full border border-gray-100">
            
            <div class="bg-gray-50 border-b border-gray-100 px-6 py-4 flex justify-between items-center">
                <h3 class="text-gray-900 font-bold text-lg">إضافة طاولة جديدة</h3>
                <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form action="{{ route('tables.store') }}" method="POST" class="p-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">اسم الطاولة</label>
                        <input type="text" name="name" placeholder="مثال: T-01, طاولة 5" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none text-sm font-bold text-gray-800" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">صالة / مكان</label>
                            <select name="dining_area_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none text-sm font-bold text-gray-800" required>
                                <option value="" disabled :selected="!preSelectedAreaId || preSelectedAreaId == 'all'">اختر المكان...</option>
                                @foreach ($diningAreas as $diningArea)
                                    <option value="{{ $diningArea->id }}" :selected="preSelectedAreaId == '{{ $diningArea->id }}'">{{ $diningArea->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">السعة</label>
                            <input type="number" name="capacity" placeholder="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none text-sm font-bold text-gray-800" min="1">
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3 pt-6">
                    <button type="button" @click="show = false" class="flex-1 py-3 rounded-xl text-gray-500 font-bold hover:bg-gray-50 transition-colors text-sm border border-gray-200">إلغاء</button>
                    <button type="submit" class="flex-[2] py-3 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all active:scale-95 text-sm">إضافة الطاولة</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
