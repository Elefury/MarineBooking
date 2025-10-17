<?php
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->js('window.location.href = "'.route('verification.notice').'"');
    }
};
?>


<div>
    <form wire:submit.prevent="register" novalidate>
        <!-- Уникальный заголовок -->
        <div class="text-center mb-6 mt-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Регистрация</h2>
            <p class="text-gray-600">Создайте свой аккаунт и присоединяйтесь к морскому приключению!</p>
        </div>

        <div>
            <x-input-label for="name" :value="__('Фамилия Имя')" />
            <x-text-input wire:model.blur="name" id="name" 
                         class="block mt-1 w-full" 
                         type="text" 
                         required 
                         autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Электронная почта')" />
            <x-text-input wire:model.blur="email" id="email" 
                         class="block mt-1 w-full" 
                         type="email"
                         required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Пароль')" />
            <x-text-input wire:model.blur="password" id="password"
                         class="block mt-1 w-full"
                         type="password"
                         required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Подтвердите пароль')" />
            <x-text-input wire:model.blur="password_confirmation" 
                         id="password_confirmation"
                         class="block mt-1 w-full"
                         type="password"
                         required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button type="submit" class="w-full justify-center mt-6 py-3 bg-blue-600 hover:bg-blue-700">
            {{ __('Зарегистрироваться') }}
        </x-primary-button>

        <div class="text-center pt-2">
            <p class="text-sm text-gray-600">
                {{ __('Уже есть аккаунт?') }}
                <a href="{{ route('login') }}" 
                   class="font-medium text-blue-600 hover:text-blue-500 ml-1"
                   wire:navigate>
                    {{ __('Авторизуйтесь!') }}
                </a>
            </p>
        </div>
    </form>
</div>