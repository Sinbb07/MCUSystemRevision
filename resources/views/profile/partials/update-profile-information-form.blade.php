<section>
    <header>
        <h2 class="text-lg font-medium text-primary">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6 w-full">
        @csrf
        @method('patch')
        <div>
            <div class="flex mt-3">
                <img id="profile-img" src="{{ asset('/images/profile-black.png') }}" alt="Profile Picture"
                    class="w-[100px] max-md:w-[85px] h-[100px] max-md:h-[85px] rounded-full object-cover">
                <!-- Upload Button -->
                <div class="my-auto mx-4">
                    <div>
                        <label for="file-upload"
                            class="cursor-pointer inline-block bg-secondary hover:bg-primary text-primary hover:text-secondary tracking-widest py-2 px-3 rounded-md duration-200">
                            CHANGE PHOTO
                        </label>
                        <input type="file" id="file-upload" accept="image/*" class="hidden">
                    </div>
                    <div class="text-sm text-primary">
                        JPG or PNG (Max 2MB per file)
                    </div>
                </div>
            </div>
        </div>
        <div class="relative mt-6 w-full">
            <x-text-input id="name" name="name" type="text" required placeholder="" autocomplete="name"
                class="peer w-full h-[40px] bg-transparent rounded focus:ring-0 outline-none text-sm" />
            <label for="name"
                class="px-2 absolute left-1 top-[9px] text-darkergray text-sm transition-all duration-300 peer-focus:-top-2 peer-focus:text-xs peer-focus:text-primary peer-valid:-top-2 peer-valid:text-xs peer-valid:text-primary bg-white">
                Name
            </label>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        <div class="relative mt-6 w-full">
            <x-text-input id="email" name="email" type="email" required placeholder=""
                class="peer w-full h-[40px] bg-transparent rounded focus:ring-0 outline-none text-sm"
                autocomplete="email" />
            <label for="email"
                class="px-2 absolute left-1 top-[9px] text-darkergray text-sm transition-all duration-300 peer-focus:-top-2 peer-focus:text-xs peer-focus:text-primary peer-valid:-top-2 peer-valid:text-xs peer-valid:text-primary bg-white">
                Email
            </label>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>
        <div>
            <p class="text-sm mt-2">
                {{ __('Your email address is unverified.') }}

                <button form="send-verification"
                    class="underline text-left text-sm text-primary hover:text-orangeyellow duration-200 rounded-md">
                    {{ __('Click here to re-send the verification email.') }}
                </button>
            </p>

            @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
<script>
    const imgDiv = document.querySelector('.user-img');
    const img = document.querySelector('#photo');
    const file = document.querySelector('#file');
    const uploadBtn = document.querySelector('#uploadBtn');

    file.addEventListener('change', function () {
        const chosenFile = this.files[0];
        if (chosenFile) {
            const reader = new FileReader();

            reader.addEventListener('load', function () {
                img.setAttribute('src', reader.result);
            })
            reader.readAsDataURL(chosenFile);
        }
    })
</script>