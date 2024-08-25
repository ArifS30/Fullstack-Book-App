<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoriesModels;
use App\Http\Requests\CategoriesRequest;

class Categories extends Controller
{

    public function __construct()
    {
        $this->middleware(['isOwner'])->only(
            'store','update','destroy');
    }
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = CategoriesModels::all();
        return response()->json([
            "message" => "All Categories",
            "data" => $categories
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoriesRequest $request)
    {
        CategoriesModels::create($request->all());

        return response()->json(['success' => 'Data Added successfully.']);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = CategoriesModels::with('listBooks')->find($id);

        if(!$category){
            return response()->json([
                "message" => "Category Not Found",
            ],404);
        }


        return response()->json([
            "message" => "Category Detail:",
            "data" => $category
        ],200);


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoriesRequest $request, string $id)
    {
        $category = CategoriesModels::find($id);

        if(!$category){
            return response()->json([
                'message' => 'Category Not Found!'
            ],404);
        }

        $category->name = $request->name;


         $category->save();
         return response()->json([
            'message' => 'Succes Update Category ID:'.$id,
        "data" => $category], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = CategoriesModels::find($id);

        if(!$category){
            return response()->json([
                'message' => 'Category Not Found!'
            ],404);
        }


        $category->delete();
        return response()->json([
            'message' => 'Succes Delete Category ID:'.$id], 201);
    }
}
