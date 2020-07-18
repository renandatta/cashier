<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <thead>
        <tr>
            <th class="text-center" width="50px">No</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Tag</th>
            <th class=" text-right">Harga</th>
            <th class="text-center" width="100px">Perintah</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $key => $product)
            <tr>
                <td class="text-center">
                    @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator )
                        {{ (($products->currentPage()-1)*10)+($key+1) }}
                    @else {{ $key+1 }} @endif
                </td>
                <td class="text-nowrap">{{ $product->name }}</td>
                <td class="text-nowrap">{{ $product->product_category->name }}</td>
                <td>{{ $product->tag }}</td>
                <td class="text-nowrap text-right">{{ format_number($product->price) }}</td>
                <td class="text-center p-0">
                    <a href="{{ route('product.info', 'id=' . $product->id) }}" class="btn btn-sm btn-secondary">Ubah</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $products->links() }}
