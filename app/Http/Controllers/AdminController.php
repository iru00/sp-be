<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AdminController extends Controller
{
    public function CreateUser(Request $request){
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'phone_num'      => 'required',
            'date_of_birth'  => 'required',
            'gender'  => 'required',
            'password'  => 'required|min:8|confirmed',
            'role' => '',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));

        return response()->json([
            'message' => 'User successfully created',
            'user' => $user
        ], 201);
    }

    public function updateUser(Request $request, $id){
        $user = User::findOrFail($id);
    
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email,'.$user->id,
            'phone_num' => 'required',
            'date_of_birth' => 'required',
            'gender'    => 'required',
            'password'  => 'sometimes|required|min:8|confirmed',
            'role'      => '',
        ]);
    
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
    
        $dataToUpdate = $request->only(['name', 'email', 'phone_num', 'date_of_birth', 'gender', 'role']);
    
        if ($request->has('password')) {
            $dataToUpdate['password'] = bcrypt($request->password);
        }
    
        if (!array_diff_assoc($dataToUpdate, $user->toArray())) {
            return response()->json(['message' => 'No changes were made.'], 200);
        }
    
        $user->update($dataToUpdate);
    
        return response()->json([
            'message' => 'User successfully updated',
            'user' => $user
        ], 201);
    }
    
    public function deleteUser($id){
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json([
            'message' => 'User successfully deleted'
        ], 201);
    }
}
