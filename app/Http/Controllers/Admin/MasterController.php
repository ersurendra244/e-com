<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Models\Menu;
use App\Models\Brand;
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
        $data['menus'] = Menu::where('is_delete', '0')->get();
        return view('admin.masters.menu_list', $data);
    }
    public function menu_edit(Request $request)
    {
        $id = $request->id;
        $data = Menu::find($id);
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function menu_save(Request $request)
    {
        $edit_id = $request->edit_id;
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('menus')->where(function ($query) {
                    return $query;
                })->ignore($edit_id),
            ],
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }
        if($edit_id){
            $modal = Menu::find($edit_id);
            $msg = 'Menu updated successfully';
        } else {
            $modal = new Menu();
            $msg = 'Menu added successfully';
        }
        if ($request->hasFile('image')) {
            if ($modal->image && file_exists(public_path('uploads/menus/' . $modal->image))) {
                unlink(public_path('uploads/menus/' . $modal->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/menus'), $imageName);
            $modal->image = $imageName;
        }
        $modal->name = $request->name;
        $modal->is_home = $request->is_home;
        $modal->order = $request->order;
        $modal->status = $request->status;
        $modal->save();
        Session::flash('success', $msg);
        return response()->json(['status' => 'success', 'message' => $msg]);
    }

    public function menu_delete($id)
    {
        $modal = Menu::find($id);
        if ($modal) {
            $modal->status = '0';
            $modal->is_delete = '1';
            $modal->save();
            Session::flash('success', 'Menu deleted successfully');
            return response()->json(['success' => true]);
        }
        Session::flash('error', 'Menu not found');
        return response()->json(['success' => false]);
    }


    public function brand()
    {
        $data['title'] = 'Brand List';
        $data['subtitle'] = 'Master';
        $data['brands'] = Brand::where('is_delete', '0')->get();
        return view('admin.masters.brand_list', $data);
    }
    public function brand_edit(Request $request)
    {
        $id = $request->id;
        $data = Brand::find($id);
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function brand_save(Request $request)
    {
        $edit_id = $request->edit_id;
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('brands')->where(function ($query) {
                    return $query;
                })->ignore($edit_id),
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }
        if($edit_id){
            $modal = Brand::find($edit_id);
            $msg = 'Brand updated successfully';
        } else {
            $modal = new Brand();
            $msg = 'Brand added successfully';
        }
        if ($request->hasFile('image')) {
            if ($modal->image && file_exists(public_path('uploads/brands/' . $modal->image))) {
                unlink(public_path('uploads/brands/' . $modal->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/brands'), $imageName);
            $modal->image = $imageName;
        }
        $modal->name = $request->name;
        $modal->status = $request->status;
        $modal->save();
        Session::flash('success', $msg);
        return response()->json(['status' => 'success', 'message' => $msg]);
    }

    public function brand_delete($id)
    {
        $modal = Brand::find($id);
        if ($modal) {
            $modal->status = '0';
            $modal->is_delete = '1';
            $modal->save();
            Session::flash('success', 'Brand deleted successfully');
            return response()->json(['success' => true]);
        }
        Session::flash('error', 'Brand not found');
        return response()->json(['success' => false]);
    }

    public function item_type()
    {
        $data['title'] = 'Item type List';
        $data['subtitle'] = 'Master';
        $data['item_types'] = Item::where('is_delete', '0')->get();
        return view('admin.masters.item_type_list', $data);
    }
    public function item_type_edit(Request $request)
    {
        $id = $request->id;
        $data = Item::find($id);
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function item_type_save(Request $request)
    {
        $edit_id = $request->edit_id;
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('items')->where(function ($query) {
                    return $query;
                })->ignore($edit_id),
            ],
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }
        if($edit_id){
            $modal = Item::find($edit_id);
            $msg = 'Item type updated successfully';
        } else {
            $modal = new Item();
            $msg = 'Item type added successfully';
        }
        if ($request->hasFile('image')) {
            if ($modal->image && file_exists(public_path('uploads/item_type/' . $modal->image))) {
                unlink(public_path('uploads/item_type/' . $modal->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/item_type'), $imageName);
            $modal->image = $imageName;
        }
        $modal->name = $request->name;
        $modal->status = $request->status;
        $modal->save();
        Session::flash('success', $msg);
        return response()->json(['status' => 'success', 'message' => $msg]);
    }

    public function item_type_delete($id)
    {
        $modal = Item::find($id);
        if ($modal) {
            $modal->status = '0';
            $modal->is_delete = '1';
            $modal->save();
            Session::flash('success', 'Item type deleted successfully');
            return response()->json(['success' => true]);
        }
        Session::flash('error', 'Item type not found');
        return response()->json(['success' => false]);
    }
}
