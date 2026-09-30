<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 leading-tight">
            {{ __('Dashboard E-Commerce') }} - <span style="color: #76b900;" class="font-bold uppercase">{{ auth()->user()->role }}</span>
        </h2>
    </x-slot>

    <!-- CDN Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* TEMA NVIDIA GEFORCE DARK MODE */
        body, .min-h-screen { background-color: #0d0d0d !important; }
        .bg-nvidia-card { background-color: #181818 !important; border: 1px solid #2a2a2a !important; color: #ffffff !important; }
        .btn-nvidia { background-color: #76b900 !important; color: #000000 !important; font-weight: 700 !important; border: none !important; }
        .btn-nvidia:hover { background-color: #8ce000 !important; color: #000000 !important; }
        .text-nvidia { color: #76b900 !important; }
        .modal-content { background-color: #1a1a1a !important; color: #ffffff !important; border: 1px solid #333 !important; }
        .form-control { background-color: #121212 !important; color: #ffffff !important; border: 1px solid #333 !important; }
        .form-control:focus { background-color: #181818 !important; color: #ffffff !important; border-color: #76b900 !important; box-shadow: none !important; }
    </style>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-nvidia-card rounded-lg p-6 shadow-lg">
                
                <!-- NOTIFIKASI SUKSES -->
                @if(session('success'))
                    <div class="alert alert-success bg-dark text-white border-success alert-dismissible fade show mb-4" role="alert">
                        <i class="bi bi-check-circle-fill text-nvidia me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                    <div>
                        <h3 class="fw-bold mb-1 text-white">Daftar Produk E-Commerce</h3>
                        <p class="text-secondary small m-0">Akses kontrol aktif untuk Role: <strong class="text-nvidia">{{ strtoupper(auth()->user()->role) }}</strong></p>
                    </div>

                    <!-- TOMBOL TAMBAH PRODUK (KHUSUS ADMIN) -->
                    @if(auth()->user()->role === 'admin')
                        <button class="btn btn-nvidia px-4 py-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Barang
                        </button>
                    @endif
                </div>

                <div class="row g-4">
                    @foreach($products as $product)
                        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                            <div class="card h-100 bg-nvidia-card rounded-3">
                                <div class="card-body d-flex flex-column p-4">
                                    <h4 class="card-title h6 fw-bold mb-2 text-white">{{ $product->name }}</h4>
                                    <p class="card-text text-secondary small flex-grow-1 mb-3">{{ $product->description }}</p>
                                    
                                    <div class="pt-3 border-top border-secondary">
                                        <p class="fw-bold text-nvidia mb-0 fs-5">{{ "Rp " . number_format($product->price, 0, ',', '.') }}</p>
                                        <p class="small text-secondary mb-0">Stok: {{ $product->stock }} pcs</p>
                                    </div>

                                    <!-- KONTROL HAK AKSES BERDASARKAN ROLE -->
                                    @if(auth()->user()->role === 'admin')
                                        <div class="mt-3 d-flex gap-2">
                                            <!-- EDIT (ADMIN) -->
                                            <button class="btn btn-warning btn-sm w-50 fw-bold" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $product->id }}">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            
                                            <!-- HAPUS (ADMIN) -->
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="w-50" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm w-100 fw-bold">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>

                                    @elseif(auth()->user()->role === 'editor')
                                        <!-- EDIT (EDITOR) -->
                                        <div class="mt-3">
                                            <button class="btn btn-warning btn-sm w-100 fw-bold" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $product->id }}">
                                                <i class="bi bi-pencil"></i> Edit Produk
                                            </button>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>

                        <!-- MODAL EDIT PRODUK -->
                        <div class="modal fade" id="modalEdit{{ $product->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header border-secondary">
                                            <h5 class="modal-title fw-bold text-white">Edit Produk: {{ $product->name }}</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-start">
                                            <div class="mb-3">
                                                <label class="form-label text-secondary small">Nama Barang</label>
                                                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-secondary small">Deskripsi</label>
                                                <textarea name="description" class="form-control" rows="2" required>{{ $product->description }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-secondary small">Harga (Rp)</label>
                                                <input type="number" name="price" class="form-control" value="{{ intval($product->price) }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label text-secondary small">Stok</label>
                                                <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-secondary">
                                            <button type="button" class="btn btn-outline-light btn-sm" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-nvidia btn-sm">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH PRODUK (KHUSUS ADMIN) -->
    @if(auth()->user()->role === 'admin')
        <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        <div class="modal-header border-secondary">
                            <h5 class="modal-title fw-bold text-white">+ Tambah Barang Baru</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                            <div class="mb-3">
                                <label class="form-label text-secondary small">Nama Barang</label>
                                <input type="text" name="name" class="form-control" placeholder="Contoh: Laptop Gaming RTX 4060" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary small">Deskripsi</label>
                                <textarea name="description" class="form-control" rows="2" placeholder="Deskripsi produk..." required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary small">Harga (Rp)</label>
                                <input type="number" name="price" class="form-control" placeholder="18500000" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-secondary small">Stok</label>
                                <input type="number" name="stock" class="form-control" placeholder="10" required>
                            </div>
                        </div>
                        <div class="modal-footer border-secondary">
                            <button type="button" class="btn btn-outline-light btn-sm" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-nvidia btn-sm">Simpan Produk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>