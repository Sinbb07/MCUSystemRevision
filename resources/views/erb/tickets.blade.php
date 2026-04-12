@section('title', 'Submitted Tickets')
<x-erb-layout>
    <!-- Main Content -->
    <main class="xl:ml-[335px] max-xl:ml-auto p-4 max-md:p-2">
        <h2 class="max-xl:hidden text-left bg-[#f2f2f2] shadow-lg p-[35px] rounded-[30px] font-medium text-[28px]">
            SUBMITTED TICKETS
        </h2>
        <br>

        <div class="w-full mx-auto px-4 py-6 bg-white rounded-lg border-2 border-gray">
            <h1 class="text-primary text-2xl max-md:text-lg font-semibold mb-4">Ticket Details</h1>
            <div class="text-primary gap-x-20 gap-y-3 max-w-full max-sm:text-sm">
                <div class="flex max-sm:block gap-x-3 my-2">
                    <div class="font-bold max-sm:mb-2">User:</div>
                    <div class="max-sm:mb-2 font-medium">
                        {{ $ticket->user ? $ticket->user->user_Fname . ' ' . $ticket->user->user_Lname : 'Unknown' }}
                    </div>
                </div>

                <div class="flex max-sm:block gap-x-3 my-2">
                    <div class="font-bold max-sm:mb-2">Research Title:</div>
                    <div class="max-sm:mb-2 font-medium">
                        {{ $ticket->user && $ticket->user->researchInformation ? $ticket->user->researchInformation->research_title : 'N/A' }}
                    </div>
                </div>
                <div class="flex max-sm:block gap-x-3 my-2">
                    <div class="font-bold max-sm:mb-2">Subject:</div>
                    <div class="max-sm:mb-2 font-medium">{{ $ticket->Ticket_Subject }}</div>
                </div>
                <div class="flex max-sm:block gap-x-3 my-2">
                    <div class="font-bold max-sm:mb-2">Category:</div>
                    <div class="max-sm:mb-2 font-medium">{{ $ticket->User_Concern }}</div>
                </div>
            </div>
            <br>
            <label class="font-bold text-primary">Concern</label>
            <textarea class="mt-2 resize-none w-full border-darkgray h-80 max-sm:h-32 max-sm:text-sm" readonly>
{{ $ticket->Ticket_Description }}
            </textarea>
        </div>
        <div class="mt-4">
            <a href="{{ url('/erb/submitted-tickets') }}"
                class="bg-secondary hover:bg-primary text-lg max-xl:text-base text-primary hover:text-secondary uppercase tracking-widest px-4 py-2 rounded-md duration-200">
                Back
            </a>
        </div>
    </main>
</x-erb-layout>