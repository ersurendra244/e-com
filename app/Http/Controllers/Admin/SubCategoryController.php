<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\FormField;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Models\SubCategoryField;
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
        $columns = ['id', 'image', 'name', 'category', 'description', 'order', 'is_home', 'status'];
        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);
        $orderIndex = $request->input('order.0.column', 0);
        $order = $columns[$orderIndex] ?? 'id';
        $dir = $request->input('order.0.dir', 'asc');
        $search = $request->input('search.value');

        // Base query
        $query = SubCategory::with('parentCategory')->where('is_delete', '0');
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
        // print_r($results); exit;
        $data = [];
        foreach ($results as $value) {
            $nestedData['id'] = $value->id;
            $nestedData['image'] = '<img class="img-sm rounded" src="' . is_image('uploads/categories/', $value->image) . '" alt=""/>';
            $nestedData['name'] = $value->name;
            // $nestedData['category'] = $value->category ?? '';
            $nestedData['category'] = $value->parentCategory->name ?? '';
            $nestedData['order'] = $value->order;
            $is_home = $value->is_home == 1 ? '<label class="badge badge-outline-success badge-pill py-1">Publish</label>' : '<label class="badge badge-outline-danger badge-pill py-1">Unpublish</label>';
            $nestedData['is_home'] = $is_home;
            $status = $value->status == 1 ? '<label class="badge badge-outline-success badge-pill py-1">Active</label>' : '<label class="badge badge-outline-danger badge-pill py-1">Inactive</label>';
            $nestedData['status'] = $status;

            $actions = "";
            if (Gate::allows('subcategory edit')) {
                $actions .= '<a href="' . route('admin.subcategory.edit', $value->slug) . '" class="btn btn-sm btn-info">Edit</a> ';
                $actions .= '<a href="' . route('admin.subcategory.form_fields', $value->slug) . '" class="btn btn-sm btn-warning">Form</a> ';
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
        $data['categories'] = Category::where('parent_id', '!=', 0)->where('is_delete', '0')->where('status', '1')->get();
        return view('admin.sub_categories.create', $data);
    }
    public function edit(Request $request, $slug)
    {
        $data['title'] = 'Edit Subcategory';
        $data['subtitle'] = 'Masters';
        $data['edit_data'] = SubCategory::where('slug', $slug)->first();
        $data['categories'] = Category::where('parent_id', '!=', 0)->where('is_delete', '0')->where('status', '1')->get();
        return view('admin.sub_categories.edit', $data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:sub_categories,name',
            'category' => 'required',
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
        $modal->category = $request->category;
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
        $modal->category = $request->category;
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

    public function form_view(Request $request, $slug)
    {
        $data['title'] = 'Form Field List';
        $data['subtitle'] = 'Subcategory';
        $data['subcategory'] = SubCategory::where('slug', $slug)->first();
        $data['selected'] = SubCategoryField::with('formField')->where('subcategory_id', $data['subcategory']->id)->orderBy('order')->get();
        // return $data['selected'];
        return view('admin.sub_categories.form_view', $data);
    }

    public function form_fields(Request $request, $slug)
    {
        $data['title'] = 'Form Field List';
        $data['subtitle'] = 'Subcategory';
        $data['subcategory'] = SubCategory::where('slug', $slug)->first();
        $data['form_fields'] = FormField::orderBy('order')->where('is_delete', '0')->get();
        $data['selected'] = SubCategoryField::where('subcategory_id', $data['subcategory']->id)->orderBy('order', 'asc')->get(['field_id', 'order', 'is_required', 'row_class', 'field_class'])->keyBy('field_id')->toArray();
        // return $data['selected'];
        return view('admin.sub_categories.form_fields', $data);
    }

    public function form_fields_save(Request $request)
    {
        $slug = $request->input('slug');
        $subcategory_id = $request->input('subcategory_id');
        $selected_field_ids = array_keys($request->input('field_id', []));

        SubCategoryField::where('subcategory_id', $subcategory_id)
            ->whereNotIn('field_id', $selected_field_ids)
            ->delete();

        foreach ($selected_field_ids as $field_id) {
            $is_required = $request->is_required[$field_id] ?? 0;
            $row_class   = $request->row_class[$field_id] ?? '6';
            $field_class = $request->field_class[$field_id] ?? '';
            $order       = $request->order[$field_id] ?? null;

            if ($order === '' || $order === 'null') {
                $order = null;
            }

            $data = [
                'subcategory_id' => $subcategory_id,
                'field_id'       => $field_id,
                'is_required'    => $is_required,
                'row_class'      => $row_class,
                'field_class'    => $field_class,
                'order'          => $order,
            ];

            SubCategoryField::updateOrCreate(
                [
                    'subcategory_id' => $subcategory_id,
                    'field_id' => $field_id,
                ],
                $data
            );
        }
        return redirect()->route('admin.subcategory.form_fields', $slug)->with('success', 'Subcategory fields updated successfully.');
    }
}
