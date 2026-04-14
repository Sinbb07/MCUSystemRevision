@section('title', 'Send OTP')
<x-guest-layout>
    <form method="POST" action="{{ route('password.otp.verify') }}" class="px-4">
        @csrf
        <div>
            <p class="text-center font-bold text-2xl max-sm:text-[18px] text-primary">Enter OTP</p>
            <p class="text-center text-primary text-[14px]">{{ __('The OTP has been sent to your email address.') }}</p>
        </div>

        <!-- Hidden email field -->
        <input type="hidden" name="email" value="{{ session('email') ?? old('email') }}">

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Email Display -->
        <div class="mb-4">
            <p class="text-primary text-sm">
                Sent to: <strong>{{ session('email') ?? old('email') }}</strong>
            </p>
        </div>

        <!-- OTP Input Boxes -->
        <div class="w-[200px] flex m-auto items-center justify-center flex-row gap-x-2 mt-4">
            <input type="text" maxlength="1" name="otp1"
                class="otp-input w-[45px] h-[55px] max-sm:w-[40px] max-sm:h-[50px] border-darkgray rounded-lg text-xl max-sm:text-lg text-center"
                required autofocus>
            <input type="text" maxlength="1" name="otp2"
                class="otp-input w-[45px] h-[55px] max-sm:w-[40px] max-sm:h-[50px] border-darkgray rounded-lg text-xl max-sm:text-lg text-center"
                required>
            <input type="text" maxlength="1" name="otp3"
                class="otp-input w-[45px] h-[55px] max-sm:w-[40px] max-sm:h-[50px] border-darkgray rounded-lg text-xl max-sm:text-lg text-center"
                required>
            <input type="text" maxlength="1" name="otp4"
                class="otp-input w-[45px] h-[55px] max-sm:w-[40px] max-sm:h-[50px] border-darkgray rounded-lg text-xl max-sm:text-lg text-center"
                required>
            <input type="text" maxlength="1" name="otp5"
                class="otp-input w-[45px] h-[55px] max-sm:w-[40px] max-sm:h-[50px] border-darkgray rounded-lg text-xl max-sm:text-lg text-center"
                required>
            <input type="text" maxlength="1" name="otp6"
                class="otp-input w-[45px] h-[55px] max-sm:w-[40px] max-sm:h-[50px] border-darkgray rounded-lg text-xl max-sm:text-lg text-center"
                required>
        </div>

        <!-- Hidden field for combined OTP -->
        <input type="hidden" name="otp" id="fullOtp">

        <div class="mt-4">
            <!-- INCASE MASIRA UNG NILAGAY KO SA BABA NG VERIFY BUTTON, ETO UNG NILAGAY NYONG PREVIOUS NA BACKEND CODE -->
            <!-- <form method="POST" action="{{ route('password.otp.resend') }}" class="mr-3">
                @csrf
                <input type="hidden" name="email" value="{{ session('email') ?? old('email') }}">
                <x-primary-button type="button" class="text-[15px] bg-primary text-orangeyellow hover:bg-orangeyellow hover:text-primary">
                    RESEND OTP
                </x-primary-button>
            </form> -->

            <!-- Verify Button -->
            <div class="flex w-full">
                <x-primary-button type="submit" class="w-full items-center justify-center text-[15px]">
                    VERIFY
                </x-primary-button>
            </div>
            <div class="text-center text-darkergray mt-4">
                Didn't receive the OTP Code?<br>
                <form method="POST" action="{{ route('password.otp.resend') }}" class="mr-3">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('email') ?? old('email') }}">
                    <button type="button"
                        class="text-primary font-bold hover:text-secondary transition-all duration-300">
                        Resend OTP
                    </button>
                </form>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const otpInputs = document.querySelectorAll('.otp-input');
            const fullOtpInput = document.getElementById('fullOtp');

            function updateFullOtp() {
                let fullOtp = '';
                otpInputs.forEach(input => {
                    fullOtp += input.value;
                });
                fullOtpInput.value = fullOtp;
            }

            otpInputs.forEach((input, index) => {
                input.addEventListener('input', function (e) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                    updateFullOtp();

                    if (this.value.length === 1 && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                });

                input.addEventListener('keydown', function (e) {
                    if (e.key === 'Backspace' && this.value.length === 0 && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                });

                input.addEventListener('paste', function (e) {
                    e.preventDefault();
                    const pasteData = e.clipboardData.getData('text').replace(/[^0-9]/g, '');
                    const chars = pasteData.split('');

                    chars.forEach((char, charIndex) => {
                        if (index + charIndex < otpInputs.length) {
                            otpInputs[index + charIndex].value = char;
                        }
                    });

                    updateFullOtp();
                    const lastIndex = Math.min(index + chars.length - 1, otpInputs.length - 1);
                    otpInputs[lastIndex].focus();
                });
            });

            updateFullOtp();
        });
    </script>
</x-guest-layout>