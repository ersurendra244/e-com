<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Models\Review;
use App\Models\Product;
use App\Models\Variant;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\SubCategoryField;
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
        $columns = ['id', 'images', 'pid', 'title', 'main_cat_id', 'cat_id', 'sub_cat_id', 'price', 'status'];

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

            $nestedData['id'] = $value->id;
            $nestedData['image'] = '<img class="img-sm rounded" style="height: 75px; width: auto;" src="' . is_image('uploads/products/', $value->image) . '" alt=""/>';
            $nestedData['pid'] = $value->pid;
            $nestedData['title'] = '<b>' . e($value->pid) . '</b><br>' . e($value->title) . '<br>' . '₹' . number_format($value->price, 2) . ' / <s>₹' . number_format($value->base_price, 2) . '</s>';

            $nestedData['category'] = $value->mainCategory->name . '<br>' . $value->category->name . '<br>' . $value->subcategory->name;
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
                $actions .= '<a href="' . route('admin.products.edit', $value->id) . '" class="text-primary">Edit</a> ';
            }
            if (Gate::allows('product review')) {
                $actions .= '<a href="' . route('admin.products.reviews', $value->id) . '" class="text-warning">Reviews</a> ';
            }
            if (Gate::allows('product delete')) {
                $actions .= '<a href="javascript:void(0)" onclick="deleteData(`' . route('admin.products.delete', $value->id) . '`)" class="text-danger">Delete</a>';
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

    public function edit(Request $request, $id)
    {
        $data['title'] = 'Edit Product';
        $data['subtitle'] = 'Products';
        $data['edit_data'] = Product::find($id);
        $data['categories'] = Category::where('parent_id', '0')->where('is_delete', '0')->where('status', '1')->get();
        // return $data['edit_data'];
        return view('admin.products.edit', $data);
    }

    public function save(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'title'         => 'required|string|max:255',
            'main_cat_id' => 'required|integer',
            'cat_id'      => 'required|integer',
            'sub_cat_id'   => 'required|integer',
            'price'         => 'nullable|numeric',
        ], [
            'main_cat_id.required' => 'The main category field is required.',
            'cat_id.required'      => 'The category field is required.',
            'sub_cat_id.required'   => 'The subcategory field is required.',
        ]);

        $validator->after(function ($validator) use ($request) {
            $variantFields = SubCategoryField::join('form_fields', 'form_fields.id', '=', 'sub_category_fields.field_id')
                ->where('sub_category_fields.subcategory_id', $request->sub_cat_id)
                ->pluck('form_fields.field_name');
            $hasVariant = false;

            foreach ($variantFields as $fieldName) {
                // skip validation for images in this loop
                if ($fieldName == 'images') continue;

                if ($request->has($fieldName)) {
                    $hasVariant = true;
                    $values = array_filter((array) $request->input($fieldName));
                    if (empty($values)) {
                        $validator->errors()->add($fieldName, 'At least one value is required.');
                    }
                }
            }

            // check if at least one variant ID exists
            if (!$hasVariant && empty($request->variant_id)) {
                $validator->errors()->add('variant', 'At least one variant field is required.');
            }

            // Optional: Validate images per variant if file exists
            if ($request->has('variant_id')) {
                foreach ((array)$request->variant_id as $variantId) {
                    if ($request->hasFile("images.$variantId")) {
                        $images = $request->file("images.$variantId");
                        if (empty($images)) {
                            $validator->errors()->add("images.$variantId", 'At least one image is required for this variant.');
                        }
                    }
                }
            }
        });

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ]);
        }

        // ✅ Product Save
        $product = new Product();
        $product->pid            = generatePID();
        $product->title          = $request->title;
        $product->slug           = slug($request->title);
        $product->sub_title      = $request->sub_title;
        $product->main_cat_id  = $request->main_cat_id;
        $product->cat_id       = $request->cat_id;
        $product->sub_cat_id    = $request->sub_cat_id;
        $product->price          = $request->price;
        $product->base_price     = $request->base_price;
        $product->description    = $request->description;
        $product->highlights     = $request->highlights;
        $product->specifications = $request->specifications;
        $product->is_featured    = $request->is_featured ? 1 : 0;
        $product->is_trending    = $request->is_trending ? 1 : 0;
        $product->status         = $request->status;

        // ✅ Single Image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imageName);
            $product->image = $imageName;
        }
        // $product = new Product();
        $variantIds = (array) $request->variant_id;
        $variantData = [];
        $variantImages = [];

        // ✅ Get variant-related field names
        $variantFields = SubCategoryField::join('form_fields', 'form_fields.id', '=', 'sub_category_fields.field_id')
            ->where('sub_category_fields.subcategory_id', $request->sub_cat_id)
            ->pluck('form_fields.field_name');

        foreach ($variantIds as $index => $variantId) {
            $variantData[$variantId] = [];

            // ✅ Assign dynamic fields
            foreach ($variantFields as $fieldName) {
                if ($request->has($fieldName) && isset($request->$fieldName[$index])) {
                    $variantData[$variantId][$fieldName] = $request->$fieldName[$index] ?? '';
                }
            }

            // ✅ Handle nested “type” (checkbox/multi-select)
            if ($request->has('type') && isset($request->type[$variantId])) {
                $variantData[$variantId]['type'] = $request->type[$variantId];
            }

            // ✅ Handle multiple variant images separately
            if ($request->hasFile("images.$variantId")) {
                $storedImages = [];
                foreach ($request->file("images.$variantId") as $image) {
                    if ($image && $image->isValid()) {
                        $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('uploads/products'), $imageName);
                        $storedImages[] = $imageName;
                    }
                }
                // store images in separate array for clarity
                $variantImages[$variantId] = $storedImages;
            }
        }

        // ✅ Save both variant sets to DB
        $product->variant_data = $variantData;
        $product->variant_images = $variantImages;
        $product->save();
        if (!empty($request->stars)) {
            $ratings = new Review();
            $ratings->product_id    = $product->id;
            $ratings->user_id       = Auth::user()->id;
            $ratings->user_name     = Auth::user()->name;
            $ratings->email         = Auth::user()->email;
            $ratings->reviews       = $request->reviews;
            $ratings->rating        = $request->stars;
            $ratings->save();
        }
        return response()->json([
            'success' => true,
            'message' => 'Product saved successfully'
        ]);
    }

    public function update(Request $request, $id)
    {
        // ✅ Validation (same as save)
        $validator = Validator::make($request->all(), [
            'title'         => 'required|string|max:255',
            'main_cat_id'   => 'required|integer',
            'cat_id'        => 'required|integer',
            'sub_cat_id'    => 'required|integer',
            'price'         => 'nullable|numeric',
        ], [
            'main_cat_id.required' => 'The main category field is required.',
            'cat_id.required'      => 'The category field is required.',
            'sub_cat_id.required'  => 'The subcategory field is required.',
        ]);

        $validator->after(function ($validator) use ($request) {
            $variantFields = SubCategoryField::join('form_fields', 'form_fields.id', '=', 'sub_category_fields.field_id')
                ->where('sub_category_fields.subcategory_id', $request->sub_cat_id)
                ->pluck('form_fields.field_name');
            $hasVariant = false;

            foreach ($variantFields as $fieldName) {
                if ($fieldName == 'images') continue;

                if ($request->has($fieldName)) {
                    $hasVariant = true;
                    $values = array_filter((array) $request->input($fieldName));
                    if (empty($values)) {
                        $validator->errors()->add($fieldName, 'At least one value is required.');
                    }
                }
            }

            if (!$hasVariant && empty($request->variant_id)) {
                $validator->errors()->add('variant', 'At least one variant field is required.');
            }
        });

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ]);
        }

        // ✅ Fetch existing product
        $product = Product::findOrFail($id);

        // ✅ Basic product fields
        $product->title          = $request->title;
        $product->slug           = slug($request->title);
        $product->sub_title      = $request->sub_title;
        $product->main_cat_id    = $request->main_cat_id;
        $product->cat_id         = $request->cat_id;
        $product->sub_cat_id     = $request->sub_cat_id;
        $product->price          = $request->price;
        $product->base_price     = $request->base_price;
        $product->description    = $request->description;
        $product->highlights     = $request->highlights;
        $product->specifications = $request->specifications;
        $product->is_featured    = $request->is_featured ? 1 : 0;
        $product->is_trending    = $request->is_trending ? 1 : 0;
        $product->status         = $request->status;

        // ✅ Update main image if new one uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imageName);
            $product->image = $imageName;
        }

        // ✅ Variant update
        $variantIds = (array) $request->variant_id;
        $variantFields = SubCategoryField::join('form_fields', 'form_fields.id', '=', 'sub_category_fields.field_id')
            ->where('sub_category_fields.subcategory_id', $request->sub_cat_id)
            ->pluck('form_fields.field_name');

        $existingData    = $product->variant_data ?? [];
        $existingImages  = $product->variant_images ?? [];
        $updatedData     = $existingData;
        $updatedImages   = $existingImages;

        foreach ($variantIds as $index => $variantId) {
            // start from existing
            $variant       = $existingData[$variantId] ?? [];
            $variantImages = $existingImages[$variantId] ?? [];

            // update dynamic fields
            foreach ($variantFields as $fieldName) {
                if ($fieldName !== 'images' && $request->has($fieldName) && isset($request->$fieldName[$index])) {
                    $variant[$fieldName] = $request->$fieldName[$index] ?? '';
                }
            }

            // type field
            if ($request->has('type') && isset($request->type[$variantId])) {
                $variant['type'] = $request->type[$variantId];
            }

            // ✅ Handle image deletions first
            if ($request->has("remove_images.$variantId")) {
                $removeList = $request->input("remove_images.$variantId");
                foreach ($removeList as $imgToDelete) {
                    // delete from folder
                    $filePath = public_path("uploads/products/{$imgToDelete}");
                    if (file_exists($filePath)) {
                        @unlink($filePath);
                    }

                    // delete from variantImages array
                    $variantImages = array_filter($variantImages, fn($img) => $img !== $imgToDelete);
                }
            }

            // ✅ Handle new uploads
            $uploadedFiles = $request->file("images.$variantId");
            if (is_array($uploadedFiles) && count($uploadedFiles) > 0) {
                $realFiles = array_filter($uploadedFiles, fn($f) => $f instanceof \Illuminate\Http\UploadedFile && $f->isValid());

                if (count($realFiles) > 0) {
                    $storedImages = [];
                    foreach ($realFiles as $img) {
                        $imgName = time() . '-' . uniqid() . '.' . $img->getClientOriginalExtension();
                        $img->move(public_path('uploads/products'), $imgName);
                        $storedImages[] = $imgName;
                    }
                    // merge new + remaining existing
                    $variantImages = array_merge($variantImages ?? [], $storedImages);
                }
            }

            // ✅ Final cleanup
            $variantImages = array_values(array_filter($variantImages, fn($i) => is_string($i) && trim($i) !== ''));

            // save back
            $updatedData[$variantId]   = $variant;
            $updatedImages[$variantId] = $variantImages;
        }

        $product->variant_data   = $updatedData;
        $product->variant_images = $updatedImages;
        $product->save();
        // Ratings
        if (!empty($request->stars)) {
            $ratings = new Review();
            $ratings->product_id    = $product->id;
            $ratings->user_id       = Auth::user()->id;
            $ratings->user_name     = Auth::user()->name;
            $ratings->email         = Auth::user()->email;
            $ratings->reviews       = $request->reviews;
            $ratings->rating        = $request->stars;
            $ratings->save();
            // return $ratings;
        }
        return redirect()->route('admin.products')->with('success', 'Product updated successfully');
    }

    public function delete($id)
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

    public function reviews($id)
    {
        $data['product_id'] = $id;
        $data['title'] = 'Reviews';
        $data['subtitle'] = 'Products';
        return view('admin.products.reviews', $data);
    }

    public function reviews_list(Request $request)
    {
        $columns = ['id', 'product_id', 'email', 'user_name', 'reviews', 'rating', 'created_at'];
        $product_id = $request->product_id;
        $query = Review::with('product')->where('product_id', $product_id);
        // return $query[0]->product->pid;
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
            $nestedData['product'] = $review->product->pid ?? 'N/A';
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
        $categories = Category::where('parent_id', $request->main_cat_id)
            ->where('is_delete', '0')
            ->where('status', '1')
            ->select('id', 'name')
            ->get();
        // print_r($categories); exit;
        $product = Product::find($request->product_id);

        $html = '<option value="">--select--</option>';

        if ($categories->count() > 0) {
            foreach ($categories as $value) {
                $selected = ($product && $value->id == $product->cat_id) ? 'selected' : '';
                $html .= '<option ' . $selected . ' value="' . $value->id . '">' . e($value->name) . '</option>';
            }
        } else {
            $html .= '<option value="">No Categories Found</option>';
        }

        return response()->json(['success' => true, 'html' => $html]);
    }

    public function get_sub_categories(Request $request)
    {
        $subcategories = SubCategory::where('category', $request->cat_id)
            ->where('status', '1')
            ->where('is_delete', '0')
            ->select('id', 'name')
            ->get();

        $product = Product::find($request->product_id);

        $html = '<option value="">--select--</option>';

        if ($subcategories->count() > 0) {
            foreach ($subcategories as $value) {
                $selected = ($product && $value->id == $product->sub_cat_id) ? 'selected' : '';
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
        $variants = [];
        $vtImages = [];

        $product = Product::find($request->product_id);
        $subcategory = SubCategory::find($request->sub_cat_id);
        $formFields = SubCategoryField::with('formField')
            ->where('subcategory_id', $request->sub_cat_id)
            ->orderBy('order')
            ->get();

        if ($product && !empty($product->variant_data)) {
            $variantData   = $product->variant_data ?? [];
            $variantImages = $product->variant_images ?? [];

            foreach ($variantData as $variantId => $fields) {
                $variants[] = array_merge(['variant_id' => $variantId], $fields);
            }

            // ✅ Keep variantImages associative (variant_id => [images...])
            foreach ($variantImages as $variantId => $images) {
                $vtImages[$variantId] = is_array($images)
                    ? array_values(array_filter($images, fn($img) => is_string($img) && $img !== ''))
                    : [];
            }
        }

        $data = [
            'edit_data'      => $product,
            'subcategory'    => $subcategory,
            'form_fields'    => $formFields,
            'variants'       => $variants,
            'variant_images' => $vtImages,
        ];

        if ($formFields->isNotEmpty()) {
            $html = view('admin.products.form_fields', $data)->render();
        }

        return response()->json(['success' => true, 'html' => $html]);
    }
}
