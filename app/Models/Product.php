<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $guarded=[];
    public  static function booted(){
        static::addGlobalScope('sale',function(Builder $builder){
              $builder->Where('status','=','sale');
        }) ;
    }
    public function scopeSold( Builder $builder){
        $builder->Where('status','=','sold');
    }
    public function scopeStatus( Builder $builder,$status='new'){
        $builder->Where('status','=',$status);
    }
    public function category(){
        return $this->belongsTo(Category::class)->withDefault();
    }
    public function cart(){
        return $this->hasMany(Cart::class, 'product_id');
    }
    public function tags(){
        return $this->belongsToMany(Tag::class, 'product_tags', 'Product_id', 'tag_id');
    }
    public function imagesproduct(){
        return $this->hasMany(ImageProduct::class);
    }
    public function orders(){
        return $this->belongsToMany(Order::class, 'order_items', 'Product_id', 'order_id');
    }
    
}
