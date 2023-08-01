<?php
namespace App\Services\Geoip;

use Illuminate\Support\Facades\Http;

class  MaxmindGeoipLite{


    protected $BaseUrl='https://geoip.maxmind.com/geoip/v2.1';
    protected $key;
    protected $account_id;
    
    public function __construct($account_id,$key){
     $this->account_id=$account_id;
     $this->key=$key;

    }
public function country($ip){

 $response=Http::baseUrl($this->BaseUrl)->withBasicAuth( $this->account_id,$this->key)->withHeaders([
    // 'Authorization'=>$this->getAuthorization(),
    'Accept'=>'application/json',

 ])->get("country/{$ip}");
 return  $response->json();


}



public function city($ip){
    
}

// protected function getAuthorization(){
//     return 'Basic '. base64_encode($this->account_id . ':' . $this->key);
// }

}


?>