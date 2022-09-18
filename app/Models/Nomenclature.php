<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Gloudemans\Shoppingcart\Contracts\Buyable;

class Nomenclature extends Model implements Buyable
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];


    public function getBuyableIdentifier($options = null) {
        return $this->id;
    }

    public function getBuyableDescription($options = null) {
        return $this->name;
    }

    public function getBuyablePrice($options = null) {
        return $this->price;
    }


    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function scopeOfMain($query)
    {
        return $query->where('main', true);
        //return $query->orderByDesc('main')->limit(1);
    }    

    public function scopeOfAdditional($query)
    {
        return $query->where('main', false);
    }   

    public function scopeOfActive($query)
    {
        return $query->where('active', 1);
    }   


    public function getMainImage(){
        $image = $this->images()->orderByDesc('main')->limit(1)->first();
        return $image;
    } 

    public function getNameMainImage(){
        $image = $this->getMainImage();

        if (empty($image)){
            return '';
        }

        return $image->name;
    }

    public function getMainPath(){

        $image = $this->getMainImage();
        if (empty($image)){
            return '';
        }

        return $image->getPathName();
    }

    public function presentPrice(){

        return $this->price;
        //return "$this->price грн";

        //return money_format('$%i', $this->price / 100);
    }

    
}
