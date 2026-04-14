@section('title', 'Reset Password')
<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <span class="text-center font-bold text-[20px] max-sm:text-[18px] text-primary">Reset Password</span>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('New Password')" />
            <x-text-input id="password" class="block mt-1 w-full text-[15px] h-[35px]" type="password" name="password"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full text-[15px] h-[35px]" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6 max-sm:text-[13px]">
            <a href="{{ route('login') }}" class="text-sm text-primary hover:text-secondary duration-200 mr-4">
                {{ __('Back to Login') }}
            </a>
            <x-primary-button type="submit">
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>