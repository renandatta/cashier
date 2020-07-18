<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <thead>
        <tr>
            <th class="text-center" width="50px">No</th>
            <th>No.Pembelian</th>
            <th>Tanggal</th>
            <th>Operator</th>
            <th class=" text-right">Harga</th>
            <th class=" text-right">Jumlah Item</th>
            <th class="text-center" width="100px">Perintah</th>
        </tr>
        </thead>
        <tbody>
        @foreach($purchases as $key => $purchase)
            <tr>
                <td class="text-center">
                    @if($purchases instanceof \Illuminate\Pagination\LengthAwarePaginator )
                        {{ (($purchases->currentPage()-1)*10)+($key+1) }}
                    @else {{ $key+1 }} @endif
                </td>
                <td class="text-nowrap">{{ $purchase->no_transaction }}</td>
                <td class="text-nowrap">{{ format_date($purchase->date) }}</td>
                <td>{{ $purchase->user->name }}</td>
                <td class="text-nowrap text-right">{{ format_number($purchase->raw_material_purchase_details->sum('total')) }}</td>
                <td class="text-nowrap text-right">{{ format_number(count($purchase->raw_material_purchase_details)) }} Item</td>
                <td class="text-center p-0">
                    <a href="{{ route('purchase.info', 'id=' . $purchase->id) }}" class="btn btn-sm btn-secondary">Ubah & Detail</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $purchases->links() }}
