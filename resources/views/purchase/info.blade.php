@extends('layouts.main')

@section('title')
{{ empty($purchase) ? 'Tambah' : 'Ubah' }} {{ $title }} -
@endsection

@section('content')
    <div class="container-fluid pt-4">
        <h3>
            <img src="{{ asset('img/category.png') }}" alt="" class="img-fluid" style="height: 28px">
            {{ empty($purchase) ? 'Tambah' : 'Ubah' }} {{ $title }}
        </h3>
        <div class="card shadow-sm">
            @if(!empty($purchase))
            <div class="card-header text-right p-2">
                <div class="row">
                    <div class="col-md-6 text-left">
                        <a href="{{ route('purchase') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                    <div class="col-md-6 text-right">
                        <form action="{{ route('purchase.delete') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $purchase->id }}">
                            <button type="submit" class="btn btn-danger">Hapus dan Batalkan Pembelian</button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            <div class="card-body">
                <form action="{{ route('purchase.save') }}" method="post">
                    @csrf
                    @if(!empty($purchase))
                        <input type="hidden" name="id" value="{{ $purchase->id }}">
                    @endif
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group mb-0">
                                <label for="no_transaction">No.Pembelian</label>
                                <input type="text" class="form-control" id="no_transaction" name="no_transaction" value="{{ !empty($purchase) ? $purchase->no_transaction : date('ymdHis') }}" required @if(!empty($purchase)) readonly @endif>
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-3">
                            <div class="form-group mb-0 text-right">
                                <label for="date">Tanggal</label>
                                <input type="text" class="form-control text-right" id="date" name="date" value="{{ !empty($purchase) ? $purchase->date : date('d-m-Y') }}" readonly>
                            </div>
                        </div>
                    </div>
                    @if(empty($purchase))
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Tambahkan Detail Bahan Baku</button>
                            <a href="{{ route('purchase') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
        @if(!empty($purchase))
            <div class="card mt-3">
                <div class="card-body">
                    <table class="table table-sm table-bordered">
                        <thead>
                        <tr>
                            <th class="text-center" width="8%">#</th>
                            <th>Bahan Baku</th>
                            <th class="text-right" width="15%">Harga Beli</th>
                            <th class="text-right" width="10%">Jumlah</th>
                            <th class="text-right" width="15%">Harga Satuan</th>
                        </tr>
                        <tr>
                            <th class="p-0">
                                <button type="button" class="btn btn-sm btn-primary btn-block border-radius-0" id="button_save_detail" onclick="saveDetail()">Tambahkan</button>
                            </th>
                            <th class="p-0">
                                <select name="raw_material_id" id="raw_material_id" class="form-control select2">
                                    <option value="">- Pilih Bahan Baku -</option>
                                    @foreach($rawMaterials as $rawMaterial)
                                        <option value="{{ $rawMaterial->id }}">{{ $rawMaterial->name }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th class="p-0">
                                <input type="text" class="form-control text-right form-control-sm border-0 border-radius-0 autonumeric" name="total" id="total" value="0">
                            </th>
                            <th class="p-0">
                                <input type="text" class="form-control text-right form-control-sm border-0 border-radius-0 autonumeric" name="qty" id="qty" value="0">
                            </th>
                            <th class="p-0">
                                <input type="text" class="form-control text-right form-control-sm border-0 border-radius-0 autonumeric" name="price" id="price" value="0">
                            </th>
                        </tr>
                        </thead>
                        <tbody id="list_details">
                        @foreach($purchase->raw_material_purchase_details as $detail)
                            <tr id="row_detail_{{ $detail->id }}">
                                <th class="p-0">
                                    <button type="button" class="btn btn-sm btn-danger btn-block border-radius-0" id="button_save_detail" onclick="deleteDetail('{{ $detail->id }}')">Hapus</button>
                                </th>
                                <td>{{ $detail->raw_material->name }}</td>
                                <td class="text-right">{{ format_number($detail->total) }}</td>
                                <td class="text-right">{{ format_number($detail->qty) }}</td>
                                <td class="text-right">{{ format_number($detail->price) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection

@if(!empty($purchase))
    @push('scripts')
        <script>
            let rawMaterialId = $('#raw_material_id'),
                total = $('#total'),
                qty = $('#qty'),
                price = $('#price'),
                buttonSaveDetail = $('#button_save_detail');
            function saveDetail() {
                if (rawMaterialId.find('option:selected').val() === '' || total.val() === '' || qty.val() === '' || price.val() === '') {
                    alert('Lengkapi Kolom !');
                    return false;
                }
                buttonSaveDetail.html('Loading');
                $.post("{{ route('purchase.detail.save') }}", {
                    _token: '{{ csrf_token() }}',
                    ajax: 1,
                    raw_material_purchase_id: '{{ $purchase->id }}',
                    raw_material_id: rawMaterialId.find('option:selected').val(),
                    qty: qty.val(),
                    price: price.val(),
                    status: 'Proses'
                }, function (result) {
                    $('#list_details').append('<tr id="row_detail_'+ result.id +'">\n' +
                        '    <th class="p-0">\n' +
                        '        <button type="button" class="btn btn-sm btn-danger btn-block border-radius-0" id="button_save_detail" onclick="deleteDetail('+ result.id +')">Hapus</button>\n' +
                        '    </th>\n' +
                        '    <td>'+ result.raw_material.name +'</td>\n' +
                        '    <td class="text-right">'+ add_commas(result.total) +'</td>\n' +
                        '    <td class="text-right">'+ add_commas(result.qty) +'</td>\n' +
                        '    <td class="text-right">'+ add_commas(result.price) +'</td>\n' +
                        '</tr>');
                    resetDetail();
                }).fail(function (xhr) {
                    console.log(xhr.responseText);
                });
            }
            function deleteDetail(id) {
                $.post('{{ route('purchase.detail.delete') }}', {
                    _token: '{{ csrf_token() }}',
                    id: id
                }, function () {
                    $('#row_detail_' + id).hide();
                });
            }
            function resetDetail() {
                rawMaterialId.val('');
                rawMaterialId.select2();
                total.val('');
                qty.val('');
                price.val('');
                buttonSaveDetail.html('Tambahkan');
            }
            $('#total, #qty, #price').change(function () {
                let totalPrice = total.val();
                let qtyPurchase = qty.val();

                totalPrice = (totalPrice !== '') ? parseFloat(remove_commas(totalPrice)) : 0;
                qtyPurchase = (qtyPurchase !== '') ? parseFloat(remove_commas(qtyPurchase)) : 0;

                price.val(add_commas((totalPrice / qtyPurchase).toFixed(0)));
            });
        </script>
    @endpush
@endif
