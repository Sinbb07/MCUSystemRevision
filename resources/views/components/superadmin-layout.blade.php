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
        @include('superadmin.navigation')

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

        dropDownMenu();

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

        function dropDownMenu() {
            const toggles = document.querySelectorAll('.dropdownToggle');

            toggles.forEach(toggle => {
                const menu = toggle.nextElementSibling;
                const arrow = toggle.querySelector('.dropdownArrow');

                toggle.addEventListener('click', (e) => {
                    e.stopPropagation();

                    const isHidden = menu.classList.contains('hidden');

                    if (isHidden) {
                        menu.classList.remove('hidden');
                        setTimeout(() => {
                            menu.classList.remove('opacity-0');
                        }); // small delay to trigger transition
                    } else {
                        menu.classList.add('opacity-0');
                        setTimeout(() => {
                            menu.classList.add('hidden');
                        }); // match the transition duration
                    }

                    arrow.classList.toggle('rotate-180');
                });
            });

            document.addEventListener('click', () => {
                toggles.forEach(toggle => {
                    const menu = toggle.nextElementSibling;
                    const arrow = toggle.querySelector('.dropdownArrow');

                    menu.classList.add('opacity-0');
                    setTimeout(() => {
                        menu.classList.add('hidden');
                    }, 300);
                    arrow.classList.remove('rotate-180');
                });
            });
        }
        document.addEventListener('click', function (e) {
            const sidebar = document.getElementById('sidebar');
            const isModalOpen = !document.getElementById('editProfileModal').classList.contains('hidden') ||
                !document.getElementById('changePasswordModal').classList.contains('hidden');

            // WHEN THE MODAL IS OPEN
            if (isModalOpen) return;

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