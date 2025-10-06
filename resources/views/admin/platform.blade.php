@extends('admin.app')

@section('content')
<style>
    :root {
        --accent-color: #FF9F43;  /* dark orange */
        --input-bg: #1f1f1f;      /* dark preview bg */
        --input-border: #333;
    }

    #slider-wrapper {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
    }

    #slider-wrapper .slider-preview {
        width: 150px;
        height: 80px;
        position: relative;
        border-radius: 5px;
        overflow: hidden;
        border: 1px solid var(--input-border);
        background: var(--input-bg);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #slider-wrapper .slider-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    #slider-wrapper .slider-preview button.remove-btn {
        position: absolute;
        top: -8px;
        right: -8px;
        background: var(--accent-color);
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        cursor: pointer;
        font-weight: bold;
    }

    #add-slider-btn {
        padding: 0.25rem 0.5rem;
        border: 1px solid var(--input-border);
        border-radius: 5px;
        cursor: pointer;
        margin-bottom: 1rem;
        background-color: #fff;
        color: var(--accent-color);
    }

    #add-slider-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    textarea {
        width: 100%;
        padding: 0.5rem;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-bottom: 1rem;
    }

    button.btn-save {
        padding: 0.5rem 1rem;
        border-radius: 5px;
        cursor: pointer;
        background: #6366f1;
        color: #fff;
        border: none;
    }

    h3 { margin-top: 1rem; }
</style>

<div class="container-fluid" style="margin-top:2rem;">
    @if(session('success'))
        <div style="padding:10px; background:#d1fae5; border:1px solid #10b981; margin-bottom:1rem;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('platform.update') }}" method="POST" enctype="multipart/form-data" id="platform-form">
        @csrf

        <h3>Slider Images (Max 5)</h3>
        <div id="slider-wrapper">
            {{-- Existing Images --}}
            @php
                $existingImages = $settings && $settings->slider_images ? json_decode($settings->slider_images, true) : [];
            @endphp
            @foreach($existingImages as $img)
                <div class="slider-preview">
                    <img src="{{ asset($img) }}" alt="slider">
                    <button type="button" class="remove-btn">&times;</button>
                    <input type="hidden" name="existing_slider_images[]" value="{{ $img }}">
                </div>
            @endforeach
        </div>

        <button type="button" id="add-slider-btn">Add Image</button>

        <h3>Login Terms of Use</h3>
        <textarea id="myTextarea" name="login_terms" rows="6">{{ $settings?->login_terms }}</textarea>

        <button class="btn-save" type="submit">Save Settings</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sliderWrapper = document.getElementById('slider-wrapper');
    const addBtn = document.getElementById('add-slider-btn');
    const MAX_SLIDERS = 5;

    // Update button disabled state
    function updateAddButtonState() {
        const total = sliderWrapper.querySelectorAll('.slider-preview').length;
        addBtn.disabled = total >= MAX_SLIDERS;
    }

    // Remove preview
    function removePreview(btn) {
        btn.parentElement.remove();
        updateAddButtonState();
    }

    // Add new file preview
    function createPreview(file) {
        const div = document.createElement('div');
        div.classList.add('slider-preview');

        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        div.appendChild(img);

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.textContent = '×';
        removeBtn.classList.add('remove-btn');
        removeBtn.addEventListener('click', () => removePreview(removeBtn));
        div.appendChild(removeBtn);

        // Hidden input to submit file
        const dt = new DataTransfer();
        dt.items.add(file);
        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'slider_images[]';
        input.files = dt.files;
        input.style.display = 'none';
        div.appendChild(input);

        sliderWrapper.appendChild(div);
        updateAddButtonState();
    }

    addBtn.addEventListener('click', () => {
        if(sliderWrapper.querySelectorAll('.slider-preview').length >= MAX_SLIDERS) return;

        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/*';
        input.style.display = 'none';

        input.addEventListener('change', function() {
            if(this.files && this.files[0]) {
                createPreview(this.files[0]);
                input.remove();
            }
        });

        sliderWrapper.appendChild(input);
        input.click();
    });

    // Remove existing buttons
    sliderWrapper.querySelectorAll('.remove-btn').forEach(btn => {
        btn.addEventListener('click', () => removePreview(btn));
    });

    updateAddButtonState();
});
</script>
@endsection
