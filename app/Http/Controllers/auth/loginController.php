<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class loginController extends Controller
{
    public function login(Request $request){
        $validation = $request->validate([//validation email et password
            'email' => 'required',
            'password' => 'required'
        ]);
        $verifController = new userController();
        if($verifController->verifLogin($request) === true){//verif password and email true = okay
            $user = DB::table('users')->get();
            foreach ($user as $item) {
                if($item->email === $validation['email'] && Hash::check($validation['password'], $item->password)) {//compare all user password with request password
                    $verifController->updateToken($item->id); //ajoute time stamp
                    return base64_encode(intval($item->id)); //return user id
                }
            }
        }
        return json_encode(false); //return false if passzord or email is wrong
    }
}
