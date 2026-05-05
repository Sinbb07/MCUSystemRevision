<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>FORM-3D</title>
    @vite('resources/css/app.css') {{-- Tailwind --}}
    <style>
        .page-break {
            break-before: page;
        }
    </style>
</head>

<body class="p-2 text-sm font-arial">
    <h1 class="text-xl font-times font-black text-center mb-6">MCUERB FORM 3(D) Application for Review of Amendment</h1>

    <x-formbanner>MCUERB FORM 3(D) Application for Review of Amendment</x-formbanner>

    <h1 class="text-base font-bold text-center underline mb-4">Application for Review of Amendment</h1>

    <div class="flex flex-col border">
        <div class="flex items-stretch">
            <!-- ORIGINAL MCUERB CODE -->
            <div class="w-[30.00%] text-sm border-r flex items-center ml-2">
                <p>Original MCUERB Code:</p>
            </div>
            <div class="w-[30.00%] border-r p-2">
                <p>{{ $mcuerbCode ?? '2025-S1-001' }}</p>
            </div>

            <!-- ORIGINAL APPROVAL DATE -->
            <div class="w-[13.00%] text-sm border-r ml-2">
                Original Approval Date:
            </div>
            <div class="flex-1 p-2">
                <p>{{ $form3d && $form3d->created_at ? $form3d->created_at->format('m/d/Y') : 'N/A' }}</p>
            </div>
        </div>
        <div class="flex items-stretch border-t">
            <!-- ORIGINAL RESEARCH TITLE -->
            <div class="w-[30.00%] py-1 text-sm border-r ml-2">
                <p>Original Research Title:</p>
            </div>
            <div class="flex-1 p-2">
                <p>{{ $researchInfo->research_title ?? 'N/A' }}</p>
            </div>
        </div>
        <div class="flex items-stretch border-t">
            <!-- AMENDED PROJECT TITLE -->
            <div class="w-[30.00%] py-1 text-sm border-r ml-2">
                <p>Amended Project Title (if applicable):</p>
            </div>
            <div class="flex-1 p-2">
                <p>N/A</p>
            </div>
        </div>
        <div class="flex items-stretch border-t">
            <!-- ORIGINAL PRINCIPAL INVESTIGATOR -->
            <div class="w-[30.00%] py-1 text-sm border-r ml-2">
                <p>Original Principal Investigator (PI):</p>
            </div>
            <div class="flex-1 p-2">
                <p>{{ $principalInvestigator }}</p>
            </div>
        </div>
        <div class="flex items-stretch border-t">
            <!-- INSTITUTION -->
            <div class="w-[30.00%] text-sm border-r ml-2">
                <p>Institution:</p>
            </div>
            <div class="flex-1 p-2">
                <p>{{ $researchInfo->research_school ?? 'N/A' }}</p>
            </div>
        </div>
        <div class="flex items-stretch border-t">
            <!-- EMAIL -->
            <div class="w-[30.00%] text-sm border-r ml-2">
                <p>Email:</p>
            </div>
            <div class="flex-1 p-2">
                <p>{{ $userEmail ?? auth()->user()->user_Email ?? 'N/A' }}</p>
            </div>
        </div>
        <div class="flex items-stretch border-t">
            <!-- DATE SUBMITTED -->
            <div class="w-[30.00%] py-1 text-sm border-r ml-2">
                <p>Date Submitted:</p>
            </div>
            <div class="flex-1 p-2">
                <p>{{ now()->format('m/d/Y') }}</p>
            </div>
        </div>
    </div>

    <div class="mt-4"></div>

    <div class="flex flex-col border">
        <div class="mx-2">
            <p>
                <b>Simple, non-substantial amendments</b> which do not alter or bring any additional ethical
                considerations should be recorded but do not require ethical review. Check the boxes if any of the
                following apply to your application:
            </p>
        </div>
        <!-- NO.1 -->
        <div class="flex">
            <div class="py-1 w-[95.00%] border-t">
                <p class="mx-2">Addition or removal of researchers (if yes, add details below)</p>
            </div>
            <div class="flex-1 py-1 px-2 border-l border-t">
                <input type="checkbox" class="my-auto" {{ $form3d->add_remove ? 'checked' : '' }}>
            </div>
        </div>
        <div class="flex">
            <div class="py-1 w-[95.00%] border-t">
                <p class="mx-2">{{ $form3d->add_remove ?? '' }}</p>
            </div>
            <div class="flex-1 py-1 px-2 pb-16 border-l border-t"></div>
        </div>

        <!-- NO.2 -->
        <div class="flex">
            <div class="py-1 w-[95.00%] border-t">
                <p class="mx-2">Addition of a new research method (if yes, add details below)</p>
            </div>
            <div class="flex-1 py-1 px-2 border-l border-t">
                <input type="checkbox" class="my-auto" {{ $form3d->add_methods ? 'checked' : '' }}>
            </div>
        </div>
        <div class="flex">
            <div class="py-1 w-[95.00%] border-t">
                <p class="mx-2">{{ $form3d->add_methods ?? '' }}</p>
            </div>
            <div class="flex-1 py-1 px-2 pb-12 border-l border-t"></div>
        </div>

        <!-- NO.3 -->
        <div class="flex">
            <div class="py-1 w-[95.00%] border-t">
                <p class="mx-2">Ask for additional data from your existing participants (if yes, add details below)</p>
            </div>
            <div class="flex-1 py-1 px-2 border-l border-t">
                <input type="checkbox" class="my-auto" {{ $form3d->additional_data ? 'checked' : '' }}>
            </div>
        </div>
        <div class="flex">
            <div class="py-1 w-[95.00%] border-t">
                <p class="mx-2">{{ $form3d->additional_data ?? '' }}</p>
            </div>
            <div class="flex-1 py-1 px-2 pb-14 border-l border-t"></div>
        </div>

        <!-- NO.4 -->
        <div class="flex">
            <div class="py-1 w-[95.00%] border-t">
                <p class="mx-2">Remove a group of participants or a research method from the project, and have not yet commenced that part of the project (if yes, add details below)</p>
            </div>
            <div class="flex-1 py-1 px-2 border-l border-t">
                <input type="checkbox" class="my-auto" {{ $form3d->remove_participants ? 'checked' : '' }}>
            </div>
        </div>
        <div class="flex">
            <div class="py-1 w-[95.00%] border-t">
                <p class="mx-2">{{ $form3d->remove_participants ?? '' }}</p>
            </div>
            <div class="flex-1 py-1 px-2 pb-16 border-l border-t"></div>
        </div>
    </div>

    <!-- Page 2 -->
    <div class="page-break"></div>

    <div class="flex flex-col border">
        <!-- NO.5 -->
        <div class="flex">
            <div class="py-1 w-[95.00%]">
                <p class="mx-2">Minor changes to study documents such as spelling and grammar, correcting errors, or updates to contact details to reflect changes in the research team (if yes, add details below)</p>
            </div>
            <div class="flex-1 py-1 px-2 border-l">
                <input type="checkbox" class="my-auto" {{ $form3d->minor_changes ? 'checked' : '' }}>
            </div>
        </div>
        <div class="flex">
            <div class="py-1 w-[95.00%] border-t">
                <p class="mx-2">{{ $form3d->minor_changes ?? '' }}</p>
            </div>
            <div class="flex-1 py-1 px-2 pb-14 border-l border-t"></div>
        </div>

        <!-- NO.6 -->
        <div class="flex">
            <div class="py-1 w-[95.00%] border-t">
                <p class="mx-2">Apply for an extension to your current ethical approval (if yes, add details below)</p>
            </div>
            <div class="flex-1 py-1 px-2 border-l border-t">
                <input type="checkbox" class="my-auto" {{ $form3d->extension ? 'checked' : '' }}>
            </div>
        </div>
        <div class="flex">
            <div class="py-1 w-[95.00%] border-t">
                <p class="mx-2">{{ $form3d->extension ?? '' }}</p>
            </div>
            <div class="flex-1 py-1 px-2 pb-12 border-l border-t"></div>
        </div>

        <!-- NO.7 -->
        <div class="flex">
            <div class="py-1 w-[95.00%] border-t">
                <p class="mx-2">
                    If you have checked any of these then review the following statements.
                <ul class="list-disc ml-10 mt-2">
                    <li>These are the only changes requested</li>
                    <li>These changes do not alter or add to the ethical considerations as described in the original application</li>
                </ul>
                </p>
                <br><br>
                <p class="mx-2">If these <b>all</b> apply, check the box. Otherwise, use the FULL AMENDMENT APPLICATION</p>
            </div>
            <div class="flex-1 py-1 px-2 border-l border-t">
                <input type="checkbox" class="my-auto" {{ $form3d->confirmation_all_changes ? 'checked' : '' }}>
            </div>
        </div>
    </div>
    <div>
        <p class="text-center font-bold mt-4 mb-2 underline">Ethical Amendment (Simple) - Document Checklist</p>
        <p class="text-center mx-12 mt-2 mb-2">Please ensure that you have included copies of any documents listed below, if those documents are part of the project paperwork and have been amended, even if only slightly.</p>

        <p class="text-center mx-12 mt-2 mb-2">For online research you may include relevant screenshots or excerpts of text instead of forms.</p>

        <p class="font-bold text-center mx-12 mt-2 mb-2">If all relevant documents are not included, your amendment application will be returned without review</p>

        <div class="mx-12 border border-darkgray">
            <div><div class="flex ml-2 py-1">Ethical Amendment Application Form (Simple)</div></div>
            <div class="border-t border-darkgray"><div class="flex ml-2 py-1">Amended Advertisements (online/paper)</div></div>
            <div class="border-t border-darkgray"><div class="flex ml-2 py-1">Amended letters to parents/guardians/children</div></div>
            <div class="border-t border-darkgray"><div class="flex ml-2 py-1">Amended Participant Information Sheet</div></div>
            <div class="border-t border-darkgray"><div class="flex ml-2 py-1">Amended Participant Consent Form</div></div>
            <div class="border-t border-darkgray"><div class="flex ml-2 py-1">Amended Participant Debriefing Form</div></div>
            <div class="border-t border-darkgray"><div class="flex ml-2 py-1">Amended external permissions: forms / emails / NHS approvals (in full)</div></div>
        </div>
    </div>

    <!-- Page 3 -->
    <div class="page-break"></div>

    <div>
        <p class="mx-8">Please list below any other documents that are included with this application:</p>
        <div class="mx-8 mt-2 border pb-2 h-24">
            <div class="mx-2 text-sm w-full">
                {{ $form3d->other_documents ?? '' }}
            </div>
        </div>
    </div>

    <div>
        <p class="mx-8 mt-4 mb-2">
            Under <b>no circumstances</b> should this form, or supplementary
            documents, contain identifiable information about your participants i.e. completed consent forms
        </p>

        <div class="mx-8 border">
            <div class="flex items-stretch">
                <div class="pb-2 w-[23.00%] text-sm border-r flex items-center ml-2">
                    <p>Applicant PI's Signature:</p>
                </div>
                <div class="w-[35.00%] border-r p-2">
                    <p>{{ $principalInvestigator }}</p>
                </div>
                <div class="w-[10.00%] text-sm border-r ml-2">
                    Date:
                </div>
                <div class="flex-1 p-2">
                    <p>{{ now()->format('m/d/Y') }}</p>
                </div>
            </div>
            <div class="flex items-stretch border-t">
                <div class="pb-2 w-[23.00%] text-sm border-r flex items-center ml-2">
                    <p>Noted by the Thesis Adviser:</p>
                </div>
                <div class="w-[35.00%] border-r p-2">
                    <p>{{ $form3d->thesisadviser ?? '' }}</p>
                </div>
                <div class="w-[10.00%] text-sm border-r ml-2">
                    Date:
                </div>
                <div class="flex-1 p-2">
                    <p>{{ now()->format('m/d/Y') }}</p>
                </div>
            </div>
            <div class="flex items-stretch border-t">
                <div class="pb-2 w-[23.00%] text-sm border-r flex items-center ml-2">
                    <p>Approved by the Research Coordinator:</p>
                </div>
                <div class="w-[35.00%] border-r p-2">
                    <p>{{ $form3d->coordinator ?? '' }}</p>
                </div>
                <div class="w-[10.00%] text-sm border-r ml-2">
                    Date:
                </div>
                <div class="flex-1 p-2">
                    <p>{{ now()->format('m/d/Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>