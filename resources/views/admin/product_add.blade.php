@extends('admin.app')

@section('content')
<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
            <div>
                <h1>Add Food</h1>
                <p class="breadcrumbs"><span><a href="{{ url('admin/dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Foods</p>
            </div>
            <div>
                <a href="{{ route('foods.all') }}" class="btn btn-primary">View All</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                    </div>

                    <div class="card-body">
                        <form class="row g-3" method="POST" action="{{ route('foods.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-lg-4">
                                <div class="ec-vendor-img-upload">
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <input type='file' id="imageUpload" name="image" accept=".png, .jpg, .jpeg" />
                                            <label for="imageUpload"><img src="{{ asset('assets/img/icons/edit.svg') }}" class="svg_img header_svg" alt="edit" /></label>
                                        </div>
                                        <div class="avatar-preview ec-preview">
                                            <div class="imagePreview ec-div-preview">
                                                <img id="previewImage" src="{{ asset('assets/img/products/vender-upload-preview.jpg') }}" alt="preview" style="width: 100%; height: auto;" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Product name</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Select Category</label>
                                    <select name="category" class="form-select">
                                        <option value="">-- Select Category --</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Short Description</label>
                                    <textarea class="form-control" name="short_description" rows="2">{{ old('short_description') }}</textarea>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Amount</label>
                                    <input class="form-control" name="amount" value="{{ old('amount') }}" rows="2"/>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Full Description</label>
                                    <textarea class="form-control" name="full_description" rows="4">{{ old('full_description') }}</textarea>
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>

                        {{-- Image Preview JS --}}
                        <script>
                            document.getElementById('imageUpload').addEventListener('change', function (event) {
                                let reader = new FileReader();
                                reader.onload = function () {
                                    document.getElementById('previewImage').src = reader.result;
                                };
                                reader.readAsDataURL(event.target.files[0]);
                            });
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
