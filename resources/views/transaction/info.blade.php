@extends('layouts.main')

@section('title')
{{ $title }} -
@endsection

@section('content')
    <div class="container-fluid pt-4">
        <h3>
            <img src="{{ asset('img/category.png') }}" alt="" class="img-fluid" style="height: 28px">
            {{ $title }}
        </h3>
        <div class="row">
            <div class="col-md-4 col-6">
                <div class="card shadow-sm">
                    @if(!empty($transaction))
                        <div class="card-header text-right p-2">
                            <div class="row">
                                <div class="col-4 text-left">
                                    <a href="{{ route('transaction') }}" class="btn btn-sm btn-block btn-secondary">Kembali</a>
                                </div>
                                <div class="col-8 text-right">
                                    <form action="{{ route('transaction.delete') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $transaction->id }}">
                                        <button type="submit" class="btn btn-sm btn-block btn-danger">Hapus dan Batalkan Penjualan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card-body p-2">
                        <form action="{{ route('transaction.save') }}" method="post">
                            @csrf
                            @if(!empty($transaction))
                                <input type="hidden" name="id" value="{{ $transaction->id }}">
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="no_transaction">No.Penjualan</label>
                                        <input type="text" class="form-control" id="no_transaction" name="no_transaction" value="{{ !empty($transaction) ? $transaction->no_transaction : date('ymdHis') }}" required @if(!empty($transaction)) readonly @endif>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group text-right">
                                        <label for="date">Tanggal</label>
                                        <input type="text" class="form-control text-right" id="date" name="date" value="{{ !empty($transaction) ? $transaction->date : date('d-m-Y') }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <label for="customer">Pelanggan</label>
                                <input type="text" class="form-control" id="customer" name="customer" placeholder="Nama Pelanggan"value="{{ !empty($transaction) ? $transaction->customer->name : '' }}" @if(!empty($transaction)) readonly @endif>
                            </div>
                            @if(empty($transaction))
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary">Tambahkan Produk</button>
                                    <a href="{{ route('transaction') }}" class="btn btn-secondary">Batal</a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
                @if(!empty($transaction))
                    <div class="card mt-3">
                        <div class="card-body p-2">
                            <h5><b>Daftar Produk</b></h5>
                            <table class="table">
                                <tbody id="list_transaction">
                                @foreach($transaction->product_transaction_details as $detail)
                                    <tr id="row_detail_{{ $detail->id }}">
                                        <td class="p-1">
                                            {{ $detail->product->name }}
                                            <div class="text-right">
                                                {{ $detail->qty }} x {{ format_number($detail->price) }} = <b>{{ format_number($detail->total) }}</b>
                                            </div>
                                        </td>
                                        <td class="p-1" width="30px" style="vertical-align: middle;">
                                            <button class="btn btn-sm btn-danger" onclick="deleteProduct('{{ $detail->id }}')">x</button>
                                        </td>
                                    </tr>
                                @endforeach
                                <tfoot>
                                <tr>
                                    <td class="p-1">
                                        <div class="float-right text-right">
                                            <b id="totalTransaction">{{ format_number($transaction->product_transaction_details->sum('total')) }}</b>
                                        </div>
                                        <b>Total</b>
                                    </td>
                                </tr>
                                </tfoot>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
            @if(!empty($transaction))
                <div class="col-md-8 col-6">
                    <div class="card">
                        <div class="card-body" style="height: calc(100vh - 140px);overflow-y: scroll;">
                            <input type="text" class="form-control form-control-lg mb-3" id="search_product" placeholder="Cari Nama Produk" autofocus>
                            <div id="list_product"></div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@if(!empty($transaction))
    @push('scripts')
        <script>
            let totalTransaction = parseFloat("{{ $transaction->product_transaction_details->sum('total') }}");
            function searchProduct()
            {
                $.post("{{ route('transaction.search_product') }}", {
                    _token: '{{ csrf_token() }}',
                    name: $('#search_product').val()
                }, function (result) {
                    $('#list_product').html(result);
                }).fail(function (xhr) {
                    console.log(xhr.responseText);
                });
            }
            function decreaseQty(id) {
                let qtyProduct = $('#qty_product_' + id);
                let qty = qtyProduct.val();
                qty = parseInt(qty);
                if (qty > 1) qty -= 1;
                else qty = 1;
                qtyProduct.val(qty);
            }
            function increaseQty(id) {
                let qtyProduct = $('#qty_product_' + id);
                let qty = qtyProduct.val();
                qty = parseInt(qty);
                qty += 1;
                qtyProduct.val(qty);
            }
            function addProduct(id, price) {
                let qty = $('#qty_product_' + id).val();
                $.post("{{ route('transaction.detail.save') }}", {
                    _token: '{{ csrf_token() }}',
                    ajax: 1,
                    product_transaction_id: '{{ $transaction->id }}',
                    product_id: id,
                    price: price,
                    qty: qty
                }, function (result) {
                    $('#list_transaction').append('<tr id="row_detail_'+ result.id +'">\n' +
                        '    <td class="p-1">\n' +
                        '        '+ result.product.name +'\n' +
                        '        <div class="text-right">\n' +
                        '            '+ result.qty +' x '+ add_commas(result.price) +' = <b>'+ add_commas(result.total) +'</b>\n' +
                        '        </div>\n' +
                        '    </td>\n' +
                        '    <td class="p-1" width="30px" style="vertical-align: middle;">\n' +
                        '        <button class="btn btn-sm btn-danger" onclick="deleteProduct('+ result.id +')">x</button>\n' +
                        '    </td>' +
                        '</tr>');
                    totalTransaction += result.total;
                    $('#totalTransaction').html(add_commas(totalTransaction.toString()));
                    $('#qty_product_' + id).val('1');
                }).fail(function (xhr) {
                    console.log(xhr.responseText);
                });
            }
            function deleteProduct(id) {
                $.post("{{ route('transaction.detail.delete') }}", {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    ajax: 1
                }, function (result) {
                    totalTransaction -= result.total;
                    $('#totalTransaction').html(add_commas(totalTransaction.toString()));
                    $('#row_detail_' + id).hide();
                }).fail(function (xhr) {
                    console.log(xhr.responseText);
                });
            }

            $('#search_product').keydown(function (e) {
                let productId = $('.product_id:first').val();
                let price = $('.product_id:first').attr('data-price');

                if (e.which === 13) {
                    addProduct(productId, price);
                    $('#search_product').val('');
                    searchProduct();
                } else
                if (e.which == 38) {
                    increaseQty(productId);
                } else
                if (e.which == 40) {
                    decreaseQty(productId);
                } else {
                    searchProduct();
                }
            });
            searchProduct();
        </script>
    @endpush
@endif
