<?php

namespace App\Http\Controllers\Admin;

use App\Models\Master;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $data['title'] = 'Categories';
        $data['subtitle'] = 'Masters';
        return view('admin.categories.index', $data);
    }
    public function list(Request $request)
    {
        $columns = ['id', 'image', 'name', 'description', 'order', 'is_home', 'status'];

        $query = Category::where('is_delete', '0');
        $totalData = $query->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);
        $orderIndex = $request->input('order.0.column', 0);
        $order = $columns[$orderIndex] ?? 'id';
        $dir = $request->input('order.0.dir', 'asc');

        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%");
            });
            $totalFiltered = $query->count();
        }

        $results = $query->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $data = [];
        foreach ($results as $value) {
            $nestedData['id'] = $value->id;
            $nestedData['image'] = '<img class="img-sm rounded" src="' . asset('uploads/categories/' . $value->image) . '" alt=""/>';
            $nestedData['name'] = $value->name;
            $nestedData['order'] = $value->order;
            $is_home = $value->is_home == 1 ? '<label class="badge badge-outline-success badge-pill py-1">Publish</label>' : '<label class="badge badge-outline-danger badge-pill py-1">Unpublish</label>';
            $nestedData['is_home'] = $is_home;
            $status = $value->status == 1 ? '<label class="badge badge-outline-success badge-pill py-1">Active</label>' : '<label class="badge badge-outline-danger badge-pill py-1">Inactive</label>';
            $nestedData['status'] = $status;
            $actions = "";
            if (Gate::allows('category edit')) {
                $actions .= '<a href="' . route('admin.categories.edit', $value->slug) . '" class="btn btn-sm btn-info">Edit</a> ';
            }
            if (Gate::allows('category edit')) {
                $actions .= '<a href="' . route('admin.categories.items', $value->slug) . '" class="btn btn-sm btn-success">Items</a> ';
            }
            if (Gate::allows('category delete')) {
                $actions .= '<a href="javascript:void(0)" onclick="deleteData(`' . route('admin.categories.delete', $value->slug) . '`)" class="btn btn-sm btn-danger">Delete</a>';
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
        $data['title'] = 'Add Category';
        $data['subtitle'] = 'Masters';
        return view('admin.categories.create', $data);
    }

    public function items(Request $request, $slug)
    {
        $data['category'] = Category::where('slug', $slug)->first();
        $data['title'] = 'Items';
        $data['subtitle'] = 'Masters';
        $data['item_types'] = Master::where('type', 'item_type')->where('is_delete', '0')->orderBy('name', 'asc')->get();
        return view('admin.categories.items', $data);
    }
    public function items_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_type' => 'required|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

            $modal = Category::findOrFail($request->category_id);
            $modal->item_type = $request->item_type;
        $modal->save();
        Session::flash('success', 'Item added successfully');
        return redirect()->back();
    }

    public function edit(Request $request, $slug)
    {
        $data['title'] = 'Edit Category';
        $data['subtitle'] = 'Masters';
        $data['edit_data'] = Category::where('slug', $slug)->first();
        return view('admin.categories.edit', $data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $modal = new Category();
        if ($request->hasFile('image')) {
            removeImage($modal->image, 'uploads/categories');
            removeImage($modal->thumbnail, 'uploads/categories/thumbnails');
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/categories'), $imageName);
            $modal->image = $imageName;

            $imageFullPath = public_path('uploads/categories/' . $imageName);
            $thumbnailName = createThumbnail($imageName,$imageFullPath, 'uploads/categories/thumbnails', 100, 100);
            $modal->thumbnail = $thumbnailName;
        }

        $modal->name = $request->name;
        $modal->slug = slug($request->name);
        $modal->description = $request->description;
        $modal->order = $request->order;
        $modal->is_home = $request->is_home;
        $modal->status = $request->status;
        $modal->save();
        return redirect()->route('admin.categories')->with('success', 'Category saved successfully');
    }
    public function update(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,' . $slug . ',slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $modal = Category::where('slug', $slug)->firstOrFail();
        if ($request->hasFile('image')) {
            removeImage($modal->image, 'uploads/categories');
            removeImage($modal->thumbnail, 'uploads/categories/thumbnails');
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/categories'), $imageName);
            $modal->image = $imageName;

            $imageFullPath = public_path('uploads/categories/' . $imageName);
            $thumbnailName = createThumbnail($imageName,$imageFullPath, 'uploads/categories/thumbnails', 100, 100);
            $modal->thumbnail = $thumbnailName;
        }
        $modal->name = $request->name;
        $modal->slug = slug($request->name);
        $modal->description = $request->description;
        $modal->order = $request->order;
        $modal->is_home = $request->is_home;
        $modal->status = $request->status;
        $modal->save();
        return redirect()->route('admin.categories')->with('success', 'Category updated successfully');
    }
    public function delete($slug)
    {
        $modal = Category::where('slug', $slug)->firstOrFail();
        if ($modal) {
            $modal->status = '0';
            $modal->is_delete = '1';
            $modal->save();
            removeImage($modal->image, 'uploads/categories');
            removeImage($modal->thumbnail, 'uploads/categories/thumbnails');
            Session::flash('success', 'Category deleted successfully');
            return response()->json(['success' => true]);
        }
        Session::flash('error', 'Category not found');
        return response()->json(['success' => false]);
    }
}
