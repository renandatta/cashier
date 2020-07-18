<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <thead>
        <tr>
            <th class="text-center" width="50px">No</th>
            <th>Nama</th>
            <th>Keterangan</th>
            <th class="text-center" width="100px">Perintah</th>
        </tr>
        </thead>
        <tbody>
        @foreach($productCategories as $key => $productCategory)
            <tr>
                <td class="text-center">
                    @if($productCategories instanceof \Illuminate\Pagination\LengthAwarePaginator )
                        {{ (($productCategories->currentPage()-1)*10)+($key+1) }}
                    @else {{ $key+1 }} @endif
                </td>
                <td class="text-nowrap">{{ $productCategory->name }}</td>
                <td>{{ $productCategory->description }}</td>
                <td class="text-center p-0">
                    <a href="{{ route('product_category.info', 'id=' . $productCategory->id) }}" class="btn btn-sm btn-secondary">Ubah</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $productCategories->links() }}
