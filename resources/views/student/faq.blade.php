<!-- MODAL FORM -->
<div id="faqModal" class="fixed inset-0 z-50 hidden bg-black/60 items-center justify-center opacity-0">
    <div id="modalBox" class="bg-white w-full max-w-md rounded-lg p-6 relative h-[500px]">
        <!-- CLOSE BUTTON -->
        <div class="flex align-center justify-between mb-5">
            <h2 class="text-xl font-semibold">Frequently Asked Questions</h2>
            <button onclick="closeFaqModal()" class="text-2xl text-gray-500 hover:text-black">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-x-icon lucide-x">
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                </svg>
            </button>
        </div>
        <!-- MODAL FORM MAIN CONTENT SCROLLABLE -->
        <div class="h-[400px] overflow-y-auto overflow-x-hidden">
            <div class="space-y-2">
                <details class="group border rounded">
                    <summary class="cursor-pointer px-4 py-3 font-medium bg-gray-100 flex justify-between items-center">
                        Item #1
                        <span class="transition-transform duration-300 group-open:rotate-180">
                            &#11167;
                        </span>
                    </summary>
                    <div class="overflow-hidden px-4 py-3 text-gray-700 border-t">
                        First content.
                    </div>
                </details>
                <details class="group border rounded">
                    <summary class="cursor-pointer px-4 py-3 font-medium bg-gray-100 flex justify-between items-center">
                        Item #2
                        <span class="transition-transform duration-300 group-open:rotate-180">
                            &#11167;
                        </span>
                    </summary>
                    <div class="overflow-hidden px-4 py-3 text-gray-700 border-t">
                        Second content.
                    </div>
                </details>
                <details class="group border rounded">
                    <summary class="cursor-pointer px-4 py-3 font-medium bg-gray-100 flex justify-between items-center">
                        Item #3
                        <span class="transition-transform duration-300 group-open:rotate-180">
                            &#11167;
                        </span>
                    </summary>
                    <div class="overflow-hidden px-4 py-3 text-gray-700 border-t">
                        Third content.
                    </div>
                </details>
                <details class="group border rounded">
                    <summary class="cursor-pointer px-4 py-3 font-medium bg-gray-100 flex justify-between items-center">
                        Item #4
                        <span class="transition-transform duration-300 group-open:rotate-180">
                            &#11167;
                        </span>
                    </summary>
                    <div class="overflow-hidden px-4 py-3 text-gray-700 border-t">
                        Fourth content.
                    </div>
                </details>
                <details class="group border rounded">
                    <summary class="cursor-pointer px-4 py-3 font-medium bg-gray-100 flex justify-between items-center">
                        Item #5
                        <span class="transition-transform duration-300 group-open:rotate-180">
                            &#11167;
                        </span>
                    </summary>
                    <div class="overflow-hidden px-4 py-3 text-gray-700 border-t">
                        Fifth content.
                    </div>
                </details>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('faqModal');
    const modalBox = document.getElementById('modalBox');
    const button = document.getElementById('faqButton');

    function closeAllDetails() {
        document.querySelectorAll('#faqModal details[open]').forEach(d => {
            d.removeAttribute('open');
        });
    }

    function openFaqModal() {
        closeAllDetails()

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        requestAnimationFrame(() => {
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');
        });

        button.classList.add('hidden');
    }

    function closeFaqModal() {
        modal.classList.add('opacity-0');
        modal.classList.remove('opacity-100');

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);

        button.classList.remove('hidden');
    }

    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeFaqModal();
    });
</script>