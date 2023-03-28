<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function getuserdata(Request $request)
    {

        //    if (Auth::user()) {
        //     # code...
        //    }
        $user1 = $request->all();
        $user = $user1['role'];
        if ($user == 'admin') {
            $data = User::where('role', 'user')->get();
            return response()->json(["status" => true, "data" => $data]);
        } else if ($user == 'superadmin') {
            # code...
            $excludeRoles = ['superadmin'];
            $data = User::where('role', '!=', 'superadmin')
                ->whereNotIn('role', $excludeRoles)
                ->get();
            return response()->json(["status" => true, "data" => $data]);
        } else {
            $data = [];
            return response()->json(["status" => true, "data" => $data]);
        }
    }

    public function register(Request $request)
    {

        $data = $request->all();
        $check = $this->create($data);
        return response()->json(["status" => true, "message" => "Form submitted successfully"]);
    }
    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function createuser(Request $request)
    {

        $data = $request->all();
        $check = $this->usercreate($data);
        return response()->json(["status" => true, "message" => "Form submitted successfully"]);
    }
    public function usercreate(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $credentials = request(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $user = Auth::user(); // Get the authenticated user
            return response()->json(['user' => $user, 'message' => true], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['status' => true]);
    }

}
