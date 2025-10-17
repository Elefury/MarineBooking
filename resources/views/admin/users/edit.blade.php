<x-app-layout>
    <div class="container mx-auto p-4">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div>
                    <label class="block text-gray-700">Имя пользователя</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-gray-700">Электронная почта</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="w-full p-2 border rounded" required>
                </div>
                <div class="flex gap-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Сохранить</button>
                    <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Отменить</a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>