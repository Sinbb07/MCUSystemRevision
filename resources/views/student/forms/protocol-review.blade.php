@section('title', 'Protocol Review Form')
<x-iacuc-reviewer>
    <main class="xl:ml-[335px] max-xl:ml-auto p-4 max-md:p-2">
        <form action="{{ route('protocol-review.store') }}" method="POST" class="block">
            @csrf
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <p class="text-right mt-3 mr-3 max-lg:text-sm max-md:text-sm max-sm:text-xs">PROTOCOL REVIEW FORM</p>
                <h1
                    class="text-center mt-10 max-2xl:mt-6 max-lg:mt-6 max-md:mt-6 font-bold text-2xl max-xl:text-xl max-lg:text-lg max-md:text-base max-sm:text-sm mb-2 underline">
                    IACUC PROTOCOL REVIEW FORM
                </h1>
            </div>
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <div class="px-3 py-2 mt-2 space-y-2 font-medium max-sm:text-sm">
                    <!-- TANGGALIN LANG TO KUNG HNDI NA KELANGAN ILAGAY SA SYSTEM TONG INSTRUCTIONS -->
                    <p>1. Fill out this form carefully and completely. Use separate sheets if necessary.</p>
                    <p>2. Attach a copy of the final protocol signed by researcher/s and faculty advisor, for student
                        researcher/s.</p>
                    <p>3. Attach proof of qualification to conduct research/procedures using animals (see section I).
                    </p>
                    <p>4. Only Protocol Review Forms submitted with complete requirements will be processed.</p>
                    <div class="pt-3">
                        <label>
                            <span class="font-semibold">
                                I. PROCEDURE(S) or TITLE OF RESEARCH STUDY
                            </span>
                        </label>
                        <textarea name="procedure_title_study"
                            class="mt-1 w-full resize-none max-sm:text-sm">{{ old('procedure_title_study', $formData->study_title ?? '') }}</textarea>
                    </div>
                    <div class="pt-3">
                        <label>
                            <span class="font-semibold">
                                II. PURPOSE/OBJECTIVE/S
                            </span>
                        </label>
                        <textarea name="objectives"
                            class="mt-1 w-full resize-none max-sm:text-sm">{{ old('objectives', $formData->scientific_merit_comment ?? '') }}</textarea>
                    </div>
                    <div class="pt-3">
                        <label>
                            <span class="font-semibold">
                                III. DURATION or TIMEFRAME
                            </span>
                        </label>
                        <textarea name="duration_timeframe"
                            class="mt-1 w-full resize-none max-sm:text-sm">{{ old('duration_timeframe', $formData->overview_section_comment ?? '') }}</textarea>
                    </div>
                    <div class="pt-3">
                        <label>
                            <span class="font-semibold">
                                IV. RESPONSIBLE PERSON or PRINCIPAL INVESTIGATOR
                            </span>
                        </label>
                        <div>
                            <div
                                class="px-3 py-2 flex flex-col md:flex-row justify-between items-start md:space-x-5 space-y-5 md:space-y-0">
                                <div class="flex flex-col md:basis-1/2 w-full">
                                    <label
                                        class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">
                                        NAME
                                    </label>
                                    <input type="text" name="pi_name" value="{{ old('pi_name', $formData->pi_person ?? $principalInvestigator ?? '') }}"
                                        class="mt-1 rounded border border-darkgray w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]"
                                        required>
                                </div>
                                <div class="flex flex-col md:basis-1/2 w-full">
                                    <label
                                        class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">
                                        QUALIFICATION
                                    </label>
                                    <input type="text" name="qualification" value="{{ old('qualification', $formData->training_experience_comment ?? '') }}"
                                        class="mt-1 rounded border border-darkgray w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pt-3">
                        <label>
                            <span class="font-semibold">
                                V. BACKGROUND and SIGNIFICANCE OF THE PROCEDURE or RESEARCH
                                <br>
                                <span class="font-normal text-sm italic">
                                    (Include a description of the biomedical characteristics of the animals which are
                                    essential to the proposed procedure/research and indicate the evidence of
                                    experiences with the proposed model).
                                </span>
                            </span>
                        </label>
                        <textarea name="significance"
                            class="mt-1 w-full resize-none max-sm:text-sm">{{ old('significance', $formData->rational_justification_comment ?? '') }}</textarea>
                    </div>
                    <div class="pt-3">
                        <label>
                            <span class="font-semibold">
                                VI. DESCRIPTION of METHODOLOGIES/EXPERIMENTAL DESIGN
                                <br>
                                <span class="font-normal text-sm italic">
                                    (This section should establish that the proposed procedure/research are well
                                    designed scientifically and ethically. The following should be indicated or
                                    described).
                                </span>
                            </span>
                        </label>
                        <div class="pl-2">
                            <div class="pt-2">
                                <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm">
                                    <span>
                                        A. Type of Animal to be used (species)
                                    </span>
                                </label>
                                <input type="text" name="animal_species" value="{{ old('animal_species', '') }}"
                                    class="mt-1 rounded border border-darkgray w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]">
                            </div>
                            <div class="pt-2">
                                <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm">
                                    <span>
                                        B. Source of Animals
                                    </span>
                                </label>
                                <input type="text" name="animal_source" value="{{ old('animal_source', '') }}"
                                    class="mt-1 rounded border border-darkgray w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]">
                            </div>
                            <div class="pt-2">
                                <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm">
                                    <span>
                                        C. Reason/basis for selecting the animal species
                                    </span>
                                </label>
                                <textarea name="reason_basis"
                                    class="mt-1 w-full resize-none max-sm:text-sm">{{ old('reason_basis', $formData->adequate_justification_comment ?? '') }}</textarea>
                            </div>
                            <div class="pt-2">
                                <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm">
                                    <span>
                                        D. Sex and number of animals <i class="font-normal text-sm">(justify the number
                                            of animals)</i>
                                    </span>
                                </label>
                                <textarea name="number_animals"
                                    class="mt-1 w-full resize-none max-sm:text-sm">{{ old('number_animals', $formData->unnecessary_duplication_comment ?? '') }}</textarea>
                            </div>
                            <div class="pt-2">
                                <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm">
                                    <span>
                                        E. Quarantine and acclimation or conditioning process
                                    </span>
                                </label>
                                <textarea name="conditioning_process"
                                    class="mt-1 w-full resize-none max-sm:text-sm">{{ old('conditioning_process', $formData->endpoint_duration_comment ?? '') }}</textarea>
                            </div>
                            <div class="pt-2">
                                <label class="max-sm:py-1 flex-items-start space-x-2 max-sm:text-sm/6">
                                    <span>
                                        F. Animal care procedures
                                    </span>
                                </label>
                                <div class="pt-2 pl-2">
                                    <label class="max-sm:py-1 flex-items-start space-x-2 max-sm:text-sm">
                                        <span>
                                            1. Cage types and beddings <i class="font-normal text-sm">(if
                                                applicable)</i>
                                        </span>
                                    </label>
                                    <textarea name="cage_type"
                                        class="mt-1 w-full resize-none max-sm:text-sm">{{ old('cage_type', $formData->pain_category_comment ?? '') }}</textarea>
                                </div>
                                <div class="pt-2 pl-2">
                                    <label class="max-sm:py-1 flex-items-start space-x-2 max-sm:text-sm">
                                        <span>
                                            2. Number of animals per cage
                                        </span>
                                    </label>
                                    <textarea name="number_cage"
                                        class="mt-1 w-full resize-none max-sm:text-sm">{{ old('number_cage', '') }}</textarea>
                                </div>
                                <div class="pt-2 pl-2">
                                    <label class="max-sm:py-1 flex-items-start space-x-2 max-sm:text-sm">
                                        <span>
                                            3. Cage cleaning/disinfection method and frequency
                                        </span>
                                    </label>
                                    <textarea name="cleaning_method"
                                        class="mt-1 w-full resize-none max-sm:text-sm">{{ old('cleaning_method', $formData->alternative_housing_comment ?? '') }}</textarea>
                                </div>
                                <div class="pt-2 pl-2">
                                    <label class="max-sm:py-1 flex-items-start space-x-2 max-sm:text-sm">
                                        <span>
                                            4. Room temperature, humidity, ventilation and lighting
                                        </span>
                                    </label>
                                    <textarea name="room_temp"
                                        class="mt-1 w-full resize-none max-sm:text-sm">{{ old('room_temp', $formData->hazardous_material_comment ?? '') }}</textarea>
                                </div>
                                <div class="pt-2 pl-2">
                                    <label class="max-sm:py-1 flex-items-start space-x-2 max-sm:text-sm">
                                        <span>
                                            5. Animal diet and feeding and watering method <i
                                                class="font-normal text-sm max-xl:text-xs">(include amount and
                                                frequency)</i>
                                        </span>
                                    </label>
                                    <textarea name="animal_diet"
                                        class="mt-1 w-full resize-none max-sm:text-sm">{{ old('animal_diet', $formData->multiple_survival_comment ?? '') }}</textarea>
                                </div>
                            </div>
                            <div class="pt-2">
                                <label class="max-sm:py-1 flex-items-start space-x-2 max-sm:text-sm">
                                    <span>
                                        G. Experimental or animal manipulation method
                                    </span>
                                </label>
                                <div class="pt-2 pl-2">
                                    <label class="max-sm:py-1 flex-items-start space-x-2 max-sm:text-sm">
                                        <span>
                                            1. General description of animal manipulation methods <i
                                                class="font-normal text-sm max-sm:text-xs">(include method of
                                                conditioning)</i>
                                        </span>
                                    </label>
                                    <textarea name="method_description"
                                        class="mt-1 w-full resize-none max-sm:text-sm">{{ old('method_description', $formData->experimental_procedures_comment ?? '') }}</textarea>
                                </div>
                                <div class="pt-2 pl-2">
                                    <label class="max-sm:py-1 flex-items-start space-x-2 max-sm:text-sm">
                                        <span>
                                            2. Dosing method <i class="font-normal text-sm max-sm:text-xs">(include
                                                frequency, volume, route, restraint method, and expected outcomes of
                                                effects)</i>
                                        </span>
                                    </label>
                                    <textarea name="dosing_method"
                                        class="mt-1 w-full resize-none max-sm:text-sm">{{ old('dosing_method', $formData->pain_relief_comment ?? '') }}</textarea>
                                </div>
                                <div class="pt-2 pl-2">
                                    <label class="max-sm:py-1 flex-items-start space-x-2 max-sm:text-sm">
                                        <span>
                                            3. Specimen or biological agent (blood, urine, etc.) collection method <i
                                                class="font-normal text-sm max-sm:text-xs">(include frequency, volume,
                                                route, and method of restraints)</i>
                                        </span>
                                    </label>
                                    <textarea name="collection_method"
                                        class="mt-1 w-full resize-none max-sm:text-sm">{{ old('collection_method', $formData->ill_debilitated_comment ?? '') }}</textarea>
                                </div>
                                <div class="pt-2 pl-2">
                                    <label class="max-sm:py-1 flex-items-start space-x-2 max-sm:text-sm">
                                        <span>
                                            4. Animal examination process and frequency of examinations <i
                                                class="font-normal text-sm max-sm:text-xs">(include restraining
                                                method)</i>
                                        </span>
                                    </label>
                                    <textarea name="exam_process"
                                        class="mt-1 w-full resize-none max-sm:text-sm">{{ old('exam_process', $formData->complications_comment ?? '') }}</textarea>
                                </div>
                                <div class="pt-2 pl-2">
                                    <label class="max-sm:py-1 flex-items-start space-x-2 max-sm:text-sm">
                                        <span>
                                            5. Use of anesthetics <i class="font-normal text-sm max-sm:text-xs">(include
                                                drug, dosage, frequency and route of administration)</i>
                                        </span>
                                    </label>
                                    <textarea name="use_anesthetics"
                                        class="mt-1 w-full resize-none max-sm:text-sm">{{ old('use_anesthetics', '') }}</textarea>
                                </div>
                                <div class="pt-2 pl-2">
                                    <label class="max-sm:py-1 flex-items-start space-x-2 max-sm:text-sm">
                                        <span>
                                            6. Surgical procedure <i class="font-normal text-sm max-sm:text-xs">(type
                                                and purpose)</i>
                                        </span>
                                    </label>
                                    <div class="font-normal">
                                        <div class="pt-2 pl-2">
                                            <label class="max-sm:py-1 flex-items-start space-x-2 max-sm:text-sm">
                                                <span>
                                                    a. Where will surgery be performed?
                                                </span>
                                            </label>
                                            <textarea name="surgery_location"
                                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('surgery_location', $formData->veterinary_complications_comment ?? '') }}</textarea>
                                        </div>
                                        <div class="pt-2 pl-2">
                                            <label class="max-sm:py-1 flex-items-start space-x-2 max-sm:text-sm">
                                                <span>
                                                    b. Description of supportive care and monitoring procedures during
                                                    and after surgery
                                                </span>
                                            </label>
                                            <textarea name="during_after"
                                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('during_after', $formData->proposed_anesthesia_comment ?? '') }}</textarea>
                                        </div>
                                        <div class="pt-2 pl-2">
                                            <label class="max-sm:py-1 flex-items-start space-x-2 max-sm:text-sm">
                                                <span>
                                                    c. Description of measures for possible post-surgical complications
                                                </span>
                                            </label>
                                            <textarea name="measure_description"
                                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('measure_description', $formData->post_procedural_comment ?? '') }}</textarea>
                                        </div>
                                        <div class="pt-2 pl-2">
                                            <label class="max-sm:py-1 flex-items-start space-x-2 max-sm:text-sm">
                                                <span>
                                                    d. Name(s) of surgeon(s), their qualifications, and relevant
                                                    experiences
                                                </span>
                                            </label>
                                            <textarea name="name_qualification"
                                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('name_qualification', $formData->appropriate_method_comment ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="pt-2 pl-2">
                                    <label class="max-sm:py-1 flex-items-start space-x-2 max-sm:text-sm">
                                        <span>
                                            7. If euthanasia of animal will be done, indicate/describe the method
                                            selected
                                        </span>
                                    </label>
                                    <textarea name="select_method"
                                        class="mt-1 w-full resize-none max-sm:text-sm">{{ old('select_method', $formData->euthanasia_method_comment ?? '') }}</textarea>
                                </div>
                            </div>
                            <div class="pt-2">
                                <label class="max-sm:py-1 flex-items-start space-x-2 max-sm:text-sm">
                                    <span>
                                        H. Is there a non-animal model applicable for the procedure/study? If so, please
                                        provide the reason for not using it
                                    </span>
                                </label>
                                <textarea name="non_animal_model"
                                    class="mt-1 w-full resize-none max-sm:text-sm">{{ old('non_animal_model', $formData->summary_comments ?? '') }}</textarea>
                            </div>
                            <div class="pt-2">
                                <label class="max-sm:py-1 flex-items-start space-x-2 max-sm:text-sm">
                                    <span>
                                        I. Indicate the names and qualification of all personnel who will be responsible for conducting the procedures
                                    </span>
                                </label>
                                <textarea name="personnel_names"
                                    class="mt-1 w-full resize-none max-sm:text-sm">{{ old('personnel_names', $formData->personnel_names ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $hasSavedForm = !empty($formData); 
            @endphp
            <!-- BUTTONS -->
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <div class="p-3 flex items-center justify-center space-x-2">
                    <button type="submit"
                        class="bg-primary text-secondary hover:bg-secondary hover:text-primary duration-200 tracking-widest p-4 max-sm:p-3 rounded max-sm:text-sm">SAVE</button>
                    <a href="{{ route('export.protocol-review-form') }}" target="_blank">
                        <button type="button"
                            class="bg-secondary text-primary hover:bg-primary hover:text-secondary duration-200 tracking-widest p-4 max-sm:p-3 rounded max-sm:text-sm"
                            @if(!$hasSavedForm) disabled style="opacity:0.5; cursor:not-allowed;" @endif>EXPORT
                            TO PDF</button>
                    </a>
                </div>
            </div>
        </form>
    </main>
</x-iacuc-reviewer>