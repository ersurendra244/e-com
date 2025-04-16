<?php

namespace App\Http\Controllers\Web;

use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        $data['title'] = 'home';
        $data['featuredProducts'] = Product::withAvg('reviews', 'rating')->where('is_featured', 1)->limit(8)->get();
        $data['recentProducts'] = Product::withAvg('reviews', 'rating')->latest()->limit(8)->get();
        $data['categories'] = Category::where('status', '1')->latest()->limit(8)->get();
        return view('web.home', $data);
    }

    public function contact_us()
    {
        $data['title'] = 'Contact Us';
        $data['featuredProducts'] = Product::withAvg('reviews', 'rating')->where('is_featured', 1)->limit(8)->get();
        $data['recentProducts'] = Product::withAvg('reviews', 'rating')->latest()->limit(8)->get();
        $data['categories'] = Category::where('status', '1')->latest()->limit(8)->get();
        return view('web.contact_us', $data);
    }

    public function contact_us_save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }

        $model = new Contact();
        $model->name = $request->name;
        $model->email = $request->email;
        $model->subject = $request->subject;
        $model->message = $request->message;
        $model->status = 0;
        $model->save();

        return response()->json(['status' => 'success', 'message' => 'Message sent successfully']);
    }


}
