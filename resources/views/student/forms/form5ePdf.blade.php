<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>FORM-5(E)</title>
    @vite('resources/css/app.css') {{-- loads Tailwind --}}
</head>
<style>
    .page-break {
        break-before: page;
    }
</style>

<body class="p-8 text-sm font-arial">
    <h1 class="text-xl font-times font-black text-center mb-6">MCUERB FORM 5 (E) Document History</h1>

    <x-formbanner>MCUERB FORM 5 (E) Document History</x-formbanner>

    <h1 class="text-base font-bold text-center underline mb-4">DOCUMENT HISTORY</h1>

    <div class="flex flex-col border">
        <div class="w-full">
            <p class="text-sm font-bold text-center m-1">TO BE FILLED OUT BY PRINCIPAL INVESTIGATOR (PI)</p>
        </div>
        <div class="flex items-center border-t">
            <div class="px-2 w-1/4 border-r">
                <p class="text-sm font-bold text-l mb-2">MCUERB CODE:
                <p class="text-sm text-l italic mb-2">(To be filled out by MCUERB Staff)</p>
                </p>
            </div>
            <p class="text-sm text-l mb-2"><!---{{ $protocol->mcuerb_code }}--></p>
        </div>
        <div class="flex items-center border-t">
            <div class="px-2 w-1/4 border-r">
                <p class="text-sm font-bold text-l mb-2">Study Protocol Title</p>
            </div>
            <p class="text-sm text-l mb-2"><!---{{ $protocol->mcuerb_code }}--></p>
        </div>
        <div class="flex items-center border-t">
            <div class="px-2 w-1/4 border-r">
                <p class="text-sm font-bold text-l mb-2">Principal Investigator (PI)</p>
            </div>
            <p class="text-sm text-l mb-2"><!---{{ $protocol->mcuerb_code }}--></p>
        </div>
        <div class="flex items-center border-t">
            <div class="px-2 w-1/4 border-r">
                <p class="text-sm font-bold text-l mb-2">Co-Investigators</p>
            </div>
            <p class="text-sm text-l mb-2"><!---{{ $protocol->mcuerb_code }}--></p>
        </div>
        <div class="flex items-center border-t">
            <div class="px-2 w-1/4 border-r">
                <p class="text-sm font-bold text-l mb-2">PI Contact Numbers</p>
            </div>
            <p class="text-sm text-l mb-2"><!---{{ $protocol->mcuerb_code }}--></p>
        </div>
        <div class="flex items-center border-t">
            <div class="px-2 w-1/4 border-r">
                <p class="text-sm font-bold text-l mb-2">PI Email Address</p>
            </div>
            <p class="text-sm text-l mb-2"><!---{{ $protocol->mcuerb_code }}--></p>
        </div>
        <div class="flex items-center border-t">
            <div class="px-2 w-1/4 border-r">
                <p class="text-sm font-bold text-l mb-2">Institution</p>
            </div>
            <p class="text-sm text-l mb-2"><!---{{ $protocol->mcuerb_code }}--></p>
        </div>
        <div class="flex items-center border-t">
            <div class="px-2 w-1/4 border-r">
                <p class="text-sm font-bold text-l mb-2">Address of Institution</p>
            </div>
            <p class="text-sm text-l mb-2"><!---{{ $protocol->mcuerb_code }}--></p>
        </div>
        <div class="flex items-center border-t">
            <div class="px-2 w-1/4 border-r">
                <p class="text-sm font-bold text-l mb-2">Ethics Review Board Contact</p>
            </div>
            <p class="text-sm text-l mb-2"><!---{{ $protocol->mcuerb_code }}--></p>
        </div>
    </div>

    <div class="flex flex-col border mt-12">
        <div class="flex items-stretch">
            <div class="px-2 w-[20%] border-r">
                <p class="text-sm font-bold text-l mb-2">Version</p>
            </div>
            <div class="px-2 w-[20%] border-r">
                <p class="text-sm font-bold text-l mb-2">Date</p>
            </div>
            <div class="px-2 w-[60%]">
                <p class="text-sm font-bold text-l mb-2">Describe what is submitted from initial submission and describe
                    the main change/revision</p>
            </div>
        </div>
        <div class="flex items-stretch border-t">
            <div class="px-2 w-[20%] border-r">
                <p class="text-sm text-l mb-2">
                    {{-- version --}}
                </p>
            </div>
            <div class="px-2 w-[20%] border-r">
                <p class="text-sm italic text-l mb-2">
                    dd-mm-yyyy
                    {{-- date --}}
                </p>
            </div>
            <div class="px-2 w-[60%]">
                <p class="text-sm italic text-l">
                    1. Initial Documents
                </p>
                <p class="text-sm italic text-l">
                    2.
                </p>
                <p class="text-sm italic text-l">
                    3.
                </p>
                <p class="text-sm italic text-l">
                    4.
                </p>
            </div>
        </div>
    </div>

    <!-- Page 2 -->
    <div class="page-break"></div>

    <div class="flex flex-col border">
        <div class="flex items-stretch">
            <div class="px-2 w-[20%] border-r">
                <p class="text-sm font-bold text-l mb-2">Version</p>
            </div>
            <div class="px-2 w-[20%] border-r">
                <p class="text-sm font-bold text-l mb-2">Date</p>
            </div>
            <div class="px-2 w-[60%]">
                <p class="text-sm font-bold text-l mb-2">Describe what is submitted from initial submission and describe
                    the main change/revision</p>
            </div>
        </div>
        <div class="flex items-stretch border-t">
            <div class="px-2 w-[20%] border-r">
                <p class="text-sm font-bold text-l mb-2">
                    {{-- version --}}
                </p>
            </div>
            <div class="px-2 w-[20%] border-r">
                <p class="text-sm italic text-l mb-2">
                    dd-mm-yyyy
                    {{-- date --}}
                </p>
            </div>
            <div class="px-2 w-[60%]">
                <p class="text-sm italic text-l">
                    First draft
                </p>
                <p class="text-sm italic text-l">
                    Second draft
                </p>
                <p class="text-sm italic text-l">
                    Final Version
                </p>
                <p class="text-sm italic text-l">
                    Minor changes
                </p>
                <p class="text-sm italic text-l">
                    Major changes
                </p>
                <p class="text-sm italic text-l">
                    No change (routine review)
                </p>
                <p class="text-sm italic text-l mt-4">
                    Final Requirements
                <ul class="pl-4">
                    <li class="list-disc">MCUERB Form 3(C) - Progress Reports</li>
                    <li class="list-disc">MCUERB FORM 3L Final Report</li>
                    <li class="list-disc">Final Research Protocol</li>
                    <li class="list-disc">IMRAD Version</li>
                    <li class="list-disc">Plagiarism Certification</li>
                    <li class="list-disc">Grammar Certification</li>
                </ul>
                </p>
            </div>
        </div>
        <div class="flex items-stretch border-t">
            <div class="px-2 w-[20%] border-r">
                <p class="text-sm text-l my-1">
                    {{-- version --}}
                </p>
            </div>
            <div class="px-2 w-[20%] border-r">
                <p class="text-sm italic text-l my-1">
                    dd-mm-yyyy
                    {{-- date --}}
                </p>
            </div>
            <div class="px-2 w-[60%]">
                {{-- description --}}
            </div>
        </div>
        <div class="flex items-stretch border-t">
            <div class="px-2 w-[20%] border-r">
                <p class="text-sm text-l my-1">
                    {{-- version --}}
                </p>
            </div>
            <div class="px-2 w-[20%] border-r">
                <p class="text-sm italic text-l my-1">
                    dd-mm-yyyy
                    {{-- date --}}
                </p>
            </div>
            <div class="px-2 w-[60%]">
                {{-- description --}}
            </div>
        </div>
        <div class="flex items-stretch border-t">
            <div class="px-2 w-[20%] border-r">
                <p class="text-sm text-l my-1">
                    {{-- version --}}
                </p>
            </div>
            <div class="px-2 w-[20%] border-r">
                <p class="text-sm italic text-l my-1">
                    dd-mm-yyyy
                    {{-- date --}}
                </p>
            </div>
            <div class="px-2 w-[60%]">
                {{-- description --}}
            </div>
        </div>
        <div class="flex items-stretch border-t">
            <div class="px-2 w-[20%] border-r">
                <p class="text-sm text-l my-1">
                    {{-- version --}}
                </p>
            </div>
            <div class="px-2 w-[20%] border-r">
                <p class="text-sm italic text-l my-1">
                    dd-mm-yyyy
                    {{-- date --}}
                </p>
            </div>
            <div class="px-2 w-[60%]">
                {{-- description --}}
            </div>
        </div>
        <div class="flex items-stretch border-t">
            <div class="px-2 w-[20%] border-r">
                <p class="text-sm text-l my-1">
                    {{-- version --}}
                </p>
            </div>
            <div class="px-2 w-[20%] border-r">
                <p class="text-sm italic text-l my-1">
                    dd-mm-yyyy
                    {{-- date --}}
                </p>
            </div>
            <div class="px-2 w-[60%]">
                {{-- description --}}
            </div>
        </div>
    </div>
    <div class="mt-4">
        <p class="italic uppercase">Process Guide</p>
        <p class="pl-4 italic">1. Initial Documents</p>

        <p class="pl-8">a. Basic documents (must submit for initial review)</p>
        <div class="pl-12">
            <div>
                <input type="checkbox" class="w-4 h-4">
                <span>
                    Cover letter from the thesis/dissertion advisor/mentor with noted by the College Dean - for MCU
                    students
                </span>
            </div>
            <div>
                <input type="checkbox" class="w-4 h-4">
                <span>
                    Proof of enrollment (1 photocopied and e-copy of registration form) - for MCU students
                </span>
            </div>
            <div>
                <input type="checkbox" class="w-4 h-4">
                <span>
                    Proof of employment (letter of endorsement from direct supervisor) - for teaching, non-teaching,
                    and
                    administrative staff
                </span>
            </div>
            <div>
                <input type="checkbox" class="w-4 h-4">
                <span>
                    Letter from the thesis/dissertion advisor/mentor noted by the College Dean signifying that the
                    protocol had undergone and passed technical review
                </span>
            </div>
            <div>
                <input type="checkbox" class="w-4 h-4">
                <span>
                    Completed MCUERB FORM 2(B) APPLICATION FOR INITIAL REVIEW - 1 hard copy of printed and a soft
                    copy
                </span>
            </div>
            <div>
                <input type="checkbox" class="w-4 h-4">
                <span>
                    Completed MCUERB FORM 2(A) PROTOCOL REVIEW CHECKLIST
                </span>
            </div>
            <div>
                <input type="checkbox" class="w-4 h-4">
                <span>
                    Completed MCUERB FORM 2(D) INFORMED CONSENT CHECKLIST for PRINCIPAL INVESTIGATOR (PI)
                </span>
            </div>
        </div>
        <p class="pl-8 mt-4">b. Protocol Package (must submit for initial review)</p>
        <div class="pl-12">
            <div>
                <input type="checkbox" class="w-4 h-4">
                <span>
                    Study Protocol (Chapters I, II, III)
                </span>
            </div>
            <div>
                <input type="checkbox" class="w-4 h-4">
                <span>
                    MCUERB FORM 2(C) INFORMED CONSENT FORM - English Version
                </span>
            </div>
            <div>
                <input type="checkbox" class="w-4 h-4">
                <span>
                    MCUERB FORM 2(C) INFORMED CONSENT FORM - Filipino Version or in local language/dialect (if
                    applicable)
                </span>
            </div>
            <div>
                <input type="checkbox" class="w-4 h-4">
                <span>
                    Data collection forms/tools/instrument/questionnaire
                </span>
            </div>
        </div>
    </div>

    <!-- Page 3 -->
    <div class="page-break"></div>

    <div>
        <div>
            <div class="pl-12 mt-4">
                <div>
                    <input type="checkbox" class="w-4 h-4">
                    <span>
                        Certificates of Validators of the tool(s)/instrument(s)/questionnaire (at least three (3)
                        validators) - Researcher's developed tool (if applicable)
                    </span>
                </div>
                <div>
                    <input type="checkbox" class="w-4 h-4">
                    <span>
                        Child Assent for Children Ages 7-12 years - English Version (if applicable)
                    </span>
                </div>
                <div>
                    <input type="checkbox" class="w-4 h-4">
                    <span>
                        Child Assent for Children Ages 7-12 years - Filipino/Dialect Version (if applicable)
                    </span>
                </div>
                <div>
                    <input type="checkbox" class="w-4 h-4">
                    <span>
                        Child Assent for Children Ages 13-17 years - English Version (if applicable)
                    </span>
                </div>
                <div>
                    <input type="checkbox" class="w-4 h-4">
                    <span>
                        Child Assent for Children Ages 13-17 years - Filipino/Dialect Version (if applicable)
                    </span>
                </div>
                <div>
                    <input type="checkbox" class="w-4 h-4">
                    <span>
                        Recruitment advertisement(s) and/or Social Media Poster (as needed by the protocol) (if
                        applicable)
                    </span>
                </div>
                <div>
                    <input type="checkbox" class="w-4 h-4">
                    <span>
                        Curriculum Vitae of PI and study team members
                    </span>
                </div>
                <div>
                    <input type="checkbox" class="w-4 h-4">
                    <span>
                        Good Clinical Practice (GCP) or Health Research Ethics Training Certificate of PI and
                        Co-Investigators (GCP is required for clinical trials) obtained within the last three (3) years
                        (if
                        applicable)
                    </span>
                </div>
            </div>
        </div>
        <p class="pl-4 mt-4 italic">2. Resubmission</p>

        <p class="pl-8">a. Decision Letter with Recommendation and Action Taken</p>
        <p class="pl-8">b. MCUERB FORM 3(A) - <b>in word file</b></p>
        <p class="pl-8">c. MCUERB FORM 3(B) - <b>in word file</b></p>
        <p class="pl-8">d. <u>Revised copy of the manuscript with PAGE NUMBER and with the highlighted amendments</u>
        </p>
        <p class="pl-8">e. Revised ICF <i>(if applicable)</i></p>

        <p class="pl-4 mt-4 italic">3. First draft</p>
        <p class="pl-4 italic">4. Second draft</p>
        <p class="pl-4 italic">5. Final version</p>
        <p class="pl-4 italic">6. Minor changes</p>
        <p class="pl-4 italic">7. Major changes</p>
        <p class="pl-4 italic">8. No change (routine review)</p>

        <p class="pl-4 italic">9. For approval</p>
        <p class="pl-8">a. MCUERB Form 3(C) Progress Reports</p>
        <p class="pl-8">b. MCUERB Form 3(L) Final Report (for exempted)</p>
        <p class="pl-8">c. Latest Research Protocol</p>

        <p class="pl-4 mt-4 italic">10. Final requirements</p>
        <p class="pl-8">a. MCUERB Form 3(C) Progress Reports</p>
        <p class="pl-8">b. MCUERB Form 3(L) Final Report</p>
        <p class="pl-8">c. Final Research Protocol</p>
        <p class="pl-8">d. IMRAD Version</p>
        <p class="pl-8">e. Plagiarism Certification</p>
        <p class="pl-8">f. Grammar Certification</p>
    </div>

    <!-- Page 4 -->
    <div class="page-break"></div>

    <div>
        <p class="text-center font-bold text-lg font-times">Research Ethics Review Board Process</p>

        <p class="font-bold mt-8">1. Submission of Documents</p>
        <p>
            The ERB staff receives the required documents in an expandable plastic envelope and forwards them to the ERB
            Chair.
        </p>

        <p class="font-bold mt-2">2. Classification</p>
        <p>
            The ERB Chair categorizes the protocol as Expedited Review, Full Review, or Exempted.
        </p>

        <p class="font-bold mt-2">3. Assignment of Reviewers</p>
        <p>
            The ERB Chair assigns primary reviewers and provides them with a communication letter and evaluation forms.
        </p>

        <p class="font-bold mt-2">4. Primary Review</p>
        <p>
            Primary reviewers evaluate the documents and submit their feelings to the ERB Chair within three (3) days.
        </p>

        <p class="font-bold mt-2">5. Consolidation and Decision Letter</p>
        <p>
            The ERB Chair consolidates suggestions, recognitions, clarification, and amendment if applicable.<br>
            A decision letter is issued to the Principal Investigator (PI) with one of the following outcomes:<br>
        <ul class="mt-2 pl-8">
            <li class="list-disc">Resubmission</li>
            <li class="list-disc">Amendment</li>
            <li class="list-disc">Certificate of Approval and Ethical Clearance</li>
        </ul>
        </p>

        <p class="font-bold mt-4">6. Principal Investigator (PI) Response</p>
        <p>
            The PI responds to the instructions in the decision letter within 48 hours (two days) by submitting any
            required documents.
        </p>

        <p class="font-bold mt-2">7. Protocol Termination or Continued Review</p>
        <p>
        <div>
            The ERB terminates the protocol if the PI does not within 48 hours.
        </div>
        <div class="mt-2">
            For expedited reviews, resubmissions are reviewed, and results are provided within one (1) week.
        </div>
        <div class="mt-2">
            For full reviews, certain cases may require an additional seven (7) days, after which results are sent to
            the PI.
        </div>
        </p>

        <p class="font-bold mt-4">8. Second Response by PI</p>
        <p>
            The PI addresses the second decision letter by submitting the required actions and documents to the ERB.
        </p>

        <p class="font-bold mt-2">9. Final Approval</p>
        <p>
            The ERB issues a Certificate of Approval and Ethical Clearance to the PI, allowing the conduct of data
            collection.
        </p>
    </div>

    <!-- Page 5 -->
    <div class="page-break"></div>

    <div>
        <p class="font-bold mt-2">10. Submission of Reports</p>
        <div>
            <div>
                <p>
                    After the thesis final defense, the PI submits the following:
                </p>
                <ul class="pl-4 mt-2">
                    <li class="list-disc">Progress Report (3C)</li>
                    <li class="list-disc">Final Report (3L)</li>
                    <li class="list-disc">Revised Final Manuscript of Thesis</li>
                    <li class="list-disc">IMRAD Format of Final Thesis</li>
                    <li class="list-disc">Plagiarism and Grammar Certifications</li>
                </ul>
            </div>
        </div>

        <p class="font-bold mt-6">11. The ERB issues the Final Ethical Clearance</p>
        <p>
            The PI submits two (2) printed copies of the final manuscript (thesis) together with all required soft
            copies listed in item no. 10 to the ERB and the Institutional Research Office (IRO) for the issuance of the
            final ethical clearance
        </p>

        <div class="mt-16">
            <div class="flex grid grid-cols-2 gap-x-40">
                <div>
                    <p class="border-b-2">
                        {{-- name and signature --}}
                    </p>
                    <p class="flex">
                        (Name and Signature)<br>
                        THESIS ADVISER
                    </p>
                    <p>
                        DATE: {{-- date --}}
                    </p>
                </div>
                <div>
                    <p class="border-b-2">
                        {{-- name and signature --}}
                    </p>
                    <p class="flex">
                        (Name and Signature)<br>
                        RESEARCH COORDINATOR
                    </p>
                    <p>
                        DATE: {{-- date --}}
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>