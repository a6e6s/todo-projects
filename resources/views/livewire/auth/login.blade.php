<x-layouts.auth>
    <div class="space-y-6">
        <div class="text-center">
            <h2 class="text-xl font-semibold text-white mb-2">{{ __('Welcome back') }}</h2>
            <p class="text-slate-400 text-sm">{{ __('Enter your credentials to continue') }}</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div>
                <label class="block text-sm font-medium text-slate-400 mb-2">{{ __('Email address') }}</label>
                <input
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="email@example.com"
                    class="w-full px-4 py-3 bg-[#101a22] border border-[#283239] rounded-lg text-white placeholder-slate-500 focus:border-[#1392ec] focus:ring-1 focus:ring-[#1392ec] transition-colors"
                />
                @error('email')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-sm font-medium text-slate-400">{{ __('Password') }}</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-[#1392ec] hover:text-blue-400 transition-colors">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>
                <input
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="{{ __('Password') }}"
                    class="w-full px-4 py-3 bg-[#101a22] border border-[#283239] rounded-lg text-white placeholder-slate-500 focus:border-[#1392ec] focus:ring-1 focus:ring-[#1392ec] transition-colors"
                />
                @error('password')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input
                    id="remember"
                    name="remember"
                    type="checkbox"
                    {{ old('remember') ? 'checked' : '' }}
                    class="size-4 text-[#1392ec] bg-[#101a22] border-[#283239] rounded focus:ring-[#1392ec] focus:ring-2"
                />
                <label for="remember" class="ml-2 text-sm text-slate-400">{{ __('Remember me') }}</label>
            </div>

            <button
                type="submit"
                class="w-full px-6 py-3 bg-[#1392ec] hover:bg-blue-600 text-white font-medium rounded-lg transition-colors shadow-lg shadow-blue-500/20"
            >
                {{ __('Log in') }}
            </button>
        </form>

        @if (Route::has('register'))
            <div class="text-center text-sm text-slate-400">
                <span>{{ __('Don\'t have an account?') }}</span>
                <a href="{{ route('register') }}" class="text-[#1392ec] hover:text-blue-400 transition-colors ml-1">
                    {{ __('Sign up') }}
                </a>
            </div>
        @endif
    </div>
</x-layouts.auth>
