@extends('Test.lists')
@section('title','商品一覧画面')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-4">
            <h2>商品一覧画面</h2>
            @if(session('message'))
            <div class="text-danger">
                {{ session('message') }}
            </div>
            @endif
            <table class="search">
                <form action="{{ route('search') }}" method="get">
                    @csrf
                    <input type="text" id="keyword" name="keyword" placeholder="検索ワード">
                    <label for="company_id">メーカー名:</label>
                    <select id="company_id" name="company_id">
                        <option value="">選択してください</option>
                        @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                        @endforeach
                    </select>
                    <button type="submit">検索</button>
                </form>
            </table>

        </div>
        <table class="table table-striped">
            <tr>
                <th>ID</th>
                <th>商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫名</th>
                <th>メーカー名</th>
                <th><a href="{{ route('create') }}" button type="button" class="btn btn-success">新規登録</th>
                <th></th>
            </tr>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td><img src="{{ asset'storage/images/'.($product->image_file) }}"></td>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ $product-> company-> company_name }}</td>
                <td><a href="{{ route('detail',$product->id) }}" class="btn btn-primary">詳細</a></td>
                <td>
                    <form method="POST" action="{{ route('delete', $product->id) }}" onSubmit="return checkDelete()" enctype='multipart/form-data'>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">削除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>

@endsection