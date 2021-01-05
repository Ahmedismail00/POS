<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Product extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes  = ['name','description'];

    public $fillable = ['category_id','image','purchasing_price','selling_price','stock'];

    protected $appends = ['image','profit_percent'];
    public function getImagePathAttribute()
    {
        return asset('uploads/products_images/'.$this->image);
    }
    public function getProfitPercentAttribute()
    {
        $profit = $this->selling_price - $this->purchasing_price;
        $profit_percent = $profit * 100 / $this->purchasing_price;
        return number_format($profit_percent,2);
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
