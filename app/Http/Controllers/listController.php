<?php

namespace App\Http\Controllers;

use App\Http\Controllers\auth\userController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class listController extends Controller
{

    public function addList(Request $request){
        $userController = new userController();
        if($userController->veifUsertoken(base64_decode($request->id_user)) === true){
            $validation = $request->validate([
                "name" => "required",
                "produitlist" => "required",
                "id_user" => "required"
            ]);
            if ($validation['name'] !== '' && $validation['produitlist'] !== '' && $validation['id_user'] !== ''){
                $id =  DB::table('list')->insertGetId([
                    "name" => $validation[ 'name'],
                    "produitlist" => $validation['produitlist'],
                    "id_user" => base64_decode($validation['id_user'])
                ]);
                return DB::table('users')->where('id', $id)->get();
            }
           return null;//return value empty
        }
        return false;//return login
    }
    public function deleteList(Request $request){
        $userController = new userController();
        if($userController->veifUsertoken(base64_decode($request->id_user)) === true){
            if($request->id !== ''){
                DB::table('list')->where('id',$request->id)->delete();
                return true;
            }
           return null;
        }
        return false;
    }
    public function updateList(Request $request){
        $userController = new userController();
        if($userController->veifUsertoken(base64_decode($request->id_user)) === true){
            $validation = $request->validate([
                "name" => "required",
                "produitlist" => "required",
                "id_user" => "required"
            ]);
            if($validation['name'] !== '' && $validation['produitlist'] !== '' && $validation['id_user'] !== ''){
                return DB::table('list')->where('id',$request->id)->update([
                    "name" => $request->name,
                    "porduitlist"=>$request->produitlist
                ]);
            }
            return null;//return value empty
        }
        return false;//return login
    }
    public function getListUser(Request $request){
        $userController = new userController();
        if($userController->veifUsertoken(base64_decode($request->id_user)) === true){
            if (isset($request->id_user)){
                return DB::table('list')->where('id_user', base64_decode($request->id_user))->get();
            }
            return null;
        }
        return false;
    }
}
