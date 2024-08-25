<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\BooksModels;
use App\Http\Requests\BooksRequest;

class Books extends Controller
{

    public function __construct()
    {
        $this->middleware(['isOwner'])->only(
            'store',
            'update',
            'destroy'
        );
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookTrending = BooksModels::select('id', 'title', 'image')->inRandomOrder()->limit(6)->get();
        $book = BooksModels::select('books.id', 'books.title', 'books.summary', 'books.image', 'books.stock', 'categories.name as category')->join('categories', 'categories.id', '=', 'books.category_id')->get();

        return response()->json([
            'message' => 'Get Book List Success',
            'trending' => $bookTrending,
            'data' => $book,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BooksRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {


            $imageName = time() . '.' . $request->image->extension();

            $request->image->storeAs('public/image', $imageName);

            $path = env('APP_URL') . '/storage/image/';

            $data['image'] = $path . $imageName;

        }

        BooksModels::create($data);

        return response()->json(['success' => 'Data Added successfully.']);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = BooksModels::with('category')->find($id);
        $borrows = $book->listBorrows()->get();
        if (!$book) {
            return response()->json([
                "message" => "Book Not Found",
            ], 404);
        }


        return response()->json([
            "message" => "Book Detail:",
            "data" => $book,
            'ListBorrows' => $borrows
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateBook(BooksRequest $request, string $id)
    {
        $data = $request->validated();

        $bookData = BooksModels::find($id);

        if (!$bookData) {
            return response()->json([
                'message' => 'Book id tidak ditemukan!'
            ], 404);
        }

        if ($request->hasFile('image')) {
            if ($bookData->image) {
                $imageName = basename($bookData->image);
                Storage::delete('public/image/' . $imageName);
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/image', $imageName);

            $path = env('APP_URL') . '/storage/image/';
            $data['image'] = $path . $imageName;
        } else {
            $data['image'] = $bookData->image;
        }

        $bookData->update($data);

        return response()->json([
            'success' => 'Data Updated successfully!',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = BooksModels::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Book Not Found!'
            ], 404);
        }

        $book->delete();
        return response()->json(['success' => 'Data Deleted successfully!'], 201);
    }
}
