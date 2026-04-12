@section('title', 'Protocol Decision')
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
    <!-- Main Content -->
    <main class="xl:ml-[335px] max-xl:ml-auto p-4 max-md:p-2">
        <h2 class="max-xl:hidden text-left bg-[#f2f2f2] shadow-lg p-[35px] rounded-[30px] font-medium text-[28px]">
            PROTOCOL DECISION
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
                <button type="button" onclick="openModal('filterModal')"
                    class="material-symbols-outlined bg-primary text-white p-1.5 rounded">filter_alt</button>
                <div class="search-wrapper max-sm:mt-3 max-sm:justify-center max-sm:items-center"></div>
            </div>
        </div>

        <table id="myTable" class="display overflow-w-scroll border-collapse w-full">
            <!-- Table header -->
            <thead class="bg-primary text-white text-lg/7 max-lg:text-base/7">
                <tr class="header-table">
                    <th class="w-[14.28%]">Protocol ID</th>
                    <th class="w-[14.28%]">Research Title</th>
                    <th class="w-[14.28%]">P.I. Name</th>
                    <th class="w-[14.28%]">Co-Investigator</th>
                    <th class="w-[14.28%]">Status</th>
                    <th class="w-[14.28%]">Date Submitted</th>
                    <th class="w-[14.28%]">Review Date</th>
                </tr>
            </thead>

            <!-- Table body -->
            <tbody class="text-base/7 max-lg:text-sm/6">
                @forelse($evaluatedProtocols as $review)
                    <tr data-submitted="{{ $review->date_submitted }}" data-review="{{ $review->review_date }}">
                        <!-- Protocol ID with checkbox (moved to first column) -->
                        <td>
                            <input type="checkbox" class="protocol-checkbox w-[14px] h-[14px] mb-1"
                                value="{{ $review->protocol_ID }}" data-title="{{ $review->research_title }}">
                            <span>{{ $review->protocol_ID }}</span>
                        </td>

                        <!-- Research Title -->
                        <td>{{ $review->research_title }}</td>

                        <!-- Principal Investigator Name -->
                        <td>{{ $review->user_Fname }}</td>

                        <td>{{ $review->co_investigator }}</td>

                        <!-- Status -->
                        <td>{{ $review->status ?? 'Pending' }}</td>

                        <!-- Date Submitted -->
                        <td>
                            @if($review->date_submitted)
                                {{ \Carbon\Carbon::parse($review->date_submitted)->format('m/d/Y') }}<br>
                                {{ \Carbon\Carbon::parse($review->date_submitted)->format('h:i:s A') }}
                            @else
                                N/A
                            @endif
                        </td>

                        <!-- Review Date -->
                        <td>
                            @if($review->review_date)
                                {{ \Carbon\Carbon::parse($review->review_date)->format('m/d/Y') }}<br>
                                {{ \Carbon\Carbon::parse($review->review_date)->format('h:i:s A') }}
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @empty
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
                        <input type="radio" name="decision" value="Resubmission" class="mt-1 w-[14px] h-[14px]">
                        <span>Resubmission</span>
                    </div>
                    <div class="flex gap-x-1">
                        <input type="radio" name="decision" value="Approved" class="mt-1 w-[14px] h-[14px]">
                        <span>Approved</span>
                    </div>
                </div>
            </div>
            <div class="flex justify-start mt-4 mx-4">
                <button id="submitBtn"
                    class="bg-secondary hover:bg-primary text-primary hover:text-secondary px-4 py-3 rounded-md uppercase tracking-widest duration-200"
                    type="button">
                    Submit
                </button>
            </div>
        </div>
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

        if (type === 'Date Submitted') {
            rowDate = row.getAttribute('data-submitted') || '';
        } else if (type === 'Review Date') {
            rowDate = row.getAttribute('data-review') || '';
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

    // ✅ Keep your checkbox logic (only one can be selected)
    const protocolCheckboxes = document.querySelectorAll(".protocol-checkbox");
    const selectedProtocolsList = document.getElementById("selectedProtocols");

    protocolCheckboxes.forEach(checkbox => {
        checkbox.addEventListener("change", () => {
            // Allow only one protocol selection at a time
            protocolCheckboxes.forEach(cb => {
                if (cb !== checkbox) cb.checked = false;
            });

            selectedProtocolsList.innerHTML = "";

            if (checkbox.checked) {
                const li = document.createElement("li");
                li.textContent = `Protocol ID: ${checkbox.value} — ${checkbox.dataset.title}`;
                li.setAttribute("data-protocol-id", checkbox.value);
                selectedProtocolsList.appendChild(li);
            }
        });
    });

    // ✅ Handle decision submission
    document.getElementById("submitBtn").addEventListener("click", function () {
        const selectedRadio = document.querySelector('input[name="decision"]:checked');
        const selectedProtocol = document.querySelector(".protocol-checkbox:checked");

        if (!selectedProtocol) {
            alert("⚠️ Please select a protocol first.");
            return;
        }

        if (!selectedRadio) {
            alert("⚠️ Please select a decision type.");
            return;
        }

        const decision = selectedRadio.value;
        const protocolID = selectedProtocol.value;

        fetch("{{ route('erb.pending-reviews.store') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                protocol_id: protocolID,
                decision: decision
            }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("✅ " + data.message);
                    selectedProtocol.closest("tr").classList.add("bg-green-100");
                    selectedProtocol.checked = false;
                    document.querySelector('input[name="decision"]:checked').checked = false;
                    selectedProtocolsList.innerHTML = '';
                } else {
                    alert("❌ " + (data.message || "An error occurred."));
                }
            })
            .catch(error => {
                console.error(error);
                alert("❌ Unexpected error occurred.");
            });
    });
</script>