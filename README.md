# Tour

Guided product tours and feature walkthroughs for Laravel applications. Highlights elements, shows tooltips, and navigates users through steps. Works with Livewire and Vue 3.

## Installation

```bash
composer require mrshanebarron/tour
```

## Livewire Usage

### Basic Usage

```blade
@php
$steps = [
    ['target' => 'btn-new', 'title' => 'Create New', 'content' => 'Click here to create a new item.'],
    ['target' => 'btn-search', 'title' => 'Search', 'content' => 'Use this to search for items.'],
    ['target' => 'btn-settings', 'title' => 'Settings', 'content' => 'Access your settings here.'],
];
@endphp

<livewire:sb-tour :steps="$steps" />

<!-- Elements to highlight -->
<button id="btn-new">New</button>
<button id="btn-search">Search</button>
<button id="btn-settings">Settings</button>
```

### Start Tour Button

```blade
<button onclick="Livewire.dispatch('start-tour')">Start Tour</button>
```

### With Progress Indicator

```blade
<livewire:sb-tour :steps="$steps" :show-progress="true" />
```

### Allow Skip

```blade
<livewire:sb-tour :steps="$steps" :allow-skip="true" />
```

### Custom Overlay Color

```blade
<livewire:sb-tour
    :steps="$steps"
    overlay-color="rgba(0, 0, 0, 0.7)"
/>
```

### Livewire Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `steps` | array | `[]` | Array of tour steps |
| `showProgress` | boolean | `true` | Show step progress (1/3) |
| `allowSkip` | boolean | `true` | Show skip button |
| `overlayColor` | string | `'rgba(0,0,0,0.5)'` | Backdrop overlay color |

### Step Structure

```php
$steps = [
    [
        'target' => 'element-id',      // ID of element to highlight
        'title' => 'Step Title',        // Tooltip title
        'content' => 'Description...',  // Tooltip content
        'position' => 'bottom',         // Optional: top, bottom, left, right
    ],
];
```

### Methods

```blade
<button wire:click="$dispatch('start-tour')">Start</button>
<button wire:click="$dispatch('skip-tour')">Skip</button>
```

### Events

```blade
<livewire:sb-tour
    :steps="$steps"
    @tour-started="handleStart"
    @tour-completed="handleComplete"
    @tour-skipped="handleSkip"
    @tour-step-changed="handleStepChange"
/>
```

## Vue 3 Usage

### Setup

```javascript
import { SbTour } from './vendor/sb-tour';
app.component('SbTour', SbTour);
```

### Basic Usage

```vue
<template>
  <SbTour :steps="steps" ref="tour" />
  <button @click="$refs.tour.start()">Start Tour</button>
</template>

<script setup>
const steps = [
  { target: 'btn-1', title: 'First', content: 'This is the first step.' },
  { target: 'btn-2', title: 'Second', content: 'This is the second step.' },
];
</script>
```

### With Options

```vue
<template>
  <SbTour
    :steps="steps"
    :show-progress="true"
    :allow-skip="true"
    overlay-color="rgba(0, 0, 0, 0.75)"
    @completed="onTourComplete"
  />
</template>
```

### Vue Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `steps` | Array | `[]` | Tour steps |
| `showProgress` | Boolean | `true` | Show progress |
| `allowSkip` | Boolean | `true` | Allow skipping |
| `overlayColor` | String | `'rgba(0,0,0,0.5)'` | Overlay color |

### Methods

| Method | Description |
|--------|-------------|
| `start()` | Begin the tour |
| `next()` | Go to next step |
| `previous()` | Go to previous step |
| `skip()` | Skip the tour |

### Events

| Event | Payload | Description |
|-------|---------|-------------|
| `started` | - | Tour started |
| `completed` | - | Tour finished all steps |
| `skipped` | - | Tour was skipped |
| `step-changed` | number | Current step changed |

## Persistent Tour State

```php
// Remember if user completed the tour
public function mount()
{
    $this->showTour = !auth()->user()->completed_onboarding;
}

#[On('tour-completed')]
public function handleTourComplete(): void
{
    auth()->user()->update(['completed_onboarding' => true]);
}
```

## Styling

The tour includes:
- Dark overlay with spotlight on target element
- Positioned tooltip with arrow
- Navigation buttons (Previous, Next, Skip)
- Step counter (1/5)
- Smooth transitions between steps

## Requirements

- PHP 8.1+
- Laravel 10, 11, or 12
- Tailwind CSS 3.x
- Alpine.js

## License

MIT License
