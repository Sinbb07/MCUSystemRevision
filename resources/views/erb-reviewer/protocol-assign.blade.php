@section('title', 'Research Protocol Assign')
<x-erb-reviewer>
    <main class="xl:ml-[335px] max-xl:ml-auto p-4 max-xl:p-2">
        <h2 class="max-xl:hidden text-left bg-[#f2f2f2] shadow-lg p-[35px] rounded-[30px] font-medium text-[28px]">
            RESEARCH PROTOCOL ASSIGN
        </h2>
        <br>

        <!-- CSS NG FILTER + SEARCH BAR -->
        <div class="top-controls">
            <div class="search-wrapper max-sm:mt-3 max-sm:justify-center max-sm:items-center"></div>
        </div>

        <table id="myTable" class="display overflow-scroll border-collapse w-full">
            <thead class="bg-primary text-white text-lg/7 max-lg:text-base/7">
                <tr class="header-table">
                    <th class="w-[25%]">Research Title</th>
                    <th class="w-[20%]">P.I. Name</th>
                    <th class="w-[15%]">Research Protocol</th>
                    <th class="w-[15%]">Type of Review</th>
                    <th class="w-[10%]">Forms</th>
                    <th class="w-[10%]">Soft Copy Submission</th>
                </tr>
            </thead>

            <tbody class="text-base/7 max-lg:text-sm/6">
                @foreach($assignedProtocols as $protocolId => $reviews)
                    @php
                        $firstReview = $reviews->first();
                    @endphp
                    <tr>
                        <td>{{ $firstReview->pi?->researchInformation?->research_title ?? 'No Research Title' }}</td>
                        <td>
                            <a
                                href="{{ route('erb-reviewer.submitted-documents', ['user_id' => $firstReview->protocol?->user?->user_ID]) }}">
                                {{ $firstReview->protocol?->user?->full_name ?? 'No PI Name' }}
                            </a>
                        </td>
                        <td>{{ $firstReview->protocol?->protocol_ID ?? 'N/A' }}</td>
                        <td>{{ $firstReview->protocol?->review_type ?? 'N/A' }}</td>

                        {{-- Forms --}}
                        <td>
                            @foreach($reviews as $review)
                                @if($review->form?->form_type === 'Forms')
                                    <a href="{{ url($review->form->form_view) }}" class="block mb-2">
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
                                    <a href="{{ route('erb-reviewer.submit-documents', ['form' => $review->form->form_id]) }}"
                                        class="block mb-2">
                                        <button class="border-2 p-[5px] hover:bg-gray">
                                            Submit {{ $review->form->form_code ?? '' }}
                                        </button>
                                    </a>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</x-erb-reviewer>
<script>
    $(document).ready(function () {
        // Only initialize if not already initialized
        if (!$.fn.dataTable.isDataTable('#myTable')) {
            const table = new DataTable('#myTable', {
                responsive: true,
                paging: false,
                scrollY: '300px',
                order: [[0, 'asc']]
            });

            // ✅ Move the DataTables search bar into our custom search-wrapper
            const dtSearch = $('div.dt-search');
            $('.search-wrapper').append(dtSearch);

            // ✅ Build dropdown filter dynamically
            const offices = [...new Set(table.column(1).data().toArray())].sort();
            const select = $('#officeFilter');
            offices.forEach(o => select.append(`<option value="${o}">${o}</option>`));

            // ✅ Apply filter to Office column
            select.on('change', function () {
                const val = $.fn.dataTable.util.escapeRegex($(this).val());
                table.column(1).search(val ? '^' + val + '$' : '', true, false).draw();
            });
        }
    });
</script>