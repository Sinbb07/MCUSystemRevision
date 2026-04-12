@section('title', 'Form 2(A)')
<x-student-layout>
    <main class="xl:ml-[335px] max-xl:ml-auto p-4">
        <form action="{{ route('form2a.store') }}" method="POST" class="block">
            @csrf
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <p class="text-right mt-3 mr-3 max-lg:text-sm max-md:text-sm max-sm:text-xs">FORM 2(A)</p>
                <h1
                    class="text-center mt-10 max-2xl:mt-6 max-lg:mt-6 max-md:mt-6 font-bold text-2xl max-xl:text-xl max-lg:text-lg max-md:text-base max-sm:text-sm mb-2 underline">
                    STUDY PROTOCOL REVIEW
                    CHECKLIST</h1>
            </div>
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <h2 class="p-3 font-bold text-lg max-2xl:text-base max-sm:text-sm">STUDY PROTOCOL INFORMATION</h2>
                <div
                    class="px-3 py-2 flex flex-col md:flex-row justify-between items-start md:space-x-5 space-y-4 md:space-y-0">
                    <div class="flex flex-col md:basis-1/3 w-full">
                        <label class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">
                            STUDY PROTOCOL TITLE
                        </label>
                        <input type="text" name="protocol" value="{{ old('protocol', $researchInfo->research_title ?? '') }}"
                            class="block rounded border border-darkgray mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]"
                            required>
                    </div>
                    <div class="flex flex-col md:basis-1/3 w-full">
                        <label class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">
                            PRINCIPAL INVESTIGATOR
                        </label>
                        <input type="text" name="pi_name" value="{{ $principalInvestigator }}" 
                            class="mt-1 rounded border border-darkgray w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]"
                            required>
                    </div>
                    <div class="flex flex-col md:basis-1/3 w-full">
                        <label class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">
                            CO-INVESTIGATOR
                        </label>
                        <input type="text" name="coiname" value="{{ old('coiname', $researchInfo->research_CoInvestigator ?? '') }}"
                            class="mt-1 rounded border border-darkgray w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]">
                    </div>
                </div>
            </div>
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <h2 class="p-3 font-bold text-lg max-2xl:text-base max-md:text-base max-sm:text-sm">TO BE FILLED UP BY
                    THESIS ADVISER</h2>
                <div class="p-3 gap-x-10 gap-y-3 text-sm">
                    <!-- BASIC DOCUMENTS -->
                    <div class="space-y-2 text-base">
                        <h2 class="font-bold max-sm:text-sm">Basic Documents (must submit for initial review)</h2>  
                        <label class="flex items-start space-x-2 max-sm:text-sm/6">
                            <input type="checkbox" class="mt-1 max-sm:w-[14px] max-sm:h-[14px]" name="cover_letter"
                            {{ old('cover_letter', $form2a->cover_letter ?? false) ? 'checked' : '' }}>
                            <span>Cover letter from the thesis/dissertion advisor/mentor with noted by the College Dean
                                - <i>for MCU Students</i></span>
                        </label>
                        <label class="flex items-start space-x-2 max-sm:text-sm/6">
                            <input type="checkbox" class="mt-1 max-sm:w-[14px] max-sm:h-[14px]" name="enrollment_proof"
                            {{ old('enrollment_proof', $form2a->enrollment_proof ?? false) ? 'checked' : '' }}>
                            <span>Proof of enrollment (1 photocopied and e-copy of registration form) - <i>for MCU
                                    Students</i></span>
                        </label>
                        <!-- ETO UNG KULANG NA DINAGDAG KO BASE SA PDF FORM -->
                        <label class="flex items-start space-x-2 max-sm:text-sm/6">
                            <input type="checkbox" class="mt-1 max-sm:w-[14px] max-sm:h-[14px]" name="employment_proof"
                            {{ old('employment_proof', $form2a->employment_proof ?? false) ? 'checked' : '' }}>
                            <span>Proof of Employment (letter of endorsement from direct supervisor) - <i>for teaching, non-teaching, 
                                    and administrative staff</i></span>
                        </label>
                        <label class="flex items-start space-x-2 max-sm:text-sm/6">
                            <input type="checkbox" class="mt-1 max-sm:w-[14px] max-sm:h-[14px]" name="letter"
                            {{ old('letter', $form2a->letter ?? false) ? 'checked' : '' }}>
                            <span>Letter from the thesis/dissertion advisor/mentor noted by the College Dean signifying
                                that the protocol had undergone and passed technical review</span>
                        </label>
                        <label class="flex items-start space-x-2 max-sm:text-sm/6">
                            <input type="checkbox" class="mt-1 max-sm:w-[14px] max-sm:h-[14px]" name="complete_form2b"
                            {{ old('complete_form2b', $form2a->complete_form2b ?? false) ? 'checked' : '' }}>
                            <span>Completed <b>MCUERB FORM 2(B) APPLICATION FOR INITIAL REVIEW</b> - 1 hard copy of
                                printed and a soft copy</span>
                        </label>
                        <label class="flex items-start space-x-2 max-sm:text-sm/6">
                            <input type="checkbox" class="mt-1 max-sm:w-[14px] max-sm:h-[14px]" name="complete_form2a"
                            {{ old('complete_form2a', $form2a->complete_form2a ?? false) ? 'checked' : '' }}>
                            <span>Completed <b>MCUERB FORM 2(A) PROTOCOL REVIEW CHECKLIST</b></span>
                        </label>
                        <label class="flex items-start space-x-2 max-sm:text-sm/6">
                            <input type="checkbox" class="mt-1 max-sm:w-[14px] max-sm:h-[14px]" name="complete_form2d"
                            {{ old('complete_form2d', $form2a->complete_form2d ?? false) ? 'checked' : '' }}>
                            <span>Completed <b>MCUERB FORM 2(D) INFORMED CONSENT CHECKLIST for PRINCIPAL INVESTIGATOR
                                    (PI)</b></span>
                        </label>
                    </div>

                    <!-- PROTOCOL PACKAGE -->
                    <div class="mt-5 space-y-2 text-base">
                        <h2 class="font-bold max-sm:text-sm">Protocol Package (must submit for initial review)</h2>
                        <label class="flex items-start space-x-2 max-sm:text-sm/6">
                            <input type="checkbox" class="mt-1 max-sm:w-[14px] max-sm:h-[14px]" name="study_protocol"
                            {{ old('study_protocol', $form2a->study_protocol ?? false) ? 'checked' : '' }}>
                            <span>Study Protocol (Chapters I, II, & III)</span>
                        </label>
                        <label class="flex items-start space-x-2 font-bold">
                            <input type="checkbox" class="mt-1 max-sm:w-[14px] max-sm:h-[14px]" name="form2c_eng"
                            {{ old('form2c_eng', $form2a->form2c_eng ?? false) ? 'checked' : '' }}>
                            <span>MCUERB FORM 2(C) INFORMED CONSENT FORM - English Version</span>
                        </label>
                        <label class="flex items-start space-x-2 font-bold">
                            <input type="checkbox" class="mt-1 max-sm:w-[14px] max-sm:h-[14px]" name="form2c_fil"
                            {{ old('form2c_fil', $form2a->form2c_fil ?? false) ? 'checked' : '' }}>
                            <span>MCUERB FORM 2(C) INFORMED CONSENT FORM - Filipino Version or in local language/dialect
                                (if
                                applicable)</span>
                        </label>
                        <label class="flex items-start space-x-2 max-sm:text-sm/6">
                            <input type="checkbox" class="mt-1 max-sm:w-[14px] max-sm:h-[14px]" name="data_collection"
                            {{ old('data_collection', $form2a->data_collection ?? false) ? 'checked' : '' }}>
                            <span>Data collection forms/tools/instrument/questionnaire</span>
                        </label>
                        <label class="flex items-start space-x-2 max-sm:text-sm/6">
                            <input type="checkbox" class="mt-1 max-sm:w-[14px] max-sm:h-[14px]" name="cert_validator"
                            {{ old('cert_validator', $form2a->cert_validator ?? false) ? 'checked' : '' }}>
                            <span>Certificates of Validators of the tool(s)/instrument(s)/questionnaire (at least three
                                (3)
                                validators) - Researcher's developed tool (if applicable)</span>
                        </label>
                        <label class="flex items-start space-x-2 max-sm:text-sm/6">
                            <input type="checkbox" class="mt-1 max-sm:w-[14px] max-sm:h-[14px]" name="eng_7_12_yrs"
                            {{ old('eng_7_12_yrs', $form2a->eng_7_12_yrs ?? false) ? 'checked' : '' }}>
                            <span>Child Assent for Children Ages 7-12 years - English Version (if applicable)</span>
                        </label>
                        <label class="flex items-start space-x-2 max-sm:text-sm/6">
                            <input type="checkbox" class="mt-1 max-sm:w-[14px] max-sm:h-[14px]" name="fil_7_12_yrs"
                            {{ old('fil_7_12_yrs', $form2a->fil_7_12_yrs ?? false) ? 'checked' : '' }}>
                            <span>
                                Child Assent for Children Ages 7-12 years - Filipino/Dialect Version (if applicable)
                            </span>
                        </label>
                        <label class="flex items-start space-x-2 max-sm:text-sm/6">
                            <input type="checkbox" class="mt-1 max-sm:w-[14px] max-sm:h-[14px]" name="eng_13_17_yrs"
                            {{ old('eng_13_17_yrs', $form2a->eng_13_17_yrs ?? false) ? 'checked' : '' }}>
                            <span>
                                Child Assent for Children Ages 13-17 years - English Version (if applicable)
                            </span>
                        </label>
                        <label class="flex items-start space-x-2 max-sm:text-sm/6">
                            <input type="checkbox" class="mt-1 max-sm:w-[14px] max-sm:h-[14px]" name="fil_13_17_yrs"
                            {{ old('fil_13_17_yrs', $form2a->fil_13_17_yrs ?? false) ? 'checked' : '' }}>
                            <span>
                                Child Assent for Children Ages 13-17 years - Filipino/Dialect Version (if applicable)
                            </span>
                        </label>
                        <label class="flex items-start space-x-2 max-sm:text-sm/6">
                            <input type="checkbox" class="mt-1 max-sm:w-[14px] max-sm:h-[14px]" name="advertisement"
                            {{ old('advertisement', $form2a->advertisement ?? false) ? 'checked' : '' }}>
                            <span>
                                Recruitment advertisement(s) and/or social media Poster (as needed by the study
                                protocol)
                                (if applicable)
                            </span>
                        </label>
                        <label class="flex items-start space-x-2 max-sm:text-sm/6">
                            <input type="checkbox" class="mt-1 max-sm:w-[14px] max-sm:h-[14px]" name="vitae"
                            {{ old('vitae', $form2a->vitae ?? false) ? 'checked' : '' }}>
                            <span>Curriculum Vitae of PI and study team members</span>
                        </label>
                        <label class="flex items-start space-x-2 max-sm:text-sm/6">
                            <input type="checkbox" class="mt-1 max-sm:w-[14px] max-sm:h-[14px]" name="gcp"
                            {{ old('gcp', $form2a->gcp ?? false) ? 'checked' : '' }}>
                            <span>Good Clinical Practice (GCP) or Health Research Ethics Training Certificate of PI and
                                Co-Investigators (GCP is required for clinical trials) obtained within the last three
                                (3) years (if applicable)
                            </span>
                        </label>
                        <label class="flex items-start space-x-2 max-sm:text-sm/6">
                            <input type="checkbox" class="mt-1 max-sm:w-[14px] max-sm:h-[14px]" name="gantt_chart"
                            {{ old('gantt_chart', $form2a->gantt_chart ?? false) ? 'checked' : '' }}>
                            <span>Gantt Chart</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <p class="p-3 max-sm:text-sm/6">Details <b>should be visible</b> in the research methods <b>(Chapter
                        III)</b> of the
                    thesis/research
                    proposal involving human participants, for the efficiency of the ERB review process. (To be filled
                    up by the Researcher)</p>

                <!-- Seniors -->
                <div class="p-3">
                    <h2 class="text-lg max-sm:text-base font-semibold">Seniors</h2>
                    <div class="mt-2 space-y-2 text-base">
                        <!-- Informed Consent -->
                        <div>
                            <label>
                                <span>
                                    <b>Informed Consent:</b> Ensure clarity and accessibility of consent forms,
                                    considering
                                    cognitive and sensory impairments (e.g., large fonts, simple language). <b>How would
                                        you
                                        accomplish this?</b>
                                </span>
                            </label>
                            <textarea name="informed_consent" id="" value="" placeholder="Page Number where description is found" 
                                class="mt-1 w-full resize-none max-sm:text-sm" value=" ">{{ old('informed_consent', $form2a->informed_consent ?? '') }}</textarea>
                        </div>
                        <!-- Cognitive Assessment -->
                        <div>
                            <label>
                                <span>
                                    <b>Cognitive Assessment:</b> Verify the capacity to consent and consider involving
                                    legally authorized representatives if necessary.
                                </span>
                            </label>
                            <textarea name="cognitive_assessment" id=""
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm" value=" ">{{ old('cognitive_assessment', $form2a->cognitive_assessment ?? '') }}</textarea>
                        </div>
                        <!-- Physical Health Risks -->
                        <div>
                            <label>
                                <span>
                                    <b>Physical Health Risks:</b> Evaluate potential health risks due to medical
                                    conditions or physical frailty.
                                </span>
                            </label>
                            <textarea name="physical_risks" id="" placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm" value=" ">{{ old('physical_risks', $form2a->physical_risks ?? '') }}</textarea>
                        </div>
                        <!-- Respect and Autonomy -->
                        <div>
                            <label>
                                <span>
                                    <b>Respect and Autonomy:</b> Ensure participants are not coerced or unduly
                                    influenced due to age-related vulnerabilities. This must be explicit in the Methods
                                    text.
                                </span>
                            </label>
                            <textarea name="respect_autonomy" id="" placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm" value=" ">{{ old('respect_autonomy', $form2a->respect_autonomy ?? '') }}</textarea>
                        </div>
                        <!-- Privacy -->
                        <div>
                            <label>
                                <span>
                                    <b>Privacy and Confidentiality:</b> Safeguard sensitive health information and
                                    ensure
                                    respectful data handling. Indicate the methods you would adopt to achieve this.
                                </span>
                            </label>
                            <textarea name="privacy_confidentiality" id=""
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm" value=" ">{{ old('privacy_confidentiality', $form2a->privacy_confidentiality ?? '') }}</textarea>
                        </div>
                        <!-- Intervention Suitability -->
                        <div>
                            <label>
                                <span>
                                    <b>Intervention Suitability:</b> Confirm interventions are age-appropriate and do
                                    not disproportionately burden seniors.
                                </span>
                            </label>
                            <textarea name="intervention_suitability" id="" 
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm" value=" ">{{ old('intervention_suitability', $form2a->intervention_suitability ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <!-- Minors -->
                    <h2 class="text-lg max-sm:text-base font-semibold">Minors (Include your details in each item)</h2>
                    <div class="mt-2 space-y-2 text-base">
                        <!-- Parental/Guardian Consent -->
                        <div>
                            <label>
                                <span>
                                    <b>Parental/Guardian Consent:</b> Require consent from parents or legal guardians,
                                    and where appropriate, seek assent from the minors themselves.
                                </span>
                            </label>
                            <textarea name="parent_consent" id="" placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('parent_consent', $form2a->parent_consent ?? '') }}</textarea>
                        </div>
                        <!-- Assent Process -->
                        <div>
                            <label>
                                <span>
                                    <b>Assent Process:</b> Tailor information for children's comprehension based on age,
                                    maturity, and developmental stage.
                                </span>
                            </label>
                            <textarea name="assent_process" id="" placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('assent_process', $form2a->assent_process ?? '') }}</textarea>
                        </div>
                        <!-- Protection from Harm -->
                        <div>
                            <label>
                                <span>
                                    <b>Protection from Harm:</b> Minimize psychological, physical, and emotional risks.
                                    Details on how should be specified.
                                </span>
                            </label>
                            <textarea name="harm_protection" id="" placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('harm_protection', $form2a->harm_protection ?? '') }}</textarea>
                        </div>
                        <!-- Educational Balance -->
                        <div>
                            <label>
                                <span>
                                    <b>Educational Balance:</b> Ensure participation does not interfere with schooling
                                    or normal development. Detail on this is necessary.
                                </span>
                            </label>
                            <textarea name="educational_balance" id=""
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('educational_balance', $form2a->educational_balance ?? '') }}</textarea>
                        </div>
                        <!-- Mandatory Reporting -->
                        <div>
                            <label>
                                <span>
                                    <b>Mandatory Reporting:</b> Ensure mehchanisms are in place to report suspected
                                    abuse or neglect.
                                </span>
                            </label>
                            <textarea name="mandatory_reporting" id=""
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('mandatory_reporting', $form2a->mandatory_reporting ?? '') }}</textarea>
                        </div>
                        <!-- Equitable Inclusion -->
                        <div>
                            <label>
                                <span>
                                    <b>Equitable Inclusion:</b> Avoid exploiting minors solely because they are an
                                    accessible population.
                                </span>
                            </label>
                            <textarea name="equitable_inclusion" id=""
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('equitable_inclusion', $form2a->equitable_inclusion ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Persons with Disabilities -->
                <div class="p-3">
                    <h2 class="text-lg max-sm:text-base font-semibold">Persons with Disabilities (Include your details
                        in each items)
                    </h2>
                    <div class="mt-2 space-y-2 text-base">
                        <!-- Accessible Communication -->
                        <div>
                            <label>
                                <span>
                                    <b>Accessible Communication:</b> Adapt materials and processes for participants'
                                    specific disabilities (e.g., braille, sign language, or simplified text).
                                </span>
                            </label>
                            <textarea name="accessible_comm" id="" placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('accessible_comm', $form2a->accessible_comm ?? '') }}</textarea>
                        </div>
                        <!-- Capacity to Consent -->
                        <div>
                            <label>
                                <span>
                                    <b>Capacity to Consent:</b> Assess individual decision-making abilities and involve
                                    legal representatives when necessary.
                                </span>
                            </label>
                            <textarea name="consent_capacity" id="" placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('consent_capacity', $form2a->consent_capacity ?? '') }}</textarea>
                        </div>
                        <!-- Risk Mitigation -->
                        <div>
                            <label>
                                <span>
                                    <b>Risk Mitigation:</b> Address potential physical, emotional, or psychological
                                    harm.
                                </span>
                            </label>
                            <textarea name="risk_mitigation" id="" placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('risk_mitigation', $form2a->risk_mitigation ?? '') }}</textarea>
                        </div>
                        <!-- Non-Discrimination -->
                        <div>
                            <label>
                                <span>
                                    <b>Non-Discrimination:</b> Ensure the study promotes inclusion and avoids
                                    stigmatization or bias.
                                </span>
                            </label>
                            <textarea name="non_discrimination" id=""
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('non_discrimination', $form2a->non_discrimination ?? '') }}</textarea>
                        </div>
                        <!-- Reasonable Accommodations -->
                        <div>
                            <label>
                                <span>
                                    <b>Reasonable Accommodations:</b> Provide necessary support, such as assistive
                                    devices or adaptive technologies.
                                </span>
                            </label>
                            <textarea name="reasonable_accommodations" id=""
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('reasonable_accommodations', $form2a->reasonable_accommodations ?? '') }}</textarea>
                        </div>
                        <!-- Monitoring -->
                        <div>
                            <label>
                                <span>
                                    <b>Monitoring:</b> Implement mechanisms to monitor and address any adverse effects
                                    unique to the disability.
                                </span>
                            </label>
                            <textarea name="monitoring" id="" class="mt-1 w-full resize-none max-sm:text-sm"
                                placeholder="Page Number where description is found">{{ old('monitoring', $form2a->monitoring ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Person Deprived of Liberty -->
                <div class="p-3">
                    <h2 class="text-lg max-sm:text-base font-semibold">Persons Deprived of Liberty (include your details
                        in each item).
                    </h2>
                    <div class="mt-2 space-y-2 text-base">
                        <!-- Volutary Participation -->
                        <div>
                            <label>
                                <span>
                                    <b>Voluntary Participation:</b> Safeguard against coercion, considering the inherent
                                    power imbalances in detention or institutional settings. Indicate how?
                                </span>
                            </label>
                            <textarea name="voluntary_participation" id=""
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('voluntary_participation', $form2a->voluntary_participation ?? '') }}</textarea>
                        </div>
                        <!-- Equitable Selection -->
                        <div>
                            <label>
                                <span>
                                    <b>Equitable Selection:</b> Ensure inclusion is based on scientific reasons and, not
                                    convenience or vulnerability.
                                </span>
                            </label>
                            <textarea name="equitable_selection" id=""
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('equitable_selection', $form2a->equitable_selection ?? '') }}</textarea>
                        </div>
                        <!-- Privacy and Confidentiality -->
                        <div>
                            <label>
                                <span>
                                    <b>Privacy and Confidentiality:</b> Protect personal information, especially in
                                    environments with limited privacy.
                                </span>
                            </label>
                            <textarea name="privacy_confidentiality_2" id=""
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('privacy_confidentiality_2', $form2a->privacy_confidentiality_2 ?? '') }}</textarea>
                        </div>
                        <!-- Benefit and Risk Analysis -->
                        <div>
                            <label>
                                <span>
                                    <b>Benefit and Risk Analysis:</b> Ensure the study offers direct benefits to
                                    participants or their communities and minimizes risks.
                                </span>
                            </label>
                            <textarea name="benefit_risk_analysis" id=""
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('benefit_risk_analysis', $form2a->benefit_risk_analysis ?? '') }}</textarea>
                        </div>
                        <!-- Independent Oversight -->
                        <div>
                            <label>
                                <span>
                                    <b>Independent Oversight:</b> Verify the absence of institutional conflicts of
                                    interest or undue influence.
                                </span>
                            </label>
                            <textarea name="independent_oversight" id=""
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('independent_oversight', $form2a->independent_oversight ?? '') }}</textarea>
                        </div>
                        <!-- Post-Study Support -->
                        <div>
                            <label>
                                <span>
                                    <b>Post-Study Support:</b> Address how findings or interventions will be accessible
                                    to participants after the study.
                                </span>
                            </label>
                            <textarea name="post_study_support" id=""
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('post_study_support', $form2a->post_study_support ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- General Principles for All Groups -->
                <div class="p-3">
                    <h2 class="text-lg max-sm:text-base font-semibold">General Principles for All Groups:</h2>
                    <div class="mt-2 space-y-2 text-base">
                        <!-- Ethical Justification -->
                        <div>
                            <label>
                                <span>
                                    <b>Ethical Justification:</b> Clearly outline the necessity and appropriateness of
                                    including vulnerable populations.
                                </span>
                            </label>
                            <textarea name="ethical_justification" id=""
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('ethical_justification', $form2a->ethical_justification ?? '') }}</textarea>
                        </div>
                        <!-- Scientific Validity -->
                        <div>
                            <label>
                                <span>
                                    <b>Scientific Validity:</b> Confirm that the study design is rigorous and ethically
                                    justifiable.
                                </span>
                            </label>
                            <textarea name="scientific_validity" id=""
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('scientific_validity', $form2a->scientific_validity ?? '') }}</textarea>
                        </div>
                        <!-- Risk-Benefit Assessment -->
                        <div>
                            <label>
                                <span>
                                    <b>Risk-Benefit Assessment:</b> Ensure that risks are minimal, and benefits
                                    outweight
                                    potential harm.
                                </span>
                            </label>
                            <textarea name="risk_benefit_assessment" id=""
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('risk_benefit_assessment', $form2a->risk_benefit_assessment ?? '') }}</textarea>
                        </div>
                        <!-- Cultural Sensitivity -->
                        <div>
                            <label>
                                <span>
                                    <b>Cultural Sensitivity:</b> Consider cultural norms and values relevant to each
                                    group.
                                </span>
                            </label>
                            <textarea name="cultural_sensitivity" id=""
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('cultural_sensitivity', $form2a->cultural_sensitivity ?? '') }}</textarea>
                        </div>
                        <!-- Compensation -->
                        <div>
                            <label>
                                <span>
                                    <b>Compensation:</b> Ensure fair and non-coercive incentives or reimbursements.
                                </span>
                            </label>
                            <textarea name="compensation" id="" placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('compensation', $form2a->compensation ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Process of Participant Recruitment -->
                <div class="p-3">
                    <h2 class="text-lg max-sm:text-base font-semibold">Process of Participant Recruitment</h2>
                    <div class="mt-2 space-y-2 text-base">
                        <div>
                            <label>
                                <span>
                                    Include how potential participants will be recruited, contacted, screened, and
                                    registered in the study described.
                                </span>
                            </label>
                            <textarea name="potential_participants" id=""
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('potential_participants', $form2a->potential_participants ?? '') }}</textarea>
                        </div>
                        <div>
                            <label>
                                <span>
                                    Specify conditions and characteristics applicable to the identification and
                                    selection of participants in the study and the conditions necessary for eligible
                                    persons to be included in the inclusion criteria.
                                </span>
                            </label>
                            <textarea name="conditions_characteristics" id=""
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('conditions_characteristics', $form2a->conditions_characteristics ?? '') }}</textarea>
                        </div>
                        <div>
                            <label>
                                <span>
                                    Specify whether there are any groups of people who might be more susceptible to the
                                    risks presented by the study and who therefore ought to be excluded from the
                                    research in the selection of participants.
                                </span>
                            </label>
                            <textarea name="susceptible_to_risks" id=""
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('susceptible_to_risks', $form2a->susceptible_to_risks ?? '') }}</textarea>
                        </div>
                        <div>
                            <label>
                                <span>
                                    Indicate if any, special vulnerability among prospective study participants that
                                    might be relevant to evaulating the risk of participation considered.
                                </span>
                            </label>
                            <textarea name="special_vulnerability" id=""
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('special_vulnerability', $form2a->special_vulnerability ?? '') }}</textarea>
                        </div>
                        <div>
                            <label>
                                <span>
                                    State explicitly possible indication of special measures to be implemented to
                                    protect the vulnerability of study participants.
                                </span>
                            </label>
                            <textarea name="possible_indication" id=""
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('possible_indication', $form2a->possible_indication ?? '') }}</textarea>
                        </div>
                        <div>
                            <label>
                                <span>
                                    State explicitly that the procedures for informing participants about the study and
                                    methods and for obtaining consent are clearly described. Indicate how you would do.
                                </span>
                            </label>
                            <textarea name="procedure" id="" class="mt-1 w-full resize-none max-sm:text-sm"
                                placeholder="Page Number where description is found">{{ old('procedure', $form2a->procedure ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Sample size and suitable determination procedure -->
                <div class="p-3">
                    <h2 class="text-lg max-sm:text-base font-semibold">Describe the sample size and suitable
                        determination procedure
                        based on your research design.</h2>
                    <div class="mt-2 space-y-2 text-base">
                        <div>
                            <label>
                                <span>
                                    1.
                                </span>
                            </label>
                            <textarea name="sample_size_1" id=""
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('sample_size_1', $form2a->sample_size_1 ?? '') }}</textarea>
                        </div>
                        <div>
                            <label>
                                <span>
                                    2.
                                </span>
                            </label>
                            <textarea name="sample_size_2" id=""
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('sample_size_2', $form2a->sample_size_2 ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Site of data collection -->
                <div class="p-3">
                    <h2 class="text-lg max-sm:text-base font-semibold">Describe the sample size and suitable
                        determination procedure
                        based on your research design.</h2>
                    <div class="mt-2 space-y-2 text-base">

                        <div>
                            <label>
                                <span>
                                    Specify measures to ensure the anonymity and confidentiality of the study
                                    participants and data collected clearly indicated: Indicate how you would achieve
                                    this.
                                </span>
                            </label>
                            <textarea name="anonymity_confidentiality" id=""
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('anonymity_confidentiality', $form2a->anonymity_confidentiality ?? '') }}</textarea>
                        </div>
                        <div>
                            <label>
                                <span>
                                    Include procedures regarding confidentality of the data, including how
                                    confidentiality will be preserved during transmission, use, and storage of the data
                                    and the names of persons or positions responsible for technical and administrative
                                    stewardship responsibilities properly discussed.
                                </span>
                            </label>
                            <textarea name="procedures_confidentiality" id=""
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('procedures_confidentiality', $form2a->procedures_confidentiality ?? '') }}</textarea>
                        </div>
                        <div>
                            <label>
                                <span>
                                    Clearly include the prcedures on how the final disposition of records, data,
                                    compuiter files, and specimens will be, including the location for any relevant
                                    information to be stored discussed.
                                </span>
                            </label>
                            <textarea name="final_disposition" id=""
                                placeholder="Page Number where description is found"
                                class="mt-1 w-full resize-none max-sm:text-sm">{{ old('final_disposition', $form2a->final_disposition ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- LAST PART -->
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <div
                    class="p-3 flex flex-col md:flex-row justify-between items-start md:space-x-5 space-y-4 md:space-y-0">
                    <div class="flex flex-col md:basis-1/3 w-full">
                        <label class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">
                            THESIS ADVISER
                        </label>
                        <input type="text" name="thesisadviser" value="{{ old('thesisadviser', $form2a->thesisadviser ?? '') }}"
                            class="block rounded border border-darkgray mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]">
                    </div>
                    <div class="flex flex-col md:basis-1/3 w-full">
                        <label class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">
                            NOTED BY:
                        </label>
                        <input type="text" name="notedby" value="{{ old('notedby', $form2a->notedby ?? '') }}"
                            class="block rounded border border-darkgray mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]">
                    </div>
                    <div class="flex flex-col md:basis-1/3 w-full">
                        <label class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">
                            RESEARCH COORDINATOR
                        </label>
                        <input type="text" name="coordinator" value="{{ old('coordinator', $form2a->coordinator ?? '') }}"
                            class="block rounded border border-darkgray mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]">
                    </div>
                </div>
            </div>

            @php
                // Assuming $form2b is retrieved based on the current user
                $hasSavedForm = !empty($form2a); 
            @endphp
            <!-- BUTTONS -->
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <div class="p-3 flex items-center justify-center space-x-2">
                    <button type="submit"
                        class="bg-primary text-secondary hover:bg-secondary hover:text-primary duration-200 tracking-widest p-4 max-sm:p-3 rounded max-sm:text-sm">SAVE</button>
                    <a href="{{ route('export.form2a') }}">
                        <button type="button"
                            class="bg-secondary text-primary hover:bg-primary hover:text-secondary duration-200 tracking-widest p-4 max-sm:p-3 rounded max-sm:text-sm"
                            @if(!$hasSavedForm) disabled style="opacity:0.5; cursor:not-allowed;" @endif>EXPORT
                            TO PDF</button>
                    </a>
                </div>
            </div>
        </form>
    </main>
</x-student-layout>