<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\product;
use App\Models\sale;

class company extends Model
{
    use HasFactory;

    protected $table ='companies';

    protected $fillable =
    [
        'id',
        'company_id',
        'company_name',
        'street_address',
        'representative_name'
    ];    
    
    public function product()
    {
        return $this->hasMany(product::class);
        $products = product::all();
    }

    public function getList() {
        // articlesテーブルからデータを取得
        $companies = DB::table('comapanies')->get();

        return $companies;
    }
}

