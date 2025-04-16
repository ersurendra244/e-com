<?php

namespace App\Http\Controllers\Web;

use App\Models\Cart;
use App\Models\Review;
use App\Models\Product;
use App\Models\Variant;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function shop(Request $request)
    {
        // return $cart = session()->get('cart');
        $data['title'] = 'Shop';
        $data['categories'] = Category::where('status', '1')->get();
        return view('web.products.shop', $data);
    }

    public function list(Request $request)
    {
        $query = Product::with('variants')->withAvg('reviews', 'rating');

        // Variant filtering
        $query->whereHas('variants', function ($variantQuery) use ($request) {
            // Price filter
            if (!empty($request->filters['price'])) {
                $prices = priceRange();
                foreach ($prices as $key => $range) {
                    $ranges = explode(' - ', $range);
                    $prices[$key] = [$ranges[0], $ranges[1]];
                }
                $selectedPrices = array_intersect_key($prices, array_flip($request->filters['price']));

                if (!empty($selectedPrices)) {
                    $variantQuery->where(function ($q) use ($selectedPrices) {
                        foreach ($selectedPrices as $range) {
                            $q->orWhereBetween('price', $range);
                        }
                    });
                }
            }

            // Color filter
            if (!empty($request->filters['color'])) {
                $variantQuery->whereIn('color', $request->filters['color']);
            }

            // Size filter
            if (!empty($request->filters['size'])) {
                $variantQuery->whereIn('size', $request->filters['size']);
            }
        });

        // Category filter (apply to product itself)
        if (!empty($request->filters['category'])) {
            $query->whereIn('category', $request->filters['category']);
        }

        // Pagination
        $page = $request->input('page', 1);
        $products = $query->paginate(12, ['*'], 'page', $page);

        // HTML generation (same as your current one)
        $html = '';
        if ($products->isEmpty()) {
            $html .= '<div class="col-12">
                <h3 class="text-center">No products found.</h3>
            </div>';
        } else {
            foreach ($products as $product) {
                $image = $product->images[0] ?? 'default.png';
                $html .= '<div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="' . asset('uploads/products/' . $image) . '" alt="Product">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href="#"><i class="far fa-heart"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="' . route('web.products.details', $product->id) . '">' . ucwords($product->name) . '</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>₹' . $product->variants[0]->price . '</h5>
                                <h6 class="text-muted ml-2"><del>₹' . ($product->variants[0]->price + 500) . '</del></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">';
                                $rating = ceil($product->reviews_avg_rating);

                                for ($i = 1; $i <= 5; $i++){
                                    if ($i <= $rating){
                                        $html .= '<small class="fa fa-star text-warning mr-1"></small>';
                                    }else{
                                        $html .= '<small class="fa fa-star text-secondary mr-1"></small>';
                                    }
                                }

                            $html .= '</div>
                        </div>
                    </div>
                </div>';
            }

            // Pagination links
            $html .= '<div class="col-12"><nav><ul class="pagination justify-content-center">';
            if ($products->previousPageUrl()) {
                $html .= '<li class="page-item"><a class="page-link filter-pagination" href="#" data-page="' . ($products->currentPage() - 1) . '">Previous</a></li>';
            }
            for ($i = 1; $i <= $products->lastPage(); $i++) {
                $active = $products->currentPage() == $i ? 'active' : '';
                $html .= '<li class="page-item ' . $active . '"><a class="page-link filter-pagination" href="#" data-page="' . $i . '">' . $i . '</a></li>';
            }
            if ($products->nextPageUrl()) {
                $html .= '<li class="page-item"><a class="page-link filter-pagination" href="#" data-page="' . ($products->currentPage() + 1) . '">Next</a></li>';
            }
            $html .= '</ul></nav></div>';
        }

        return response()->json(['html' => $html]);
    }


    public function details(Request $request, $id)
    {
        $data['title'] = 'Shop';
        $data['productData'] = Product::with('variants')->withAvg('reviews', 'rating')->find($id);
        $data['relatedProducts'] = Product::with('variants')->withAvg('reviews', 'rating')->where('category', $data['productData']->category)->where('id', '!=', $id)->latest()->limit(8)->get();
        // return $data['productData'];
        return view('web.products.details', $data);
    }

    public function getSizesByColor(Request $request)
    {
        $color = $request->color;
        $productId = $request->product_id;

        $variants = Variant::where('product_id', $productId)
                    ->where('color', $color)
                    ->get();
        $sizes = $variants->pluck('size')->unique()->values();
                    return $sizes;

        return response()->json([
            'sizes' => $sizes,
        ]);
    }

    public function reviews_save(Request $request)
    {
        $rules = [
            'stars'   => 'required|integer|min:1|max:5',
            'reviews' => 'required|string',
        ];
        if (!Auth::user()) {
            $rules['user_name'] = 'required|string|max:255';
            $rules['email']     = 'required|email|max:255';
        }
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }

        $model = new Review();
        $model->pid  = $request->product_id;
        $model->user_id  = Auth::user()?Auth::user()->id:'';
        $model->user_name = Auth::user()?Auth::user()->name:$request->user_name;
        $model->email = Auth::user()?Auth::user()->email:$request->email;
        $model->rating = $request->stars;
        $model->reviews = $request->reviews;
        $model->save();
        return response()->json(['status' => 'success', 'message' => 'Review saved successfully']);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $quantity = $request->input('quantity', 1);
        $product = Product::with('variants')->find($request->product_id);

        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Product not found']);
        }

        $variant = $product->variants->first(); // assuming variants relationship exists
        if (!$variant) {
            return response()->json(['status' => 'error', 'message' => 'No variant found for product']);
        }

        // Optional: If user is logged in
        $userId = auth()->id() ?? null;

        // Check if the same product is already in the cart for this user
        $cartItem = Cart::where('user_id', $userId)
                        ->where('product_id', $product->id)
                        ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $variant->price,
                // 'variant_id' => $variant->id, // Uncomment if you have this in your table
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Product added to cart successfully',
        ]);
    }


}
