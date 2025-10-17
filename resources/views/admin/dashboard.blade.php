
<x-app-layout>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 p-6">
        
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-bold">Общая выручка</h3>
            <p class="text-2xl">${{ number_format($metrics['revenue'], 2) }}</p>
        </div>
        
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-bold">% занятости мест</h3>
            <p class="text-2xl">{{ number_format($metrics['occupancy'], 1) }}%</p>
        </div>
        
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-bold">Самый популярный</h3>
            <p class="text-xl">{{ $metrics['popular']->name ?? 'N/A' }}</p>
        </div>
        
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-bold">Быстрые действия</h3>
            <div class="mt-4 space-y-2">
                <a href="{{ route('admin.cruises.create') }}" class="block btn btn-primary">
                    Add New Cruise
                </a>
                <a href="{{ route('admin.users.index') }}" class="block btn btn-primary">
                    Manage Users
                </a>
            </div>
        </div>
    </div>
</x-app-layout>