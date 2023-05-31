<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginModel extends Model{
    use HasFactory;

    public static function checkUser($email_username){
        $result = DB::table('users')
        ->select('username','email', 'id')
        ->where('username', $email_username)
        ->orWhere('email', $email_username)
        ->first();

        return $result;
    }

}
