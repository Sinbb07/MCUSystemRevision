@section('title', 'Submit Documents')
<x-student-layout>
    <!-- Main Content -->
    <main class="xl:ml-[335px] max-xl:ml-auto p-4">
        <h2 class="max-xl:hidden text-left bg-[#f2f2f2] shadow-lg p-[35px] rounded-[30px] font-medium text-[28px]">
            SUBMIT DOCUMENTS
        </h2>
        <br>
        <div class="p-6 max-md:p-0 space-y-10">
            
            <!-- Deficiencies Section -->
            <div class="my-4">
                <h2 class="mb-4 font-semibold text-[20px]">Deficiencies</h2>
                @forelse($submissionForms as $form)
                    @if(!$form->is_submitted)
                    <div class="bg-red-200 hover:bg-red-300 my-3 p-4 rounded-lg duration-200">
                        <div class="flex justify-between items-center">
                            <div class="block items-center flex-wrap gap-[10px]">
                                <h2 class="text-lg text-red-900 max-sm:text-base font-semibold">{{ $form->form_code }}</h2>
                                <p class="text-sm max-sm:text-xs text-red-900">Due at {{ \Carbon\Carbon::parse($form->due_date ?? now()->addDays(7))->format('m/d/Y') }}</p>
                                <label class="mt-1 text-sm max-sm:text-xs text-red-900">{{ $form->form_name }}</label>
                            </div>
                            <div>
                                <input type="file" name="uploadForms[]" id="upload-{{ $form->form_id }}" accept=".doc,.docx,.pdf" multiple hidden>
                                <label for="upload-{{ $form->form_id }}" class="flex flex-col items-center justify-center p-2 rounded-lg transition cursor-pointer">
                                    <i class="bi bi-cloud-arrow-up-fill text-blue-600 text-3xl max-md:text-xl"></i>
                                </label>
                            </div>
                        </div>
                        <div id="toggleExpand-{{ $form->form_id }}" class="hidden mt-5 transition-all duration-300">
                            <h3 class="text-lg font-semibold mb-2 text-gray-700">Uploaded Files</h3>
                            <div id="scrollbar-{{ $form->form_id }}" class="bg-gray-50 h-64 px-3 border-2 border-blue-300 rounded-lg overflow-y-auto">
                                <!-- Uploaded files go here -->
                            </div>
                            <div>
                                <form action="{{ route('student.submit.form.store', ['form' => $form->form_id]) }}" method="POST" enctype="multipart/form-data" id="form-{{ $form->form_id }}">
                                    @csrf
                                    <x-primary-button class="mt-4" type="submit">
                                        Submit
                                    </x-primary-button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                @empty
                    <p class="text-sm text-gray-600">No assigned forms to submit.</p>
                @endforelse
            </div>

            <!-- Completed Section -->
            <div class="my-4">
                <h2 class="mb-4 font-semibold text-[20px]">Completed</h2>
                @forelse($submissionForms as $form)
                    @if($form->is_submitted)
                    <a href="{{ route('student.submit.form', ['form' => $form->form_id]) }}">
                        <div class="bg-green-200 hover:bg-green-300 my-3 p-4 rounded-lg flex justify-between items-center duration-200">
                            <div class="block items-center flex-wrap gap-[10px]">
                                <h2 class="text-lg text-green-900 max-sm:text-base font-semibold">{{ $form->form_code }}</h2>
                                <p class="text-sm max-sm:text-xs text-green-900">Submitted on {{ \Carbon\Carbon::parse($form->submitted_at)->format('m/d/Y') }}</p>
                                <label class="mt-1 text-sm max-sm:text-xs text-green-900">{{ $form->form_name }}</label>
                            </div>
                        </div>
                    </a>
                    @endif
                @empty
                    <p class="text-sm text-gray-600">No completed forms yet.</p>
                @endforelse
            </div>
        </div>
    </main>
</x-student-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // File upload change event
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function(e) {
            const formId = this.id.replace('upload-', '');
            const filesContainer = document.getElementById(`scrollbar-${formId}`);
            const toggleExpand = document.getElementById(`toggleExpand-${formId}`);
            const form = document.getElementById(`form-${formId}`);
            
            // Clear previous files display
            filesContainer.innerHTML = '';
            
            // Show the expandable section
            toggleExpand.classList.remove('hidden');
            
            // Create hidden input fields for each file in the form
            if (this.files.length > 0) {
                Array.from(this.files).forEach((file, index) => {
                    showFileBox(file.name, formId);
                });
                
                // Move the file input into the form
                form.appendChild(this.cloneNode(true));
                // Replace the original file input with a new one for new selections
                const newInput = this.cloneNode(true);
                this.parentNode.replaceChild(newInput, this);
                newInput.addEventListener('change', arguments.callee);
            }
        });
    });

    // File display function
    const showFileBox = (filename, formId) => {
        const scrollbar = document.getElementById(`scrollbar-${formId}`);
        const fileBox = document.createElement("div");
        fileBox.classList.add(
            "relative", "items-center", "px-3", "py-1", "rounded-md", "shadow-md", "bg-lightgray", "border", "border-darkgray", "shadow-sm", "my-2", "overflow-hidden", "hover:shadow-md", "transition"
        );

        const inner = document.createElement("div");
        inner.classList.add("flex", "items-center", "justify-between");

        // Left (icon + filename)
        const left = document.createElement("div");
        left.classList.add("flex", "items-center", "space-x-2");

        const name = document.createElement("span");
        name.textContent = filename;
        name.classList.add("text-gray-700", "truncate", "max-w-[250px]");

        left.append(name);

        // Right (delete button)
        const right = document.createElement("span");
        right.innerHTML = "&times;";
        right.classList.add("text-gray-400", "hover:text-red-500", "cursor-pointer", "text-xl");

        right.addEventListener("click", () => {
            fileBox.remove();
            if (scrollbar.children.length === 0) {
                document.getElementById(`toggleExpand-${formId}`).classList.add("hidden");
            }
        });

        inner.append(left, right);
        fileBox.append(inner);

        // Smooth progress bar
        const progressBar = document.createElement("div");
        progressBar.classList.add(
            "absolute", "bottom-0", "left-0", "h-[3px]", "bg-blue"
        );
        progressBar.style.width = "0%";
        progressBar.style.transition = "width 3s linear";

        fileBox.append(progressBar);
        scrollbar.append(fileBox);

        // Animate smoothly to 100%
        setTimeout(() => {
            progressBar.style.width = "100%";
        }, 100);

        // Instantly stop transition & color change when done
        setTimeout(() => {
            progressBar.style.transition = "none";
            progressBar.classList.replace("bg-blue", "bg-white");
        }, 3000);
    };
});
</script>