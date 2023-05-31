<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function index(Request $request)
    {   
        $search = $request->input('search');
        if($search){
            $items = User::
            where('email', 'like', "%$search%")->where('userlevel', 2)
            ->orWhere('username', 'like', "%$search%")->where('userlevel', 2)
            ->get();
        }else{
            $items = User::where('userlevel', 2)->get();
        }
        // $items = User::paginate($request->input('itemsPerPage', 10));
        return response()->json($items);
    }
    
    public function update(Request $request)
    {   
        $edit_id = $request->input('edit_id');
        $email = $request->input('email');
        $username = $request->input('username');
        $phone_number = $request->input('phone_number');

        $data = array (
            'email' => $email,
            'username' => $username,
            'phone_number' => $phone_number,
            'updated_at' => date('Y-m-d H:i:s', time())
        );

        $update_user = User::where('id', $edit_id)->update($data);

        if($update_user){
            $response = [
                "data" => [],
                "status" => "success",
                "title" => "Update Successful!",
                "message" => "You successfully updated a user with id#$edit_id",
                "http_code" => 200,
            ];
            return response()->json($response, 200);
        }else{
            $response = [
                "data" => [],
                "status" => "error",
                "title" => "Delete Failed",
                "message" => "There was an error encountered while tring to update the user with id#$edit_id. Please try again later.",
                "http_code" => 500,
            ];
            return response()->json($response, 500);
        }
    }

    public function delete($id)
    {
        $user = User::find($id)->delete();

        if($user){
            $response = [
                "data" => [],
                "status" => "success",
                "title" => "Delete Successful!",
                "message" => "You successfully delete a user with id#$id",
                "http_code" => 200,
            ];
            return response()->json($response, 200);
        }else{
            $response = [
                "data" => [],
                "status" => "error",
                "title" => "Delete Failed",
                "message" => "There was an error encountered while tring to delete the user with id#$id. Please try again later.",
                "http_code" => 500,
            ];
            return response()->json($response, 500);
        }
    }
    
}