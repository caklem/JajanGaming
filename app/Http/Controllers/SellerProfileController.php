<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Rating;
use Illuminate\Http\Request;

class SellerProfileController extends Controller
{
    public function show($sellerId)
    {
        $seller = User::where('id', $sellerId)
            ->where('role', 'seller')
            ->firstOrFail();

        // Get seller's products with pagination
        $products = Product::where('seller_id', $seller->id)
            ->where('is_active', true)
            ->with(['ratings'])
            ->paginate(12);

        // Calculate seller statistics
        $totalProducts = Product::where('seller_id', $seller->id)->count();
        $activeProducts = Product::where('seller_id', $seller->id)->where('is_active', true)->count();
        
        // Get orders that contain this seller's products
        $sellerOrders = Order::whereHas('orderItems.product', function($query) use ($seller) {
            $query->where('seller_id', $seller->id);
        })->with(['orderItems.product'])->get();

        $totalOrders = $sellerOrders->count();
        $completedOrders = $sellerOrders->where('status', 'completed')->count();
        $totalRevenue = $sellerOrders->where('status', 'completed')->sum('total_amount');
        
        // Calculate success rate (percentage of completed orders)
        $successRate = $totalOrders > 0 ? round(($completedOrders / $totalOrders) * 100) : 0;
        
        // Calculate average delivery time (in hours) - using order completion time
        $avgDeliveryHours = 0;
        if ($completedOrders > 0) {
            $completedOrderTimes = $sellerOrders->where('status', 'completed')
                ->whereNotNull('updated_at')
                ->map(function($order) {
                    return $order->created_at->diffInHours($order->updated_at);
                });
            $avgDeliveryHours = $completedOrderTimes->avg() ?? 0;
        }
        
        // Get unique buyers count (last 2 weeks)
        $twoWeeksAgo = now()->subWeeks(2);
        $uniqueBuyers = $sellerOrders->where('created_at', '>=', $twoWeeksAgo)
            ->pluck('user_id')
            ->unique()
            ->count();
        
        // Calculate total sales count for all seller's products
        $totalSales = Product::where('seller_id', $seller->id)->sum('sales_count');
        
        // Calculate ratings using Rating records (not dummy)
        $ratingsBaseQuery = Rating::whereHas('product', function($query) use ($seller) {
            $query->where('seller_id', $seller->id);
        });

        $totalRatings = (clone $ratingsBaseQuery)->count();
        $averageRating = (float) number_format(((clone $ratingsBaseQuery)->avg('rating') ?? 0), 2, '.', '');

        // Distribution 5..1 stars
        $ratingDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $ratingDistribution[$i] = (clone $ratingsBaseQuery)->where('rating', $i)->count();
        }

        // Get recent orders (last 10)
        $recentOrders = $sellerOrders->sortByDesc('created_at')->take(10);

        // Get top selling products
        $topProducts = Product::where('seller_id', $seller->id)
            ->where('is_active', true)
            ->orderBy('sales_count', 'desc')
            ->take(5)
            ->get();

        return view('seller.profile', compact(
            'seller',
            'products',
            'totalProducts',
            'activeProducts',
            'totalOrders',
            'completedOrders',
            'totalRevenue',
            'totalSales',
            'averageRating',
            'totalRatings',
            'ratingDistribution',
            'recentOrders',
            'topProducts',
            'successRate',
            'avgDeliveryHours',
            'uniqueBuyers'
        ));
    }

    public function index()
    {
        // Get all sellers with their statistics
        $sellers = User::where('role', 'seller')
            ->withCount(['products' => function($query) {
                $query->where('is_active', true);
            }])
            ->get()
            ->map(function($seller) {
                // Calculate total sales count for all seller's products
                $seller->total_sales = Product::where('seller_id', $seller->id)->sum('sales_count');
                
                // Calculate average rating from Rating model (actual reviews)
                $seller->average_rating = Rating::whereHas('product', function($query) use ($seller) {
                    $query->where('seller_id', $seller->id);
                })->avg('rating') ?? 0;
                
                // Get total number of ratings
                $seller->total_ratings = Rating::whereHas('product', function($query) use ($seller) {
                    $query->where('seller_id', $seller->id);
                })->count();
                
                return $seller;
            })
            ->sortByDesc('total_sales');

        return view('seller.index', compact('sellers'));
    }
}