<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;

use App\Services\Geoip\MaxmindGeoipLite;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


use Illuminate\Support\Facades\Notification;
use App\Notifications\NewOrderCreatedNotification;

class dasboardController extends Controller
{
    public function index(){
        $products=Product::with('category','tags')->get();
       $orders=Order::with('products','country','city')->get();
       $config=config('services.maxmind');
      $Geoip= new MaxmindGeoipLite($config['account_id'],$config['license_key']);
    return  $Geoip->country('51.79.240.216');
      
    //    foreach($orders as $order)
    //    // Assuming you have a user model or any other notifiable entity
    //        $user = Auth::guard('admin')->user(); 
    //    Notification::send($user, new NewOrderCreatedNotification( $order)); 
    
      // dd($items);
        return view('Admin.dashboard',compact('products','orders'));
    }
    public function login(){
        return view('Admin.auth.login');
    }
    public function loginstore(Request $request){

      //  return 'ds';      
          $check=$request->all();
    
        if(Auth::guard('admin')->attempt([
            'email'=>$check['email'],
            'password'=>$check['password']
            ])){

            return redirect()->route('dashboard');
        }
        else{
        return redirect()->back()->with('error','please enter information ');
    }}
    public function logout()  {
        Auth::guard('admin')->logout();
        return redirect()->route('dashboard')->with('error','success logout ');
    }
    public function register(){
        return view('Admin.auth.register');
    }
    public function registerstore(Request $request){
        Admin::insert([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>$request->password,

        ]);
        return redirect()->route('Admin-logout')->with('error','success register');
    }
//     public function sendNotification()
// {
//     $user = Auth::guard('admin')->user(); // Assuming you have a user model or any other notifiable entity
    
//     Notification::send($user, new NewOrderCreatedNotification($ordrers));
    
//     return redirect()->back()->with('success', 'Notification sent successfully!');
// }


}
