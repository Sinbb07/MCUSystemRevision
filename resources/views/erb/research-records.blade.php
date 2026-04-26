@section('title', 'Research Records')
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
                    <!-- FILTER BY COLUMN -->
                    <div class="filter-box mt-4">
                        <label for="filter">Review Type:</label>
                        <select id="filter"
                            class="w-full max-md:text-sm h-[35px] leading-[15px] max-sm:h-[31px] max-sm:leading-[11px]">
                            <option value="" selected disabled>-- Choose type --</option>
                            <option value="Exempted">Exempted</option>
                            <option value="Full Board">Full Board</option>
                            <option value="Expedite">Expedite</option>
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
    <main class="xl:ml-[335px] max-xl:ml-auto p-4 max-md:p-2">
        <h2 class="max-xl:hidden text-left bg-[#f2f2f2] shadow-lg p-[35px] rounded-[30px] font-medium text-[28px]">
            RESEARCH RECORDS
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
            <thead class="bg-primary text-white text-lg/7 max-sm:text-base/7">
                <tr class="header-table">
                    <th class="w-[10%]">Research Title</th>
                    <th class="w-[10%]">P.I. Name</th>
                    <th class="w-[10%]">Date of Submission</th>
                    <th class="w-[10%]">Protocol No.</th>
                    <th class="w-[10%]">Review Type</th>
                    <th class="w-[10%]">Reviewer no. 1</th>
                    <th class="w-[10%]">Status of Review</th>
                    <th class="w-[10%]">Reviewer no. 2</th>
                    <th class="w-[10%]">Status of Review</th>
                    <th class="w-[10%]">Decision</th>
                </tr>
            </thead>

            <!-- Table body -->
            <tbody class="text-base/7 max-lg:text-sm/6">
                @foreach($researchRecords as $research)
                    @php
                        // Get the protocol for this research
                        $protocol = $research->user->protocol ?? null;
                        $protocolId = $protocol->protocol_ID ?? 'N/A';
                        $reviewType = $protocol->review_type ?? 'N/A';
                        
                        // Get evaluated reviews from tbl_evaluated_reviews
                        $evaluatedReviews = $protocol ? $protocol->evaluatedReviews : collect();
                        
                        // Get reviewer 1 evaluation (first reviewer)
                        $reviewer1Evaluation = $evaluatedReviews->first();
                        $reviewer1 = optional($reviewer1Evaluation?->reviewer)->full_name ?? 'N/A';
                        // Status from tbl_evaluated_reviews ('Pending', 'Accepted', 'Declined', 'Completed', 'In Progress')
                        $status1 = $reviewer1Evaluation->status ?? 'Pending';
                        
                        // Get reviewer 2 evaluation (second reviewer)
                        $reviewer2Evaluation = $evaluatedReviews->skip(1)->first();
                        $reviewer2 = optional($reviewer2Evaluation?->reviewer)->full_name ?? 'N/A';
                        $status2 = $reviewer2Evaluation->status ?? 'Pending';
                        
                        // Get decision from tbl_approved
                        $decision = optional($research->user->approved)->Decision ?? 'Pending';
                        
                        // Latest submission date from research files
                        $latestSubmission = $research->user->researchFiles->max('submitted_at');
                        $submissionDate = $latestSubmission ? \Carbon\Carbon::parse($latestSubmission)->format('Y-m-d') : '';
                        
                        // Format submission date for display
                        $submissionDisplay = $latestSubmission 
                            ? \Carbon\Carbon::parse($latestSubmission)->timezone(config('app.timezone'))->format('m/d/Y') . '<br>' . 
                              \Carbon\Carbon::parse($latestSubmission)->timezone(config('app.timezone'))->format('h:i:s A')
                            : 'N/A';
                    @endphp

                    <tr data-date="{{ $submissionDate }}" data-review-type="{{ $reviewType }}">
                        <td>{{ $research->research_title }}</td>
                        <td>
                            <a href="{{ route('erb.submitted-documents', $research->user->user_ID) }}">{{ $research->user->full_name }}</a>
                        </td>
                        <td>{!! $submissionDisplay !!}</td>
                        <td>{{ $protocolId }}</td>
                        <td class="review-type">{{ $reviewType }}</td>
                        <td>{{ $reviewer1 }}</td>
                        <td>{{ $status1 }}</td>
                        <td>{{ $reviewer2 }}</td>
                        <td>{{ $status2 }}</td>
                        <td>{{ $decision }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</x-erb-layout>

<script>
    const fromDate = document.getElementById('fromDate');
    const toDate = document.getElementById('toDate');
    const reviewTypeFilter = document.getElementById('filter');

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        if (settings.nTable.id !== 'myTable') return true;

        const from = fromDate ? fromDate.value : '';
        const to = toDate ? toDate.value : '';
        const reviewType = reviewTypeFilter ? reviewTypeFilter.value : '';

        const row = settings.aoData[dataIndex].nTr;
        const rowDate = row ? row.getAttribute('data-date') : '';
        
        // Review type is at index 4 (5th column, 0-based index)
        const rowReviewType = data[4];

        // Date filtering
        if (from && rowDate < from) return false;
        if (to && rowDate > to) return false;

        // Review type filtering
        if (reviewType && rowReviewType !== reviewType) return false;

        return true;
    });

    function updateTable() {
        const table = $('#myTable').DataTable();
        table.draw();
    }
</script>