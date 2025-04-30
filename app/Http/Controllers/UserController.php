<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
// use Illuminate\Foundation\Auth\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json([
            'status' => 200,
            'data' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {   
        $user = User::create([

            "name"=> $request->name,
            "email"=> $request->email,
            'password'=> bcrypt($request->password),
        ]);
        return response()->json([
            'status' => 200,
            'data' => $user,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::with('posts')->find($id);

        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'User topilmadi'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 404,    
                'message' => 'User topilmadi'
            ], 404);
        }

        
        $user->update( $request->all());

        return response()->json([
            'status' => 200,
            'data' => $user
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'User topilmadi'
            ], 404);
        }
        $user->delete();
        return response()->json([
            'status' => 200,
            'message' => 'User o\'chirildi'
        ]);
    }
}
