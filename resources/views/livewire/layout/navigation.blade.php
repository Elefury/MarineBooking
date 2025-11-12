
<?php
use Livewire\Volt\Component;

new class extends Component {
    public function logout(): void
    {
        auth()->guard('web')->logout();

        session()->invalidate();
        session()->regenerateToken();

        session()->flush();

        $this->redirect('/', navigate: false);
    }
};
?>

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">

                <div class="shrink-0 flex items-center">
                    <a href="/" wire:navigate>
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Главная') }}
                    </x-nav-link>

                    <x-nav-link :href="route('cruises.index')" :active="request()->routeIs('cruises.index')" wire:navigate>
                        {{ __('Круизы') }}
                    </x-nav-link>

                     <x-nav-link :href="route('voyages.index')" :active="request()->routeIs('voyages.index')" wire:navigate>
                        {{ __('Рейсы') }}
                    </x-nav-link>

                    <x-nav-link :href="route('about')" :active="request()->routeIs('about')" wire:navigate>
                        {{ __('О нас') }}
                    </x-nav-link>

                    <x-nav-link :href="route('faq.index')" :active="request()->routeIs('faq.index')" wire:navigate>
                        {{ __('FAQ') }}
                    </x-nav-link>

                     <x-nav-link :href="route('reviews.index')" :active="request()->routeIs('reviews.*')" wire:navigate>
                        {{ __('Отзывы') }}
                    </x-nav-link>


                </div>
            </div>



            <div class="hidden sm:flex sm:items-center sm:ms-6">

                <x-dropdown-link :href="route('profile')" wire:navigate>
                <div class="shrink-0">
                    <img
                        src="{{ asset('images/default_avatar.jpg') }}"
                        alt="User avatar"
                        class="h-8 w-8 rounded-full object-cover border border-gray-200"
                    >
                </div>
                </x-dropdown-link>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            @auth
                                <div x-data="{ name: '{{ auth()->user()->name }}' }"
                                     x-text="name"
                                     x-on:profile-updated.window="name = $event.detail.name">
                                </div>
                            @else
                                <span>Guest</span>
                            @endauth
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                    @if(auth()->check() && auth()->user()->is_admin)
                        <x-dropdown-link :href="route('admin.dashboard')" wire:navigate>
                            {{ __('Админ. панель') }}
                        </x-dropdown-link>
                    @endif


                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Профиль') }}
                        </x-dropdown-link>



                        <form method="POST" action="{{ route('logout') }}" wire:ignore>
                            @csrf
                            <button type="submit" class="w-full text-start">
                                <x-dropdown-link>
                                    {{ __('Выйти из аккаунта') }}
                                </x-dropdown-link>
                            </button>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Главная') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('cruises.index')" :active="request()->routeIs('cruises.index')" wire:navigate>
                {{ __('Круизы') }}
            </x-responsive-nav-link>

             <x-responsive-nav-link :href="route('voyages.index')" :active="request()->routeIs('voyages.index')" wire:navigate>
            {{ __('Рейсы') }}
            </x-responsive-nav-link>



            <x-responsive-nav-link :href="route('about')" :active="request()->routeIs('about')" wire:navigate>
                {{ __('О компании') }}
            </x-responsive-nav-link>


            <x-responsive-nav-link :href="route('faq.index')" :active="request()->routeIs('faq.index')" wire:navigate>
                {{ __('FAQ') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('reviews.index')" :active="request()->routeIs('reviews.*')" wire:navigate>
                {{ __('Отзывы') }}
            </x-responsive-nav-link>

        </div>


        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">

                <div class="shrink-0 mr-3">
                    <img
                        src="{{ asset('images/default_avatar.jpg') }}"
                        alt="User avatar"
                        class="h-10 w-10 rounded-full object-cover border border-gray-200"
                    >
                </div>

            <div class="px-4">
                @auth
                    <div class="font-medium text-base text-gray-800"
                         x-data="{ name: '{{ auth()->user()->name }}' }"
                         x-text="name"
                         x-on:profile-updated.window="name = $event.detail.name">
                    </div>
                    <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
                @else
                    <div class="font-medium text-base text-gray-800">Guest</div>
                @endauth
            </div>
            </div>

            <div class="mt-3 space-y-1">
                @if(auth()->check() && auth()->user()->is_admin)
                    <x-responsive-nav-link :href="route('admin.dashboard')" wire:navigate>
                        {{ __('Админ. панель') }}
                    </x-responsive-nav-link>
                @endif
                    <x-responsive-nav-link :href="route('profile')" wire:navigate>
                        {{ __('Профиль') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}" wire:ignore>
                        @csrf
                        <button type="submit" class="w-full text-start">
                            <x-responsive-nav-link>
                                {{ __('Выйти из аккаунта') }}
                            </x-responsive-nav-link>
                        </button>
                    </form>


            </div>
        </div>
    </div>
</nav>

