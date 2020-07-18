<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <thead>
        <tr>
            <th class="text-center" width="50px">No</th>
            <th>No.Penjualan</th>
            <th>Tanggal</th>
            <th>Pelanggan</th>
            <th class=" text-right">Harga</th>
            <th class=" text-right">Jumlah Item</th>
            <th class="text-center" width="120px">Perintah</th>
            <th class="text-center" width="120px">Tutup</th>
        </tr>
        </thead>
        <tbody>
        @foreach($transactions as $key => $transaction)
            <tr>
                <td class="text-center">
                    @if($transactions instanceof \Illuminate\Pagination\LengthAwarePaginator )
                        {{ (($transactions->currentPage()-1)*10)+($key+1) }}
                    @else {{ $key+1 }} @endif
                </td>
                <td class="text-nowrap">{{ $transaction->no_transaction }}</td>
                <td class="text-nowrap">{{ format_date($transaction->date) }}</td>
                <td>{{ $transaction->customer->name }}</td>
                <td class="text-nowrap text-right">{{ format_number($transaction->product_transaction_details->sum('total')) }}</td>
                <td class="text-nowrap text-right">{{ format_number(count($transaction->product_transaction_details)) }} Item</td>
                <td class="text-center p-0">
                    @if($transaction->status != 'Selesai')
                        <a href="{{ route('transaction.info', 'id=' . $transaction->id) }}" class="btn btn-sm btn-secondary">Tambahkan Item</a>
                    @endif
                </td>
                <td class="text-center p-0">
                    @if($transaction->status == 'Selesai')
                        <a href="{{ route('transaction.print', 'id=' . $transaction->id) }}" class="btn btn-sm btn-success">Cetak Ulang</a>
                    @else
                        <a href="{{ route('transaction.payment', 'id=' . $transaction->id) }}" class="btn btn-sm btn-success">Ke Pembayaran</a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $transactions->links() }}
