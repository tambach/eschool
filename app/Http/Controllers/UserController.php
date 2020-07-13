<?php

namespace App\Http\Controllers;

use App\Mail\SendEmailMailable;
use App\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Validator;

class UserController extends Controller
{
    public function getAllStudents(Request $request)
    {
        $per_page = isset($request->per_page) ? $request->per_page : 10;
        $limit    = isset($request->limit) ? $request->limit : 200;
        $sort_field = $request->sort_field ?? 'created_at';
        $sort_order = (!empty($request->sort_order)) ? ($request->sort_order == 'descending') ? 'desc' : 'asc' : '';
        $id = ( $request->id != 0) ? $request->id : 0;
        $search    = ($request->search !== 0)  ? $request->search : 0;


        $result = DB::table('users')
            ->where('role_id','=', 2)
//            ->when($id , function ($query, $id) {
//                return  $query->where(function (Builder $query) use ($id) {
//                    $query->where('users.id','=', $id);
//                });
//            })
//            ->when($search , function ($query, $search) {
//                return  $query->where(function (Builder $query) use ($search) {
//                    $query->where('users.username','like', '%'.strtolower($search).'%')
//                        ->orWhere('users.name', 'like', '%'.strtolower($search).'%');
//                });
//            })
            ->orderBy($sort_field, $sort_order)
            ->limit($limit)
            ->paginate($per_page);

        return $result;
    }

    public function createStudent(Request $request)
    {
        $rules = [
            'name' => 'required|string',
        ];

//        $validator = Validator::make($request->all(), $rules);
//
//        if ($validator->fails())
//        {
//            $response['data'] = $validator->messages();
//            return $response;
//        }

        $input['name'] = $request->name;
        $input['email'] = $request->email;
        $input['password'] = str_random(8);
        $input['class_id'] = $request->class;
        $input['role_id']  = '2';

        $user = User::create($input);

        Mail::to($user->email)->send(new SendEmailMailable($user->email, $input['password']));

        return response()->json([
            'success' => true,
            'id' => $user->id
        ], 200);
    }

    public function softdelete($id)
    {
        $note = User::destroy($id);
        if ($note) {

            $response = $this->successfulMessage(200, 'Successfully deleted', true, 0, $note);

        } else {

            $response = $this->notFoundMessage();
        }

        return response($response);
    }

    public function softDeleted()
    {
        $notes = User::onlyTrashed()->get();

        $response = $this->successfulMessage(200, 'Successfully', true, $notes->count(), $notes);
        return response($response);
    }

    public function restore($id)
    {
        $note = User::onlyTrashed()->find($id);

        if (!is_null($note)) {
            $note->restore();
            $response = $this->successfulMessage(200, 'Successfully restored', true, $note->count(), $note);
        }
        return response($response);
    }

    private function notFoundMessage()
    {

        return [
            'code' => 404,
            'message' => 'Note not found',
            'success' => false,
        ];

    }

    private function successfulMessage($code, $message, $status, $count, $payload)
    {

        return [
            'code' => $code,
            'message' => $message,
            'success' => $status,
            'count' => $count,
            'data' => $payload,
        ];

    }

}
