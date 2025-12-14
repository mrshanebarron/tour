<div>
    @if($active && $this->getCurrentStep())
        @php $step = $this->getCurrentStep(); @endphp
        
        <div
            x-data="{
                init() {
                    this.highlight();
                },
                highlight() {
                    const target = document.querySelector('{{ $step['target'] ?? '' }}');
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        target.style.position = 'relative';
                        target.style.zIndex = '1001';
                    }
                }
            }"
            class="fixed inset-0 z-[1000]"
        >
            <!-- Overlay -->
            <div class="absolute inset-0" style="background: {{ $overlayColor }}"></div>

            <!-- Tooltip -->
            <div
                x-init="$nextTick(() => {
                    const target = document.querySelector('{{ $step['target'] ?? '' }}');
                    if (target) {
                        const rect = target.getBoundingClientRect();
                        $el.style.top = (rect.bottom + 16) + 'px';
                        $el.style.left = rect.left + 'px';
                    }
                })"
                class="absolute z-[1002] max-w-sm bg-white rounded-xl shadow-2xl"
            >
                <div class="p-4">
                    @if(isset($step['title']))
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $step['title'] }}</h3>
                    @endif
                    <p class="text-gray-600">{{ $step['content'] ?? '' }}</p>
                </div>

                <div class="flex items-center justify-between px-4 py-3 bg-gray-50 rounded-b-xl border-t">
                    <div class="flex items-center gap-2">
                        @if($showProgress)
                            <span class="text-sm text-gray-500">{{ $currentStep + 1 }} of {{ count($steps) }}</span>
                        @endif
                        @if($allowSkip)
                            <button wire:click="skip" class="text-sm text-gray-400 hover:text-gray-600">Skip tour</button>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        @if($currentStep > 0)
                            <button wire:click="previous" class="px-3 py-1.5 text-sm text-gray-600 hover:bg-gray-200 rounded-lg">
                                Previous
                            </button>
                        @endif
                        <button wire:click="next" class="px-4 py-1.5 text-sm bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            {{ $currentStep === count($steps) - 1 ? 'Finish' : 'Next' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
