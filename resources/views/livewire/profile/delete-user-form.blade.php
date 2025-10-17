<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Удалить учётную запись') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Данное действие приведет к удалению аккаунта из нашего сервиса и всех данных, связанных с ним, без возможности возврата.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Удалить свою учётную запись') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-6">

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Вы уверены, что хотите удалить свой аккаунт?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Данное действие приведет к удалению аккаунта из нашего сервиса и всех данных, связанных с ним, без возможности возврата. Введите пароль от аккаунта, если вы уверены, что хотите удалить свой аккаунт навсегда.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    wire:model="password"
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Отменить') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Удалить свою учетную запись') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
