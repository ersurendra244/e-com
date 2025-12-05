<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function index()
    {
        $data['title'] = 'Pages';
        $data['subtitle'] = '';
        return view('admin.pages.index', $data);
    }
    public function list(Request $request)
    {
        $columns = ['id', 'name', 'status'];
        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);
        $orderIndex = $request->input('order.0.column', 0);
        $order = $columns[$orderIndex] ?? 'id';
        $dir = $request->input('order.0.dir', 'asc');
        $search = $request->input('search.value');

        // Base query
        $query = Page::where('is_delete', '0');
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
            $nestedData['name'] = $value->name;
            $status = $value->status == 1 ? '<label class="badge badge-outline-success badge-pill py-1">Active</label>' : '<label class="badge badge-outline-danger badge-pill py-1">Inactive</label>';
            $nestedData['status'] = $status;

            $actions = "";
            if (Gate::allows('page edit')) {
                $actions .= '<a href="' . route('admin.pages.edit', $value->slug) . '" class="btn btn-sm btn-info">Edit</a> ';
            }
            if (Gate::allows('page delete')) {
                $actions .= '<a href="javascript:void(0)" onclick="deleteData(`' . route('admin.pages.delete', $value->slug) . '`)" class="btn btn-sm btn-danger">Delete</a>';
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
        $data['title'] = 'Add Page';
        $data['subtitle'] = '';
        return view('admin.pages.create', $data);
    }
    public function edit(Request $request, $slug)
    {
        $data['title'] = 'Edit Page';
        $data['subtitle'] = '';
        $data['edit_data'] = Page::where('slug', $slug)->first();
        return view('admin.pages.edit', $data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:pages,name',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $modal = new Page();
        $modal->name = $request->name;
        $modal->slug = slug($request->name);
        $modal->description = $request->description;
        $modal->status = $request->status;
        // return $modal;
        $modal->save();
        return redirect()->route('admin.pages')->with('success', 'Page saved successfully');
    }
    public function update(Request $request, $slug)
    {
        $modal = Page::where('slug', $slug)->firstOrFail();
        // dd($request->all(), $modal->id);
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('pages')->where(function ($query) {
                    return $query;
                })->ignore($modal->id),
            ],
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $modal->name = $request->name;
        $modal->slug = slug($request->name);
        $modal->description = $request->description;
        $modal->status = $request->status;
        $modal->update();
        return redirect()->route('admin.pages')->with('success', 'Page updated successfully');
    }
    public function delete($slug)
    {
        $modal = Page::where('slug', $slug)->first();
        if ($modal) {
            $modal->status = '0';
            $modal->is_delete = '1';
            $modal->save();
            Session::flash('success', 'Page deleted successfully');
            return response()->json(['success' => true]);
        }
        Session::flash('error', 'Page not found');
        return response()->json(['success' => false]);
    }
}
