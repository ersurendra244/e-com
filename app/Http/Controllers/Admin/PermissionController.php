<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function index()
    {
        $data['title'] = 'Permissions';
        $data['permissions'] = Permission::orderBy('name', 'asc')->get();
        return view('admin.permissions.index', $data);
    }

    public function create()
    {
        $data['title'] = 'Add Permission';
        $data['subtitle'] = 'Permissions';
        return view('admin.permissions.create', $data);
    }

    public function list(Request $request)
    {
        $columns = ['id', 'name', 'created_at', 'id'];

        $totalData = Permission::count();
        $totalFiltered = $totalData;
        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);
        $orderIndex = $request->input('order.0.column', 0);
        $order = $columns[$orderIndex] ?? 'id';
        $dir = $request->input('order.0.dir', 'desc');
        $query = Permission::orderBy($order, $dir);
        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%");
            });
            $totalFiltered = $query->count();
        }
        $model = $query->offset($start)->limit($limit)->get();
        $data = [];
        foreach ($model as $key => $value) {
            $nestedData['id'] = ++$key;
            $nestedData['name'] = $value->name;
            $nestedData['created_at'] = date('d-m-Y', strtotime($value->created_at));
            $actions = "";
            if (Gate::allows('permission edit')) {
                $actions .= '<a href="' . route('admin.permissions.edit', $value->id) . '" class="btn btn-sm btn-info">Edit</a> ';
            }

            if (Gate::allows('permission delete')) {
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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = new Permission();
        $msg = 'Permission saved successfully';
        $model->name = $request->name;
        $model->save();
        return redirect()->route('admin.permissions')->with('success', $msg);
    }

    public function edit(Request $request, $id)
    {
        $data['title'] = 'Edit Permission';
        $data['subtitle'] = 'Permissions';
        $data['permission'] = Permission::find($id);
        return view('admin.permissions.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions,name,' . $id,

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = Permission::find($id);
        $msg = 'Permission updated successfully';
        $model->name = $request->name;
        $model->save();
        return redirect()->route('admin.permissions')->with('success', $msg);
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $model = Permission::find($id);
        if ($model) {
            $model->delete();
            Session::flash('success', 'Permission deleted successfully');
            return response()->json(['success' => true, 'message' => 'Permission deleted successfully']);
        }
        Session::flash('error', 'Permission not found');
        return response()->json(['success' => false, 'message' => 'Permission not found']);
    }
}
