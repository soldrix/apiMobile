<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\matchesRegularExpression;
use Carbon\Carbon;
class userController extends Controller
{
    public function verifEmail(Request $request){//verification email already exist
        $email = DB::table('users')->get('email');
        if(count($email) > 0){
            foreach ($email as $datas){
                if(strcmp($request->email,$datas->email) == 0){
                    return json_encode(true);
                }
            }
        }
        return json_encode(false);
    }
    public function verifLogin($datas){//verification fomat email and password
       return (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",$datas->password) && matchesRegularExpression($datas->email,"/(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/")) ? true : false;
    }
    public function updateToken($id){
        return DB::table('users')->where('id', $id)->update([
            'token' => Carbon::now()->timestamp
        ]);
    }
    public function veifUsertoken($id){//verfiaction user connect and token not expired
        $datas = DB::table('users')->where('id', $id)->get();
        foreach ($datas as $items){
            if((Carbon::now()->timestamp - intval($items->token)) < 1800){
                $this->updateToken($id);
                return true;
            }
        }
        DB::table('users')->where('id', $id)->update([
            'token' => null
        ]);
        return false;
    }
}
