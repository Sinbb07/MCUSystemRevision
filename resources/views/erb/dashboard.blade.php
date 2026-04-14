@section('title', 'Dashboard')
<x-erb-layout>
    <!-- Main Content -->
    <main class="xl:ml-[335px] max-xl:ml-auto p-4 max-md:p-2">
        <h2 class="max-xl:hidden text-left bg-[#f2f2f2] shadow-lg p-[35px] rounded-[30px] font-medium text-[28px]">
            DASHBOARD
        </h2>
        <br>
        <div class="p-6 max-md:p-0 space-y-10">
            <!-- Announcement/Reminders -->
            <div class="rounded-md shadow-md overflow-hidden bg-white">
                <!-- Header bar -->
                <div class="bg-primary max-sm:text-sm text-white font-semibold px-4 py-2">
                    Reminder
                </div>

                <!-- Body -->
                <div class="p-6 text-sm leading-relaxed">
                    <p class="mb-4 max-sm:text-xs">
                        sample text
                    </p>
                </div>
            </div>
            <!-- User Account Cards -->
            <div>
                <h2 class="text-[20px] max-sm:text-[17px] font-semibold mb-4">USERS ACCOUNT</h2>
                <div class="grid max-md:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="card bg-lightgray p-4 rounded-lg border border-gray shadow">
                        <h3 class="text-2xl max-md:text-[22px] max-sm:text-xl font-semibold">{{ $totalUsers }}</h3>
                        <p class="max-xl:text-sm">TOTAL USERS</p>
                    </div>
                    <div class="card bg-lightgray p-4 rounded-lg border border-gray shadow">
                        <h3 class="text-2xl max-md:text-[22px] max-sm:text-xl font-semibold">{{ $pendingUsers }}</h3>
                        <p class="max-xl:text-sm">PENDING</p>
                    </div>
                    <div class="card bg-lightgray p-4 rounded-lg border border-gray shadow">
                        <h3 class="text-2xl max-md:text-[22px] max-sm:text-xl font-semibold">{{ $approvedUsers }}</h3>
                        <p class="max-xl:text-sm">APPROVED</p>
                    </div>
                    <div class="card bg-lightgray p-4 rounded-lg border border-gray shadow">
                        <h3 class="text-2xl max-md:text-[22px] max-sm:text-xl font-semibold">3</h3>
                        <p class="max-xl:text-sm">DISABLED</p>
                    </div>
                </div>
            </div>

            <!-- Research Protocol -->
            <div>
                <h2 class="text-[20px] max-sm:text-[17px] font-semibold mb-4">RESEARCH PROTOCOL</h2>
                <div class="grid max-md:grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <div class="card bg-lightgray p-4 rounded-lg border border-gray shadow">
                        <h3 class="text-2xl max-md:text-[22px] max-sm:text-xl font-semibold">{{ $evaluatedProtocols }}</h3>
                        <p class="max-xl:text-sm">EVALUATED</p>
                    </div>
                    <div class="card bg-lightgray p-4 rounded-lg border border-gray shadow">
                        <h3 class="text-2xl max-md:text-[22px] max-sm:text-xl font-semibold">{{ $pendingReviews }}</h3>
                        <p class="max-xl:text-sm">PENDING REVIEWS</p>
                    </div>
                    <div class="card bg-lightgray p-4 rounded-lg border border-gray shadow">
                        <h3 class="text-2xl max-md:text-[22px] max-sm:text-xl font-semibold">{{ $ongoingReviews }}</h3>
                        <p class="max-xl:text-sm">ONGOING REVIEWS</p>
                    </div>
                    <div class="card bg-lightgray p-4 rounded-lg border border-gray shadow">
                        <h3 class="text-2xl max-md:text-[22px] max-sm:text-xl font-semibold">5</h3>
                        <p class="max-xl:text-sm">TERMINATED</p>
                    </div>
                    <div class="card bg-lightgray p-4 rounded-lg border border-gray shadow">
                        <h3 class="text-2xl max-md:text-[22px] max-sm:text-xl font-semibold">{{ $approvedProtocols }}</h3>
                        <p class="max-xl:text-sm">APPROVED</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-6 max-md:px-0 space-y-10">
            <div class="flex max-md:block gap-10 w-full">
                <!-- Main content -->
                <main class="flex-1">
                    <div class="max-w-5xl mx-auto max-md:px-1 px-4 py-4 flex items-center justify-between">
                        <h1 class="text-2xl max-md:text-xl max-sm:text-lg font-semibold text-gray-800">Notifications
                        </h1>
                        <button onclick="markAllAsRead()" class="text-sm max-md:text-xs text-blue hover:text-darkblue duration-200">Mark all as read</button>
                    </div>
                    <div class="max-w-5xl mx-auto max-md:px-0 px-4 py-6 max-md:py-2">
                        <div class="bg-white shadow-sm border-2 border-gray">
                            <!-- Scroll area -->
                            <ul class="h-[32rem] max-md:h-[20rem] overflow-y-auto scrollbar divide-y divide-gray">
                                @forelse(auth()->user()->unreadNotifications ?? [] as $notification)
                                <li class="p-4 flex gap-4 hover:bg-gray duration-200 cursor-pointer">
                                    <form method="POST" action="{{ route('erb.notification.markRead', $notification->id) }}" class="hidden" id="form-{{ $notification->id }}">
                                        @csrf
                                    </form>
                                    <div onclick="document.getElementById('form-{{ $notification->id }}').submit()" class="flex gap-4 w-full">
                                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-4h2v2H9v-2zm0-8h2v6H9V6z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-800">
                                                <span class="font-medium">{{ $notification->data['name'] ?? 'User' }}</span> 
                                                {{ $notification->data['message'] ?? 'has been classified' }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        @if($notification->unread())
                                        <span class="inline-flex w-3 h-3 rounded-full bg-blue self-center"></span>
                                        @endif
                                    </div>
                                </li>
                                @empty
                                <li class="p-4 text-center text-gray-500">
                                    No new notifications
                                </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </main>
                <div class="flex-1 space-y-10 overflow-auto">
                    <table id="myTable" class="display overflow-scroll border-collapse w-full">
                        <thead class="bg-primary text-white text-lg/7 max-lg:text-base/7">
                            <tr class="header-table">
                                <th class="w-[25.00%]">Research Protocol</th>
                                <th class="w-[25.00%]">Research Title</th>
                                <th class="w-[25.00%]">Reviewer</th>
                                <th class="w-[25.00%]">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-base/7 max-lg:text-sm/6">
                            @foreach($recentProtocols as $protocol)
                            <tr>
                                <td>{{ $protocol['protocol_id'] }}</td>
                                <td>{{ $protocol['research_title'] }}</td>
                                <td>{{ $protocol['reviewer'] }}</td>
                                <td>{{ $protocol['status'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</x-erb-layout>

<script>
    function markAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => {
            if (response.ok) {
                // Remove the blue dot
                $(`.notification-item[data-id="${notificationId}"]`).find('.bg-blue').remove();
            }
        });
    }

    function markAllAsRead() {
        // Create a form and submit it
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("erb.notification.markAllRead") }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    }
</script>