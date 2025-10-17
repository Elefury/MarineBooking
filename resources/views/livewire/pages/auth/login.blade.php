<?php
use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();
        
        if (auth()->attempt([
            'email' => $this->form->email,
            'password' => $this->form->password
        ], $this->form->remember)) {
            request()->session()->regenerate();
            $this->js('window.location.href = "'.route('dashboard').'"');
        } else {
            $this->addError('form.email', __('auth.failed'));
        }
    }
};
?>


<div>
    <form wire:submit.prevent="login" class="space-y-4">
        <div class="text-center mb-6 mt-6 px-4"> 
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Авторизация</h2>
            <p class="text-gray-600">Войдите в аккаунт, чтобы продолжить морское приключение!</p>
        </div>

        <div>
            <x-input-label for="email" :value="__('Электронная почта')" />
            <x-text-input wire:model="form.email" id="email" 
                         class="block w-full mt-1"
                         type="email" 
                         required 
                         autofocus />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Пароль')" />
            <x-text-input wire:model="form.password" id="password"
                         class="block w-full mt-1"
                         type="password"
                         required />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label class="inline-flex items-center">
                <input wire:model="form.remember" type="checkbox" 
                       class="rounded border-gray-300 text-indigo-600 shadow-sm">
                <span class="ms-2 text-sm text-gray-600">{{ __('Запомнить меня') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm underline">
                    {{ __('Забыли пароль? Восстановим!') }}
                </a>
            @endif
        </div>

        <x-primary-button class="w-full justify-center mt-6 py-3 bg-blue-600 hover:bg-blue-700">
            {{ __('Войти') }}
        </x-primary-button>
    </form>
    @if (Route::has('register'))
    <div class="mt-2 text-center">
        <p class="text-sm text-gray-600">
            {{ __('Нет аккаунта?') }}
            <a href="{{ route('register') }}" 
               class="font-medium text-blue-600 hover:text-blue-500"
               wire:navigate>
                {{ __('Зарегистрируйте!') }}
            </a>
        </p>
    </div>
    @endif
</div>

    