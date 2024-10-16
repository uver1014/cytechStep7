@extends('Test.lists')
@section('title','商品情報編集画面')
@section('content')

<!-- Page Content -->
<div class="container mt-5 p-lg-5 bg-light">
    <div class="col-md-8 col-md-offset-2">
        <h2>商品情報編集画面</h2>
    </div>

    <form method="POST" action="{{ route('update',$product->id) }}" onSubmit="return checkUpdate()" enctype='multipart/form-data'>
    @csrf
    @method('PUT')
    <input type="hidden" name="_method" value="put">
        @if (session('message'))
        <div class="text-danger">
            {{ session('message') }}
        </div>
        @endif

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
                <label for="product_name">商品名&#42;</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="{{ $product->product_name }}">
            </div>
            @if($errors->has('product_name'))
            <div class="text-danger">
                {{ $errors->first('product_name')}}
            </div>
            @endif
        </div>

        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label for="company_id">メーカー名&#42;</label>
                <select name="company_id" id="company_id" class="form-select">
                    <option value="{{ $product->company_id }}">選択してください</option>
                    @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                    @endforeach
                </select>
                @if($errors->has('company_id'))
                <div class="text-danger">
                    {{ $errors->first('company_id') }}
                </div>
                @endif
            </div>
        </div>


        <div class="form-row">
            <div class="col-md-3 mb-3">
                <label for="price">価格&#42;</label>
                <input type="text" class="form-control" id="price" name="price" value="{{ $product->price }}">
            </div>
            @if($errors->has('price'))
            <div class="text-danger">
                {{ $errors->first('price') }}
            </div>
            @endif
        </div>

        <div class="form-row">
            <div class="col-md-3 mb-3">
                <label for="stock">在庫数&#42;</label>
                <input type="text" class="form-control" id="stock" name="stock" value="{{ $product->idstock }}">
            </div>
            @if($errors->has('stock'))
            <div class="text-danger">
                {{ $errors->first('stock')}}
            </div>
            @endif
        </div>

        <div class="form-row">
            <div class="custom-file mb-3">
                <label for="img_path">商品画像</label>
                <input type="file" class="custom-file-input" id="img_path" name="img_path" value="{{ old('img_path') }}">
                {{--<label class="productFile" for="customFile">ファイル選択...</label>--}}
                <img src="{{ asset($product->image_file) }}">
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="comment">コメント</label>
            <textarea class="form-control" id="comment" name="comment" rows="3">{{ $product->comment }}</textarea>
            @if($errors->has('comment'))
            <div class="text-danger">
                {{ $errors->first('comment') }}
            </div>
            @endif
        </div>


        <!--ボタンブロック-->
        <div class="form-group row">
            <div class="mt-5">
                <button type="submit" class="btn btn-primary">更新</button>
                <a href="{{route('detail', $product->id)}}" class="btn btn-warning">戻る</a>

            </div>
        </div>

    </form>

</div>
</body>

</html>

@endsection