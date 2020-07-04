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

    public function addNews(Request $request)
    {
        $image = $request->file;
        $fileExt = time().'.'.$image->getClientOriginalName();
        $request->file->move('upload/imgs/', $fileExt);

//        $filename = $request->file->getClientOriginalName();
//        $path = hash( 'sha256', time());
        if($request->file)
        {
            $input['cover'] = $fileExt;
            $input['title'] = $request->title;
            $input['description'] = $request->text;
            $input['user_id'] = $request->user_id;

            $file = Article::create($input);

            return response()->json([
                'success' => true,
                'id' => $file->id
            ], 200);
        }
        return response()->json([
            'success' => false
        ], 500);
    }

    public function upload(Request $request)
    {
        return response()->json([
            'success' => true,
        ], 200);
    }
}
