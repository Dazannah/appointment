<x-app-layout>
    <x-slot:pageTitle>{{'Welcome'}}</x-slot>
    <div class="w-full sm:max-w-md bg-gray-900 dark:bg-gray-900 overflow-hidden m-auto mt-10">
        <div class="flex flex-col justify-center items-center pt-6 sm:pt-0 bg-white dark:bg-gray-900 p-2">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-gray-100 dark:bg-gray-800 overflow-hidden sm:rounded-lg">                
                <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                </div>
            
                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf
            
                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
            
                        <x-text-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password" />
            
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
            
                    <div class="flex justify-end mt-4">
                        <x-primary-button>
                            {{ __('Confirm') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
