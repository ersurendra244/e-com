<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Models\Review;
use App\Models\Product;
use App\Models\Variant;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $data['title'] = 'Products';
        return view('admin.products.index', $data);
    }

    public function list(Request $request)
    {
        $columns = ['id', 'images', 'pid', 'title', 'category', 'subcategory', 'price', 'status'];

        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);
        $orderIndex = $request->input('order.0.column', 0);
        $order = $columns[$orderIndex] ?? 'id';
        $dir = $request->input('order.0.dir', 'asc');

        $query = Product::with(['category', 'subcategory']);
        $totalData = $query->count();
        $search = $request->input('search.value');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('title', 'LIKE', "%{$search}%")
                    ->orWhere('pid', 'LIKE', "%{$search}%");
            });
        }

        $totalFiltered = $query->count();

        $products = $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = [];
        foreach ($products as $value) {
            $image = $value->images[0] ?? '';
            // $variants = Variant::where('product_id', $value->id)->count();
            $total_variants = $value->variants()->count();
            $nestedData['id'] = $value->id;
            $nestedData['image'] = '<img class="img-sm rounded" style="height: 75px; width: auto;" src="' . is_image('uploads/products/', $value->image) . '" alt=""/>';
            $nestedData['pid'] = $value->pid;
            $nestedData['title'] = '<b>' . e($value->pid) . '</b><br>' .
                e($value->title) . '<br>' .
                '₹' . number_format($value->price, 2) . ' / <s>₹' . number_format($value->base_price, 2) . '</s>';

            $nestedData['category'] = $value->category->name ?? '';
            // $nestedData['category'] = $value->category->name ?? '' . ' <br> ' . $value->subcategory->name ?? '';
            $nestedData['price'] = $value->price;
            $status = $value->status == 1 ? '<label class="badge badge-outline-success badge-pill py-1">Active</label>' : '<label class="badge badge-outline-danger badge-pill py-1">Inactive</label>';
            $nestedData['status'] = $status;
            $collections = '<div class="form-group mb-0">';
            $collections .= '<div class="form-check">
                                <label class="form-check-label">
                                <input ' . ($value->is_featured == 1 ? 'checked' : '') . ' type="checkbox" class="form-check-input" name="is_featured" value="1">
                                    Featured<i class="input-helper"></i></label>
                            </div>';
            $collections .= '<div class="form-check">
                                <label class="form-check-label">
                                <input ' . ($value->is_trending == 1 ? 'checked' : '') . ' type="checkbox" class="form-check-input" name="is_tranding" value="1">
                                    Trending<i class="input-helper"></i></label>
                            </div>';
            $collections .= '</div>';
            $nestedData['collections'] = $collections;
            $actions = '<div class="dropdown">
                        <button class="dropbtn"><i class="fas fa-ellipsis-v"></i></button>
                        <div class="dropdown-content">';
            if (Gate::allows('product edit')) {
                $actions .= '<a href="' . roleRoute('products.edit', ['id' => $value->id]) . '" class="text-primary">Edit</a> ';
            }
            if (Gate::allows('product review')) {
                $actions .= '<a href="' . roleRoute('products.reviews', ['id' => $value->id]) . '" class="text-warning">Reviews</a> ';
            }
            if (Gate::allows('product delete')) {
                $actions .= '<a href="javascript:void(0)" onclick="deleteData(`' . roleRoute('products.delete', ['id' => $value->id]) . '`)" class="text-danger">Delete</a>';
            }
            $actions .= '</div></div>';
            $nestedData['action'] = $actions;
            $data[] = $nestedData;
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ];

        return response()->json($json_data);
    }

    public function create(Request $request)
    {
        $data['title'] = 'Add Product';
        $data['subtitle'] = 'Products';
        $data['categories'] = Category::where('parent_id', '0')->where('is_delete', '0')->where('status', '1')->get();
        return view('admin.products.create', $data);
    }

    public function edit(Request $request)
    {
        $data['title'] = 'Edit Product';
        $data['subtitle'] = 'Products';
        $data['edit_data'] = Product::with('variants')->find($id);
        $data['categories'] = Category::where('parent_id', '0')->where('is_delete', '0')->where('status', '1')->get();
        // return $data['categories'];
        return view('admin.products.edit', $data);
    }

    public function save(Request $request)
    {
        // return $request->all();
        // $validator = Validator::make($request->all(), [
        //     'title' => 'required|string|max:255',
        //     'main_category' => 'required|integer',
        //     'category' => 'required|integer',
        //     'subcategory' => 'required|integer',
        //     'item_type' => 'required|integer',
        //     'price' => 'nullable|numeric',
        //     'color.*' => 'nullable|string',
        //     'size.*' => 'nullable|string',
        //     'quantity.*' => 'nullable|numeric|min:0',
        // ]);

        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'main_category' => 'required|integer',
            'category' => 'required|integer',
            'subcategory' => 'required|integer',
            'price' => 'nullable|numeric',
            'color.*' => 'nullable|string',
            'size.*' => 'nullable|string',
            'quality.*' => 'nullable|string',
            'resolution.*' => 'nullable|string',
            'quantity.*' => 'nullable|numeric|min:0',
        ]);
        $validator->after(function ($validator) use ($request) {
    $variantFields = SubCategory::find($request->subcategory)->form_fields ?? [];
    $hasVariant = false;

    foreach ($variantFields as $field) {
        $values = $request->input($field, []);
        foreach ($values as $val) {
            if (!is_null($val) && $val !== '') {
                $hasVariant = true;
                break 2; // exit both loops
            }
        }
    }

    if (!$hasVariant) {
        // सभी dynamic fields के नीचे same message दिखेगा
        foreach ($variantFields as $field) {
            $validator->errors()->add($field, 'This field is required.');
        }
    }
});
        // $validator->after(function ($validator) use ($request) {
        //     $variantFields = SubCategory::find($request->subcategory)->form_fields ?? [];
        //     $hasVariant = false;

        //     foreach ($variantFields as $field) {
        //         $values = $request->input($field, []);
        //         foreach ($values as $val) {
        //             if (!is_null($val) && $val !== '') {
        //                 $hasVariant = true;
        //                 break 2; // exit both loops
        //             }
        //         }
        //     }

        //     if (!$hasVariant) {
        //         $validator->errors()->add('variant', 'At least one variant field must be filled out.');
        //     }
        // });
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        return response()->json(['success' => true, 'message' => 'Product saved successfully!']);
        // if ($validator->fails()) {
        //     return redirect()->back()->withErrors($validator)->withInput();
        // }

        $product = new Product();
        $product->pid               = generatePID();
        $product->title             = $request->title;
        $product->slug              = slug($request->title);
        $product->sub_title         = $request->sub_title;
        $product->main_category     = $request->main_category;
        $product->category          = $request->category;
        $product->subcategory       = $request->subcategory;
        $product->price             = $request->price;
        $product->base_price        = $request->base_price;
        $product->description       = $request->description;
        $product->highlights        = $request->highlights;
        $product->specifications    = $request->specifications;
        $product->is_featured       = $request->is_featured ? '1' : '0';
        $product->is_trending       = $request->is_trending ? '1' : '0';
        $product->status            = $request->status;
        // if ($request->hasFile('image')) {
        //     removeImage($product->image, 'uploads/products');
        //     $image = $request->file('image');
        //     $imageName = time() . '.' . $image->getClientOriginalExtension();
        //     $image->move(public_path('uploads/products'), $imageName);
        //     $product->image = $imageName;
        // }
        // $product->save();


        // if (!empty($request->color)) {
        //     foreach ($request->color as $index => $color) {
        //         $variant = new Variant();
        //         $variant->product_id = $product->id;
        //         $variant->color      = $color ?? null;
        //         $variant->size       = $request->size[$index] ?? null;
        //         $variant->quantity   = $request->quantity[$index] ?? 0;
        //         $variant->status     = $request->status;
        //         $imagePaths = [];

        //         if ($request->hasFile("images.$index")) {
        //             foreach ($request->file("images")[$index] as $image) {
        //                 $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
        //                 $image->move(public_path('uploads/products'), $imageName);
        //                 $imagePaths[] = $imageName;
        //             }
        //         }
        //         $variant->images = $imagePaths ?? [];
        //         $variant->save();
        //     }
        // }

        // if (!empty($request->stars)) {
        //     $ratings = new Review();
        //     $ratings->product_id    = $product->id;
        //     $ratings->user_id       = Auth::user()->id;
        //     $ratings->user_name     = Auth::user()->name;
        //     $ratings->email         = Auth::user()->email;
        //     $ratings->reviews       = $request->reviews;
        //     $ratings->rating        = $request->stars;
        //     $ratings->save();
        // }
        // Session::flash('success', 'Product saved successfully');
        return redirect(roleRoute('products'))->with('success', 'Product saved successfully');
    }
    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'main_category' => 'required|integer',
            'category' => 'required|integer',
            'subcategory' => 'required|integer',
            'price' => 'nullable|numeric',
            'color.*' => 'nullable|string',
            'size.*' => 'nullable|string',
            'quantity.*' => 'nullable|numeric|min:0',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $product = Product::find($id);
        $product->pid               = generatePID();
        $product->title             = $request->title;
        $product->slug              = slug($request->title);
        $product->sub_title         = $request->sub_title;
        $product->main_category     = $request->main_category;
        $product->category          = $request->category;
        $product->subcategory       = $request->subcategory;
        $product->price             = $request->price;
        $product->base_price        = $request->base_price;
        $product->description       = $request->description;
        $product->highlights        = $request->highlights;
        $product->specifications    = $request->specifications;
        $product->is_featured       = $request->is_featured ? '1' : '0';
        $product->is_trending       = $request->is_trending ? '1' : '0';
        $product->status            = $request->status;
        if ($request->hasFile('image')) {
            removeImage($product->image, 'uploads/products');
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imageName);
            $product->image = $imageName;
        }
        $product->save();

        // Update variants

        if (!empty($request->color)) {
            foreach ($request->color as $index => $color) {
                $variant_id = $request->variant_id[$index] ?? null;
                $variant = Variant::where('id', $variant_id)->firstOrNew();
                $variant->product_id = $product->id;
                $variant->color      = $color ?? null;
                $variant->size       = $request->size[$index] ?? null;
                $variant->quantity   = $request->quantity[$index] ?? 0;
                $variant->status     = $request->status;
                $imagePaths = [];

                if ($request->hasFile("images.$index")) {
                    foreach ($request->file("images")[$index] as $image) {
                        $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('uploads/products'), $imageName);
                        removeImage($variant->image, 'uploads/products');
                        $imagePaths[] = $imageName;
                    }
                    // Purani images sirf tab remove karein jab naye image aaye ho (optional logic)
                    if ($variant->exists && is_array($variant->images)) {
                        foreach ($variant->images as $oldImage) {
                            removeImage($oldImage, 'uploads/products');
                        }
                    }
                }
                // Merge karna tab hi chahiye jab new image aayi ho + purani bhi rakhi ja rahi ho
                if ($variant->exists && is_array($variant->images)) {
                    $existingImages = $variant->images ?? [];
                    $imagePaths = array_merge($existingImages, $imagePaths);
                }
                $variant->images = $imagePaths ?? [];
                $variant->save();
            }
        }
        // Ratings
        if (!empty($request->stars)) {
            $ratings = new Review();
            $ratings->pid   = $product->id;
            $ratings->user_id   = Auth::user()->id;
            $ratings->user_name = Auth::user()->name;
            $ratings->email = Auth::user()->email;
            $ratings->reviews   = $request->reviews;
            $ratings->rating    = $request->stars;
            $ratings->save();
            // return $ratings;
        }
        return redirect(roleRoute('products'))->with('success', 'Product updated successfully');
    }
    public function delete(Request $request)
    {
        $modal = Product::find($id);
        if ($modal) {
            $modal->status = '0';
            $modal->is_delete = '1';
            $modal->save();
            removeImage($modal->image, 'uploads/products');
            Session::flash('success', 'Product deleted successfully');
            return response()->json(['success' => true]);
        }
        Session::flash('error', 'Product not found');
        return response()->json(['success' => false]);
    }
    public function variants_image_delete(Request $request)
    {
        $image = $request->image;
        $id = $request->variant_id;

        $variant = Variant::where('id', $id)
            ->whereJsonContains('images', $image)
            ->first();

        if ($variant) {
            // Remove image from filesystem
            $filePath = public_path('uploads/products/' . $image);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Remove image from DB (images array)
            $images = array_filter($variant->images, fn($img) => $img !== $image);
            $variant->images = array_values($images); // re-index
            $variant->save();
            Session::flash('success', 'Image deleted successfully');
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Image not found']);
    }

    public function variants_delete(Request $request)
    {
        $id = $request->variant_id;
        $modal = Variant::find($id);

        if ($modal) {
            $image = $modal->image;

            if (!empty($image)) {
                $filePath = public_path('uploads/products/' . $image);

                // Ensure it's a file, not a directory
                if (file_exists($filePath) && is_file($filePath)) {
                    unlink($filePath);
                }
            }

            $modal->delete(); // You forgot to delete the variant
            Session::flash('success', 'Variant deleted successfully');
            return response()->json(['success' => true]);
        }

        Session::flash('error', 'Variant not found');
        return response()->json(['success' => false]);
    }


    public function reviews($id)
    {
        $data['pid'] = $id;
        $data['title'] = 'Reviews';
        $data['subtitle'] = 'Products';
        return view('admin.products.reviews', $data);
    }

    public function reviews_list(Request $request)
    {
        $columns = ['id', 'pid', 'email', 'user_name', 'reviews', 'rating', 'created_at'];
        $pid = $request->pid;
        $query = Review::with('product')->where('pid', $pid);
        $totalData = $query->count();
        $totalFiltered = $totalData;
        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);
        $orderIndex = $request->input('order.0.column', 0);
        $order = $columns[$orderIndex] ?? 'id';
        $dir = $request->input('order.0.dir', 'asc');

        // Handle search functionality
        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');

            // Clone base query for filtered count
            $filteredQuery = clone $query;

            $query->where(function ($query) use ($search) {
                $query->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('user_name', 'LIKE', "%{$search}%")
                    ->orWhere('reviews', 'LIKE', "%{$search}%")
                    ->orWhere('rating', 'LIKE', "%{$search}%");
            });

            $totalFiltered = $filteredQuery->where(function ($query) use ($search) {
                $query->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('user_name', 'LIKE', "%{$search}%")
                    ->orWhere('reviews', 'LIKE', "%{$search}%")
                    ->orWhere('rating', 'LIKE', "%{$search}%");
            })->count();
        }

        $reviews = $query->offset($start)->limit($limit)->orderBy($order, $dir)->get();
        $data = [];
        foreach ($reviews as $review) {
            $nestedData['id'] = $review->id;
            $nestedData['product'] = $review->product->name ?? 'N/A';
            $nestedData['user'] = '<div>Name: ' . $review->user_name . '<br>Email: ' . $review->email . '</div>';
            $nestedData['reviews'] = '<div>' . $review->reviews . '</div>';
            $nestedData['reviews'] .= '<div class="ratings mt-2">';
            for ($i = 1; $i <= 5; $i++) {
                $nestedData['reviews'] .= '<i class="fa fa-star ' . ($i <= $review->rating ? 'gold' : 'gray') . '"></i>';
            }
            $nestedData['reviews'] .= '</div>';
            $nestedData['created_at'] = date('d-m-Y', strtotime($review->created_at));
            $data[] = $nestedData;
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ];

        return response()->json($json_data);
    }

    public function get_categories(Request $request)
    {
        $categories = Category::where('parent_id', $request->main_category)
            ->where('is_delete', '0')
            ->where('status', '1')
            ->select('id', 'name')
            ->get();
        // print_r($categories); exit;
        $product = Product::find($request->product_id);

        $html = '<option value="">--select--</option>';

        if ($categories->count() > 0) {
            foreach ($categories as $value) {
                $selected = ($product && $value->id == $product->category) ? 'selected' : '';
                $html .= '<option ' . $selected . ' value="' . $value->id . '">' . e($value->name) . '</option>';
            }
        } else {
            $html .= '<option value="">No Categories Found</option>';
        }

        return response()->json(['success' => true, 'html' => $html]);
    }

    public function get_sub_categories(Request $request)
    {
        $subcategories = SubCategory::where('category', $request->category)
            ->where('status', '1')
            ->where('is_delete', '0')
            ->select('id', 'name')
            ->get();

        $product = Product::find($request->product_id);

        $html = '<option value="">--select--</option>';

        if ($subcategories->count() > 0) {
            foreach ($subcategories as $value) {
                $selected = ($product && $value->id == $product->subcategory) ? 'selected' : '';
                $html .= '<option ' . $selected . ' value="' . $value->id . '">' . e($value->name) . '</option>';
            }
        } else {
            $html .= '<option value="">No Subcategories Found</option>';
        }

        return response()->json(['success' => true, 'html' => $html]);
    }

    public function get_form_fields(Request $request)
    {
        $html = '';
        $data['edit_data'] = Product::with('variants')->find($request->product_id);
        $data['subcategory'] = SubCategory::find($request->subcategory);
        $data['fields'] = $data['subcategory']->form_fields ?? [];
        if (!empty($data['fields'])) {
            $html = view('admin.products.form_fields', $data)->render();
        }
        return response()->json(['success' => true, 'html' => $html]);
    }
}
