<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Akun Baru</h2>
        <p class="text-sm text-gray-500 mt-1">Lengkapi data diri Anda di bawah ini</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="id_anggota" value="ID Anggota / NIM" class="font-semibold text-gray-700" />
            <x-text-input id="id_anggota" class="block mt-1 w-full rounded-xl shadow-sm focus:ring-blue-500 transition duration-200" type="text" name="id_anggota" :value="old('id_anggota')" required autocomplete="id_anggota" />
            <x-input-error :messages="$errors->get('id_anggota')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="kontak" value="Nomor HP / Kontak" class="font-semibold text-gray-700" />
            <x-text-input id="kontak" class="block mt-1 w-full rounded-xl shadow-sm focus:ring-blue-500 transition duration-200" type="text" name="kontak" :value="old('kontak')" required autocomplete="kontak" />
            <x-input-error :messages="$errors->get('kontak')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="font-semibold text-gray-700" />
            <x-text-input id="name" class="block mt-1 w-full rounded-xl shadow-sm focus:ring-blue-500 transition duration-200" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="font-semibold text-gray-700" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl shadow-sm focus:ring-blue-500 transition duration-200" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Kata Sandi')" class="font-semibold text-gray-700" />
            <x-text-input id="password" class="block mt-1 w-full rounded-xl shadow-sm focus:ring-blue-500 transition duration-200" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="font-semibold text-gray-700" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-xl shadow-sm focus:ring-blue-500 transition duration-200" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4 flex flex-col gap-3">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 transform hover:-translate-y-0.5">
                Mendaftar
            </button>
            <a class="text-sm text-center text-gray-600 hover:text-blue-800 hover:underline font-semibold transition duration-150" href="{{ route('login') }}">
                Sudah punya akun? Log in di sini
            </a>
        </div>
    </form>
</x-guest-layout>