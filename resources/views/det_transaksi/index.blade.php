@extends('templates.layout')

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h1>Transaksi History </h1>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                            </div>
                            @endif
                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <div class="x_content">
                                <a href="{{ route('export-pdf') }}" class="btn btn-primary"><i class="fa fa-file-pdf-o"></i>Export PDF</a>
                                <a class="btn btn-success" href="{{route('export-detail_transaksi')}}"><i class="fa fa-file-excel-o"></i> Export </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Id Transaksi</th>
                                            <th>Id Menu</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaksi as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->id }}</td>
                                            <td>
                                                @foreach($item->detailTransaksi as $detail)
                                                <p>Nama:{{$detail->menu->nama_menu}}</p>
                                                <p>Qty:{{$detail->jumlah}}</p>
                                                <p>Subtotal:{{$detail->subtotal}}</p>
                                                <hr>
                                                @endforeach
                                            </td>
                                            <td>{{ $item->total_harga }}</td>
                                            <td>
                                                @csrf
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endsection