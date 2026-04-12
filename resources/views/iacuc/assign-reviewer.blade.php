@section('title', 'Assign Reviewer')
<x-iacuc-layout>
    <!-- Main Content -->
    <main class="xl:ml-[335px] max-xl:ml-auto p-4 max-md:p-2">
        <h2 class="max-xl:hidden text-left bg-[#f2f2f2] shadow-lg p-[35px] rounded-[30px] font-medium text-[28px]">
            ASSIGN REVIEWER
        </h2>
        <br>

        <!-- CSS NG FILTER + SEARCH BAR -->
        <div class="top-controls flex items-center justify-end max-md:flex-col">
            <div class="flex items-center max-md:block max-md:text-center">
                <div class="search-wrapper max-md:mt-3 max-sm:justify-center max-sm:items-center"></div>
            </div>
        </div>

        <table id="myTable" class="display overflow-scroll border-collapse w-full">
            <thead class="bg-primary text-white text-lg/7 max-lg:text-base/7">
                <tr class="header-table">
                    <th class="w-[16.66%]">Research Title</th>
                    <th class="w-[16.66%]">PI Name</th>
                    <th class="w-[16.66%]">Co-Investigators</th>
                </tr>
            </thead>
            <tbody class="text-base/7 max-lg:text-sm/6">
                @foreach ($piWithIacuc as $assignReviewer)
                    <tr>
                        <td>
                            <input type="checkbox" class="user-checkbox w-[14px] h-[14px] mb-1"
                                value="{{ $assignReviewer->user_ID }}"
                                data-name="{{ $assignReviewer->researchInformation?->research_title }}">
                            <span>{{ $assignReviewer->researchInformation?->research_title }}</span>
                        </td>
                        <td>{{ $assignReviewer->user_Fname }} {{ $assignReviewer->user_MI }}
                            {{ $assignReviewer->user_Lname }}
                        </td>
                        <td>{{ $assignReviewer->researchInformation?->research_CoInvestigator }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="grid grid-cols-3 max-sm:block gap-x-5">
            <div class="mt-2 max-sm:max-w-full">
                <label for="reviewer1" class="block max-sm:text-sm">Reviewer 1</label>
                <select name="reviewer1" id="reviewer1"
                    class="w-full max-sm:text-sm border border-darkgray rounded-md h-[35px] leading-[18px] max-md:leading-[15px]">
                    <option disabled selected>Choose Reviewer</option>
                    <option value="N/A">N/A</option>
                    @foreach($iacucReviewer as $reviewer)
                        <option value="{{ $reviewer->user_ID }}"
                            data-name="{{ $reviewer->user_Fname }} {{ $reviewer->user_Lname }}"
                            data-college="{{ $reviewer->reviewerInformation->Reviewer_Dept ?? 'N/A' }}"
                            data-prog="{{ $reviewer->reviewerInformation->Reviewer_Prog ?? 'N/A' }}">
                            {{ $reviewer->user_Fname }} {{ $reviewer->user_Lname }}
                        </option>
                    @endforeach
                </select>
                <label for="reviewer2" class="mt-3 block max-sm:text-sm">Reviewer 2</label>
                <select name="reviewer2" id="reviewer2"
                    class="w-full max-md:text-sm border border-darkgray rounded-md h-[35px] leading-[18px] max-md:leading-[15px]">
                    <option disabled selected>Choose Reviewer</option>
                    <option value="N/A">N/A</option>
                    @foreach($iacucReviewer as $reviewer)
                        <option value="{{ $reviewer->user_ID }}"
                            data-name="{{ $reviewer->user_Fname }} {{ $reviewer->user_Lname }}"
                            data-college="{{ $reviewer->reviewerInformation->Reviewer_Dept ?? 'N/A' }}"
                            data-prog="{{ $reviewer->reviewerInformation->Reviewer_Prog ?? 'N/A' }}">
                            {{ $reviewer->user_Fname }} {{ $reviewer->user_Lname }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mt-2 max-md:mt-3 bg-lightgray shadow-md rounded-md p-3">
                <h3 class="text-lg font-semibold max-md:text-base mb-3">Reviewer 1</h3>
                <div class="grid grid-cols-[max-content_1fr] max-sm:grid-cols-1 gap-x-2 gap-y-3">
                    <div class="font-bold">Name:</div>
                    <div id="r1_name">—</div>

                    <div class="font-bold">College:</div>
                    <div id="r1_college">—</div>

                    <div class="font-bold">Program:</div>
                    <div id="r1_prog">—</div>
                </div>
            </div>
            <div class="mt-2 max-md:mt-3 bg-lightgray shadow-md rounded-md p-3">
                <h3 class="text-lg font-semibold max-md:text-base mb-3">Reviewer 2</h3>
                <div class="grid grid-cols-[max-content_1fr] max-sm:grid-cols-1 gap-x-2 gap-y-3">
                    <div class="font-bold">Name:</div>
                    <div id="r2_name">—</div>

                    <div class="font-bold">College:</div>
                    <div id="r2_college">—</div>

                    <div class="font-bold">Program:</div>
                    <div id="r2_prog">—</div>
                </div>
            </div>
        </div>
        <div class="flex justify-start mt-4 mx-4">
            <button id="submitBtn"
                class="bg-secondary hover:bg-primary text-primary hover:text-secondary px-4 py-3 rounded-md uppercase tracking-widest duration-200"
                type="button">
                Submit
            </button>
        </div>
    </main>
</x-iacuc-layout>
<script>
    // Store selected reviewers to prevent duplicates
    let selectedReviewers = {
        reviewer1: null,
        reviewer2: null
    };

    // Function to update dropdown options based on selected reviewers
    function updateDropdownOptions() {
        const reviewer1Select = document.getElementById('reviewer1');
        const reviewer2Select = document.getElementById('reviewer2');

        // Reset all options first
        Array.from(reviewer1Select.options).forEach(option => {
            if (option.value !== 'N/A') {
                option.disabled = false;
                option.hidden = false;
            }
        });

        Array.from(reviewer2Select.options).forEach(option => {
            if (option.value !== 'N/A') {
                option.disabled = false;
                option.hidden = false;
            }
        });

        // Disable selected reviewers in the other dropdown
        if (selectedReviewers.reviewer1 && selectedReviewers.reviewer1 !== 'N/A') {
            const optionToDisable = reviewer2Select.querySelector(`option[value="${selectedReviewers.reviewer1}"]`);
            if (optionToDisable) {
                optionToDisable.disabled = true;
            }
        }

        if (selectedReviewers.reviewer2 && selectedReviewers.reviewer2 !== 'N/A') {
            const optionToDisable = reviewer1Select.querySelector(`option[value="${selectedReviewers.reviewer2}"]`);
            if (optionToDisable) {
                optionToDisable.disabled = true;
            }
        }
    }

    // Function to display reviewer information
    function displayReviewerInfo(reviewerNumber, selectedOption) {
        const nameElement = document.getElementById(`r${reviewerNumber}_name`);
        const collegeElement = document.getElementById(`r${reviewerNumber}_college`);
        const progElement = document.getElementById(`r${reviewerNumber}_prog`);

        if (selectedOption.value === 'N/A') {
            nameElement.textContent = '—';
            collegeElement.textContent = '—';
            progElement.textContent = '—';
        } else {
            nameElement.textContent = selectedOption.getAttribute('data-name');
            collegeElement.textContent = selectedOption.getAttribute('data-college');
            progElement.textContent = selectedOption.getAttribute('data-prog');
        }
    }

    // Reviewer 1 change event
    document.getElementById('reviewer1').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        selectedReviewers.reviewer1 = selectedOption.value;

        // Update reviewer 1 information
        displayReviewerInfo(1, selectedOption);

        // Update dropdown options to prevent duplicate selection
        updateDropdownOptions();

        // If same reviewer is selected in both, reset reviewer 2
        if (selectedReviewers.reviewer1 === selectedReviewers.reviewer2 && selectedReviewers.reviewer1 !== 'N/A') {
            document.getElementById('reviewer2').value = 'N/A';
            selectedReviewers.reviewer2 = 'N/A';
            displayReviewerInfo(2, document.getElementById('reviewer2').options[0]);
        }
    });

    // Reviewer 2 change event
    document.getElementById('reviewer2').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        selectedReviewers.reviewer2 = selectedOption.value;

        // Update reviewer 2 information
        displayReviewerInfo(2, selectedOption);

        // Update dropdown options to prevent duplicate selection
        updateDropdownOptions();

        // If same reviewer is selected in both, reset reviewer 1
        if (selectedReviewers.reviewer2 === selectedReviewers.reviewer1 && selectedReviewers.reviewer2 !== 'N/A') {
            document.getElementById('reviewer1').value = 'N/A';
            selectedReviewers.reviewer1 = 'N/A';
            displayReviewerInfo(1, document.getElementById('reviewer1').options[0]);
        }
    });

    // Submit button functionality following your format
    const submitBtn = document.getElementById("submitBtn");

    submitBtn.addEventListener("click", function (e) {
        e.preventDefault();

        const selectedCheckboxes = document.querySelectorAll('.user-checkbox:checked');
        const reviewer1Id = document.getElementById('reviewer1').value;
        const reviewer2Id = document.getElementById('reviewer2').value;

        // Get selected PI IDs
        const selectedPIs = Array.from(selectedCheckboxes).map(checkbox => checkbox.value);

        // Validate at least one research is selected
        if (selectedPIs.length === 0) {
            alert("Please select at least one research project.");
            return;
        }

        // Validate at least one reviewer is selected (not N/A)
        if (reviewer1Id === 'N/A' && reviewer2Id === 'N/A') {
            alert("Please select at least one reviewer.");
            return;
        }

        // Validate no duplicate reviewers
        if (reviewer1Id !== 'N/A' && reviewer2Id !== 'N/A' && reviewer1Id === reviewer2Id) {
            alert("Please select different reviewers for Reviewer 1 and Reviewer 2.");
            return;
        }

        submitBtn.disabled = true;
        submitBtn.textContent = "Submitting...";

        const data = {
            _token: '{{ csrf_token() }}',
            pis: selectedPIs,
            reviewer1_ID: reviewer1Id,
            reviewer2_ID: reviewer2Id
        };

        fetch("{{ route('iacuc.assign-reviewer.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify(data)
        })
            .then(response => {
                const contentType = response.headers.get('content-type');

                if (contentType && contentType.includes('application/json')) {
                    return response.json();
                } else {
                    return response.text().then(text => {
                        throw new Error('Unexpected response type: ' + contentType);
                    });
                }
            })
            .then(res => {
                submitBtn.disabled = false;
                submitBtn.textContent = "Submit";

                if (res && res.message) {
                    alert("✅ " + res.message);
                    resetForm();
                } else if (res && res.error) {
                    alert("❌ " + res.error);
                }
            })
            .catch(err => {
                console.error('Error details:', err);
                alert("❌ Failed to save: " + err.message);
                submitBtn.disabled = false;
                submitBtn.textContent = "Submit";
            });
    });

    // Function to reset form
    function resetForm() {
        // Clear all checkboxes
        document.querySelectorAll('.user-checkbox').forEach(checkbox => {
            checkbox.checked = false;
        });

        // Reset reviewer selections
        document.getElementById('reviewer1').selectedIndex = 0;
        document.getElementById('reviewer2').selectedIndex = 0;

        // Reset reviewer information display
        document.getElementById("r1_name").textContent = "—";
        document.getElementById("r2_name").textContent = "—";
        document.getElementById("r1_college").textContent = "—";
        document.getElementById("r2_college").textContent = "—";
        document.getElementById("r1_prog").textContent = "—";
        document.getElementById("r2_prog").textContent = "—";

        // Reset selected reviewers
        selectedReviewers = {
            reviewer1: null,
            reviewer2: null
        };

        // Update dropdown options
        updateDropdownOptions();
    }

    // Initialize dropdown options on page load
    document.addEventListener('DOMContentLoaded', function () {
        updateDropdownOptions();
    });
</script>