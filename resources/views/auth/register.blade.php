<x-guest-layout>
    <div
        class="flex items-center justify-center min-h-screen px-4 py-12 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 sm:px-6 lg:px-8">
        <div class="w-full max-w-md p-10 space-y-8 shadow-xl bg-white/80 backdrop-blur-lg rounded-2xl">
            <div class="flex flex-col items-center">
                <a href="{{ url('/') }}" class="text-3xl font-extrabold tracking-wide text-indigo-600">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <h2 class="mt-6 text-2xl font-bold text-center text-gray-900">
                    {{ __('Create your account') }}
                </h2>
            </div>

            <form class="mt-8 space-y-6" method="POST" action="{{ route('register') }}">
                @csrf

                <div class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label for="name" class="sr-only">{{ __('Name') }}</label>
                        <input id="name" name="name" type="text" required autofocus autocomplete="name"
                            class="block w-full px-3 py-3 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="{{ __('Full name') }}" value="{{ old('name') }}" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="sr-only">{{ __('Email') }}</label>
                        <input id="email" name="email" type="email" autocomplete="username" required
                            class="block w-full px-3 py-3 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="{{ __('Email address') }}" value="{{ old('email') }}" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="sr-only">{{ __('Password') }}</label>
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                            class="block w-full px-3 py-3 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="{{ __('Password') }}" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="sr-only">{{ __('Confirm Password') }}</label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                            autocomplete="new-password" required
                            class="block w-full px-3 py-3 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-md appearance-none focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="{{ __('Confirm password') }}" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>
                    <button type="submit"
                        class="relative flex justify-center px-4 py-3 ml-3 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md group hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        {{ __('Register') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
