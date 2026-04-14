@section('title', 'Assigned Forms')
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
                        <label for="filter">Filter:</label>
                        <select id="filter"
                            class="w-full max-md:text-sm h-[35px] leading-[15px] max-sm:h-[31px] max-sm:leading-[11px]">
                            <option value="" selected disabled>All</option>
                            <option value="Date Registered">Date Registered</option>
                            <option value="Assigned Date">Assigned Date</option>
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
    <!-- Main Content -->
    <main class="xl:ml-[335px] max-xl:ml-auto p-4 max-md:p-2">
        <h2 class="max-xl:hidden text-left bg-[#f2f2f2] shadow-lg p-[35px] rounded-[30px] font-medium text-[28px]">
            ASSIGNED FORMS
        </h2>
        <br>

        <!-- CSS NG FILTER + SEARCH BAR -->
        <div class="top-controls flex items-center justify-between max-md:flex-col">
            <!-- FUNCTIONALITY TO DISPLAY THE DATAS BASED ON DATE -->
            <div class="filter-box">
                Total Submission Count:
                <span class="font-bold" id="submissionCount"></span>
            </div>
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
                    <th class="w-[25%]">P.I. Name</th>
                    <th class="w-[25%]">Date Registered</th>
                    <th class="w-[25%]">Assigned Forms</th> <!-- New column -->
                    <th class="w-[25%]">Assigned Date/Time</th> <!-- New column -->
                </tr>
            </thead>
            <tbody class="text-base/7 max-lg:text-sm/6">
                @foreach($approvedAccounts as $user)
                    <tr data-user-id="{{ $user->user_ID }}" data-date="{{ optional($user->created_at)->format('Y-m-d') }}"
                        data-assigned-date="{{ $user->forms && $user->forms->count() > 0 ? optional($user->forms->max(fn($form) => $form->pivot->created_at))->format('Y-m-d') : '' }}">
                        <td>{{ $user->user_Fname }} {{ $user->user_MI ? $user->user_MI : '' }} {{ $user->user_Lname }}</td>
                        <td>{{ optional($user->created_at)->format('m/d/Y h:i:s A') }}</td>
                        <td>
                            @if($user->forms && $user->forms->count() > 0)
                                <ul class="list-disc pl-5">
                                    @foreach($user->forms as $form)
                                        <li>{{ $form->form_code }}</li>
                                    @endforeach
                                </ul>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            @if($user->forms && $user->forms->count() > 0)
                                @php
                                    // Get the latest timestamp from pivot table
                                    $latestTimestamp = $user->forms->max(function ($form) {
                                        return $form->pivot->created_at;
                                    });
                                @endphp
                                {{ $latestTimestamp ? \Carbon\Carbon::parse($latestTimestamp)->format('m/d/Y h:i:s A') : 'N/A' }}
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</x-erb-layout>
<script>
    const fromDate = document.getElementById('fromDate');
    const toDate = document.getElementById('toDate');
    const filterType = document.getElementById('filter');
    const countSpan = document.getElementById('submissionCount');

    // ✅ Register DataTables filter plugin BEFORE table initializes
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

        if (type === 'Assigned Date') {
            rowDate = row.getAttribute('data-assigned-date') || '';
        } else if (type === 'Date Registered') {
            rowDate = row.getAttribute('data-date') || '';
        }

        if (!rowDate) return false;

        const date = rowDate.split(' ')[0]; // strip time

        if (from && date < from) return false;
        if (to && date > to) return false;

        return true;
    });

    function updateTable() {
        const table = $('#myTable').DataTable();
        table.draw();
        countSpan.textContent = table.rows({ search: 'applied' }).count();
    }

    // ✅ Set initial count after DataTables is ready
    $(document).ready(function () {
        countSpan.textContent = $('#myTable').DataTable().rows().count();
    });
</script>