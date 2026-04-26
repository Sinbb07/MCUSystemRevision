<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>IACUC-PROTOCOL-REVIEW-CHECKLIST</title>
    @vite('resources/css/app.css') {{-- Tailwind --}}
    <style>
        .page-break {
            break-before: page;
        }
    </style>
</head>

<body class="font-arial text-sm">
    <x-iacucformbanner>IACUC PROTOCOL REVIEW CHECKLIST</x-iacucformbanner>

    <div class="mt-10 mx-10 border">
        <div class="ml-1 mt-2 mb-2">
            <div class="flex">
                <!-- IACUC PROTOCOL NO. -->
                <p class="font-bold">
                    IACUC Protocol No:
                </p>
                <p class="border border-t-0 border-l-0 border-r-0 border-b-2 h-5 ml-1 w-80">
                    {{ $protocol_data->protocol_ID ?? $form->protocol_ID ?? 'N/A' }}
                </p>

                <!-- DATE -->
                <p class="ml-1 font-bold">
                    Date:
                </p>
                <p class="border border-t-0 border-l-0 border-r-0 border-b-2 h-5 ml-1 w-24">
                    {{ now()->format('Y-m-d') }}
                </p>
            </div>
        </div>

        <div class="ml-1 mt-3 mb-2">
            <div class="flex">
                <!-- STUDY PROTOCOL TITLE -->
                <p class="font-bold">
                    Study Protocol Title:
                </p>
                <p class="border border-t-0 border-l-0 border-r-0 border-b-2 h-5 ml-1 w-96">
                    {{ $form->study_title ?? $protocol_data->researchInformation->research_title ?? 'N/A' }}
                </p>
            </div>
        </div>

        <div class="ml-1 mt-3 mb-2">
            <div class="flex">
                <!-- PI/RESPONSIBLE PERSON -->
                <p class="font-bold">
                    PI/Resp. Person
                </p>
                <p class="border border-t-0 border-l-0 border-r-0 border-b-2 h-5 ml-1 w-64">
                    {{ $form->pi_person ?? $pi->full_name ?? $pi->user_Fname . ' ' . ($pi->user_Lname ?? '') }}
                </p>

                <!-- ADVISER -->
                <p class="ml-1 font-bold">
                    Adviser
                </p>
                <p class="border border-t-0 border-l-0 border-r-0 border-b-2 h-5 ml-1 w-40">
                    {{ $form->adviser ?? 'N/A' }}
                </p>
            </div>
        </div>

        <div class="border-t mt-5">
            <!-- HEADER -->
            <div class="flex font-bold">
                <div class="border-r py-1 w-[45.00%]">
                    <p class="text-center items-center">All Protocols</p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center">YES</p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center">NO</p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center">N/A</p>
                </div>
                <div class="py-1 w-[34.00%]">
                    <p class="text-center items-center">COMMENTS</p>
                </div>
            </div>

            <!-- QUESTION 1 -->
            <div class="flex border-t">
                <div class="border-r py-1 w-[45.00%]">
                    <p class="mx-1 items-center">
                        Has a satisfactory review of scientific merit been performed?
                    </p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="py-1 w-[34.00%]">
                    <p class="items-center mx-1">{{ $form->scientific_merit_comment ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- QUESTION 2 -->
            <div class="flex border-t">
                <div class="border-r py-1 w-[45.00%]">
                    <p class="mx-1 items-center">
                        Are the training and experience of the individuals performing the procedures satisfactory?
                    </p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="py-1 w-[34.00%]">
                    <p class="items-center mx-1">{{ $form->training_experience_comment ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- QUESTION 3 -->
            <div class="flex border-t">
                <div class="border-r py-1 w-[45.00%]">
                    <p class="mx-1 items-center">
                        Is the overview section completed in layman's terms?
                    </p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="py-1 w-[34.00%]">
                    <p class="items-center mx-1">{{ $form->overview_section_comment ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- QUESTION 4 -->
            <div class="flex border-t">
                <div class="border-r py-1 w-[45.00%]">
                    <p class="mx-1 items-center">
                        Is the rationale/justification/alternative for using the specified vertebrate animals complete?
                    </p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="py-1 w-[34.00%]">
                    <p class="items-center mx-1">{{ $form->rational_justification_comment ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- QUESTION 5 -->
            <div class="flex border-t">
                <div class="border-r py-1 w-[45.00%]">
                    <p class="mx-1 items-center">
                        Is there adequate justification for the number of animals requested?
                    </p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="py-1 w-[34.00%]">
                    <p class="items-center mx-1">{{ $form->adequate_justification_comment ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- QUESTION 6 -->
            <div class="flex border-t">
                <div class="border-r py-1 w-[45.00%]">
                    <p class="mx-1 items-center">
                        Is the documentation of unnecessary duplication and/or pain and distress complete?
                    </p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="py-1 w-[34.00%]">
                    <p class="items-center mx-1">{{ $form->unnecessary_duplication_comment ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- QUESTION 7 -->
            <div class="flex border-t">
                <div class="border-r py-1 w-[45.00%]">
                    <p class="mx-1 items-center">
                        Are the experimental procedures for the animal clear and precise?
                    </p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="py-1 w-[34.00%]">
                    <p class="items-center mx-1">{{ $form->experimental_procedures_comment ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- QUESTION 8 -->
            <div class="flex border-t">
                <div class="border-r py-1 w-[45.00%]">
                    <p class="mx-1 items-center">
                        Are the experimental endpoints and duration of experiments clear?
                    </p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="py-1 w-[34.00%]">
                    <p class="items-center mx-1">{{ $form->endpoint_duration_comment ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- QUESTION 9 -->
            <div class="flex border-t">
                <div class="border-r py-1 w-[45.00%]">
                    <p class="mx-1 items-center">
                        Is the pain category appropriate for the research being done?
                    </p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="py-1 w-[34.00%]">
                    <p class="items-center mx-1">{{ $form->pain_category_comment ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- QUESTION 10 -->
            <div class="flex border-t">
                <div class="border-r py-1 w-[45.00%]">
                    <p class="mx-1 items-center">
                        If alternative housing and husbandry methods are proposed, are they acceptable and justified?
                    </p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="py-1 w-[34.00%]">
                    <p class="items-center mx-1">{{ $form->alternative_housing_comment ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Page 2 -->
    <div class="page-break"></div>

    <div class="mx-10 border">
        <div>
            <!-- HEADER -->
            <div class="flex font-bold">
                <div class="border-r py-1 w-[45.00%]">
                    <p class="text-center items-center">As applicable</p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center">YES</p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center">NO</p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center">N/A</p>
                </div>
                <div class="py-1 w-[34.00%]">
                    <p class="text-center items-center">COMMENTS</p>
                </div>
            </div>

            <!-- QUESTION 1 -->
            <div class="flex border-t">
                <div class="border-r py-1 w-[45.00%]">
                    <p class="mx-1 items-center">
                        If hazardous material use is proposed, are appropriate measures described for handling?
                    </p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="py-1 w-[34.00%]">
                    <p class="items-center mx-1">{{ $form->hazardous_material_comment ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- QUESTION 2 -->
            <div class="flex border-t">
                <div class="border-r py-1 w-[45.00%]">
                    <p class="mx-1 items-center">
                        If multiple survival surgery is proposed, is the scientific justification adequate?
                    </p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="py-1 w-[34.00%]">
                    <p class="items-center mx-1">{{ $form->multiple_survival_comment ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- QUESTION 3 -->
            <div class="flex border-t">
                <div class="border-r py-1 w-[45.00%]">
                    <p class="mx-1 items-center">
                        If pain relief would be withheld, is the scientific justification adequate?
                    </p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="py-1 w-[34.00%]">
                    <p class="items-center mx-1">{{ $form->pain_relief_comment ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- QUESTION 4 -->
            <div class="flex border-t">
                <div class="border-r py-1 w-[45.00%]">
                    <p class="mx-1 items-center">
                        If animals may become seriously ill or debilitated, are criteria for interventional euthanasia defined?
                    </p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="py-1 w-[34.00%]">
                    <p class="items-center mx-1">{{ $form->ill_debilitated_comment ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- QUESTION 5 -->
            <div class="flex border-t">
                <div class="border-r py-1 w-[45.00%]">
                    <p class="mx-1 items-center">
                        Do you anticipate complications to the procedures not considered by the investigator?
                    </p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="py-1 w-[34.00%]">
                    <p class="items-center mx-1">{{ $form->complications_comment ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- BREAK -->
            <div class="border-t border-b h-8"></div>

            <!-- HEADER -->
            <div class="flex font-bold">
                <div class="border-r py-1 w-[45.00%]">
                    <p class="text-center items-center">Veterinary Review</p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center">YES</p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center">NO</p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center">N/A</p>
                </div>
                <div class="py-1 w-[34.00%]">
                    <p class="text-center items-center">COMMENTS</p>
                </div>
            </div>

            <!-- QUESTION 1 - Veterinary -->
            <div class="flex border-t">
                <div class="border-r py-1 w-[45.00%]">
                    <p class="mx-1 items-center">
                        Do you anticipate complications to the procedures not considered by the Investigator?
                    </p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="py-1 w-[34.00%]">
                    <p class="items-center mx-1">{{ $form->veterinary_complications_comment ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- QUESTION 2 - Veterinary -->
            <div class="flex border-t">
                <div class="border-r py-1 w-[45.00%]">
                    <p class="mx-1 items-center">
                        Are the proposed anesthesia and analgesia appropriate?
                    </p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="py-1 w-[34.00%]">
                    <p class="items-center mx-1">{{ $form->proposed_anesthesia_comment ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- QUESTION 3 - Veterinary -->
            <div class="flex border-t">
                <div class="border-r py-1 w-[45.00%]">
                    <p class="mx-1 items-center">
                        Are post-procedural care and observation adequate?
                    </p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="py-1 w-[34.00%]">
                    <p class="items-center mx-1">{{ $form->post_procedural_comment ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- QUESTION 4 - Veterinary -->
            <div class="flex border-t">
                <div class="border-r py-1 w-[45.00%]">
                    <p class="mx-1 items-center">
                        Are the methods of euthanasia appropriate?
                    </p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="border-r py-1 w-[7.00%]">
                    <p class="text-center items-center"></p>
                </div>
                <div class="py-1 w-[34.00%]">
                    <p class="items-center mx-1">{{ $form->appropriate_method_comment ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- BREAK -->
        <div class="border-t h-8"></div>

        <div class="border-t p-1">
            <div class="flex">
                <!-- IACUC PROTOCOL NO. -->
                <p class="font-bold">
                    IACUC Protocol No:
                </p>
                <p class="border border-t-0 border-l-0 border-r-0 border-b-2 h-5 ml-1 w-80">
                    {{ $protocol_data->protocol_ID ?? $form->protocol_ID ?? 'N/A' }}
                </p>

                <!-- DATE -->
                <p class="ml-1 font-bold">
                    Date:
                </p>
                <p class="border border-t-0 border-l-0 border-r-0 border-b-2 h-5 ml-1 w-24">
                    {{ now()->format('Y-m-d') }}
                </p>
            </div>
            <div class="mt-3 grid grid-cols-2 gap-y-2">
                <div class="flex space-x-1">
                    <input type="checkbox" class="mt-0.5 h-[14px] w-[14px]">
                    <span>RECOMMENDATION</span>
                </div>
                <div class="flex space-x-1">
                    <input type="checkbox" class="mt-0.5 h-[14px] w-[14px]">
                    <span>APPROVED</span>
                </div>
                <div class="flex space-x-1">
                    <input type="checkbox" class="mt-0.5 h-[14px] w-[14px]">
                    <span>EXEMPTED</span>
                </div>
                <div class="flex space-x-1">
                    <input type="checkbox" class="mt-0.5 h-[14px] w-[14px]">
                    <span>REQUIRE REVISION</span>
                </div>
                <div class="flex space-x-1">
                    <input type="checkbox" class="mt-0.5 h-[14px] w-[14px]">
                    <span>NEED FURTHER INFORMATION</span>
                </div>
                <div class="flex space-x-1">
                    <input type="checkbox" class="mt-0.5 h-[14px] w-[14px]">
                    <span>FOR FULL REVIEW</span>
                </div>
                <div class="flex space-x-1">
                    <input type="checkbox" class="mt-0.5 h-[14px] w-[14px]">
                    <span>DISAPPROVED</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Page 3 -->
    <div class="page-break"></div>

    <div class="mx-10 border">
        <div class="font-bold m-1">
            <p>Summary/Comments:</p>
        </div>
        <div class="border border-darkgray mb-2 mx-2 h-56">
            <p class="mx-1">
                {{ $form->summary_comments ?? 'N/A' }}
            </p>
        </div>
    </div>

    <!-- REVIEWER, IACUC CHAIR, SIGNATURE & DATE -->
    <div class="mx-10 mt-10">
        <div class="flex">
            <!-- REVIEWER -->
            <p class="font-bold">
                Reviewer:
            </p>
            <p class="border border-t-0 border-l-0 border-r-0 border-b-2 h-5 ml-1 w-52">
                {{ $reviewer->user_Fname ?? '' }} {{ $reviewer->user_Lname ?? '' }}
            </p>

            <!-- SIGNATURE -->
            <p class="ml-3 font-bold">
                Signature:
            </p>
            <p class="border border-t-0 border-l-0 border-r-0 border-b-2 h-5 ml-1 w-36">
                {{-- Signature field - leave blank for physical signature --}}
            </p>

            <!-- DATE -->
            <p class="ml-1 font-bold">
                Date:
            </p>
            <p class="border border-t-0 border-l-0 border-r-0 border-b-2 h-5 ml-1 w-16">
                {{ now()->format('Y-m-d') }}
            </p>
        </div>
        <div class="my-10">
            <p class="font-bold">
                Attested by:
            </p>
        </div>

        <div class="flex">
            <!-- IACUC CHAIR -->
            <p class="font-bold">
                IACUC Chair:
            </p>
            <p class="border border-t-0 border-l-0 border-r-0 border-b-2 h-5 ml-1 w-48">
                {{-- IACUC Chair name - leave blank or can be populated from settings --}}
            </p>

            <!-- SIGNATURE -->
            <p class="ml-1 font-bold">
                Signature:
            </p>
            <p class="border border-t-0 border-l-0 border-r-0 border-b-2 h-5 ml-1 w-36">
                {{-- Signature field - leave blank for physical signature --}}
            </p>

            <!-- DATE -->
            <p class="ml-1 font-bold">
                Date:
            </p>
            <p class="border border-t-0 border-l-0 border-r-0 border-b-2 h-5 ml-1 w-16">
                {{ now()->format('Y-m-d') }}
            </p>
        </div>
    </div>
</body>

</html> 