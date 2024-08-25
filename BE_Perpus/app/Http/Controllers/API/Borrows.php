<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BorrowsModels;
use Illuminate\Support\Facades\Validator;

class Borrows extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Load_date' => 'required',
            'Borrow_date' => 'required',
            'book_id' => 'required|exists:books,id',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $borrow = BorrowsModels::updateOrCreate(
            ['user_id' => auth()->user()->id],
            [
                'Load_date' => $request['Load_date'],
                'Borrow_date' => $request['Borrow_date'],
                'book_id' => $request['book_id']
            ]
        );
        return response()->json([
            'message' => 'Borrow Book Create or Update successfully',
            'data' => $borrow
        ]);
    }

    public function index()
    {

        $borrows = BorrowsModels::with(['listBook', 'listUser'])->get();

        return response()->json([
            'message' => 'tampil semua Borrow',
            'data' => $borrows
        ], 200);
    }
}
