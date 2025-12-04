@extends('layouts.app')

@section('title', 'JajanGaming - Top Up Robux Roblox')

@section('content')
    <!-- Hero Section -->
    <div class="hero-section">
        <!-- Hero Slider -->
        <div class="hero-slider">
            <div class="hero-slide active"></div>
            <div class="hero-slide"></div>
            <div class="hero-slide"></div>
        </div>

        <!-- Dark Overlay for text contrast -->
        <div class="dark-overlay"></div>

        <!-- Navigation Arrows -->
        <button class="hero-nav hero-nav-prev" onclick="changeHeroSlide(-1)">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="hero-nav hero-nav-next" onclick="changeHeroSlide(1)">
            <i class="fas fa-chevron-right"></i>
        </button>

        <div class="container">
            <div class="row align-items-center">
                <!-- Left Content -->
                <div class="col-lg-6 hero-content-left">
                    <h1 class="hero-title">
                        THE LAST OF US PART II
                    </h1>
                    <p class="hero-description">
                        Five years after the events of The Last of Us, Ellie embarks on another journey through a
                        post-apocalyptic America on a mission of vengeance against a mysterious militia.
                    </p>
                </div>

                <!-- Right Content -->
                <div class="col-lg-6 hero-content-right">
                    <div class="hero-price">$49.99</div>
                    <div class="hero-buttons d-flex flex-column gap-3">
                        <a href="#products" class="btn btn-hero-buy">
                            Buy Now
                        </a>
                        <a href="#" class="btn btn-hero-wishlist">
                            Add to Wishlist
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="container">
        <div class="search-section">
            <div class="row align-items-center">
                <div class="col-md-10">
                    <div class="d-flex align-items-center">
                        <h4 class="mb-0 me-4">
                            <i class="fas fa-search me-2"></i>Cari Paket Robux
                        </h4>
                        <form method="GET" action="{{ route('home') }}" class="d-flex flex-grow-1">
                            <div class="me-2 flex-grow-1">
                                <input type="text" class="form-control" name="search" placeholder="Cari paket Robux..."
                                    value="{{ request('search') }}">
                            </div>
                            <div class="me-2" style="min-width: 180px;">
                                <select class="form-select" name="category">
                                    <option value="">🏷️ Semua Kategori</option>
                                    <option value="popular" {{ request('category') == 'popular' ? 'selected' : '' }}>
                                        🔥 Game Popular
                                    </option>
                                    <option value="top_seller" {{ request('category') == 'top_seller' ? 'selected' : '' }}>
                                        👑 Penjual Terbanyak
                                    </option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary me-3">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-md-2 text-end">
                    @auth
                        <div class="wallet-balance" style="max-width: 160px;">
                            <i class="fas fa-wallet me-2"></i>
                            Rp {{ number_format(auth()->user()->wallet_balance, 0, ',', '.') }}
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Top Selling Products Section -->
    <div class="container mt-5 mb-5">
        <div class="row align-items-center mb-4">
            <div class="col">
                <h2 class="mb-0">
                    <i class="fas fa-fire me-2"></i>Paket Robux Terlaris
                    <i class="fas fa-chevron-right ms-2"></i>
                </h2>
            </div>
        </div>

        <div class="upcoming-games-wrapper position-relative">
            <button class="upcoming-nav upcoming-nav-prev" onclick="scrollUpcomingGames(-1)">
                <i class="fas fa-chevron-left"></i>
            </button>

            <div class="upcoming-games-container">
                @forelse($topSellingProducts as $index => $topProduct)
                    <div class="upcoming-game-card">
                        <div class="upcoming-game-image">
                            <img src="{{ asset('img/' . $topProduct->image) }}" alt="{{ $topProduct->name }}">
                            <button class="favorite-btn" onclick="toggleFavorite(this, {{ $topProduct->id }})">
                                <i class="far fa-heart"></i>
                            </button>
                            @if ($index === 0)
                                <div class="best-seller-badge">
                                    <i class="fas fa-crown"></i> #1 Best Seller
                                </div>
                            @endif
                        </div>
                        <div class="upcoming-game-info">
                            <h5 class="upcoming-game-title">{{ $topProduct->name }}</h5>
                            <p class="upcoming-game-description">{{ Str::limit($topProduct->description, 60) }}</p>

                            <!-- Seller Info -->
                            <div class="mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="seller-avatar me-2">
                                        @if ($topProduct->seller && $topProduct->seller->profile_photo)
                                            <img src="{{ asset('storage/' . $topProduct->seller->profile_photo) }}"
                                                alt="{{ $topProduct->seller_name }}" class="rounded-circle"
                                                style="width: 28px; height: 28px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center rounded-circle"
                                                style="width: 28px; height: 28px;">
                                                <i class="fas fa-user fa-xs text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <small class="text-muted d-block" style="font-size: 0.75rem;">Seller:</small>
                                        @if ($topProduct->seller && $topProduct->seller->id)
                                            <a href="{{ route('seller.profile', $topProduct->seller->id) }}"
                                                class="fw-medium text-white text-decoration-none seller-link-upcoming"
                                                onclick="event.stopPropagation();" style="font-size: 0.85rem;">
                                                {{ $topProduct->seller_name }}
                                                <i class="fas fa-external-link-alt ms-1" style="font-size: 0.6rem;"></i>
                                            </a>
                                        @else
                                            <span class="fw-medium text-white"
                                                style="font-size: 0.85rem;">{{ $topProduct->seller_name }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="rating me-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($topProduct->averageRating()))
                                                <i class="fas fa-star text-warning"></i>
                                            @elseif($i - 0.5 <= $topProduct->averageRating())
                                                <i class="fas fa-star-half-alt text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <small class="text-muted">{{ number_format($topProduct->averageRating(), 1) }}</small>
                                </div>
                                <small class="text-success">
                                    <i class="fas fa-shopping-cart me-1"></i>{{ number_format($topProduct->sales_count) }}
                                    terjual
                                </small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="upcoming-game-price">Rp
                                    {{ number_format($topProduct->price, 0, ',', '.') }}</span>
                                <a href="{{ route('products.show', $topProduct) }}" class="btn btn-upcoming">
                                    <i class="fas fa-shopping-cart me-1"></i>Beli Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-4">
                        <p class="text-muted">Belum ada produk terlaris</p>
                    </div>
                @endforelse
            </div>

            <button class="upcoming-nav upcoming-nav-next" onclick="scrollUpcomingGames(1)">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <!-- Products Section -->
    <div class="container" id="products">
        <div class="row">
            <div class="col-12 mb-4">
                <h2 class="text-center mb-4">
                    <i class="fas fa-gamepad me-2"></i>Paket Robux Tersedia
                </h2>
            </div>
        </div>

        <div class="row">
            @forelse($products as $product)
                <div class="col-12 col-md-6 mb-4">
                    <div class="card-landscape h-100" onclick="window.location='{{ route('products.show', $product) }}'">
                        <div class="card-landscape-image">
                            <img src="{{ asset('img/' . $product->image) }}" alt="{{ $product->name }}">
                            <button class="favorite-btn-landscape"
                                onclick="event.stopPropagation(); toggleFavorite(this, {{ $product->id }})">
                                <i class="far fa-heart"></i>
                            </button>
                            @if (request('category') == 'top_seller' || $product->sales_count > 100)
                                <div class="discount-badge-landscape">
                                    -55%
                                </div>
                            @endif
                        </div>

                        <div class="card-landscape-content">
                            <h5 class="card-landscape-title">{{ $product->name }}</h5>

                            <p class="card-landscape-description">{{ Str::limit($product->description, 80) }}</p>

                            <div class="d-flex align-items-center gap-2 mb-2">
                                @if ($product->sales_count > 50)
                                    <span class="badge bg-success">
                                        <i class="fas fa-crown me-1"></i>Top Seller
                                    </span>
                                @endif
                                <span class="badge bg-primary">{{ $product->game_type }}</span>
                            </div>

                            <!-- Seller Info -->
                            <div class="mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="seller-avatar me-2">
                                        @if ($product->seller && $product->seller->id && $product->seller->profile_photo)
                                            <img src="{{ asset('storage/' . $product->seller->profile_photo) }}"
                                                alt="{{ $product->seller_name }}" class="rounded-circle"
                                                style="width: 24px; height: 24px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary d-flex align-items-center justify-content-center rounded-circle"
                                                style="width: 24px; height: 24px;">
                                                <i class="fas fa-user fa-xs text-white"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <small class="text-muted d-block" style="font-size: 0.7rem;">Seller:</small>
                                        @if ($product->seller && $product->seller->id)
                                            <a href="{{ route('seller.profile', $product->seller->id) }}"
                                                class="seller-link-landscape text-decoration-none"
                                                onclick="event.stopPropagation();" style="font-size: 0.85rem;">
                                                <span class="text-white">{{ $product->seller_name }}</span>
                                                <i class="fas fa-external-link-alt ms-1" style="font-size: 0.6rem;"></i>
                                            </a>
                                        @else
                                            <span class="text-white"
                                                style="font-size: 0.85rem;">{{ $product->seller_name }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Rating and Sales -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="rating me-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($product->averageRating()))
                                                <i class="fas fa-star text-warning"></i>
                                            @elseif($i - 0.5 <= $product->averageRating())
                                                <i class="fas fa-star-half-alt text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <small class="text-muted">{{ number_format($product->averageRating(), 1) }}</small>
                                </div>
                                <small class="text-success">
                                    <i class="fas fa-shopping-cart me-1"></i>{{ number_format($product->sales_count) }}
                                    terjual
                                </small>
                            </div>

                            <div class="card-landscape-footer">
                                <div class="d-flex flex-column">
                                    @if (request('category') == 'top_seller' || $product->sales_count > 100)
                                        <span class="original-price-landscape">Rp
                                            {{ number_format($product->price * 2.22, 0, ',', '.') }}</span>
                                    @endif
                                    <span class="current-price-landscape">Rp
                                        {{ number_format($product->price, 0, ',', '.') }}</span>
                                </div>
                                <button class="btn-add-to-cart-landscape"
                                    onclick="event.stopPropagation(); addToCartLandscape({{ $product->id }})">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h3>Paket Robux tidak ditemukan</h3>
                        <p class="text-muted">Coba ubah kriteria pencarian Anda</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="row">
            <div class="col-12">
                <div class="pagination-info mb-3">
                    Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }}
                    results
                </div>
                {{ $products->links('pagination.bootstrap-5') }}
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h2>Mengapa Memilih JajanGaming?</h2>
                <p class="text-muted">Platform terpercaya untuk top up Robux Roblox</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-shield-alt fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title">100% Aman</h5>
                        <p class="card-text">Transaksi aman dengan enkripsi SSL dan sistem keamanan terbaik.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-bolt fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title">Proses Cepat</h5>
                        <p class="card-text">Robux langsung masuk ke akun Roblox Anda dalam hitungan menit.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-headset fa-3x text-primary"></i>
                        </div>
                        <h5 class="card-title">Support 24/7</h5>
                        <p class="card-text">Tim support siap membantu Anda kapan saja, setiap hari.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Sellers Section -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h2>Top Sellers</h2>
                <p class="text-muted">Penjual terpercaya dengan produk berkualitas</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12 text-center">
                <a href="{{ route('sellers.index') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-store me-2"></i>Lihat Semua Sellers
                </a>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Prevent card click when clicking seller link
        document.querySelectorAll('.seller-link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.stopPropagation();
                // Add visual feedback
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });

        // Prevent card click when clicking add to cart button
        document.querySelectorAll('.add-to-cart-btn').forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.stopPropagation();
                // Add visual feedback
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });

        // Prevent card click when clicking quantity input
        document.querySelectorAll('input[type="number"]').forEach(function(input) {
            input.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });

        // Prevent card click when clicking quantity selector
        document.querySelectorAll('.quantity-selector').forEach(function(selector) {
            selector.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });

        // Favorite button functionality
        document.querySelectorAll('.favorite-btn').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                toggleFavorite(this);
            });
        });
    });

    // Toggle favorite function
    function toggleFavorite(btn, productId) {
        event.stopPropagation();
        const icon = btn.querySelector('i');
        if (icon.classList.contains('far')) {
            icon.classList.remove('far');
            icon.classList.add('fas');
            btn.style.color = '#ff4757';
        } else {
            icon.classList.remove('fas');
            icon.classList.add('far');
            btn.style.color = '#ffffff';
        }
    }

    // Quantity control functions
    function increaseQuantity(productId) {
        const input = document.getElementById(`quantity-${productId}`);
        const currentValue = parseInt(input.value) || 1;
        input.value = currentValue + 1;

        // Add visual feedback
        const btn = event.target.closest('.quantity-btn');
        btn.style.transform = 'scale(0.9)';
        setTimeout(() => {
            btn.style.transform = '';
        }, 150);
    }

    function decreaseQuantity(productId) {
        const input = document.getElementById(`quantity-${productId}`);
        const currentValue = parseInt(input.value) || 1;
        const minValue = parseInt(input.min) || 1;

        if (currentValue > minValue) {
            input.value = currentValue - 1;

            // Add visual feedback
            const btn = event.target.closest('.quantity-btn');
            btn.style.transform = 'scale(0.9)';
            setTimeout(() => {
                btn.style.transform = '';
            }, 150);
        }
    }

    // Hero Carousel Functions
    let currentHeroSlide = 0;
    const heroSlides = document.querySelectorAll('.hero-slide');
    const totalHeroSlides = heroSlides.length;

    function changeHeroSlide(direction) {
        heroSlides[currentHeroSlide].classList.remove('active');
        currentHeroSlide += direction;

        if (currentHeroSlide >= totalHeroSlides) {
            currentHeroSlide = 0;
        } else if (currentHeroSlide < 0) {
            currentHeroSlide = totalHeroSlides - 1;
        }

        heroSlides[currentHeroSlide].classList.add('active');
    }

    // Auto-play carousel
    setInterval(() => {
        changeHeroSlide(1);
    }, 5000);

    // Upcoming Games Scroll
    function scrollUpcomingGames(direction) {
        const container = document.querySelector('.upcoming-games-container');
        const cardWidth = container.querySelector('.upcoming-game-card').offsetWidth;
        const gap = 24; // 1.5rem gap
        const scrollAmount = (cardWidth + gap) * direction;

        container.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
    }

    // Add to cart for landscape cards
    function addToCartLandscape(productId) {
        @auth
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('cart.add') }}';

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';

        const productInput = document.createElement('input');
        productInput.type = 'hidden';
        productInput.name = 'product_id';
        productInput.value = productId;

        const quantityInput = document.createElement('input');
        quantityInput.type = 'hidden';
        quantityInput.name = 'quantity';
        quantityInput.value = 1;

        form.appendChild(csrfToken);
        form.appendChild(productInput);
        form.appendChild(quantityInput);

        document.body.appendChild(form);
        form.submit();
    @else
        window.location.href = '{{ route('login') }}';
    @endauth
    }
</script>
