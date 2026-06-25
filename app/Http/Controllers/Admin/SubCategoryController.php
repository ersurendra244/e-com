<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\FormField;
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
                $actions .= '<a href="' . roleRoute('subcategory.edit', ['id' => $value->id]) . '" class="btn btn-sm btn-info">Edit</a> ';
                $actions .= '<a href="' . roleRoute('subcategory.form_fields', ['id' => $value->id]) . '" class="btn btn-sm btn-warning">Form</a> ';
            }
            if (Gate::allows('subcategory delete')) {
                $actions .= '<a href="javascript:void(0)" onclick="deleteData(`' . roleRoute('subcategory.delete', ['id' => $value->id]) . '`)" class="btn btn-sm btn-danger">Delete</a>';
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
    public function edit(Request $request)
    {
        $data['title'] = 'Edit Subcategory';
        $data['subtitle'] = 'Masters';
        $data['edit_data'] = SubCategory::where('id', $id)->first();
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
        return redirect(roleRoute('subcategory'))->with('success', 'Subcategory saved successfully');
    }
    public function update(Request $request)
    {
        $modal = SubCategory::where('id', $id)->firstOrFail();
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
        return redirect(roleRoute('subcategory'))->with('success', 'Subcategory updated successfully');
    }
    public function delete($slug)
    {
        $modal = SubCategory::where('id', $id)->first();
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

    public function form_view(Request $request)
    {
        $data['title'] = 'Form Field List';
        $data['subtitle'] = 'Subcategory';
        $data['subcategory'] = SubCategory::where('id', $id)->first();
        $data['form_fields'] = FormField::where('subcategory_id', $data['subcategory']->id)->where('status', '1')->where('is_delete', '0')->orderBy('order')->get();
        // return $data['selected'];
        return view('admin.sub_categories.form_view', $data);
    }

    public function form_fields(Request $request)
    {
        $data['title'] = 'Form Field List';
        $data['subtitle'] = 'Subcategory';
        $data['subcategory'] = SubCategory::where('id', $id)->first();
        $data['form_fields'] = FormField::where('subcategory_id', $data['subcategory']->id)->where('is_delete', '0')->orderBy('order')->get();
        return view('admin.sub_categories.form_fields', $data);
    }


    public function form_fields_edit(Request $request)
    {
        $id = $request->route('id');
        $data = FormField::find($id);
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function form_fields_save(Request $request)
    {
        $edit_id = $request->edit_id;

        // Validation
        $validator = Validator::make($request->all(), [
            'field_label'    => 'required|string|max:255',
            'field_name'     => 'required|string|max:255',
            'field_type'     => 'required|string',
            'field_options'  => 'nullable',
            'is_required'    => 'nullable|integer',
            'order'          => 'nullable|integer',
            'status'         => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ]);
        }

        // Prepare data
        $field_name = strtolower(str_replace(' ', '_', $request->field_name));

        $data = [
            'field_label'    => ucwords($request->field_label),
            'field_name'     => $field_name,
            'field_type'     => $request->field_type,
            'is_required'    => $request->is_required ?? 0,
            'subcategory_id' => $request->subcategory_id,
            'row_class'      => $request->row_class ?? '12',
            'field_class'    => $request->field_class,
            'order'          => $request->order,
            'status'         => $request->status ?? 1,
        ];

        // Handle field options (NO json_encode here)
        if (!empty($request->field_options)) {
            $options = is_array($request->field_options)
                ? $request->field_options
                : array_map('trim', explode(',', $request->field_options));

            $data['field_options'] = $options; // ✅ direct array
        } else {
            $data['field_options'] = null;
        }

        // Create or Update
        if ($edit_id) {
            FormField::where('id', $edit_id)->update($data);
        } else {
            FormField::create($data);
        }

        // Message
        $msg = $edit_id
            ? 'Form field updated successfully!'
            : 'Form field created successfully!';

        return response()->json([
            'status'  => 'success',
            'message' => $msg,
        ]);
    }
    public function form_fields_delete(Request $request)
    {
        $form_field = FormField::find($request->route('id'));
        $form_field->status = '0';
        $form_field->is_delete = '1';
        $form_field->save();
        Session::flash('success', 'Form field deleted successfully!');
        return response()->json(['success' => false]);
    }
}
