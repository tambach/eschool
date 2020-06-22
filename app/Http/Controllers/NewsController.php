<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function getAll()
    {
        $articles = Article::all();
        return response(['data' => $articles ], 200);
    }

    public function getById(Request $request)
    {
        $id = $request->id;
        $article = Article::find($id);
        return response(['data' => $article ], 200);
    }
}
