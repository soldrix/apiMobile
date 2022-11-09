<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class listController extends Controller
{
    public function addList(Request $request):void{
        DB::table('list')->insert([
            "name" => $request->name
        ]);
    }
    public function deleteList(Request $request):void{
        DB::table('list')->where('id',$request->id)->delete();
    }
    public function updateList(Request $request){
        return DB::table('list')->where('id',$request->id)->update([
            "name" => $request->name,
            "porduitlist"=>$request->produitlist
        ]);
    }
}
