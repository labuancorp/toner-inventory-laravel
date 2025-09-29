@extends('layouts.material')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 col-lg-8 mx-auto">
            {{-- Page Header --}}
            <div class="page-header d-print-none mb-4">
                <div class="row align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            Appearance Settings
                        </h2>
                        <div class="text-muted mt-1">
                            Customize the look and feel of the application. Changes are saved to your browser.
                        </div>
                    </div>
                </div>
            </div>

            {{-- Theme Options Card --}}
            <div
                class="card"
                x-data="themeSettings"
            >
                <div class="card-header">
                    <h3 class="card-title">Theme Options</h3>
                </div>
                <div class="card-body">
                    {{-- Primary Color Selection --}}
                    <div class="mb-4">
                        <div class="form-label">Primary Color</div>
                        <div class="row g-2">
                            <template x-for="(color, name) in colors" :key="name">
                                <div class="col-auto">
                                    <label class="form-colorinput">
                                        <input
                                            name="color"
                                            type="radio"
                                            :value="name"
                                            class="form-colorinput-input"
                                            x-model="selectedColor"
                                            @change="handleColorChange($event)"
                                        />
                                        <span
                                            class="form-colorinput-color"
                                            :style="{ 'background-color': color }"
                                        ></span>
                                    </label>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Layout Density Selection --}}
                    <div>
                        <div class="form-label">Layout Density</div>
                        <div class="d-flex gap-3">
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="density" value="comfortable" x-model="selectedDensity" @change="handleDensityChange($event)">
                                <span class="form-check-label">Comfortable</span>
                            </label>
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="density" value="compact" x-model="selectedDensity" @change="handleDensityChange($event)">
                                <span class="form-check-label">Compact</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('themeSettings', () => ({
            // Define available colors for the UI picker
            colors: {
                'blue': '#206bc4',
                'green': '#2fb344',
                'purple': '#ae3ec9',
                'orange': '#d6336c',
                'red': '#d63939',
            },

            // Set initial state from localStorage for the radio buttons
            selectedColor: localStorage.getItem('theme_color') || 'blue',
            selectedDensity: localStorage.getItem('theme_density') || 'comfortable',

            // Handlers now call the global functions from app.js
            handleColorChange(event) {
                const newColor = event.target.value;
                this.selectedColor = newColor;
                window.setThemeColor(newColor);
            },
            handleDensityChange(event) {
                const newDensity = event.target.value;
                this.selectedDensity = newDensity;
                window.setThemeDensity(newDensity);
            }
        }));
    });
</script>
@endpush
@endsection