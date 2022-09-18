<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function nomenclature()
    {
        return $this->belongsTo(Nomenclature::class);
    }

    public function getPathName(){
    	return $this->path.$this->name;
    }

    
}
