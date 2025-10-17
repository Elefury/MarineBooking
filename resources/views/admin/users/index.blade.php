<x-app-layout>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Менеджмент пользователей</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if($users->count())
            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="px-4 py-2 text-left">Имя</th>
                            <th class="px-4 py-2 text-left">Электронная почта</th>
                            <th class="px-4 py-2 text-left">Роль</th>
                            <th class="px-4 py-2 text-left">Действия</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm">
                        @foreach($users as $user)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="px-4 py-2">{{ $user->name }}</td>
                                <td class="px-4 py-2">{{ $user->email }}</td>
                                <td class="px-4 py-2">
                                    <span class="{{ $user->is_admin ? 'bg-blue-200 text-blue-800' : 'bg-gray-200 text-gray-800' }} px-2 py-1 rounded-full text-xs">
                                        {{ $user->is_admin ? 'Администратор' : 'Пользователь' }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 flex gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                        Изменить
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                            onclick="return confirm('Вы уверены, что хотите удалить данного пользователя?')">
                                            Удалить
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        @else
            <div class="bg-white p-4 rounded shadow">
                <p class="text-gray-500">Пользователей не найдено</p>
            </div>
        @endif
    </div>
</x-app-layout>