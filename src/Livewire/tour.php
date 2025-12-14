<?php

namespace MrShaneBarron\Tour\Livewire;

use Livewire\Component;

class Tour extends Component
{
    public array $steps = [];
    public int $currentStep = 0;
    public bool $active = false;
    public string $overlayColor = 'rgba(0,0,0,0.5)';
    public bool $showProgress = true;
    public bool $allowSkip = true;

    public function mount(
        array $steps = [],
        bool $showProgress = true,
        bool $allowSkip = true,
        string $overlayColor = 'rgba(0,0,0,0.5)'
    ): void {
        $this->steps = $steps;
        $this->showProgress = $showProgress;
        $this->allowSkip = $allowSkip;
        $this->overlayColor = $overlayColor;
    }

    public function start(): void
    {
        $this->active = true;
        $this->currentStep = 0;
        $this->dispatch('tour-started');
    }

    public function next(): void
    {
        if ($this->currentStep < count($this->steps) - 1) {
            $this->currentStep++;
            $this->dispatch('tour-step-changed', step: $this->currentStep);
        } else {
            $this->finish();
        }
    }

    public function previous(): void
    {
        if ($this->currentStep > 0) {
            $this->currentStep--;
            $this->dispatch('tour-step-changed', step: $this->currentStep);
        }
    }

    public function skip(): void
    {
        $this->active = false;
        $this->dispatch('tour-skipped');
    }

    public function finish(): void
    {
        $this->active = false;
        $this->dispatch('tour-completed');
    }

    public function getCurrentStep(): ?array
    {
        return $this->steps[$this->currentStep] ?? null;
    }

    public function render()
    {
        return view('sb-tour::livewire.tour');
    }
}
