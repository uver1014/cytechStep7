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

    //一覧画面を表示
    public function showList()
    {
        //productsデータを呼び出し
        $model = new product();
        $products = $model->getList();
        //companiesデータを呼び出し
        $model = new company();
        $companies = $model->getCompany();

        return view('Test.list', ['products' => $products, 'companies' => $companies]);
    }

    //検索機能
    public function exeSearch(Request $request)
    {
        //検索処理
        if ($request->ajax()) {
        $model = new product();
        $products = $model->searchProducts($request);
        
            // 検索結果のHTMLを部分ビューから生成
            $html = view('Test.search_result', ['products' => $products])->render();
            return response()->json(['success' => true, 'html' => $html,]);
        }
    }

    //登録処理
    public function exeStore(TestRequest $request)
    {

        $image_path = null; // 初期化
        if ($request->has('img_path')) {

            $image = $request->file('img_path');
            //②画像ファイルのファイル名を取得
            $file_name = $image->getClientOriginalName();
            //③storage/app/public/imagesフォルダ内に、取得したファイル名で保存
            $image->storeAs('public/images', $file_name);
            //④データベース登録用に、ファイルパスを作成
            $image_path = 'storage/images/' . $file_name;
        }
        DB::beginTransaction();

        try {
            $model = new product();
            $product = $model->registProduct($request, $image_path);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('message', '登録に失敗しました。');
        }

        session()->flash('message', '登録しました');
        return redirect(route('create'));
    }

    //詳細画面の表示
    public function showDetail($id)
    {

        $model = new product();
        $product = $model->findList($id);

        if (is_null($product)) {
            session()->flash('message', 'データがありません');
            return redirect(route('List'));
        }

        return view('Test.detail', ['product' => $product]);
    }

    //編集画面の表示
    public function editDetail($id)
    {
        //
        $model = new company();
        $companies = $model->getCompany();
        //idのデータを呼び出し
        $model = new product();
        $product = $model->findList($id);
        return view('Test.edit', ['product' => $product, 'companies' => $companies]);
    }

    //更新処理
    public function exeUpdate(TestRequest $request, $id)
    {

        $image_path = null; // 初期化
        $model = new product();
        $product = $model->findList($id);

        if ($request->has('img_path')) {
            $image = $request->file('img_path');
            $path = $product->img_path;

            if (isset($image)) {
                //古い画像を削除
                Storage::delete('public/images/' . $path);
                //新しい画像を保存
                $fileName = $image->getClientOriginalName();
                $image->storeAs('public/images', $fileName);
                $image_path = 'storage/images/' . $fileName;
            }
        }
        DB::beginTransaction();
        try {
            $model = new product();
            $product = $model->updateProduct($request, $image_path, $id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('message', '更新に失敗しました。');
        }

        return redirect(route('edit', $id))->with('message', '更新しました');
    }

    //削除機能
    public function exeDelete($id)
    {
        try{
        $product = product::findOrFail($id);
        $product->delete();
        return response()->json(['success' => true,  'tr' => 'tr_' . $id]);
        }catch(\Exception $e){
            return response()->json(['success' => false, 'message' => '削除に失敗しました。'], 500);
        }
    }
}
