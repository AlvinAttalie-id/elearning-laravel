<x-guest-layout>
    <div
        class="flex items-center justify-center min-h-screen px-4 py-12 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 sm:px-6 lg:px-8">
        <div class="w-full max-w-md p-10 space-y-8 shadow-xl bg-white/80 backdrop-blur-lg rounded-2xl">
            <div class="flex flex-col items-center">
                <a href="{{ url('/') }}" class="text-3xl font-extrabold tracking-wide text-indigo-600">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <h2 class="mt-6 text-2xl font-bold text-center text-gray-900">
                    {{ __('Sign in to your account') }}
                </h2>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="-space-y-px rounded-md shadow-sm">
                    <!-- Email Address -->
                    <div>
                        <label for="email" class="sr-only">{{ __('Email') }}</label>
                        <input id="email" name="email" type="email" autocomplete="email" required autofocus
                            class="relative block w-full px-3 py-3 text-gray-900 placeholder-gray-500 border border-gray-300 appearance-none rounded-t-md focus:z-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="{{ __('Email address') }}" value="{{ old('email') }}" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <label for="password" class="sr-only">{{ __('Password') }}</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="relative block w-full px-3 py-3 text-gray-900 placeholder-gray-500 border border-gray-300 appearance-none rounded-b-md focus:z-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            placeholder="{{ __('Password') }}" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox"
                            class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <label for="remember_me" class="block ml-2 text-sm text-gray-900">
                            {{ __('Remember me') }}
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}"
                                class="font-medium text-indigo-600 hover:text-indigo-500">
                                {{ __('Forgot your password?') }}
                            </a>
                        </div>
                    @endif
                </div>

                <div>
                    <button type="submit"
                        class="relative flex justify-center w-full px-4 py-3 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md group hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        {{ __('Log in') }}
                    </button>
                </div>

                <div class="text-sm text-center text-gray-600">
                    {{ __("Don't have an account?") }}
                    <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        {{ __('Register here') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
