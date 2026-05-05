@section('title', 'Form 3(B)')
<x-student-layout>
    <main class="xl:ml-[335px] max-xl:ml-auto p-4 max-md:p-2">
        <form action="{{ route('form3b.store') }}" method="POST" class="block">
            @csrf
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <p class="text-right mt-3 mr-3 max-lg:text-sm max-md:text-sm max-sm:text-xs">FORM 3(B)</p>
                <h1
                    class="text-center mt-10 max-2xl:mt-6 max-lg:mt-6 max-md:mt-6 font-bold text-2xl max-xl:text-xl max-lg:text-lg max-md:text-base max-sm:text-sm mb-2 underline">
                    REVIEW OF RESUBMITTED STUDY PROTOCOL FORM</h1>
            </div>
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <h2 class="px-3 py-2 font-bold text-lg max-2xl:text-base max-sm:text-sm">STUDY PROTOCOL INFORMATION</h2>
                <div class="p-3 mt-2 space-y-2 text-base max-sm:text-sm">
                    <div class="grid grid-cols-[max-content_1fr] max-sm:grid-cols-1 gap-x-20 gap-y-3 max-w-full">
                        <div class="font-bold">MCUERB Code:</div>
                        <div class="max-sm:mb-2">2025-S1-001</div>

                        <div class="font-bold">Date of Initial Submission:</div>
                        <div class="max-sm:mb-2">{{ $form3b && $form3b->created_at ? $form3b->created_at->format('m/d/Y') : 'N/A' }}</div>

                        <div class="font-bold">Study Protocol Title:</div>
                        <div class="max-sm:mb-2">{{ $researchInfo->research_title ?? 'N/A' }}</div>

                        <div class="font-bold">Resubmitted Protocol Submission Date:</div>
                        <div class="max-sm:mb-2">{{ $form3b && $form3b->updated_at ? $form3b->updated_at->format('m/d/Y') : 'N/A' }}</div>

                        <div class="font-bold">Principal Investigator (PI):</div>
                        <div class="max-sm:mb-2">{{ $principalInvestigator }}</div>

                        <div class="font-bold">Telephone:</div>
                        <div class="max-sm:mb-2">{{ $researchInfo->research_Contact ?? 'N/A' }}</div>

                        <div class="font-bold">Initial Review Date:</div>
                        <div class="max-sm:mb-2">{{ $form3b && $form3b->created_at ? $form3b->created_at->format('m/d/Y') : 'N/A' }}</div>

                        <div class="font-bold">Last Review Date:</div>
                        <div class="max-sm:mb-2">{{ $form3b && $form3b->updated_at ? $form3b->updated_at->format('m/d/Y') : 'N/A' }}</div>

                        <div class="font-bold">Total Participants:</div>
                        <div class="max-sm:mb-2">
                            <input type="text" name="total_participants" value="{{ old('total_participants', $form3b->total_participants ?? '') }}"
                                class="block rounded border border-darkgray max-lg:w-full text-sm h-[30px]">
                        </div>
                    </div>
                    <label class="max-sm:py-1 font-semibold flex items-start space-x-2 max-sm:text-sm/6">
                        <span>
                            REVIEW
                        </span>
                    </label>
                    <div class="flex mt-3 space-x-1 gap-x-2">
                        <label class="flex items-start space-x-2 max-sm:text-sm/6">
                            <input type="radio" class="check mt-1 max-sm:w-[14px] max-sm:h-[14px]" name="review_type" value="2nd_review" {{ old('review_type', $form3b->review_type ?? '') == '2nd_review' ? 'checked' : '' }}>
                            <span>2nd Review</span>
                        </label>
                        <label class="flex items-start space-x-2 max-sm:text-sm/6">
                            <input type="radio" class="check mt-1 max-sm:w-[14px] max-sm:h-[14px]" name="review_type" value="3rd_review" {{ old('review_type', $form3b->review_type ?? '') == '3rd_review' ? 'checked' : '' }}>
                            <span>3rd Review</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <h2 class="px-3 py-2 font-bold text-lg max-2xl:text-base max-md:text-sm">TO BE FILLED UP BY P.I.</h2>
                <div class="p-3 mt-2 space-y-2 max-md:text-sm">
                    <div>
                        <label>
                            <span class="font-semibold">
                                RECOMMENDATION FROM LAST REVIEW
                            </span><br>
                        </label>
                        <textarea name="recommendation_from_last_review" class="mt-1 w-full resize-none max-md:text-sm">{{ old('recommendation_from_last_review', $form3b->recommendation_from_last_review ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>
                                Indicate of the study protocol contains the specified assessment point
                            </span>
                        </label>
                        <textarea name="recommendation_indication" class="mt-1 w-full resize-none max-md:text-sm">{{ old('recommendation_indication', $form3b->recommendation_indication ?? '') }}</textarea>
                    </div>
                </div>
                <div class="p-3 space-y-2 max-sm:text-sm">
                    <label class="font-semibold">1. Address protocol-related issues</label>
                    <div class="pl-4">
                        <label class="block mb-1">1.1</label>
                        <input type="text" name="protocol_issues_1" value="{{ old('protocol_issues_1', $form3b->protocol_issues_1 ?? '') }}"
                            class="w-full h-[35px] max-lg:h-[30px] max-md:text-sm rounded"
                            placeholder="Enter details here" />
                    </div>
                    <div class="pl-4">
                        <label class="block mb-1">1.2</label>
                        <input type="text" name="protocol_issues_2" value="{{ old('protocol_issues_2', $form3b->protocol_issues_2 ?? '') }}"
                            class="w-full h-[35px] max-lg:h-[30px] max-md:text-sm rounded"
                            placeholder="Enter details here" />
                    </div>
                    <div class="pl-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>
                                Indicate of the study protocol contains the specified assessment point
                            </span>
                        </label>
                        <textarea name="indicate_protocol_related" class="mt-1 w-full resize-none max-md:text-sm">{{ old('indicate_protocol_related', $form3b->indicate_protocol_related ?? '') }}</textarea>
                    </div>
                    <div class="pl-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>
                                Page & Paragraph where it is found
                            </span>
                        </label>
                        <input type="text" name="protocol_related_page" value="{{ old('protocol_related_page', $form3b->protocol_related_page ?? '') }}"
                            class="w-full h-[35px] max-lg:h-[30px] max-md:text-sm rounded">
                    </div>
                </div>
                <div class="p-3 space-y-2 max-sm:text-sm">
                    <label class="font-semibold">2. Address ethical-related issues</label>
                    <div class="pl-4">
                        <label class="block mb-1">2.1</label>
                        <input type="text" name="ethical_issues_1" value="{{ old('ethical_issues_1', $form3b->ethical_issues_1 ?? '') }}"
                            class="w-full h-[35px] max-lg:h-[30px] max-md:text-sm rounded"
                            placeholder="Enter details here" />
                    </div>
                    <div class="pl-4">
                        <label class="block mb-1">2.2</label>
                        <input type="text" name="ethical_issues_2" value="{{ old('ethical_issues_2', $form3b->ethical_issues_2 ?? '') }}"
                            class="w-full h-[35px] max-lg:h-[30px] max-md:text-sm rounded"
                            placeholder="Enter details here" />
                    </div>
                    <div class="pl-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>
                                Indicate of the study protocol contains the specified assessment point
                            </span>
                        </label>
                        <textarea name="indicate_ethical_issue" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('indicate_ethical_issue', $form3b->indicate_ethical_issue ?? '') }}</textarea>
                    </div>
                    <div class="pl-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>
                                Page & Paragraph where it is found
                            </span>
                        </label>
                        <input type="text" name="ethical_related_page" value="{{ old('ethical_related_page', $form3b->ethical_related_page ?? '') }}"
                            class="w-full h-[35px] max-lg:h-[30px] max-md:text-sm rounded">
                    </div>
                </div>
                <div class="p-3 space-y-2 max-sm:text-sm">
                    <label class="font-semibold">3. Address informed consent-related issues</label>
                    <div class="pl-4">
                        <label class="block mb-1">3.1</label>
                        <input type="text" name="consent_issues_1" value="{{ old('consent_issues_1', $form3b->consent_issues_1 ?? '') }}"
                            class="w-full h-[35px] max-lg:h-[30px] max-md:text-sm rounded"
                            placeholder="Enter details here" />
                    </div>
                    <div class="pl-4">
                        <label class="block mb-1">3.2</label>
                        <input type="text" name="consent_issues_2" value="{{ old('consent_issues_2', $form3b->consent_issues_2 ?? '') }}"
                            class="w-full h-[35px] max-lg:h-[30px] max-md:text-sm rounded"
                            placeholder="Enter details here" />
                    </div>
                    <div class="pl-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>
                                Indicate of the study protocol contains the specified assessment point
                            </span>
                        </label>
                        <textarea name="indicate_consent_related" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('indicate_consent_related', $form3b->indicate_consent_related ?? '') }}</textarea>
                    </div>
                    <div class="pl-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>
                                Page & Paragraph where it is found
                            </span>
                        </label>
                        <input type="text" name="consent_related_page" value="{{ old('consent_related_page', $form3b->consent_related_page ?? '') }}"
                            class="w-full h-[35px] max-lg:h-[30px] max-md:text-sm rounded">
                    </div>
                </div>
                <div class="p-3 space-y-2 max-sm:text-sm">
                    <label class="font-semibold">4. Changes that were not part of the initial review</label>
                    <div class="pl-4">
                        <label class="block mb-1">4.1</label>
                        <input type="text" name="review_changes_1" value="{{ old('review_changes_1', $form3b->review_changes_1 ?? '') }}"
                            class="w-full h-[35px] max-lg:h-[30px] max-md:text-sm rounded"
                            placeholder="Enter details here" />
                    </div>
                    <div class="pl-4">
                        <label class="block mb-1">4.2</label>
                        <input type="text" name="review_changes_2" value="{{ old('review_changes_2', $form3b->review_changes_2 ?? '') }}"
                            class="w-full h-[35px] max-lg:h-[30px] max-md:text-sm rounded"
                            placeholder="Enter details here" />
                    </div>
                    <div class="pl-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>
                                Indicate of the study protocol contains the specified assessment point
                            </span>
                        </label>
                        <textarea name="indicate_review_changes" class="mt-1 w-full resize-none max-sm:text-sm">{{ old('indicate_review_changes', $form3b->indicate_review_changes ?? '') }}</textarea>
                    </div>
                    <div class="pl-4">
                        <label class="max-sm:py-1 flex items-start space-x-2 max-sm:text-sm/6">
                            <span>
                                Page & Paragraph where it is found
                            </span>
                        </label>
                        <input type="text" name="review_changes_page" value="{{ old('review_changes_page', $form3b->review_changes_page ?? '') }}"
                            class="w-full h-[35px] max-lg:h-[30px] max-md:text-sm rounded">
                    </div>
                </div>
            </div>
            @php
                $hasSavedForm = !empty($form3b); 
            @endphp
            <!-- BUTTONS -->
            <div class="mt-3 p-1 max-w-7xl w-full bg-lightgray rounded mx-auto shadow-md">
                <div class="p-3 flex items-center justify-center space-x-2">
                    <button type="submit"
                        class="bg-primary text-secondary hover:bg-secondary hover:text-primary duration-200 tracking-widest p-4 max-sm:p-3 rounded max-sm:text-sm">SAVE</button>
                    <a href="{{ route('export.form3b') }}" target="_blank">
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