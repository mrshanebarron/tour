# Laravel Design Tour

Product tour/onboarding component for Laravel. Supports Livewire, Blade, and Vue 3.

## Installation

```bash
composer require mrshanebarron/tour
```

## Usage

### Livewire Component

```blade
<livewire:ld-tour />
```

### Blade Component

```blade
<x-ld-tour />
```

## Configuration

Publish the config file:

```bash
php artisan vendor:publish --tag=ld-tour-config
```

## Customization

### Publishing Views

```bash
php artisan vendor:publish --tag=ld-tour-views
```

## License

MIT
