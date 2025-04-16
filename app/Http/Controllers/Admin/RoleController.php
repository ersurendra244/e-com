<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        $data['title'] = 'Roles';
        return view('admin.roles.index', $data);
    }

    public function create()
    {
        $data['title'] = 'Add Role';
        $data['subtitle'] = 'Roles';
        $data['permissions'] = Permission::orderBy('name', 'asc')->get()->groupBy(function ($permission) {
            return explode(' ', $permission->name)[0];
        });
        return view('admin.roles.create', $data);
    }

    public function list(Request $request)
    {
        $columns = ['id', 'name', 'created_at', 'id'];

        $totalData = Role::count();
        $totalFiltered = $totalData;
        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);
        $orderIndex = $request->input('order.0.column', 0);
        $order = $columns[$orderIndex] ?? 'id';
        $dir = $request->input('order.0.dir', 'asc');

        if (empty($request->input('search.value'))) {
            $model = Role::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $model = Role::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = Role::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->count();
        }

        $data = [];
        foreach ($model as $value) {
            $nestedData['id'] = $value->id;
            $nestedData['name'] = $value->name;
            $nestedData['created_at'] = date('d-m-Y', strtotime($value->created_at));
            $actions = "";
            if (Gate::allows('role edit')) {
                $actions .= '<a href="' . route('admin.roles.edit', $value->id) . '" class="btn btn-sm btn-info">Edit</a> ';
            }

            if (Gate::allows('role delete')) {
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

    public function edit(Request $request, $id)
    {
        $data['title'] = 'Edit Role';
        $data['subtitle'] = 'Roles';
        $data['data'] = Role::find($id);
        $data['data'] = Role::with('permissions')->findOrFail($id);
        $data['permissions'] = Permission::orderBy('name', 'asc')->get()->groupBy(function ($permission) {
            return explode(' ', $permission->name)[0];
        });
        return view('admin.roles.edit', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles',
            'permissions' => 'array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $role = Role::create(['name' => $request->name]);

        if (!empty($request->permissions)) {
            $role->givePermissionTo($request->permissions);
        }

        return redirect()->route('admin.roles')->with('success', 'Role saved successfully.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $id,
            'permissions' => 'array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);

        if (!empty($request->permissions)) {
            $role->permissions()->sync(Permission::whereIn('name', $request->permissions)->pluck('id'));
        } else {
            $role->permissions()->detach();
        }
        return redirect()->route('admin.roles')->with('success', 'Role updated successfully.');
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $model = Role::find($id);
        if ($model) {
            $model->delete();
            Session::flash('success', 'Role deleted successfully');
            return response()->json(['success' => true, 'message' => 'Role deleted successfully']);
        }
        Session::flash('error', 'Role not found');
        return response()->json(['success' => false, 'message' => 'Role not found']);
    }
}
