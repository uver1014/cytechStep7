@extends('Test.lists')
@section('title','商品情報詳細画面')
@section('content')

<!-- Page Content -->
<div class="container mt-5 p-lg-5 bg-light">
    <div class="col-md-8 col-md-offset-2">
        <h2>商品情報詳細画面</h2>
    </div>

    <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="id">ID</label>
                <div class="form-control" id="id" name="id" value="{{ $product->id }}">
                    {{ $product->id }}
                </div>
            </div>
        </div>

    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label for="product_name">商品名</label>
            <div class="form-control" id="product_name" name="product_name">
                {{ $product->product_name }}
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-6 mb-3">
            <label for="company_id">メーカー名</label>
            <div name="company_id" id="company_id" class="form-select">
                {{ $product->company->company_name }}
            </div>
        </div>
    </div>



    <div class="form-row">
        <div class="col-md-3 mb-3">
            <label for="price">価格</label>
            <div class="form-control" id="price" name="price" value="{{ old('price') }}">
                {{ $product->price }}
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-3 mb-3">
            <label for="stock">在庫数</label>
            <div class="form-control" id="stock" name="stock" value="{{ old('stock') }}">
                {{ $product->stock }}
            </div>
        </div>

    </div>

    <div class="form-row">
        <div class="custom-file mb-3">
            <label for="img_path">商品画像</label>
            <img src="{{ asset('storage/'.$product->image_file) }}">
        </div>
    </div>

    <div class="form-group mb-3">
        <label for="comment">コメント</label>
        <div class="form-control" id="comment" name="comment" rows="3">
            {{ $product->comment }}
        </div>

    </div>


    <!--ボタンブロック-->
    <div class="form-group row">
        <div class="mt-5">
            <a href="{{ route('edit', $product->id) }}" class="btn btn-primary">編集</a>
            <a href="{{ route('List') }}" class="btn btn-warning">戻る</a>

        </div>
    </div>

</div>
</body>

</html>

@endsection