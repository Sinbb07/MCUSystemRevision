<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>FORM-3L</title>
    @vite('resources/css/app.css') {{-- Tailwind --}}
    <style>
        .page-break {
            break-before: page;
        }
    </style>
</head>

<body class="p-2 text-sm font-arial">
    <h1 class="text-xl font-times font-black text-center mb-6">MCUERB FORM 3(L) Final Reports</h1>

    <x-formbanner>MCUERB FORM 3(L) Final Reports</x-formbanner>

    <h1 class="text-base font-bold text-center underline mb-4">Final Reports</h1>

    <div class="mt-8 flex flex-col border">
        <div class="flex items-stretch bg-gray">
            <div class="w-full">
                <p class="text-sm font-bold py-1 mx-2">GENERAL INFORMATION</p>
            </div>
        </div>

        <!-- TITLE OF STUDY -->
        <div class="flex items-stretch border-t">
            <div class="w-[21.00%] border-r py-4 mx-2">
                <p>Title of Study</p>
            </div>
            <div class="mx-2 py-1">
                {{ $form3l->study_title ?? $researchInfo->research_title ?? 'N/A' }}
            </div>
        </div>

        <!-- VERSION NUMBER -->
        <div class="flex items-stretch border-t">
            <div class="w-[21.00%] border-r py-1 mx-2">
                Version number/date of the ERB approved protocol
            </div>
            <div class="mx-2 py-1">
                {{ $form3l->version_number_date ?? 'N/A' }}
            </div>
        </div>

        <!-- MCUERB CODE & STUDY SITE -->
        <div class="flex items-stretch border-t">
            <!-- MCUERB CODE -->
            <div class="w-[21.00%] text-sm border-r mx-2">
                <p>MCUERB Code <i>(to be provided by MCUERB)</i></p>
            </div>
            <div class="w-[30.00%] border-r p-2 ml-2">
                <p>{{ $mcuerbCode ?? '2025-S1-001' }}</p>
            </div>

            <!-- STUDY SITE -->
            <div class="w-[13.00%] flex items-center text-sm border-r mx-2">
                Study Site
            </div>
            <div class="flex-1 p-2">
                <p>{{ $form3l->study_site ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- NAME OF INVESTIGATOR & CONTACT INFORMATION -->
        <div class="flex items-stretch border-t">
            <!-- NAME OF RESEARCHER -->
            <div class="w-[21.00%] flex items-center border-r mx-2 py-1">
                <p>Name of Researcher/PI</p>
            </div>
            <div class="w-[30.00%] border-r ml-2 p-2">
                <p>{{ $form3l->pi_name ?? $principalInvestigator ?? 'N/A' }}</p>
            </div>

            <!-- CONTACT INFORMATION -->
            <div class="w-[13.00%] flex items-center border-r ml-2 py-1">
                <p>Contact Information</p>
            </div>
            <div class="flex-1">
                <!-- TELEPHONE NUMBER -->
                <div class="flex items-center">
                    <p class="py-1">Tel. No:</p>&nbsp;
                    <p>{{ $form3l->tel_no ?? 'N/A' }}</p>
                </div>

                <!-- MOBILE NUMBER -->
                <div class="flex items-center border-t">
                    <p class="py-1">Mobile No:</p>&nbsp;
                    <p class="break-all">{{ $form3l->contact_no ?? 'N/A' }}</p>
                </div>

                <!-- EMAIL -->
                <div class="flex items-center border-t">
                    <p class="py-1">Email:</p>&nbsp;
                    <p class="break-all">{{ $form3l->pi_email ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- CO-INVESTIGATOR(S) -->
        <div class="flex items-stretch border-t">
            <div class="w-[21.00%] border-r py-1 mx-2">
                <p>Co-Investigator/s (if any)</p>
            </div>
            <div class="mx-2 py-1">
                <p>{{ $form3l->co_investigators ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- INSTITUTION OF RESEARCHER -->
        <div class="flex items-stretch border-t">
            <div class="w-[21.00%] border-r py-1 mx-2">
                <p>Institution of researcher</p>
            </div>
            <div class="mx-2 py-1">
                <p>{{ $form3l->institution_researcher ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- ADDRESS OF INSTITUTION -->
        <div class="flex items-stretch border-t">
            <div class="w-[21.00%] border-r py-1 mx-2">
                <p>Address of Institution</p>
            </div>
            <div class="mx-2 py-1">
                <p>{{ $form3l->institution_address ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- EFFECTIVE PERIOD OF ETHICAL CLEARANCE -->
        <div class="flex items-stretch border-t">
            <div class="w-[21.00%] border-r py-1 mx-2">
                <p>Effective period of ethical clearance</p>
            </div>
            <div class="w-[35.00%] mx-1 border-r">
                <p>From:</p>
                <p>{{ $form3l->ethical_from_date ? \Carbon\Carbon::parse($form3l->ethical_from_date)->format('Y-m-d') : 'N/A' }}</p>
            </div>
            <div class="mx-1">
                <p>To:</p>
                <p>{{ $form3l->ethical_to_date ? \Carbon\Carbon::parse($form3l->ethical_to_date)->format('Y-m-d') : 'N/A' }}</p>
            </div>
        </div>
    </div>

    <div class="mt-4 flex flex-col border">
        <div class="flex items-stretch">
            <div class="w-full">
                <p class="text-sm text-center font-bold py-1 mx-2">Final Report</p>
            </div>
        </div>

        <!-- START OF STUDY -->
        <div class="flex items-stretch border-t">
            <div class="w-full">
                <p class="text-sm py-0.5 mx-2">1. Start of study</p>
            </div>
        </div>
        <div class="flex items-stretch border-t">
            <div class="w-full">
                <p class="text-sm py-0.5 h-6 mx-2">{{ $form3l->study_start ? \Carbon\Carbon::parse($form3l->study_start)->format('Y-m-d') : 'N/A' }}</p>
            </div>
        </div>

        <!-- END OF STUDY -->
        <div class="flex-items stretch border-t">
            <div class="w-full">
                <p class="text-sm py-0.5 mx-2">2. End of study</p>
            </div>
            <div class="w-full border-t">
                <p class="text-sm py-0.5 h-6 mx-2">{{ $form3l->study_end ? \Carbon\Carbon::parse($form3l->study_end)->format('Y-m-d') : 'N/A' }}</p>
            </div>
        </div>

        <!-- NUMBER OF ENROLLED PARTICIPANTS -->
        <div class="flex-items stretch border-t">
            <div class="w-full">
                <p class="text-sm py-0.5 mx-2">3. Number of enrolled participants</p>
            </div>
            <div class="w-full border-t">
                <p class="text-sm py-0.5 h-6 mx-2">{{ $form3l->enrolled_participants ?? '0' }}</p>
            </div>
        </div>

        <!-- NUMBER OF REQUIRED PARTICIPANTS -->
        <div class="flex-items stretch border-t">
            <div class="w-full">
                <p class="text-sm py-0.5 mx-2">4. Number of required participants</p>
            </div>
            <div class="w-full border-t">
                <p class="text-sm py-0.5 h-6 mx-2">{{ $form3l->required_participants ?? '0' }}</p>
            </div>
        </div>
    </div>

    <!-- Page 2 -->
    <div class="page-break"></div>

    <div class="flex flex-col border">
        <!-- NUMBER OF PARTICIPANTS WHO WITHDREW -->
        <div class="flex-items stretch">
            <div class="w-full">
                <p class="text-sm py-0.5 mx-2">5. Number of participants who withdrew</p>
            </div>
            <div class="w-full border-t">
                <p class="text-sm py-0.5 h-6 mx-2">{{ $form3l->participant_withdrew ?? '0' }}</p>
            </div>
        </div>

        <!-- DEVIATIONS FROM THE APPROVED PROTOCOL -->
        <div class="flex-items stretch border-t">
            <div class="w-full">
                <p class="text-sm py-0.5 mx-2">6. Deviations from the approved protocol</p>
            </div>
            <div class="w-full border-t">
                <p class="text-sm py-0.5 h-6 mx-2">{{ $form3l->deviations ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- ISSUES/PROBLEMS ENCOUNTERED -->
        <div class="flex-items stretch border-t">
            <div class="w-full">
                <p class="text-sm py-0.5 mx-2">7. Issues/problems encountered</p>
            </div>
            <div class="w-full border-t">
                <p class="text-sm py-0.5 h-6 mx-2">{{ $form3l->issues_problems ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- SUMMARY OF FINDINGS -->
        <div class="flex-items stretch border-t">
            <div class="w-full">
                <p class="text-sm py-0.5 mx-2">8. Summary of findings</p>
            </div>
            <div class="w-full border-t">
                <p class="text-sm py-0.5 h-6 mx-2">{{ $form3l->findings_summary ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- CONCLUSIONS -->
        <div class="flex-items stretch border-t">
            <div class="w-full">
                <p class="text-sm py-0.5 mx-2">9. Conclusions</p>
            </div>
            <div class="w-full border-t">
                <p class="text-sm py-0.5 h-6 mx-2">{{ $form3l->conclusions ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- ACTIONS FOR DISSEMINATION OF STUDY RESULTS -->
        <div class="flex-items stretch border-t">
            <div class="w-full">
                <p class="text-sm py-0.5 mx-2">10. Actions for dissemination of study results</p>
            </div>
            <div class="w-full border-t">
                <p class="text-sm py-0.5 h-6 mx-2">{{ $form3l->action_dissemination ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <div class="mt-4 mx-4">
        <div class="flex">
            <p class="font-bold">Signature over Printed Name of Principal Investigator:</p>&nbsp;
            <p class="border border-t-0 border-l-0 border-r-0 border-b-2 h-5 w-48">{{ $form3l->pi_name ?? $principalInvestigator ?? '' }}</p>
        </div>
        <div class="flex">
            <p class="font-bold">Date:</p>&nbsp;
            <p class="border border-t-0 border-l-0 border-r-0 border-b-2 h-5 w-48">{{ now()->format('Y-m-d') }}</p>
        </div>
    </div>

    <div class="mt-8 mx-4">
        <p class="text-sm font-arial mt-6 font-bold">Noted by the Research Adviser:</p>

        <p class="text-sm font-arial mt-2">Date and Signature:</p>

        <p class="text-sm font-arial mt-6 font-bold">Approved by the Research Coordinator:</p>

        <p class="text-sm font-arial mt-2">Date and Signature:</p>
    </div>
</body>

</html>