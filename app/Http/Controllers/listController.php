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
        if($userController->veifUsertoken(base64_decode($request->id_user)) === true){//verfication user connected
            $validation = $request->validate([
                "name" => "required",
                "id_user" => "required"
            ]);
            if ($validation['name'] !== '' && $validation['id_user'] !== ''){//verification value not empty
                $id =  DB::table('list')->insertGetId([//innsert list and get id
                    "name" => $validation[ 'name'],
                    "id_user" => base64_decode($validation['id_user'])
                ]);
                $json->id = $id;
                $dataUser = DB::table('users')->where('id',base64_decode($validation['id_user']))->get();//get user
                foreach ($dataUser as $datas){
                    $json->token = $datas->token;
                    $json->id_user = $datas->id;
                }
                return $json;//return token,id_user,id list
            }
           return json_encode(null);//return value empty
        }
        return json_encode(false);//return login
    }
    public function deleteList(Request $request){
        $userController = new userController();
        if($userController->veifUsertoken(base64_decode($request->id_user)) === true){
            DB::table('list')->where('id',$request->id)->delete();
            return json_encode(true);//success
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
                return DB::table('list')->where('id_user', base64_decode($request->id_user))->get();//return all list of connected user
            }
            return json_encode(null);//value empty
        }
        return json_encode(false);//user not connected
    }
    public function addproduct(Request $request){

        $controllerUser= new userController();
        if($controllerUser->veifUsertoken( base64_decode($request->id_user)) === true){
            $validation = $request->validate([
                'name' => 'required',
                'id_list' => 'required',
                'id_user' => 'required',
            ]);
            if ($validation['name'] !== '' && $validation['id_list'] !== '' && $validation['id_user'] !== ''){//verification value not empty
               return  DB::table('product')->insertGetId([ //insert product and return product id
                    "name" => $validation[ 'name'],
                    "id_list" => $validation['id_list'],
                   "status" => 'false'
                ]);
            }
            return json_encode(null);//value empty
        }
        return json_encode(false);//user not connected
    }
    public function getProduct(Request $request){
        $userController = new userController();
        if($userController->veifUsertoken(base64_decode($request->id_user)) === true){
            return DB::table('product')->where([ //return all product from list
                'id_list' => $request->id
            ])->get();
        }
        return json_encode(false);//user not connected
    }
    public function updateProduct(Request $request){
        $userController = new userController();
        if($userController->veifUsertoken(base64_decode($request->id_user)) === true){
           DB::table('product')->where('id' , $request->id)->update([ // update status of product
                'status' => $request->status
           ]);
           return json_encode(true);
        }
        return json_encode(false);
    }
}
