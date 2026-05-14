<x-guest-layout>
    <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Selamat Datang Kembali</h2>
        <p class="text-sm text-gray-500 mt-1">Silakan masuk ke akun Anda</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" value="Alamat Email" class="font-semibold text-gray-700" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Kata Sandi" class="font-semibold text-gray-700" />
            <x-text-input id="password" class="block mt-1 w-full rounded-xl border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 transition duration-200" name="remember">
                <span class="text-gray-600 select-none">Ingat saya</span>
            </label>
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 transform hover:-translate-y-0.5">
                Log in
            </button>
        </div>

        @if (Route::has('register'))
            <p class="text-center text-sm text-gray-600 mt-4">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 hover:underline font-semibold transition duration-150">
                    Daftar Sekarang
                </a>
            </p>
        @endif
    </form>
</x-guest-layout>