<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function index()
    {
        $data['title'] = 'Items';
        $data['subtitle'] = 'Masters';
        return view('admin.items.index', $data);
    }
    public function list(Request $request)
    {
        $columns = ['id', 'name', 'created_at', 'status'];

        $query = Item::where('is_delete', '0');
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
            $nestedData['name'] = $value->name;
            $status = $value->status == 1 ? '<label class="badge badge-outline-success badge-pill py-1">Active</label>' : '<label class="badge badge-outline-danger badge-pill py-1">Inactive</label>';
            $nestedData['created_at'] = date('d-m-Y', strtotime($value->created_at));
            $nestedData['status'] = $status;
            $actions = "";
            if (Gate::allows('category edit')) {
                $actions .= '<a href="' . route('admin.items.edit', $value->slug) . '" class="btn btn-sm btn-info">Edit</a> ';
            }
            if (Gate::allows('category delete')) {
                $actions .= '<a href="javascript:void(0)" onclick="deleteData(`' . route('admin.items.delete', $value->slug) . '`)" class="btn btn-sm btn-danger">Delete</a>';
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
        $data['title'] = 'Add Item';
        $data['subtitle'] = 'Masters';
        $data['subcategories'] = SubCategory::where('is_delete', '0')->get();
        return view('admin.items.create', $data);
    }
    public function edit(Request $request, $slug)
    {
        $data['title'] = 'Edit Item';
        $data['subtitle'] = 'Masters';
        $data['edit_data'] = Item::where('slug', $slug)->first();
        $data['subcategories'] = SubCategory::where('is_delete', '0')->get();
        return view('admin.items.edit', $data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:items,name',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $modal = new Item();
        $modal->name = $request->name;
        $modal->slug = slug($request->name);
        $modal->sub_cat_id = $request->sub_cat_id;
        $modal->status = $request->status;
        $modal->save();
        return redirect()->route('admin.items')->with('success', 'Item saved successfully');
    }
    public function update(Request $request, $slug)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:items,name,' . $slug . ',slug',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $modal = Item::where('slug', $slug)->firstOrFail();
        $modal->name = $request->name;
        $modal->slug = slug($request->name);
        $modal->sub_cat_id = $request->sub_cat_id;
        $modal->status = $request->status;
        $modal->save();
        return redirect()->route('admin.items')->with('success', 'Item updated successfully');
    }
    public function delete($slug)
    {
        $modal = Item::where('slug', $slug)->firstOrFail();
        if ($modal) {
            $modal->status = '0';
            $modal->is_delete = '1';
            $modal->save();
            Session::flash('success', 'Item deleted successfully');
            return response()->json(['success' => true]);
        }
        Session::flash('error', 'Item not found');
        return response()->json(['success' => false]);
    }
}
