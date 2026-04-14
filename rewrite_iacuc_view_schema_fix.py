from pathlib import Path
content = '''@section('title', 'Protocol Review Checklist')
<x-iacuc-reviewer>
    <main class="xl:ml-[335px] max-xl:ml-auto p-4 max-md:p-2">
        <form action="{{ route('iacuc-reviewer.protocol-review-checklist.store') }}" method="POST" class="block">
            @csrf
            <input type="hidden" name="protocol_id" value="{{ request()->query('protocol') }}">
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <p class="text-right mt-3 mr-3 max-lg:text-sm max-md:text-sm max-sm:text-xs">PROTOCOL REVIEW CHECKLIST</p>
                <h1 class="text-center mt-10 max-2xl:mt-6 max-lg:mt-6 max-md:mt-6 font-bold text-2xl max-xl:text-xl max-lg:text-lg max-md:text-base max-sm:text-sm mb-2 underline">IACUC PROTOCOL REVIEW CHECKLIST</h1>
            </div>
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <div class="px-3 py-2 flex flex-col md:flex-row justify-between items-start md:space-x-5 space-y-5 md:space-y-0">
                    <div class="flex flex-col md:basis-1/3 w-full">
                        <label class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">STUDY TITLE</label>
                        <input type="text" name="study_title" value="{{ old('study_title', $form->study_title ?? '') }}" class="mt-1 rounded border border-darkgray w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]" required>
                    </div>
                    <div class="flex flex-col md:basis-1/3 w-full">
                        <label class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">PI/RESP. PERSON</label>
                        <input type="text" name="pi_person" value="{{ old('pi_person', $form->pi_person ?? '') }}" class="mt-1 rounded border border-darkgray w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]" required>
                    </div>
                    <div class="flex flex-col md:basis-1/3 w-full">
                        <label class="font-semibold text-base max-2xl:text-base max-lg:text-sm max-sm:text-[13px]">ADVISER</label>
                        <input type="text" name="adviser" value="{{ old('adviser', $form->adviser ?? '') }}" class="mt-1 rounded border border-darkgray w-full text-[14px] max-sm:text-[13px] h-[35px] max-lg:h-[30px]" required>
                    </div>
                </div>
            </div>
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <div class="px-3 mt-2 space-y-2 max-sm:text-sm">
                    <h2 class="py-2 font-semibold text-lg max-2xl:text-base max-sm:text-sm">ALL PROTOCOLS</h2>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6"><span>Has a satisfactory review of scientific merit been performed?</span></label>
                        <textarea name="scientific_merit_comment" data-group="scientific_merit" id="1" placeholder="Comments" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('scientific_merit_comment', $form->scientific_merit_comment ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6"><span>Are the training and experience of the individuals performing the procedures satisfactory?</span></label>
                        <textarea name="training_experience_comment" data-group="training_experience" id="2" placeholder="Comments" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('training_experience_comment', $form->training_experience_comment ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6"><span>Is the overview section completed in layman's terms?</span></label>
                        <textarea name="overview_section_comment" data-group="overview_section" id="3" placeholder="Comments" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('overview_section_comment', $form->overview_section_comment ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6"><span>Is the rationale/justification/alternative for using the specified vertebrate animals complete?</span></label>
                        <textarea name="rational_justification_comment" data-group="rational_justification" id="4" placeholder="Comments" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('rational_justification_comment', $form->rational_justification_comment ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6"><span>Is there adequate justification for the number of animal requested?</span></label>
                        <textarea name="adequate_justification_comment" data-group="adequate_justification" id="5" placeholder="Comments" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('adequate_justification_comment', $form->adequate_justification_comment ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6"><span>Is the documentation of unnecessary duplication and/or pain and distress complete?</span></label>
                        <textarea name="unnecessary_duplication_comment" data-group="unnecessary_duplication" id="6" placeholder="Comments" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('unnecessary_duplication_comment', $form->unnecessary_duplication_comment ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6"><span>Are the experimental procedures for the animal clear and precise?</span></label>
                        <textarea name="experimental_procedures_comment" data-group="experimental_procedures" id="7" placeholder="Comments" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('experimental_procedures_comment', $form->experimental_procedures_comment ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6"><span>Are experimental endpoints and durations of experiments clear?</span></label>
                        <textarea name="endpoint_duration_comment" data-group="endpoint_duration" id="8" placeholder="Comments" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('endpoint_duration_comment', $form->endpoint_duration_comment ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6"><span>Are the methods of euthanasia appropriate?</span></label>
                        <textarea name="euthanasia_method_comment" data-group="euthanasia_method" id="9" placeholder="Comments" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('euthanasia_method_comment', $form->euthanasia_method_comment ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6"><span>Is the pain category appropriate for the research being done?</span></label>
                        <textarea name="pain_category_comment" data-group="pain_category" id="10" placeholder="Comments" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('pain_category_comment', $form->pain_category_comment ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6"><span>If alternative housing and husbandry methods are proposed, are they acceptable and justified?</span></label>
                        <textarea name="alternative_housing_comment" data-group="alternative_housing" id="11" placeholder="Comments" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('alternative_housing_comment', $form->alternative_housing_comment ?? '') }}</textarea>
                    </div>
                </div>
                <div class="px-3 mt-2 space-y-2 max-sm:text-sm">
                    <h2 class="py-2 font-semibold text-lg max-2xl:text-base max-sm:text-sm">AS APPLICABLE</h2>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6"><span>If hazardous material use is proposed, are appropriate measures described for handling?</span></label>
                        <textarea name="hazardous_material_comment" data-group="hazardous_material" id="12" placeholder="Comments" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('hazardous_material_comment', $form->hazardous_material_comment ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6"><span>If multiple survival surgery is proposed, is the scientific justification adequate?</span></label>
                        <textarea name="multiple_survival_comment" data-group="multiple_survival" id="13" placeholder="Comments" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('multiple_survival_comment', $form->multiple_survival_comment ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6"><span>If pain relief would be withheld, is the scientific justification adequate?</span></label>
                        <textarea name="pain_relief_comment" data-group="pain_relief" id="14" placeholder="Comments" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('pain_relief_comment', $form->pain_relief_comment ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6"><span>If animals may become seriously ill or debilitated, are criteria for interventional euthanasia defined?</span></label>
                        <textarea name="ill_debilitated_comment" data-group="ill_debilitated" id="15" placeholder="Comments" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('ill_debilitated_comment', $form->ill_debilitated_comment ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6"><span>Do you anticipate complications to the procedures not considered by the Investigator?</span></label>
                        <textarea name="complications_comment" data-group="complications" id="16" placeholder="Comments" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('complications_comment', $form->complications_comment ?? '') }}</textarea>
                    </div>
                </div>
                <div class="px-3 mt-2 space-y-2 max-sm:text-sm">
                    <h2 class="py-2 font-semibold text-lg max-2xl:text-base max-sm:text-sm">VETERINARY REVIEW</h2>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6"><span>Do you anticipate complications to the procedures not considered by the Investigator?</span></label>
                        <textarea name="veterinary_complications_comment" data-group="veterinary_complications" id="17" placeholder="Comments" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('veterinary_complications_comment', $form->veterinary_complications_comment ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6"><span>Are the proposed anesthesia and analgesia appropriate?</span></label>
                        <textarea name="proposed_anesthesia_comment" data-group="proposed_anesthesia" id="18" placeholder="Comments" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('proposed_anesthesia_comment', $form->proposed_anesthesia_comment ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6"><span>Are the post-procedural care and observation adequate</span></label>
                        <textarea name="post_procedural_comment" data-group="post_procedural" id="19" placeholder="Comments" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('post_procedural_comment', $form->post_procedural_comment ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6"><span>Are the methods of euthanasia appropriate?</span></label>
                        <textarea name="appropriate_method_comment" data-group="appropriate_method" id="20" placeholder="Comments" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('appropriate_method_comment', $form->appropriate_method_comment ?? '') }}</textarea>
                    </div>
                </div>
                <div class="px-3 mt-2 space-y-2 max-sm:text-sm">
                    <div>
                        <label><span class="font-semibold">Summary/Comments</span></label>
                        <textarea name="summary_comments" id="summary_comments" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('summary_comments', $form->summary_comments ?? '') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <div class="p-3 flex items-center justify-center space-x-2">
                    <button type="submit" class="bg-primary text-secondary hover:bg-secondary hover:text-primary duration-200 tracking-widest p-4 max-sm:p-3 rounded max-sm:text-sm">SAVE</button>
                    <a href="{{ route('export.protocol-review-checklist') }}" class="inline-block">
                        <button type="button" class="bg-secondary text-primary hover:bg-primary hover:text-secondary duration-200 tracking-widest p-4 max-sm:p-3 rounded max-sm:text-sm">EXPORT TO PDF</button>
                    </a>
                </div>
            </div>
        </form>
    </main>
</x-iacuc-reviewer>
'''
Path('resources/views/iacuc-reviewer/forms/protocol-review-checklist.blade.php').write_text(content, encoding='utf-8')
print('view fixed')
