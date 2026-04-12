@section('title', 'Dashboard')
<x-student-layout>
    <!-- Main Content -->
    <main class="xl:ml-[335px] max-xl:ml-auto p-4">
        <h2 class="max-xl:hidden text-left bg-[#f2f2f2] shadow-lg p-[35px] rounded-[30px] font-medium text-[28px]">
            DASHBOARD
        </h2>
        <br>
        <div class="p-6 max-md:p-0 space-y-10">
            <!-- Announcement/Reminders -->
            <div class="rounded-md shadow-md overflow-hidden bg-white">
                <!-- Header bar -->
                <div class="bg-primary max-sm:text-base text-white font-semibold px-4 py-2">
                    Reminder
                </div>

                <!-- Body -->
                <div class="p-6 text-sm leading-relaxed">
                    <p class="mb-4 max-sm:text-[13px]">
                        @if($reviewStatus === 'Under Review')
                            Your protocol is currently under review. Please wait for the evaluation results.
                        @elseif($reviewStatus === 'Evaluated')
                            Your protocol has been evaluated. Check your notifications for results.
                        @elseif($reviewStatus === 'Submitted')
                            Your protocol has been submitted and is awaiting review.
                        @else
                            Welcome! Please submit your research protocol for review.
                        @endif
                    </p>
                </div>
            </div>

            <!-- Cards -->
            <div>
                <div class="grid 2xl:grid-cols-4 max-md:grid-cols-1 md:grid-cols-2 max-lg:grid-cols-2 gap-4">
                    <!-- Status of Review Card -->
                    <div class="card bg-lightgray p-4 rounded-lg border border-gray shadow">
                        <h2 class="text-[25px] max-2xl:text-[22px] max-sm:text-base font-semibold text-center">
                            {{ strtoupper($reviewStatus) }}
                        </h2>
                        <p class="mt-2 text-center max-sm:text-sm">STATUS OF REVIEW</p>
                    </div>
                    
                    <!-- Deadline Card -->
                    <div class="card bg-lightgray p-4 rounded-lg border border-gray shadow">
                        <h2 class="text-[25px] max-2xl:text-[22px] max-sm:text-base font-semibold text-center">
                            {{ $deadline }}
                        </h2>
                        <p class="mt-2 text-center max-sm:text-sm">DEADLINE OF SUBMISSION</p>
                    </div>
                    
                    <!-- Submitted Documents Card -->
                    <div data-modal="modal1"
                        class="card cursor-pointer bg-lightgray hover:bg-gray duration-200 p-4 rounded-lg border border-gray shadow">
                        <h3 class="text-[25px] max-2xl:text-[22px] max-sm:text-base/5 font-semibold text-center">
                            {{ $submittedDocumentsCount }}
                        </h3>
                        <p class="mt-2 text-center max-sm:text-sm">Submitted Documents</p>
                    </div>
                    
                    <!-- Pending Documents Card -->
                    <div data-modal="modal2"
                        class="card cursor-pointer bg-lightgray hover:bg-gray duration-200 p-4 rounded-lg border border-gray shadow">
                        <h2 class="text-[25px] max-2xl:text-[22px] max-sm:text-base/5 font-semibold text-center">
                            {{ $pendingDocumentsCount }}
                        </h2>
                        <p class="mt-2 text-center max-sm:text-sm">Pending Documents</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rest of your existing code for notifications remains the same -->
        <div class="p-6 max-md:px-0 space-y-10">
            <div class="flex max-md:block gap-10 w-full">
                <!-- Notification Tab -->
                <main class="flex-1 py-4 max-md:px-0 max-md:py-2">
                    <div class="w-full mx-auto px-4 max-md:px-1 py-4 flex items-center justify-between">
                        <h1 class="text-2xl max-md:text-[20px] font-semibold text-gray-800">Notifications</h1>
                        <form id="markAllReadForm" action="{{ route('student.notification.markAllRead') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-sm max-md:text-xs text-blue hover:text-darkblue duration-200">Mark all as read</button>
                        </form>
                    </div>
                    <div class="w-full mx-auto px-4 max-md:px-0 py-2 max-md:py-0">
                        <div class="bg-white shadow-sm border-2 border-gray">
                            <!-- Scroll area -->
                            <ul class="h-[32rem] max-md:h-[20rem] overflow-y-auto scrollbar divide-y divide-gray" id="notifications-list">
                                @forelse(auth()->user()->notifications->take(20) as $notification)
                                    <li class="p-4 flex gap-4 hover:bg-gray duration-200 cursor-pointer {{ $notification->read_at ? '' : 'bg-blue-50' }}"
                                        onclick="handleNotificationClick('{{ $notification->id }}', '{{ json_encode($notification->data) }}')">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-4h2v2H9v-2zm0-8h2v6H9V6z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-800">
                                                {{ $notification->data['message'] ?? 'New notification' }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                        @if(!$notification->read_at)
                                            <span class="inline-flex w-3 h-3 rounded-full bg-blue self-center"></span>
                                        @endif
                                    </li>
                                @empty
                                    <li class="p-4 text-center text-gray-500">
                                        No notifications yet
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </main>

    <!-- Modal -->
    <!-- Submitted Documents -->
    <div id="modal1" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-[9999]">
        <div class="bg-white max-sm:mx-2 rounded-lg shadow-lg p-6 max-w-md w-full">
            <h2 class="text-[23px] max-sm:text-[18px] font-bold mb-4">Submitted Documents</h2>
            <div id="scrollbar" class="overflow-y-auto h-64 max-sm:h-60 px-2 border-2 border-gray">
                @forelse($submittedDocuments as $document)
                    <div class="py-2 border-b border-gray-200">
                        <p class="font-medium text-sm">{{ $document->form_name }}</p>
                        <p class="text-xs text-gray-500">Submitted: {{ $document->submitted_at ? \Carbon\Carbon::parse($document->submitted_at)->format('M d, Y') : 'N/A' }}</p>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-4">No documents submitted yet</p>
                @endforelse
            </div>
            <button type="button"
                class="closeModal text-[17px] max-sm:text-[15px] mt-6 px-4 py-2 rounded text-primary tracking-widest bg-secondary text-primary hover:bg-primary hover:text-secondary duration-200">
                CLOSE
            </button>
        </div>
    </div>
    
    <!-- Pending Documents -->
    <div id="modal2" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-[9999]">
        <div class="bg-white max-sm:mx-2 rounded-lg shadow-lg p-6 max-w-md w-full">
            <h2 class="text-[23px] max-sm:text-[18px] font-bold mb-4">Pending Requirements</h2>
            <div id="scrollbar" class="overflow-y-auto h-64 max-sm:h-60 px-2 border-2 border-gray">
                @forelse($pendingDocuments as $document)
                    <div class="py-2 border-b border-gray-200">
                        <p class="font-medium text-sm">{{ $document->form_name }}</p>
                        <p class="text-xs text-gray-500">Status: Pending</p>
                    </div>
                @empty
                    <p class="max-sm:text-[14px] text-center py-4">All requirements have been submitted</p>
                @endforelse
            </div>
            <button type="button"
                class="closeModal text-[17px] max-sm:text-[15px] mt-6 px-4 py-2 rounded text-primary bg-secondary tracking-widest text-primary hover:bg-primary hover:text-secondary duration-200">
                CLOSE
            </button>
        </div>
    </div>
</x-student-layout>

<!-- Your existing JavaScript remains exactly the same -->
<script>
    // Attach click event to all cards
    document.querySelectorAll('[data-modal]').forEach(card => {
        card.addEventListener('click', () => {
            const modalId = card.getAttribute('data-modal');
            const modal = document.getElementById(modalId);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    // Attach click event to all close buttons
    document.querySelectorAll('.closeModal').forEach(button => {
        button.addEventListener('click', () => {
            const modal = button.closest('.fixed');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });
    });

    // Optional: close modal by clicking outside
    document.querySelectorAll('.fixed').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });
    });

    // Handle notification click
    function handleNotificationClick(notificationId, notificationDataJson) {
        const notificationData = JSON.parse(notificationDataJson);
        
        // First mark as read
        markAsRead(notificationId);
        
        // Then handle the action
        if (notificationData.action_url) {
            // Check if the route exists and is valid
            if (isValidRoute(notificationData.action_url)) {
                window.location.href = notificationData.action_url;
            } else {
                console.warn('Invalid route:', notificationData.action_url);
                // Fallback to a default page
                window.location.href = '/student/dashboard';
            }
        } else {
            // Default action if no action_url specified
            window.location.href = '/student/dashboard';
        }
    }

    // Mark notification as read
    function markAsRead(notificationId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/notifications/${notificationId}/mark-read`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    }

    // Check if route is valid (basic check)
    function isValidRoute(url) {
        // Remove leading slash if present
        const path = url.replace(/^\//, '');
        
        // Check if it's a valid-looking path
        return path.length > 0 && !path.includes('..') && !path.includes('//');
    }

    // Add confirmation for mark all as read
    document.getElementById('markAllReadForm').addEventListener('submit', function(e) {
        if (!confirm('Are you sure you want to mark all notifications as read?')) {
            e.preventDefault();
        }
    });
</script>