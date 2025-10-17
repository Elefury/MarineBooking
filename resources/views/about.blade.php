<x-app-layout>
    <div class="relative bg-blue-900 overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-blue-900 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <div class="pt-10 sm:pt-16 lg:pt-8 lg:pb-14 lg:overflow-hidden">
                    <div class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                        <div class="sm:text-center lg:text-left">
                            <h1 class="text-4xl tracking-tight font-semibold text-white sm:text-5xl md:text-6xl">
                                <span class="block">Marine Booking</span>
                                <span class="block text-blue-200">Ваш надежный партнер</span>
                            </h1>
                            <p class="mt-3 text-base text-blue-100 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                                Мы предоставляем лучшие услуги водного транспорта для тысяч довольных клиентов.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" 
                 src="images/nophoto.png" 
                 alt="">
        </div>
    </div>

    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base text-blue-600 font-semibold tracking-wide uppercase">О компании</h2>
                <p class="mt-2 text-3xl leading-8 font-semibold tracking-tight text-gray-900 sm:text-4xl">
                    Наша история
                </p>
            </div>

            <div class="mt-10">
                <div class="prose prose-lg text-gray-500 mx-auto">
                    <p>
                        Основанная в 2020 году, компания Marine Booking начала свою деятельность с небольшого флота 
                        из 3 судов. Сегодня мы располагаем более 50-ью современными судами различных классов.
                    </p>
                    <p>
                        Наша миссия - предоставлять клиентам незабываемые впечатления от путешествий по воде, 
                        сочетая комфорт, безопасность и превосходный сервис.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-blue-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-8">Наши достижения</h2>
            
            <div class="glide">
                <div class="glide__track" data-glide-el="track">
                    <ul class="glide__slides">
                        <li class="glide__slide">
                            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                                <div class="text-blue-600 text-5xl font-bold mb-2">10+</div>
                                <h3 class="text-xl font-semibold text-gray-800">Лет на рынке</h3>
                            </div>
                        </li>
                        <li class="glide__slide">
                            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                                <div class="text-blue-600 text-5xl font-bold mb-2">50+</div>
                                <h3 class="text-xl font-semibold text-gray-800">Судов в парке</h3>
                            </div>
                        </li>
                        <li class="glide__slide">
                            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                                <div class="text-blue-600 text-5xl font-bold mb-2">10K+</div>
                                <h3 class="text-xl font-semibold text-gray-800">Довольных клиентов</h3>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- <div class="glide__arrows" data-glide-el="controls">
                    <button class="glide__arrow glide__arrow--left" data-glide-dir="<">←</button>
                    <button class="glide__arrow glide__arrow--right" data-glide-dir=">">→</button>
                </div> -->
            </div>
        </div>
    </div>

    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-8">Наша команда</h2>
            
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach([
                    ['name' => 'Алексей Петров', 'position' => 'CEO', 'photo' => 'https://randomuser.me/api/portraits/men/32.jpg'],
                    ['name' => 'Мария Иванова', 'position' => 'Менеджер по клиентам', 'photo' => 'https://randomuser.me/api/portraits/women/44.jpg'],
                    ['name' => 'Дмитрий Смирнов', 'position' => 'Капитан флота', 'photo' => 'https://randomuser.me/api/portraits/men/75.jpg']
                ] as $member)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img class="w-full h-48 object-cover" src="{{ $member['photo'] }}" alt="{{ $member['name'] }}">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800">{{ $member['name'] }}</h3>
                        <p class="text-blue-600">{{ $member['position'] }}</p>
                        <p class="mt-2 text-gray-600">
                            @if($member['position'] == 'CEO')
                            Основатель компании с 8-летним опытом в индустрии.
                            @elseif($member['position'] == 'Менеджер по клиентам')
                            Всегда на связи с клиентами, решает любые вопросы.
                            @else
                            Опытный капитан с 15-летним стажем.
                            @endif
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-blue-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-center mb-8">Отзывы клиентов</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach([
                    ['name' => 'Иван К.', 'text' => 'Отличный сервис! Круиз превзошел все ожидания. Обязательно вернемся всей семьей за подобными впечатлениями!', 'rating' => 5],
                    ['name' => 'Елена С.', 'text' => 'Прекрасная организация, внимательный персонал. Рекомендую!', 'rating' => 5]

                ] as $review)
                <div class="bg-blue-800 p-6 rounded-lg">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 mr-2">
                            @for($i = 1; $i <= 5; $i++)
                                {{ $i <= $review['rating'] ? '★' : '☆' }}
                            @endfor
                        </div>
                        <h3 class="text-xl font-semibold">{{ $review['name'] }}</h3>
                    </div>
                    <p class="text-blue-100">{{ $review['text'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Теперь вы готовы к путешествию!</h2>
            <p class="text-xl text-gray-600 mb-8">Выберите круиз или рейс, который вам по душе</p>
            <a href="{{ route('cruises.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition duration-150">
                Посмотреть предложения
            </a>
        </div>
    </div>

    @push('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.5.0/css/glide.core.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.5.0/glide.min.js"></script>
    <script>
        new Glide('.glide', {
            type: 'carousel',
            perView: 3,
            breakpoints: {
                1024: { perView: 2 },
                768: { perView: 1 }
            }
        }).mount();
    </script>
    @endpush
</x-app-layout>