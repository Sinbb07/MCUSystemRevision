@section('title', 'Form 2(J)')
<x-erb-reviewer>
    <main class="xl:ml-[335px] max-xl:ml-auto p-4 max-md:p-2">
        <form action="{{ route('form2j.store') }}" method="POST" class="block">
            @csrf
            <input type="hidden" name="protocol_ID" value="{{ $protocol_data?->protocol_ID }}">
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <p class="text-right mt-3 mr-3 max-lg:text-sm max-md:text-sm max-sm:text-xs">FORM 2(J)</p>
                <h1
                    class="text-center mt-10 max-2xl:mt-6 max-lg:mt-6 max-md:mt-6 font-bold text-2xl max-xl:text-xl max-lg:text-lg max-md:text-base max-sm:text-sm mb-2 underline">
                    INFORMED CONSENT EVALUATION CHECKLIST
                </h1>
            </div>
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <div class="p-3 mt-2 space-y-2 text-base max-sm:text-sm">
                    <div class="grid grid-cols-[max-content_1fr] max-sm:grid-cols-1 gap-x-20 gap-y-3 max-w-full">
                        <div class="font-bold">MCUERB Code:</div>
                        <div class="max-sm:mb-2">{{ $protocol_data?->protocol_ID ?? 'N/A' }}</div>

                        <div class="font-bold">Study Protocol Title:</div>
                        <div class="max-sm:mb-2">{{ $pi?->researchInformation?->research_title ?? 'N/A' }}</div>

                        <div class="font-bold">Principal Investigator (PI):</div>
                        <div class="max-sm:mb-2">{{ $pi?->full_name ?? 'N/A' }}</div>

                        <div class="font-bold">PI Contact Numbers:</div>
                        <div class="max-sm:mb-2">{{ $pi?->phone_number ?? 'N/A' }}</div>

                        <div class="font-bold">Study Protocol Submission Date:</div>
                        <div class="max-sm:mb-2">{{ $protocol_data?->created_at?->format('Y-m-d') ?? 'N/A' }}</div>

                        <div class="font-bold">Study Protocol Review Date:</div>
                        <div class="max-sm:mb-2">{{ now()->format('Y-m-d') }}</div>
                    </div>
                </div>
            </div>
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <h2 class="px-3 py-2 font-bold text-lg max-2xl:text-base max-sm:text-sm">TO BE FILLED UP BY
                    NON-SCIENTIST MEMBER
                </h2>
                <div class="p-3 mt-2 space-y-2 text-base max-sm:text-sm">
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>
                                Is the manner in which potential participants will be recruited, contacted, screened,
                                and registered in the study described?
                            </span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="check mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="potential_manner" value="Yes"
                                    {{ old('potential_manner', $form2j->potential_manner ?? '') === 'Yes' ? 'checked' : '' }}>
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="check mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="potential_manner" value="No"
                                    {{ old('potential_manner', $form2j->potential_manner ?? '') === 'No' ? 'checked' : '' }}>
                                <span>No</span>
                            </label>
                        </div>
                        <textarea name="manner_described" id="" placeholder="Comments"
                            class="mt-1 w-full resize-none max-sm:text-sm">{{ old('manner_described', $form2j->manner_described ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>
                                Are conditions and characteristics applicable to the identification and selection of
                                participants in the study and the conditions necessary for eligible persons to be
                                included discussed? (Inclusion criteria)
                            </span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="check mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="conditions_characteristics" value="Yes"
                                    {{ old('conditions_characteristics', $form2j->conditions_characteristics ?? '') === 'Yes' ? 'checked' : '' }}>
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="check mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="conditions_characteristics" value="No"
                                    {{ old('conditions_characteristics', $form2j->conditions_characteristics ?? '') === 'No' ? 'checked' : '' }}>
                                <span>No</span>
                            </label>
                        </div>
                        <textarea name="apply_characteristics" id="" placeholder="Comments"
                            class="mt-1 w-full resize-none max-sm:text-sm">{{ old('apply_characteristics', $form2j->apply_characteristics ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>
                                Are there any groups of people who might be more susceptible to the risks presented by
                                the study and who therefore ought to be excluded from the research?
                            </span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="check mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="susceptible_risks" value="Yes"
                                    {{ old('susceptible_risks', $form2j->susceptible_risks ?? '') === 'Yes' ? 'checked' : '' }}>
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="check mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="susceptible_risks" value="No"
                                    {{ old('susceptible_risks', $form2j->susceptible_risks ?? '') === 'No' ? 'checked' : '' }}>
                                <span>No</span>
                            </label>
                        </div>
                        <textarea name="exclusion_people" id="" placeholder="Comments"
                            class="mt-1 w-full resize-none max-sm:text-sm">{{ old('exclusion_people', $form2j->exclusion_people ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>
                                Has any special vulnerability among prospective study participants that might be
                                relevant to evaluating the risk of participation taken into account?
                            </span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="check mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="special_vulnerability" value="Yes"
                                    {{ old('special_vulnerability', $form2j->special_vulnerability ?? '') === 'Yes' ? 'checked' : '' }}>
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="check mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="special_vulnerability" value="No"
                                    {{ old('special_vulnerability', $form2j->special_vulnerability ?? '') === 'No' ? 'checked' : '' }}>
                                <span>No</span>
                            </label>
                        </div>
                        <textarea name="relevant" id="" placeholder="Comments"
                            class="mt-1 w-full resize-none max-sm:text-sm">{{ old('relevant', $form2j->relevant ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>
                                Is there an indication of special measures to be implemented to protect vulnerability of
                                study participants?
                            </span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="check mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="special_measures" value="Yes"
                                    {{ old('special_measures', $form2j->special_measures ?? '') === 'Yes' ? 'checked' : '' }}>
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="check mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="special_measures" value="No"
                                    {{ old('special_measures', $form2j->special_measures ?? '') === 'No' ? 'checked' : '' }}>
                                <span>No</span>
                            </label>
                        </div>
                        <textarea name="indicate_measures" id="" placeholder="Comments"
                            class="mt-1 w-full resize-none max-sm:text-sm">{{ old('indicate_measures', $form2j->indicate_measures ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>
                                Are procedure for informing participants about study and methods and for obtaining
                                consent clearly described?
                            </span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="check mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="study_methods" value="Yes"
                                    {{ old('study_methods', $form2j->study_methods ?? '') === 'Yes' ? 'checked' : '' }}>
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="check mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="study_methods" value="No"
                                    {{ old('study_methods', $form2j->study_methods ?? '') === 'No' ? 'checked' : '' }}>
                                <span>No</span>
                            </label>
                        </div>
                        <textarea name="describe_study_methods" id="" placeholder="Comments"
                            class="mt-1 w-full resize-none max-sm:text-sm">{{ old('describe_study_methods', $form2j->describe_study_methods ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>
                                Are measures to ensure anonymity and confidentiality of the study participants and data
                                collected clearly indicated?
                            </span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="check mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="confidentiality" value="Yes"
                                    {{ old('confidentiality', $form2j->confidentiality ?? '') === 'Yes' ? 'checked' : '' }}>
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="check mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="confidentiality" value="No"
                                    {{ old('confidentiality', $form2j->confidentiality ?? '') === 'No' ? 'checked' : '' }}>
                                <span>No</span>
                            </label>
                        </div>
                        <textarea name="anonymity" id="" placeholder="Comments"
                            class="mt-1 w-full resize-none max-sm:text-sm">{{ old('anonymity', $form2j->anonymity ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>
                                Are procedures regarding confidentiality of the data, including how confidentiality will
                                be preserved during transmission, use and storage of data and the names of persons or
                                positions responsible for technical and administrative stewardship responsibilities
                                properly discussed?
                            </span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="check mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="confidential_procedures" value="Yes"
                                    {{ old('confidential_procedures', $form2j->confidential_procedures ?? '') === 'Yes' ? 'checked' : '' }}>
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="check mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="confidential_procedures" value="No"
                                    {{ old('confidential_procedures', $form2j->confidential_procedures ?? '') === 'No' ? 'checked' : '' }}>
                                <span>No</span>
                            </label>
                        </div>
                        <textarea name="discussed_confidentiality" id="" placeholder="Comments"
                            class="mt-1 w-full resize-none max-sm:text-sm">{{ old('discussed_confidentiality', $form2j->discussed_confidentiality ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>
                                Are procedures on how final disposition of records, data, and computer files, and
                                specimens will be, including location for any relevant information to be stored
                                discussed?
                            </span>
                        </label>
                        <div class="flex mt-1 space-x-1 gap-x-2">
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="check mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="disposition_records" value="Yes"
                                    {{ old('disposition_records', $form2j->disposition_records ?? '') === 'Yes' ? 'checked' : '' }}>
                                <span>Yes</span>
                            </label>
                            <label class="flex items-start space-x-2 max-sm:text-sm/6">
                                <input type="radio" class="check mt-1 max-sm:w-[14px] max-sm:h-[14px]"
                                    name="disposition_records" value="No"
                                    {{ old('disposition_records', $form2j->disposition_records ?? '') === 'No' ? 'checked' : '' }}>
                                <span>No</span>
                            </label>
                        </div>
                        <textarea name="disposition_discuss" id="" placeholder="Comments"
                            class="mt-1 w-full resize-none max-sm:text-sm">{{ old('disposition_discuss', $form2j->disposition_discuss ?? '') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <div class="p-3 mt-2 space-y-2 text-base max-sm:text-sm">
                    <h2 class="pb-2 font-bold text-lg max-2xl:text-base max-sm:text-sm">SUMMARY OF RECOMMENDATIONS:
                    </h2>
                    <div>
                        <label>
                            <span>
                                1.
                            </span>
                        </label>
                        <textarea name="summary_recommendation_1" id="" placeholder="Summary of Recommendations"
                            class="mt-1 w-full resize-none max-sm:text-sm">{{ old('summary_recommendation_1', $form2j->summary_recommendation_1 ?? '') }}</textarea>
                    </div>
                    <div>
                        <label>
                            <span>
                                2.
                            </span>
                        </label>
                        <textarea name="summary_recommendation_2" id="" placeholder="Summary of Recommendations"
                            class="mt-1 w-full resize-none max-sm:text-sm">{{ old('summary_recommendation_2', $form2j->summary_recommendation_2 ?? '') }}</textarea>
                    </div>
                    <div>
                        <label>
                            <span>
                                3.
                            </span>
                        </label>
                        <textarea name="summary_recommendation_3" id="" placeholder="Summary of Recommendations"
                            class="mt-1 w-full resize-none max-sm:text-sm">{{ old('summary_recommendation_3', $form2j->summary_recommendation_3 ?? '') }}</textarea>
                    </div>
                    <div>
                        <label>
                            <span>
                                4.
                            </span>
                        </label>
                        <textarea name="summary_recommendation_4" id="" placeholder="Summary of Recommendations"
                            class="mt-1 w-full resize-none max-sm:text-sm">{{ old('summary_recommendation_4', $form2j->summary_recommendation_4 ?? '') }}</textarea>
                    </div>
                </div>
                <div class="p-3 mt-2 space-y-2 text-base max-sm:text-sm">
                    <!-- RECOMMENDED ACTION -->
                    <h2 class="pt-2 font-bold text-lg max-2xl:text-base max-sm:text-sm">RECOMMENDED ACTION
                    </h2>
                    <div class="grid grid-cols-2 gap-x-5">
                        <label class="flex items-start space-x-2 max-sm:text-sm/6">
                            <input type="radio" class="check mt-1 max-sm:w-[14px] max-sm:h-[14px]" 
                                name="action" value="Approve"
                                {{ old('action', $form2j->action ?? '') === 'Approve' ? 'checked' : '' }}>
                            <span>Approve</span>
                        </label>
                        <label class="flex items-start space-x-2 max-sm:text-sm/6">
                            <input type="radio" class="check mt-1 max-sm:w-[14px] max-sm:h-[14px]" 
                                name="action" value="Disapprove"
                                {{ old('action', $form2j->action ?? '') === 'Disapprove' ? 'checked' : '' }}>
                            <span>Disapprove</span>
                        </label>
                    </div>
                </div>

                <!-- JUSTIFICATION FOR RECOMMENDED ACTION -->
                <div class="p-3 mt-2 space-y-2 text-base max-sm:text-sm">
                    <h2 class="pb-2 font-bold text-lg max-2xl:text-base max-sm:text-sm">JUSTIFICATION FOR RECOMMENDED
                        ACTION:
                    </h2>
                    <div>
                        <textarea name="justification" id="" placeholder="Summary of Recommendations"
                            class="mt-1 w-full resize-none max-sm:text-sm">{{ old('justification', $form2j->justification ?? '') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <div class="p-3 flex items-center justify-center space-x-2">
                    <button type="submit"
                        class="bg-primary text-secondary hover:bg-secondary hover:text-primary duration-200 tracking-widest p-4 max-sm:p-3 rounded max-sm:text-sm">SAVE</button>
                    <a href="{{ route('export.form2j') }}" target="_blank">
                        <button type="button"
                            class="bg-secondary text-primary hover:bg-primary hover:text-secondary duration-200 tracking-widest p-4 max-sm:p-3 rounded max-sm:text-sm">EXPORT
                            TO PDF</button>
                    </a>
                </div>
            </div>
        </form>
    </main>
</x-erb-reviewer>