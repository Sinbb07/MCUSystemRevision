@section('title', 'Permission Control')
<x-superadmin-layout>
    <div id="roleFilterModal" onclick="outsideClick(event)"
        class="fixed inset-0 bg-black z-[9999] bg-opacity-50 hidden items-center justify-center overflow-auto overscroll-contain">
        <div class="relative flex items-center justify-center bg-white w-[400px] p-6 rounded-[10px] shadow-md">
            <form action="" class="w-full px-2">
                <div class="flex justify-between items-center mb-2">
                    <div class="text-xl font-bold">Filter</div>
                    <button type="button" onclick="closeModal('roleFilterModal')">
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
                        <label for="roleFilter">Type of Account:</label>
                        <select id="roleFilter"
                            class="w-full max-md:text-sm h-[35px] leading-[15px] max-sm:h-[31px] max-sm:leading-[11px]">
                            <option value="" selected disabled>-- Choose type --</option>
                            <option value="Superadmin">Superadmin</option>
                            <option value="System">System</option>
                            <option value="ERB Admin">ERB Admin</option>
                            <option value="ERB Reviewer">ERB Reviewer</option>
                            <option value="IACUC Admin">IACUC Admin</option>
                            <option value="IACUC Reviewer">IACUC Reviewer</option>
                            <option value="Principal Investigator">Principal Investigator</option>
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
                <button type="button" onclick="updateTable(); closeModal('roleFilterModal')"
                    class="mt-4 bg-primary text-white tracking-widest uppercase px-4 py-2 rounded">
                    Apply
                </button>
            </form>
        </div>
    </div>
    <!-- Main Content -->
    <main class="xl:ml-[335px] max-xl:ml-auto p-4 max-md:p-2">
        <h2 class="max-xl:hidden text-left bg-[#f2f2f2] shadow-lg p-[35px] rounded-[30px] font-medium text-[28px]">
            PERMISSION CONTROL
        </h2>
        <br>

        <button type="button" onclick="openModal('addUserModal')"
            class="m-auto block border-2 border-secondary px-5 py-3 max-md:px-4 max-md:py-2 bg-primary font-bold text-white max-md:text-[14px] rounded-md hover:border-primary hover:bg-secondary hover:text-primary duration-200">Add
            User
        </button>

        <!-- Modal form -->
        <div id="addUserModal" onclick="outsideClick(event)"
            class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
            <div
                class="bg-white rounded-md mt-6 px-6 py-4 border-4 border-gray max-md:mx-2 max-h-[80vh] overflow-y-auto relative max-sm:max-h-[75vh] max-sm:overflow-y-auto max-sm:relative">
                <div class="flex justify-between items-center mb-2">
                    <div class="text-xl font-bold">Add User</div>
                    <button type="button" onclick="closeModal('addUserModal')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-x-icon lucide-x">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </button>
                </div>
                <!-- Form -->
                <form method="POST" action="{{ route('superadmin.store') }}" id="modalForm">
                    @csrf
                    <!-- Full name for another user -->
                    <div class="mt-2">
                        <x-input-label for="adminName" :value="__('Full name')" />
                        <div class="flex space-x-2">
                            <!-- Last name -->
                            <div class="w-1/3">
                                <x-text-input id="adminLname"
                                    class="block mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px]" type="text"
                                    name="user_Lname" :value="old('user_Lname')" required autofocus
                                    autocomplete="user_Lname" placeholder="Last name" />
                                <x-input-error :messages="$errors->get('user_Lname')" class="mt-2" />
                            </div>
                            <!-- First name -->
                            <div class="w-1/3">
                                <x-text-input id="adminFname"
                                    class="block mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px]" type="text"
                                    name="user_Fname" :value="old('user_Fname')" required autofocus
                                    autocomplete="user_Fname" placeholder="First name" />
                                <x-input-error :messages="$errors->get('user_Fname')" />
                            </div>
                            <!-- Middle Initial -->
                            <div class="w-1/3">
                                <x-text-input id="user_MI"
                                    class="block mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px]" type="text"
                                    name="user_MI" maxlength="2" :value="old('user_MI')" required autofocus
                                    autocomplete="adminMI" placeholder="M.I." />
                                <x-input-error :messages="$errors->get('user_MI')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Classify users -->
                    <div class="mt-2">
                        <x-input-label for="user_Access" :value="__('Type of user')" />
                        <x-combobox-user-type id="user_Access" name="user_Access"
                            class="mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px] leading-[15px]" />
                        <x-input-error :messages="$errors->get('user_Access')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-2">
                        <x-input-label for="user_Email" :value="__('Email')" />
                        <x-text-input id="user_Email" class="block mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px]"
                            type="email" name="user_Email" :value="old('user_Email')" required autocomplete="username"
                            placeholder="you@example.com" />
                        <x-input-error :messages="$errors->get('user_Email')" class="mt-2" />
                    </div>

                    <!-- Button -->
                    <div class="flex justify-end">
                        <x-primary-button class="mt-4 max-sm:text-sm">
                            Submit
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>

        @if ($errors->any())
            <script>
                alert("{{ implode('\n', $errors->all()) }}");
            </script>
        @endif

        @if (session('success'))
            <script>
                alert("{{ session('success') }}");
            </script>
        @endif

        <!-- CSS NG FILTER + SEARCH BAR -->
        <div class="top-controls flex items-center justify-end max-md:flex-col">
            <div class="flex items-center max-sm:block max-sm:text-center max-md:mt-2">
                <button type="button" onclick="openModal('roleFilterModal')"
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
            <thead class="bg-primary text-white text-lg/7 max-lg:text-base/7">
                <tr class="header-table">
                    <th class="w-[20.00%]">Account Name</th>
                    <th class="w-[20.00%]">Username</th>
                    <th class="w-[20.00%]">Email</th>
                    <th class="w-[20.00%]">Role</th>
                    <th class="w-[20.00%]">Date Modified</th>
                </tr>
            </thead>
            <!-- Table body -->
            <tbody class="text-base/7 max-lg:text-sm/6">
                @foreach($users as $admin)
                    <tr data-date="{{ $admin->created_at->format('m-d-Y') }}">
                        <td>{{ $admin->user_ID }}</td>
                        <td>{{ $admin->user_Fname }} {{ $admin->user_MI ? $admin->user_MI . '.' : '' }}
                            {{ $admin->user_Lname }}
                        </td>
                        <td class="break-all">{{ $admin->user_Email }}</td>
                        <td>{{ $admin->user_Access }}</td>
                        <td>{{ $admin->created_at->format('m/d/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</x-superadmin-layout>
<script>
    const fromDate = document.getElementById('fromDate');
    const toDate = document.getElementById('toDate');
    const roleFilter = document.getElementById('roleFilter');

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        if (settings.nTable.id !== 'myTable') return true;

        const from = fromDate.value;
        const to = toDate.value;
        const role = roleFilter.value;

        const row = settings.aoData[dataIndex].nTr;
        const rowDate = row ? row.getAttribute('data-date') : '';
        const rowRoleFilter = data[3]

        if (from && rowDate < from) return false;
        if (to && rowDate > to) return false;

        if (role && rowRoleFilter !== role) return false;

        return true;
    });

    function updateTable() {
        const table = $('#myTable').DataTable();
        table.draw();
    }
</script>