<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Analytics Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold">Total Revenue</h3>
                <p class="text-2xl">${{ number_format($metrics['revenue'], 2) }}</p>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold">Average Occupancy</h3>
                <p class="text-2xl">{{ number_format($metrics['occupancy'], 1) }}%</p>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold">Most Popular Cruise</h3>
                <p class="text-xl">{{ $metrics['popular']->name ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded shadow">
            {!! $chart->container() !!}
            <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4"></script>
            {!! $chart->script() !!}
        </div>
    </div>
</x-app-layout>