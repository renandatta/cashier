<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <thead>
        <tr>
            <th>Nama</th>
            <th>Kategori</th>
            <th class=" text-right">Jumlah</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rawMaterials as $key => $rawMaterial)
            <tr>
                <td class="text-nowrap">{{ $rawMaterial->name }}</td>
                <td class="text-nowrap">{{ $rawMaterial->raw_material_category->name }}</td>
                <td class="text-nowrap text-right">{{ format_number($rawMaterial->stock) . ' ' . $rawMaterial->unit }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
