@extends('layouts.main')

@section('title')
Pembayaran {{ $title }} -
@endsection

@section('content')
    <div class="container-fluid pt-4">
        <h3>
            <img src="{{ asset('img/category.png') }}" alt="" class="img-fluid" style="height: 28px">
            Pembayaran {{ $title }}
        </h3>
        <div class="row">
            <div class="col-md-4 col-6">
                <div class="card">
                    <div class="card-header p-1">
                        <a href="{{ route('transaction') }}" class="btn btn-sm btn-block btn-secondary">Kembali</a>
                    </div>
                    <div class="card-body p-2">
                        <p class="mb-0">No.Penjualan : {{ $transaction->no_transaction }}</p>
                        <p class="mb-1 float-right">Tanggal : {{ format_date($transaction->date) }}</p>
                        <p class="mb-1">Pelanggan : {{ $transaction->customer->name }}</p>
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
                <button type="button" class="btn btn-lg btn-primary btn-block mt-3 shadow-sm" onclick="savetransaction()">Simpan Pembayaran</button>
            </div>
            <div class="col-md-8 col-6">
                <div class="card">
                    <div class="card-body" style="height: calc(100vh - 140px);overflow-y: scroll;">
                        <form action="{{ route('transaction.save') }}" method="post" id="form_transaction">
                            @csrf
                            <input type="hidden" name="id" value="{{ $transaction->id }}">
                            <input type="hidden" name="date" value="{{ $transaction->date }}">
                            <input type="hidden" name="payment" value="1">
                            <input type="hidden" name="status" value="Selesai">
                            <div class="form-group text-right">
                                <label for="total"><h1>Total Penjualan</h1></label>
                                <input type="text" class="form-control form-control-xl text-right" name="total" id="total" value="{{ format_number($transaction->product_transaction_details->sum('total')) }}" readonly>
                            </div>
                            <div class="form-group text-right">
                                <label for="cash"><h1>Dibayar</h1></label>
                                <input type="text" class="form-control form-control-xl text-right autonumeric" name="cash" id="cash" placeholder="0" autofocus required>
                            </div>
                            <div class="form-group text-right">
                                <label for="change"><h1>Kembalian</h1></label>
                                <input type="text" class="form-control form-control-xl text-right" name="change" id="change" readonly>
                            </div>
                            <button type="submit" id="submit_transaction" style="display: none;">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if(!empty($transaction))

        @endif
    </div>
@endsection

@if(!empty($transaction))
    @push('scripts')
        <script>
            function savetransaction()
            {
                $('#submit_transaction').trigger('click');
            }
            $('#cash').keyup(function () {
                let total = $('#total').val();
                total = parseFloat(remove_commas(total));

                let cash = $('#cash').val();
                cash = cash !== '' ? parseFloat(remove_commas(cash)) : 0;

                let change = cash - total;
                $('#change').val(add_commas(change.toString()));
            });
        </script>
    @endpush
@endif
