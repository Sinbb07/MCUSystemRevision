@section('title', 'Register')
<x-guest-layout>
    <style>
        .step {
            display: none;
        }

        .step.active {
            display: block;
        }

        #departmentWrapper {
            display: none;
        }

        button {
            margin-top: 10px;
        }
    </style>
    <form method="POST" action="{{ route('register') }}" id="studentForm" enctype="multipart/form-data">
        <div id="step1" class="step active">
            @csrf
            <h2 class="mb-2 font-semibold mt-2 uppercase text-xl max-sm:text-base text-primary">Registration Form</h2>
            <div class="p-0.5 max-md:max-h-[240px] overflow-y-auto">
                <!-- Name -->
                <div id="pi-wrapper">
                    <x-input-label for="pi_name" :value="__('Principal Investigator')" />
                    <div class="flex space-x-2">
                        <div class="w-1/3">
                            <x-text-input id="user_Lname" class="block mt-1 w-full text-[15px] max-sm:text-sm h-[35px]"
                                type="text" name="user_Lname" :value="old('user_Lname')" required autofocus
                                autocomplete="user_Lname" placeholder="Last name" />
                            <x-input-error :messages="$errors->get('user_Lname')" class="mt-2" />
                        </div>
                        <div class="w-1/3">
                            <x-text-input id="user_Fname" class="block mt-1 w-full text-[15px] max-sm:text-sm h-[35px]"
                                type="text" name="user_Fname" :value="old('user_Fname')" required autofocus
                                autocomplete="user_Fname" placeholder="First name" />
                            <x-input-error :messages="$errors->get('user_Fname')" class="mt-2" />
                        </div>
                        <div class="w-1/3">
                            <x-text-input id="user_MI" class="block mt-1 w-full text-[15px] max-sm:text-sm h-[35px]"
                                type="text" name="user_MI" maxlength="2" :value="old('user_MI')"
                                autocomplete="user_MI" placeholder="MI" title="Enter 1 or 2 letters only" />
                            <x-input-error :messages="$errors->get('user_MI')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Email Address -->
                <div class="mt-2">
                    <x-input-label for="user_Email" :value="__('Email')" />
                    <x-text-input id="user_Email" class="block mt-1 w-full text-[15px] max-sm:text-sm h-[35px]"
                        type="email" name="user_Email" :value="old('user_Email')" required autocomplete="username"
                        placeholder="you@example.com" />
                    <x-input-error :messages="$errors->get('user_Email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-2">
                    <x-input-label for="user_Password" :value="__('Password')" />
                    <x-text-input id="user_Password" class="block mt-1 w-full text-[15px] max-sm:text-sm h-[35px]"
                        type="password" name="user_Password" required autocomplete="user_Password"
                        placeholder="Password" />
                    <x-input-error :messages="$errors->get('user_Password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-2">
                    <x-input-label for="user_Password" :value="__('Confirm Password')" />
                    <x-text-input id="user_Password_confirmation"
                        class="block mt-1 w-full text-[15px] max-sm:text-sm h-[35px]" type="password"
                        name="user_Password_confirmation" required autocomplete="user_Password"
                        placeholder="Confirm Password" />
                    <x-input-error :messages="$errors->get('user_Password_confirmation')" class="mt-2" />
                </div>
            </div>
            <div class="flex items-center justify-end mt-4">
                <a class="max-sm:text-sm text-primary hover:text-secondary duration-200 rounded-md focus:outline-none"
                    href="{{ route('login') }}">
                    {{ __('Go to Login') }}
                </a>
                <!-- button type="button" ginamit ko para madirect sya into 2nd part khit nakarequired(pag submit button ginamit, di madidirect si user sa 2ndo part since naka required sya) -->
                <button type="button" onclick="nextStep()"
                    class="bg-secondary hover:bg-primary text-primary hover:text-secondary max-sm:text-sm px-4 py-2 rounded-md ms-2 mt-1 uppercase tracking-widest duration-200">
                    Next
                </button>
            </div>
        </div>
        <div id="step2" class="step">
            <h2 class="mb-2 font-semibold mt-2 uppercase text-xl max-sm:text-base text-primary">Registration Form</h2>
            <div class="p-0.5 max-md:max-h-[240px] overflow-y-auto">
                <!-- Co-Investigator -->
                <div id="co-wrapper">
                    <x-input-label for="research_CoInvestigator" :value="__('Co-Investigator/s (type N/A if none)')" />
                    <x-text-input id="research_CoInvestigator"
                        class="block mt-1 w-full text-[15px] max-sm:text-sm h-[35px]" type="text"
                        name="research_CoInvestigator" :value="old('Co_Investigators')" required
                        autocomplete="research_CoInvestigator" placeholder="e.g. (Last Name, First Name, M.I.)" />
                    <x-input-error :messages="$errors->get('research_CoInvestigator')" class="mt-2" />
                </div>

                <!-- PI Contact Number -->
                <div class="mt-2">
                    <x-input-label for="research_Contact" :value="__('PI Contact Number')" />
                    <x-text-input id="research_Contact"
                        class="block mt-1 w-full text-[15px] max-sm:text-sm h-[35px]" type="text"
                        name="research_Contact" :value="old('research_Contact')" required
                        autocomplete="research_Contact" placeholder="09XX-XXX-XX74" />
                    <x-input-error :messages="$errors->get('research_Contact')" class="mt-2" />
                </div>

                <!-- If MCU Student or not -->
                <div class="mt-3">
                    <label for="research_checkmcu" class="flex items-center space-x-1">
                        <input id="toggleCheckBox" type="checkbox" class="rounded max-sm:w-[14px] max-sm:h-[14px]"
                            name="research_checkmcu" value="1" />
                        <span id="inputSpan" class="text-primary max-sm:text-sm">{{ __('Check if not MCU student') }}
                        </span>
                    </label>

                    <input type="hidden" name="research_college" value="">
                    <input type="hidden" name="research_department" value="">

                    <x-input-label id="inputLabel" for="pi_program" :value="__('Select College and Department')" />
                    <x-combo-box id="pi_program" name="research_college" onchange="updateDepartments()"
                        class="block border-gray mt-1 w-full text-[15px] max-sm:text-sm max-sm:text-sm h-[35px] leading-[20px]" />
                    <div id="departmentWrapper">
                        <select id="department" name="research_department"
                            class="w-full text-[15px] max-sm:text-sm mt-1 border-gray rounded-md h-[35px]">
                            <option value="" disabled selected>-- Select Department --</option>
                        </select>
                    </div>
                    <x-input-error :messages="$errors->get('research_college')" class="mt-2" />

                    <input type="text" id="textBox" name="research_school"
                        class="h-[35px] text-[15px] max-sm:text-sm block mt-1 w-full border-gray hover:bg-gray rounded-md duration-200 hidden"
                        placeholder="School" value="{{ old('research_school') }}" />
                </div>

                <!-- Research Type -->
                <div class="mt-2">
                    <x-input-label for="research_type" :value="__('Research Type')" />
                    <select name="research_type" id="research_type" class="block border-gray mt-1 w-full text-[15px] max-sm:text-sm max-sm:text-sm h-[35px] leading-[20px]" required>
                        <option value="" disabled {{ old('research_type') ? '' : 'selected' }}>-- Choose type --</option>
                        <option value="MCU Undergraduate Student" {{ old('research_type') === 'MCU Undergraduate Student' ? 'selected' : '' }}>MCU Undergraduate Student</option>
                        <option value="MCU Graduate Student" {{ old('research_type') === 'MCU Graduate Student' ? 'selected' : '' }}>MCU Graduate Student</option>
                        <option value="MCU Faculty" {{ old('research_type') === 'MCU Faculty' ? 'selected' : '' }}>MCU Faculty</option>
                        <option value="MCU Non-Teaching Staff" {{ old('research_type') === 'MCU Non-Teaching Staff' ? 'selected' : '' }}>MCU Non-Teaching Staff</option>
                        <option value="MCU Administrative Staff" {{ old('research_type') === 'MCU Administrative Staff' ? 'selected' : '' }}>MCU Administrative Staff</option>
                        <option value="Non-MCU Researcher" {{ old('research_type') === 'Non-MCU Researcher' ? 'selected' : '' }}>Non-MCU Researcher</option>
                    </select>
                    <x-input-error :messages="$errors->get('research_type')" class="mt-2" />
                </div>

                <!-- Research Title -->
                <div class="mt-2">
                    <x-input-label for="research_title" :value="__('Research Title')" />
                    <x-text-input id="research_title" class="block mt-1 w-full text-[15px] max-sm:text-sm h-[35px]"
                        type="text" name="research_title" :value="old('research_title')" required
                        autocomplete="research_title" placeholder="Research Title" />
                    <x-input-error :messages="$errors->get('research_title')" class="mt-2" />
                </div>

                <!-- Attach Endorsement Letter File -->
                <div class="mt-2">
                    <x-input-label for="attachments" :value="__('Endorsement Letter')" />
                    <x-text-input id="research_Endorsement"
                        class="block mt-1 w-full rounded-md p-1 hover:bg-transparent text-[15px] max-sm:text-sm h-[35px]"
                        type="file" name="research_Endorsement" multiple />
                </div>

                <!-- Receipts Upload File -->
                <div class="mt-2">
                    <x-input-label for="attachments" :value="__('Receipts')" />
                    <x-text-input id="research_Receipts"
                        class="block mt-1 w-full rounded-md p-1 hover:bg-transparent text-[15px] max-sm:text-sm h-[35px]"
                        type="file" name="research_Receipts" multiple />
                </div>
            </div>
            <div class="flex items-center justify-end mt-4">
                <a class="max-sm:text-sm text-primary hover:text-secondary duration-200 rounded-md focus:outline-none"
                    href="{{ route('login') }}">
                    {{ __('Go to Login') }}
                </a>
                <!-- button type="button" ginamit ko para madirect sya into 1st part khit nakarequired(pag submit button ginamit, di madidirect si user sa 2nd part since naka required sya) -->
                <button type="button" onclick="prevStep()"
                    class="bg-secondary hover:bg-primary text-primary hover:text-secondary max-sm:text-sm px-4 py-2 rounded-md ms-2 mt-1 uppercase tracking-widest duration-200">
                    Back
                </button>
                <x-primary-button class="ms-2 mt-1 max-sm:text-sm" type="submit">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleCheckBox = document.getElementById('toggleCheckBox');
            const comboBox = document.getElementById('pi_program');
            const textBox = document.getElementById('textBox');
            const departmentWrapper = document.getElementById('departmentWrapper')
            const inputSpan = document.getElementById('inputSpan');
            const dynamicLabel = document.getElementById('inputLabel');

            toggleCheckBox.addEventListener('change', function () {
                if (toggleCheckBox.checked) {
                    comboBox.classList.add('hidden');
                    departmentWrapper.style.display = "none";
                    textBox.classList.remove('hidden');
                    textBox.value = "";
                    textBox.disabled = false;
                    // Update the x-input-label's text
                    dynamicLabel.textContent = 'School';
                } else {
                    comboBox.classList.remove('hidden');
                    comboBox.value = "";
                    if (comboBox.value && departmentOptions[comboBox.value]) {
                        departmentWrapper.style.display = "block";
                    }
                    else {
                        departmentWrapper.style.display = "none";
                    }
                    departmentWrapper.value = "";
                    textBox.classList.add('hidden');
                    textBox.disabled = true;
                    textBox.value = "N/A";

                    // Restore label text
                    dynamicLabel.textContent = 'Select Program';
                }
            });

            const middleInitialInput = document.getElementById('user_MI');
            if (middleInitialInput) {
                middleInitialInput.addEventListener('input', function (event) {
                    let value = event.target.value.replace(/[^a-zA-Z]/g, '').toUpperCase();
                    if (value.length > 2) {
                        value = value.slice(0, 2);
                    }
                    event.target.value = value;
                });
            }
        });

        // Program → Department mapping
        const departmentOptions = {
            cas: ["Bachelor of Science in Biology", "Bachelor of Science in Computer Science",
                "Bachelor of Science in Information Technology", "Bachelor of Science in Psychology",
                "Bachelor of Arts in Communication", "Bachelor of Science in Entertainment and Multimedia Computing"],
            ioe: ["Bachelor of Secondary Education"],
            sbm: ["Bachelor of Science in Business Administration", "Bachelor of Accountancy",
                "Bachelor of Science in Entrepreneurship", "Bachelor of Science in Hospitality Management",
                "Bachelor of Science in Tourism Management"],
            medical: ["Bachelor of Science in Radiologic Technology", "Bachelor of Science in Medical Technology",
                "Doctor of Dental Medicine", "Doctor of Medicine", "Bachelor of Science in Nursing",
                "Doctor of Optometry", "Bachelor of Science in Pharmacy", "Bachelor of Science in Physical Therapy"]
        };

        function updateDepartments() {
            const program = document.getElementById("pi_program").value;
            const departmentSelect = document.getElementById("department");
            const departmentWrapper = document.getElementById("departmentWrapper");

            // Clear old options
            departmentSelect.innerHTML = '<option value="" disabled selected>-- Select Department --</option>';

            if (program && departmentOptions[program]) {
                // Show department dropdown
                departmentWrapper.style.display = "block";

                departmentOptions[program].forEach(dept => {
                    const option = document.createElement("option");
                    option.textContent = dept;
                    departmentSelect.appendChild(option);
                });
            }
        }

        let currentStep = 1;
        const totalSteps = 2;

        function showStep(step) {
            // hide all steps
            for (let i = 1; i <= totalSteps; i++) {
                document.getElementById("step" + i).classList.remove("active");
                // disable required for hidden inputs
                document.querySelectorAll("#step" + i + " [required]").forEach(input => {
                    input.dataset.required = "true";
                    input.removeAttribute("required");
                });
            }

            // show current step
            const currentDiv = document.getElementById("step" + step);
            currentDiv.classList.add("active");
            // enable required for visible inputs
            currentDiv.querySelectorAll("[data-required]").forEach(input => {
                input.setAttribute("required", "true");
            });
        }

        function nextStep() {
            const form = document.getElementById("studentForm");
            if (form.checkValidity()) { // validate current step
                currentStep++;
                showStep(currentStep);
            } else {
                form.reportValidity(); // show validation error
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        }

        // initialize
        document.addEventListener("DOMContentLoaded", () => showStep(currentStep));

        // handle final submit
        document.getElementById("studentForm").addEventListener("submit", function () {
            // no e.preventDefault() here, allow normal Laravel submission
            // ✅ Form will submit to your controller and save
        });
    </script>
</x-guest-layout>