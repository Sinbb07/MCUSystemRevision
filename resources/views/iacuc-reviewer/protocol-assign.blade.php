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
                                        <button onclick="changeStatus('{{ $protocolId }}', 'Accepted')"
                                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-1 rounded font-bold shadow transition-all text-xs">
                                            ACCEPT
                                        </button>
                                        <button onclick="changeStatus('{{ $protocolId }}', 'Declined')"
                                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-1 rounded font-bold shadow transition-all text-xs">
                                            DECLINE
                                        </button>
                                    </div>
                                </div>
                            </td>

                        @elseif($currentStatus === 'Declined')
                            <td class="p-2 text-center text-red-600 italic font-bold bg-red-50 text-xs">
                                Assignment Declined
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
                                            <a href="{{ route('iacuc-reviewer.submit-documents', ['formId' => $review->form->form_id]) }}" class="block mb-1">
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
    function changeStatus(protocolId, status) {
        const message = status === 'Declined'
            ? "Are you sure you want to DECLINE this review? This will notify the Admin to re-assign it."
            : "Are you sure you want to ACCEPT this review?";

        if (!confirm(message)) return;

        fetch("{{ route('iacuc-reviewer.update-status') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ protocol_id: protocolId, status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(status === 'Accepted' ? 'You have accepted this review assignment.' : 'You have declined this review assignment.');
                location.reload();
            } else {
                alert("Error: " + (data.message ?? 'Something went wrong.'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Something went wrong. Please try again.");
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