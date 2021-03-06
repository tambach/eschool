<?php

namespace App\Http\Controllers;

use App\Homework;
use App\HomeWorkFiles;
use Illuminate\Http\Request;

class HomeWorkController extends Controller
{
    public function getList(Request $request)
    {
        $user_id   = $request['user_id'];
        $lesson_id = $request['lesson_id'];

//        $user = User::find($user_id);
//        $rating = $user->class->classLessons->where('id', $lesson_id)->homeWork;
//        $lesson = Lesson::find($lesson_id);
//        $hw = $lesson->homework->sortByDesc('created_at')->take(1)->get();

        $hw = Homework::where('lesson_id', $lesson_id)->orderBy('created_at', 'DESC')->limit(1)->get();

        $hww = Homework::where('lesson_id', $lesson_id)->orderBy('created_at', 'DESC')->first();

        $file = HomeWorkFiles::where('student_id',$user_id)->where('homework_id', $hww->id)->first();

        if($file)
        {
            return response()->json([
                'status' => 1,
                'id' => $file->id,
                'hw' =>$hw,
            ], 200);
        }
        else{
            return response()->json([
                'status' => 0,
                'hw' =>$hw,
            ], 200);
        }

//        $files = HomeWorkFiles::where('homework_id', $hw->id)->orderBy('created_at', 'DESC')->first();
//
//        if(file_exists(public_path('upload') . '/591903063.pages' ))
//        {
//            return Response::download(public_path('upload') . '/591903063.pages' );
//        }

    }

    public function uploadFile(Request $request)
    {
        $fileExt = time().'.'.$request->file->getClientOriginalExtension();
        //$request->file->move(public_path('upload'), $fileExt);
        $request->file->move('storage/files/', $fileExt);


        $filename = $request->file->getClientOriginalName();
        $path = hash( 'sha256', time());
        if($request->file)
        {
            $input['filename'] = $filename;
            $input['mime'] = $request->file->getClientMimeType();
            $input['path'] = $path;
            $input['student_id'] = $request->user;
            $input['homework_id'] = $request->homework;
            //$input['size'] = $request->file->getClientSize();
            $file = HomeWorkFiles::create($input);

            return response()->json([
                'success' => true,
                'id' => $file->id
            ], 200);
        }
        return response()->json([
            'success' => false
        ], 500);
    }

    public function postHomeWork(Request $request)
    {
        $input['mime'] = $request->text;
        $input['filename'] = $request->title;
        $input['student_id'] = $request->userid;
        $input['homework_id'] = $request->hwid;

        $file = HomeWorkFiles::create($input);

        return response()->json([
            'success' => true,
            'id' => $request->text
        ], 200);
    }

    public function filesbyid(Request $request)
    {
        $id = $request->id;
        $file = HomeWorkFiles::find($id);

        return response()->json([
            'file' => $file
        ], 200);
    }

    public function getFiles()
    {
        return response()->download(public_path('upload/1591903063.pages'));
    }
}
