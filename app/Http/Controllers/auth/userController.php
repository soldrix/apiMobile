<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\matchesRegularExpression;
use Carbon\Carbon;
class userController extends Controller
{
    public function verifEmail(Request $request){
        $email = DB::table('users')->get('email');
        $returnValue = "false";
        if(count($email) > 0){
            foreach ($email as $datas){
                if(strcmp($request->email,$datas->email) == 0){
                    $returnValue = "true";
                }
            }
        }
        return $returnValue;
    }
    public function verifLogin($datas){
       return (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",$datas->password) && matchesRegularExpression($datas->email,"/(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/")) ? true : false;
    }
    public function updateToken($id){
        return DB::table('users')->where('id', $id)->update([
            'token' => Carbon::now()->timestamp
        ]);
    }
    public function veifUsertoken($id){
        $token = DB::table('users')->where('id', $id)->get('token');
        if((Carbon::now()->timestamp - intval(base64_decode($token))) < 1800){
            $this->updateToken($id);
            return true;
        }
        return false;
    }
}
