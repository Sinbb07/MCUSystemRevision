<nav class="bg-primary h-screen text-white fixed top-0 left-0 hidden xl:flex xl:flex-col overflow-y-auto w-[335px]">
    <header
        class="hidden lg:flex justify-center bg-primary align-center p-2 overflow-hidden overscroll-contain border-darkergray border-b">
        <img src="{{ asset('images/mcu-logo-white.png') }}" alt="STUDENT MAS BAGO" class="w-44">
    </header>
    <div
        class="sidebar overflow-y-auto overscroll-contain px-0 flex-1 bg-primary [&::-webkit-scrollbar]:w-[4px] [&::-webkit-scrollbar-thumb]:bg-[#666666]">
        <ul class="m-4 text-lg p-0 bg-primary">
            <li>
                <a href="{{ url('/erb/dashboard') }}" class="w-full flex items-center px-2 py-3 border-none no-underline gap-x-3 hover:text-secondary transition-all duration-300 
                    {{ Request::is('erb/dashboard') ? 'text-secondary' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard">
                        <rect width="7" height="9" x="3" y="3" rx="1" />
                        <rect width="7" height="5" x="14" y="3" rx="1" />
                        <rect width="7" height="9" x="14" y="12" rx="1" />
                        <rect width="7" height="5" x="3" y="16" rx="1" />
                    </svg>
                    Dashboard
                </a>
            </li>
            <li>
                <button
                    class="dropdownToggle w-full flex items-center px-2 py-3 border-none gap-x-3 hover:text-secondary transition-all duration-300 
                    {{ Request::is('erb/view-reviews') ? 'text-secondary' : '' }} {{ Request::is('erb/assign-reviewer') || Request::is('erb/view-review-files/*/*') || Request::is('erb/full-board-review') ? 'text-secondary' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-file-search-corner-icon lucide-file-search-corner">
                        <path
                            d="M11.1 22H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.589 3.588A2.4 2.4 0 0 1 20 8v3.25" />
                        <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                        <path d="m21 22-2.88-2.88" />
                        <circle cx="16" cy="17" r="3" />
                    </svg>
                    <span class="mr-auto">View Documents</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-chevron-down-icon lucide-chevron-down dropdownArrow transition-transform">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </button>
                <ul class="dropdownMenu ml-1 mt-1 hidden pl-5 w-full">
                    <li>
                        <a href="{{ url('/erb/view-reviews') }}"
                            class="block hover:text-secondary duration-200 px-2 py-1.5 flex
                            {{ Request::is('erb/view-reviews') || Request::is('erb/view-review-files/*/*') ? 'text-secondary' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-file-check-corner-icon lucide-file-check-corner">
                                <path
                                    d="M10.5 22H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.588 3.588A2.4 2.4 0 0 1 20 8v6" />
                                <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                                <path d="m14 20 2 2 4-4" />
                            </svg>
                            <span class="w-full flex justify-between items-center px-3">
                                View Reviews
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/erb/assign-reviewer') }}" class="block hover:text-secondary duration-200 px-2 py-1.5 flex
                            {{ Request::is('erb/assign-reviewer') ? 'text-secondary' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-notebook-pen-icon lucide-notebook-pen">
                                <path d="M13.4 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7.4" />
                                <path d="M2 6h4" />
                                <path d="M2 10h4" />
                                <path d="M2 14h4" />
                                <path d="M2 18h4" />
                                <path
                                    d="M21.378 5.626a1 1 0 1 0-3.004-3.004l-5.01 5.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                            </svg>
                            <span class="w-full flex justify-between items-center px-3">
                                Assign Reviewer
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/erb/full-board-review') }}" class="block hover:text-secondary duration-200 px-2 py-1.5 flex
                            {{ Request::is('erb/full-board-review') ? 'text-secondary' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-users-icon lucide-users">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                <circle cx="9" cy="7" r="4" />
                            </svg>
                            <span class="w-full flex justify-between items-center px-3">
                                Full Board Review
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="{{ url('/erb/iro-approved-accounts') }}" class="w-full flex items-center px-2 py-3 border-none no-underline gap-x-3 hover:text-secondary transition-all duration-300 
                    {{ Request::is('erb/iro-approved-accounts') ? 'text-secondary' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-user-round-cog-icon lucide-user-round-cog">
                        <path d="m14.305 19.53.923-.382" />
                        <path d="m15.228 16.852-.923-.383" />
                        <path d="m16.852 15.228-.383-.923" />
                        <path d="m16.852 20.772-.383.924" />
                        <path d="m19.148 15.228.383-.923" />
                        <path d="m19.53 21.696-.382-.924" />
                        <path d="M2 21a8 8 0 0 1 10.434-7.62" />
                        <path d="m20.772 16.852.924-.383" />
                        <path d="m20.772 19.148.924.383" />
                        <circle cx="10" cy="8" r="5" />
                        <circle cx="18" cy="18" r="3" />
                    </svg>
                    IRO Approved Accounts
                </a>
            </li>
            <li>
                <a href="{{ url('/erb/research-records') }}"
                    class="w-full flex items-center px-2 py-3 border-none no-underline gap-x-3 hover:text-secondary transition-all duration-300 
                    {{ Request::is('erb/research-records') || Request::is('erb/submitted-documents/*') ? 'text-secondary' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-database-icon lucide-database">
                        <ellipse cx="12" cy="5" rx="9" ry="3" />
                        <path d="M3 5V19A9 3 0 0 0 21 19V5" />
                        <path d="M3 12A9 3 0 0 0 21 12" />
                    </svg>
                    Research Records
                </a>
            </li>

            <li>
                <a href="{{ url('/erb/assigned-forms') }}" class="w-full flex items-center px-2 py-3 border-none no-underline gap-x-3 hover:text-secondary transition-all duration-300 
                    {{ Request::is('erb/assigned-forms') ? 'text-secondary' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-folder-pen-icon lucide-folder-pen">
                        <path
                            d="M2 11.5V5a2 2 0 0 1 2-2h3.9c.7 0 1.3.3 1.7.9l.8 1.2c.4.6 1 .9 1.7.9H20a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-9.5" />
                        <path
                            d="M11.378 13.626a1 1 0 1 0-3.004-3.004l-5.01 5.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                    </svg>
                    Assigned Forms
                </a>
            </li>
            <li>
                <a href="{{ url('/erb/protocol-decision') }}" class="w-full flex items-center px-2 py-3 border-none no-underline gap-x-3 hover:text-secondary transition-all duration-300 
                    {{ Request::is('erb/protocol-decision') ? 'text-secondary' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-file-user-icon lucide-file-user">
                        <path
                            d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                        <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                        <path d="M16 22a4 4 0 0 0-8 0" />
                        <circle cx="12" cy="15" r="3" />
                    </svg>
                    Protocol Decision
                </a>
            </li>
            <li>
                <a href="{{ url('/erb/submitted-tickets') }}" class="w-full flex items-center px-2 py-3 border-none no-underline gap-x-3 hover:text-secondary transition-all duration-300 
                    {{ Request::is('erb/submitted-tickets') || Request::is('erb/tickets/*') ? 'text-secondary' : ''}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-folder-kanban-icon lucide-folder-kanban">
                        <path
                            d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z" />
                        <path d="M8 10v4" />
                        <path d="M12 10v2" />
                        <path d="M16 10v6" />
                    </svg>
                    Submitted Inquiries
                </a>
            </li>
            <li>
                <a href="{{ url('/erb/resubmission') }}" class="w-full flex items-center px-2 py-3 border-none no-underline gap-x-3 hover:text-secondary transition-all duration-300 
                    {{ Request::is('erb/resubmission') ? 'text-secondary' : ''}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-folder-pen-icon lucide-folder-pen">
                        <path
                            d="M2 11.5V5a2 2 0 0 1 2-2h3.9c.7 0 1.3.3 1.7.9l.8 1.2c.4.6 1 .9 1.7.9H20a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-9.5" />
                        <path
                            d="M11.378 13.626a1 1 0 1 0-3.004-3.004l-5.01 5.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                    </svg>
                    Resubmission
                </a>
            </li>
            <li>
                <a href="{{ url('/erb/monitoring-process') }}" class="w-full flex items-center px-2 py-3 border-none no-underline gap-x-3 hover:text-secondary transition-all duration-300 
                    {{ Request::is('erb/monitoring-process') ? 'text-secondary' : ''}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-monitor-cloud-icon lucide-monitor-cloud">
                        <path d="M11 13a3 3 0 1 1 2.83-4H14a2 2 0 0 1 0 4z" />
                        <path d="M12 17v4" />
                        <path d="M8 21h8" />
                        <rect x="2" y="3" width="20" height="14" rx="2" />
                    </svg>
                    Process Monitoring
                </a>
            </li>
            <li>
                <a href="{{ url('/erb/final-completion') }}" class="w-full flex items-center px-2 py-3 border-none no-underline gap-x-3 hover:text-secondary transition-all duration-300 
                    {{ Request::is('erb/final-completion') ? 'text-secondary' : ''}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-user-check-icon lucide-user-check">
                        <path d="m16 11 2 2 4-4" />
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                    </svg>
                    Final Completion
                </a>
            </li>
        </ul>
    </div>
    <footer class="flex items-center px-3 py-3 border-darkergray border-t">
        <div class="flex items-center">
            <img src="{{ asset('images/profile-white.png') }}" alt="PFP" class="w-[45px] h-[45px] rounded-[50%] mx-1">
            <div>
                <div class="whitespace-nowrap">
                    {{ Auth::user()->user_Fname }} {{ Auth::user()->user_MI }} {{ Auth::user()->user_Lname }}
                </div>
                <div class="whitespace-nowrap text-sm">ERB Admin</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="duration-200 hover:text-secondary p-0 m-0 bg-transparent border-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-log-out-icon lucide-log-out text-2xl absolute right-4 bottom-[10px] -translate-y-[50%]">
                        <path d="m16 17 5-5-5-5" />
                        <path d="M21 12H9" />
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    </svg>
                </button>
            </form>
        </div>
    </footer>
</nav>

<div id="sidebar"
    class="fixed top-0 left-0 h-full w-[310px] bg-primary xl:hidden shadow transform -translate-x-full transition-transform duration-300 z-[999]">
    <nav
        class="bg-primary h-[100vh] text-white fixed top-0 left-0 max-xl:flex max-xl:flex-col overflow-y-auto w-[310px]">
        <header
            class="flex justify-center items-center p-2 overflow-hidden border-darkergray border-b h-[90px] max-sm:h-[80px]">
            <img src="{{ asset('images/mcu-logo-white.png') }}" alt="ERB MAS BAGO"
                class="w-[160px] h-[55px] max-sm:w-[140px] max-sm:h-[50px]">
        </header>
        <div class="overflow-auto overscroll-contain flex-1">
            <ul class="m-2 p-0 bg-primary">
                <li>
                    <a href="{{ url('/erb/dashboard') }}" class="flex items-center max-sm:text-[15px] px-2 py-3 max-sm:py-2.5 border-0 no-underline gap-x-2 cursor-pointer transition-all duration-300 hover:text-secondary 
                        {{ Request::is('erb/dashboard') ? 'text-secondary' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard">
                            <rect width="7" height="9" x="3" y="3" rx="1" />
                            <rect width="7" height="5" x="14" y="3" rx="1" />
                            <rect width="7" height="9" x="14" y="12" rx="1" />
                            <rect width="7" height="5" x="3" y="16" rx="1" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <button
                        class="dropdownToggle w-full flex items-center px-2 py-3 border-none gap-x-2 hover:text-secondary transition-all duration-300 text-[15px]
                        {{ Request::is('erb/view-reviews') ? 'text-secondary' : '' }} {{ Request::is('erb/assign-reviewer') || Request::is('erb/full-board-review') ? 'text-secondary' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-file-search-corner-icon lucide-file-search-corner">
                            <path
                                d="M11.1 22H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.589 3.588A2.4 2.4 0 0 1 20 8v3.25" />
                            <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                            <path d="m21 22-2.88-2.88" />
                            <circle cx="16" cy="17" r="3" />
                        </svg>
                        <span class="mr-auto">View Documents</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-chevron-down-icon lucide-chevron-down dropdownArrow transition-transform">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                    </button>
                    <ul class="dropdownMenu ml-1 mt-1 hidden pl-5 w-full">
                        <li>
                            <a href="{{ url('/erb/view-reviews') }}"
                                class="block hover:text-secondary duration-200 px-2 py-1.5 flex
                                {{ Request::is('erb/view-reviews') || Request::is('erb/erb/view-review-files/*') ? 'text-secondary' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="lucide lucide-file-check-corner-icon lucide-file-check-corner">
                                    <path
                                        d="M10.5 22H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.588 3.588A2.4 2.4 0 0 1 20 8v6" />
                                    <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                                    <path d="m14 20 2 2 4-4" />
                                </svg>
                                <span class="w-full flex justify-between items-center px-3">
                                    View Reviews
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/erb/assign-reviewer') }}" class="block hover:text-secondary duration-200 px-2 py-1.5 flex
                                {{ Request::is('erb/assign-reviewer') ? 'text-secondary' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-notebook-pen-icon lucide-notebook-pen">
                                    <path d="M13.4 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7.4" />
                                    <path d="M2 6h4" />
                                    <path d="M2 10h4" />
                                    <path d="M2 14h4" />
                                    <path d="M2 18h4" />
                                    <path
                                        d="M21.378 5.626a1 1 0 1 0-3.004-3.004l-5.01 5.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                                </svg>
                                <span class="w-full flex justify-between items-center px-3">
                                    Assign Reviewer
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/erb/full-board-review') }}" class="block hover:text-secondary duration-200 px-2 py-1.5 flex
                                {{ Request::is('erb/full-board-review') ? 'text-secondary' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-users-icon lucide-users">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                    <path d="M16 3.128a4 4 0 0 1 0 7.744" />
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                    <circle cx="9" cy="7" r="4" />
                                </svg>
                                <span class="w-full flex justify-between items-center px-3">
                                    Full Board Review
                                </span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ url('/erb/iro-approved-accounts') }}" class="flex items-center max-sm:text-[15px] px-2 py-3 max-sm:py-2.5 border-0 no-underline gap-x-2 cursor-pointer transition-all duration-300 hover:text-secondary 
                        {{ Request::is('erb/iro-approved-accounts') ? 'text-secondary' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-user-round-cog-icon lucide-user-round-cog">
                            <path d="m14.305 19.53.923-.382" />
                            <path d="m15.228 16.852-.923-.383" />
                            <path d="m16.852 15.228-.383-.923" />
                            <path d="m16.852 20.772-.383.924" />
                            <path d="m19.148 15.228.383-.923" />
                            <path d="m19.53 21.696-.382-.924" />
                            <path d="M2 21a8 8 0 0 1 10.434-7.62" />
                            <path d="m20.772 16.852.924-.383" />
                            <path d="m20.772 19.148.924.383" />
                            <circle cx="10" cy="8" r="5" />
                            <circle cx="18" cy="18" r="3" />
                        </svg>
                        IRO Approved Accounts
                    </a>
                </li>
                <li>
                    <a href="{{ url('/erb/research-records') }}"
                        class="flex items-center max-sm:text-[15px] px-2 py-3 max-sm:py-2.5 border-0 no-underline gap-x-2 cursor-pointer transition-all duration-300 hover:text-secondary
                        {{ Request::is('erb/research-records') || Request::is('erb/submitted-documents/*') ? 'text-secondary' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-database-icon lucide-database">
                            <ellipse cx="12" cy="5" rx="9" ry="3" />
                            <path d="M3 5V19A9 3 0 0 0 21 19V5" />
                            <path d="M3 12A9 3 0 0 0 21 12" />
                        </svg>
                        Research Records
                    </a>
                </li>

                <li>
                    <a href="{{ url('/erb/assigned-forms') }}" class="flex items-center max-sm:text-[15px] px-2 py-3 max-sm:py-2.5 border-0 no-underline gap-x-2 cursor-pointer transition-all duration-300 hover:text-secondary 
                        {{ Request::is('erb/assigned-forms') ? 'text-secondary' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-folder-pen-icon lucide-folder-pen">
                            <path
                                d="M2 11.5V5a2 2 0 0 1 2-2h3.9c.7 0 1.3.3 1.7.9l.8 1.2c.4.6 1 .9 1.7.9H20a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-9.5" />
                            <path
                                d="M11.378 13.626a1 1 0 1 0-3.004-3.004l-5.01 5.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                        </svg>
                        Assigned Forms
                    </a>
                </li>
                <li>
                    <a href="{{ url('/erb/protocol-decision') }}" class="flex items-center max-sm:text-[15px] px-2 py-3 max-sm:py-2.5 border-0 no-underline gap-x-2 cursor-pointer transition-all duration-300 hover:text-secondary 
                        {{ Request::is('erb/protocol-decision') ? 'text-secondary' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-file-user-icon lucide-file-user">
                            <path
                                d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
                            <path d="M14 2v5a1 1 0 0 0 1 1h5" />
                            <path d="M16 22a4 4 0 0 0-8 0" />
                            <circle cx="12" cy="15" r="3" />
                        </svg>
                        Protocol Decision
                    </a>
                </li>
                <li>
                    <a href="{{ url('/erb/submitted-tickets') }}"
                        class="flex items-center max-sm:text-[15px] px-2 py-3 max-sm:py-2.5 border-0 no-underline gap-x-2 cursor-pointer transition-all duration-300 hover:text-secondary 
                        {{ Request::is('erb/submitted-tickets') || Request::is('erb/tickets/*') ? 'text-secondary' : ''}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-folder-kanban-icon lucide-folder-kanban">
                            <path
                                d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z" />
                            <path d="M8 10v4" />
                            <path d="M12 10v2" />
                            <path d="M16 10v6" />
                        </svg>
                        Submitted Inquiries
                    </a>
                </li>
                <li>
                    <a href="{{ url('/erb/resubmission') }}" class="flex items-center max-sm:text-[15px] px-2 py-3 max-sm:py-2.5 border-0 no-underline gap-x-2 cursor-pointer transition-all duration-300 hover:text-secondary 
                        {{ Request::is('erb/resubmission') ? 'text-secondary' : ''}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-folder-pen-icon lucide-folder-pen">
                            <path
                                d="M2 11.5V5a2 2 0 0 1 2-2h3.9c.7 0 1.3.3 1.7.9l.8 1.2c.4.6 1 .9 1.7.9H20a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-9.5" />
                            <path
                                d="M11.378 13.626a1 1 0 1 0-3.004-3.004l-5.01 5.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                        </svg>
                        Resubmission
                    </a>
                </li>
                <li>
                    <a href="{{ url('/erb/monitoring-process') }}" class="flex items-center max-sm:text-[15px] px-2 py-3 max-sm:py-2.5 border-0 no-underline gap-x-2 cursor-pointer transition-all duration-300 hover:text-secondary 
                        {{ Request::is('erb/monitoring-process') ? 'text-secondary' : ''}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-monitor-cloud-icon lucide-monitor-cloud">
                            <path d="M11 13a3 3 0 1 1 2.83-4H14a2 2 0 0 1 0 4z" />
                            <path d="M12 17v4" />
                            <path d="M8 21h8" />
                            <rect x="2" y="3" width="20" height="14" rx="2" />
                        </svg>
                        Process Monitoring
                    </a>
                </li>
                <li>
                    <a href="{{ url('/erb/final-completion') }}" class="flex items-center max-sm:text-[15px] px-2 py-3 max-sm:py-2.5 border-0 no-underline gap-x-2 cursor-pointer transition-all duration-300 hover:text-secondary 
                        {{ Request::is('erb/final-completion') ? 'text-secondary' : ''}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-user-check-icon lucide-user-check">
                            <path d="m16 11 2 2 4-4" />
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                        </svg>
                        Final Completion
                    </a>
                </li>
            </ul>
        </div>
        <footer class="flex items-center px-3 py-3 border-darkergray border-t">
            <div class="flex items-center">
                <img src="{{ asset('images/profile-white.png') }}" alt="PFP"
                    class="w-[40px] h-[40px] rounded-[50%] mx-0.5">
                <div class="pl-1">
                    <div class="whitespace-nowrap max-sm:text-sm">
                        {{ Auth::user()->user_Fname }} {{ Auth::user()->user_MI }} {{ Auth::user()->user_Lname }}
                    </div>
                    <div class="whitespace-nowrap max-sm:text-xs text-sm">ERB Admin</div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="duration-200 hover:text-secondary p-0 m-0 bg-transparent border-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-log-out-icon lucide-log-out text-2xl absolute right-4 bottom-[10px] -translate-y-[50%]">
                            <path d="m16 17 5-5-5-5" />
                            <path d="M21 12H9" />
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        </svg>
                    </button>
                </form>
            </div>
        </footer>
    </nav>
</div>
<header
    class="h-[65px] xl:hidden bg-primary z-[99] shadow-md sticky top-0 left-0 flex items-center px-3 justify-between">
    <button id="menuBtn" class="text-white focus:outline-none text-xl pl-3">&#9776;</button>
    <img src="{{ asset('images/mcu-logo-white(2).png') }}" alt="" class="w-[55px] h-[55px]">
    <img src="{{ asset('images/profile-white.png') }}" alt="" class="rounded-[50%] w-[35px] h-[35px] border-none">
</header>