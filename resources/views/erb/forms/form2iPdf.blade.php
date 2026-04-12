<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>FORM-2I</title>
    @vite('resources/css/app.css') {{-- loads Tailwind --}}
</head>
<style>
    .page-break {
        break-before: page;
    }
</style>

<body class="p-8 text-sm font-arial">
    <h1 class="text-xl font-times font-black text-center mb-6">MCUERB FORM 2(I) Certificate of Exemption of Review</h1>

    <x-formbanner>MCUERB FORM 2(I) Certificate of Exemption of Review</x-formbanner>

    <h1 class="text-base font-bold text-center underline my-4">CERTIFICATE OF EXEMPTION OF REVIEW TEMPLATE</h1>

    <div class="mx-8">
        <p class="italic">Date:</p>
        <p class="mt-2 h-4">
            {{ $date }}
        </p>

        <div class="mt-4">
            <p class="font-bold italic uppercase">
                {{ $pi->user_Fname }} {{ $pi->user_MI }} {{ $pi->user_Lname }}
            </p>
            <p>
                Principal Investigator
            </p>
            <p class="italic">
                {{ $pi->user_College ?? 'Manila Central University' }}
            </p>
            <p class="italic">
                {{ $pi->user_Address ?? 'Manila, Philippines' }}
            </p>
        </div>
        <div class="mt-6">
            <p>
                Re: Study Protocol Title: {{ $research->research_title ?? 'Research Title' }}
            </p>
            <p class="font-bold mt-6">
                MCUERB Code:
                <label class="font-normal">
                    {{ $protocol->protocol_ID }}
                </label>
            </p>
            <p class="font-bold mt-4">
                Subject: Certificate of Exemption from Review
            </p>
            <p class="mt-3">
                Dear {{ $pi->user_Fname }} {{ $pi->user_Lname }},
            </p>
            <p class="mt-2">
                This is to acknowledge submission of the following documents (include version numbers and dates)
            <ul class="mx-8 mt-2">
                <li class="list-disc">Research Protocol - Version 1.0, {{ $date }}</li>
                <li class="list-disc">Informed Consent Form - Version 1.0, {{ $date }}</li>
                <li class="list-disc">Data Collection Tools - Version 1.0, {{ $date }}</li>
            </ul>
            </p>
            <p class="mt-2">
                After a preliminary review of the above documents, MCUERB deemed it appropriate that the above proposal
                be EXEMPTED FROM REVIEW.
            </p>
            <p class="mt-4">
                This means that the study may be implemented without undergoing expedited or full review. Neither will
                the proponents be required to submit further documents to the committee as long as there is no amendment
                nor alteration in the protocol that will change the nature of the study nor the level of risks involved.
                A Final Report (MCUERB FORM 3(L) Final Report) must be submitted 30 days after the completion of
                research together with the final manuscript.
            </p>
            <p class="mt-4">
                Very truly yours,<br>
                ERB Chair
            </p>
        </div>
    </div>
</body>

</html>