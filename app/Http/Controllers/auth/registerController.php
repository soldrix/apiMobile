<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class registerController extends Controller
{
    public function insert(Request $request){
        $returnValue = false;
        $validation = $request->validate( [
            'email'    => 'required',
            'password' => 'required',
            'prenom' => 'required',
            'nom' => 'required'
        ]);
        $verifController = new userController();
        if($verifController->verifLogin($request) === true && $validation['prenom'] !== "" && $validation['nom'] !== ''){
            DB::table('users')->insert([
                "prenom" => $validation['prenom'],
                "nom" => $validation['nom'],
                'email' => $validation['email'],
                "password" => Hash::make($validation['password'])
            ]);
        }else{
            $returnValue = true;
        }
        return $returnValue;
    }
}
