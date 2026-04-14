<section>
    <header>
        <h2 class="text-lg font-medium text-primary">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')
        <div class="relative mt-6 w-full">
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                required placeholder="" autocomplete="current-password"
                class="peer w-full h-[40px] bg-transparent rounded focus:ring-0 outline-none text-sm" />
            <label for="update_password_current_password"
                class="px-2 absolute left-1 top-[9px] text-darkergray text-sm transition-all duration-300 peer-focus:-top-2 peer-focus:text-xs peer-focus:text-primary peer-valid:-top-2 peer-valid:text-xs peer-valid:text-primary bg-white">
                Current Password
            </label>
            <x-input-error class="mt-2" :messages="$errors->updatePassword->get('current_password')" />
        </div>

        <div class="relative mt-6 w-full">
            <x-text-input id="update_password_password" name="password" type="password" required
                placeholder="" autocomplete="new-password"
                class="peer w-full h-[40px] bg-transparent rounded focus:ring-0 outline-none text-sm" />
            <label for="update_password_password"
                class="px-2 absolute left-1 top-[9px] text-darkergray text-sm transition-all duration-300 peer-focus:-top-2 peer-focus:text-xs peer-focus:text-primary peer-valid:-top-2 peer-valid:text-xs peer-valid:text-primary bg-white">
                New Password
            </label>
            <x-input-error class="mt-2" :messages="$errors->updatePassword->get('password')"/>
        </div>

        <div class="relative mt-6 w-full">
            <x-text-input id="update_password_current_password" name="password_confirmation" type="password"
                required placeholder="" autocomplete="name"
                class="peer w-full h-[40px] bg-transparent rounded focus:ring-0 outline-none text-sm" />
            <label for="update_password_password_confirmation"
                class="px-2 absolute left-1 top-[9px] text-darkergray text-sm transition-all duration-300 peer-focus:-top-2 peer-focus:text-xs peer-focus:text-primary peer-valid:-top-2 peer-valid:text-xs peer-valid:text-primary bg-white">
                Confirm New Password
            </label>
            <x-input-error class="mt-2" :messages="$errors->updatePassword->get('password_confirmation')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>