<?php

namespace App\Http\Controllers\Admin;



use Illuminate\Http\Request;
use App\Services\CurrencyConverter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\session;
use App\Services\CurrencyConverter as ServicesCurrencyConverter;

class CurrencyConverterController extends Controller
{
    public function storewe(Request $request){
         
      //  $request->validate([
      //   'currency_code'=>'required|string|size:3'
      //  ]);
       $basecurrency=config('app.currency');
      
       $currency_code=$request->input('currency_Code');
         
       $cachekey='currency_rate_'.$currency_code;
     
       $rate=Cache::get($cachekey,0);
       
       if(!Cache::has($cachekey)){
       // dd(config('services.currency_converter.api_key'));
      
        $converter=new  CurrencyConverter(config('services.currency_converter.api_key'));
       $rate= $converter->convert($basecurrency, $currency_code,1);

       Cache::put($cachekey, $rate,now()->addMinutes(60));
       }
       session::put('currency_code',$currency_code);
       
      
      
      return redirect()->back();
    }

}
