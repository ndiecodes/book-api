<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class BookController extends Controller
{

    public function __construct()
    { }

    public function showAll()
    {
        return response()->json(['data' => Book::all()], 200);
    }

    public function show($id)
    {
        try {

            $book = Book::findOrFail($id);

            return response()->json(['data' => $book], 200);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Book not found!'], 404);
        }
    }

    public function validateRequest($request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'author' => 'required|string',
            'price' => 'required|integer'
        ]);
    }

    public function store(Request $request)
    {

        $this->validateRequest($request);

        try {
            $book = new Book;
            $book->title = $request->input('title');
            $book->author = $request->input('author');
            $book->price = $request->input('price');

            $book->save();

            return response()->json(['data' => $book, 'message' => 'CREATED'], 201);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Resource Creation Failed!'], 409);
        }
    }

    public function update(Request $request, $id)
    {

        $this->validateRequest($request);

        try {
            $book = Book::findOrFail($id);

            $book->title = $request->input('title');
            $book->author = $request->input('author');
            $book->price = $request->input('price');

            $book->save();

            return response()->json(['data' => $book, 'message' => 'UPDATED'], 200);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Book not found!'], 404);
        }
    }

    public function destroy($id)
    {
        try {

            $book = Book::findOrFail($id);

            $book->delete();

            return response()->json(['data' => $book, 'message' => 'DELETED'], 200);
        } catch (\Exception $e) {

            return response()->json(['message' => 'Book not found!'], 404);
        }
    }
}
