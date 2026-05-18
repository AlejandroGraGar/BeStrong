<x-layouts.auth :title="__('Login')">

    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">

        <div class="p-8">

            <div class="text-center mb-8">

                <div class="flex justify-center mb-4">
                    <img 
                        src="{{ asset('storage/logo.png') }}" 
                        alt="BeStrong Logo"
                        class="w-16 h-16 object-contain"
                    >
                </div>

                <h1 class="text-3xl font-black text-red-600">
                    BeStrong
                </h1>

                <p class="text-gray-500 dark:text-gray-400 mt-2">
                    Inicia sesión en tu cuenta
                </p>

            </div>

            <form method="POST" action="{{ route('login') }}">

                @csrf

                <div class="mb-4">
                    <x-forms.input 
                        label="Email" 
                        name="email" 
                        type="email" 
                        placeholder="your@email.com" 
                    />
                </div>

                <div class="mb-4">
                    <x-forms.input 
                        label="Password" 
                        name="password" 
                        type="password" 
                        placeholder="••••••••" 
                    />

                    <a href="{{ route('password.request') }}"
                        class="text-xs text-red-500 hover:text-red-600 hover:underline">
                        {{ __('Forgot password?') }}
                    </a>
                </div>

                <div class="mb-6">
                    <x-forms.checkbox 
                        label="Remember me" 
                        name="remember" 
                    />
                </div>

                <x-buttons.primary class="w-full bg-red-500 hover:bg-red-600 border-0">
                    {{ __('Sign In') }}
                </x-buttons.primary>

            </form>

            <div class="text-center mt-6">

                <p class="text-sm text-gray-600 dark:text-gray-400">

                    {{ __('Don\'t have an account?') }}

                    <a href="{{ route('register') }}"
                        class="text-red-500 hover:text-red-600 hover:underline font-semibold">

                        {{ __('Sign up') }}

                    </a>

                </p>

            </div>

        </div>

    </div>

</x-layouts.auth>