<x-app-layout>
    <x-slot:pageTitle>{{'Welcome'}}</x-slot>
    <div class="w-full sm:max-w-md bg-gray-900 dark:bg-gray-900 overflow-hidden m-auto mt-10">
        <div class="flex flex-col justify-center items-center pt-6 sm:pt-0 bg-white dark:bg-gray-900 p-2">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-gray-100 dark:bg-gray-800 overflow-hidden sm:rounded-lg">                
                <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>
            
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />
            
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
            
                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
            
                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button>
                            {{ __('Email Password Reset Link') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
