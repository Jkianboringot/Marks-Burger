<!-- resources/views/admin.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Filament Admin
        </h2>
    </x-slot>

    <div class="p-6 bg-white border-b border-gray-200">
        <iframe src="{{ url('/admin') }}" style="width:100%; height:80vh; border:none;"></iframe>
    </div>
</x-app-layout>
