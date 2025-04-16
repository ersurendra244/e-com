<?php

namespace App\Http\Controllers\Admin;

use App\Models\File;
use App\Models\Role;
use App\Models\User;
use App\Models\FileShare;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    public function index()
    {
        // $files = File::with('shares')->get();
        // return view('files.index', compact('files'));
        $data['title'] = 'Files';
        $data['roles'] = Role::all();
        return view('admin.files.index', $data);
    }

    public function create()
    {
        $data['title'] = 'Create File';
        $data['subtitle'] = 'Files';
        $data['roles'] = Role::all();
        return view('admin.files.create', $data);
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'filename' => 'required|unique:files,filename',
            'remark' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $model = new File();
        if ($request->hasFile('uploadfile')) {
            $image = $request->file('uploadfile');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->move(public_path('uploads/files'), $imageName);
            $imagePath = $imageName;
            $model->uploadfile = $imageName;
        }
        $model->filename = $request->filename;
        $model->remark = $request->remark;
        $model->created_by = Auth::user()->id;
        $model->save();
        if ($request->has('role_id') && $request->has('user_id')) {
            FileShare::create([
                'file_id' => $model->id,
                'role_id' => $request->role_id,
                'user_id' => $request->user_id,
                'action_type' => 'forwarded',
                'action_by' => Auth::user()->id,
            ]);
        }
        return redirect()->route('admin.files')->with('success', 'File created successfully');
    }

    public function list(Request $request)
    {
        $columns = ['id', 'uploadfile', 'filename', 'remark', 'created_by', 'created_at', 'action'];

        // $query = File::with('shares');
        if (Auth::user()->hasRole('admin')) {
            $query = File::with('shares');
        }else {
            $query = File::whereHas('shares', function ($query) {
                $query->where('user_id', Auth::id());
            })->with('shares');
        }
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
                    ->orWhere('filename', 'LIKE', "%{$search}%")
                    ->orWhere('created_by', 'LIKE', "%{$search}%");
            });

            $totalFiltered = $filteredQuery->where(function ($query) use ($search) {
                $query->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('filename', 'LIKE', "%{$search}%")
                    ->orWhere('created_by', 'LIKE', "%{$search}%");
            })->count();
        }

        $results = $query->offset($start)->limit($limit)->orderBy($order, $dir)->get();
        // return $results;
        $data = [];
        foreach ($results as $value) {
            $nestedData['id'] = $value->id;
            $nestedData['uploadfile'] = '<img class="img-sm rounded" src="' . asset('uploads/files/' . $value->uploadfile) . '" alt=""/>';
            $nestedData['filename'] = $value->filename;
            $nestedData['remark'] = $value->remark;
            $nestedData['created_by'] = getUserName($value->created_by);
            $nestedData['created_at'] = date('d-m-Y', strtotime($value->created_at));
            $actions = "";
            if (Gate::allows('file edit')) {
                $actions .= '<a href="' . route('admin.files.edit', $value->id) . '" class="btn btn-sm btn-info">Edit</a> ';
            }
            if (Gate::allows('file review')) {
                $actions .= '<a href="' . route('admin.files.reviews', $value->id) . '" class="btn btn-sm btn-warning">Reviews</a> ';
            }
            if($value->shares->isNotEmpty() && $value->shares->first()->action_type == 'forwarded') {
                $actions .= '<a href="javascript:void(0)" onclick="fileShare(' . $value->id . ', \'return\')" class="btn btn-sm btn-success">Return</a> ';
            }
            $actions .= '<a href="javascript:void(0)" onclick="fileShare(' . $value->id . ', \'forwarded\')" class="btn btn-sm btn-primary">Forward</a> ';
            if (Gate::allows('file delete')) {
                $actions .= '<a href="javascript:void(0)" onclick="deleteData(' . $value->id . ')" class="btn btn-sm btn-danger">Delete</a>';
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
        $data['title'] = 'Edit File';
        $data['subtitle'] = 'Files';
        $data['roles'] = Role::all();
        $data['edit_data'] = File::find($id);
        return view('admin.files.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'filename' => 'required|unique:files,filename,'.$id,
            'remark' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $model = File::find($id);
        if ($request->hasFile('uploadfile')) {
            $image = $request->file('uploadfile');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->move(public_path('uploads/files'), $imageName);
            $imagePath = $imageName;
            $model->uploadfile = $imageName;
        }
        $model->filename = $request->filename;
        $model->remark = $request->remark;
        $model->created_by = Auth::user()->id;
        $model->save();

        return redirect()->route('admin.files')->with('success', 'File updated successfully');
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $model = File::find($id);
        if ($model) {
            // $model->status = '0';
            $model->delete();
            Session::flash('success', 'File deleted successfully');
            return response()->json(['success' => true, 'message' => 'File deleted successfully']);
        }
        Session::flash('error', 'File not found');
        return response()->json(['success' => false, 'message' => 'File not found']);
    }

    public function share(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'user_id' => 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ]);
        }

        FileShare::create([
            'file_id' => $request->file_id,
            'role_id' => $request->role_id,
            'user_id' => $request->user_id,
            'action_type' => $request->action_type,
            'action_by' => Auth::user()->id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'File shared successfully!',
        ]);
    }

}
