@section('title', 'Dashboard')
<x-erb-reviewer>
    @php
        // Get the current authenticated reviewer
        $reviewer = auth()->user();
        $reviewerId = $reviewer->user_ID;
        
        // Count pending protocols - protocols assigned to this reviewer but not yet evaluated
        $pendingProtocolsCount = DB::table('tbl_initial_review')
            ->where(function($query) use ($reviewerId) {
                $query->where('reviewer1_ID', $reviewerId)
                      ->orWhere('reviewer2_ID', $reviewerId);
            })
            ->whereNotIn('protocol_ID', function($subquery) use ($reviewerId) {
                $subquery->select('protocol_ID')
                         ->from('tbl_evaluated_reviews')
                         ->where('reviewer_ID', $reviewerId)
                         ->where('status', 'Completed');
            })
            ->count();
            
        // Count evaluated protocols - protocols this reviewer has completed
        $evaluatedProtocolsCount = DB::table('tbl_evaluated_reviews')
            ->where('reviewer_ID', $reviewerId)
            ->where('status', 'Completed')
            ->count();
    @endphp

    <!-- Main Content -->
    <main class="xl:ml-[335px] max-xl:ml-auto p-4 max-xl:p-2">
        <h2 class="max-xl:hidden text-left bg-[#f2f2f2] shadow-lg p-[35px] rounded-[30px] font-medium text-[28px]">
            DASHBOARD
        </h2>
        <br>
        <div class="p-6 max-md:p-0 space-y-10">
            <div class="rounded-md shadow-md overflow-hidden bg-white">
                <!-- Header bar -->
                <div class="bg-primary text-white font-semibold px-4 py-2">
                    Reminder
                </div>

                <!-- Body -->
                <div class="p-6 text-sm leading-relaxed">
                    <p class="mb-4">
                        You have {{ $pendingProtocolsCount }} protocol(s) pending review. Please complete your evaluations promptly.
                    </p>
                </div>
            </div>
            <div>
                <div class="grid max-md:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
                    <div class="card bg-lightgray p-4 rounded-lg border border-gray shadow">
                        <h3 class="text-[25px] max-2xl:text-[22px] max-sm:text-lg font-semibold">{{ $pendingProtocolsCount }}</h3>
                        <p class="max-md:text-[13px]">PENDING PROTOCOLS</p>
                    </div>
                    <div class="card bg-lightgray p-4 rounded-lg border border-gray shadow">
                        <h3 class="text-[25px] max-2xl:text-[22px] max-sm:text-lg font-semibold">{{ $evaluatedProtocolsCount }}</h3>
                        <p class="max-md:text-[13px]">EVALUATED PROTOCOLS</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6 max-md:px-0 space-y-10">
            <div class="flex max-md:block gap-10 w-full">
                <!-- Notification Tab -->
                <main class="flex-1 py-4 max-md:px-0 max-md:py-2">
                    <div class="w-full mx-auto px-4 max-md:px-1 py-4 flex items-center justify-between">
                        <h1 class="text-2xl max-md:text-[20px] font-semibold text-gray-800">Notifications</h1>
                        <button onclick="markAllAsRead()" class="text-sm max-md:text-xs text-blue hover:text-darkblue duration-200">Mark all as read</button>
                    </div>
                    <div class="w-full mx-auto px-4 max-md:px-0 py-2 max-md:py-0">
                        <div class="bg-white shadow-sm border-2 border-gray">
                            <!-- Scroll area -->
                            <ul class="h-[32rem] max-md:h-[20rem] overflow-y-auto scrollbar divide-y divide-gray">
                                @forelse(auth()->user()->notifications->take(20) as $notification)
                                <li class="p-4 flex gap-4 hover:bg-gray duration-200 cursor-pointer">
                                    <form method="POST" action="{{ route('erb-reviewer.notification.markRead', $notification->id) }}" class="hidden" id="form-{{ $notification->id }}">
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
                                                {{ $notification->data['message'] ?? 'New notification' }}
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
</x-erb-reviewer>

<script>
    function markAllAsRead() {
        if (confirm('Are you sure you want to mark all notifications as read?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("erb-reviewer.notification.markAllRead") }}';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>