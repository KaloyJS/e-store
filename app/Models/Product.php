<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Product extends Model
{
    // enable soft deletes
    use SoftDeletes;

    public $timestamps = true;
    protected $fillable = ['name', 'price', 'description', 'category_id', 'sub_category_id', 'image_path', 'quantity'];
    protected $dates = ['deleted_at'];

    public function transform($data)
    {
        $products = [];
        foreach ($data as $item) {
            $added = new Carbon($item->created_at);
            array_push($products, [
                'id' => $item->id,
                'name' => $item->name,
                'description' => $item->description,
                'category_id' => $item->category_id,
                'category_name' => Category::where('id', $item->category_id)->first()->name,
                'sub_category_id' => $item->sub_category_id,
                'sub_category_name' => SubCategory::where('id', $item->sub_category_id)->first()->name,
                'price' => $item->price,
                'image_path' => $item->image_path,
                'quantity' => $item->quantity,
                'added' => $added->toFormattedDateString()
            ]);
        }
        return $products;
    }
}