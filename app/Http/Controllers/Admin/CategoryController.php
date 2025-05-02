<?php

namespace App\Http\Controllers\Admin;

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

        $totalData = Category::count();
        $totalFiltered = $totalData;
        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);
        $orderIndex = $request->input('order.0.column', 0);
        $order = $columns[$orderIndex] ?? 'id';
        $dir = $request->input('order.0.dir', 'asc');

        if (empty($request->input('search.value'))) {
            $users = Category::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $users = Category::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Category::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];
        foreach ($users as $value) {
            $nestedData['id'] = $value->id;
            $nestedData['image'] = '<img class="img-sm rounded" src="' . asset('uploads/categories/' . $value->image) . '" alt=""/>';
            $nestedData['name'] = $value->name;
            $nestedData['description'] = $value->description;
            $nestedData['order'] = $value->order;
            $is_home = $value->is_home == 1 ? '<label class="badge badge-outline-success badge-pill py-1">Publish</label>' : '<label class="badge badge-outline-danger badge-pill py-1">Unpublish</label>';
            $nestedData['is_home'] = $is_home;
            $status = $value->status == 1 ? '<label class="badge badge-outline-success badge-pill py-1">Active</label>' : '<label class="badge badge-outline-danger badge-pill py-1">Inactive</label>';
            $nestedData['status'] = $status;
            $actions = "";
            if (Gate::allows('category edit')) {
                $actions .= '<a href="' . route('admin.categories.edit', $value->slug) . '" class="btn btn-sm btn-info">Edit</a> ';
            }
            if (Gate::allows('category delete')) {
                $actions .= '<a href="javascript:void(0)" onclick="deleteData(`' . route('admin.categories.delete', $value->id) . '`)" class="btn btn-sm btn-danger">Delete</a>';
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
    public function delete($id)
    {
        $modal = Category::find($id);
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

    public function subcategory()
    {
        $data['title'] = 'Subcategories';
        $data['subtitle'] = 'Masters';
        return view('admin.categories.subcategory', $data);
    }
    public function subcategory_list(Request $request)
    {
        $columns = ['id', 'parent_id', 'image', 'name', 'description', 'order', 'is_home', 'status'];
        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);
        $orderIndex = $request->input('order.0.column', 0);
        $order = $columns[$orderIndex] ?? 'id';
        $dir = $request->input('order.0.dir', 'asc');
        $search = $request->input('search.value');

        // Base query
        $query = Category::with('parents')->whereNotNull('parent_id');
        // Count total
        $totalData = $query->count();

        // Filtered query
        if (!empty($search)) {
            $filteredQuery = clone $query;
            $filteredQuery = $filteredQuery->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%");
            });

            $totalFiltered = $filteredQuery->count();
        } else {
            $totalFiltered = $totalData;
        }
        $results = $query->offset($start)->limit($limit)->orderBy($order, $dir)->get();
        $data = [];
        foreach ($results as $value) {
            $nestedData['id'] = $value->id;
            $nestedData['image'] = '<img class="img-sm rounded" src="' . asset('uploads/categories/' . $value->image) . '" alt=""/>';
            $nestedData['name'] = $value->name;
            $nestedData['parent_id'] = $value->parents->name ?? '-';
            $nestedData['description'] = $value->description;
            $nestedData['order'] = $value->order;
            $is_home = $value->is_home == 1 ? '<label class="badge badge-outline-success badge-pill py-1">Publish</label>' : '<label class="badge badge-outline-danger badge-pill py-1">Unpublish</label>';
            $nestedData['is_home'] = $is_home;
            $status = $value->status == 1 ? '<label class="badge badge-outline-success badge-pill py-1">Active</label>' : '<label class="badge badge-outline-danger badge-pill py-1">Inactive</label>';
            $nestedData['status'] = $status;

            $actions = "";
            if (Gate::allows('subcategory edit')) {
                $actions .= '<a href="' . route('admin.subcategory.edit', $value->id) . '" class="btn btn-sm btn-info">Edit</a> ';
            }
            if (Gate::allows('subcategory delete')) {
                $actions .= '<a href="javascript:void(0)" onclick="deleteData(`' . route('admin.subcategory.delete', $value->id) . '`)" class="btn btn-sm btn-danger">Delete</a>';
            }
            $nestedData['action'] = $actions;
            $data[] = $nestedData;
        }

        return response()->json([
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        ]);
    }
    public function subcategory_create(Request $request)
    {
        $data['title'] = 'Add Subcategory';
        $data['subtitle'] = 'Masters';
        $data['categories'] = Category::whereNull('parent_id')->get();
        // return $data['categories'];
        return view('admin.categories.subcategory_create', $data);
    }
    public function subcategory_edit(Request $request, $id)
    {
        $data['title'] = 'Edit Subcategory';
        $data['subtitle'] = 'Masters';
        $data['edit_data'] = Category::find($id);
        $data['categories'] = Category::whereNull('parent_id')->get();
        return view('admin.categories.subcategory_edit', $data);
    }
    public function subcategory_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name',
            'parent_id' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $modal = new Category();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->move(public_path('uploads/categories'), $imageName);
            $imagePath = $imageName;
            $modal->image = $imagePath;
        }
        $modal->name = $request->name;
        $modal->parent_id = $request->parent_id;
        $modal->description = $request->description;
        $modal->order = $request->order;
        $modal->is_home = $request->is_home;
        $modal->status = $request->status;
        $modal->save();
        return redirect()->route('admin.subcategory')->with('success', 'Subcategory saved successfully');
    }
    public function subcategory_update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,' . $id,
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $modal = Category::find($id);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->move(public_path('uploads/categories'), $imageName);

            $imagePath = $imageName;
            $modal->image = $imagePath;
        }
        $modal->name = $request->name;
        $modal->parent_id = $request->parent_id;
        $modal->description = $request->description;
        $modal->order = $request->order;
        $modal->is_home = $request->is_home;
        $modal->status = $request->status;
        $modal->save();
        return redirect()->route('admin.subcategory')->with('success', 'Subcategory updated successfully');
    }
    public function subcategory_delete($id)
    {
        $modal = Category::find($id);
        if ($modal) {
            $modal->status = '0';
            $modal->is_delete = '1';
            $modal->save();
            Session::flash('success', 'Subcategory deleted successfully');
            return response()->json(['success' => true]);
        }
        Session::flash('error', 'Subcategory not found');
        return response()->json(['success' => false]);
    }
}
