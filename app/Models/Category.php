<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory ;
    use SoftDeletes;
    protected $guarded=[];
   

    public function products(){
        return $this->hasMany(Product::class);
    }
    public function images(){
        return $this->hasMany(Image::class);
    }

    public function parent(){
        return $this->belongsTo(Category::class, 'parent_id')->withDefault();
    }
    
}
