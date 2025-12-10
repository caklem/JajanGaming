@extends('layouts.app')

@section('title', $product->name . ' - JajanGaming')

@section('content')
    <style>
        .product-detail-container {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }

        .product-hero {
            background: rgba(42, 42, 62, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(0, 212, 170, 0.15);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .product-title {
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
            line-height: 1.3;
        }

        .product-subtitle {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.85rem;
            margin-bottom: 0;
            line-height: 1.5;
        }

        .product-main-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .product-image-wrapper {
            background: 
                repeating-linear-gradient(45deg, rgba(0, 212, 170, 0.03) 0px, rgba(0, 212, 170, 0.03) 10px, transparent 10px, transparent 20px),
                linear-gradient(135deg, rgba(26, 26, 46, 0.6) 0%, rgba(42, 42, 62, 0.6) 100%);
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(0, 212, 170, 0.2);
            transition: all 0.3s ease;
            position: relative;
            width: 100%;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
        }

        .product-image-wrapper::after {
            content: '';
            position: absolute;
            inset: -2px;
            background: linear-gradient(135deg, rgba(0, 212, 170, 0.4), rgba(0, 168, 204, 0.4), rgba(102, 126, 234, 0.4));
            border-radius: 16px;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
            filter: blur(20px);
        }

        .product-image-wrapper:hover {
            border-color: rgba(0, 212, 170, 0.4);
            transform: translateY(-3px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.5);
        }

        .product-image-wrapper:hover::after {
            opacity: 1;
        }

        .main-product-image {
            width: 100%;
            height: 100%;
            aspect-ratio: 5/3;
            object-fit: cover;
            object-position: center;
            display: block;
            position: relative;
            z-index: 1;
        }

        .image-info-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .info-card-mini {
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .info-card-mini:hover {
            background: rgba(0, 0, 0, 0.4);
            border-color: rgba(0, 212, 170, 0.3);
            transform: translateY(-2px);
        }

        .info-card-mini .icon {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .info-card-mini.stock .icon { color: #00d4aa; }
        .info-card-mini.rating .icon { color: #ffc107; }
        .info-card-mini.sales .icon { color: #667eea; }

        .info-card-mini .label {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.5);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }

        .info-card-mini .value {
            font-size: 1rem;
            font-weight: 700;
            color: #ffffff;
        }

        .product-sidebar {
            display: flex;
            flex-direction: column;
            gap: 0.7rem;
        }

        .price-card {
            background: rgba(0, 0, 0, 0.4);
            padding: 1.25rem;
            border-radius: 12px;
            border: 1px solid rgba(0, 212, 170, 0.25);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        }

        .price-label {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.7rem;
            margin-bottom: 0.3rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .product-price {
            color: #00d4aa;
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 10px rgba(0, 212, 170, 0.3);
        }

        .price-idr {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.75rem;
        }

        .rating-section {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.85rem;
            background: rgba(255, 193, 7, 0.1);
            border-radius: 10px;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .rating-stars {
            display: flex;
            gap: 0.25rem;
            font-size: 1rem;
        }

        .rating-stars i {
            color: #ffc107;
        }

        .rating-info {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.85rem;
            font-weight: 500;
        }

        .stock-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 0.85rem;
            background: rgba(0, 212, 170, 0.15);
            border-radius: 8px;
            color: #00d4aa;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .product-actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .btn-buy-now {
            background: linear-gradient(135deg, #00d4aa 0%, #00a8cc 100%);
            color: white;
            border: none;
            padding: 0.85rem 1rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 212, 170, 0.4);
            text-align: center;
            text-decoration: none;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-buy-now:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 212, 170, 0.5);
            color: white;
        }

        .btn-secondary-action {
            background: rgba(255, 255, 255, 0.05);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.2);
            padding: 0.75rem 1rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            display: block;
            font-size: 0.85rem;
        }

        .btn-secondary-action:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
            color: white;
            transform: translateY(-2px);
        }

        .product-meta-card {
            background: rgba(0, 0, 0, 0.3);
            padding: 1rem;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .meta-title {
            color: #ffffff;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            padding-bottom: 0.6rem;
            border-bottom: 2px solid rgba(0, 212, 170, 0.3);
        }

        .meta-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .meta-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .meta-label {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.75rem;
        }

        .meta-value {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            font-size: 0.75rem;
            text-align: right;
        }

        .description-section {
            background: rgba(42, 42, 62, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 1.75rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .section-title {
            color: #ffffff;
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title::before {
            content: '';
            width: 4px;
            height: 32px;
            background: linear-gradient(135deg, #00d4aa 0%, #00a8cc 100%);
            border-radius: 2px;
        }

        .description-text {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }

        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-list-item {
            padding: 1rem;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            margin-bottom: 0.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .info-list-item:hover {
            background: rgba(0, 0, 0, 0.3);
            transform: translateX(5px);
        }

        .info-list-item:last-child {
            margin-bottom: 0;
        }

        .info-label {
            color: rgba(255, 255, 255, 0.6);
            font-weight: 500;
        }

        .info-value {
            color: #ffffff;
            font-weight: 600;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .back-button:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(-5px);
        }

        @media (max-width: 992px) {
            .product-main-section {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .product-hero {
                padding: 1.25rem;
            }

            .product-title {
                font-size: 1.35rem;
            }

            .product-price {
                font-size: 1.5rem;
            }

            .main-product-image {
                aspect-ratio: 5/3;
            }
        }

        @media (max-width: 768px) {
            .product-hero {
                padding: 1.5rem;
            }

            .product-title {
                font-size: 1.75rem;
            }

            .main-product-image {
                height: 300px;
            }

            .product-price {
                font-size: 1.75rem;
            }

            .description-section {
                padding: 1.5rem;
            }
        }
    </style>

    <div class="product-detail-container">
        <div class="container">
            <!-- Hero Header -->
            <div class="product-hero">
                <h1 class="product-title">{{ $product->name }}</h1>
                <p class="product-subtitle">{{ $product->game_name }} - {{ $product->game_type }}</p>
            </div>

            <!-- Main Section -->
            <div class="product-main-section">
                <!-- Product Image -->
                <div>
                    <div class="product-image-wrapper">
                        <img src="{{ asset('img/' . $product->image) }}" alt="{{ $product->name }}" class="main-product-image">
                    </div>
                    
                    <!-- Info Cards Below Image -->
                    <div class="image-info-cards">
                        <div class="info-card-mini stock">
                            <i class="fas fa-box icon"></i>
                            <div class="label">Stock</div>
                            <div class="value">{{ $product->stock }}</div>
                        </div>
                        <div class="info-card-mini rating">
                            <i class="fas fa-star icon"></i>
                            <div class="label">Rating</div>
                            <div class="value">{{ number_format($product->ratings_avg_rating ?? 0, 1) }}</div>
                        </div>
                        <div class="info-card-mini sales">
                            <i class="fas fa-fire icon"></i>
                            <div class="label">Sold</div>
                            <div class="value">{{ $product->total_sold ?? 0 }}</div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="product-sidebar">
                    <!-- Price Card -->
                    <div class="price-card">
                        <div class="price-label">Harga</div>
                        <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                        <div class="price-idr">${{ number_format($product->price / 15000, 2) }} USD</div>
                    </div>

                    <!-- Rating -->
                    <div class="rating-section">
                        <div class="rating-stars">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= floor($product->averageRating()))
                                    <i class="fas fa-star"></i>
                                @elseif($i - 0.5 <= $product->averageRating())
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <div class="rating-info">
                            <strong>{{ number_format($product->averageRating(), 1) }}</strong>
                            ({{ $product->totalRatings() }} reviews)
                        </div>
                    </div>

                    <!-- Stock Badge -->
                    <div>
                        <span class="stock-badge">
                            <i class="fas fa-check-circle"></i>
                            {{ $product->quantity }} In Stock
                        </span>
                    </div>

                    <!-- Actions -->
                    @auth
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">

                            <div class="product-actions">
                                <button type="submit" class="btn-buy-now">
                                    <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                </button>
                                <a href="{{ route('home') }}" class="btn-secondary-action">
                                    <i class="fas fa-heart me-2"></i>Add to Wishlist
                                </a>
                            </div>
                        </form>
                    @else
                        <div class="product-actions">
                            <a href="{{ route('login') }}" class="btn-buy-now">
                                <i class="fas fa-sign-in-alt me-2"></i>Login to Purchase
                            </a>
                        </div>
                    @endauth

                    <!-- Product Meta -->
                    <div class="product-meta-card">
                        <h3 class="meta-title">Product Information</h3>
                        <div class="meta-row">
                            <span class="meta-label">Game</span>
                            <span class="meta-value">{{ $product->game_name }}</span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">Type</span>
                            <span class="meta-value">{{ $product->game_type }}</span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">Seller</span>
                            <span class="meta-value">{{ $product->seller_name }}</span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-label">Total Sales</span>
                            <span class="meta-value">{{ number_format($product->sales_count) }} sold</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description Section -->
            <div class="description-section">
                <h2 class="section-title">About This Product</h2>
                <p class="description-text">
                    {{ $product->description ?? $product->name . ' adalah paket ' . $product->game_type . ' untuk ' . $product->game_name . '. Dapatkan dengan harga terbaik dan proses yang cepat. Top up mudah, aman, dan terpercaya untuk kebutuhan gaming Anda.' }}
                </p>

                <h3 class="section-title">Product Details</h3>
                <ul class="info-list">
                    <li class="info-list-item">
                        <span class="info-label">
                            <i class="fas fa-gamepad me-2"></i>Game
                        </span>
                        <span class="info-value">{{ $product->game_name }}</span>
                    </li>
                    <li class="info-list-item">
                        <span class="info-label">
                            <i class="fas fa-tag me-2"></i>Category
                        </span>
                        <span class="info-value">{{ $product->game_type }}</span>
                    </li>
                    <li class="info-list-item">
                        <span class="info-label">
                            <i class="fas fa-boxes me-2"></i>Stock Available
                        </span>
                        <span class="info-value">{{ $product->quantity }} units</span>
                    </li>
                    <li class="info-list-item">
                        <span class="info-label">
                            <i class="fas fa-shopping-bag me-2"></i>Total Purchases
                        </span>
                        <span class="info-value">{{ number_format($product->sales_count) }} transactions</span>
                    </li>
                    <li class="info-list-item">
                        <span class="info-label">
                            <i class="fas fa-calendar-alt me-2"></i>Listed Date
                        </span>
                        <span class="info-value">{{ $product->created_at->format('F d, Y') }}</span>
                    </li>
                </ul>
            </div>

            <!-- Back Button -->
            <div class="mt-4 mb-4">
                <a href="{{ route('home') }}" class="back-button">
                    <i class="fas fa-arrow-left"></i>
                    Back to Products
                </a>
            </div>
        </div>
    </div>
@endsection
