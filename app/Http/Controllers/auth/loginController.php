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

        $validation = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $verifController = new userController();
        if($verifController->verifLogin($request) === true){
            $user = DB::table('users')->get();
            foreach ($user as $item) {
                if($item->email === $validation['email'] && Hash::check($validation['password'], $item->password)) {
                    $verifController->updateToken($item->id);
                    return base64_encode(intval($item->id));
                }
            }
        }
        return json_encode(false);
    }
}
