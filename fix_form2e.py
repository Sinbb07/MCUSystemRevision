import re

with open(r'c:\laragon\www\mcusystem\resources\views\erb-reviewer\forms\form2e.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

# Fix all radio buttons to have values and checked attributes
fields = [
    'background_study', 'relevant_information', 'population', 'sample_size', 
    'manner', 'study_site', 'research_questions', 'conditions_characteristics',
    'characteristics', 'participant_vulnerability', 'special_vulnerability', 
    'special_measures', 'study_procedure', 'overall_procedures', 
    'anonymity_confidentiality', 'maintained', 'data_confidentiality', 
    'records_data', 'risks_likelihood', 'duration', 'techniques'
]

for field in fields:
    # Fix Yes radio buttons
    pattern1 = f'name="{field}">\n                                <span>Yes</span>'
    replacement1 = f'name="{field}" value="Yes"\n                                    {{{{ old(\'{field}\', $form2e->{field} ?? \'\') === \'Yes\' ? \'checked\' : \'\' }}}}\n                                >\n                                <span>Yes</span>'
    content = content.replace(pattern1, replacement1)
    
    # Fix No radio buttons  
    pattern2 = f'name="{field}">\n                                <span>No</span>'
    replacement2 = f'name="{field}" value="No"\n                                    {{{{ old(\'{field}\', $form2e->{field} ?? \'\') === \'No\' ? \'checked\' : \'\' }}}}\n                                >\n                                <span>No</span>'
    content = content.replace(pattern2, replacement2)

# Map textarea fields to their corresponding radio fields
textarea_mappings = {
    'adequate': 'background_study',
    'information_discuss': 'relevant_information',
    'population_define': 'population',
    'approx_size': 'sample_size',
    'participants_manner': 'manner',
    'site_identify': 'study_site',
    'appropriate_questions': 'research_questions',
    'apply_characteristics': 'conditions_characteristics',
    'characteristics_disqualify': 'characteristics',
    'involvement': 'participant_vulnerability',
    'vulnerability_evaluation': 'special_vulnerability',
    'indicate_measures': 'special_measures',
    'describe_procedure': 'study_procedure',
    'overall_procedure_describe': 'overall_procedures',
    'confidentiality_measures': 'anonymity_confidentiality',
    'describe_maintain': 'maintained',
    'preserve_data': 'data_confidentiality',
    'disposition_records': 'records_data',
    'minimize_maximize': 'risks_likelihood',
    'estimated_date': 'duration',
    'techniques_described': 'techniques',
}

# Fix textareas to populate with saved data
for textarea, _ in textarea_mappings.items():
    old_pattern = f'<textarea name="{textarea}" id="" placeholder="Comments"\n                            class="mt-1 w-full resize-none max-sm:text-sm"></textarea>'
    new_pattern = f'<textarea name="{textarea}" id="" placeholder="Comments"\n                            class="mt-1 w-full resize-none max-sm:text-sm">{{{{ old(\'{textarea}\', $form2e->{textarea} ?? \'\') }}}}</textarea>'
    content = content.replace(old_pattern, new_pattern)

# Fix summary recommendations textareas
for i in range(1, 5):
    old = f'<textarea name="summary_recommendation_{i}" id="" placeholder="Summary of Recommendations"\n                            class="mt-1 w-full resize-none max-sm:text-sm"></textarea>'
    new = f'<textarea name="summary_recommendation_{i}" id="" placeholder="Summary of Recommendations"\n                            class="mt-1 w-full resize-none max-sm:text-sm">{{{{ old(\'summary_recommendation_{i}\', $form2e->summary_recommendation_{i} ?? \'\') }}}}</textarea>'
    content = content.replace(old, new)

# Fix justification textarea
old_just = '<textarea name="justification" id="" placeholder="Summary of Recommendations"\n                            class="mt-1 w-full resize-none max-sm:text-sm"></textarea>'
new_just = '<textarea name="justification" id="" placeholder="Summary of Recommendations"\n                            class="mt-1 w-full resize-none max-sm:text-sm">{{ old(\'justification\', $form2e->justification ?? \'\') }}</textarea>'
content = content.replace(old_just, new_just)

with open(r'c:\laragon\www\mcusystem\resources\views\erb-reviewer\forms\form2e.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)

print('Form2E successfully fixed - all fields now populate with saved data')
