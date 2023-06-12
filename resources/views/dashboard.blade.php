@extends('layouts.main')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Total Product <i class="bi bi-bag"></i></h4>
                            <p class="card-text">Total Product: {{ $totalProduct }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Total Brand <i class="bi bi-box"></i></h4>
                            <p class="card-text">Total Product: {{ $totalBrand }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Total Category <i class="bi bi-people"></i></h4>
                            <p class="card-text">Total Category: {{ $totalCategory }}</p>
                        </div>
                    </div>
                </div>
                @if (Auth::user()->role->name == 'Admin' || Auth::user()->role->name == 'Staff')
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Total User <i class="bi bi-people"></i></h4>
                            <p class="card-text">Total Product: {{ $totalUser }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <hr>
        </div>
        @if (Auth::user()->role->name == 'Admin' || Auth::user()->role->name == 'Staff')
        <div class="container-fluid px-4">
            <h3>User</h3>
            <div class="card mb-4">
                <div class="card-body">
                <table id="datatablesSimple">
                <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Image</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        <span class="badge {{ $user->role ? ($user->role->name == 'Admin' ? 'bg-info' : ($user->role->name == 'Staff' ? 'bg-primary' : ($user->role->name == 'User' ? 'bg-success' : 'bg-warning'))) : 'bg-danger' }}">
                                            {{ $user->role ? $user->role->name : 'Tidak Tersedia' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($user->image == null)
                                            <span class="badge bg-primary">No Image</span>
                                        @else
                                            <img src="{{ asset('storage/user/' . $user->image) }}" alt="{{ $user->name }}" style="max-width: 50px">
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <div class="container-fluid px-4">
        <h3>Product</h3>
            <div class="row">
                <div class="col">
                    <div class="card mb-4">
                        <div class="card-body">
                            <table id="datatablesSimple2">
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
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </main>
@endsection
