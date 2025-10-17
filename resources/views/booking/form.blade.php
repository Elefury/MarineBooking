<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('booking-form', ['cruise' => $cruise])
        </div>
    </div>
</x-app-layout>