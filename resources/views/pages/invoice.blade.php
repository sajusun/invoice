<x-applayout>
    <x-slot name="meta">
        <script src="{{asset('/js/classes.js')}}"></script>
        <script src="{{asset('/js/global-var.js')}}"></script>
{{--        <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>--}}
        @vite('resources/js/builder.js')
    </x-slot>
<div class="px-0 py-0.5 md:p-1">
    @auth()
{{--        @include('custom-layouts.invoice')--}}
        @include('pages.invoice.builder')
    @else
        @include('custom-layouts.guest_invoice')
    @endauth
</div>

</x-applayout>

