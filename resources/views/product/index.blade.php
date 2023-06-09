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
                                <th>Image</th>
                                @if (Auth::user()->role->name == 'Admin')
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
                                    <td>
                                        @if ($product->image == null)
                                            <span class="badge bg-primary">No Image</span>
                                        @else
                                            <img src="{{ asset('storage/product/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 50px">
                                        @endif
                                    </td>
                                    @if (Auth::user()->role->name == 'Admin')
                                    <td>
                                        
                                        <form onsubmit="return confirm('Are you sure? ');" action="{{ route('product.destroy', $product->id) }}" method="POST">
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
    </main>
@endsection