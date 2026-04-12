@section('title', 'Submitted Documents')
<x-iacuc-layout>
    <main class="xl:ml-[335px] max-xl:ml-auto p-4 max-md:p-2">
        <h2 class="max-xl:hidden text-left bg-[#f2f2f2] shadow-lg p-[35px] rounded-[30px] font-medium text-[28px]">
            SUBMITTED DOCUMENTS
        </h2>
        <div class="w-full mx-auto my-8 px-4 py-6 bg-white rounded-lg border-2 border-gray">
            <h1 class="text-primary text-2xl max-md:text-base font-semibold mb-4">Submission Details</h1>
            <h2 class="text-primary text-xl max-md:text-base font-medium">
                User: <span class="text-blue-600">{{ $piFiles->user_Fname }}</span>
            </h2>

            <div class="max-sm:text-sm mt-6 space-y-4 h-64 overflow-y-auto">
                @forelse($piFiles->researchFiles as $file)
                    <div class="p-3 border border-darkgray bg-lightgray flex justify-between items-center rounded-lg" data-file-id="{{ $file->id }}">
                        <div class="flex-1">
                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="block hover:bg-gray-50 p-2 rounded">
                                <h3 class="font-medium text-lg">Form: {{ $file->form?->form_name ?? 'N/A' }}</h3>
                                <p class="text-gray-700">Document: {{ $file->file_name }}</p>
                                <p class="text-sm">Submitted: {{ $file->submitted_at ?? 'N/A' }}</p>
                            </a>
                        </div>
                        <div class="right flex flex-col items-end space-y-2">
                            @if($file->status === 'active')
                            <form method="POST" action="{{ route('research-files.soft-delete', $file->id) }}" class="inline" onsubmit="return confirmDelete(this)">
                                @csrf
                                <div class="flex flex-col items-end space-y-2">
                                    <textarea 
                                        name="delete_reason" 
                                        placeholder="Reason for deletion (optional)"
                                        class="w-48 max-sm:w-36 text-sm p-2 border border-gray-300 rounded resize-none"
                                        rows="2"
                                    ></textarea>
                                    <button type="submit" 
                                            class="bg-red-500 hover:bg-red-600 text-white py-2 px-3 rounded duration-200 transition-colors">
                                        <i class="bi bi-trash3-fill text-xl max-sm:text-sm"></i>
                                    </button>
                                </div>
                            </form>
                            @else
                            <div class="flex flex-col items-end space-y-2">
                                <textarea 
                                    disabled
                                    placeholder="Document already deleted"
                                    class="w-48 max-sm:w-36 text-sm p-2 border border-gray-300 rounded resize-none bg-gray-100 text-gray-500"
                                    rows="2"
                                ></textarea>
                                <span class="bg-gray-400 text-white py-2 px-3 rounded cursor-not-allowed">
                                    <i class="bi bi-trash3-fill text-xl max-sm:text-sm"></i>
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-gray-500 text-lg">No submitted documents found.</p>
                        <p class="text-gray-400 text-sm mt-2">All documents will appear here once submitted.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-8">
            <a href="{{ url('/iacuc/research-records') }}"
                class="bg-secondary hover:bg-primary text-lg max-xl:text-base text-primary hover:text-secondary uppercase tracking-widest px-4 py-2 rounded-md duration-200 transition-colors">
                Back
            </a>
        </div>
    </main>

    <!-- Success/Error Message Toast -->
    @if(session('success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-opacity duration-300" id="toast">
            <div class="flex items-center">
                <i class="bi bi-check-circle-fill mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-opacity duration-300" id="toast">
            <div class="flex items-center">
                <i class="bi bi-exclamation-triangle-fill mr-2"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif
</x-iacuc-layout>

<script>
    // Auto-hide toast messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const toast = document.getElementById('toast');
        if (toast) {
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }
    });

    // Enhanced delete confirmation that shows the reason
    function confirmDelete(form) {
        const deleteReason = form.querySelector('textarea[name="delete_reason"]').value;
        
        let message = 'Are you sure you want to delete this document?';
        
        if (deleteReason.trim() !== '') {
            message += '\n\nReason: ' + deleteReason;
        } else {
            message += '\n\nNo reason provided.';
        }
        
        return confirm(message);
    }
</script>

<style>
    .transition-colors {
        transition: background-color 0.2s ease, color 0.2s ease;
    }
    
    .cursor-not-allowed {
        cursor: not-allowed;
    }
    
    .opacity-50 {
        opacity: 0.5;
    }
</style>