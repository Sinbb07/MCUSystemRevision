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

        <table id="myTable" class="display border-collapse w-full shadow-sm rounded-lg">
            <thead class="bg-primary text-white text-lg/7">
                <tr class="header-table">
                    <th class="w-[25%] p-3 text-left">Research Title</th>
                    <th class="w-[20%] p-3 text-left">P.I. Name</th>
                    <th class="w-[15%] p-3 text-left">Research Protocol</th>
                    <th class="w-[15%] p-3 text-left">Type of Review</th>
                    
                    {{-- Check if ANY protocol in the collection is still 'Pending' to decide header label --}}
                    @php 
                        $hasPending = false;
                        foreach($assignedProtocols as $pid => $rs) {
                            $status = \App\Models\EvaluatedReviews::where('protocol_ID', $pid)
                                    ->where('reviewer_ID', auth()->user()->user_ID)->value('status');
                            if(!$status || $status === 'Pending') { $hasPending = true; break; }
                        }
                    @endphp

                    <th class="p-3 text-center">Forms</th>
                    {{-- Hide this header text if everything is pending to make it look like one "Action" area --}}
                    <th class="p-3 text-center">{{ $hasPending ? '' : 'Soft Copy Submission' }}</th>
                </tr>
            </thead>

            <tbody class="text-base/7">
                @foreach($assignedProtocols as $protocolId => $reviews)
                    @php
                        $firstReview = $reviews->first();
                        $myReview = \App\Models\EvaluatedReviews::where('protocol_ID', $protocolId)
                                    ->where('reviewer_ID', auth()->user()->user_ID)
                                    ->first();
                        $currentStatus = $myReview->status ?? 'Pending';
                    @endphp
                    <tr class="border-b">
                        <td class="p-3">{{ $firstReview->pi?->researchInformation?->research_title ?? 'No Title' }}</td>
                        <td class="p-3">
                            <a class="text-blue-600 underline" href="{{ route('iacuc-reviewer.submitted-documents', ['user_id' => $firstReview->protocol?->user?->user_ID]) }}">
                                {{ $firstReview->protocol?->user?->full_name ?? 'No PI Name' }}
                            </a>
                        </td>
                        <td class="p-3 font-mono text-sm">{{ $protocolId }}</td>
                        <td class="p-3">{{ $firstReview->protocol?->review_type ?? 'N/A' }}</td>

                        @if($currentStatus === 'Pending')
                            {{-- This colspan="2" removes the middle divider, effectively removing the second field --}}
                            <td colspan="2" class="p-4 bg-gray-50 border-l-4 border-yellow-500">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <span class="text-[11px] font-bold text-gray-600 uppercase">Review Invitation</span>
                                    <div class="flex gap-4">
                                        <button onclick="changeStatus('{{ $protocolId }}', 'Accepted')" 
                                            class="bg-green-600 hover:bg-green-700 text-white px-10 py-2 rounded font-bold shadow transition-all">
                                            ACCEPT
                                        </button>
                                        <button onclick="changeStatus('{{ $protocolId }}', 'Declined')" 
                                            class="bg-red-600 hover:bg-red-700 text-white px-10 py-2 rounded font-bold shadow transition-all">
                                            DECLINE
                                        </button>
                                    </div>
                                </div>
                            </td>
                        @elseif($currentStatus === 'Declined')
                            <td colspan="2" class="p-4 text-center text-red-600 italic font-bold bg-red-50">
                                Assignment Declined
                            </td>
                        @else
                            {{-- ACCEPTED: Show separated columns --}}
                            <td class="p-3 border-l">
                                @php $hasChecklistInDB = false; @endphp
                                @foreach($reviews as $review)
                                    @if($review->form?->form_type === 'Forms')
                                        @php
                                            $formCode = $review->form->form_code;
                                            $isChecklist = str_contains(strtolower($formCode), 'checklist');
                                            if($isChecklist) $hasChecklistInDB = true;
                                            
                                            // Use route() for the checklist to ensure the protocol ID is passed
                                            $url = $isChecklist 
                                                ? route('iacuc-reviewer.protocol-review-checklist', ['protocol' => $protocolId])
                                                : url($review->form->form_view);
                                        @endphp
                                        <a href="{{ $url }}" class="block mb-2">
                                            <button class="border border-black p-2 w-full text-[11px] font-bold hover:bg-black hover:text-white transition-all uppercase">
                                                {{ $formCode }}
                                            </button>
                                        </a>
                                    @endif
                                @endforeach

                                {{-- Manual backup link if the form isn't in the collection --}}
                                @if(!$hasChecklistInDB)
                                    <a href="{{ route('iacuc-reviewer.protocol-review-checklist', ['protocol' => $protocolId]) }}" class="block">
                                        <button class="border border-black p-2 w-full text-[11px] font-bold hover:bg-black hover:text-white transition-all uppercase">
                                            Protocol Review Checklist
                                        </button>
                                    </a>
                                @endif
                            </td>

                            <td class="p-3 border-l">
                                @foreach($reviews as $review)
                                    @if($review->form?->form_type === 'Submission')
                                        <a href="{{ route('iacuc-reviewer.submit-documents', ['formId' => $review->form->form_id]) }}" class="block mb-2">
                                            <button class="border border-black p-2 w-full text-[11px] font-bold hover:bg-gray-100 transition-all uppercase">
                                                Submit {{ $review->form->form_code }}
                                            </button>
                                        </a>
                                    @endif
                                @endforeach
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>

    <script>
    function changeStatus(protocolId, status) {
        if(confirm(`Are you sure you want to ${status.toLowerCase()} this review?`)) {
            fetch("{{ route('iacuc-reviewer.update-status') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ protocol_id: protocolId, status: status })
            })
            .then(response => response.json())
            .then(data => { if(data.success) location.reload(); });
        }
    }
    </script>
</x-iacuc-reviewer>