<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class  CurrencyConverter
{    
    protected $BaseUrl = 'https://free.currconv.com/api/v7/';
    private $apiKey;
    

    public function __construct($apiKey)
    {
     
        
         
        $this->apiKey = $apiKey;
    }
    public function convert(string $from, string $to, float $amount = 1)
    {
        $q = "{$from}_{$to}";
    
        $response = Http::baseUrl($this->BaseUrl)->get('/convert', [
            'q' => $q,
            'compact' => 'ultra',

            'apiKey' => $this->apiKey,
        


        ]);
        // https://free.currconv.com/api/v7/convert?q=USD_PHP&compact=ultra&apiKey=2bf30fabc3f35e4714c6

        $result = $response->json();
      // dd($result);
        return $result[$q] * $amount;
    }
}
// https://free.currconv.com/api/v7/convert?q=USD_PHP&compact=ultra&apiKey=2bf30fabc3f35e4714c6