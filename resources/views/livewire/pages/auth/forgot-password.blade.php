<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status !== Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));
            return;
        }

        session()->flash('status', __($status));
        $this->reset('email'); 
    }
}; ?>

<div>
    <div class="mb-4 mt-4 text-sm text-gray-600">
        {{ __('Если вы забыли пароль, мы без проблем вам его восстановим. Просто введите электронную почту, которую вы регистрировали, и мы отправим на неё ссылку для восстановления.') }}
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink">
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <a href="{{ route('login') }}" 
               class="underline text-sm text-gray-600 hover:text-gray-900"
               wire:navigate>
                {{ __('Отмена') }}
            </a>
            
            <x-primary-button>
                {{ __('Отправить ссылку') }}
            </x-primary-button>
        </div>
    </form>
</div>
