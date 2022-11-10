<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isNull;

class userController extends Controller
{
    function verifEmail(Request $request){
        $email = DB::table('users')->get('email');
        $returnValue = "false";
        if(count($email) > 0){
            foreach ($email as $datas){
                error_log(json_encode($datas->email));
                error_log(json_encode($request->email));
                if(strcmp($request->email,$datas->email) == 0){
                    $returnValue = "true";
                }
            }

        }
        return $returnValue;
    }
}
