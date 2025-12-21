<div>
    @if($this->active && $this->getCurrentStep())
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
            style="position: fixed; inset: 0; z-index: 1000;"
        >
            <!-- Overlay -->
            <div style="position: absolute; inset: 0; background: {{ $this->overlayColor }};"></div>

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
                style="position: absolute; z-index: 1002; max-width: 24rem; background: white; border-radius: 12px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);"
            >
                <div style="padding: 16px;">
                    @if(isset($step['title']))
                        <h3 style="font-size: 18px; font-weight: 600; color: #111827; margin-bottom: 8px;">{{ $step['title'] }}</h3>
                    @endif
                    <p style="color: #4b5563;">{{ $step['content'] ?? '' }}</p>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; background: #f9fafb; border-radius: 0 0 12px 12px; border-top: 1px solid #e5e7eb;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        @if($this->showProgress)
                            <span style="font-size: 14px; color: #6b7280;">{{ $this->currentStep + 1 }} of {{ count($this->steps) }}</span>
                        @endif
                        @if($this->allowSkip)
                            <button wire:click="skip" style="font-size: 14px; color: #9ca3af; background: none; border: none; cursor: pointer;">Skip tour</button>
                        @endif
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        @if($this->currentStep > 0)
                            <button wire:click="previous" style="padding: 6px 12px; font-size: 14px; color: #4b5563; background: transparent; border: none; border-radius: 8px; cursor: pointer;">
                                Previous
                            </button>
                        @endif
                        <button wire:click="next" style="padding: 6px 16px; font-size: 14px; background: #3b82f6; color: white; border: none; border-radius: 8px; cursor: pointer;">
                            {{ $this->currentStep === count($this->steps) - 1 ? 'Finish' : 'Next' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
