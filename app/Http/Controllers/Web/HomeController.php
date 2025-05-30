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
        $data['featuredProducts'] = Product::with('variants')->withAvg('reviews', 'rating')->where('is_featured', 1)->limit(8)->get();
        // return $data['featuredProducts'][0]->variants[0]->images[0];
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

        $modal = new Contact();
        $modal->name = $request->name;
        $modal->email = $request->email;
        $modal->subject = $request->subject;
        $modal->message = $request->message;
        $modal->status = 0;
        $modal->save();

        return response()->json(['status' => 'success', 'message' => 'Message sent successfully']);
    }


}
