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

    protected $fillable =
    [
        'id',
        'product_id',
        
    ];


    public function product()
    {
        return $this->belongsTo(product::class);
        
    }

    public function getList() {
        // articlesテーブルからデータを取得
        $sales = DB::table('sales')->get();

        return $sales;
    }

}
