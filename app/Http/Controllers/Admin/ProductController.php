<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;
use App\Models\Product;
use App\Models\Variant;
use App\Models\Category;
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
        $columns = ['id', 'images', 'name', 'category', 'pid', 'price', 'status'];

        $totalData = Product::count();
        $totalFiltered = $totalData;
        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);
        $orderIndex = $request->input('order.0.column', 0);
        $order = $columns[$orderIndex] ?? 'id';
        $dir = $request->input('order.0.dir', 'asc');

        if (empty($request->input('search.value'))) {
            $users = Product::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $users = Product::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('category', 'LIKE', "%{$search}%")
                ->orWhere('pid', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Product::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('category', 'LIKE', "%{$search}%")
                ->orWhere('pid', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];
        foreach ($users as $value) {
            $image = $value->images[0] ?? '';
            // $variants = Variant::where('product_id', $value->id)->count();
            $total_variants = $value->variants()->count();
            $nestedData['id'] = $value->id;
            $nestedData['image'] = '<img class="img-sm rounded" src="' . asset('uploads/products/' . $image) . '" alt=""/>';
            $nestedData['pid'] = $value->pid;
            $nestedData['name'] = $value->name;
            $nestedData['category'] = $value->category;
            $nestedData['price'] = $value->variants[0]->price;
            $variants = '<a href="' . route('admin.products.variants', ['product_id' => $value->id]) . '" class="btn btn-sm btn-success">Variants [' . $total_variants . ']</a>';

            $nestedData['variants'] = $variants;

            $nestedData['status'] = $value->status == 1 ? 'Active' : 'Inactive';
            $collections = '<div class="form-group">';
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
            $actions = "";
            if (Gate::allows('product edit')) {
                $actions .= '<a href="' . route('admin.products.edit', $value->id) . '" class="btn btn-sm btn-info">Edit</a> ';
            }
            if (Gate::allows('product review')) {
                $actions .= '<a href="' . route('admin.products.reviews', $value->id) . '" class="btn btn-sm btn-warning">Reviews</a> ';
            }

            if (Gate::allows('product delete')) {
                $actions .= '<a href="javascript:void(0)" onclick="deleteData({$value->id})" class="btn btn-sm btn-danger">Delete</a>';
            }

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
        $data['categories'] = Category::where('status', '1')->get();
        return view('admin.products.create', $data);
    }

    public function edit(Request $request, $id)
    {
        $data['title'] = 'Edit Product';
        $data['subtitle'] = 'Products';
        $data['data'] = Product::with('variants')->find($id);
        // return $data['data']->variants[0]->color;
        $data['categories'] = Category::where('status', '1')->get();
        return view('admin.products.edit', $data);
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category' => 'required',
            'price' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $model = new Product();
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/products'), $imageName);
                $imagePaths[] = $imageName; // Store image name in array
            }
        }
        $model->images = $imagePaths;
        $model->name = $request->name;
        $model->category = $request->category;
        $model->pid = generatePID();
        $model->status = $request->status;
        $model->is_featured = $request->is_featured ?'1':'0';
        $model->is_trending = $request->is_trending ?'1':'0';
        $model->save();

        // Update variants
        $variant = new Variant();
        $variant->images = $imagePaths;
        $variant->product_id = $model->id;
        $variant->color = $request->color;
        $variant->size = $request->size;
        $variant->stock = $request->stock;
        $variant->price = $request->price;
        $variant->status = $request->status;
        $variant->save();

        if (!empty($request->stars)) {
            $ratings = new Review();
            $ratings->pid   = $model->id;
            $ratings->user_id   = Auth::user()->id;
            $ratings->user_name = Auth::user()->name;
            $ratings->email = Auth::user()->email;
            $ratings->reviews   = $request->reviews;
            $ratings->rating    = $request->stars;
            $ratings->save();
            // return $ratings;
        }
        return redirect()->route('admin.products')->with('success', 'Product saved successfully');
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category' => 'required',
            'price' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = Product::find($id);
        $imagePaths = $model->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                if (isset($imagePaths[$key])) {
                    // Delete the old image if it exists
                    $oldImagePath = public_path('uploads/products/' . $imagePaths[$key]);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // Upload new image
                $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/products'), $imageName);

                // Replace in array
                $imagePaths[$key] = $imageName;
            }
        }
        $model->images = $imagePaths;
        $model->name = $request->name;
        $model->category = $request->category;
        $model->status = $request->status;
        $model->is_featured = $request->is_featured ?'1':'0';
        $model->is_trending = $request->is_trending ?'1':'0';
        $model->short_description = $request->short_description;
        $model->full_description = $request->full_description;
        $model->add_description = $request->add_description;
        $model->save();

        // Update variants
        $variant = Variant::where('product_id', $model->id)->firstOrNew();
        $variant->product_id = $model->id;
        $variant->images = $imagePaths;
        $variant->color = $request->color;
        $variant->size = $request->size;
        $variant->stock = $request->stock;
        $variant->price = $request->price;
        $variant->status = $request->status;
        $variant->save();

        // Ratings
        if (!empty($request->stars)) {
            $ratings = new Review();
            $ratings->pid   = $model->id;
            $ratings->user_id   = Auth::user()->id;
            $ratings->user_name = Auth::user()->name;
            $ratings->email = Auth::user()->email;
            $ratings->reviews   = $request->reviews;
            $ratings->rating    = $request->stars;
            $ratings->save();
            // return $ratings;
        }
        return redirect()->route('admin.products')->with('success', 'Product updated successfully');
    }
    public function delete(Request $request)
    {
        $id = $request->id;
        $model = Product::find($id);
        if ($model) {
            $model->status = '0';
            $model->save();
            Session::flash('success', 'Product deleted successfully');
            return response()->json(['success' => true, 'message' => 'Book deleted successfully']);
        }
        Session::flash('error', 'Product not found');
        return response()->json(['success' => false, 'message' => 'Book not found']);
    }

    public function variants($product_id)
    {
        $data['title'] = 'Variants';
        $data['subtitle'] = 'Products';
        $data['productData'] = Product::with('variants')->find($product_id);
        return view('admin.products.variants', $data);
    }

    public function variants_manage($product_id, $id = null)
    {
        if (!empty($id)) {
            $data['title']       = 'Edit Variant';
            $data['variantData'] = Variant::find($id);
        }else {
            $data['title']       = 'Add Variant';
            $data['variantData'] = Variant::find($id);
        }
        $data['productData'] = Product::find($product_id);
        $data['subtitle'] = 'Products';

        return view('admin.products.variants_manage', $data);
    }

    public function variants_save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'color' => 'required',
            'price' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $id = $request->edit_id;
        if (!empty($id)) {
            $model = Variant::find($id);
            $msg = 'Variant updated successfully';
        } else {
            $model = new Variant();
            $msg = 'Variant saved successfully';
        }
        $imagePaths = $model->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                if (isset($imagePaths[$key])) {
                    // Delete the old image if it exists
                    $oldImagePath = public_path('uploads/products/' . $imagePaths[$key]);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // Upload new image
                $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/products'), $imageName);

                // Replace in array
                $imagePaths[$key] = $imageName;
            }
        }
        $model->images = $imagePaths;
        $model->product_id = $request->product_id;
        $model->color = $request->color;
        $model->size = $request->size;
        $model->stock = $request->stock;
        $model->price = $request->price;
        $model->status = $request->status;
        $model->save();
        return redirect()->route('admin.products.variants', ['product_id' => $request->product_id])->with('success', $msg);
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
        $columns = ['id', 'pid', 'email', 'user_name', 'reviews', 'rating','created_at'];
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
            $nestedData['reviews'] = '<div>' . $review->reviews.'</div>';
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

}
