@section('title', 'Research Protocol Assign')
<x-erb-reviewer>
    <main class="xl:ml-[335px] max-xl:ml-auto p-4 max-xl:p-2">
        <h2 class="max-xl:hidden text-left bg-[#f2f2f2] shadow-lg p-[35px] rounded-[30px] font-medium text-[28px]">
            RESEARCH PROTOCOL ASSIGN
        </h2>
        <br>

        <div class="top-controls">
            <div class="search-wrapper max-sm:mt-3 max-sm:justify-center max-sm:items-center"></div>
        </div>

        <table id="myTable" class="display overflow-scroll border-collapse w-full">
            <thead class="bg-primary text-white text-lg/7 max-lg:text-base/7">
                <tr class="header-table">
                    <th class="w-[20%]">Research Title</th>
                    <th class="w-[15%]">P.I. Name</th>
                    <th class="w-[15%]">Research Protocol</th>
                    <th class="w-[15%]">Type of Review</th>
                    <th class="w-[10%]">Forms</th>
                    <th class="w-[15%]">Soft Copy Submission</th>
                    <th class="w-[10%]">Decision</th> {{-- New Column --}}
                </tr>
            </thead>

            <tbody class="text-base/7 max-lg:text-sm/6">
                @foreach($assignedProtocols as $protocolId => $reviews)
                    @php
                        $firstReview = $reviews->first();
                        $reviewerId = auth()->user()->user_ID;
                        
                        // Fetch the current evaluation status for this reviewer
                        $evalRecord = DB::table('tbl_evaluated_reviews')
                            ->where('protocol_ID', $protocolId)
                            ->where('reviewer_ID', $reviewerId)
                            ->first();
                    @endphp
                    <tr>
                        <td>{{ $firstReview->pi?->researchInformation?->research_title ?? 'No Research Title' }}</td>
                        <td>
                            <a href="{{ route('erb-reviewer.submitted-documents', ['user_id' => $firstReview->protocol?->user?->user_ID]) }}">
                                {{ $firstReview->protocol?->user?->full_name ?? 'No PI Name' }}
                            </a>
                        </td>
                        <td>{{ $firstReview->protocol?->protocol_ID ?? 'N/A' }}</td>
                        <td>{{ $firstReview->protocol?->review_type ?? 'N/A' }}</td>

                        {{-- Forms --}}
                        <td>
                            @foreach($reviews as $review)
                                @if($review->form?->form_type === 'Forms')
                                    <a href="{{ route('form2e.edit', ['protocol' => $firstReview->protocol?->protocol_ID]) }}" class="block mb-2">
                                        <button class="border-2 p-[5px] hover:bg-gray">
                                            {{ $review->form->form_code ?? 'N/A' }}
                                        </button>
                                    </a>
                                @endif
                            @endforeach
                        </td>

                        {{-- Submissions --}}
                        <td>
                            @foreach($reviews as $review)
                                @if($review->form?->form_type === 'Submission')
                                    <a href="{{ route('erb-reviewer.submit-documents', ['form' => $review->form->form_id]) }}" class="block mb-2">
                                        <button class="border-2 p-[5px] hover:bg-gray">
                                            Submit {{ $review->form->form_code ?? '' }}
                                        </button>
                                    </a>
                                @endif
                            @endforeach
                        </td>

                        {{-- DECISION COLUMN LOGIC --}}
                        <td>
                            @if(!$evalRecord || $evalRecord->status === 'Pending')
                                <div class="flex flex-col gap-2">
                                    <button onclick="updateReviewStatus('{{ $protocolId }}', 'Accepted')" 
                                            class="bg-green-600 text-white px-2 py-1 rounded text-xs hover:bg-green-700 transition">
                                        Accept
                                    </button>
                                    <button onclick="updateReviewStatus('{{ $protocolId }}', 'Declined')" 
                                            class="bg-red-600 text-white px-2 py-1 rounded text-xs hover:bg-red-700 transition">
                                        Decline
                                    </button>
                                </div>
                            @else
                                <span class="font-bold px-2 py-1 rounded {{ $evalRecord->status === 'Accepted' ? 'text-green-600' : 'text-blue' }}">
                                    {{ strtoupper($evalRecord->status) }}
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</x-erb-reviewer>

<script>
    // AJAX Function to update status
    function updateReviewStatus(protocolId, status) {
        const message = status === 'Declined' 
            ? "Are you sure you want to DECLINE this protocol? This will notify the Admin to re-assign it."
            : "Are you sure you want to ACCEPT this protocol?";

        if(!confirm(message)) return;

        fetch("{{ route('erb-reviewer.update-status') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                protocol_id: protocolId,
                status: status
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert(data.message);
                location.reload(); // Refresh to update the UI and counts
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Something went wrong. Please try again.");
        });
    }

    $(document).ready(function () {
        if (!$.fn.dataTable.isDataTable('#myTable')) {
            const table = new DataTable('#myTable', {
                responsive: true,
                paging: false,
                scrollY: '400px',
                order: [[2, 'desc']] // Order by Protocol ID
            });

            const dtSearch = $('div.dt-search');
            $('.search-wrapper').append(dtSearch);
        }
    });
</script>