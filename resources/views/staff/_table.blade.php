<div class="table-responsive">
    <table class="table table-sm table-bordered">
        <thead>
        <tr>
            <th class="text-center" width="50px">No</th>
            <th>Nama</th>
            <th>NIK</th>
            <th class="text-center" width="100px">Perintah</th>
        </tr>
        </thead>
        <tbody>
        @foreach($staffs as $key => $staff)
            <tr>
                <td class="text-center">
                    @if($staffs instanceof \Illuminate\Pagination\LengthAwarePaginator )
                        {{ (($staffs->currentPage()-1)*10)+($key+1) }}
                    @else {{ $key+1 }} @endif
                </td>
                <td class="text-nowrap">{{ $staff->name }}</td>
                <td>{{ $staff->no_id }}</td>
                <td class="text-center p-0">
                    <a href="{{ route('staff.info', 'id=' . $staff->id) }}" class="btn btn-sm btn-secondary">Ubah</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
{{ $staffs->links() }}
