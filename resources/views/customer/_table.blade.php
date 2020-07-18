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
        @foreach($customers as $key => $customer)
            <tr>
                <td class="text-center">
                    @if($customers instanceof \Illuminate\Pagination\LengthAwarePaginator )
                        {{ (($customers->currentPage()-1)*10)+($key+1) }}
                    @else {{ $key+1 }} @endif
                </td>
                <td class="text-nowrap">{{ $customer->name }}</td>
                <td>{{ $customer->description }}</td>
                <td class="text-center p-0">
                    <a href="{{ route('customer.info', 'id=' . $customer->id) }}" class="btn btn-sm btn-secondary">Ubah</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $customers->links() }}
