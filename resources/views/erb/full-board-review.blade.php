@section('title', 'Assign Full Board Review')
<x-erb-layout>
    <div id="filterModal" onclick="outsideClick(event)"
        class="fixed inset-0 bg-black z-[9999] bg-opacity-50 hidden items-center justify-center overflow-auto overscroll-contain">
        <div class="relative flex items-center justify-center bg-white w-[400px] p-6 rounded-[10px] shadow-md">
            <form action="" class="w-full px-2">
                <div class="flex justify-between items-center mb-2">
                    <div class="text-xl font-bold">Filter</div>
                    <button type="button" onclick="closeModal('filterModal')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-x-icon lucide-x">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </button>
                </div>
                <div class="w-full">
                    <!-- CALENDAR FILTERING FOR THE COUNT OF SUBMISSION -->
                    <div class="mt-4">
                        <label for="fromDate">From:</label>
                        <input type="date" id="fromDate" class="w-full max-md:text-sm h-[35px] text-sm max-sm:h-[31px]">
                    </div>
                    <div class="mt-4">
                        <label for="toDate">To:</label>
                        <input type="date" id="toDate" class="w-full max-md:text-sm h-[35px] text-sm max-sm:h-[31px]">
                    </div>
                </div>
                <button type="button" onclick="updateTable(); closeModal('filterModal')"
                    class="mt-4 bg-primary text-white tracking-widest uppercase px-4 py-2 rounded">
                    Apply
                </button>
            </form>
        </div>
    </div>
    <!-- Main Content -->
    <main class="xl:ml-[335px] max-xl:ml-auto p-4 max-md:p-2">
        <h2 class="max-xl:hidden text-left bg-[#f2f2f2] shadow-lg p-[35px] rounded-[30px] font-medium text-[28px]">
            FULL BOARD REVIEW
        </h2>
        <br>

        <!-- CSS NG FILTER + SEARCH BAR -->
        <div class="top-controls flex items-center justify-between max-md:flex-col">
            <!-- FUNCTIONALITY TO DISPLAY THE DATAS BASED ON DATE -->
            <div class="filter-box">
                Total Submission Count:
                <span class="font-bold" id="submissionCount"></span>
            </div>
            <div class="flex items-center max-sm:block max-sm:text-center max-md:mt-2">
                <button type="button" onclick="openModal('filterModal')" class="bg-primary text-white p-1.5 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-funnel-icon lucide-funnel">
                        <path
                            d="M10 20a1 1 0 0 0 .553.895l2 1A1 1 0 0 0 14 21v-7a2 2 0 0 1 .517-1.341L21.74 4.67A1 1 0 0 0 21 3H3a1 1 0 0 0-.742 1.67l7.225 7.989A2 2 0 0 1 10 14z" />
                    </svg>
                </button>
                <div class="search-wrapper max-sm:mt-3 max-sm:justify-center max-sm:items-center"></div>
            </div>
        </div>

        <table id="myTable" class="display overflow-scroll border-collapse w-full">
            <thead class="bg-primary text-white text-lg/7 max-lg:text-base/7">
                <tr class="header-table">
                    <th class="w-[16.66%]">Research Protocol</th>
                    <th class="w-[16.66%]">Reviewer(s)</th>
                    <th class="w-[16.66%]">P.I. Name</th>
                    <th class="w-[16.66%]">Co-I. Name(s)</th>
                    <th class="w-[16.66%]">Research Title</th>
                    <th class="w-[16.66%]">Date Assigned</th>
                </tr>
            </thead>
            <tbody class="text-base/7 max-lg:text-sm/6">
                @foreach($protocols as $protocol)
                    <tr data-date="{{ $protocol->created_at->format('Y-m-d') }}">
                        <td>
                            <div class="flex items-center gap-2">
                                <input type="checkbox" class="protocol-checkbox w-[14px] h-[14px]"
                                    value="{{ $protocol->protocol_ID }}"
                                    data-title="{{ $protocol->researchInformation ? $protocol->researchInformation->research_title : 'N/A' }}"
                                    data-user="{{ $protocol->user ? $protocol->user->user_Fname . ' ' . $protocol->user->user_Lname : 'N/A' }}">
                                <span>{{ $protocol->protocol_ID }}</span>
                            </div>
                        </td>
                        <td>
                            @if($protocol->fullBoardAssignments && $protocol->fullBoardAssignments->count() > 0)
                                                {{ $protocol->fullBoardAssignments->map(function ($assignment) {
                                    return $assignment->reviewer ? $assignment->reviewer->user_Fname . ' ' . $assignment->reviewer->user_Lname : '';
                                })->join(', ') }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if($protocol->user)
                                {{ $protocol->user->user_Fname }} {{ $protocol->user->user_Lname }}
                            @endif
                        </td>
                        <td>
                            @if($protocol->researchInformation)
                                {{ $protocol->researchInformation->research_CoInvestigator }}
                            @endif
                        </td>
                        <td>
                            @if($protocol->researchInformation)
                                {{ $protocol->researchInformation->research_title }}
                            @endif
                        </td>
                        <td>
                            {{ $protocol->created_at->format('m/d/Y') }}<br>
                            {{ $protocol->created_at->format('h:i:s A') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="grid grid-cols-2 max-sm:block gap-x-5 mt-4">
            <div class="max-sm:max-w-full">
                <div class="max-md:mt-3 bg-lightgray p-3 font-semibold max-sm:text-sm shadow-md rounded-md">
                    <h3 class="text-lg font-semibold max-md:text-base mb-3">Assigning Reviewers</h3>
                    <div class="mb-3 text-sm text-gray-600" id="reviewerCounter">
                        Assigning: <span id="currentCount">0</span>/5 reviewers
                    </div>
                    <div class="h-36 max-md:h-20 overflow-y-auto">
                        <div class="gap-x-3 gap-y-3 grid grid-cols-2 max-md:grid-cols-1 overflow-y-auto"
                            id="reviewersContainer">
                            <!-- Reviewers will be populated dynamically -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="max-md:mt-3 bg-lightgray shadow-md rounded-md overflow-y-auto p-3">
                <h3 class="text-lg font-semibold max-md:text-base mb-3">Assigned Reviewers</h3>
                <div class="h-36 max-md:h-20 overflow-y-auto">
                    <ul id="assignedList" class="list-disc grid grid-cols-2 max-md:text-sm gap-x-2 gap-y-3">
                        <!-- lists of assigned reviewers -->
                    </ul>
                </div>
            </div>
        </div>
        <div class="flex justify-start max-md:justify-center mt-4 mx-4 max-md:mx-0">
            <button id="submitBtn"
                class="bg-secondary hover:bg-primary text-primary hover:text-secondary px-4 py-3 rounded-md uppercase tracking-widest duration-200"
                type="button">
                Submit Assignment
            </button>
        </div>
    </main>
</x-erb-layout>

<script>
    const fromDate = document.getElementById('fromDate');
    const toDate = document.getElementById('toDate');
    const countSpan = document.getElementById("submissionCount");

    // ✅ Register BEFORE DataTable initializes (this runs first since it's in the slot)
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        if (settings.nTable.id !== 'myTable') return true;

        const from = fromDate.value;
        const to = toDate.value;

        if (!from && !to) return true;

        const row = settings.aoData[dataIndex].nTr;
        const rowDate = row ? row.getAttribute('data-date') : '';

        if (from && rowDate < from) return false;
        if (to && rowDate > to) return false;

        return true;
    });

    function updateTable() {
        const table = $('#myTable').DataTable();
        table.draw();
        countSpan.textContent = table.rows({ search: 'applied' }).count();
    }

    // ✅ Set initial count after DataTables is ready
    $(document).ready(function () {
        countSpan.textContent = $('#myTable').DataTable().rows().count();
    });

    // JavaScript for handling reviewer assignment
    document.addEventListener('DOMContentLoaded', function () {
        const reviewersContainer = document.getElementById('reviewersContainer');
        const assignedList = document.getElementById('assignedList');
        const submitBtn = document.getElementById('submitBtn');
        const reviewerCounter = document.getElementById('reviewerCounter');
        const currentCountSpan = document.getElementById('currentCount');

        let assignedReviewers = [];
        let selectedProtocols = [];
        const MAX_REVIEWERS = 5;

        // Dynamic reviewers from Laravel
        const availableReviewers = @json($reviewers->map(function ($reviewer) {
            return [
                'id' => $reviewer->user_ID,
                'name' => $reviewer->user_Fname . ' ' . $reviewer->user_Lname . ($reviewer->user_MI ? ' ' . $reviewer->user_MI . '.' : '')
            ];
        }));

        // Initialize checkboxes
        initializeCheckboxes();

        // Populate reviewers dynamically
        availableReviewers.forEach(reviewer => {
            const reviewerElement = document.createElement('div');
            reviewerElement.className = 'room cursor-pointer bg-gray hover:bg-darkgray px-3 py-2 rounded-md transition-colors duration-200';
            reviewerElement.textContent = reviewer.name;
            reviewerElement.dataset.id = reviewer.id;
            reviewerElement.dataset.name = reviewer.name;

            reviewerElement.addEventListener('click', function () {
                assignReviewer(reviewer.id, reviewer.name, reviewerElement);
            });

            reviewersContainer.appendChild(reviewerElement);
        });

        function initializeCheckboxes() {
            const checkboxes = document.querySelectorAll('.protocol-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    const protocolId = this.value;
                    const researchTitle = this.dataset.title;
                    const userName = this.dataset.user;

                    if (this.checked) {
                        selectedProtocols.push({
                            id: protocolId,
                            title: researchTitle,
                            user: userName,
                            element: this
                        });
                    } else {
                        selectedProtocols = selectedProtocols.filter(p => p.id !== protocolId);
                    }
                });
            });
        }

        function assignReviewer(id, name, element) {
            // Check if maximum limit reached
            if (assignedReviewers.length >= MAX_REVIEWERS) {
                alert(`Maximum of ${MAX_REVIEWERS} reviewers allowed. Please remove one before adding another.`);
                return;
            }

            if (!assignedReviewers.some(r => r.id === id)) {
                assignedReviewers.push({ id, name, element });

                // Disable the reviewer button
                element.classList.add('opacity-50', 'cursor-not-allowed', 'bg-darkgray');
                element.classList.remove('hover:bg-darkgray', 'cursor-pointer');
                element.removeEventListener('click', arguments.callee);

                updateReviewerCounter();
                updateAssignedList();

                // If maximum reached, show message and disable all remaining reviewer buttons
                if (assignedReviewers.length >= MAX_REVIEWERS) {
                    disableAllRemainingReviewers();
                    showMaxReviewersMessage();
                }
            }
        }

        function removeReviewer(index) {
            if (index >= 0 && index < assignedReviewers.length) {
                const reviewer = assignedReviewers[index];

                // Re-enable the reviewer button
                if (reviewer.element) {
                    reviewer.element.classList.remove('opacity-50', 'cursor-not-allowed', 'bg-darkgray');
                    reviewer.element.classList.add('hover:bg-darkgray', 'cursor-pointer');

                    // Re-add click event listener
                    reviewer.element.addEventListener('click', function () {
                        assignReviewer(reviewer.id, reviewer.name, reviewer.element);
                    });
                }

                // Remove from assigned reviewers array
                assignedReviewers.splice(index, 1);

                updateReviewerCounter();
                updateAssignedList();

                // If we were at maximum and now we're below, re-enable remaining reviewers
                if (assignedReviewers.length === MAX_REVIEWERS - 1) {
                    enableAllRemainingReviewers();
                    hideMaxReviewersMessage();
                }
            }
        }

        function updateReviewerCounter() {
            currentCountSpan.textContent = assignedReviewers.length;

            // Update counter color based on count
            if (assignedReviewers.length >= MAX_REVIEWERS) {
                reviewerCounter.classList.add('text-red-600', 'font-semibold');
                reviewerCounter.classList.remove('text-gray-600');
            } else {
                reviewerCounter.classList.remove('text-red-600', 'font-semibold');
                reviewerCounter.classList.add('text-gray-600');
            }
        }

        function disableAllRemainingReviewers() {
            const allReviewerElements = reviewersContainer.querySelectorAll('.room');
            allReviewerElements.forEach(element => {
                if (!assignedReviewers.some(r => r.element === element)) {
                    element.classList.add('opacity-30', 'cursor-not-allowed');
                    element.classList.remove('hover:bg-darkgray', 'cursor-pointer');
                    element.style.pointerEvents = 'none';
                }
            });
        }

        function enableAllRemainingReviewers() {
            const allReviewerElements = reviewersContainer.querySelectorAll('.room');
            allReviewerElements.forEach(element => {
                if (!assignedReviewers.some(r => r.element === element)) {
                    element.classList.remove('opacity-30', 'cursor-not-allowed');
                    element.classList.add('hover:bg-darkgray', 'cursor-pointer');
                    element.style.pointerEvents = 'auto';
                }
            });
        }

        function showMaxReviewersMessage() {
            // Remove existing message if any
            const existingMessage = reviewersContainer.querySelector('.max-reviewers-message');
            if (existingMessage) {
                existingMessage.remove();
            }

            const message = document.createElement('div');
            message.className = 'max-reviewers-message col-span-2 text-center text-red-600 text-sm font-semibold mt-2 p-2 bg-red-50 rounded-md';
            message.textContent = `Maximum of ${MAX_REVIEWERS} reviewers reached. Remove one to add another.`;
            reviewersContainer.appendChild(message);
        }

        function hideMaxReviewersMessage() {
            const existingMessage = reviewersContainer.querySelector('.max-reviewers-message');
            if (existingMessage) {
                existingMessage.remove();
            }
        }

        function updateAssignedList() {
            assignedList.innerHTML = '';
            assignedReviewers.forEach((reviewer, index) => {
                const listItem = document.createElement('li');
                listItem.className = 'flex items-center justify-between bg-white px-3 py-2 rounded-md shadow-sm';

                listItem.innerHTML = `
                <span class="flex-1">${reviewer.name}</span>
                <button type="button" class="remove-reviewer text-red-500 hover:text-red-700 transition-colors duration-200 ml-2" data-index="${index}" title="Remove reviewer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            `;

                assignedList.appendChild(listItem);
            });

            // Add event listeners to remove buttons
            document.querySelectorAll('.remove-reviewer').forEach(button => {
                button.addEventListener('click', function () {
                    const index = parseInt(this.dataset.index);
                    removeReviewer(index);
                });
            });
        }

        submitBtn.addEventListener('click', function () {
            // Validation
            if (selectedProtocols.length === 0) {
                alert('Please select at least one protocol.');
                return;
            }

            if (assignedReviewers.length === 0) {
                alert('Please assign at least one reviewer.');
                return;
            }

            if (assignedReviewers.length > MAX_REVIEWERS) {
                alert(`Please assign no more than ${MAX_REVIEWERS} reviewers.`);
                return;
            }

            // Prepare data for submission
            const submissionData = {
                protocols: selectedProtocols.map(p => p.id),
                reviewers: assignedReviewers.map(r => r.id),
                _token: '{{ csrf_token() }}'
            };

            // Show loading state
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Assigning...';
            submitBtn.disabled = true;

            // Send data to backend via AJAX
            fetch('{{ route("full-board.assign") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(submissionData)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Reviewers assigned successfully for full board review!');
                        // Reset form after successful submission
                        resetForm();
                        // Reload page to show updated assignments
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while assigning reviewers.');
                })
                .finally(() => {
                    // Restore button state
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                });
        });

        function resetForm() {
            // Uncheck all protocols
            selectedProtocols.forEach(protocol => {
                protocol.element.checked = false;
            });
            selectedProtocols = [];

            // Clear assigned reviewers
            assignedReviewers.forEach(reviewer => {
                removeReviewer(assignedReviewers.indexOf(reviewer));
            });
        }

        // Initialize counter
        updateReviewerCounter();
    });
</script>