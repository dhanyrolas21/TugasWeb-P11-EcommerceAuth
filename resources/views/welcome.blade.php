<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexTechCommerce — Katalog E-Commerce RBAC</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body { background: #f3f4f9; font-family: 'Inter', sans-serif; }
        h1, h2, h3, .navbar-brand { font-family: 'Sora', sans-serif; }
        .bg-dark-custom { background-color: #12141c !important; }
        .btn-accent { background-color: #0e7490; color: #fff; font-weight: 600; }
        .btn-accent:hover { background-color: #0b5b73; color: #fff; }
        .product-card { background: #fff; border: 1px solid #e2e4ee; border-radius: 10px; transition: transform 0.2s, border-color 0.2s; }
        .product-card:hover { transform: translateY(-4px); border-color: #4c3fe0; }
        .price { color: #372fb0; font-weight: 700; font-size: 1.15rem; }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark-custom sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="#">
                <i class="bi bi-cpu-fill text-info"></i> NexTechCommerce
            </a>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item"><a class="nav-link" href="#katalog">Katalog</a></li>
                    
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <span class="badge bg-secondary me-2">Role: {{ strtoupper(auth()->user()->role) }}</span>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/dashboard') }}" class="btn btn-outline-light btn-sm">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item"><a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Log in</a></li>
                            <li class="nav-item"><a href="{{ route('register') }}" class="btn btn-accent btn-sm">Register</a></li>
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- KATALOG PRODUK -->
    <main class="py-5" id="katalog">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h2 class="fw-bold m-0">Katalog Produk Teknologi</h2>
                    <p class="text-secondary m-0">Terhubung langsung dengan Database & Role-Based Access Control (RBAC) Laravel 11</p>
                </div>

                <!-- AKSI KHUSUS ADMIN: TOMBOL TAMBAH PRODUK -->
                @auth
                    @if(auth()->user()->role === 'admin')
                        <button class="btn btn-success"><i class="bi bi-plus-lg"></i> Tambah Produk (Admin Only)</button>
                    @endif
                @endauth
            </div>

            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                        <article class="card product-card h-100">
                            <div class="card-body d-flex flex-column p-4">
                                <h3 class="card-title h6 fw-bold mb-2">{{ $product->name }}</h3>
                                <p class="card-text text-secondary small flex-grow-1 mb-3">{{ $product->description }}</p>
                                
                                <div class="pt-2 border-top">
                                    <p class="price mb-0">{{ "Rp " . number_format($product->price, 0, ',', '.') }}</p>
                                    <p class="small text-muted mb-0">Stok: {{ $product->stock }} pcs</p>
                                </div>

                                <!-- AKSI HANYA TAMPIL JIKA ADMIN/EDITOR LOGIN -->
                                @auth
                                    @if(auth()->user()->role === 'admin')
                                        <div class="mt-3 d-flex gap-1">
                                            <button class="btn btn-warning btn-sm w-50"><i class="bi bi-pencil"></i> Edit</button>
                                            <button class="btn btn-danger btn-sm w-50"><i class="bi bi-trash"></i> Hapus</button>
                                        </div>
                                    @elseif(auth()->user()->role === 'editor')
                                        <div class="mt-3">
                                            <button class="btn btn-warning btn-sm w-100"><i class="bi bi-pencil"></i> Edit Produk</button>
                                        </div>
                                    @endif
                                @endauth

                            </div>
                        </article>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

</body>
</html>