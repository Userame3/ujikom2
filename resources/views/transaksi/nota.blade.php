<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faktur Transaksi</title>
    <style>
        /* Gaya CSS untuk faktur */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            margin-bottom: 5px;
        }

        h5 {
            margin: 0;
        }

        hr {
            margin-top: 5px;
            margin-bottom: 10px;
            border: 0;
            border-top: 1px solid #ccc;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tfoot td {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>Cafe Indomart</h2>
    <h5>Jl. Mockingjay No. 45, 34234</h5>
    <hr>
    <h5>No. Faktur: {{ $transaksi->id }}</h5>
    <h5>Tanggal: {{ $transaksi->tanggal }}</h5>
    <table>
        <thead>
            <tr>
                <th>Qty</th>
                <th>Item</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi->detailTransaksi as $item)
            <tr>
                <td>{{ $item->jumlah }}</td>
                <td>{{ $item->menu ? $item->menu->nama_menu : $item->titipan->nama_produk }}</td>
                <td>{{ number_format($item->menu ? $item->menu->harga : $item->titipan->harga_jual, 0, ",", ",") }}</td>
                <td>{{ number_format($item->subtotal, 0, ",", ",") }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3">Total</td>
                <td>{{ number_format($transaksi->total_harga, 0, ",", ",") }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>