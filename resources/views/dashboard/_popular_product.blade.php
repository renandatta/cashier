<div class="table-responsive">
    <table class="table table-sm table-bordered mb-0">
        <thead>
        <tr>
            <th class="text-center" width="50px">No</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th class=" text-right">Jumlah</th>
        </tr>
        </thead>
        <tbody>
        @foreach($transactions as $key => $transaction)
            <tr>
                <td class="text-center">{{ $key+1 }}</td>
                <td class="text-nowrap">{{ $transaction->product->name }}</td>
                <td class="text-nowrap">{{ $transaction->product->product_category->name }}</td>
                <td class="text-nowrap text-right">{{ format_number($transaction->count) . ' ' . $transaction->product->unit }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
