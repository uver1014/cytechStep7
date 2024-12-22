@foreach ($products as $product)
<tr id="tr_{{ $product->id }}">
    <td>{{ $product->id }}</td>
    <td><img src="{{ asset($product->img_path) }}" class="img"></td>
    <td>{{ $product->product_name }}</td>
    <td>{{ $product->price }}</td>
    <td>{{ $product->stock }}</td>
    <td>{{ $product->company_name }}</td>
    <td><a href="{{ route('detail', $product->id) }}" class="btn btn-primary">詳細</a></td>
    <td>
        <button class="btn btn-danger delete-btn" data-id="{{ $product->id }}">削除</button>
    </td>
</tr>
@endforeach