@section('title', 'Research Protocol Assign')
<x-erb-reviewer>
    <main class="xl:ml-[335px] max-xl:ml-auto p-4 max-xl:p-2">
        <h2 class="max-xl:hidden text-left bg-[#f2f2f2] shadow-lg p-[35px] rounded-[30px] font-medium text-[28px]">
            RESEARCH PROTOCOL ASSIGN
        </h2>
        <br>

        <div class="top-controls">
            <div class="search-wrapper mt-1 flex max-sm:justify-center max-sm:items-center"></div>
        </div>

        <table id="myTable" class="display border-collapse w-full shadow-sm rounded-lg text-sm">
            <thead class="bg-primary text-white">
                <tr class="header-table">
                    <th class="w-[25%] p-2 text-left">Research Title</th>
                    <th class="w-[20%] p-2 text-left">P.I. Name</th>
                    <th class="w-[15%] p-2 text-left">Research Protocol</th>
                    <th class="w-[15%] p-2 text-left">Type of Review</th>
                    <th class="p-2 text-center">Action / Forms</th>
                </tr>
            </thead>

            <tbody>
                @foreach($assignedProtocols as $protocolId => $reviews)
                    @php
                        $firstReview = $reviews->first();
                        $reviewerId = auth()->user()->user_ID;

                        // Fetch the current evaluation status for this reviewer
                        $evalRecord = DB::table('tbl_evaluated_reviews')
                            ->where('protocol_ID', $protocolId)
                            ->where('reviewer_ID', $reviewerId)
                            ->first();
                        $currentStatus = $evalRecord->status ?? 'Pending';
                    @endphp
                    <tr class="border-b">
                        <td class="p-2">{{ $firstReview->pi?->researchInformation?->research_title ?? 'No Research Title' }}</td>
                        <td class="p-2">
                            <a class="text-blue-600 underline" href="{{ route('erb-reviewer.submitted-documents', ['user_id' => $firstReview->protocol?->user?->user_ID]) }}">
                                {{ $firstReview->protocol?->user?->full_name ?? 'No PI Name' }}
                            </a>
                        </td>
                        <td class="p-2 font-mono text-sm">{{ $firstReview->protocol?->protocol_ID ?? 'N/A' }}</td>
                        <td class="p-2">{{ $firstReview->protocol?->review_type ?? 'N/A' }}</td>

                        @if($currentStatus === 'Pending')
                            <td class="p-2 bg-gray-50 border-l-4 border-yellow-500">
                                <div class="flex flex-col items-center justify-center gap-1">
                                    <span class="text-[10px] font-bold text-gray-600 uppercase">Review Invitation</span>
                                    <div class="flex gap-2">
                                        <button onclick="showAcceptModal('{{ $protocolId }}')"
                                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-1 rounded font-bold shadow transition-all text-xs">
                                            ACCEPT
                                        </button>
                                        <button onclick="showDeclineModal('{{ $protocolId }}')"
                                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-1 rounded font-bold shadow transition-all text-xs">
                                            DECLINE
                                        </button>
                                    </div>
                                </div>
                            </td>

                        @elseif($currentStatus === 'Declined')
                            <td class="p-2 text-center text-red-600 italic font-bold bg-red-50 text-xs">
                                <div>
                                    Assignment Declined
                                    @if($evalRecord->decline_reason)
                                        <div class="text-xxs text-gray-500 mt-1">
                                            Reason: {{ $evalRecord->decline_reason }}
                                        </div>
                                    @endif
                                </div>
                            </td>

                        @else
                            {{-- ACCEPTED: Show Forms and Submissions in a single column --}}
                            <td class="p-2 border-l">
                                {{-- Forms Section --}}
                                <div class="mb-2">
                                    <div class="text-[10px] font-bold text-gray-600 mb-1 uppercase border-b pb-0.5">Forms to Accomplish</div>
                                    @foreach($reviews as $review)
                                        @if(is_object($review) && isset($review->form) && $review->form->form_type === 'Forms')
                                            @php
                                                $route = match($review->form->form_code) {
                                                    'FORM 2(E)' => 'form2e.edit',
                                                    'FORM 2(J)' => 'form2j.edit',
                                                    default     => null
                                                };
                                            @endphp

                                            @if($route)
                                                <a href="{{ route($route, ['protocol' => $firstReview->protocol?->protocol_ID]) }}" class="block mb-1">
                                                    <button class="border border-black p-1 w-full text-[10px] font-bold hover:bg-black hover:text-white transition-all uppercase">
                                                        {{ $review->form->form_code ?? 'N/A' }}
                                                    </button>
                                                </a>
                                            @else
                                                <span class="text-[10px] text-red-500 block mb-1">Route not defined for {{ $review->form->form_code }}</span>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>

                                {{-- Submissions Section --}}
                                <div>
                                    <div class="text-[10px] font-bold text-gray-600 mb-1 uppercase border-b pb-0.5">Soft Copy Submissions</div>
                                    @foreach($reviews as $review)
                                        @if($review->form?->form_type === 'Submission')
                                            <a href="{{ route('erb-reviewer.submit-documents', ['form' => $review->form->form_id, 'protocol_id' => $protocolId]) }}" class="block mb-1">
                                                <button class="border border-black p-1 w-full text-[10px] font-bold hover:bg-black hover:text-white transition-all uppercase">
                                                    Submit {{ $review->form->form_code ?? '' }}
                                                </button>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</x-erb-reviewer>

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
                <p class="text-xs text-gray-500 mt-2">This reason will be sent to the admin for reassignment.</p>
            </div>
            <div class="flex justify-end gap-2 px-4 py-3">
                <button onclick="closeDeclineModal()" class="px-4 py-2 bg-gray-500 text-white rounded">Cancel</button>
                <button onclick="submitDecline()" class="px-4 py-2 bg-red-600 text-white rounded">Confirm Decline</button>
            </div>
        </div>
    </div>
</div>

<script>
let currentProtocolId = null;

// Accept Modal Functions
function showAcceptModal(protocolId) {
    currentProtocolId = protocolId;
    document.getElementById('acceptProtocolId').value = protocolId;
    document.getElementById('acceptModal').classList.remove('hidden');
}

function closeAcceptModal() {
    document.getElementById('acceptModal').classList.add('hidden');
    currentProtocolId = null;
}

function submitAccept() {
    updateReviewStatus(currentProtocolId, 'Accepted', null);
    closeAcceptModal();
}

// Decline Modal Functions
function showDeclineModal(protocolId) {
    currentProtocolId = protocolId;
    document.getElementById('declineProtocolId').value = protocolId;
    document.getElementById('declineReason').value = '';
    document.getElementById('declineModal').classList.remove('hidden');
}

function closeDeclineModal() {
    document.getElementById('declineModal').classList.add('hidden');
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

// AJAX Function to update status
function updateReviewStatus(protocolId, status, declineReason) {
    const data = {
        protocol_id: protocolId,
        status: status
    };
    
    if (declineReason) {
        data.decline_reason = declineReason;
    }

    // Show loading indicator
    const acceptButtons = document.querySelectorAll('.bg-green-600');
    const declineButtons = document.querySelectorAll('.bg-red-600');
    
    if (status === 'Accepted') {
        acceptButtons.forEach(btn => btn.disabled = true);
    } else {
        declineButtons.forEach(btn => btn.disabled = true);
    }

    fetch("{{ route('erb-reviewer.update-status') }}", {
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
                : '✅ You have declined this review assignment. Admin will be notified for reassignment.');
            location.reload();
        } else {
            alert("❌ Error: " + (data.message || 'Something went wrong. Please try again.'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("❌ Something went wrong. Please try again.");
    })
    .finally(() => {
        // Re-enable buttons
        if (status === 'Accepted') {
            acceptButtons.forEach(btn => btn.disabled = false);
        } else {
            declineButtons.forEach(btn => btn.disabled = false);
        }
    });
}

$(document).ready(function () {
    // Destroy existing DataTable if it exists
    if ($.fn.dataTable.isDataTable('#myTable')) {
        $('#myTable').DataTable().destroy();
    }
    
    // Clear the search wrapper first
    $('.search-wrapper').empty();
    
    // Initialize DataTable with default settings (includes search box)
    const table = $('#myTable').DataTable({
        responsive: true,
        paging: false,
        scrollY: '400px',
        order: [[2, 'desc']],
        columns: [
            { title: "Research Title" },
            { title: "P.I. Name" },
            { title: "Research Protocol" },
            { title: "Type of Review" },
            { title: "Action / Forms" }
        ]
    });

    // Move the search box to our custom wrapper
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