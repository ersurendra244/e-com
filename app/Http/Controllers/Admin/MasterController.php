<?php

namespace App\Http\Controllers\Admin;

use App\Models\Master;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class MasterController extends Controller
{
    public function menu()
    {
        $data['title'] = 'Menu List';
        $data['subtitle'] = 'Master';
        $data['menus'] = Master::where('type', 'menu')->get();
        return view('admin.masters.menu_list', $data);
    }
    public function menu_edit(Request $request)
    {
        $id = $request->id;
        $data = Master::find($id);
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function menu_save(Request $request)
    {
        $edit_id = $request->edit_id;
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('masters')->where(function ($query) {
                    return $query->where('type', 'menu');
                })->ignore($edit_id),
            ],
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }
        if($edit_id){
            $modal = Master::find($edit_id);
            $msg = 'Menu updated successfully';
        } else {
            $modal = new Master();
            $msg = 'Menu added successfully';
        }
        $modal->name = $request->name;
        $modal->type = 'menu';
        $modal->order = $request->order;
        $modal->status = $request->status;
        $modal->save();
        Session::flash('success', $msg);
        return response()->json(['status' => 'success', 'message' => $msg]);
    }

    public function menu_delete(Request $request)
    {
        $id = $request->id;
        $modal = Master::find($id);
        if ($modal) {
            $modal->status = '0';
            $modal->save();
            Session::flash('success', 'Menu deleted successfully');
            return response()->json(['success' => true, 'message' => 'Menu deleted successfully']);
        }
        Session::flash('error', 'Menu not found');
        return response()->json(['success' => false, 'message' => 'Menu not found']);
    }


}
