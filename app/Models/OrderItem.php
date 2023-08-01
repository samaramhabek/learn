<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;
    protected $guarded=[];
    // public function products(){
    //     return $this->BelongsToMany(Product::class);
    // }
    // public function orders(){
    //     return $this->BelongsToMany(Order::class);
    // }
    
}
