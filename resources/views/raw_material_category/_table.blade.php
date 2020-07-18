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
        @foreach($rawMaterialCategories as $key => $rawMaterialCategory)
            <tr>
                <td class="text-center">
                    @if($rawMaterialCategories instanceof \Illuminate\Pagination\LengthAwarePaginator )
                        {{ (($rawMaterialCategories->currentPage()-1)*10)+($key+1) }}
                    @else {{ $key+1 }} @endif
                </td>
                <td class="text-nowrap">{{ $rawMaterialCategory->name }}</td>
                <td>{{ $rawMaterialCategory->description }}</td>
                <td class="text-center p-0">
                    <a href="{{ route('raw_material_category.info', 'id=' . $rawMaterialCategory->id) }}" class="btn btn-sm btn-secondary">Ubah</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $rawMaterialCategories->links() }}
