@section('title', 'Approved Accounts')
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

    <main class="xl:ml-[335px] max-xl:ml-auto p-4 max-md:p-2">
        <h2 class="max-xl:hidden text-left bg-[#f2f2f2] shadow-lg p-[35px] rounded-[30px] font-medium text-[28px]">
            APPROVED ACCOUNTS
        </h2>
        <br>

        <div class="top-controls flex items-center justify-end max-md:flex-col">
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
                    <th class="w-[20.00%]">P.I. Name</th>
                    <th class="w-[20.00%]">Department</th>
                    <th class="w-[20.00%]">Research Title</th>
                    <th class="w-[20.00%]">Registration Date</th>
                    <th class="w-[20.00%]">Status</th>
                </tr>
            </thead>
            <tbody class="text-base/7 max-lg:text-sm/6">
                @foreach($approvedAccounts as $user)
                    <tr data-date="{{ $user->created_at ? $user->created_at->format('Y-m-d') : '' }}"
                        data-user-id="{{ $user->user_ID }}"
                        data-assigned-forms="{{ $user->forms->pluck('form_id')->toJson() }}">
                        <td>
                            <input type="checkbox" class="user-checkbox w-[14px] h-[14px] mb-1" value="{{ $user->user_ID }}"
                                data-name="{{ $user->user_Fname }} {{ $user->user_Lname }}"
                                data-assigned-forms="{{ $user->forms->pluck('form_id')->toJson() }}">
                            <span>{{ $user->user_Fname }} {{ $user->user_Lname }}</span>
                            @if($user->forms->isNotEmpty())
                                <span class="text-xs text-green-600">(Has {{ $user->forms->count() }} forms)</span>
                            @endif
                        </td>
                        <td>{{ $user->researchInformation?->research_department ?? 'N/A' }}</td>
                        <td>{{ $user->researchInformation?->research_title ?? 'N/A' }}</td>
                        <td>
                            {{ $user->created_at ? $user->created_at->format('m/d/Y') : 'N/A' }}<br>
                            {{ $user->created_at ? $user->created_at->format('h:i:s A') : '' }}
                        </td>
                        <td>{{ $user->classifications?->classificationStatus ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if($approvedAccounts->isNotEmpty())
            <div class="flex mx-4 gap-6 grid grid-cols-2 max-md:grid-cols-1">
                <div class="forms-assign bg-lightgray p-4 shadow-md rounded-md">
                    <h3 class="text-lg font-semibold max-md:text-base mb-3">Assignment of Forms</h3>
                    <div class="flex h-40 max-md:h-28 overflow-y-auto grid grid-cols-3 max-sm:grid-cols-2 gap-y-3 gap-x-3 font-semibold max-md:text-sm">
                        @foreach ($selectForms as $form)
                            <div class="room cursor-pointer bg-gray hover:bg-darkgray px-3 py-2 rounded-md"
                                data-room="{{ $form->form_id }}" data-code="{{ $form->form_code }}" data-view="{{ $form->form_view }}">
                                {{ $form->form_code }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="assigned-forms bg-lightgray p-4 shadow-md rounded-md">
                    <h3 class="text-lg font-semibold max-md:text-base mb-3">Forms to Remove from Selected Users</h3>
                    <div class="mb-2 text-sm text-red-600">
                        ⚠️ Click the ✕ button next to a form to mark it for removal from ALL selected users
                    </div>
                    <ul id="assignedList" class="list-disc h-40 max-md:h-28 overflow-y-auto mx-2 pl-6 pt-2 flex flex-col gap-y-3 max-md:text-sm">
                        <!-- Already assigned forms will appear here with delete buttons -->
                    </ul>
                </div>
            </div>
                
            <div class="flex justify-end mt-4 mx-4">
                <button id="submitBtn"
                    class="bg-secondary hover:bg-primary text-primary hover:text-secondary px-4 py-3 rounded-md uppercase tracking-widest duration-200"
                    type="button" disabled>
                    Submit
                </button>
            </div>
        @else
            <div class="text-center p-6 bg-lightgray rounded-md text-gray-500 mt-6">
                ⚠ No approved accounts available for form assignment.
            </div>
        @endif
    </main>
</x-erb-layout>

<script>
    const fromDate = document.getElementById('fromDate');
    const toDate = document.getElementById('toDate');
    let selectedUsers = [];
    let formsToAssign = [];
    let formsToRemove = [];  // Track forms to remove (selected from already assigned)
    let currentAssignedForms = [];  // Track the original assigned forms for selected users

    // DataTable filter
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
    }

    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.getElementById(modalId).style.display = 'flex';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.getElementById(modalId).style.display = 'none';
    }

    function outsideClick(event) {
        if (event.target.id === 'filterModal') {
            closeModal('filterModal');
        }
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function updateBothDisplays() {
        updateRemoveListDisplay();
        updateFormAvailability();
        validateSubmitButton();
    }

    function updateRemoveListDisplay() {
        const assignedList = document.getElementById("assignedList");
        if (!assignedList) return;
        
        assignedList.innerHTML = '';

        // Show forms that are currently assigned to ALL selected users (common forms only)
        if (selectedUsers.length > 0 && currentAssignedForms.length > 0) {
            currentAssignedForms.forEach(form => {
                const isMarkedForRemoval = formsToRemove.some(f => f.id == form.id);
                const li = document.createElement("li");
                li.className = "flex justify-between items-center w-full hover:bg-gray-100 p-1 rounded";
                li.innerHTML = `
                    <div class="flex items-center gap-2">
                        <span class="${isMarkedForRemoval ? 'text-red-600 line-through' : 'text-gray-700'}">●</span>
                        <span class="${isMarkedForRemoval ? 'line-through text-red-600' : ''}">${escapeHtml(form.code)}</span>
                    </div>
                    <button onclick="toggleRemoveForm('${form.id}', '${escapeHtml(form.code)}')" 
                            class="ml-2 px-2 py-1 rounded transition ${isMarkedForRemoval ? 'bg-green-500 hover:bg-green-600 text-white' : 'bg-red-500 hover:bg-red-600 text-white'}"
                            title="${isMarkedForRemoval ? 'Cancel removal' : 'Mark for removal'}">
                        ${isMarkedForRemoval ? '✓ Undo' : '✕ Remove'}
                    </button>
                `;
                li.setAttribute('data-form-id', form.id);
                assignedList.appendChild(li);
            });
        } else {
            const li = document.createElement("li");
            li.className = "text-gray-400 italic text-center";
            li.textContent = "Select users to see their assigned forms";
            assignedList.appendChild(li);
        }
    }

    // Toggle form for removal
    window.toggleRemoveForm = function(formId, formCode) {
        const existingIndex = formsToRemove.findIndex(f => f.id == formId);
        
        if (existingIndex > -1) {
            // Remove from removal list (keep the form)
            formsToRemove.splice(existingIndex, 1);
        } else {
            // Add to removal list
            formsToRemove.push({ id: formId, code: formCode });
        }
        
        updateRemoveListDisplay();
        validateSubmitButton();
    }

    function validateSubmitButton() {
        const submitBtn = document.getElementById("submitBtn");
        const hasSelectedUsers = selectedUsers.length > 0;
        const hasFormsToAssign = formsToAssign.length > 0;
        const hasFormsToRemove = formsToRemove.length > 0;
        
        if (submitBtn) {
            submitBtn.disabled = !(hasSelectedUsers && (hasFormsToAssign || hasFormsToRemove));
        }
    }

    function updateFormAvailability() {
        const rooms = document.querySelectorAll(".room");
        
        rooms.forEach(room => {
            room.classList.remove('disabled-form', 'cursor-not-allowed', 'opacity-50');
            room.style.pointerEvents = 'auto';
        });

        if (selectedUsers.length > 0) {
            const assignedFormIds = currentAssignedForms.map(form => parseInt(form.id));

            rooms.forEach(room => {
                const formId = parseInt(room.dataset.room);
                if (assignedFormIds.includes(formId)) {
                    room.classList.add('disabled-form', 'cursor-not-allowed', 'opacity-50');
                    room.style.pointerEvents = 'none';
                }
            });
        }
    }

    // Load current assigned forms for selected users (common forms only)
    function loadCurrentAssignedForms() {
        currentAssignedForms = [];
        const selectedCheckboxes = document.querySelectorAll(".user-checkbox:checked");
        
        if (selectedCheckboxes.length === 0) {
            updateRemoveListDisplay();
            return;
        }
        
        // Get assigned forms for each selected user
        const allUsersForms = [];
        selectedCheckboxes.forEach(cb => {
            const assignedFormsJson = cb.getAttribute('data-assigned-forms');
            const assignedFormIds = assignedFormsJson ? JSON.parse(assignedFormsJson) : [];
            const forms = [];
            assignedFormIds.forEach(formId => {
                const formElement = document.querySelector(`.room[data-room="${formId}"]`);
                if (formElement) {
                    forms.push({
                        id: parseInt(formId),
                        code: formElement.textContent.trim()
                    });
                }
            });
            allUsersForms.push(forms);
        });
        
        // Find forms that are common to ALL selected users
        if (allUsersForms.length > 0) {
            // Start with the first user's forms
            let commonForms = [...allUsersForms[0]];
            
            // Intersect with each subsequent user's forms
            for (let i = 1; i < allUsersForms.length; i++) {
                commonForms = commonForms.filter(form => 
                    allUsersForms[i].some(f => f.id === form.id)
                );
            }
            
            currentAssignedForms = commonForms;
        }
        
        updateRemoveListDisplay();
    }

    // Handle form room clicks (for assignment)
    const rooms = document.querySelectorAll(".room");
    rooms.forEach(room => {
        room.addEventListener("click", () => {
            if (room.classList.contains('disabled-form')) {
                alert("This form is already assigned to all selected users.");
                return;
            }

            const formId = room.dataset.room;
            const formCode = room.textContent.trim();

            const existingIndex = formsToAssign.findIndex(form => form.id == formId);

            if (existingIndex > -1) {
                formsToAssign.splice(existingIndex, 1);
                room.classList.remove("bg-darkgray");
                room.classList.add("bg-gray");
            } else {
                formsToAssign.push({ id: formId, code: formCode });
                room.classList.add("bg-darkgray");
                room.classList.remove("bg-gray");
            }

            validateSubmitButton();
        });
    });

    // Handle user checkbox changes
    const userCheckboxes = document.querySelectorAll(".user-checkbox");
    userCheckboxes.forEach(cb => {
        cb.addEventListener("change", () => {
            const userId = cb.value;

            if (cb.checked) {
                selectedUsers.push(userId);
            } else {
                selectedUsers = selectedUsers.filter(id => id !== userId);
                // Also remove any forms to assign that might be pending
                if (selectedUsers.length === 0) {
                    formsToAssign = [];
                    formsToRemove = [];
                    // Reset room colors
                    rooms.forEach(room => {
                        room.classList.remove("bg-darkgray");
                        room.classList.add("bg-gray");
                    });
                }
            }

            // Reload current assigned forms
            loadCurrentAssignedForms();
            
            // Clear forms to assign when user selection changes
            formsToAssign.forEach(form => {
                const room = document.querySelector(`.room[data-room="${form.id}"]`);
                if (room) {
                    room.classList.remove("bg-darkgray");
                    room.classList.add("bg-gray");
                }
            });
            formsToAssign = [];
            
            updateFormAvailability();
            validateSubmitButton();
        });
    });

    // Submit button
    const submitBtn = document.getElementById("submitBtn");
    submitBtn.addEventListener("click", (e) => {
        const newFormsToAssign = formsToAssign.map(form => form.id);
        const formsToRemoveIds = formsToRemove.map(form => form.id);

        if (selectedUsers.length === 0) {
            alert("⚠️ Please select at least one user.");
            return;
        }

        if (newFormsToAssign.length === 0 && formsToRemoveIds.length === 0) {
            alert("⚠️ Please select forms to assign or mark forms for removal.");
            return;
        }

        let message = "";
        if (newFormsToAssign.length > 0) message += `📝 Assign ${newFormsToAssign.length} new form(s) to ALL selected users`;
        if (newFormsToAssign.length > 0 && formsToRemoveIds.length > 0) message += " and ";
        if (formsToRemoveIds.length > 0) message += `🗑️ Remove ${formsToRemoveIds.length} form(s) from ALL selected users`;
        message += `\n\n👥 For ${selectedUsers.length} user(s).\n\nDo you want to continue?`;

        if (!confirm(message)) return;

        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = "Processing...";

        fetch("{{ route('assign.forms.ajax') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                user_ids: selectedUsers,
                form_ids: newFormsToAssign,
                remove_form_ids: formsToRemoveIds
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("✅ " + (data.message || "Operation completed successfully!"));
                location.reload();
            } else {
                alert("❌ " + (data.message || "Something went wrong."));
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        })
        .catch(err => {
            console.error("Fetch error:", err);
            alert("❌ An error occurred. Please try again.");
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        });
    });

    // Initialize DataTable
    $(document).ready(function () {
        if ($.fn.dataTable.isDataTable('#myTable')) {
            $('#myTable').DataTable().destroy();
        }
        
        $('.search-wrapper').empty();
        
        $('#myTable').DataTable({
            responsive: true,
            paging: false,
            scrollY: '400px',
            order: [[0, 'asc']],
            columns: [
                { title: "P.I. Name" },
                { title: "Department" },
                { title: "Research Title" },
                { title: "Registration Date" },
                { title: "Status" }
            ]
        });

        const dtSearch = $('#myTable_filter');
        if (dtSearch.length) {
            $('.search-wrapper').append(dtSearch);
        }
        
        validateSubmitButton();
    });
</script>

<style>
    .disabled-form {
        background-color: #d1d5db !important;
        color: #9ca3af !important;
        cursor: not-allowed !important;
        opacity: 0.5;
    }

    .disabled-form:hover {
        background-color: #d1d5db !important;
        color: #9ca3af !important;
    }
    
    .room {
        transition: all 0.2s ease;
    }
    
    .room:hover:not(.disabled-form) {
        transform: translateY(-2px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    button {
        cursor: pointer;
    }