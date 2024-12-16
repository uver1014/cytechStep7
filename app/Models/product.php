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
    public function getList(){
        return DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.*', 'companies.company_name as company_name')
            ->orderBy('products.id', 'desc')
            ->paginate(10);
        }

    //
    public function searchProducts($keyword, $company_id, $pricemin, $pricemax, $stockmin, $stockmax){

        // クエリをビルド
        $query = DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.*', 'companies.company_name as company_name');

        // 検索条件をクロージャでグループ化
        $query->where(function ($q) use ($keyword, $company_id, $pricemin, $pricemax, $stockmin, $stockmax) {
            if (!empty($company_id)) {
                $q->where('products.company_id', $company_id);
            }

            if (!empty($keyword)) {
                $q->where(function ($subQuery) use ($keyword) {
                    $subQuery->where('products.product_name', 'like', "%{$keyword}%")
                        ->orWhere('products.price', $keyword)
                        ->orWhere('products.stock', $keyword)
                        ->orWhere('products.comment', 'like', "%{$keyword}%");
                });
            }

           if(!empty($pricemin) || !empty($pricemax)){
            $q->where(function ($priceQuery) use ($pricemin, $pricemax){
                if(!empty($pricemin) && !empty($pricemax)){
                $priceQuery->whereBetween('products.price', [$pricemin, $pricemax]);
            }elseif(!empty($pricemin)){
                $priceQuery->where('products.price', '>=', $pricemin);
            }elseif(!empty($pricemax)){
                $priceQuery->where('products.price', '<=', $pricemax);
              }
            });
           }

           if(!empty($stockmin) || !empty($stockmax)){
            $q->where(function ($stockQuery) use ($stockmin, $stockmax){
                if(!empty($stockmin) && !empty($stockmax)){
                    $stockQuery->whereBetween('products.stock', [$stockmin, $stockmax]);
                }elseif(!empty($stockmin)){
                    $stockQuery->where('products.stock', '>=', $stockmin);
                }elseif(!empty($stockmax)){
                    $stockQuery->where('products.stock', '<=', $stockmax);
                }
            });
         }
        });

        return $query->orderBy('id','desc')->paginate(10);
    }


    // 登録処理
    public function registProduct($data, $image_path){
        DB::table('products')->insert([
            'company_id' => $data->company_id,
            'product_name' => $data->product_name,
            'price' => $data->price,
            'stock' => $data->stock,
            'img_path' => $image_path,
            'comment' => $data->comment
        ]);
    }

    //結合してidでデータを取得
    public function findList($id){
        return DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.*', 'companies.company_name')
            ->where('products.id', $id)
            ->first();
        
    }

    //更新処理
    public function updateProduct($data, $image_path, $id){

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
