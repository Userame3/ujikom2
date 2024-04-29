@extends('templates.layout')

@push('style')
@endpush

@section('content')
    <div role="main">
        <div class>
            <div class="row" style="display: flex; width: 100%;">
                <!-- Jumlah Menu -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Jumlah Pendapatan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp
                                        {{ number_format($pendapatan, 0, ',', '.') }}</div>

                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-list-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Jumlah Pelanggan</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count_pelanggan }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Jumlah Transaksi</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count_transaksi }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-money fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Jumlah Transaksi Hari Ini</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $count_transaksi_today }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-calendar fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                        Sisa Stok</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $sisaStok }}</div>

                                </div>
                                <div class="col-auto">
                                    <i class="fa fa-list-alt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Transaction Summary <small>Weekly progress</small></h2>
                        <div class="filter">
                            <div id="reportrange" class="pull-right"
                                style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div id="chart" style="height: 370px; width: 100%;  "></div>
                        <div class="col-md-6 col-sm-3 ">
                            <div>
                                <div class="x_title">
                                    <h2>Pelanggan Baru</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                                aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#">Settings 1</a>
                                                <a class="dropdown-item" href="#">Settings 2</a>
                                            </div>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <ul class="list-unstyled top_profiles scroll-view">
                                    @foreach ($pelanggan as $p)
                                        <li class="media event">
                                            <a class="pull-left border-aero profile_thumb">
                                                <i class="fa fa-user aero"></i>
                                            </a>
                                            <div class="media-body">
                                                <a class="title" href="#">{{ $p->nama }}</a>
                                                <p>{{ $p->email }} </p>
                                                <p>{{ $p->alamat }}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-3 ">
                            <div>
                                <div class="x_title">
                                    <h2>Sisa Stok Yang Tersedia</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                                aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#">Settings 1</a>
                                                <a class="dropdown-item" href="#">Settings 2</a>
                                            </div>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <ul class="list-unstyled top_profiles scroll-view">
                                    @foreach ($stok as $p)
                                        <li class="media event">
                                            <img width="50px"
                                                src="{{ asset('storage/menu-images') }}/{{ $p->menu ? $p->menu->images : '' }}"
                                                alt="">
                                            <div class="media-body">
                                                <a class="title"
                                                    href="#">{{ $p->menu ? $p->menu->nama_menu : 'Unnamed' }}</a>
                                                <p>{{ $p->jumlah }}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-3 ">
                            <div>
                                <div class="x_title">
                                    <h2>Menu Paling Laris</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                                role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#">Settings 1</a>
                                                <a class="dropdown-item" href="#">Settings 2</a>
                                            </div>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <ul class="list-unstyled top_profiles scroll-view">
                                    @foreach ($laris as $p)
                                        <li class="media event">
                                            <img width="50px"
                                                src="{{ asset('storage/menu-images') }}/{{ $p->menu ? $p->menu->images : '' }}"
                                                alt="">
                                            <div class="media-body">
                                                <a class="title"
                                                    href="#">{{ $p->menu ? $p->menu->nama_menu : '--' }}</a>
                                                <p>{{ $p->jumlah }}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        window.onload = function() {
            var dataPenjualan = [];
            var dataJmlTransaksi = [];
            var chart;

            $.get("{{ url('/data_penjualan') }}/0", function(data) {
                console.log(data)
                $.each(data, function(key, value) {
                    let dat = value['tanggal'];
                    let year = dat.substring(0, 4);
                    let month = dat.substring(5, 7) - 1;
                    let day = dat.substring(8, 10);
                    // console.log(year+"-"+month+"-"+day);
                    dataPenjualan.push({
                        x: new Date(year, month, day),
                        y: parseInt(value['total_bayar'])
                    });

                    dataJmlTransaksi.push({
                        x: new Date(year, month, day),
                        y: parseInt(value['jumlah'])
                    });
                });

                chart = new CanvasJS.Chart("chart", {
                    title: {
                        text: "Grafik Pendapatan"
                    },
                    axisY: {
                        title: "Penjualan",
                        lineColor: "#70E000",
                        tickColor: "#70E000",
                        labelFontColor: "#70E000",
                        titleFontColor: "#70E000",
                        includeZero: true,
                        suffix: ""
                    },
                    axisY2: {
                        title: "Pendapatan",
                        lineColor: "#da2c38",
                        tickColor: "#da2c38",
                        labelFontColor: "#da2c38",
                        titleFontColor: "#da2c38",
                        includeZero: true,
                        prefix: "",
                        suffix: ""
                    },
                    toolTip: {
                        shared: true
                    },
                    legend: {
                        cursor: "pointer",
                        itemclick: toggleDataSeries
                    },
                    data: [{
                            type: "line",
                            name: "Penjualan",
                            color: "#70E000",
                            axisYIndex: 0,
                            showInLegend: true,
                            dataPoints: dataJmlTransaksi
                        },
                        {
                            type: "line",
                            name: "Pendapatan",
                            color: "#da2c38",
                            axisYType: "secondary",
                            showInLegend: true,
                            dataPoints: dataPenjualan
                        }
                    ]
                });
                chart.render();
                updateChart();
            });


            function updateChart() {
                $.get("{{ url('/data_peenjualan') }}/" + dataJmlTransaksi.length, function(data) {
                    console.log(data)
                    $.each(data, function(key, value) {
                        let date = value['tanggal'];
                        let year = date.substring(0, 4);
                        let month = date.substring(5, 7) - 1;
                        let day = date.substring(8, 10);
                        console.log(year + "-" + month + "-" + day);
                        dataPenjualan.push({
                            x: new Date(year, month, day),
                            y: parseInt(value['total_bayar'])
                        });

                        if (dataPenjualan.length == 1)
                            dataJmlTransaksi.pop({
                                x: new Date(year, month, day),
                                y: parseInt(value['jumlah'])
                            });
                        else
                            dataJmlTransaksi.push({
                                x: new Date(year, month, day),
                                y: parseInt(value['jumlah'])
                            });

                    });
                });
                chart.render();
                setTimeout(function() {
                    updateChart()
                }, 10000);
            }

            function toggleDataSeries(e) {
                if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                e.chart.render();
            }

        }
    </script>
@endpush
