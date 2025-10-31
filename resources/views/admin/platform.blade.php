@extends('admin.app')

@section('content')
<style>
    h3 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: var(--accent-color);
        font-weight: 600;
    }

    .card-section {
        padding: 1.5rem;
        border-radius: 10px;
        border: 1px solid var(--card-border);
        margin-bottom: 2rem;
        background-color: #fff;
    }

    #slider-wrapper {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 0.5rem;
    }

    #slider-wrapper .slider-preview {
        width: 150px;
        height: 80px;
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid var(--input-border);
        background: var(--input-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s ease;
    }

    #slider-wrapper .slider-preview:hover {
        transform: scale(1.05);
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
        background: red;
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        cursor: pointer;
        font-weight: bold;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    #add-slider-btn {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        cursor: pointer;
        border: 1px solid var(--input-border);
        background-color: darkorange;
        color: #fff;
        transition: background 0.2s ease;
        margin-top: 0.5rem;
    }

    #add-slider-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    label {
        display: block;
        font-weight: 500;
        margin-bottom: 0.3rem;
        color: #333;
    }

    input.form-control,
    textarea.form-control {
        width: 100%;
        padding: 0.5rem;
        border-radius: 6px;
        border: 1px solid #ccc;
        margin-bottom: 1rem;
        color: black;
    }

    textarea.form-control {
        resize: vertical;
    }

    .btn-save {
        padding: 0.6rem 1.5rem;
        border-radius: 6px;
        cursor: pointer;
        color: #fff;
        border: none;
        background-color: black;
        transition: background 0.2s ease;
    }

    .btn-save:hover {
        background-color: #4f46e5;
    }

    .row {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .col-half {
        flex: 1 1 48%;
    }

</style>

<div class="container-fluid">
    @if(session('success'))
        <div style="padding:10px; background:#d1fae5; border:1px solid #10b981; margin-bottom:1rem;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('platform.update') }}" method="POST" enctype="multipart/form-data" id="platform-form">
        @csrf

       
        {{-- Support Line & Social Section --}}
        <div class="card-section">
            <h3>Support Line & Social Links</h3>
            <div class="row">
                <div class="col-half">
                    <label>Phone Number (Toll-Free)</label>
                    <input class="form-control" type="text" name="support_phone"
                           value="{{ $settings?->support_phone ?? '08001234567' }}">
                </div>
                <div class="col-half">
                    <label>Support Email</label>
                    <input class="form-control" type="email" name="support_email"
                           value="{{ $settings?->support_email ?? 'support@GINELLA.com' }}">
                </div>
                <div class="col-half">
                    <label>Location</label>
                    <input class="form-control" type="text" name="support_location"
                           value="{{ $settings?->support_location ?? 'Ikeja, Lagos' }}">
                </div>
                <div class="col-half">
                    <label>Facebook Link</label>
                    <input class="form-control" type="text" name="social_facebook"
                           value="{{ $settings?->social_facebook ?? '#' }}">
                </div>
                <div class="col-half">
                    <label>X / TikTok Link</label>
                    <input class="form-control" type="text" name="social_x_tiktok"
                           value="{{ $settings?->social_x_tiktok ?? '#' }}">
                </div>
                <div class="col-half">
                    <label>Instagram Link</label>
                    <input class="form-control" type="text" name="social_instagram"
                           value="{{ $settings?->social_instagram ?? '#' }}">
                </div>
            </div>
        </div>

        <button class="btn-save" type="submit">Save Settings</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sliderWrapper = document.getElementById('slider-wrapper');
    const addBtn = document.getElementById('add-slider-btn');
    const MAX_SLIDERS = 5;

    function updateAddButtonState() {
        const total = sliderWrapper.querySelectorAll('.slider-preview').length;
        addBtn.disabled = total >= MAX_SLIDERS;
    }

    function removePreview(btn) {
        btn.parentElement.remove();
        updateAddButtonState();
    }

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

    sliderWrapper.querySelectorAll('.remove-btn').forEach(btn => {
        btn.addEventListener('click', () => removePreview(btn));
    });

    updateAddButtonState();
});
</script>
@endsection
