@section('title', 'Form 3(C)')
<x-student-layout>
    <main class="xl:ml-[335px] max-xl:ml-auto p-4 max-md:p-2">
        <form action="{{ route('form3c.store') }}" method="POST" class="block">
            @csrf
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <p class="text-right mt-3 mr-3 max-lg:text-sm max-md:text-sm max-sm:text-xs">FORM 3(C)</p>
                <h1
                    class="text-center mt-10 max-2xl:mt-6 max-lg:mt-6 max-md:mt-6 font-bold text-2xl max-xl:text-xl max-lg:text-lg max-md:text-base max-sm:text-sm mb-2 underline">
                    PROGRESS REPORTS</h1>
            </div>
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <p class="p-3 italic font-semibold max-sm:text-sm/6">
                    Instructions to the Researcher: Please accomplish this form and ensure that you have included in
                    your submission the relevant documents.
                </p>
                <h2 class="px-3 py-2 font-bold text-lg max-2xl:text-base max-sm:text-sm">GENERAL INFORMATION</h2>
                <div
                    class="px-3 py-2 flex flex-col md:flex-row justify-between items-start md:space-x-5 space-y-5 md:space-y-0">
                    <div class="flex flex-col md:basis-1/3 w-full">
                        <!-- TITLE OF STUDY -->
                        <label class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">
                            TITLE OF STUDY
                        </label>
                        <input type="text" name="study_title" value="{{ old('study_title', $form3c->study_title ?? $researchInfo->research_title ?? '') }}"
                            class="block rounded border border-darkgray mt-1 w-full text-sm max-sm:text-[13px] h-[35px] max-lg:h-[30px]"
                            required>
                    </div>
                    <div class="flex flex-col md:basis-1/3 w-full">
                        <!-- STUDY SITE -->
                        <label class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">
                            STUDY SITE
                        </label>
                        <input type="text" name="study_site" value="{{ old('study_site', $form3c->study_site ?? '') }}"
                            class="mt-1 rounded border border-darkgray w-full text-sm max-sm:text-[13px] h-[35px] max-lg:h-[30px]"
                            required>
                    </div>
                    <div class="flex flex-col md:basis-1/3 w-full">
                        <!-- PRINICIPAL INVESTIGATOR -->
                        <label class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">
                            PRINCIPAL INVESTIGATOR
                        </label>
                        <input type="text" name="pi_name" value="{{ old('pi_name', $form3c->pi_name ?? $principalInvestigator) }}"
                            class="mt-1 rounded border border-darkgray w-full text-sm max-sm:text-[13px] h-[35px] max-lg:h-[30px]"
                            required>
                    </div>
                </div>
                <h2 class="px-3 pt-5 pb-1 font-semibold text-lg max-2xl:text-base max-sm:text-sm">CONTACT INFORMATION
                </h2>
                <div
                    class="px-3 py-2 flex flex-col md:flex-row justify-between items-start md:space-x-5 space-y-4 md:space-y-0">
                    <div class="flex flex-col md:basis-1/3 w-full">
                        <label class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">
                            TELEPHONE NO.
                        </label>
                        <input type="text" name="tel_no" maxlength="10" value="{{ old('tel_no', $form3c->tel_no ?? '') }}"
                            class="block rounded border border-darkgray mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]">
                    </div>
                    <div class="flex flex-col md:basis-1/3 w-full">
                        <label class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">
                            MOBILE NO.
                        </label>
                        <input type="tel" name="contact_no" maxlength="11" value="{{ old('contact_no', $form3c->contact_no ?? '') }}"
                            class="mt-1 rounded border border-darkgray w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]"
                            required>
                    </div>
                    <div class="flex flex-col md:basis-1/3 w-full">
                        <label class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">
                            EMAIL
                        </label>
                        <input type="email" name="pi_email" value="{{ old('pi_email', $form3c->pi_email ?? auth()->user()->user_Email) }}"
                            class="mt-1 rounded border border-darkgray w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]"
                            required>
                    </div>
                </div>
                <div
                    class="px-3 py-2 flex flex-col md:flex-row justify-between items-start md:space-x-5 space-y-4 md:space-y-0">
                    <div class="flex flex-col md:basis-1/2 w-full">
                        <label class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">
                            INSTITUTION
                        </label>
                        <input type="text" name="investigator_institution" value="{{ old('investigator_institution', $form3c->investigator_institution ?? '') }}"
                            class="block rounded border border-darkgray mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]"
                            required>
                    </div>
                    <div class="flex flex-col md:basis-1/2 w-full">
                        <label class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">
                            ADDRESS OF INSTITUTION
                        </label>
                        <input type="text" name="institution_address" value="{{ old('institution_address', $form3c->institution_address ?? '') }}"
                            class="mt-1 rounded border border-darkgray w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]"
                            required>
                    </div>
                </div>
                <div
                    class="px-3 py-2 flex flex-col md:flex-row justify-between items-start md:space-x-5 space-y-4 md:space-y-0">
                    <div class="flex flex-col md:basis-1/2 w-full">
                        <label class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">
                            COLLEGE/DEPARTMENT/UNIT
                        </label>
                        <input type="text" name="college_dept" value="{{ old('college_dept', $form3c->college_dept ?? '') }}"
                            class="block rounded border border-darkgray mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]"
                            required>
                    </div>
                    <div class="flex flex-col md:basis-1/2 w-full">
                        <label class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">
                            ETHICAL CLEARANCE EFFECTIVITY PERIOD
                        </label>
                        <input type="text" name="ethical_clearance" value="{{ old('ethical_clearance', $form3c->ethical_clearance ?? '') }}"
                            class="mt-1 rounded border border-darkgray w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]"
                            required>
                    </div>
                </div>
                <h2 class="px-3 pt-5 pb-1 font-semibold text-lg max-2xl:text-base max-sm:text-sm">PROGRESS REPORT
                </h2>
                <div
                    class="px-3 py-2 flex flex-col md:flex-row justify-between items-start md:space-x-5 space-y-4 md:space-y-0">
                    <div class="flex flex-col md:basis-1/2 w-full">
                        <label class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">
                            START OF STUDY
                        </label>
                        <input type="date" name="study_start" value="{{ old('study_start', $form3c->study_start ?? '') }}"
                            class="block rounded border border-darkgray mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]"
                            required>
                    </div>
                    <div class="flex flex-col md:basis-1/2 w-full">
                        <label class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">
                            EXPECTED END OF STUDY
                        </label>
                        <input type="date" name="study_end" value="{{ old('study_end', $form3c->study_end ?? '') }}"
                            class="mt-1 rounded border border-darkgray w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]"
                            required>
                    </div>
                </div>
                <div
                    class="px-3 py-2 flex flex-col md:flex-row justify-between items-start md:space-x-5 space-y-4 md:space-y-0">
                    <div class="flex flex-col md:basis-1/2 w-full">
                        <label class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">
                            NUMBER OF ENROLLED PARTICIPANTS
                        </label>
                        <input type="number" name="enrolled_participants" value="{{ old('enrolled_participants', $form3c->enrolled_participants ?? '') }}"
                            class="block rounded border border-darkgray mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]"
                            required>
                    </div>
                    <div class="flex flex-col md:basis-1/2 w-full">
                        <label class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">
                            NUMBER OF REQUIRED PARTICIPANTS
                        </label>
                        <input type="number" name="required_participants" value="{{ old('required_participants', $form3c->required_participants ?? '') }}"
                            class="mt-1 rounded border border-darkgray w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]"
                            required>
                    </div>
                </div>
                <div
                    class="px-3 py-2 flex flex-col md:flex-row justify-between items-start md:space-x-5 space-y-4 md:space-y-0">
                    <div class="flex flex-col md:basis-1/2 w-full">
                        <label class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">
                            NUMBER OF PARTICIPANTS WHO WITHDREW
                        </label>
                        <input type="number" name="participant_withdrew" value="{{ old('participant_withdrew', $form3c->participant_withdrew ?? '0') }}"
                            class="block rounded border border-darkgray mt-1 w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]"
                            required>
                    </div>
                    <div class="flex flex-col md:basis-1/2 w-full">
                        <label class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">
                            DEVIATIONS FROM THE APPROVED PROTOCOL
                        </label>
                        <input type="text" name="deviations" value="{{ old('deviations', $form3c->deviations ?? '') }}"
                            class="mt-1 rounded border border-darkgray w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]"
                            required>
                    </div>
                </div>
                <div class="p-3 mt-2 space-y-2 text-base max-sm:text-sm">
                    <div>
                        <label>
                            <span>
                                New information (literature or in the conduct of the study) that may signifcantly change
                                the risk-benefit ratio
                            </span>
                            <textarea name="new_information" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('new_information', $form3c->new_information ?? '') }}</textarea>
                        </label>
                    </div>
                    <div>
                        <label>
                            <span>
                                Issues/problems encountered
                            </span>
                            <textarea name="issues_problems" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('issues_problems', $form3c->issues_problems ?? '') }}</textarea>
                        </label>
                    </div>
                </div>
            </div>
            @php
                $hasSavedForm = !empty($form3c); 
            @endphp
            <!-- BUTTONS -->
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <div class="p-3 flex items-center justify-center space-x-2">
                    <button type="submit"
                        class="bg-primary text-secondary hover:bg-secondary hover:text-primary duration-200 tracking-widest p-4 max-sm:p-3 rounded max-sm:text-sm">SAVE</button>
                    <a href="{{ route('export.form3c') }}" target="_blank">
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