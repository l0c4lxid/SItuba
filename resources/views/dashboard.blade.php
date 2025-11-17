<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php($user = auth()->user())
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-4">
                    <p class="text-lg font-semibold">Selamat datang, {{ $user->name }}</p>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Peran</p>
                            <p class="font-medium">{{ $user->role->label() }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Status Akun</p>
                            <p class="font-medium">
                                {{ $user->is_active ? 'Aktif' : 'Tidak aktif' }}
                            </p>
                        </div>
                    </div>

                    @if ($user->detail)
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4 space-y-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Kontak</p>
                            <p>
                                <span class="font-semibold">NIK:</span>
                                {{ $user->detail->nik ?? '-' }}
                            </p>
                            <p>
                                <span class="font-semibold">Telepon:</span>
                                {{ $user->detail->phone ?? '-' }}
                            </p>
                            <p>
                                <span class="font-semibold">Alamat:</span>
                                {{ $user->detail->address ?? '-' }}
                            </p>
                            <p>
                                <span class="font-semibold">Instansi:</span>
                                {{ $user->detail->organization ?? '-' }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
