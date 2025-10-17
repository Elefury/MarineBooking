<x-app-layout>
    <div class="relative h-screen bg-cover bg-center bg-no-repeat bg-fixed" 
         style="background-image: url('/images/welcome-bg.jpg')">
        <div class="absolute inset-0 bg-black/50 flex items-center">
            <div class="container mx-auto px-6 text-center text-white">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Откройте для себя морские приключения
                </h1>
                <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto">
                    Незабываемые круизы и комфортные рейсы на современных судах
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('cruises.index') }}" 
                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-full text-lg transition-all transform hover:scale-105">
                        Круизы
                    </a>
                    <a href="{{ route('voyages.index') }}" 
                       class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full text-lg transition-all transform hover:scale-105">
                        Рейсы
                    </a>
                </div>
            </div>
        </div>
        
        <div class="absolute bottom-10 left-0 right-0 flex justify-center mb-12">
            <div class="animate-bounce w-12 h-12 rounded-full bg-white bg-opacity-60 flex items-center justify-center">
                <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </div>
        </div>
    </div>

    <section class="py-16 bg-gradient-to-r from-blue-900 to-blue-700 text-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12">Наши преимущества</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($advantages as $advantage)
                <div class="p-6 text-center">
                    <div class="text-5xl mb-4">
                        {!! $advantage['icon'] !!}
                    </div>
                    <h3 class="text-xl font-bold mb-2">{{ $advantage['title'] }}</h3>
                    <p class="text-gray-300">{{ $advantage['description'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12">Рекомендуемые круизы</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($featuredCruises as $cruise)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                    <div class="relative h-48 bg-gray-200 overflow-hidden">
                        <img src="{{ $cruise->image_url ?? '/images/default-cruise.jpg' }}" 
                             alt="{{ $cruise->name }}" 
                             class="w-full h-full object-cover"
                             onerror="this.src='data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22800%22%20height%3D%22600%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20800%20600%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_18945cb716a%20text%20%7B%20fill%3A%23AAAAAA%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A40pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_18945cb716a%22%3E%3Crect%20width%3D%22800%22%20height%3D%22600%22%20fill%3D%22%23EEEEEE%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2250%25%22%20y%3D%2250%25%22%20dominant-baseline%3D%22middle%22%20text-anchor%3D%22middle%22%3ECruise%20Image%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E'">
                        <div class="absolute top-3 left-3 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded">
                            {{ $cruise->available_seats }} мест
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">{{ $cruise->name }}</h3>
                        <div class="flex items-center text-gray-600 mb-3">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $cruise->meeting_point }}
                        </div>
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <span class="text-2xl font-bold text-blue-600">${{ number_format($cruise->price_per_seat, 2) }}</span>
                                <span class="text-sm text-gray-500">/место</span>
                            </div>
                            <div class="text-sm">
                                {{ $cruise->departure_time->format('d M Y') }}
                            </div>
                        </div>
                        <a href="{{ route('cruises.show', $cruise) }}" 
                           class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg transition-colors">
                            Подробнее о круизе
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="text-center mt-10">
                <a href="{{ route('cruises.index') }}" 
                   class="inline-block border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white font-bold py-2 px-6 rounded-full transition-colors">
                    Все круизы
                </a>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-12">Популярные рейсы</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($featuredVoyages as $voyage)
                <div class="bg-gray-50 rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">
                            {{ $voyage->departurePort->city }} → {{ $voyage->arrivalPort->city }}
                        </h3>
                        <div class="flex items-center text-gray-600 mb-3">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ $voyage->departure_time->format('d M Y, H:i') }}
                        </div>
                        <div class="flex items-center text-gray-600 mb-4">
                            <svg class="w-4 h-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21l18 0M5 21l2-16h10l2 16"></path>
                            </svg>
                            {{ $voyage->vessel->name }} ({{ $voyage->vessel->type }})
                        </div>
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <span class="text-2xl font-bold text-green-600">${{ number_format($voyage->price_per_seat, 2) }}</span>
                                <span class="text-sm text-gray-500">/место</span>
                            </div>
                            <div class="text-sm bg-green-100 text-green-800 px-2 py-1 rounded">
                                {{ $voyage->available_seats }} мест
                            </div>
                        </div>
                        <a href="{{ route('voyages.show', $voyage) }}" 
                           class="block w-full bg-green-600 hover:bg-green-700 text-white text-center py-2 px-4 rounded-lg transition-colors">
                            Подробнее о рейсе
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="text-center mt-10">
                <a href="{{ route('voyages.index') }}" 
                   class="inline-block border-2 border-green-600 text-green-600 hover:bg-green-600 hover:text-white font-bold py-2 px-6 rounded-full transition-colors">
                    Все рейсы
                </a>
            </div>
        </div>
    </section>

    <section class="py-20 bg-cover bg-center" style="background-image: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('/images/cta-bg.jpg')">
        <div class="container mx-auto px-6 text-center text-white">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Готовы к путешествию?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">
                Присоединяйтесь к тысячам довольных пассажиров, которые уже оценили наш сервис!
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('cruises.index') }}" 
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-full text-lg transition-all">
                    Круизы
                </a>
                <a href="{{ route('voyages.index') }}" 
                   class="inline-block bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full text-lg transition-all">
                    Рейсы
                </a>
                <!-- <a href="#" 
                   class="inline-block border-2 border-white hover:bg-white hover:text-black text-white font-bold py-3 px-8 rounded-full text-lg transition-all">
                    Контакты
                </a> -->
            </div>
            <p class="text-xl mt-8 max-w-2xl mx-auto">
                Телефон: +7-098-765-43-21
            </p>
            <p>
                Адрес: г. Москва, ул. Примерная, д. 10
            </p>
        </div>
    </section>
</x-app-layout>