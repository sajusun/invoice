@auth
<x-dashboard-layout>
    <x-slot name="title">Invoice Builder - {{ Auth::user()->settings?->company_name ?? 'Invozen' }}</x-slot>
    <x-slot name="meta">
        <script src="{{ asset('/js/classes.js') }}"></script>
        <script src="{{ asset('/js/global-var.js') }}"></script>
        @vite(['resources/js/builder.js'])
    </x-slot>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto">
        <div id="app">
            <invoice-builder></invoice-builder>
        </div>
    </div>
</x-dashboard-layout>
@else
<x-app-layout>
    <x-slot name="title">Create Invoice - Invozen</x-slot>
    <x-slot name="meta">
        <script src="{{ asset('/js/classes.js') }}"></script>
        <script src="{{ asset('/js/global-var.js') }}"></script>
        @vite(['resources/js/builder.js'])
    </x-slot>

    <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto">
        <div id="app">
            <invoice-builder></invoice-builder>
        </div>
    </div>
</x-app-layout>
@endauth


