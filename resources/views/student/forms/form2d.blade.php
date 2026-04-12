@section('title', 'Form 2(D)')
<x-student-layout>
    <main class="xl:ml-[335px] max-xl:ml-auto p-4 max-md:p-2">
        <form action="{{ route('form2d.store') }}" method="POST" class="block">
            @csrf
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <p class="text-right mt-3 mr-3 max-lg:text-sm max-md:text-sm max-sm:text-xs">FORM 2(D)</p>
                <h1
                    class="text-center mt-10 max-2xl:mt-6 max-lg:mt-6 max-md:mt-6 font-bold text-2xl max-xl:text-xl max-lg:text-lg max-md:text-base max-sm:text-sm mb-2 underline">
                    INFORMED CONSENT CHECKLIST FOR P.I.
                </h1>
            </div>
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <h2 class="px-3 py-2 font-bold text-lg max-2xl:text-base max-sm:text-sm">STUDY PROTOCOL INFORMATION</h2>
                <div class="p-3 mt-2 space-y-2 text-base max-sm:text-sm">
                    <div class="grid grid-cols-[max-content_1fr] max-sm:grid-cols-1 gap-x-20 gap-y-3 max-w-full">
                        <div class="font-bold">MCUERB Code:</div>
                        <div class="max-sm:mb-2">2025-S1-001</div>

                        <div class="font-bold">Study Protocol Title:</div>
                        <div class="max-sm:mb-2">{{ $researchInfo->research_title ?? '' }}</div>

                        <div class="font-bold">Principal Investigator (PI):</div>
                        <div class="max-sm:mb-2">{{ $principalInvestigator }}</div>

                        <div class="font-bold">PI Contact Numbers:</div>
                        <div class="max-sm:mb-2">09XX-XXX-XX74</div>

                        <div class="font-bold">Study Protocol Submission Date:</div>
                        <div class="max-sm:mb-2">2025-05-05</div>

                        <div class="font-bold">Study Protocol Review Date:</div>
                        <div class="max-sm:mb-2">2025-05-05</div>
                    </div>
                </div>
            </div>
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <p class="p-3 max-sm:text-sm/6">
                    Please indicate <b>YES</b> or <b>NO</b> in the space provided whether or not the informed consent
                    form (ICF) addresses the specified component of <b>NA</b> if Not Applicable. To facilitate the
                    evaluation of the assessment point, indicate the page and paragraph where this information can be
                    found.
                </p>
                <div class="p-3 mt-2 space-y-2 text-base max-sm:text-sm">
                    <h2 class="py-2 font-semibold text-lg max-2xl:text-base max-sm:text-sm">TO BE FILLED UP BY P.I.
                    </h2>
                    
                    <!-- Question 1 -->
                    <div class="border-b pb-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>1. Statement indicating the study involves research</span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-yes mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="study_involvement" value="Yes" data-target="textarea1">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-no mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="study_involvement" value="No" data-target="textarea1">
                                <span>No</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-na mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="study_involvement" value="NA" data-target="textarea1">
                                <span>NA</span>
                            </label>
                        </div>
                        <textarea name="statement_study_involve" id="textarea1"
                            placeholder="Page and paragraph where component is found"
                            class="mt-1 w-full resize-none max-sm:text-sm p-2 border rounded" disabled></textarea>
                    </div>

                    <!-- Question 2 -->
                    <div class="border-b pb-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>2. Statement indicating clearly the purpose of the study</span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-yes mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="study_purpose" value="Yes" data-target="textarea2">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-no mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="study_purpose" value="No" data-target="textarea2">
                                <span>No</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-na mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="study_purpose" value="NA" data-target="textarea2">
                                <span>NA</span>
                            </label>
                        </div>
                        <textarea name="statement_study_purpose" id="textarea2"
                            placeholder="Page and paragraph where component is found"
                            class="mt-1 w-full resize-none max-sm:text-sm p-2 border rounded" disabled></textarea>
                    </div>

                    <!-- Question 3 -->
                    <div class="border-b pb-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>3. Explanation to the study participants why they were included in the study</span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-yes mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="participant_inclusion" value="Yes" data-target="textarea3">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-no mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="participant_inclusion" value="No" data-target="textarea3">
                                <span>No</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-na mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="participant_inclusion" value="NA" data-target="textarea3">
                                <span>NA</span>
                            </label>
                        </div>
                        <textarea name="explanation_inclusion" id="textarea3"
                            placeholder="Page and paragraph where component is found"
                            class="mt-1 w-full resize-none max-sm:text-sm p-2 border rounded" disabled></textarea>
                    </div>

                    <!-- Question 4 -->
                    <div class="border-b pb-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>4. Provisions ensuring that the study participant's participation in the study is voluntary</span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-yes mt-1 max-sm:w-[14px] max-sm:h-[14px]" 
                                    name="voluntary" value="Yes" data-target="textarea4">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-no mt-1 max-sm:w-[14px] max-sm:h-[14px]" 
                                    name="voluntary" value="No" data-target="textarea4">
                                <span>No</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-na mt-1 max-sm:w-[14px] max-sm:h-[14px]" 
                                    name="voluntary" value="NA" data-target="textarea4">
                                <span>NA</span>
                            </label>
                        </div>
                        <textarea name="provisions" id="textarea4"
                            placeholder="Page and paragraph where component is found"
                            class="mt-1 w-full resize-none max-sm:text-sm p-2 border rounded" disabled></textarea>
                    </div>

                    <!-- Question 5 -->
                    <div class="border-b pb-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>5. Statement indicating that participation may be withdrawn anytime without penalty or loss of benefit to which the participant is entitled</span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-yes mt-1 max-sm:w-[14px] max-sm:h-[14px]" 
                                    name="withdraw" value="Yes" data-target="textarea5">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-no mt-1 max-sm:w-[14px] max-sm:h-[14px]" 
                                    name="withdraw" value="No" data-target="textarea5">
                                <span>No</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-na mt-1 max-sm:w-[14px] max-sm:h-[14px]" 
                                    name="withdraw" value="NA" data-target="textarea5">
                                <span>NA</span>
                            </label>
                        </div>
                        <textarea name="withdrawal_statement" id="textarea5"
                            placeholder="Page and paragraph where component is found"
                            class="mt-1 w-full resize-none max-sm:text-sm p-2 border rounded" disabled></textarea>
                    </div>

                    <!-- Question 6 -->
                    <div class="border-b pb-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>6. Statement explaining the nature and procedure of the study</span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-yes mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="study_nature" value="Yes" data-target="textarea6">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-no mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="study_nature" value="No" data-target="textarea6">
                                <span>No</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-na mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="study_nature" value="NA" data-target="textarea6">
                                <span>NA</span>
                            </label>
                        </div>
                        <textarea name="statement_study_nature" id="textarea6"
                            placeholder="Page and paragraph where component is found"
                            class="mt-1 w-full resize-none max-sm:text-sm p-2 border rounded" disabled></textarea>
                    </div>

                    <!-- Question 7 -->
                    <div class="border-b pb-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>7. Disclosure of the anticipated risks and benefits to the study participants disclosed?</span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-yes mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="risks_benefits" value="Yes" data-target="textarea7">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-no mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="risks_benefits" value="No" data-target="textarea7">
                                <span>No</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-na mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="risks_benefits" value="NA" data-target="textarea7">
                                <span>NA</span>
                            </label>
                        </div>
                        <textarea name="disclose_risks_benefits" id="textarea7"
                            placeholder="Page and paragraph where component is found"
                            class="mt-1 w-full resize-none max-sm:text-sm p-2 border rounded" disabled></textarea>
                    </div>

                    <!-- Question 8 -->
                    <div class="border-b pb-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>8. Statements indicating the potential benefits to the community or to society, or contributions to scientific knowledge stated</span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-yes mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="potential_benefits" value="Yes" data-target="textarea8">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-no mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="potential_benefits" value="No" data-target="textarea8">
                                <span>No</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-na mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="potential_benefits" value="NA" data-target="textarea8">
                                <span>NA</span>
                            </label>
                        </div>
                        <textarea name="potential_benefits_statement" id="textarea8"
                            placeholder="Page and paragraph where component is found"
                            class="mt-1 w-full resize-none max-sm:text-sm p-2 border rounded" disabled></textarea>
                    </div>

                    <!-- Question 9 -->
                    <div class="border-b pb-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>9. Provisions for the mitigation of risks in the protocol consistent with what is in the ICF?</span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-yes mt-1 max-sm:w-[14px] max-sm:h-[14px]" 
                                    name="mitigation" value="Yes" data-target="textarea9">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-no mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="mitigation" value="No" data-target="textarea9">
                                <span>No</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-na mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="mitigation" value="NA" data-target="textarea9">
                                <span>NA</span>
                            </label>
                        </div>
                        <textarea name="provision_mitigations" id="textarea9"
                            placeholder="Page and paragraph where component is found"
                            class="mt-1 w-full resize-none max-sm:text-sm p-2 border rounded" disabled></textarea>
                    </div>

                    <!-- Question 10 -->
                    <div class="border-b pb-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>10. Lists of alternative procedure(s) or course(s) of treatment that may be available to the participant and their important potential benefits and risks?</span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-yes mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="alternate_procedure" value="Yes" data-target="textarea10">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-no mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="alternate_procedure" value="No" data-target="textarea10">
                                <span>No</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-na mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="alternate_procedure" value="NA" data-target="textarea10">
                                <span>NA</span>
                            </label>
                        </div>
                        <textarea name="alternate_procedure_lists" id="textarea10"
                            placeholder="Page and paragraph where component is found"
                            class="mt-1 w-full resize-none max-sm:text-sm p-2 border rounded" disabled></textarea>
                    </div>

                    <!-- Question 11 -->
                    <div class="border-b pb-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>11. Statement informing study participant of his/her responsibilities</span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-yes mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="participant_responsibilities" value="Yes" data-target="textarea11">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-no mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="participant_responsibilities" value="No" data-target="textarea11">
                                <span>No</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-na mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="participant_responsibilities" value="NA" data-target="textarea11">
                                <span>NA</span>
                            </label>
                        </div>
                        <textarea name="statement_responsibilities" id="textarea11"
                            placeholder="Page and paragraph where component is found"
                            class="mt-1 w-full resize-none max-sm:text-sm p-2 border rounded" disabled></textarea>
                    </div>

                    <!-- Question 12 -->
                    <div class="border-b pb-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>12. Statement indicating if there are any anticipated expenses to the study participants in the course of the study</span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-yes mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="study_expenses" value="Yes" data-target="textarea12">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-no mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="study_expenses" value="No" data-target="textarea12">
                                <span>No</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-na mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="study_expenses" value="NA" data-target="textarea12">
                                <span>NA</span>
                            </label>
                        </div>
                        <textarea name="expenses_statement" id="textarea12"
                            placeholder="Page and paragraph where component is found"
                            class="mt-1 w-full resize-none max-sm:text-sm p-2 border rounded" disabled></textarea>
                    </div>

                    <!-- Question 13 -->
                    <div class="border-b pb-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>13. Statement indicating if there is a compensation and/or treatment available to the study participants in the event of study-relate injury.</span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-yes mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="compensation" value="Yes" data-target="textarea13">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-no mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="compensation" value="No" data-target="textarea13">
                                <span>No</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-na mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="compensation" value="NA" data-target="textarea13">
                                <span>NA</span>
                            </label>
                        </div>
                        <textarea name="compensation_statement" id="textarea13"
                            placeholder="Page and paragraph where component is found"
                            class="mt-1 w-full resize-none max-sm:text-sm p-2 border rounded" disabled></textarea>
                    </div>

                    <!-- Question 14 -->
                    <div class="border-b pb-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>14. Statement that the records identifying the participant will be kept confidential and will not be made publicly available, to the extent permitted by law; and that the identity of the participant will remain confidential in the even the study results are published; including limitations to the investigator's ability to guarantee confidentiality</span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-yes mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="participant_records" value="Yes" data-target="textarea14">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-no mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="participant_records" value="No" data-target="textarea14">
                                <span>No</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-na mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="participant_records" value="NA" data-target="textarea14">
                                <span>NA</span>
                            </label>
                        </div>
                        <textarea name="statement_participant_records" id="textarea14"
                            placeholder="Page and paragraph where component is found"
                            class="mt-1 w-full resize-none max-sm:text-sm p-2 border rounded" disabled></textarea>
                    </div>

                    <!-- Question 15 -->
                    <div class="border-b pb-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>15. Description of data protection plan and details about storage (including who has access to the study-related documents, how long identifying data will be stored, and manner of storage)</span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-yes mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="data_protection" value="Yes" data-target="textarea15">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-no mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="data_protection" value="No" data-target="textarea15">
                                <span>No</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-na mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="data_protection" value="NA" data-target="textarea15">
                                <span>NA</span>
                            </label>
                        </div>
                        <textarea name="data_protection_description" id="textarea15"
                            placeholder="Page and paragraph where component is found"
                            class="mt-1 w-full resize-none max-sm:text-sm p-2 border rounded" disabled></textarea>
                    </div>

                    <!-- Question 16 -->
                    <div class="border-b pb-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>16. Expected duration of the subject's participation in the study specified</span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-yes mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="study_duration" value="Yes" data-target="textarea16">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-no mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="study_duration" value="No" data-target="textarea16">
                                <span>No</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-na mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="study_duration" value="NA" data-target="textarea16">
                                <span>NA</span>
                            </label>
                        </div>
                        <textarea name="expected_study_duration" id="textarea16"
                            placeholder="Page and paragraph where component is found"
                            class="mt-1 w-full resize-none max-sm:text-sm p-2 border rounded" disabled></textarea>
                    </div>

                    <!-- Question 17 -->
                    <div class="border-b pb-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>17. Approximate number of study subjects stated</span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-yes mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="number_subject" value="Yes" data-target="textarea17">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-no mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="number_subject" value="No" data-target="textarea17">
                                <span>No</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-na mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="number_subject" value="NA" data-target="textarea17">
                                <span>NA</span>
                            </label>
                        </div>
                        <textarea name="approximate_number_subject" id="textarea17"
                            placeholder="Page and paragraph where component is found"
                            class="mt-1 w-full resize-none max-sm:text-sm p-2 border rounded" disabled></textarea>
                    </div>

                    <!-- Question 18 -->
                    <div class="border-b pb-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>18. Explanation whether the study participant will be offered the option of receiving overall study findings and results</span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-yes mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="findings_results" value="Yes" data-target="textarea18">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-no mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="findings_results" value="No" data-target="textarea18">
                                <span>No</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-na mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="findings_results" value="NA" data-target="textarea18">
                                <span>NA</span>
                            </label>
                        </div>
                        <textarea name="explanation_findings_results" id="textarea18"
                            placeholder="Page and paragraph where component is found"
                            class="mt-1 w-full resize-none max-sm:text-sm p-2 border rounded" disabled></textarea>
                    </div>

                    <!-- Question 19 -->
                    <div class="border-b pb-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>19. Person(s) to contact in the study team for further information regarding the study and whom to contact in the event of study-related injury indicated</span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-yes mt-1 max-sm:w-[14px] max-sm:h-[14px]" 
                                    name="contact" value="Yes" data-target="textarea19">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-no mt-1 max-sm:w-[14px] max-sm:h-[14px]" 
                                    name="contact" value="No" data-target="textarea19">
                                <span>No</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-na mt-1 max-sm:w-[14px] max-sm:h-[14px]" 
                                    name="contact" value="NA" data-target="textarea19">
                                <span>NA</span>
                            </label>
                        </div>
                        <textarea name="person_contact" id="textarea19"
                            placeholder="Page and paragraph where component is found"
                            class="mt-1 w-full resize-none max-sm:text-sm p-2 border rounded" disabled></textarea>
                    </div>

                    <!-- Question 20 -->
                    <div class="border-b pb-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>20. Statement that the MCUERB has approved the study, and may be reached through the following contact for information regarding rights of study participants, including grievances and complaints <br>
                                <b>Email Address:</b> erb@mcu.edu.ph<br>
                                <b>Contact Number:</b> (02) 8364 1071</span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-yes mt-1 max-sm:w-[14px] max-sm:h-[14px]" 
                                    name="approval" value="Yes" data-target="textarea20">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-no mt-1 max-sm:w-[14px] max-sm:h-[14px]" 
                                    name="approval" value="No" data-target="textarea20">
                                <span>No</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-na mt-1 max-sm:w-[14px] max-sm:h-[14px]" 
                                    name="approval" value="NA" data-target="textarea20">
                                <span>NA</span>
                            </label>
                        </div>
                        <textarea name="statement_approval" id="textarea20"
                            placeholder="Page and paragraph where component is found"
                            class="mt-1 w-full resize-none max-sm:text-sm p-2 border rounded" disabled></textarea>
                    </div>

                    <!-- Question 21 -->
                    <div class="border-b pb-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>21. Manifestation that the language and presentation of the information to be conveyed appropriate to the study participant</span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-yes mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="presentation_language" value="Yes" data-target="textarea21">
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-no mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="presentation_language" value="No" data-target="textarea21">
                                <span>No</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="radio-na mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="presentation_language" value="NA" data-target="textarea21">
                                <span>NA</span>
                            </label>
                        </div>
                        <textarea name="manifestation_presentation" id="textarea21"
                            placeholder="Page and paragraph where component is found"
                            class="mt-1 w-full resize-none max-sm:text-sm p-2 border rounded" disabled></textarea>
                    </div>

                </div>
            </div>

            @php
                $hasSavedForm = !empty($form2d); 
            @endphp

            <!-- BUTTONS -->
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <div class="p-3 flex items-center justify-center space-x-2">
                    <button type="submit"
                        class="bg-primary text-secondary hover:bg-secondary hover:text-primary duration-200 tracking-widest p-4 max-sm:p-3 rounded max-sm:text-sm">SAVE</button>
                    <a href="{{ route('export.form2d') }}">
                        <button type="button"
                            class="bg-secondary text-primary hover:bg-primary hover:text-secondary duration-200 tracking-widest p-4 max-sm:p-3 rounded max-sm:text-sm"
                            @if(!$hasSavedForm) disabled style="opacity:0.5; cursor:not-allowed;" @endif>EXPORT
                            TO PDF</button>
                    </a>
                </div>
            </div>
        </form>
    </main>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Script loaded - initializing radio buttons');
        
        // Function to handle radio button changes
        function handleRadioChange(event) {
            const radio = event.target;
            const targetId = radio.getAttribute('data-target');
            const textarea = document.getElementById(targetId);
            
            console.log('Radio changed:', radio.name, radio.value, 'Target:', targetId);
            
            if (!textarea) {
                console.error('Textarea not found:', targetId);
                return;
            }
            
            if (radio.value === 'Yes') {
                textarea.disabled = false;
                textarea.required = true;
                textarea.classList.remove('bg-gray-100', 'text-gray-400');
                textarea.classList.add('bg-white', 'text-gray-900');
                console.log('Enabled textarea:', targetId);
            } else {
                textarea.disabled = true;
                textarea.required = false;
                // Clear the textarea value when switching to No or NA
                textarea.value = '';
                textarea.classList.remove('bg-white', 'text-gray-900');
                textarea.classList.add('bg-gray-100', 'text-gray-400');
                console.log('Disabled and cleared textarea:', targetId);
            }
        }

        // Add event listeners to all radio buttons
        const radioButtons = document.querySelectorAll('input[type="radio"][data-target]');
        console.log('Found radio buttons:', radioButtons.length);
        
        radioButtons.forEach(radio => {
            radio.addEventListener('change', handleRadioChange);
            console.log('Added listener to:', radio.name);
        });

        // Populate form with existing data if available
        const formData = @json($form2d ?? null);
        if (formData) {
            console.log('Populating form with data:', formData);
            
            // Set radio buttons first
            Object.keys(formData).forEach(fieldName => {
                const value = formData[fieldName];
                
                if (value === 'Yes' || value === 'No' || value === 'NA') {
                    const radio = document.querySelector(`input[name="${fieldName}"][value="${value}"]`);
                    if (radio) {
                        radio.checked = true;
                        console.log('Set radio:', fieldName, value);
                        // Trigger change event to handle textareas
                        setTimeout(() => {
                            radio.dispatchEvent(new Event('change'));
                        }, 50);
                    }
                }
            });

            // Set textarea values after a short delay to ensure they're enabled
            setTimeout(() => {
                Object.keys(formData).forEach(fieldName => {
                    const value = formData[fieldName];
                    // Only set textarea values (not radio values) and only if they have content
                    if (value && value !== 'Yes' && value !== 'No' && value !== 'NA' && value.trim() !== '') {
                        const textarea = document.querySelector(`textarea[name="${fieldName}"]`);
                        if (textarea) {
                            // Only set the value if the textarea is enabled (meaning "Yes" was selected)
                            if (!textarea.disabled) {
                                textarea.value = value;
                                console.log('Set textarea:', fieldName, value);
                            } else {
                                console.log('Textarea disabled, not setting value:', fieldName);
                            }
                        }
                    }
                });
            }, 200);
        }

        // Form submission handler
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                console.log('Form submitting...');
                // Enable all disabled textareas before submission so their data gets sent
                // But only if they have content (for cases where we're updating from Yes to No/NA)
                const allTextareas = document.querySelectorAll('textarea');
                allTextareas.forEach(textarea => {
                    if (textarea.disabled && textarea.value.trim() !== '') {
                        // If a textarea is disabled but has content, clear it first
                        textarea.value = '';
                    }
                    textarea.disabled = false;
                });
            });
        }

        // Additional cleanup: Clear any textarea that's disabled but has content when form loads
        setTimeout(() => {
            const disabledTextareasWithContent = document.querySelectorAll('textarea:disabled');
            disabledTextareasWithContent.forEach(textarea => {
                if (textarea.value.trim() !== '') {
                    console.log('Clearing disabled textarea with content:', textarea.id);
                    textarea.value = '';
                }
            });
        }, 300);
    });
    </script>

    <style>
    textarea:disabled {
        background-color: #f3f4f6 !important;
        color: #6b7280 !important;
        cursor: not-allowed;
    }

    textarea:enabled {
        background-color: white !important;
        color: #1f2937 !important;
    }
    </style>
</x-student-layout>