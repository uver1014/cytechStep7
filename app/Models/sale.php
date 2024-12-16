<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\company;
use App\Models\product;

class sale extends Model
{
    use HasFactory;

    protected $table ='sales';

    protected $fillable =['product_id'];

    public function getList() {
        // articlesテーブルからデータを取得
        $sales = DB::table('sales')
        ->join('products', 'sales.product_id', '=', 'product.id')
        ->select('sales.*', 'product.product_name as product_name')
        ->get();

        return $sales;
    }
   
}
