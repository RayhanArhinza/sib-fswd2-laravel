@extends('layouts.main')

@section('content')
    <main>
        <div class="container-fluid mt-4">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                <div class="col-md-10">
                    <div class="title mb-30">
                        <h1 >Product</h1>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-md-2">
                    <div class="breadcrumb-wrapper mb-30">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('product.index') }}" style="text-decoration: none;">Product</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            All
                        </li>
                        </ol>
                    </nav>
                    </div>
                </div>
                <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <hr>
        </div>
        
        <div class="container-fluid px-4">
            <section class="py-2">
                <div class="container mt-2">
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-9">
                            <div class="row gx-4 row-cols-xl-3">
                                @forelse ($products->where('status', 'approve') as $product)
                                    <!-- Product card -->
                                    <div class="col mb-3">
                                        <div class="card h-100">
                                            <!-- Sale badge -->
                                            @if ($product['sale_price'] != 0)
                                                <div class="badge bg-success text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                                            @endif
                                            <!-- Product image -->
                                            <img class="card-img-top" src="{{ asset('storage/product/' . $product->image) }}" alt="{{ $product->name }}" />
                                            <!-- Product details -->
                                            <div class="card-body p-4">
                                                <div class="text-center">
                                                    <!-- Product name -->
                                                    <a href="{{ route('product.show', ['id' => $product->id]) }}" style="text-decoration: none" class="text-dark">
                                                        <small class="text-strong">{{ $product->category->name }}</small>
                                                        <h5 class="fw-bolder">{{ $product->name }}</h5>
                                                    </a>
                                                    <!-- Product reviews -->
                                                    <div class="d-flex justify-content-center small text-warning mb-2">
                                                        @for ($i = 0; $i < $product->rating; $i++)
                                                            <div class="bi-star-fill"></div>
                                                        @endfor
                                                    </div>
                                                    <!-- Product price -->
                                                    @if ($product['sale_price'] != 0)
                                                        <span class="text-muted text-decoration-line-through">Rp.{{ number_format($product->price, 0) }}</span>
                                                        Rp.{{ number_format($product->sale_price, 0) }}
                                                    @else
                                                        Rp.{{ number_format($product->price, 0) }}
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- Product actions -->
                                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="alert alert-secondary w-100 text-center" role="alert">
                                        <h4>Produk belum tersedia</h4>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="col-md-3 mb-5">
                            <div class="row">
                                <div class="col">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">Price</h5>
                                            <form action="{{ route('product.index') }}" method="GET">
                                                @csrf
                                                <div class="row g-3 my-2">
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" placeholder="Min" name="min" value="{{ old('min') }}">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" placeholder="Max" name="max" value="{{ old('max') }}">
                                                    </div>
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h5 class="card-title">Brand</h5>
                                            <form action="{{ route('product.index') }}" method="GET">
                                                @csrf
                                                <div class="row g-3 my-2">
                                                    <div class="col-12">
                                                        <select class="form-select @error('brand') is-invalid @enderror" aria-label="brand" id="brand" name="brand">
                                                            <option selected disabled>- Choose Brand -</option>
                                                            @foreach ($brands as $brand)
                                                                <option value="{{ $brand->name }}" {{ old('brand') == $brand->name ? 'selected' : '' }}>{{ $brand->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Category</h5>
                                            <form action="{{ route('product.index') }}" method="GET">
                                                @csrf
                                                <div class="row g-3 my-2">
                                                    <div class="col-12">
                                                    <select class="form-select @error('category') is-invalid @enderror" aria-label="category" id="category" name="category">
                                                        <option selected disabled>- Choose Category -</option>
                                                        @foreach ($categories as $cat)
                                                            <option value="{{ $cat->id }}" {{ old('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    </div>
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item {{ $products->currentPage() == 1 ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $products->previousPageUrl() }}" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                        </li>
                        @for ($i = 1; $i <= $products->lastPage(); $i++)
                        <li class="page-item {{ $i == $products->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                        </li>
                        @endfor
                        <li class="page-item {{ $products->currentPage() == $products->lastPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                        </li>
                    </ul>
                </nav>
            </section>
        </div>
    </main>
@endsection