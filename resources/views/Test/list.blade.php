@extends('Test.base')
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
                <form id="search-form" action="{{ route('search') }}" method="get">
                    @csrf
                    <input type="number" id="pricemin" name="pricemin" placeholder="価格最安値">
                    <input type="number" id="pricemax" name="pricemax" placeholder="価格最大値">
                    <input type="number" id="stockmin" name="stockmin" placeholder="最小在庫数">
                    <input type="number" id="stockmax" name="stockmax" placeholder="最大在庫数">
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
        <table class="tablesorter" id="table_sort">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>商品画像</th>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>在庫数</th>
                    <th>メーカー名</th>
                    <th><a href="{{ route('create') }}" button type="button" class="btn btn-success">新規登録</a></th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="allData">
                @foreach($products as $product)
                <tr id="tr_{{$product->id}}">
                    <td>{{ $product->id }}</td>
                    <td><img src="{{ asset($product->img_path) }}" class="img"></td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->company_name }}</td>
                    <td><a href="{{ route('detail',$product->id) }}" class="btn btn-primary">詳細</a></td>
                    <td>
                    <a href="javascript(0)" class="btn btn-danger" id="deletepost" >削除</a>
                    </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tbody id="searchData">
            </tbody>
        </table>
        {{ $products->appends(request()->query())->links() }}
    </div>



    <script type="text/javascript">
        $(document).ready(function() {
            $("#table_sort").tablesorter();
        });

        $(document).ready(function() {

            $('#search-form').on('submit', function(e) {
                e.preventDefault();
                const keyword = $('#keyword').val();
                const company_id = $('#company_id').val();
                const pricemin = $('#pricemin').val();
                const pricemax = $('#pricemax').val();
                const stockmin = $('#stockmin').val();
                const stockmax = $('#stockmax').val();
                $('#allData').hide();

                $.ajax({
                    url: "{{ route('search') }}", //$(this).attr('action'),
                    type: 'GET',
                    data: {
                        keyword: keyword,
                        company_id: company_id,
                        pricemin: pricemin,
                        pricemax: pricemax,
                        stockmin: stockmin,
                        stockmax: stockmax,
                    },
                    success: function(response) {
                        $('#searchData').html(response);
                    },
                    error: function() {
                        alert('検索に失敗しました。');
                        $('#allData').show();
                    }
                });
            });
        });

        $(document).ready(function() {
            $('#deletepost').on('click', function(e) {

                if(comfirm('削除してよろしいですか?')){
                    $.ajaxSetup({
                        header:{
                            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url:'delete/'+id,
                        type:"DELETE",

                        success:function(result){
                            $("#"+result['tr']).fadeOut("slow", function(){
                                alert('削除しました。');
                            });
                        }
                    });

                }
            })
            
        });

        
    </script>
</div>

@endsection