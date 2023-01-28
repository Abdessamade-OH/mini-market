<x-app-layout>
    {{-- 
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>
         --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @switch($type)
                    @case('products')
                        <livewire:products/> 
                        @break
                    @case('categories')
                        <livewire:categories/> 
                        @break
                    @case('clients')
                        <livewire:clients/> 
                        @break
                    @case('commands')
                        <livewire:commands/> 
                        @break
                    @default
                        
                @endswitch
            </div>
        </div>
    </div>
</x-app-layout>