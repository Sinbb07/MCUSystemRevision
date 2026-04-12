@section('title','Forgot Password')
<x-guest-layout>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <span class="font-bold text-[20px] text-primary">Forgot Password</span>
        <div class="mb-4 text-[15px] text-primary font-normal">
            {{ __('Enter your registered email address and we will send you an OTP to reset your password.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full text-[15px] h-[35px]" 
                         type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="mr-auto text-sm text-primary hover:text-secondary duration-200"
                href="{{ route('login') }}">
                {{ __('Back to Login') }}
            </a>

            <x-primary-button class="text-[15px]">
                {{ __('Send OTP') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>