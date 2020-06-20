<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function getBooks()
    {
        $books = Book::all();
        return response(['data' => $books ], 200);
    }

    public function download(Request $request)
    {
        //return User::all();
        //$file = Book::find($request->file);
        return response()->download(public_path('upload/'.$request->file));
    }
}
