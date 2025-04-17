<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Site Settings';
        $data['subtitle'] = 'Settings';
        $data['edit_data'] = Setting::where('id', 1)->first();
        return view('admin.settings.edit', $data);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:settings,title,' . $id,
            'header_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'footer_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = Setting::find($id);
        if ($request->hasFile('header_logo')) {
            if ($model->header_logo && file_exists(public_path('uploads/settings/' . $model->header_logo))) {
                unlink(public_path('uploads/settings/' . $model->header_logo));
            }

            $header_logo = $request->file('header_logo');
            $header_logoName = time() . '_' . uniqid() . '.' . $header_logo->getClientOriginalExtension();
            $header_logo->move(public_path('uploads/settings'), $header_logoName);
            $model->header_logo = $header_logoName;
        }
        if ($request->hasFile('footer_logo')) {
            if ($model->footer_logo && file_exists(public_path('uploads/settings/' . $model->footer_logo))) {
                unlink(public_path('uploads/settings/' . $model->footer_logo));
            }

            $footer_logo = $request->file('footer_logo');
            $footer_logoName = time() . '_' . uniqid() . '.' . $footer_logo->getClientOriginalExtension();
            $footer_logo->move(public_path('uploads/settings'), $footer_logoName);
            $model->footer_logo = $footer_logoName;
        }

        $model->title = $request->title;
        $model->description = $request->description;
        $model->email = $request->email;
        $model->phone = $request->phone;
        $model->address = $request->address;
        $model->post_code = $request->post_code;
        $model->facebook_url = $request->facebook_url;
        $model->twitter_url = $request->twitter_url;
        $model->linkedin_url = $request->linkedin_url;
        $model->instagram_url = $request->instagram_url;
        $model->map_iframe = $request->map_iframe;
        $model->save();
        return redirect()->back()->with('success', 'Setting updated successfully');
    }
}
