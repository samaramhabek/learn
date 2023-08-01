<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cart;
use App\Models\Image;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ImageProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class CartController extends Controller
{
  public function home()
  {
    $products = Product::all();
    // $images=ImageProduct::all();
    //  $categories=Category::all();
    $imagescat = Image::all();
    $images = ImageProduct::all();


    return view('home', compact('imagescat', 'products'));
  }
  // طريقة الa  href
  public function my_cart()
  {
   $cart_id= Cookie::get('cart_id');
    // $user_id = Auth::user()->id;
    // $cart = Cart::with('product')->where('user_id', $user_id)->get();
    $cart = Cart::with('product')->where('cart_id', $cart_id)->get();

    //dd($cart);
    
    $final_total = $cart->sum(function ($c) {
      return $c->quantity * $c->product->price;
  });
 // dd($final_total);
    //dd($cart);
    return view('Admin.cart', compact('cart', 'final_total'));
  }
  // public function Addtocart(string $product_id){
  //        $product= Product::findorfail($product_id);
  //        $user_id= Auth::user()->id;
  //        $cart = Cart::where('product_id', $product->id)->where('user_id',$user_id)->first();
  //       //  $cart= Cart::where('user_id',$user_id)->first();
  //           DB::table('carts')->update(['total' => 0.00]);
  //        if(!$cart){
  //         $cart=new cart();

  //         $cart->user_id=$user_id;
  //         $cart->quantity=1;

  //         $cart->product_id=$product->id;
  //         $cart->total=$product->price;
  //         $cart->save();
  //         return redirect()->route('my_cart');
  //        }else{
  //         dd('exists');
  //        }

  //       // dd($cart);



  // }
  public function addtocart2(Request $request, $product_id)
  {
    //dd($request);
    // $request->validate([
    // // 'product_id'=>'require'|'exists:products,id',
    // 'quantity'=>'int'|'min:1',
    // ]);
    $quantity = $request->quantity;
    $product = Product::where('id', $product_id)->first();
    $price = $product->price;
    $total = $price * $quantity;
if(Auth::user()){
    $user_id = Auth::id();
}
    //$cart = Cart::where('product_id', $product_id)->first();
    // if(!$cart){
    //   $cart =  new Cart();
    //   $cart->cart_id = $this->getCartId();
    //   $cart->product_id = $request->product_id;
    // $cart->user_id = $user_id;
    // $cart->quantity = $request->post('quantity', 1);
    // $cart->Total = $product->price * $request->post('quantity', 1);
    // $cart->save();
    // }else{
    //   $cart->user_id = $user_id;
    //   $cart->quantity = $request->post('quantity');
    //   $cart->Total = $product->price * $request->post('quantity');
    //   $cart->save();
    // }

    Cart::updateOrCreate([
      'cart_id' =>App::make('cart.id'),
      'product_id' => $request->product_id,
      'user_id' => $user_id,
    ], [
      'quantity' => $request->post('quantity', 1),
      'Total' => $product->price * $request->post('quantity', 1),
    ]);
    return redirect()->route('my_cart');
  }
  protected function getCartId()
  {
    $id = Cookie::get('cart_id');
    if (!$id) {
      $id = Str::uuid();
      Cookie::queue('cart_id', $id, 60 * 24 * 30);
    }
    return $id;
  }

  public function updateQuantity(Request $request)
  {
    $cart = Cart::where('id', $request->cart_id)->first();
    // $price=$cart->product->price;
    // $total=$price*$request->quantity;
    // return $total;
    // $cart->update([
    //   'quantity' => $request->quantity,
    //   'total' => $request->quantity * $cart->product->price,
    // ]);
    $cart->quantity = $request->quantity;
    $cart->total = $request->quantity * $cart->product->price;
    $cart->save();

    // $cart->refresh();
    $carts= Cart::with('product')->where('cart_id', App::make('cart.id'))->get();



    $total = $carts->sum(function ($c) {
        return $c->quantity * $c->product->price;
    });

    return response()->json([
      'total' => $cart->total,
      'all_total' => $total,
    ]);
    // dd($request->all());

  }
}
