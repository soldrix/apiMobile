<?php

namespace App\Http\Controllers;

use App\Http\Controllers\auth\userController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class listController extends Controller
{

    public function addList(Request $request){
        $json = new \stdClass();
        $userController = new userController();
        if($userController->veifUsertoken(base64_decode($request->id_user)) === true){
            $validation = $request->validate([
                "name" => "required",
                "id_user" => "required"
            ]);
            if ($validation['name'] !== '' && $validation['id_user'] !== ''){
                $id =  DB::table('list')->insertGetId([
                    "name" => $validation[ 'name'],
                    "id_user" => base64_decode($validation['id_user'])
                ]);
                $json->id = $id;
                $dataUser = DB::table('users')->where('id',base64_decode($validation['id_user']))->get();
                foreach ($dataUser as $datas){
                    $json->token = $datas->token;
                    $json->id_user = $datas->id;
                }
                return $json;
            }
           return json_encode(null);//return value empty
        }
        return json_encode(false);//return login
    }
    public function deleteList(Request $request){
        $userController = new userController();
        if($userController->veifUsertoken(base64_decode($request->id_user)) === true){
            DB::table('list')->where('id',$request->id)->delete();
            return json_encode(true);
        }
        return json_encode(false);
    }
    public function deleteProduct(Request $request){
        $userController = new userController();
        if($userController->veifUsertoken(base64_decode($request->id_user)) === true){
            DB::table('product')->where('id',$request->id)->delete();
            return json_encode(true);
        }
        return json_encode(false);
    }

    public function getListUser(Request $request){
        $userController = new userController();
        if($userController->veifUsertoken(base64_decode($request->id_user)) === true){
            if (isset($request->id_user)){
                return DB::table('list')->where('id_user', base64_decode($request->id_user))->get();
            }
            return json_encode(null);
        }
        return json_encode(false);
    }
    public function addproduct(Request $request){

        $controllerUser= new userController();
        if($controllerUser->veifUsertoken( base64_decode($request->id_user)) === true){
            $validation = $request->validate([
                'name' => 'required',
                'id_list' => 'required',
                'id_user' => 'required',
            ]);
            if ($validation['name'] !== '' && $validation['id_list'] !== '' && $validation['id_user'] !== ''){
               return  DB::table('product')->insertGetId([
                    "name" => $validation[ 'name'],
                    "id_list" => $validation['id_list'],
                   "status" => 'false'
                ]);
            }
            return json_encode(null);
        }
        return json_encode(false);
    }
    public function getProduct(Request $request){
        $userController = new userController();
        if($userController->veifUsertoken(base64_decode($request->id_user)) === true){
            return DB::table('product')->where([
                'id_list' => $request->id
            ])->get();
        }
        return json_encode(false);
    }
    public function updateProduct(Request $request){
        $userController = new userController();
        if($userController->veifUsertoken(base64_decode($request->id_user)) === true){
           return DB::table('product')->where('id' , $request->id)->update([
                'status' => $request->status
            ]);
        }
        return json_encode(false);
    }
}
