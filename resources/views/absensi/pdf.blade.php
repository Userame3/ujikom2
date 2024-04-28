<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan PDF</title>
    <style>
        /* Gaya CSS untuk PDF */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Laporan PDF</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Karyawan</th>
                <th>Tanggal Masuk</th>
                <th>Waktu Masuk</th>
                <th>Status</th>
                <th>Waktu Keluar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->namaKaryawan }}</td>
                    <td>{{ $item->tanggalMasuk }}</td>
                    <td>{{ $item->waktuMasuk }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->waktuKeluar }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
