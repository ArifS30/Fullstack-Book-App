<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RolesModels;
use Illuminate\Support\Facades\Validator;

class Roles extends Controller
{
    public function index()
    {
        $roles = RolesModels::all();
        return response()->json([
            'message' => 'All Roles',
            'data' => $roles,
        ],200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        RolesModels::create([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Successfully created role',
        ], 201);
    }

    public function update(Request $request,string $id)
    {
        $role = RolesModels::find($id);

        if(!$role){
            return response()->json([
                'message' => 'Role not found!'
            ],404);
        }

        $role->name = $request->name;

        $role->save();
        return response()->json([
            'message' => 'Role Data successfully updated',
            'data' => $role
        ]);
    }

    public function destroy(string $id)
    {
        $role = RolesModels::find($id);
        if(!$role){
            return response()->json([
                'message' => 'Role not found!'
            ],404);
        }
        $role->delete();
        return response()->json([
            'message' => 'Role Data  successfully deleted',
        ]);
    }
}


