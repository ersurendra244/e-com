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
    // for test only dsdsdd
    public function index()
    {
        $data['title'] = 'Categories';
        return view('admin.categories.index', $data);
    }
    public function list(Request $request)
    {
        $columns = ['id', 'image', 'name', 'description', 'status'];

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
            $nestedData['status'] = $value->status == 1 ? 'Active' : 'Inactive';
            $actions = "";
            if (Gate::allows('category edit')) {
                $actions .= '<a href="' . route('admin.categories.edit', $value->id) . '" class="btn btn-sm btn-info">Edit</a> ';
            }
            if (Gate::allows('category delete')) {
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
        $data['title'] = 'Add Category';
        $data['subtitle'] = 'Categories';
        return view('admin.categories.create', $data);
    }
    public function edit(Request $request, $id)
    {
        $data['title'] = 'Edit Category';
        $data['subtitle'] = 'Categories';
        $data['edit_data'] = Category::find($id);
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

        $model = new Category();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->move(public_path('uploads/categories'), $imageName);
            $imagePath = $imageName;
            $model->image = $imagePath;
        }
        $model->name = $request->name;
        $model->description = $request->description;
        $model->status = $request->status;
        $model->save();
        return redirect()->route('admin.categories')->with('success', 'Category saved successfully');
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,' . $id,
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = Category::find($id);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->move(public_path('uploads/categories'), $imageName);

            $imagePath = $imageName;
            $model->image = $imagePath;
        }
        $model->name = $request->name;
        $model->description = $request->description;
        $model->status = $request->status;
        $model->save();
        return redirect()->route('admin.categories')->with('success', 'Category updated successfully');
    }
    public function delete(Request $request)
    {
        $id = $request->id;
        $model = Category::find($id);
        if ($model) {
            $model->status = '0';
            $model->save();
            Session::flash('success', 'Category deleted successfully');
            return response()->json(['success' => true, 'message' => 'Category deleted successfully']);
        }
        Session::flash('error', 'Category not found');
        return response()->json(['success' => false, 'message' => 'Category not found']);
    }

}
