<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-white tracking-wide">Selamat Datang Kembali</h2>
        <p class="text-xs text-gray-400 mt-1">Silakan masuk ke portal manajemen BMEX</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-semibold text-xs text-amber-300 uppercase tracking-wider mb-2">
                {{ __('Email Address') }}
            </label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus 
                   autocomplete="username"
                   placeholder="admin@bmex.com"
                   class="w-full px-4 py-2.5 bg-[#050B2E] border border-amber-500/30 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 transition text-sm">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block font-semibold text-xs text-amber-300 uppercase tracking-wider mb-2">
                {{ __('Password') }}
            </label>
            <input id="password" 
                   type="password" 
                   name="password" 
                   required 
                   autocomplete="current-password"
                   placeholder="••••••••"
                   class="w-full px-4 py-2.5 bg-[#050B2E] border border-amber-500/30 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-amber-400 focus:ring-1 focus:ring-amber-400 transition text-sm">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-xs" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between text-xs">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" 
                       type="checkbox" 
                       class="rounded bg-[#050B2E] border-amber-500/40 text-amber-500 focus:ring-amber-400 focus:ring-offset-0" 
                       name="remember">
                <span class="ms-2 text-gray-300">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-amber-400/80 hover:text-amber-400 hover:underline transition" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-[#050B2E] font-black rounded-xl shadow-lg shadow-amber-500/10 hover:shadow-amber-500/20 transition duration-200 active:scale-[0.99] uppercase tracking-wider text-sm flex items-center justify-center gap-2">
                <span>{{ __('Log in') }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </div>
    </form>
</x-guest-layout>