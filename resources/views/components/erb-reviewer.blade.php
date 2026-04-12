<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Default title')</title>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Fonts and Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
    <!-- Browser Tab Icon -->
    <link rel="icon" href="{{ asset('images/mcu-logo.png') }}" type="image/x-icon">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.5/css/responsive.dataTables.css">

    <!-- DataTables and jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.5/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.5/js/responsive.dataTables.js"></script>
</head>

<body>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('erb-reviewer.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <script>
        $(document).ready(function () {
            // Only initialize if not already initialized
            if (!$.fn.dataTable.isDataTable('#myTable')) {
                const table = new DataTable('#myTable', {
                    responsive: true,
                    paging: true,
                    scrollY: '350px',
                    order: [],
                    // Tell DataTables not to auto-detect data sources
                    deferRender: true,
                    // Use the existing HTML as-is
                    columnDefs: [
                        { targets: '_all', defaultContent: '' }
                    ]
                });

                // ✅ Move the DataTables search bar into our custom search-wrapper
                const dtSearch = $('div.dt-search');
                $('.search-wrapper').append(dtSearch);
            }
        });

        document.addEventListener("DOMContentLoaded", () => {
            const radios = document.querySelectorAll("input[type=radio]");

            radios.forEach(radio => {
                radio.addEventListener("change", () => {
                    const groupName = radio.name;

                    // Disable all textboxes/textarea in this group
                    document.querySelectorAll(`[data-group='${groupName}']`).forEach(el => {
                        el.disabled = true;
                        el.value = ""; // optional reset (mawawala ung iniinput mo pag clinick mo ung ibang choices hehez)
                    });

                    // Enable the target linked to this radio (if any)
                    if (radio.dataset.textbox) {
                        const target = document.getElementById(radio.dataset.textbox);
                        if (target) {
                            target.disabled = false;
                            target.focus();
                        }
                    }
                });
            });

            // Auto-check radio when user types in a linked input/textarea
            document.querySelectorAll("input[type=text][id], textarea[id]").forEach(el => {
                el.addEventListener("input", () => {
                    const linkedRadio = document.querySelector(`input[type=radio][data-textbox='${el.id}']`);
                    if (linkedRadio) linkedRadio.checked = true;
                });
            });
        });

        // TOGGLE SIDEBAR
        const sidebar = document.getElementById('sidebar');
        const menuBtn = document.getElementById('menuBtn');

        menuBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            sidebar.classList.toggle('-translate-x-full');
        });

        document.addEventListener('click', function (e) {
            if (!sidebar.contains(e.target)) {
                sidebar.classList.add('-translate-x-full');
            }
        });

        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function outsideClick(event) {
            if (event.target.id === 'filterModal') {

                // PREVENTS TO CLOSE SIDEBAR
                event.stopPropagation();
                event.currentTarget.classList.add('hidden');
                event.currentTarget.classList.remove('flex');
            }
        }
    </script>
</body>

</html>