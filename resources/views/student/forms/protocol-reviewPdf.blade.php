<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>IACUC-PROTOCOL-REVIEW-FORM</title>
    @vite('resources/css/app.css') {{-- Tailwind --}}
    <style>
        .page-break {
            break-before: page;
        }
    </style>
</head>

<body class="font-cambria">
    <x-iacucformbanner2>IACUC PROTOCOL REVIEW FORM</x-iacucformbanner2>

    <div class="mt-2 mx-10">
        <div class="flex text-sm font-bold">
            <div>
                PROTOCOL NO.
                <p class="w-56 border-r">{{ $protocol->protocol_ID ?? 'N/A' }}</p>
            </div>
            <div>
                Date received: {{ now()->format('m/d/Y') }}
            </div>
        </div>

        <!-- TANGGALIN NALANG TO KUNG HNDI NA KELANGAN ISAMA HAHAHA -->
        <div class="text-sm">
            <div class="mt-3 flex">
                <p>
                    1.
                </p>
                <p class="mx-3">
                    Fill out this form carefully and completely. Use separate sheets if necessary.
                </p>
            </div>
            <div class="mt-2 flex">
                <p>
                    2.
                </p>
                <p class="mx-3">
                    Attach a copy of the final protocol signed by researcher/s and faculty advisor, for student
                    researcher/s.
                </p>
            </div>
            <div class="mt-2 flex">
                <p>
                    3.
                </p>
                <p class="mx-3">
                    Attach proof of qualification to conduct research/procedures using animals (see section I).
                </p>
            </div>
            <div class="mt-2 flex">
                <p>
                    4.
                </p>
                <p class="mx-3">
                    Only Protocol Review Forms submitted with complete requirements will be processed
                </p>
            </div>
        </div>

        <div class="mt-3 border">
            <!-- I. PROCEDURE(S) OR TITLE OF RESEARCH STUDY -->
            <div>
                <div class="mx-1 flex">
                    <p class="font-bold">
                        I.
                    </p>
                    <p class="ml-5 font-bold">
                        PROCEDURE(S) or TITLE OF RESEARCH STUDY:
                    </p>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-9">{{ $formData->study_title ?? '' }}</p>
                </div>
            </div>

            <!-- II. PURPOSE/OBJECTIVE -->
            <div class="border-t">
                <div class="mx-1 flex">
                    <p class="font-bold">
                        II.
                    </p>
                    <p class="ml-3.5 font-bold">
                        PURPOSE/OBJECTIVE/S:
                    </p>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-9">{{ $formData->scientific_merit_comment ?? '' }}</p>
                </div>
            </div>

            <!-- III. DURATION OR TIMEFRAME -->
            <div class="border-t">
                <div class="mx-1 flex">
                    <p class="font-bold">
                        III.
                    </p>
                    <p class="ml-2 font-bold">
                        DURATION or TIMEFRAME:
                    </p>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-9">{{ $formData->overview_section_comment ?? '' }}</p>
                </div>
            </div>

            <!-- IV. RESPONSIBLE PERSON OR PRINCIPAL INVESTIGATOR -->
            <div class="border-t">
                <div class="mx-1 flex">
                    <p class="font-bold">
                        IV.
                    </p>
                    <p class="ml-3 font-bold">
                        RESPONSIBLE PERSON or PRINCIPAL INVESTIGATOR:
                    </p>
                </div>
            </div>

            <!-- A. NAME -->
            <div class="border-t">
                <div class="mx-1 ml-6 flex">
                    <p class="font-bold">
                        A.
                    </p>
                    <p class="ml-2">
                        Name:
                    </p>
                    <p class="mt-0.5 ml-2 text-sm">{{ $formData->pi_person ?? $principalInvestigator ?? '' }}</p>
                </div>
            </div>

            <!-- B. QUALIFICATION -->
            <div class="border-t">
                <div class="mx-1 ml-6 flex">
                    <p class="font-bold">
                        B.
                    </p>
                    <p class="ml-2">
                        Qualification:
                    <p class="ml-2 mt-1 italic text-xs">
                        (degree/s or training experience)
                    </p>
                    </p>
                </div>
                <div class="pl-12 h-auto text-sm p-2">
                    <p>{{ $formData->training_experience_comment ?? '' }}</p>
                </div>
            </div>

            <!-- V. BACKGROUND AND SIGNIFICANCE OF THE PROCEDURE OR RESEARCH -->
            <div class="border-t">
                <div class="mx-1 flex">
                    <p class="font-bold">
                        V.
                    </p>
                    <div class="block my-0">
                        <p class="ml-4 font-bold">
                            BACKGROUND and SIGNIFICANCE OF THE PROCEDURE or RESEARCH:
                        </p>
                        <p class="ml-4 italic text-xs">
                            (Include a description of the biomedical characteristics of the animals which are essential
                            to
                            the proposed procedure/research and indicate the evidence of experiences with the proposed
                            model).
                        </p>
                    </div>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-9">{{ $formData->rational_justification_comment ?? '' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Page 2 -->
    <div class="page-break"></div>

    <div class="mt-2 mx-10">
        <div class="mt-3 border">
            <!-- VI. DESCRIPTION OF METHODOLOGIES/EXPERIMENTAL DESIGN -->
            <div>
                <div class="mx-1 flex">
                    <p class="font-bold">
                        VI.
                    </p>
                    <div class="block my-0">
                        <p class="ml-3 font-bold">
                            DESCRIPTION of METHODOLOGIES/EXPERIMENTAL DESIGN:
                        </p>
                        <p class="ml-3 italic text-xs">
                            (This section should establish that the proposed procedure/research are well designed
                            scientifically and ethically. The following should be indicated or described).
                        </p>
                    </div>
                </div>
            </div>

            <!-- A. TYPE OF ANIMAL TO BE USED -->
            <div class="border-t">
                <div class="mx-1 ml-6 flex">
                    <p class="font-bold">
                        A.
                    </p>
                    <p class="ml-2">
                        Type of animal to be used
                    </p>
                    <p class="mt-0.5 ml-1 text-sm">
                        (species)
                    </p>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-12">{{ $formData->animal_species ?? '' }}</p>
                </div>
            </div>

            <!-- B. SOURCE OF ANIMALS -->
            <div class="border-t">
                <div class="mx-1 ml-6 flex">
                    <p class="font-bold">
                        B.
                    </p>
                    <p class="ml-2">
                        Source of animals:
                    </p>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-12">{{ $formData->animal_source ?? '' }}</p>
                </div>
            </div>

            <!-- C. REASON/BASIS FOR SELECTING THE ANIMAL SPECIES -->
            <div class="border-t">
                <div class="mx-1 ml-6 flex">
                    <p class="font-bold">
                        C.
                    </p>
                    <p class="ml-2">
                        Reason/basis for selecting the animal species:
                    </p>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-12">{{ $formData->adequate_justification_comment ?? '' }}</p>
                </div>
            </div>

            <!-- D. SEX AND NUMBER OF ANIMAL -->
            <div class="border-t">
                <div class="mx-1 ml-6 flex">
                    <p class="font-bold">
                        D.
                    </p>
                    <p class="ml-2">
                        Sex and number of animals
                    </p>
                    <p class="mt-0.5 ml-1 text-sm italic">
                        (justify the number of animals):
                    </p>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-12">{{ $formData->unnecessary_duplication_comment ?? '' }}</p>
                </div>
            </div>

            <!-- E. QUARANTINE AND ACCLIMATION OR CONDITIONING PROCESS -->
            <div class="border-t">
                <div class="mx-1 ml-6 flex">
                    <p class="font-bold">
                        E.
                    </p>
                    <p class="ml-2">
                        Quarantine and acclimation or conditioning process:
                    </p>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-12">{{ $formData->endpoint_duration_comment ?? '' }}</p>
                </div>
            </div>

            <!-- F. ANIMAL CARE PROCEDURES -->
            <div class="border-t">
                <div class="mx-1 ml-6 flex">
                    <p class="font-bold">
                        F.
                    </p>
                    <p class="ml-2">
                        Animal care procedures
                    </p>
                </div>
            </div>

            <!-- 1. CAGE TYPE AND BINDINGS -->
            <div class="border-t">
                <div class="mx-1 ml-9 flex">
                    <p class="font-bold">
                        1.
                    </p>
                    <p class="ml-2">
                        Cage type and beddings
                    </p>
                    <p class="mt-0.5 ml-1 text-sm italic">
                        (if applicable):
                    </p>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-14">{{ $formData->pain_category_comment ?? '' }}</p>
                </div>
            </div>

            <!-- 2. NUMBER OF ANIMAL PER CAGE -->
            <div class="border-t">
                <div class="mx-1 ml-9 flex">
                    <p class="font-bold">
                        2.
                    </p>
                    <p class="ml-2">
                        Number of animal per cage
                    </p>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-14">{{ $formData->number_cage ?? '' }}</p>
                </div>
            </div>

            <!-- 3. CAGE CLEANING/DISINFECTION METHOD AND FREQUENCY -->
            <div class="border-t">
                <div class="mx-1 ml-9 flex">
                    <p class="font-bold">
                        3.
                    </p>
                    <p class="ml-2">
                        Cage cleaning/disinfection method and frequency
                    </p>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-14">{{ $formData->alternative_housing_comment ?? '' }}</p>
                </div>
            </div>

            <!-- 4. ROOM TEMPERATURE, HUMIDITY, VENTILATION, AND LIGHTING -->
            <div class="border-t">
                <div class="mx-1 ml-9 flex">
                    <p class="font-bold">
                        4.
                    </p>
                    <p class="ml-2">
                        Room temperature, humidity, ventilation, and lighting
                    </p>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-14">{{ $formData->hazardous_material_comment ?? '' }}</p>
                </div>
            </div>

            <!-- 5. ANIMAL DIET AND FEEDING AND WATERING METHOD -->
            <div class="border-t">
                <div class="mx-1 ml-9 flex">
                    <p class="font-bold">
                        5.
                    </p>
                    <p class="ml-2">
                        Animal diet and feeding and watering method
                    </p>
                    <p class="mt-0.5 ml-1 text-sm italic">
                        (include amount and frequency):
                    </p>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-14">{{ $formData->multiple_survival_comment ?? '' }}</p>
                </div>
            </div>

            <!-- G. EXPERIMENTAL OR ANIMAL MANIPULATION METHOD -->
            <div class="border-t">
                <div class="mx-1 ml-6 flex">
                    <p class="font-bold">
                        G.
                    </p>
                    <p class="ml-2">
                        Experimental or animal manipulation method:
                    </p>
                </div>
            </div>

            <!-- 1. GENERAL DESCRIPTION OF ANIMAL MANIPULATION METHODS -->
            <div class="border-t">
                <div class="mx-1 ml-9 flex">
                    <p class="font-bold">
                        1.
                    </p>
                    <p class="ml-2">
                        General description of animal manipulation methods
                    </p>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-12">{{ $formData->experimental_procedures_comment ?? '' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Page 3 -->
    <div class="page-break"></div>

    <div class="mt-2 mx-10">
        <div class="mt-3 border">
            <div>
                <div class="mx-1 ml-6 flex">
                    <p class="font-bold">
                        G.
                    </p>
                    <p class="ml-2">
                        Experimental or animal manipulation method:
                    </p>
                </div>
            </div>

            <!-- 2. DOSING METHOD -->
            <div class="border-t">
                <div class="mx-1 ml-9 flex">
                    <p class="font-bold">
                        2.
                    </p>
                    <div class="block my-0">
                        <p class="ml-2">
                            Dosing method
                        </p>
                        <p class="ml-2 italic text-sm">
                            (include frequency, volume, route, restraint method and expected outcome of effects):
                        </p>
                    </div>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-12">{{ $formData->pain_relief_comment ?? '' }}</p>
                </div>
            </div>

            <!-- 3. SPECIMEN OR BIOLOGICAL AGENT -->
            <div class="border-t">
                <div class="mx-1 ml-9 flex">
                    <p class="font-bold">
                        3.
                    </p>
                    <div class="block my-0">
                        <p class="ml-2">
                            Specimen or biological agent (blood, urine, etc.) collection method
                        </p>
                        <p class="ml-2 italic text-sm">
                            (include frequency, volume, route and method of restraint):
                        </p>
                    </div>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-12">{{ $formData->ill_debilitated_comment ?? '' }}</p>
                </div>
            </div>

            <!-- 4. ANIMAL EXAMINATION PROCESS AND FREQUENCY OF EXAMINATIONS -->
            <div class="border-t">
                <div class="mx-1 ml-9 flex">
                    <p class="font-bold">
                        4.
                    </p>
                    <div class="block my-0">
                        <p class="ml-2">
                            Animal examination process and frequency of examinations
                        </p>
                        <p class="ml-2 italic text-sm">
                            (include restraining method):
                        </p>
                    </div>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-12">{{ $formData->complications_comment ?? '' }}</p>
                </div>
            </div>

            <!-- 5. USE OF ANESTHETICS -->
            <div class="border-t">
                <div class="mx-1 ml-9 flex">
                    <p class="font-bold">
                        5.
                    </p>
                    <div class="block my-0">
                        <p class="ml-2">
                            Use of anesthetics
                        </p>
                        <p class="ml-2 italic text-sm">
                            (include drug, dosage, frequency, and route of administration)
                        </p>
                    </div>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-12">{{ $formData->use_anesthetics ?? '' }}</p>
                </div>
            </div>

            <!-- 6. SURGICAL PROCEDURE -->
            <div class="border-t">
                <div class="mx-1 ml-9 flex">
                    <p class="font-bold">
                        6.
                    </p>
                    <div class="block my-0">
                        <p class="ml-2">
                            Surgical procedure
                        </p>
                        <p class="ml-2 italic text-sm">
                            (type and purpose)
                        </p>
                    </div>
                </div>
            </div>

            <!-- 6A. WHERE WILL SURGERY BE PERFORMED -->
            <div class="border-t">
                <div class="mx-1 ml-12 flex">
                    <p class="font-bold">
                        6a.
                    </p>
                    <p class="ml-2">
                        Where will surgery be performed?
                    </p>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-15">{{ $formData->veterinary_complications_comment ?? '' }}</p>
                </div>
            </div>

            <!-- 6B. DESCRIPTION OF SUPPORTIVE CARE AND MONITORING PROCEDURES DURING AND AFTER SURGERY -->
            <div class="border-t">
                <div class="mx-1 ml-12 flex">
                    <p class="font-bold">
                        6b.
                    </p>
                    <p class="ml-2">
                        Description of supportive care and monitoring procedures during and after surgery
                    </p>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-15">{{ $formData->proposed_anesthesia_comment ?? '' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Page 4 -->
    <div class="page-break"></div>

    <div class="mt-2 mx-10">
        <div class="mt-3 border">
            <div>
                <div class="mx-1 ml-9 flex">
                    <p class="font-bold">
                        6.
                    </p>
                    <div class="block my-0">
                        <p class="ml-2">
                            Surgical procedure
                        </p>
                        <p class="ml-2 italic text-sm">
                            (type and purpose)
                        </p>
                    </div>
                </div>
            </div>

            <!-- 6C. DESCRIPTION OF MEASURES FOR POSSIBLE POST-SURGICAL COMPLICATIONS -->
            <div class="border-t">
                <div class="mx-1 ml-12 flex">
                    <p class="font-bold">
                        6c.
                    </p>
                    <p class="ml-2">
                        Description of measures for possible post-surgical complications
                    </p>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-15">{{ $formData->post_procedural_comment ?? '' }}</p>
                </div>
            </div>

            <!-- 6D. NAME(S) OF SURGEON(S), THEIR QUALIFICATIONS, AND RELEVANT EXPERIENCES -->
            <div class="border-t">
                <div class="mx-1 ml-12 flex">
                    <p class="font-bold">
                        6d.
                    </p>
                    <p class="ml-2">
                        Name(s) of surgeon(s), their qualifications, and relevant experiences
                    </p>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-15">{{ $formData->appropriate_method_comment ?? '' }}</p>
                </div>
            </div>

            <!-- 7. IF EUTHANASIA OF ANIMALS WILL BE DONE, INDICATE/DESCRIBE THE METHOD SELECTED -->
            <div class="border-t">
                <div class="mx-1 ml-9 flex">
                    <p class="font-bold">
                        7.
                    </p>
                    <p class="ml-2">
                        If euthanasia of animals will be done, indicate/describe the method selected
                    </p>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-12">{{ $formData->euthanasia_method_comment ?? '' }}</p>
                </div>
            </div>

            <!-- H. NON-ANIMAL MODEL APPLICABLE FOR THE PROCEDURE/STUDY -->
            <div class="border-t">
                <div class="mx-1 ml-6 flex">
                    <p class="font-bold">
                        H.
                    </p>
                    <p class="ml-2">
                        Is there a non-animal model applicable for the procedure/study? If so, please provide the reason
                        for not using it
                    </p>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-9">{{ $formData->summary_comments ?? '' }}</p>
                </div>
            </div>

            <!-- I. INDICATE THE NAMES AND QUALIFICATION OF ALL PERSONNEL -->
            <div class="border-t">
                <div class="mx-1 ml-6 flex">
                    <p class="font-bold">
                        I.
                    </p>
                    <div class="block my-0">
                        <p class="ml-2">
                            Indicate the names and qualification of all personnel who will be responsible for conducting
                            the procedures
                        </p>
                        <p class="ml-2 italic text-sm">
                            (attach proof of qualification such as certificate of training, etc.)
                        </p>
                    </div>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-9">{{ $formData->personnel_names ?? '' }}</p>
                </div>
            </div>

            <!-- J. POST-EXPERIMENTAL PROCEDURES -->
            <div class="border-t">
                <div class="mx-1 ml-6 flex">
                    <p class="font-bold">
                        J.
                    </p>
                    <p class="ml-2">
                        Post-experimental procedures (if any) especially if physical manipulation like surgical
                        procedures will be done or if the animal will be euthanized, please indicate the method of
                        carcass disposal
                    </p>
                </div>
                <div class="h-auto text-sm p-2">
                    <p class="pl-9">{{ $formData->post_experimental ?? '' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Page 5 -->
    <div class="page-break"></div>

    <div class="mt-2 mx-10">
        <div class="mt-3 border">
            <div>
                <div class="mx-1 flex">
                    <p class="font-bold">
                        VII.
                    </p>
                    <p class="ml-1 font-bold">
                        BACKGROUND and SIGNIFICANCE OF THE PROCEDURE or RESEARCH:
                    </p>
                </div>
                <div class="text-sm">
                    <p class="pl-9 uppercase">
                        I accept responsibility for assuring that the procedures/study will be conducted in accordance
                        with the approved protocol. <br><br>

                        I assure that all personnel who will use this protocol and work with animals have received
                        appropriate training/instructions in procedural and handling techniques, and on animal welfare
                        considerations. <br><br>

                        I agree to obtain written approval from the institutional animal care and use of committee
                        (IACUC) prior to making any changes affecting my protocol. I also agree promptly notify the
                        IACUC in writing of any emergent problems that may arise in the course of study, including the
                        occurrence of adverse side effects. <br><br>
                    </p>
                    <!-- RESPONSIBLE PERSON NAME & SIGNATURE -->
                    <div class="mt-10 pl-9">
                        <div class="flex">
                            <div>
                                <p class="border-b-2">{{ $formData->pi_person ?? $principalInvestigator ?? '' }}</p>
                                <p class="flex items-center">
                                    Responsible Person Name & Signature
                                </p>
                            </div>
                            <div class="ml-24 flex">
                                <p>Date</p>
                                <p class="border border-t-0 border-l-0 border-r-0 border-b-2 h-4 ml-2 w-28">{{ now()->format('m/d/Y') }}</p>
                            </div>
                        </div>
                    </div>
                    <p class="pl-9 mt-10 font-bold underline">
                        ASSURANCE OF THE FACULTY ADVISOR (required if the Resp. Person is a student):
                    </p>
                    <p class="pl-9 mt-8 uppercase">
                        This is to certify that i have reviewed the protocol and that i attest to the scientific merit
                        of this study and the competency of the investigator(s) to conduct the project. I assure that
                        the investigator(s) is/are knowledgeable about the regulations and policies governing the use of
                        animals in research. I agree to meet with the investigator(s) on a regular basis to monitor
                        study progress and compliance with the iacuc approved protocol.
                    </p>
                    
                    <!-- FACULTY ADVISOR NAME -->
                    <div class="mt-10 pl-9">
                        <div class="flex">
                            <div>
                                <p class="border-b-2">{{ $formData->adviser ?? '' }}</p>
                                <p class="flex items-center">
                                    Faculty Advisor Name & Signature
                                </p>
                            </div>
                            <div class="ml-28 flex">
                                <p>Date</p>
                                <p class="border border-t-0 border-l-0 border-r-0 border-b-2 h-4 ml-2 w-28">{{ now()->format('m/d/Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <p class="pl-4 mt-10 font-bold">
                        Noted by:
                    </p>
                    <div class="mt-8 pl-9 pb-4">
                        <div class="flex">
                            <div>
                                <p class="border-b-2"></p>
                                <p class="flex items-center">
                                    Research Coordinator Name & Signature
                                </p>
                            </div>
                            <div class="ml-28 flex">
                                <p>Date</p>
                                <p class="border border-t-0 border-l-0 border-r-0 border-b-2 h-4 ml-2 w-28"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>