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
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:settings,title,' . $id,
            'header_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'footer_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $modal = Setting::find($id);
        if ($request->hasFile('header_logo')) {
            if ($modal->header_logo && file_exists(public_path('uploads/settings/' . $modal->header_logo))) {
                unlink(public_path('uploads/settings/' . $modal->header_logo));
            }

            $header_logo = $request->file('header_logo');
            $header_logoName = time() . '_' . uniqid() . '.' . $header_logo->getClientOriginalExtension();
            $header_logo->move(public_path('uploads/settings'), $header_logoName);
            $modal->header_logo = $header_logoName;
        }
        if ($request->hasFile('footer_logo')) {
            if ($modal->footer_logo && file_exists(public_path('uploads/settings/' . $modal->footer_logo))) {
                unlink(public_path('uploads/settings/' . $modal->footer_logo));
            }

            $footer_logo = $request->file('footer_logo');
            $footer_logoName = time() . '_' . uniqid() . '.' . $footer_logo->getClientOriginalExtension();
            $footer_logo->move(public_path('uploads/settings'), $footer_logoName);
            $modal->footer_logo = $footer_logoName;
        }

        $modal->title = $request->title;
        $modal->description = $request->description;
        $modal->email = $request->email;
        $modal->phone = $request->phone;
        $modal->address = $request->address;
        $modal->post_code = $request->post_code;
        $modal->facebook_url = $request->facebook_url;
        $modal->twitter_url = $request->twitter_url;
        $modal->linkedin_url = $request->linkedin_url;
        $modal->instagram_url = $request->instagram_url;
        $modal->map_iframe = $request->map_iframe;
        $modal->save();
        return redirect()->back()->with('success', 'Setting updated successfully');
    }
}
