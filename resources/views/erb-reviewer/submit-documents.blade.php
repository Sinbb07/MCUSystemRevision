@section('title','Submit Documents')
<x-erb-reviewer>
    <main class="ml-[335px] max-xl:ml-auto p-4">
        <h2 class="max-xl:hidden text-left bg-[#f2f2f2] shadow-lg p-[35px] rounded-[30px] font-medium text-[28px]">
            SUBMIT DOCUMENTS
        </h2>
        <br>
        
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="p-6 max-md:p-0 space-y-10">

            {{-- Only display a single submission form --}}
            @if($formData ?? $form ?? null)
                @php $currentForm = $formData ?? $form; @endphp
                <div class="duration-200 my-4 p-4 max-sm:p-2 border rounded-lg shadow-sm">
                    
                    <h2 class="font-semibold text-2xl max-sm:text-[19px]">
                        {{ $currentForm->form_name }}
                    </h2>

                    <p class="max-md:text-[15px]">
                        @if($currentForm->due_date)
                            Due at {{ \Carbon\Carbon::parse($currentForm->due_date)->format('F d, Y h:i A') }}
                        @else
                            No deadline specified
                        @endif
                    </p>
                    <br>

                    @if($submittedFiles && $submittedFiles->count() > 0)
                        <div id="fileWrapper">
                            <h3 class="my-[30px] max-md:mb-3 text-[20px] max-md:text-[17px] font-bold">
                                Your Submitted Documents
                            </h3>
                            <div id="scrollbar" class="h-64 px-2 border-2 border-gray overflow-y-auto">
                                @foreach($submittedFiles as $file)
                                    <div class="flex justify-between items-center my-2 px-3 py-1 shadow-md bg-lightgray border border-darkgray">
                                        <span class="break-all">{{ $file->file_name }}</span>
                                        <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                            class="text-primary underline">View</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <p class="max-md:text-[15px]">Attach the files here</p>

                        <form action="{{ route('erb-reviewer.submit-documents.store', $currentForm->form_id) }}" 
                              method="POST" 
                              enctype="multipart/form-data"
                              onsubmit="return validateFiles();">
                            @csrf
                            <input type="hidden" name="protocol_id" value="{{ $protocolId ?? '' }}">

                            <div class="max-w-xs w-xs cursor-pointer">
                                <div>
                                    <input type="file" name="uploadForms[]" id="upload" accept=".doc,.docx,.pdf" multiple hidden>
                                    <label for="upload"
                                           class="w-full text-md min-h-[50px] flex-col justify-center items-center rounded cursor-pointer">
                                        <i class="bi bi-cloud-arrow-up-fill text-primary"></i>
                                        <span class="text-primary mx-1 max-md:text-[15px]">
                                            Click to upload file/s
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <div id="fileWrapper">
                                <h3 class="my-[30px] max-md:mb-3 text-[20px] max-md:text-[17px] font-bold">
                                    Uploaded Documents
                                    <label class="text-[16px] max-md:text-[13px]">
                                        (.docx, .doc, or .pdf)
                                    </label>
                                </h3>
                                <div id="scrollbar" class="h-64 px-2 border-2 border-gray overflow-y-auto"></div>
                            </div>

                            <div>
                                <x-primary-button class="mt-4">
                                    SUBMIT
                                </x-primary-button>
                            </div>
                        </form>
                    @endif

                </div>
            @else
                <div class="text-center p-8 bg-yellow-50 border border-yellow-200 rounded">
                    <p class="text-yellow-600">No form found for submission.</p>
                </div>
            @endif

        </div>
    </main>
</x-erb-reviewer>

<script>
window.addEventListener("load", () => {
    const input = document.getElementById('upload');
    const filewrapper = document.getElementById('scrollbar');

    if(input){
        input.addEventListener("change", (e) => {
            const files = e.target.files;
            for (let i = 0; i < files.length; i++) {
                fileshow(files[i].name);
            }
        });
    }

    const fileshow = (filename) => {
        const showfileboxElem = document.createElement("div");
        showfileboxElem.classList.add("flex", "justify-between", "items-center", "my-2", "px-3", "py-1", "shadow-md", "bg-lightgray", "border", "border-darkgray");

        const leftElem = document.createElement("span");
        leftElem.classList.add("break-all");
        leftElem.innerHTML = filename;

        const rightElem = document.createElement("span");
        rightElem.classList.add("cursor-pointer", "text-primary", "text-[25px]");
        rightElem.innerHTML = "&#215;";

        showfileboxElem.append(leftElem, rightElem);
        filewrapper.append(showfileboxElem);

        rightElem.addEventListener("click", () => {
            filewrapper.removeChild(showfileboxElem);
        });
    }
});

// Validation to block empty submission
function validateFiles(){
    const input = document.getElementById('upload');
    if(input && input.files.length === 0){
        alert("Please select at least one file before submitting.");
        return false;
    }
    return true;
}
</script>