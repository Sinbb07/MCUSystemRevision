@section('title', 'Research Records')
<x-superadmin-layout>
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
                    <div class="filter-box mt-4">
                        <label for="protocolTypeFilter">Protocol Type:</label>
                        <select id="protocolTypeFilter"
                            class="w-full max-md:text-sm h-[35px] leading-[15px] max-sm:h-[31px] max-sm:leading-[11px]">
                            <option value="" selected>All</option>
                            <option value="ERB">ERB</option>
                            <option value="IACUC">IACUC</option>
                        </select>
                    </div>
                    <div class="filter-box mt-4">
                        <label for="reviewTypeFilter">Review Type:</label>
                        <select id="reviewTypeFilter"
                            class="w-full max-md:text-sm h-[35px] leading-[15px] max-sm:h-[31px] max-sm:leading-[11px]">
                            <option value="" selected disabled>-- Choose type --</option>
                            <option value="Expedite">Expedite</option>
                            <option value="Full Board">Full Board</option>
                            <option value="Exempted">Exempted</option>
                        </select>
                    </div>
                    <!-- CALENDAR FILTERING -->
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
    <!-- Main Content -->
    <main class="xl:ml-[335px] max-xl:ml-auto p-4 max-md:p-2">
        <h2 class="max-xl:hidden text-left bg-[#f2f2f2] shadow-lg p-[35px] rounded-[30px] font-medium text-[28px]">
            RESEARCH RECORDS
        </h2>
        <br>

        <!-- CSS NG FILTER + SEARCH BAR -->
        <div class="top-controls flex items-center justify-end max-md:flex-col">
            <div class="flex items-center max-sm:block max-sm:text-center max-md:mt-2">
                <button type="button" onclick="openModal('filterModal')"
                    class="material-symbols-outlined bg-primary text-white p-1.5 rounded">
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
            <thead class="bg-primary text-white text-lg/7 max-sm:text-base/7">
                <tr class="header-table">
                    <th class="w-[8%]">Protocol Type</th>
                    <th class="w-[12%]">Research Title</th>
                    <th class="w-[10%]">P.I. Name</th>
                    <th class="w-[10%]">Date of Submission</th>
                    <th class="w-[10%]">Protocol No.</th>
                    <th class="w-[8%]">Review Type</th>
                    <th class="w-[10%]">Reviewer no. 1</th>
                    <th class="w-[8%]">Status of Review</th>
                    <th class="w-[10%]">Reviewer no. 2</th>
                    <th class="w-[8%]">Status of Review</th>
                    <th class="w-[6%]">Decision</th>
                </tr>
            </thead>

            <!-- Table body -->
            <tbody class="text-base/7 max-lg:text-sm/6">
                @foreach($Records as $research)
                    @php
                        // Determine if this is ERB or IACUC based on protocol
                        $firstReview = optional($research->user->initialReviews->first());
                        $protocolERB = optional($firstReview->protocol);
                        $protocolIACUC = optional($research->user->protocol);
                        
                        // Check which protocol exists and is valid
                        $isERB = $protocolERB && str_starts_with($protocolERB->protocol_ID, 'ERB');
                        $isIACUC = $protocolIACUC && str_starts_with($protocolIACUC->protocol_ID, 'IACUC');
                        
                        if ($isERB) {
                            $protocolType = 'ERB';
                            $protocol = $protocolERB;
                            $protocolId = $protocol->protocol_ID ?? 'N/A';
                            $reviewType = $protocol->review_type ?? 'N/A';
                            
                            // Get evaluated reviews from tbl_evaluated_reviews for ERB
                            $evaluatedReviews = $protocol ? $protocol->evaluatedReviews : collect();
                            
                            $reviewer1Evaluation = $evaluatedReviews->first();
                            $reviewer1 = optional($reviewer1Evaluation?->reviewer)->full_name ?? 'N/A';
                            $status1 = $reviewer1Evaluation->status ?? 'Pending';
                            
                            $reviewer2Evaluation = $evaluatedReviews->skip(1)->first();
                            $reviewer2 = optional($reviewer2Evaluation?->reviewer)->full_name ?? 'N/A';
                            $status2 = $reviewer2Evaluation->status ?? 'Pending';
                            
                            // Get decision from tbl_approved for ERB
                            $decision = optional($research->user->approved->first())->Decision ?? 'Pending';
                        } else {
                            $protocolType = 'IACUC';
                            $protocol = $protocolIACUC;
                            $protocolId = $protocol->protocol_ID ?? 'N/A';
                            $reviewType = $protocol->review_type ?? 'N/A';
                            
                            // Get evaluated reviews from tbl_evaluated_reviews for IACUC
                            $evaluatedReviews = $protocol ? $protocol->evaluatedReviews : collect();
                            
                            $reviewer1Evaluation = $evaluatedReviews->first();
                            $reviewer1 = optional($reviewer1Evaluation?->reviewer)->full_name ?? 'N/A';
                            $status1 = $reviewer1Evaluation->status ?? 'Pending';
                            
                            $reviewer2Evaluation = $evaluatedReviews->skip(1)->first();
                            $reviewer2 = optional($reviewer2Evaluation?->reviewer)->full_name ?? 'N/A';
                            $status2 = $reviewer2Evaluation->status ?? 'Pending';
                            
                            // Get decision from tbl_approved_iacuc for IACUC
                            $decision = optional($research->user->approvedIacuc)->Decision ?? 'Pending';
                        }
                        
                        $latestSubmission = $research->user->researchFiles->max('submitted_at');
                        $submissionDate = $latestSubmission ? \Carbon\Carbon::parse($latestSubmission)->format('Y-m-d') : '';
                        
                        $submissionDisplay = $latestSubmission 
                            ? \Carbon\Carbon::parse($latestSubmission)->timezone(config('app.timezone'))->format('m/d/Y') . '<br>' . 
                              \Carbon\Carbon::parse($latestSubmission)->timezone(config('app.timezone'))->format('h:i:s A')
                            : 'N/A';
                    @endphp

                    <tr data-date="{{ $submissionDate }}" data-protocol-type="{{ $protocolType }}" data-review-type="{{ $reviewType }}">
                        <!-- Protocol Type -->
                        <td>{{ $protocolType }}</td>
                        
                        <!-- Research Title -->
                        <td>{{ $research->research_title }}</td>
                        
                        <!-- P.I. Name -->
                        <td class="underline text-blue-600">
                            <a href="{{ $protocolType === 'ERB' ? route('erb.submitted-documents', $research->user->user_ID) : route('iacuc.submitted-documents', $research->user->user_ID) }}">
                                {{ $research->user->full_name }}
                            </a>
                        </td>
                        
                        <!-- Date of Submission -->
                        <td>{!! $submissionDisplay !!}</td>
                        
                        <!-- Protocol No. -->
                        <td>{{ $protocolId }}</td>
                        
                        <!-- Review Type -->
                        <td>{{ $reviewType }}</td>
                        
                        <!-- Reviewer no. 1 -->
                        <td>{{ $reviewer1 }}</td>
                        
                        <!-- Status of Review 1 -->
                        <td>{{ $status1 }}</td>
                        
                        <!-- Reviewer no. 2 -->
                        <td>{{ $reviewer2 }}</td>
                        
                        <!-- Status of Review 2 -->
                        <td>{{ $status2 }}</td>
                        
                        <!-- Decision -->
                        <td>{{ $decision }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</x-superadmin-layout>

<script>
    const fromDate = document.getElementById('fromDate');
    const toDate = document.getElementById('toDate');
    const reviewTypeFilter = document.getElementById('reviewTypeFilter');
    const protocolTypeFilter = document.getElementById('protocolTypeFilter');

    // Register DataTables filter plugin
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        if (settings.nTable.id !== 'myTable') return true;

        const from = fromDate ? fromDate.value : '';
        const to = toDate ? toDate.value : '';
        const reviewType = reviewTypeFilter ? reviewTypeFilter.value : '';
        const protocolType = protocolTypeFilter ? protocolTypeFilter.value : '';

        const row = settings.aoData[dataIndex].nTr;
        const rowDate = row ? row.getAttribute('data-date') : '';
        const rowProtocolType = row ? row.getAttribute('data-protocol-type') : '';
        const rowReviewType = data[5]; // Review Type is now at index 5

        // Date filtering
        if (from && rowDate < from) return false;
        if (to && rowDate > to) return false;

        // Protocol type filtering
        if (protocolType && rowProtocolType !== protocolType) return false;

        // Review type filtering
        if (reviewType && rowReviewType !== reviewType) return false;

        return true;
    });

    function updateTable() {
        const table = $('#myTable').DataTable();
        table.draw();
    }
</script>