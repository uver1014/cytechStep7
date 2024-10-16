<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\company;
use App\Models\sale;

class product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable =
    [
        'id',
        'product_name',
        'company_id',
        'price',
        'stock',
        'img_path',
        'comment'
    ];

    public function company()
    {
        return $this->belongsTo(company::class);
    }

    public function sale()
    {
        return $this->hasMany(sale::class);
        $sales = sale::all();
    }

    public function getList()
    {
        // テーブルからデータを取得
        $products = DB::table('products')->get();

        return $products;
    }

    public function registProduct($data) {
        // 登録処理
        DB::table('products')->insert([
            'company_id' => $data->company_id,
            'product_name' => $data->product_name,
            'price' => $data->price,
            'stock' => $data->stock,
            'comment' => $data->comment,
        ]);
    }

    public function registPic($image_path){
        DB::table('products')->insert([
            'image_file' => $image_path
        ]);
    }
    
}
