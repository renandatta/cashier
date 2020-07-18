<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <thead>
        <tr>
            <th class="text-center" width="50px">No</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Tag</th>
            <th class=" text-right">Harga</th>
            <th class=" text-right">Jumlah</th>
            <th class="text-center" width="100px">Perintah</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rawMaterials as $key => $rawMaterial)
            <tr>
                <td class="text-center">
                    @if($rawMaterials instanceof \Illuminate\Pagination\LengthAwarePaginator )
                        {{ (($rawMaterials->currentPage()-1)*10)+($key+1) }}
                    @else {{ $key+1 }} @endif
                </td>
                <td class="text-nowrap">{{ $rawMaterial->name }}</td>
                <td class="text-nowrap">{{ $rawMaterial->raw_material_category->name }}</td>
                <td>{{ $rawMaterial->tag }}</td>
                <td class="text-nowrap text-right">{{ format_number($rawMaterial->price) }}</td>
                <td class="text-nowrap text-right">{{ format_number($rawMaterial->stock) . ' ' . $rawMaterial->unit }}</td>
                <td class="text-center p-0">
                    <a href="{{ route('raw_material.info', 'id=' . $rawMaterial->id) }}" class="btn btn-sm btn-secondary">Ubah</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $rawMaterials->links() }}
