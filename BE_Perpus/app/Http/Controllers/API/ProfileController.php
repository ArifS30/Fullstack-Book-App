<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfileModels;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'age' => 'required',
            'bio' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $profile = ProfileModels::updateOrCreate(
            ['user_id' => auth()->user()->id],
            $request->all()
        );
        return response()->json([
            'message' => 'Profile updated!',
            'data' => $profile
        ]);
    }
}
