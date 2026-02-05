@extends('layouts.app')

@section('title', 'تحت التطوير')

@section('main-content')
<div class="flex flex-col items-center justify-center h-full text-center p-8">
    <div class="bg-gray-800 p-4 rounded-full mb-4">
        <i class="fas fa-hard-hat text-4xl text-yellow-500"></i>
    </div>
    <h1 class="text-3xl font-bold text-gray-800 mb-2">هذه الصفحة تحت التطوير</h1>
    <p class="text-gray-600 mb-6">نحن نعمل بجد لإتاحة هذه الميزة قريباً.</p>
    <a href="{{ route('dashboard') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        <i class="fas fa-arrow-right ml-2"></i> العودة للرئيسية
    </a>
</div>
@endsection
