<?php

namespace App\Http\Controllers\Admin;

//use app;

use ErrorException;
use App\Models\Cart;
use App\Models\City;
use App\Models\User;
use App\Models\Order;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
//use App\Notifications\NewOrderCreatedNotification;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewOrderCreatedNotification;

class OrderController extends Controller
{
    public function index(){
       $cart= Cart::with('product')->where('cart_id', App::make('cart.id'))->get();
     //  dd($cart);
     $subtotal=$cart->sum(function($item){
      return $item->quantity * $item->product->price;
     // dd($item->quantity);
     });
     $country=Country::all();
     
        return view('Admin.checkout',compact('cart','subtotal','country'));
    }
     public function getcities(Request $request){
        // $request->post('country_id');
          $cities=City::where('country_id',$request->country_id)->get();
          return response()->json([
            'cities' => $cities,
          ]);
     }
     public function store(Request $request){
  
       // dd($request->except('name,email,password,register'));
        $cart= Cart::with('product')->where('cart_id', App::make('cart.id'))->get();
        $subtotal=$cart->sum(function($item){
          return $item->quantity * $item->product->price;
          
        });
        if($cart->count()==0){
          return redirect()->back();
        }
      // $user= new User();
      //   $user->name=$request->name ;
      //   $user->email= $request->emailg ;
      //   $user->password=$request->password ;
        
      //   $user->save();
       // Auth::login($user);
       
    DB::beginTransaction();
    try{
      if($request->register){
      $user= new User();
        $user->name=$request->name ;
        $user->email= $request->emailg ;
        $user->password=$request->password ;
        
        $user->save();
       Auth::login($user);
      }
      $request->merge([
        'total'=>$subtotal,
        
        'user_id'=>Auth::id(),
      ]);
    $order=  Order::create($request->except('name','emailg','password','register'));
    
        foreach($cart as $item){
          OrderItem::insert([
            'order_id'=>$order->id,
            'product_id'=> $item->product_id,
            'quantity'=>$item->quantity,
            'price'=>$item->product->price,
     
          ]);
      // $order->products()->create([
      //  'product_id'=> $item->product_id,
      //  'quantity'=>$item->quantity,
      //  'price'=>$item->product->price,


      // ]);

        }
        Cart::where('cart_id', App::make('cart.id'))->delete();
     
        DB::commit();
         
      //  $user= User::where('type','=','Admin')->first();
      // $user1 = Auth::guard('admin')->user(); 
      $user1 = User::where('id', '5')->first();
      //  dd($user1);
       $user1->notify(new NewOrderCreatedNotification($order)); 


       return redirect()->route('orders.payments.create',$order->id);
        
      } 
       
      catch(ErrorException $error){
       DB::rollBack();
     
      return redirect()->back()->with($error->getMessage());
      }
     }
}
