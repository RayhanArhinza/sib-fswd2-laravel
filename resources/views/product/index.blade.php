@extends('layouts.main')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="my-4">Product</h1>
            @if (Auth::user()->role->name == 'Admin')
                <a class="btn btn-primary mb-2" href="{{ route('product.create') }}" role="button">Create New</a>
            @endif
            <div class="card mb-4">
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Nama</th>
                                <th>Price</th>
                                <th>Sale Price</th>
                                <th>Stock</th>
                                <th>Rating</th>
                                <th>Brand</th>
                                <th>Description</th>
                                <th>Image</th>
                                @if (Auth::user()->role->name == 'Admin')
                                    <th>Status</th>
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>Rp. {{ number_format($product->price, 0, 2) }}</td>
                                    <td>Rp. {{ number_format($product->sale_price, 0, 2) }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>{{ $product->rating }}</td>
                                    <td>{{ $product->brands }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>
                                        @if ($product->image == null)
                                            <span class="badge bg-primary">No Image</span>
                                        @else
                                            <img src="{{ asset('storage/product/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 50px">
                                        @endif
                                    </td>
                                    @if (Auth::user()->role->name == 'Admin')
                                    
                                    <td id="status-{{ $product->id }}">
                                        @if ($product->status == 'approve')
                                            <span class="badge bg-success">Approve</span>
                                        @elseif ($product->status == 'reject')
                                            <span class="badge bg-danger">Reject</span>
                                        @else
                                            <form id="status-form-{{ $product->id }}" action="{{ route('product.updateStatus', $product->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="approve">
                                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#confirmApproveModal{{ $product->id }}"><i class="fas fa-check"></i></button>
                                            </form>

                                            <form id="status-form-{{ $product->id }}" action="{{ route('product.updateStatus', $product->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="reject">
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmRejectModal{{ $product->id }}"><i class="fas fa-times"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                    
                                    <td>
                                        <form onsubmit="return confirm('Are you sure?');" action="{{ route('product.destroy', $product->id) }}" method="POST">
                                            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>

                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        @foreach ($products as $product)
            <div class="modal fade" id="confirmApproveModal{{ $product->id }}" tabindex="-1" aria-labelledby="confirmApproveModalLabel{{ $product->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmApproveModalLabel{{ $product->id }}">Approve Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to approve this product?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-success" onclick="updateStatus({{ $product->id }}, 'approve')">Approve</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="confirmRejectModal{{ $product->id }}" tabindex="-1" aria-labelledby="confirmRejectModalLabel{{ $product->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmRejectModalLabel{{ $product->id }}">Reject Product</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to reject this product?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" onclick="updateStatus({{ $product->id }}, 'reject')">Reject</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </main>
@endsection

<script>
    function updateStatus(productId, status) {
        const formElement = document.getElementById(`status-form-${productId}`);
        formElement.querySelector('input[name="status"]').value = status;
        formElement.submit();
    }
</script>
