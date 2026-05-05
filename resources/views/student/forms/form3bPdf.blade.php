<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FORM-3B</title>
    @vite('resources/css/app.css') {{-- Tailwind --}}
    <style>
        .page-break {
            break-before: page;
        }
    </style>
</head>
<body class="p-2 text-sm font-arial">
    <h1 class="text-xl font-times font-black text-center mb-6">MCUERB FORM 3(B) Review of Resubmitted Study Protocol</h1>

    <x-formbanner>MCUERB FORM 3(B) Review of Resubmitted Study Protocol</x-formbanner>

    <h1 class="text-base font-bold text-center underline mb-4">Review of Resubmitted Study Protocol Form</h1>

    <div class="flex flex-col border">
        <div class ="flex items-center">
            <div class = "px-2 w-1/2 border-r">
                <p class = "text-xs text-l mb-2">MCUERB CODE: {{ $mcuerbCode ?? '2025-S1-001' }}</p>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-xs text-l mb-2">Date of Initial Submission: {{ $form3b && $form3b->created_at ? $form3b->created_at->format('m/d/Y') : 'N/A' }}</p>
            </div>
        </div>
        <div class = "w-full border-t">
            <p class = "text-xs text-L m-1">Study Protocol Title: {{ $researchInfo->research_title ?? 'N/A' }}</p>
        </div>
        <div class ="flex items-center border-t">
            <div class = "px-2 w-1/2 border-r">
                <p class = "text-xs text-l mb-2">Resubmitted protocol Submission Date:</p>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-xs text-l mb-2">{{ $form3b && $form3b->updated_at ? $form3b->updated_at->format('m/d/Y') : 'N/A' }}</p>
            </div>
        </div>
        <div class ="flex items-center border-t">
            <div class = "px-2 w-1/2 border-r">
                <p class = "text-xs text-l mb-2">Total Participants: {{ $form3b->total_participants ?? 'N/A' }}</p>
            </div>
            <div class="px-2 w-1/2 flex space-x-2">
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                    @if(($form3b->review_type ?? '') === '2nd_review')✓@endif
                </div>
                <span class = "text-xs ml-2 leading-snug">2nd Review</span>
                <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                    @if(($form3b->review_type ?? '') === '3rd_review')✓@endif
                </div>
                <span class = "text-xs ml-2 leading-snug">3rd Review</span>
            </div>
        </div>
        <div class ="flex items-center border-t">
            <div class = "px-2 w-1/2 border-r">
                <p class = "text-xs text-l mb-2">Principal Investigator: {{ $principalInvestigator }}</p>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-xs text-l mb-2">Tel.: {{ $researchInfo->research_Contact ?? 'N/A' }}</p>
            </div>
        </div>
        <div class ="flex items-center border-t">
            <div class = "px-2 w-1/2 border-r">
                <p class = "text-xs text-l mb-2">Initial Review Date: {{ $form3b && $form3b->created_at ? $form3b->created_at->format('m/d/Y') : 'N/A' }}</p>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-xs text-l mb-2">Last Review Date: {{ $form3b && $form3b->updated_at ? $form3b->updated_at->format('m/d/Y') : 'N/A' }}</p>
            </div>
        </div>
        <div class ="flex items-stretch border-t bg-[#9ca3af]">
            <div class = "px-2 w-3/4 border-r">
                <p class = "text-xs text-center font-bold mb-2">To be filled out by the Primary Investigator (PI)</p>
            </div>
            <div class = "px-2 w-1/3">
                <p class = "text-xs text-center font-bold mb-2">To be filled out by the Primary Reviewer</p>
            </div>
        </div>
        <div class ="flex items-stretch border-t">
            <div class = "px-2 w-3/5 border-r">
                <p class = "text-xs text-l mb-2">Recommendations from last review: {{ $form3b->recommendation_from_last_review ?? 'N/A' }}</p>
            </div>
            <div class = "w-2/5 border-r">
                <p class = "text-xs text-l mb-2">Indicate if the study protocol contains the specified assessment point: {{ $form3b->recommendation_indication ?? 'N/A' }}</p>
                <div class="w-full flex border-t">
                    <div class="px-2 w-1/2 flex border-r border-black">
                        <p class="text-xs mb-2">YES</p>
                    </div>
                    <div class="px-2 w-1/2 flex">
                        <p class="text-xs mb-2">N/A</p>
                    </div>
                </div>
            </div>
            <div class = "px-2 w-1/6 border-r">
                <p class = "text-xs text-l mb-2">Page and paragraph where it is found</p>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-xs text-l mb-2">Were the recommendations met (Yes/No)? Explain: N/A</p>
            </div>
        </div>
        <div class ="flex items-stretch border-t">
            <div class = "px-2 w-3/5 border-r">
                <p class = "text-xs text-l mb-2">1. Address protocol-related issues:</p>
                <p class = "text-xs text-l mb-2">{{ $form3b->protocol_issues_1 ?? 'N/A' }}</p>
                <p class = "text-xs text-l mb-2">{{ $form3b->protocol_issues_2 ?? 'N/A' }}</p>
            </div>
            <div class = "w-1/5 border-r">
                <p class="text-xs mb-2">{{ $form3b->indicate_protocol_related ?? 'N/A' }}</p>
            </div>
            <div class = "w-1/5 border-r">
                <p class="text-xs mb-2"></p>
            </div>
            <div class = "px-2 w-1/6 border-r">
                <p class = "text-xs text-l mb-2">{{ $form3b->protocol_related_page ?? 'N/A' }}</p>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-xs text-l mb-2">1. N/A</p>
                <p class = "text-xs text-l mb-2"></p>
            </div>
        </div>
        <div class ="flex items-stretch border-t">
            <div class = "px-2 w-3/5 border-r">
                <p class = "text-xs text-l mb-2">2. Address ethical-related issues:</p>
                <p class = "text-xs text-l mb-2">{{ $form3b->ethical_issues_1 ?? 'N/A' }}</p>
                <p class = "text-xs text-l mb-2">{{ $form3b->ethical_issues_2 ?? 'N/A' }}</p>
            </div>
            <div class = "w-1/5 border-r">
                <p class="text-xs mb-2">{{ $form3b->indicate_ethical_issue ?? 'N/A' }}</p>
            </div>
            <div class = "w-1/5 border-r">
                <p class="text-xs mb-2"></p>
            </div>
            <div class = "px-2 w-1/6 border-r">
                <p class = "text-xs text-l mb-2">{{ $form3b->ethical_related_page ?? 'N/A' }}</p>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-xs text-l mb-2">2. N/A</p>
                <p class = "text-xs text-l mb-2"></p>
            </div>
        </div>
        <div class ="flex items-stretch border-t">
            <div class = "px-2 w-3/5 border-r">
                <p class = "text-xs text-l mb-2">3. Address informed consent-related issues:</p>
                <p class = "text-xs text-l mb-2">{{ $form3b->consent_issues_1 ?? 'N/A' }}</p>
                <p class = "text-xs text-l mb-2">{{ $form3b->consent_issues_2 ?? 'N/A' }}</p>
            </div>
            <div class = "w-1/5 border-r">
                <p class="text-xs mb-2">{{ $form3b->indicate_consent_related ?? 'N/A' }}</p>
            </div>
            <div class = "w-1/5 border-r">
                <p class="text-xs mb-2"></p>
            </div>
            <div class = "px-2 w-1/6 border-r">
                <p class = "text-xs text-l mb-2">{{ $form3b->consent_related_page ?? 'N/A' }}</p>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-xs text-l mb-2">3. N/A</p>
                <p class = "text-xs text-l mb-2"></p>
            </div>
        </div>
        <div class ="flex items-stretch border-t">
            <div class = "px-2 w-3/5 border-r">
                <p class = "text-xs text-l mb-2">4. Changes that were not part of the initial review:</p>
                <p class = "text-xs text-l mb-2">{{ $form3b->review_changes_1 ?? 'N/A' }}</p>
                <p class = "text-xs text-l mb-2">{{ $form3b->review_changes_2 ?? 'N/A' }}</p>
            </div>
            <div class = "w-1/5 border-r">
                <p class="text-xs mb-2">{{ $form3b->indicate_review_changes ?? 'N/A' }}</p>
            </div>
            <div class = "w-1/5 border-r">
                <p class="text-xs mb-2"></p>
            </div>
            <div class = "px-2 w-1/6 border-r">
                <p class = "text-xs text-l mb-2">{{ $form3b->review_changes_page ?? 'N/A' }}</p>
            </div>
            <div class = "px-2 w-1/2">
                <p class = "text-xs text-l mb-2">4. N/A</p>
                <p class = "text-xs text-l mb-2"></p>
            </div>
        </div>
        <div class = "w-full pb-4 border-t">
            <p class = "text-xs text-L m-1">PI Signature: {{ $principalInvestigator }}</p>
        </div>
        <div class ="flex items-stretch border-t">
            <div class = "flex flex-col items-start px-2">
                <p class = "text-xs font-bold text-l mb-2">RECOMMENDATION OF PRIMARY REVIEWER:</p>
                <div class = "flex items-center mb-1">
                    <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                    </div>
                    <span class="text-xs ml-2">APPROVE</span>
                </div>
                <div class = "flex items-center mb-1">
                    <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                    </div>
                    <span class = "text-xs ml-2">MINOR MODIFICATION</span>
                </div>
                <div class = "flex items-center mb-1">
                    <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                    </div>
                    <span class="text-xs ml-2">MAJOR MODIFICATION</span>
                </div>
                <div class = "flex items-center mb-1">
                    <div class="w-4 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                    </div>
                    <span class="text-xs ml-2">DISAPPROVE</span>
                </div>
                <div class = "flex items-center mb-1">
                    <div class="w-5 h-4 border border-black flex items-center justify-center text-[10px] leading-none">
                    </div>
                    <span class="text-xs ml-2">PENDING, IF MAJOR CLARIFICATIONS ARE REQUIRED BEFORE A DECISION CAN BE MADE</span>
                </div>
            </div>
            <div class = "px-2 w-2/3 flex border-l">
                <p class = "text-xs font-bold text-l mb-2">JUSTIFICATION FOR RECOMMENDED ACTION:</p>
                <p class = "text-xs text-l mb-2"></p>
            </div>
        </div>
        <div class = "w-full border-t">
            <p class = "text-xs text-l m-1">Summary of Recommendations:</p>
            <p class = "text-xs text-l mb-2"></p>
        </div>
    </div>

    <div class = "page-break"></div>

    <div class = "flex flex-col border">
        <div class ="flex items-stretch">
            <div class = "px-2 w-1/4 border-r">
                <p class = "text-xs font-bold text-l m-1">ERB CHAIR</p>
            </div>
            <p class = "text-xs text-l pt-6 m-1">Signature</p>
        </div>
    </div>
    
    <p class = "text-xs font-bold text-l mt-4 mb-2">Signature of Researcher: ______________________</p>
    <p class = "text-xs font-bold text-l mt-4 mb-2">Date: _____________</p>
    <p class = "text-xs font-bold text-l mt-4 mb-2">Noted by the adviser: ______________________</p>
    <p class = "text-xs font-bold text-l mt-4 mb-2">Approved by the Research Coordinator: ______________________</p>
</body>
</html>