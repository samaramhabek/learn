<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Tag;
use App\Models\User;
use App\Models\Product;
use App\Models\ImageProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class loginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request){

        $request->validate([
          'email'=>'required',
          'password'=>'required',
        //  'device_name'=>'',

        ]);
       $user= User::where('email',$request->email)->first();
 
       //return $user;
       if($user && Hash::check($request->password, $user->password)){
        //sanctum
       
        
       $device= $request->input('device_name',$request->userAgent()); 
       $token= $user->CreateToken($device,['product.create','product.edit']);
       return Response::json([
       
        'token'=> $token->plainTextToken,
   ]);
       }
       return Response::json([
        'message'=>'invailed ',
       
   ]  ,401);
    }
    public function logout( Request $request){
      $user=Auth::guard('sanctum')->user();
      $user->CurrentAccessToken()->delete();
        return Response::json([
          'message'=>'token delete',
        ]);
    }
 
}
