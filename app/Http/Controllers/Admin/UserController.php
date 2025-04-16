<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index()
    {
        $data['title'] = 'Users';
        return view('admin.users.index', $data);
    }

    public function list(Request $request)
    {
        $columns = ['id', 'image', 'name', 'email', 'phone', 'address'];

        $totalData = User::count();
        $totalFiltered = $totalData;
        $limit = $request->input('length', 10);
        $start = $request->input('start', 0);
        $orderIndex = $request->input('order.0.column', 0);
        $order = $columns[$orderIndex] ?? 'id';
        $dir = $request->input('order.0.dir', 'asc');

        if (empty($request->input('search.value'))) {
            $users = User::offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');

            $users = User::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('phone', 'LIKE', "%{$search}%")
                ->orWhere('address', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = User::where('id', 'LIKE', "%{$search}%")
                ->orWhere('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('phone', 'LIKE', "%{$search}%")
                ->orWhere('address', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = [];
        foreach ($users as $user) {
            $nestedData['id'] = $user->id;
            $nestedData['image'] = '<img class="img-sm rounded" src="' . asset('uploads/profile/' . $user->image) . '" alt=""/>';
            $nestedData['name'] = $user->name;
            $nestedData['email'] = $user->email;
            $nestedData['phone'] = $user->phone;
            $nestedData['address'] = $user->address;
            $nestedData['status'] = 'Active';

            // Initialize the action buttons
            $actions = "";
            if (Gate::allows('user edit')) {
                $actions .= '<a href="' . route('admin.users.edit', $user->id) . '" class="btn btn-sm btn-info">Edit</a> ';
            }

            if (Gate::allows('user delete')) {
                $actions .= '<a href="javascript:void(0)" onclick="deleteData({$user->id})" class="btn btn-sm btn-danger">Delete</a>';
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

    public function create(Request $request)
    {
        $data['title'] = 'Add User';
        $data['subtitle'] = 'Users';
        $data['roles'] = Role::all();
        return view('admin.users.create', $data);
    }
    public function edit(Request $request, $id)
    {
        $data['title'] = 'Edit User';
        $data['subtitle'] = 'Users';
        $data['user'] = User::find($id);
        $data['roles'] = Role::all();
        return view('admin.users.edit', $data);
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'phone' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pin_code' => 'required',
            'role' => 'required|exists:roles,id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new User();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->move(public_path('uploads/profile'), $imageName);

            $imagePath = $imageName;
            $user->image = $imagePath;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->pin_code = $request->pin_code;
        $user->password = Hash::make('password');
        $user->save();
        // Assign Role to User
        $user->roles()->sync([$request->role]);
        return redirect()->route('admin.users')->with('success', 'User saved successfully');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'phone' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pin_code' => 'required',
            'role' => 'required|exists:roles,id',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::find($id);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->move(public_path('uploads/profile'), $imageName);

            $imagePath = $imageName;
            $user->image = $imagePath;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->pin_code = $request->pin_code;
        // $user->password = Hash::make('password');
        $user->save();
        // Assign Role to User
        $user->roles()->sync([$request->role]);
        return redirect()->route('admin.users')->with('success', 'User updated successfully');
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);
        if ($user) {
            $user->status = '0';
            $user->save();
            Session::flash('success', 'User deleted successfully');
            return response()->json(['success' => true, 'message' => 'User deleted successfully']);
        }
        Session::flash('error', 'User not found');
        return response()->json(['success' => false, 'message' => 'User not found']);
    }

    public function edit_profile(Request $request)
    {
        $data['title'] = 'Edit Profile';
        $data['subtitle'] = '';
        $data['user'] = User::find(Auth::user()->id);
        return view('user.edit_profile', $data);
    }

    public function update_profile(Request $request)
    {
        $id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'phone' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pin_code' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::find($id);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->move(public_path('uploads/profile'), $imageName);

            $imagePath = $imageName;
            $user->image = $imagePath;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->pin_code = $request->pin_code;
        // $user->password = Hash::make('password');
        $user->save();
        return redirect()->back()->with('success', 'Profile updated successfully');

    }

    public function saved_address(Request $request)
    {
        $data['title'] = 'Saved Address';
        $data['subtitle'] = '';
        $data['user'] = User::find(Auth::user()->id);
        $data['addresses'] = Address::where('user_id', Auth::user()->id)->get();
        return view('user.saved_address', $data);
    }

    public function store_address(Request $request)
    {
        $id = Auth::user()->id;
        $edit_id = $request->edit_id;
        $validator = Validator::make($request->all(), [
            'street' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'postal_code' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }
        if($edit_id){
            $address = Address::find($edit_id);
            $msg = 'Address updated successfully';
        } else {
            $address = new Address();
            $msg = 'Address added successfully';
        }
        $address->user_id = $id;
        $address->street = $request->street;
        $address->city = $request->city;
        $address->state = $request->state;
        $address->country = $request->country;
        $address->postal_code = $request->postal_code;
        $address->save();
        Session::flash('success', $msg);
        return response()->json(['status' => 'success', 'message' => $msg]);
    }

    public function edit_address(Request $request)
    {
        $id = $request->id;
        $data = Address::find($id);
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function update_password(Request $request)
    {
        $id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()]);
        }

        $user = User::find($id);
        $user->password = Hash::make($request->password);
        $user->save();
        Session::flash('success', 'Password updated successfully');
        return response()->json(['status' => 'success', 'message' => 'Password updated successfully']);

    }

    public function reviews(Request $request)
    {
        $data['title'] = 'Reviews';
        $data['subtitle'] = 'Products';
        return view('user.reviews', $data);
    }

    public function reviews_list(Request $request)
    {
        $columns = ['id', 'pid', 'product:name', 'product:category', 'reviews', 'rating','created_at'];
        $user = User::find(Auth::user()->id);
        $query = $user->reviews()->with(['product:id,name,category']);
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

            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                  ->orWhere('reviews', 'LIKE', "%{$search}%")
                  ->orWhere('rating', 'LIKE', "%{$search}%");
            });

            // Update filtered count (clone query again if needed)
            $totalFiltered = $query->count();
        }

        $reviews = $query->offset($start)->limit($limit)->orderBy($order, $dir)->get();
        // return $reviews;
        $data = [];
        foreach ($reviews as $key => $review) {
            $nestedData['id'] = ++$key;
            $nestedData['product'] = $review->product->name ?? 'N/A';
            $nestedData['category'] = $review->product->category ?? 'N/A';
            $nestedData['reviews'] = '<div>' . $review->reviews.'</div>';
            $nestedData['reviews'] .= '<div class="ratings mt-2">';
            for ($i = 1; $i <= 5; $i++) {
                $nestedData['reviews'] .= '<i class="fa fa-star ' . ($i <= $review->rating ? 'gold' : 'gray') . '"></i>';
            }
            $nestedData['reviews'] .= '</div>';
            $nestedData['created_at'] = date('d-m-Y', strtotime($review->created_at));
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

}
