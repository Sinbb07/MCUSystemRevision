<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FORM-2E</title>
    @vite('resources/css/app.css')
</head>
<style>
    .page-break {
        break-before: page;
    }
</style>
<body class="p-8 text-sm font-arial">
    <h1 class="text-xl font-times font-black text-center mb-6">MCUERB FORM 2E Protocol Evaluation Checklist</h1>

    <x-formbanner>MCUERB FORM 2E Protocol Evaluation Checklist</x-formbanner>

    <div class = "mb-8"></div>
    <div class ="flex flex-col border">
        <div class = "w-full bg-[#9ca3af]">
            <p class = "text-sm font-bold text-center m-1">TO BE FILLED UP</p>
        </div>
        <div class = "w-full border-t">
            <p class = "text-sm font-bold text-L m-1">STUDY PROTOCOL INFORMATION</p>
        </div>
        <div class ="flex items-center border-t">
            <div class = "px-2 w-1/4 border-r">
                <p class = "text-sm font-bold text-l mb-2">MCUERB CODE:</p>
            </div>
            <p class = "text-sm text-l mb-2">{{ $protocol_data->protocol_ID ?? $form2e->protocol_ID ?? 'N/A' }}</p>
        </div>
        <div class = "flex items-center border-t">
            <div class = "px-2 w-1/4 border-r">
                <p class = "text-sm font-bold text-l mb-2">Study Protocol Title</p>
            </div>
            <p class = "text-sm text-l mb-2">{{ $pi->researchInformation->research_title ?? 'N/A' }}</p>
        </div>
        <div class = "flex items-center border-t">
            <div class = "px-2 w-1/4 border-r">
                <p class = "text-sm font-bold text-l mb-2">Principal Investigator (PI)</p>
            </div>
            <p class = "text-sm text-l mb-2">{{ $pi->full_name ?? $pi->user_Fname . ' ' . ($pi->user_Lname ?? '') }}</p>
        </div>
        <div class = "flex items-center border-t">
            <div class = "px-2 w-1/4 border-r">
                <p class = "text-sm font-bold text-l mb-2">Co-Investigators</p>
            </div>
            <p class = "text-sm text-l mb-2">{{ $co_investigator ?? 'N/A' }}</p>
        </div>
        <div class = "flex items-center border-t">
            <div class = "px-2 w-1/4 border-r">
                <p class = "text-sm font-bold text-l mb-2">PI Contact Numbers</p>
            </div>
            <p class = "text-sm text-l mb-2">{{ $pi->phone_number ?? $pi->user_Phone ?? 'N/A' }}</p>
        </div>
        <div class = "flex items-center border-t">
            <div class = "px-2 w-1/4 border-r">
                <p class = "text-sm font-bold text-l mb-2">PI Email Address</p>
            </div>
            <p class = "text-sm text-l mb-2">{{ $pi->email ?? $pi->user_Email ?? 'N/A' }}</p>
        </div>
        <div class = "flex items-center border-t">
            <div class = "px-2 w-1/4 border-r">
                <p class = "text-sm font-bold text-l mb-2">Study Protocol Submission Date</p>
            </div>
            <p class = "text-sm text-l mb-2">{{ isset($protocol_data->created_at) ? \Carbon\Carbon::parse($protocol_data->created_at)->format('Y-m-d') : 'N/A' }}</p>
        </div>
        <div class = "flex items-center border-t">
            <div class = "px-2 w-1/4 border-r">
                <p class = "text-sm font-bold text-l mb-2">Study Protocol Review Date</p>
            </div>
            <p class = "text-sm text-l mb-2">{{ now()->format('Y-m-d') }}</p>
        </div>
        <div class = "flex items-center border-t">
            <div class = "px-2 w-full">
                <p class = "text-sm font-bold text-center text-l m-2">PROTOCOL EVALUATION FORM</p>
            </div>
        </div>
    </div>

    <h1 class = "text-base font-bold text-center underline mt-2 mb-4">STUDY PROTOCOL EVALUATION CHECKLIST</h1>

    <div class = "flex flex-col border">
        <div class = "w-full bg-[#9ca3af]">
            <p class = "text-xs font-bold text-center m-1">TO BE FILLED UP BY PRIMARY REVIEWER</p>
        </div>
        <div class = "flex items-stretch border-t">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-center text-l mb-2">GUIDE QUESTIONS</p>
            </div>
            <div class = "px-2 w-20 border-r">
                <p class = "text-xs text-center text-l mb-2">YES</p>
            </div>
            <div class = "px-2 w-20 border-r">
                <p class = "text-xs text-center text-l mb-2">NO</p>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-xs text-l font-bold mb-2">COMMENTS</p>
            </div>
        </div>
        <div class = "flex items-stretch border-t">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• Does the title summarize the main idea under investigation and is able to stand alone as an explanation of the study?</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-sm text-l mb-2">{{ $form2e->main_idea_summarize ?? 'N/A' }}</p>
            </div>
        </div>
        <div class = "flex items-stretch border-t">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• Are the scientific significance, public health, the contributions this study will make 
                                                    and the expected applicability of study findings discussed clearly?</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-sm text-l mb-2">{{ $form2e->significance_discuss ?? 'N/A' }}</p>
            </div>
        </div>
        <div class = "flex items-stretch border-t">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• Does the study require human participants?</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-sm text-l mb-2">{{ $form2e->require_human_participants ?? 'N/A' }}</p>
            </div>
        </div>
        <div class = "flex items-stretch border-t">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• Are the problem statement and research questions or objectives that the study will address, 
                                                    formulated and stated correctly, clearly, and concisely?</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-sm text-l mb-2">{{ $form2e->problem_statement_address ?? 'N/A' }}</p>
            </div>
        </div>
        <div class = "flex items-stretch border-t">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• Is the background of the study adequate?</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-sm text-l mb-2">{{ $form2e->adequate ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <div class = "page-break"></div>

    <!----page 2-->

    <div class = "flex flex-col border">
        <div class = "flex items-stretch">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• Are relevant information discussed about the participant of the study based on a review of the literature?</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-sm text-l mb-2">{{ $form2e->information_discuss ?? 'N/A' }}</p>
            </div>
        </div>
        <div class = "flex items-stretch border-t">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• Is the population from which the participants and sample will be drawn defined?</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-sm text-l mb-2">{{ $form2e->population_define ?? 'N/A' }}</p>
            </div>
        </div>
        <div class = "flex items-stretch border-t">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• Is the approximate sample size specified and is it appropriate for the nature of the research?</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-sm text-l mb-2">{{ $form2e->approx_size ?? 'N/A' }}</p>
            </div>
        </div>
        <div class = "flex items-stretch border-t">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• Is the manner in which potential participants 
                                                    will be recruited, contacted, screened, and registered 
                                                    in the study described?</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-sm text-l mb-2">{{ $form2e->participants_manner ?? 'N/A' }}</p>
            </div>
        </div>
        <div class = "flex items-stretch border-t">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• Is/Are the study site(s) clearly identified?</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-sm text-l mb-2">{{ $form2e->site_identify ?? 'N/A' }}</p>
            </div>
        </div>
        <div class = "flex items-stretch border-t">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• Is the study design appropriate for 
                                                    the objectives and research questions?</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-sm text-l mb-2">{{ $form2e->appropriate_questions ?? 'N/A' }}</p>
            </div>
        </div>
        <div class = "flex items-stretch border-t">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• Are conditions and characteristics applicable to the identification and 
                                                    selection of participants in the study and the 
                                                    conditions necessary for eligible persons to be 
                                                    included discussed? (Inclusion criteria)</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-sm text-l mb-2">{{ $form2e->apply_characteristics ?? 'N/A' }}</p>
            </div>
        </div>
        <div class = "flex items-stretch border-t">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• Are characteristics that would disqualify otherwise eligible 
                                                    participants from the study described? (Exclusion criteria)</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-sm text-l mb-2">{{ $form2e->characteristics_disqualify ?? 'N/A' }}</p>
            </div>
        </div>
        <div class = "flex items-stretch border-t">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• Is there any vulnerable participant involved (Ex: Children 
                    (under 18), Indigenous People, PWD, Elderly, etc.)? Are there any groups of people who 
                    might be more susceptible to the risks presented by the study and who therefore ought 
                    to be excluded from the research? Will this study increase the discrimination, discomfort, 
                    and inconvenience of the study participants?</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-sm text-l mb-2">{{ $form2e->involvement ?? 'N/A' }}</p>
            </div>
        </div>
        <div class = "flex items-stretch border-t">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• Has any special vulnerability (in terms of the procedure) 
                    among prospective study participants that might be relevant to evaluating the risk 
                    of participation taken into account?</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-sm text-l mb-2">{{ $form2e->vulnerability_evaluation ?? 'N/A' }}</p>
            </div>
        </div>
        <div class = "flex items-stretch border-t">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• Is there an indication of special measures to be 
                                                    implemented to protect vulnerability of study participants?</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-sm text-l mb-2">{{ $form2e->indicate_measures ?? 'N/A' }}</p>
            </div>
        </div>
        <div class = "flex items-stretch border-t">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• Are the procedures to be done in the study clearly described and are understandable?</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-sm text-l mb-2">{{ $form2e->describe_procedure ?? 'N/A' }}</p>
            </div>
        </div>
        <div class = "flex items-stretch border-t">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• Are procedures for informing participants 
                        about study and methods and for obtaining consent clearly described?</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                {{-- Form2J has this field, not Form2E --}}
                <p class = "text-sm text-l mb-2">N/A</p>
            </div>
        </div>
        <div class = "flex items-stretch border-t">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• Are the overall procedures for management of the data 
                        collected and the process for entering and editing data described?</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-sm text-l mb-2">{{ $form2e->overall_procedure_describe ?? 'N/A' }}</p>
            </div>
        </div>
        <div class = "flex items-stretch border-t">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• Are measures to ensure anonymity and confidentiality 
                    of the study participants and data collected clearly indicated?</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-sm text-l mb-2">{{ $form2e->confidentiality_measures ?? 'N/A' }}</p>
            </div>
        </div>
        <div class = "flex items-stretch border-t">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• How study materials, including questionnaires, 
                    statistical analyses, computer programs and other computerized information, 
                    whether used for publication or not, will be maintained and safeguarded 
                    described in the study?</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-sm text-l mb-2">{{ $form2e->describe_maintain ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <div class = "page-break"></div>

    <!----page 3--->

    <div class = "flex flex-col border">
        <div class = "flex items-stretch">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• Are procedures regarding confidentiality of the data, 
                    including how confidentiality will be preserved during transmission, 
                    use and storage of the data and the names of persons or positions 
                    responsible for technical and administrative stewardship responsibilities 
                    properly discussed?</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-sm text-l mb-2">{{ $form2e->preserve_data ?? 'N/A' }}</p>
            </div>
        </div>
        <div class = "flex items-stretch border-t">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• Are procedures on how final disposition 
                    of records, data, and computer files, and specimens will be, 
                    including location for any relevant information to be stored discussed?</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-sm text-l mb-2">{{ $form2e->disposition_records ?? 'N/A' }}</p>
            </div>
        </div>
        <div class = "flex items-stretch border-t">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• Has due care been clearly 
                    specified to minimize risks and maximize the likelihood of benefits?</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-sm text-l mb-2">{{ $form2e->minimize_maximize ?? 'N/A' }}</p>
            </div>
        </div>
        <div class = "flex items-stretch border-t">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• Is a timeline or duration of the study in Gantt chart with estimated dates 
                    for implementing and completing key activities provided and specified?</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-sm text-l mb-2">{{ $form2e->estimated_date ?? 'N/A' }}</p>
            </div>
        </div>
        <div class = "flex items-stretch border-t">
            <div class = "px-2 w-5/6 border-r">
                <p class = "text-xs text-l mb-2">• Is training, such as interviewer techniques, 
                    data collection and handling methods or informed consent, 
                    provided to investigators/researchers described?</p>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class="px-2 w-20 border-r flex justify-center items-center">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                </div>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-sm text-l mb-2">{{ $form2e->techniques_described ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <div class = "mt-4"></div>
    <div class = "flex flex-col border">
        <div class = "w-full">
            <p class = "text-xs font-bold text-center m-1">Summary of Recommendations:</p>
        </div>
        <div class = "w-full border-t">
            <p class = "text-xs text-center m-1">1. {{ $form2e->summary_recommendation_1 ?? 'N/A' }}</p>
            <p class = "text-xs text-center m-1">2. {{ $form2e->summary_recommendation_2 ?? 'N/A' }}</p>
            <p class = "text-xs text-center m-1">3. {{ $form2e->summary_recommendation_3 ?? 'N/A' }}</p>
            <p class = "text-xs text-center m-1">4. {{ $form2e->summary_recommendation_4 ?? 'N/A' }}</p>
        </div>
        <div class = "w-full border-t">
            <p class = "text-xs font-bold text-center m-1">Recommended Action:</p>
        </div>
        <div class ="flex items-stretch border-t pt-1 pb-1">
            <div class = "flex flex-col w-full items-start px-2">
                <div class = "flex items-center pb-2">
                    <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                        @if(($form2e->action ?? '') === 'Approve')✓@endif
                    </div>
                    <span class="text-xs ml-2">Approve</span>
                </div>
                <div class = "flex items-center pb-2">
                    <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                        @if(($form2e->action ?? '') === 'Minor Modifications')✓@endif
                    </div>
                    <span class = "text-xs ml-2">Minor Modifications</span>
                </div>
                <div class = "flex items-center pb-2">
                    <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                        @if(($form2e->action ?? '') === 'Major Modifications')✓@endif
                    </div>
                    <span class="text-sm ml-2">Major Modifications</span>
                </div>
                <div class = "flex items-center pb-2">
                    <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                        @if(($form2e->action ?? '') === 'Disapprove')✓@endif
                    </div>
                    <span class="text-xs ml-2">Disapprove</span>
                </div>
                <div class = "flex items-center pb-2">
                    <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                        @if(($form2e->action ?? '') === 'Pending if Major Clarifications are Required Before a Decision can be Made')✓@endif
                    </div>
                    <span class="text-xs ml-2">Pending if Major Clarifications are Required Before a Decision can be Made</span>
                </div>
            </div>
        </div>
        <div class ="flex items-center border-b">
            <div class = "w-full border-t">
                <p class = "text-xs font-bold text-center m-1">Justification for Recommended Action:</p>
                <p class = "text-sm text-l mb-2">{{ $form2e->justification ?? 'N/A' }}</p>
            </div>
        </div>
        <div class ="flex items-center">
            <div class = "w-2/5">
                <p class = "text-xs font-bold text-l m-1">Primary Reviewer</p>
            </div>
            <p class = "text-xs text-l m-1">Signature: ______________________________</p>
        </div>
        <div class ="flex items-center">
            <div class = "w-2/5">
                <p class = "text-xs text-l ml-1 mt-4">Date: {{ now()->format('Y-m-d') }}</p>
            </div>
            <p class = "text-xs text-l m-1">Name: {{ $reviewer->user_Fname ?? '' }} {{ $reviewer->user_Lname ?? '' }}</p>
        </div>
    </div>
</body>
</html>