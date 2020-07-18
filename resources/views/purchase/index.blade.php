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
                <div class="row">
                    <div class="col-md-6 text-left">
                        <button type="button" onclick="toggleSearch()" class="btn btn-info">Pencarian</button>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('purchase.info') }}" class="btn btn-primary">Pembelian Baru</a>
                    </div>
                </div>
                <form action="{{ route('purchase.search') }}" method="post" style="display: none;" id="form_search">
                    @csrf
                    <div class="input-group mt-3">
                        <input type="text" class="form-control" id="search_no_transaction" name="no_transaction" placeholder="No. Pembelian">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-secondary" id="button_search">Cari</button>
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
        function toggleSearch() {
            formSearch.slideToggle();
        }
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
            $.post("{{ route('purchase.search') }}?page=" + selectedPage, {
                _token: '{{ csrf_token() }}',
                no_transaction: $('#search_no_transaction').val()
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
