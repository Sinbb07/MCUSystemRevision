@section('title', 'Protocol Decision')
<x-iacuc-layout>
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
                    <!-- FILTER BY COLUMN -->
                    <div class="filter-box mt-4">
                        <label for="filter">Filter:</label>
                        <select id="filter"
                            class="w-full max-md:text-sm h-[35px] leading-[15px] max-sm:h-[31px] max-sm:leading-[11px]">
                            <option value="" selected disabled>All</option>
                            <option value="Date Submitted">Date Submitted</option>
                            <option value="Review Date">Review Date</option>
                        </select>
                    </div>
                    <!-- CALENDAR FILTERING FOR THE COUNT OF SUBMISSION -->
                    <div class="filter-box mt-4 flex items-center gap-x-2">
                        <div>
                            <label for="fromDate">From:</label>
                            <input type="date" id="fromDate"
                                class="w-full max-md:text-sm h-[35px] text-sm max-sm:h-[31px]">
                        </div>
                        <div>
                            <label for="toDate">To:</label>
                            <input type="date" id="toDate"
                                class="w-full max-md:text-sm h-[35px] text-sm max-sm:h-[31px]">
                        </div>
                    </div>
                </div>
                <button type="button" onclick="updateTable(); closeModal('filterModal')"
                    class="mt-4 bg-primary text-white tracking-widest uppercase px-4 py-2 rounded">
                    Apply
                </button>
            </form>
        </div>
    </div>

    <!-- Accept Confirmation Modal -->
    <div id="acceptModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900">Accept Protocol Assignment</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">Are you sure you want to ACCEPT this protocol? You will be required to complete all assigned forms.</p>
                    <input type="hidden" id="acceptProtocolId">
                </div>
                <div class="flex justify-end gap-2 px-4 py-3">
                    <button onclick="closeAcceptModal()" class="px-4 py-2 bg-gray-500 text-white rounded">Cancel</button>
                    <button onclick="submitAccept()" class="px-4 py-2 bg-green-600 text-white rounded">Confirm Accept</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Decline Modal with Reason -->
    <div id="declineModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900">Decline Protocol Assignment</h3>
                <div class="mt-2 px-7 py-3">
                    <input type="hidden" id="declineProtocolId">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reason for declining:</label>
                    <textarea id="declineReason" rows="4" 
                              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 text-sm"
                              placeholder="Please provide a detailed reason for declining this protocol..."></textarea>
                    <p class="text-xs text-gray-500 mt-2">This reason will be sent to the IACUC Admin for reassignment.</p>
                </div>
                <div class="flex justify-end gap-2 px-4 py-3">
                    <button onclick="closeDeclineModal()" class="px-4 py-2 bg-gray-500 text-white rounded">Cancel</button>
                    <button onclick="submitDecline()" class="px-4 py-2 bg-red-600 text-white rounded">Confirm Decline</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main class="xl:ml-[335px] max-xl:ml-auto p-4 max-md:p-2">
        <h2 class="max-xl:hidden text-left bg-[#f2f2f2] shadow-lg p-[35px] rounded-[30px] font-medium text-[28px]">
            PROTOCOL DECISION
        </h2>
        <br>

        <!-- CSS NG FILTER + SEARCH BAR -->
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
            <!-- Table header -->
            <thead class="bg-primary text-white text-lg/7 max-lg:text-base/7">
                <tr class="header-table">
                    <th class="w-[12%]">Action</th>
                    <th class="w-[12%]">Protocol ID</th>
                    <th class="w-[16%]">Research Title</th>
                    <th class="w-[12%]">P.I. Name</th>
                    <th class="w-[12%]">Co-Investigator</th>
                    <th class="w-[10%]">Status</th>
                    <th class="w-[13%]">Date Submitted</th>
                    <th class="w-[13%]">Review Date</th>
                </tr>
            </thead>

            <!-- Table body -->
            <tbody class="text-base/7 max-lg:text-sm/6">
                @forelse($assignedProtocols ?? $evaluatedProtocols ?? [] as $review)
                    @php
                        $protocolId = is_object($review) ? ($review->protocol_ID ?? $review->protocol_id ?? null) : null;
                        $currentStatus = $review->status ?? 'Pending';
                        $declineReason = $review->decline_reason ?? null;
                    @endphp
                    <tr data-submitted="{{ $review->date_submitted ?? '' }}" data-review="{{ $review->review_date ?? '' }}">
                        <!-- Action Buttons -->
                        <td>
                            @if($currentStatus === 'Pending')
                                <div class="flex flex-col gap-1">
                                    <button onclick="showAcceptModal('{{ $protocolId }}')"
                                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-bold">
                                        ACCEPT
                                    </button>
                                    <button onclick="showDeclineModal('{{ $protocolId }}')"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-bold">
                                        DECLINE
                                    </button>
                                </div>
                            @elseif($currentStatus === 'Declined')
                                <div class="text-center">
                                    <span class="text-red-600 italic font-bold text-xs">Declined</span>
                                    @if($declineReason)
                                        <div class="text-xxs text-gray-500 mt-1">Reason: {{ $declineReason }}</div>
                                    @endif
                                </div>
                            @elseif($currentStatus === 'Accepted')
                                <div class="text-center">
                                    <span class="text-green-600 italic font-bold text-xs">Accepted</span>
                                </div>
                            @else
                                <div class="text-center">
                                    <span class="text-gray-500 text-xs">{{ $currentStatus }}</span>
                                </div>
                            @endif
                        </td>
                        
                        <!-- Protocol ID -->
                        <td>
                            <input type="checkbox" class="protocol-checkbox w-[14px] h-[14px] mb-1"
                                value="{{ $protocolId }}" data-title="{{ $review->research_title ?? '' }}"
                                @if($currentStatus !== 'Pending') disabled @endif>
                            <span>{{ $protocolId }}</span>
                        </td>

                        <!-- Research Title -->
                        <td>{{ $review->research_title ?? 'N/A' }}</td>

                        <!-- Principal Investigator Name -->
                        <td>{{ $review->user_Fname ?? '' }} {{ $review->user_Lname ?? '' }}</td>

                        <td>{{ $review->co_investigator ?? 'N/A' }}</td>

                        <!-- Status -->
                        <td>
                            @if($currentStatus === 'Pending')
                                <span class="text-yellow-600 font-semibold">Pending</span>
                            @elseif($currentStatus === 'Accepted')
                                <span class="text-green-600 font-semibold">Accepted</span>
                            @elseif($currentStatus === 'Declined')
                                <span class="text-red-600 font-semibold">Declined</span>
                            @else
                                <span>{{ $currentStatus }}</span>
                            @endif
                        </td>

                        <!-- Date Submitted -->
                        <td>
                            @if(!empty($review->date_submitted))
                                {{ \Carbon\Carbon::parse($review->date_submitted)->format('m/d/Y') }}<br>
                                {{ \Carbon\Carbon::parse($review->date_submitted)->format('h:i:s A') }}
                            @else
                                N/A
                            @endif
                        </td>

                        <!-- Review Date -->
                        <td>
                            @if(!empty($review->review_date))
                                {{ \Carbon\Carbon::parse($review->review_date)->format('m/d/Y') }}<br>
                                {{ \Carbon\Carbon::parse($review->review_date)->format('h:i:s A') }}
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-8 text-gray-500">
                            No protocols assigned to you yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Selected Protocol and Decision Section -->
        <div class="flex mx-4 gap-6 grid grid-cols-2 max-md:grid-cols-1 mt-6">
            <!-- Selected Protocol -->
            <div class="bg-lightgray p-4 shadow-md rounded-md">
                <h3 class="font-semibold text-lg max-md:text-base mb-3">SELECTED PROTOCOL</h3>
                <div class="h-24 max-md:h-16 overflow-y-auto">
                    <ul id="selectedProtocols"
                        class="list-disc pl-5 flex grid grid-cols-2 max-md:grid-cols-1 max-md:text-sm"></ul>
                </div>
            </div>

            <!-- Decision Tab -->
            <div class="bg-lightgray p-4 shadow-md rounded-md">
                <h3 class="font-semibold text-lg max-md:text-base mb-4">DECISION TAB</h3>
                <div class="flex h-24 max-md:h-16 overflow-y-auto grid grid-cols-3 max-md:grid-cols-2">
                    <div class="flex gap-x-1">
                        <input type="radio" name="decision" value="Approved" class="mt-1 w-[14px] h-[14px]">
                        <span>Approve</span>
                    </div>
                    <div class="flex gap-x-1">
                        <input type="radio" name="decision" value="Resubmission" class="mt-1 w-[14px] h-[14px]">
                        <span>Reject</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
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
let currentProtocolId = null;
let fromDate = document.getElementById('fromDate');
let toDate = document.getElementById('toDate');
let filterType = document.getElementById('filter');

// Modal functions
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

// Accept Modal Functions
function showAcceptModal(protocolId) {
    if (!protocolId) {
        alert('Error: Protocol ID not found.');
        return;
    }
    currentProtocolId = protocolId;
    document.getElementById('acceptProtocolId').value = protocolId;
    openModal('acceptModal');
}

function closeAcceptModal() {
    closeModal('acceptModal');
    currentProtocolId = null;
}

function submitAccept() {
    if (currentProtocolId) {
        updateReviewStatus(currentProtocolId, 'Accepted', null);
        closeAcceptModal();
    }
}

// Decline Modal Functions
function showDeclineModal(protocolId) {
    if (!protocolId) {
        alert('Error: Protocol ID not found.');
        return;
    }
    currentProtocolId = protocolId;
    document.getElementById('declineProtocolId').value = protocolId;
    document.getElementById('declineReason').value = '';
    openModal('declineModal');
}

function closeDeclineModal() {
    closeModal('declineModal');
    currentProtocolId = null;
}

function submitDecline() {
    const reason = document.getElementById('declineReason').value.trim();
    if (!reason) {
        alert('Please provide a reason for declining.');
        return;
    }
    
    if (reason.length < 10) {
        alert('Please provide a more detailed reason (at least 10 characters).');
        return;
    }
    
    updateReviewStatus(currentProtocolId, 'Declined', reason);
    closeDeclineModal();
}

// DataTable filter functions
$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    if (settings.nTable.id !== 'myTable') return true;

    const from = fromDate.value;
    const to = toDate.value;
    const type = filterType.value;

    if (!from && !to) return true;
    if (!type) return true;

    const row = settings.aoData[dataIndex].nTr;
    if (!row) return true;

    let rowDate = '';

    if (type === 'Date Submitted') {
        rowDate = row.getAttribute('data-submitted') || '';
    } else if (type === 'Review Date') {
        rowDate = row.getAttribute('data-review') || '';
    }

    if (!rowDate) return false;

    const date = rowDate.split(' ')[0];

    if (from && date < from) return false;
    if (to && date > to) return false;

    return true;
});

function updateTable() {
    const table = $('#myTable').DataTable();
    table.draw();
}

// AJAX Function to update status for IACUC
function updateReviewStatus(protocolId, status, declineReason) {
    const data = {
        protocol_id: protocolId,
        status: status
    };
    
    if (declineReason) {
        data.decline_reason = declineReason;
    }

    // Disable buttons for this protocol
    const row = document.querySelector(`input[value="${protocolId}"]`)?.closest('tr');
    if (row) {
        const buttons = row.querySelectorAll('button');
        buttons.forEach(btn => btn.disabled = true);
    }

    // Use the IACUC route
    const route = "{{ route('iacuc-reviewer.update-status') }}";
    
    fetch(route, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json"
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(status === 'Accepted' 
                ? '✅ You have accepted this review assignment. You can now access the forms.' 
                : '✅ You have declined this review assignment. IACUC Admin will be notified for reassignment.');
            location.reload();
        } else {
            alert("❌ Error: " + (data.message || 'Something went wrong. Please try again.'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("❌ Something went wrong. Please try again.");
    });
}

// Handle protocol selection and decision submission
const protocolCheckboxes = document.querySelectorAll(".protocol-checkbox");
const selectedProtocolsList = document.getElementById("selectedProtocols");

function updateSelectedProtocolsList() {
    const selectedCheckboxes = Array.from(protocolCheckboxes).filter(cb => cb.checked);
    
    selectedProtocolsList.innerHTML = "";

    if (selectedCheckboxes.length > 0) {
        selectedCheckboxes.forEach(checkbox => {
            const li = document.createElement("li");
            li.textContent = `Protocol ID: ${checkbox.value} — ${checkbox.dataset.title}`;
            li.setAttribute("data-protocol-id", checkbox.value);
            selectedProtocolsList.appendChild(li);
        });
    }
}

protocolCheckboxes.forEach(checkbox => {
    checkbox.addEventListener("change", () => {
        updateSelectedProtocolsList();
    });
});

// Handle decision submission for multiple protocols
document.getElementById("submitBtn").addEventListener("click", function () {
    const selectedRadio = document.querySelector('input[name="decision"]:checked');
    const selectedProtocols = Array.from(protocolCheckboxes).filter(cb => cb.checked);

    if (selectedProtocols.length === 0) {
        alert("⚠️ Please select at least one protocol first.");
        return;
    }

    if (!selectedRadio) {
        alert("⚠️ Please select a decision type.");
        return;
    }

    const decision = selectedRadio.value;
    
    if (selectedProtocols.length > 1) {
        if (!confirm(`You are about to ${decision} ${selectedProtocols.length} protocols. Do you want to continue?`)) {
            return;
        }
    }

    const submitBtn = document.getElementById("submitBtn");
    const originalText = submitBtn.textContent;
    submitBtn.textContent = "Processing...";
    submitBtn.disabled = true;

    const promises = selectedProtocols.map(checkbox => {
        return fetch("{{ route('iacuc.pending-reviews.store') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                protocol_id: checkbox.value,
                decision: decision
            }),
        }).then(response => response.json());
    });

    Promise.all(promises)
        .then(results => {
            const successCount = results.filter(r => r.success).length;
            const failCount = results.length - successCount;
            
            if (failCount === 0) {
                alert(`✅ Successfully ${decision.toLowerCase()} ${successCount} protocol(s)!`);
                
                selectedProtocols.forEach(checkbox => {
                    checkbox.closest("tr").classList.add("bg-green-100");
                    checkbox.checked = false;
                    checkbox.disabled = true;
                });
                
                if (selectedRadio) {
                    selectedRadio.checked = false;
                }
                
                selectedProtocolsList.innerHTML = '';
            } else {
                alert(`⚠️ Processed ${successCount} protocol(s) successfully, but ${failCount} failed.`);
            }
        })
        .catch(error => {
            console.error(error);
            alert("❌ Unexpected error occurred.");
        })
        .finally(() => {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        });
});

$(document).ready(function () {
    if ($.fn.dataTable.isDataTable('#myTable')) {
        $('#myTable').DataTable().destroy();
    }
    
    $('.search-wrapper').empty();
    
    const table = $('#myTable').DataTable({
        responsive: true,
        paging: false,
        scrollY: '400px',
        order: [[1, 'desc']],
        columns: [
            { title: "Action" },
            { title: "Protocol ID" },
            { title: "Research Title" },
            { title: "P.I. Name" },
            { title: "Co-Investigator" },
            { title: "Status" },
            { title: "Date Submitted" },
            { title: "Review Date" }
        ]
    });

    const dtSearch = $('#myTable_filter');
    if (dtSearch.length) {
        $('.search-wrapper').append(dtSearch);
    }
});
</script>

<style>
.text-xxs {
    font-size: 0.65rem;
}
</style>