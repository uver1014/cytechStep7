<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\company;
use App\Models\sale;
use App\Models\Request;
use GuzzleHttp\Psr7\Request as Psr7Request;

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

    // 結合してデータを取得
    public function getList()
    {
        return DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.*', 'companies.company_name as company_name')
            ->orderBy('products.id', 'desc')
            ->paginate(10);
    }

    //
    public function searchProducts($request)
    {

        // クエリをビルド
        $query = DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.*', 'companies.company_name as company_name');

        // 検索条件を適用
        if ($request->filled('keyword')) {
            $query->where('product_name', 'LIKE', '%' . $request->keyword . '%');
        }

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        if ($request->filled('pricemin')) {
            $query->where('price', '>=', $request->pricemin);
        }

        if ($request->filled('pricemax')) {
            $query->where('price', '<=', $request->pricemax);
        }

        if ($request->filled('stockmin')) {
            $query->where('stock', '>=', $request->stockmin);
        }

        if ($request->filled('stockmax')) {
            $query->where('stock', '<=', $request->stockmax);
        }
        return $query->paginate(5); 
    }


    // 登録処理
    public function registProduct($data, $image_path)
    {
        DB::table('products')->insert([
            'company_id' => $data->company_id,
            'product_name' => $data->product_name,
            'price' => $data->price,
            'stock' => $data->stock,
            'img_path' => $image_path,
            'comment' => $data->comment,
        ]);
    }

    //結合してidでデータを取得
    public function findList($id)
    {
        return DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.*', 'companies.company_name')
            ->where('products.id', $id)
            ->first();
    }

    //更新処理
    public function updateProduct($data, $image_path, $id)
    {

        return DB::table('products')
            ->where('id', $id)
            ->update([
                'product_name' => $data->product_name,
                'company_id' => $data->company_id,
                'price' => $data->price,
                'stock' => $data->stock,
                'img_path' => $image_path,
                'comment' => $data->comment,
            ]);
    }
}
