<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>ARHZ STORE</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-Zb8XqXqzkszZqXRgK2Pxv3w61WlFPN9dHNbRKuzn3T9wByh6BuoRqDHGka2oUOxRZwAwTw5Ogy5MleX9ShNnzw==" crossorigin="anonymous" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('css/landing.css') }}" rel="stylesheet" />
</head>

<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-4 px-lg-5">
    <h4 class="logo-brand"><span class="text-light">ARHZ</span><span class="text-warning">STORE</span></h4>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categories</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @foreach ($categories as $category)
                            <li><a class="dropdown-item" href="{{ route('landing', ['category' => $category->name]) }}">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
            </ul>
            <form class="d-flex flex-grow-1 mx-lg-4" action="{{ route('landing') }}" method="GET">
                @csrf
                <input class="form-control me-2" type="search" placeholder="Search for products..." aria-label="Search" name="search" onchange="this.form.submit()">
            </form>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="btn btn-outline-light me-1" href="#">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-light text-dark ms-1 rounded-pill">0</span>
                    </a>
                </li>
                @auth
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-light me-1">
                            <i class="bi-person-fill me-1"></i>
                            Dashboard
                        </a>
                    </li>
                @endauth
                @guest
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-outline-light">
                            <i class="bi-person-fill me-1"></i>
                            Login
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>


    <!-- Carousel-->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach ($sliders as $slider)
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $loop->iteration - 1 }}" class="{{ $loop->first ? 'active' : '' }}"
                    aria-current="{{ $loop->first ? 'true' : '' }}" aria-label="Slide 1"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach ($sliders as $slider)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}" data-bs-interval="3000">
                    <img src="{{ asset('storage/slider/' . $slider->image) }}" class="d-block w-100" alt="{{ $slider->image }}">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>{{ $slider->title }}</h5>
                        <p>{{ $slider->caption }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- Section-->
    <section class="py-5">
    <div class="container mt-2">
    <h3 class="text-center">Our Product</h3>
    <div class="row d-flex justify-content-between">
        <div class="col-md-3 mb-3">
            <div class="row mb-3">
                <div class="col">
                    <div class="card mb-1">
                        <div class="card-body">
                            <h5 class="card-title">Price</h5>
                            <form action="{{ route('landing') }}" method="GET">
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
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Brand</h5>
                            <form action="{{ route('landing') }}" method="GET">
                                @csrf
                                <div class="row g-3 my-2">
                                    <div class="col-12">
                                        <label for="brand" class="form-label">Brand</label>
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
        </div>

        <div class="col-md-9">
            <div class="row gx-4 row-cols-xl-3">
                @forelse ($products as $product)
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
    </div>
</div>

    </section>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
        <div class="row">
                <div class="col-6 px-4">
                    <h2 class="logo-brand"><span class="text-light">ARHZ</span><span class="text-warning">STORE</span></h2>
                    <p class="text-light">merupakan toko yang menjual beraneka ragam tanaman, mulai dari tanaman hias hingga tanaman obat keluarga.</p>
                </div>
                <div class="col-6 px-4">
                    <p class="text-light"><i class="bi bi-geo-alt-fill" class="text-light"></i> Surabaya, Jawa Timur</p>
                    <small class="text-light">Developed by Rayhan Saneval Arhinza</small>
                    <br>
                    <br>
                    <a class="icon text-light" style="font-size: 30px;" href="https://www.linkedin.com/in/rayhan-saneval-840018207/"><i class="bi bi-linkedin"></i></a>
                    <a class="icon text-light" style="font-size: 30px;" href="https://github.com/RayhanArhinza"><i class="bi bi-github"></i></a>
                    <a class="icon text-light" style="font-size: 30px;" href=""><i class="bi bi-facebook"></i></a>

                </div>
            </div>
            <hr>
            <p class="text-center text-light"> CopyRight © 2023 by Rayhan Saneval Arhinza | FSWD 2</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    {{-- <script src="js/scripts.js"></script> --}}
</body>

</html>