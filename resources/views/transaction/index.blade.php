@extends('layouts.main')

@section('title')
{{ $title }} -
@endsection

@section('content')
    <div class="container pt-4">
        <h3>
            <img src="{{ asset('img/category.png') }}" alt="" class="img-fluid" style="height: 28px">
            {{ $title }}
        </h3>
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('purchase.search') }}" method="post" id="form_search">
                    @csrf
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group mb-0">
                                <label for="search_date">Tanggal</label>
                                <input type="text" class="form-control datepicker" name="date" id="search_date" value="{{ date('d-m-Y') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-0">
                                <label for="search_status">Status</label>
                                <select name="status" id="search_status" class="form-control">
                                    <option value="Proses">Proses</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-0">
                                <label for="search_customer_id">Pelanggan</label>
                                <select name="customer_id" id="search_customer_id" class="form-control">
                                    <option value="">Semua</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mb-0">
                                <label for="button_search">&nbsp;</label>
                                <br>
                                <button type="submit" class="btn btn-secondary btn-block" id="button_search">Cari</button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mb-0">
                                <label for="button_search">&nbsp;</label>
                                <br>
                                <a href="{{ route('transaction.info') }}" class="btn btn-primary btn-block">Penjualan Baru</a>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <div id="content_table"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let formSearch = $('#form_search');
        let selectedPage = 1;
        function searchData(page = '1') {
            if (page === '-1') selectedPage -= 1;
            else if (page === '+1') selectedPage += 1;
            else selectedPage = parseInt(page);
            $('#form_search').trigger('submit');
        }
        formSearch.submit(function (e) {
            e.preventDefault();

            let button = $('#button_search');
            button.html('Loading ...');
            $.post("{{ route('transaction.search') }}?page=" + selectedPage, {
                _token: '{{ csrf_token() }}',
                no_transaction: $('#search_no_transaction').val(),
                customer_id: $('#search_customer_id').find('option:selected').val(),
                date: $('#search_date').val(),
                status: $('#search_status').find('option:selected').val(),
            }, function (result) {
                $('#content_table').html(result);
                button.html('Cari');
            }).fail(function (xhr) {
                console.log(xhr.responseText);
                button.html('Error!');
            });
        });
        searchData();
    </script>
@endpush
