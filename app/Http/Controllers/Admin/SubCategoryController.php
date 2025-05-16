<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    public function index()
    {
        $data['title'] = 'Subcategories';
        $data['subtitle'] = 'Masters';
        return view('admin.sub_categories.index', $data);
    }
    public function list(Request $request)
    {
        $columns = ['id', 'cat_id', 'image', 'name', 'description', 'order', 'is_home', 'status'];
        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);
        $orderIndex = $request->input('order.0.column', 0);
        $order = $columns[$orderIndex] ?? 'id';
        $dir = $request->input('order.0.dir', 'asc');
        $search = $request->input('search.value');

        // Base query
        $query = SubCategory::where('is_delete', '0');
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
            $nestedData['cat_id'] = $value->category->name ?? '';
            $nestedData['order'] = $value->order;
            $is_home = $value->is_home == 1 ? '<label class="badge badge-outline-success badge-pill py-1">Publish</label>' : '<label class="badge badge-outline-danger badge-pill py-1">Unpublish</label>';
            $nestedData['is_home'] = $is_home;
            $status = $value->status == 1 ? '<label class="badge badge-outline-success badge-pill py-1">Active</label>' : '<label class="badge badge-outline-danger badge-pill py-1">Inactive</label>';
            $nestedData['status'] = $status;

            $actions = "";
            if (Gate::allows('subcategory edit')) {
                $actions .= '<a href="' . route('admin.subcategory.edit', $value->slug) . '" class="btn btn-sm btn-info">Edit</a> ';
            }
            if (Gate::allows('subcategory delete')) {
                $actions .= '<a href="javascript:void(0)" onclick="deleteData(`' . route('admin.subcategory.delete', $value->slug) . '`)" class="btn btn-sm btn-danger">Delete</a>';
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
    public function create(Request $request)
    {
        $data['title'] = 'Add Subcategory';
        $data['subtitle'] = 'Masters';
        $data['categories'] = Category::where('is_delete', '0')->where('status', '1')->get();
        return view('admin.sub_categories.create', $data);
    }
    public function edit(Request $request, $slug)
    {
        $data['title'] = 'Edit Subcategory';
        $data['subtitle'] = 'Masters';
        $data['edit_data'] = SubCategory::where('slug', $slug)->first();
        $data['categories'] = Category::where('is_delete', '0')->where('status', '1')->get();
        return view('admin.sub_categories.edit', $data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:sub_categories,name',
            'cat_id' => 'required',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $modal = new SubCategory();
        if ($request->hasFile('image')) {
            removeImage($modal->image, 'uploads/categories');
            removeImage($modal->thumbnail, 'uploads/categories/thumbnails');
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/categories'), $imageName);
            $modal->image = $imageName;

            $imageFullPath = public_path('uploads/categories/' . $imageName);
            $thumbnailName = createThumbnail($imageName, $imageFullPath, 'uploads/categories/thumbnails', 100, 100);
            $modal->thumbnail = $thumbnailName;
        }
        $modal->name = $request->name;
        $modal->slug = slug($request->name);
        $modal->cat_id = $request->cat_id;
        $modal->description = $request->description;
        $modal->order = $request->order;
        $modal->is_home = $request->is_home;
        $modal->status = $request->status;
        // return $modal;
        $modal->save();
        return redirect()->route('admin.subcategory')->with('success', 'Subcategory saved successfully');
    }
    public function update(Request $request, $slug)
    {
        $modal = SubCategory::where('slug', $slug)->firstOrFail();
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:sub_categories,name,' . $modal->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('image')) {
            removeImage($modal->image, 'uploads/categories');
            removeImage($modal->thumbnail, 'uploads/categories/thumbnails');
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/categories'), $imageName);
            $modal->image = $imageName;

            $imageFullPath = public_path('uploads/categories/' . $imageName);
            $thumbnailName = createThumbnail($imageName, $imageFullPath, 'uploads/categories/thumbnails', 100, 100);
            $modal->thumbnail = $thumbnailName;
        }
        $modal->name = $request->name;
        $modal->slug = slug($request->name);
        $modal->cat_id = $request->cat_id;
        $modal->description = $request->description;
        $modal->order = $request->order;
        $modal->is_home = $request->is_home;
        $modal->status = $request->status;
        $modal->update();
        return redirect()->route('admin.subcategory')->with('success', 'Subcategory updated successfully');
    }
    public function delete($slug)
    {
        $modal = SubCategory::where('slug', $slug)->first();
        if ($modal) {
            $modal->status = '0';
            $modal->is_delete = '1';
            $modal->save();
            removeImage($modal->image, 'uploads/categories');
            removeImage($modal->thumbnail, 'uploads/categories/thumbnails');
            Session::flash('success', 'Subcategory deleted successfully');
            return response()->json(['success' => true]);
        }
        Session::flash('error', 'Subcategory not found');
        return response()->json(['success' => false]);
    }

}
