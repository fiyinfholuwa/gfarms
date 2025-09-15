@extends('admin.app')

@section('content')
<div class="ec-content-wrapper">
    <div class="content">
        <div class="breadcrumb-wrapper d-flex align-items-center justify-content-between">
            <div>
                <h1>Product</h1>
                <p class="breadcrumbs">
                    <span><a href="{{ url('admin/dashboard') }}">Home</a></span>
                    <span><i class="mdi mdi-chevron-right"></i></span>Product
                </p>
            </div>
            <div>
                <a href="{{ route('admin.product.add') }}" class="btn btn-primary">Add Product</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card card-default">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="responsive-data-table" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Amount</th>
                                        <th>Date Added</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($foods as $food)
                                        <tr>
                                            <td>
                                                @if($food->image && file_exists(public_path($food->image)))
                                                    <img class="tbl-thumb" src="{{ asset($food->image) }}" alt="{{ $food->name }}" style="width:50px; height:auto;">
                                                @else
                                                    <img class="tbl-thumb" src="{{ asset('assets_old/img/products/vender-upload-preview.jpg') }}" alt="No Image" style="width:50px; height:auto;">
                                                @endif
                                            </td>
                                            <td>{{ $food->name }}</td>
                                            <td>{{ optional($food->cat)->name }}</td>
                                            <td>{{ $food->amount }}</td>
                                            <td>{{ $food->created_at->format('Y-m-d') }}</td>
                                            <td>
                                                <div class="btn-group mb-1">
                                                    <a href="{{ route('foods.edit', $food->id) }}" class="btn btn-outline-success">Edit</a>
                                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $food->id }}">
                                                        Delete
                                                    </button>
                                                </div>

                                                <!-- Delete Confirmation Modal -->
                                                <div class="modal fade" id="deleteModal{{ $food->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $food->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteModalLabel{{ $food->id }}">Confirm Delete</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete <strong>{{ $food->name }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <form action="{{ route('foods.destroy', $food->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Modal -->
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No products found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection
