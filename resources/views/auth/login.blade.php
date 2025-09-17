<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm">{{ __('Remember me') }}</span>
                </label>
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a href="#" onclick="openModal(\'termsModal\')" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a href="#" onclick="openModal(\'privacyModal\')" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>

                <!-- Terms of Service Modal -->
                <div id="termsModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
                    <div class="bg-white rounded-lg shadow-lg max-w-3xl w-full p-6">
                        <h2 class="text-xl font-bold mb-4">{{ __('Terms of Service') }}</h2>
                        <div class="overflow-y-auto max-h-96">
                            <!-- Render Markdown file for Terms of Service -->
                            {!! \Illuminate\Support\Str::markdown(file_get_contents(resource_path('markdown/terms.md'))) !!}
                        </div>
                        <div class="flex justify-end mt-4">
                            <x-button onclick="closeModal('termsModal')">{{ __('Close') }}</x-button>
                        </div>
                    </div>
                </div>

                <!-- Privacy Policy Modal -->
                <div id="privacyModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center z-50">
                    <div class="bg-white rounded-lg shadow-lg max-w-3xl w-full p-6">
                        <h2 class="text-xl font-bold mb-4">{{ __('Privacy Policy') }}</h2>
                        <div class="overflow-y-auto max-h-96">
                            <!-- Render Markdown file for Privacy Policy -->
                            {!! \Illuminate\Support\Str::markdown(file_get_contents(resource_path('markdown/policy.md'))) !!}
                        </div>
                        <div class="flex justify-end mt-4">
                            <x-button onclick="closeModal('privacyModal')">{{ __('Close') }}</x-button>
                        </div>
                    </div>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>

        </form>
    </x-authentication-card>
</x-guest-layout>

<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
</script>

