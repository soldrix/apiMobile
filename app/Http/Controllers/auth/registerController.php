<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use MongoDB\BSON\Regex;
use function PHPUnit\Framework\matchesRegularExpression;

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
        if($validation['prenom'] !== "" && $validation['nom'] !== '' && preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/",$validation['password']) && matchesRegularExpression($validation['email'],"/(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/")){
            DB::table('users')->insert([
                "prenom" => $validation['prenom'],
                "nom" => $validation['nom'],
                'email' => $validation['email'],
                "password" => $validation['password']
            ]);
        }else{
            $returnValue = true;
        }
        return $returnValue;
    }
}
