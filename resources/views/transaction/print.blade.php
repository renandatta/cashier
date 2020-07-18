@extends('layouts.blank')

@push('styles')
    <style>
        table{
            width: 100%;
        }
        p {
            font-size: 7pt;
        }
        table tr td{
            border: 0;
            font-size: 7pt;
        }
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
        }
        @media print {
            #button_back {
                display: none;
            }
        }
    </style>
@endpush

@section('content')
    <a href="{{ route('transaction') }}" id="button_back">Kembali</a>
    <p class="mb-0">No.Penjualan : {{ $transaction->no_transaction }}</p>
    <p class="mb-1 float-right">Tanggal : {{ format_date($transaction->date) }}</p>
    <p class="mb-1">Pelanggan : {{ $transaction->customer->name }}</p>
    <hr>
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
                <hr>
                <div class="float-right text-right">
                    <b id="totalTransaction">{{ format_number($transaction->product_transaction_details->sum('total')) }}</b>
                </div>
                <b>Total</b>
            </td>
        </tr>
        </tfoot>
        </tbody>
    </table>
@endsection

@push('scripts')
    <script>

    </script>
@endpush
