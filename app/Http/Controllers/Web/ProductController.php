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
    public function shop(Request $request, $slug = null)
    {
        // return $cart = session()->get('cart');
        $data['title'] = 'Shop';
        if (!empty($slug)) {
            // $data['title'] = $slug;
            $data['categories'] = Category::where('status', '1')->where('id', $id)->get();
        } else {
            $data['categories'] = Category::where('is_delete', '0')->where('status', '1')->get();
        }
        // return $data['categories'];
        return view('web.products.shop', $data);
    }

    public function list(Request $request)
    {
        $query = Product::withAvg('reviews', 'rating');

        if (!empty($request->category)) {
            $query->where('category', $request->category);
        }

        if (!empty($request->filters)) {

            if (!empty($request->filters['color'])) {
                $colors = $request->filters['color'];

                $query->where(function ($q) use ($colors) {
                    foreach ($colors as $color) {
                        $q->orWhereJsonContains('variant_data', ['color' => $color]);
                    }
                });
            }

            // 🔵 Size filter (array case)
            if (!empty($request->filters['size'])) {
                $sizes = $request->filters['size'];

                $query->where(function ($q) use ($sizes) {
                    foreach ($sizes as $size) {
                        $q->orWhereJsonContains('variant_data->1->size', $size);
                    }
                });
            }

            // 🔵 Price filter
            if (!empty($request->filters['price'])) {

                $prices = priceRange();

                foreach ($prices as $key => $range) {
                    $ranges = explode(' - ', $range);
                    $prices[$key] = [(int)$ranges[0], (int)$ranges[1]];
                }

                $selectedPrices = array_intersect_key($prices, array_flip($request->filters['price']));

                if (!empty($selectedPrices)) {
                    $query->where(function ($q) use ($selectedPrices) {
                        foreach ($selectedPrices as $range) {
                            $q->orWhereBetween('price', $range); // fallback
                        }
                    });
                }
            }
        }

        $products = $query->paginate(12);

        $html = '';

        if ($products->isEmpty()) {
            $html .= '<div class="col-12">
            <h3 class="text-center">No products found.</h3>
        </div>';
        } else {

            foreach ($products as $product) {

                // ✅ get first image safely
                $images = $product->variant_images ?? [];
                $firstImage = 'default.png';

                if (is_array($images)) {
                    $flat = [];
                    foreach ($images as $imgArr) {
                        if (is_array($imgArr)) {
                            $flat = array_merge($flat, $imgArr);
                        }
                    }
                    $firstImage = $flat[0] ?? 'default.png';
                }

                $html .= '<div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                <div class="product-item bg-light mb-4">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="' . asset('uploads/products/' . $firstImage) . '" alt="Product">
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href="' . route('web.products.details', $product->id) . '">' . ucwords($product->title) . '</a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5>₹' . ($product->price ?? 0) . '</h5>
                        </div>
                    </div>
                </div>
            </div>';
            }
        }

        return response()->json(['html' => $html]);
    }


    public function details(Request $request)
    {
        $data['title'] = 'Shop';
        $data['productData'] = Product::withAvg('reviews', 'rating')->find($id);
        $data['relatedProducts'] = Product::withAvg('reviews', 'rating')->where('cat_id', $data['productData']->cat_id)->where('id', '!=', $id)->latest()->limit(8)->get();
        $data['variant_data'] = $data['productData']->variant_data ?? [];
        $data['variant_images'] = $data['productData']->variant_images ?? [];
        // return $data['productData']->variant_data ?? [];
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

        $modal = new Review();
        $modal->pid  = $request->product_id;
        $modal->user_id  = Auth::user() ? Auth::user()->id : '';
        $modal->user_name = Auth::user() ? Auth::user()->name : $request->user_name;
        $modal->email = Auth::user() ? Auth::user()->email : $request->email;
        $modal->rating = $request->stars;
        $modal->reviews = $request->reviews;
        $modal->save();
        return response()->json(['status' => 'success', 'message' => 'Review saved successfully']);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $quantity = $request->input('quantity', 1);
        $product = Product::find($request->product_id);

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
