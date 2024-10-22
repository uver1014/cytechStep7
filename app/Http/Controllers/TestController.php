<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\company;
use App\Http\Requests\TestRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Test;

class TestController extends Controller
{

    public function showList()
    {
        $products = product::orderByDesc('id')->paginate(10);
        $companies = company::all();

        return view('layouts.list', ['products' => $products, 'companies' => $companies]);
    }

    public function exeSearch(Request $request)
    {

        $keyword = $request->input('keyword');
        $company_id = $request->input('company_id');

        $query = product::query();

        $products = DB::table('products')
            ->join('companies', 'products.company_id', '=', 'companies.id')
            ->select('products.*', 'companies.company_name as company_name')
            ->get();

        if (!empty($company_id)) {
            $query->where('company_id', $company_id);
        }

        if (!empty($keyword)) {
            $query->where('product_name', 'like', "%{$keyword}%")
                ->orwhere('price', $keyword)
                ->orwhere('stock', $keyword)
                ->orwhere('comment', 'like', "%{$keyword}%");
        }
        $companies = company::all();
        $products = $query->orderBy('id', 'asc')->paginate(10);

        return view(
            'layouts.list',
            ['keyword' => $keyword, 'companies' => $companies, 'products' => $products]
        );
    }


    public function createList()
    {
        $companies = company::all();
        $model = new product();
        $products = $model->getList();
        return view('Test.form', ['companies' => $companies]);
    }

    public function exeStore(TestRequest $request)
    {

        if ($request->has('img_path')) {

            $image = $request->file('img_path');
            //②画像ファイルのファイル名を取得
            $file_name = $image->getClientOriginalName();
            //③storage/app/public/imagesフォルダ内に、取得したファイル名で保存
            $image->storeAs('public/images', $file_name);
            //④データベース登録用に、ファイルパスを作成
            $image_path = 'storage/images/' . $file_name;
            chmod($image_path, 0775);
        }

        $inputs = $request->all();
        product::create($inputs);

        DB::beginTransaction();

        try {
            $model = new product();
            $model->registPic($image_path);
            $model->registProduct($request);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back();
        }
        session()->flash('message', '登録しました');
        return redirect(route('create'));
    }

    public function showDetail($id)
    {

        $product = product::find($id);

        if (is_null($product)) {
            session()->flash('message', 'データがありません');
            return redirect(route('List'));
        }

        return view('Test.detail', ['product' => $product]);
    }

    public function editDetail($id)
    {

        $companies = company::all();
        $model = new product();
        $products = $model->getList();
        $product = product::find($id);
        return view('Test.edit', ['companies' => $companies, 'product' => $product]);
    }


    public function exeUpdate(TestRequest $request, product $product, $id)
    {

        if ($request->has('img_path')) {

            $image = $request->file('img_path');
            $path = $product->img_path;
            if (isset($image)) {
                Storage::delete('public/images' . $path);
                $path = $image->storeAs('product', 'public/images');
            }
        }

        $product = product::find($id);

        $product->fill([
            'product_name' => $request->product_name,
            'company_id' => $request->company_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'img_path' => $request->img_pathe,
            'comment' => $request->comment
        ]);

        $product->save();

        return redirect(route('edit', $product->id))->with('message', '更新しました');
    }


    public function exeDelete($id)
    {

        if (empty($id)) {
            session()->flash('message', 'データがありません');
            return redirect(route('List'));
        }

        try {
            $product = product::destroy($id);
        } catch (\Exception $e) {
            abort(500);
        }

        session()->flash('message', '削除しました');
        return redirect(route('List'));
    }
}
