@section('title', 'Research Protocol Assign')
<x-iacuc-reviewer>
    <main class="xl:ml-[335px] max-xl:ml-auto p-4 max-xl:p-2">
        <h2 class="max-xl:hidden text-left bg-[#f2f2f2] shadow-lg p-[35px] rounded-[30px] font-medium text-[28px]">
            RESEARCH PROTOCOL ASSIGN
        </h2>
        <br>

        <div class="top-controls">
            <div class="search-wrapper mt-1 flex max-sm:justify-center max-sm:items-center"></div>
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
                        $myReview = \App\Models\EvaluatedReviews::where('protocol_ID', $protocolId)
                                    ->where('reviewer_ID', auth()->user()->user_ID)
                                    ->first();
                        $currentStatus = $myReview->status ?? 'Pending';
                        $declineReason = $myReview->decline_reason ?? null;
                    @endphp
                    <tr class="border-b">
                        <td class="p-2">{{ $firstReview->pi?->researchInformation?->research_title ?? 'No Title' }}</td>
                        <td class="p-2">
                            <a class="text-blue-600 underline" href="{{ route('iacuc-reviewer.submitted-documents', ['user_id' => $firstReview->protocol?->user?->user_ID]) }}">
                                {{ $firstReview->protocol?->user?->full_name ?? 'No PI Name' }}
                            </a>
                        </td>
                        <td class="p-2 font-mono text-sm">{{ $protocolId }}</td>
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
                            <td class="p-2 text-center bg-red-50">
                                <div class="text-red-600 italic font-bold text-xs">Assignment Declined</div>
                                @if($declineReason)
                                    <div class="text-xs text-gray-500 mt-1">Reason: {{ $declineReason }}</div>
                                @endif
                            </td>

                        @else
                            {{-- ACCEPTED: Show Forms and Submissions in a single column --}}
                            <td class="p-2 border-l">
                                @php $hasChecklistInDB = false; @endphp
                                
                                {{-- Forms Section --}}
                                <div class="mb-2">
                                    <div class="text-[10px] font-bold text-gray-600 mb-1 uppercase border-b pb-0.5">Forms to Accomplish</div>
                                    @foreach($reviews as $review)
                                        @if($review->form?->form_type === 'Forms')
                                            @php
                                                $formCode = $review->form->form_code;
                                                $isChecklist = str_contains(strtolower($formCode), 'checklist');
                                                if($isChecklist) $hasChecklistInDB = true;

                                                $url = $isChecklist
                                                    ? route('iacuc-reviewer.protocol-review-checklist', ['protocol' => $protocolId])
                                                    : url($review->form->form_view);
                                            @endphp
                                            <a href="{{ $url }}" class="block mb-1">
                                                <button class="border border-black p-1 w-full text-[10px] font-bold hover:bg-black hover:text-white transition-all uppercase">
                                                    {{ $formCode }}
                                                </button>
                                            </a>
                                        @endif
                                    @endforeach

                                    @if(!$hasChecklistInDB)
                                        <a href="{{ route('iacuc-reviewer.protocol-review-checklist', ['protocol' => $protocolId]) }}" class="block">
                                            <button class="border border-black p-1 w-full text-[10px] font-bold hover:bg-black hover:text-white transition-all uppercase">
                                                Protocol Review Checklist
                                            </button>
                                        </a>
                                    @endif
                                </div>

                                {{-- Submissions Section --}}
                                <div>
                                    <div class="text-[10px] font-bold text-gray-600 mb-1 uppercase border-b pb-0.5">Soft Copy Submissions</div>
                                    @foreach($reviews as $review)
                                        @if($review->form?->form_type === 'Submission')
                                            <a href="{{ route('iacuc-reviewer.submit-documents', ['formId' => $review->form->form_id, 'protocol_id' => $protocolId]) }}" class="block mb-1">
                                                <button class="border border-black p-1 w-full text-[10px] font-bold hover:bg-black hover:text-white transition-all uppercase">
                                                    Submit {{ $review->form->form_code }}
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

    <script>
    let currentProtocolId = null;

    // Accept Modal Functions
    function showAcceptModal(protocolId) {
        if (!protocolId) {
            alert('Error: Protocol ID not found.');
            return;
        }
        currentProtocolId = protocolId;
        document.getElementById('acceptProtocolId').value = protocolId;
        document.getElementById('acceptModal').classList.remove('hidden');
    }

    function closeAcceptModal() {
        document.getElementById('acceptModal').classList.add('hidden');
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

    // Main function to update status
    function updateReviewStatus(protocolId, status, declineReason) {
        const data = {
            protocol_id: protocolId,
            status: status
        };
        
        if (declineReason) {
            data.decline_reason = declineReason;
        }

        // Disable buttons while processing
        const row = document.querySelector(`button[onclick*="${protocolId}"]`)?.closest('tr');
        if (row) {
            const buttons = row.querySelectorAll('button');
            buttons.forEach(btn => btn.disabled = true);
        }

        fetch("{{ route('iacuc-reviewer.update-status') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
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
                alert("❌ Error: " + (data.message ?? 'Something went wrong. Please try again.'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("❌ Something went wrong. Please try again.\n\nError: " + error.message);
        })
        .finally(() => {
            if (row) {
                const buttons = row.querySelectorAll('button');
                buttons.forEach(btn => btn.disabled = false);
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
        
        // Initialize DataTable
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
            ],
            dom: 'rt' // This removes the default search box and only shows the table
        });

        // Manually move the search box that DataTables creates
        const dtSearch = $('#myTable_filter');
        if (dtSearch.length) {
            $('.search-wrapper').append(dtSearch);
        }
    });
    </script>
</x-iacuc-reviewer>