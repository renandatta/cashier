@extends('layouts.main')

@section('title')
    Dashboard -
@endsection

@section('content')
    <div class="container-fluid pt-4 pb-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4>Grafik Penjualan Bulan Ini</h4>
                <div id="transaction_chart" style="height: 400px;"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm mt-3">
                    <div class="card-body">
                        <h4>Produk Terjual Paling Banyak Bulan Ini</h4>
                        <div id="popular_product_data"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm mt-3">
                    <div class="card-body">
                        <h4>Bahan Baku Hampir Habis</h4>
                        <div id="warning_raw_material_data"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('lib/amcharts/amcharts.js') }}"></script>
    <script src="{{ asset('lib/amcharts/serial.js') }}"></script>
    <script>
        function loadGraph() {
            $.post("{{ route('dashboard.transaction') }}", {
                _token: '{{ csrf_token() }}',
                month: '{{ date('m-Y') }}'
            }, function (result) {
                console.log(result);
                AmCharts.makeChart("transaction_chart",
                    {
                        "type": "serial",
                        "categoryField": "date",
                        "startDuration": 1,
                        "decimalSeparator": ",",
                        "thousandsSeparator": ".",
                        "categoryAxis": {
                            "gridPosition": "start",
                            "labelRotation": 90
                        },
                        "trendLines": [],
                        "graphs": [
                            {
                                "balloonText": "Tanggal : [[category]] <br> Total Penjualan Rp.[[value]] <br> Total Transaksi [[count]]",
                                "bullet": "round",
                                "id": "AmGraph-1",
                                "title": "graph 1",
                                "type": "smoothedLine",
                                "valueField": "total"
                            }
                        ],
                        "guides": [],
                        "valueAxes": [
                            {
                                "id": "ValueAxis-1",
                                "title": ""
                            }
                        ],
                        "allLabels": [],
                        "balloon": {},
                        "titles": [],
                        "dataProvider": result
                    }
                );
            }).fail(function (xhr) {
                console.log(xhr.responseText);
            });
        }
        function popularProduct() {
            $.post("{{ route('dashboard.popular_product') }}", {
                _token: '{{ csrf_token() }}',
                month: '{{ date('m-Y') }}'
            }, function (result) {
                $('#popular_product_data').html(result);
            }).fail(function (xhr) {
                console.log(xhr.responseText);
            });
        }
        function warningRawMaterial() {
            $.post("{{ route('dashboard.warning_raw_material') }}", {
                _token: '{{ csrf_token() }}',
            }, function (result) {
                $('#warning_raw_material_data').html(result);
            }).fail(function (xhr) {
                console.log(xhr.responseText);
            });
        }
        loadGraph();
        popularProduct();
        warningRawMaterial();
    </script>
@endpush
