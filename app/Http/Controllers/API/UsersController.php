<?php

namespace App\Http\Controllers\API;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function index(Request $request)
    {

        return new UserCollection(User::where('name', 'LIKE', "%" . $request->search . "%")->orderBy('id', 'desc')->paginate(10));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'username' => 'required|min:6',
            'level' => 'required|in:Admin,Kasir',
            'address' => 'required',
            'phone' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }

        if ($request->hasFile('photo') == true) {
            $photo = $request->file('photo');
            $photo_name = date('siHdmY') . '_' . $photo->getClientOriginalName();
            $photo->move('images/users/', $photo_name);
            $image = '/images/users/' . $photo_name;
        } else {
            $image = $request->image;
        }

        if ($request->id == true) {
            if ($request->password == true) {
                $dataUser = [
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'level' => $request->level,
                    'image' => $image,
                    'password' => Hash::make($request->password),
                ];
            } else {
                $dataUser = [
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'level' => $request->level,
                    'image' => $image,
                ];
            }
        } else {
            $username = User::where('username', $request->username)->count();
            $email = User::where('email', $request->email)->count();
            if ($username > 0) {
                return response("username sudah terdaftar", 400);
            } elseif ($email > 0) {
                return response("email sudah terdaftar", 400);
            } else {
                $dataUser = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'username' => $request->username,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'level' => $request->level,
                    'image' => $image,
                    'password' => Hash::make($request->password),
                ];
            }
        }

        User::UpdateOrCreate(['id' => $request->id], $dataUser);

        return response(['success' => true], 200);
    }

    public function show($id)
    {
        return User::findorfail($id);
    }

    public function edit($id)
    {
        return User::findorfail($id);
    }

    public function update(Request $request, $id)
    {
        // 
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return response(['status' => true]);
    }
}
