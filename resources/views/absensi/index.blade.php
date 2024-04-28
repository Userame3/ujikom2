@extends('templates.layout')

@push('style')
@endpush

@section('content')


    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h1>Absensi Karyawan </h1>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <!-- <div class="alert alert-success alert-dismissible " role="alert">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <strong>Berhasil!</strong>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div> -->

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
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#formInputAbsensi"><i class="fa fa-plus-square"></i> Tambah
                                        Karyawan</button>

                                    <button class="btn btn-info" data-toggle="modal" data-target="#formInputabsensi"><i
                                            class="fa fa-file-excel-o"></i> Import</button>
                                    <a class="btn btn-success" href="{{ route('export-absensi') }}"><i
                                            class="fa fa-file-excel-o"></i>Export</a>
                                    <a href="{{ route('absensi-export-pdf') }}" class="btn btn-primary"><i
                                            class="fa fa-file-pdf-o"></i>Export PDF</a>


                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                                        <table id="data-absensi" class="table table-bordered table striped"
                                            style="text-align: center">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Karyawan</th>
                                                    <th>Tanggal Masuk</th>
                                                    <th>Waktu Masuk</th>
                                                    <th>Status</th>
                                                    <th>Waktu Selesai Kerja</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($absensi as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->namaKaryawan }}</td>
                                                        <td>{{ $item->tanggalMasuk }}</td>
                                                        <td>{{ $item->waktuMasuk }}</td>
                                                        <td>{{ $item->status }} </td>
                                                        <td>
                                                            @php
                                                                // Pisahkan jam dan menit dari waktu keluar
                                                                $jamKeluar = explode(':', $item->waktuKeluar)[0];
                                                                $menitKeluar = explode(':', $item->waktuKeluar)[1];

                                                                // A;bil jam saat ini

                                                                $jamSaatIni = (float) (date('H') + 7 . '.' . date('i'));
                                                                $jamSaatKeluarAh =
                                                                    (float) ($jamKeluar . '.' . $menitKeluar);

                                                                // dd($jamSaatIni, $jamSaatKeluarah);
                                                                // Jika jam keluar sama dengan jam saat ini, tampilkan "Selesai"
                                                                // Jika tidak, tampilkan waktu keluar
                                                                if ($jamSaatKeluarAh <= $jamSaatIni) {
                                                                    echo 'Selesai';
                                                                } else {
                                                                    echo $item->waktuKeluar;
                                                                }
                                                            @endphp
                                                        </td>
                                                        <td>

                                                            <button type="button" class="btn btn-warning"
                                                                data-toggle="modal" data-target="#formInputAbsensi"
                                                                data-mode="edit" data-id="{{ $item->id }}"
                                                                data-nama_karyawan="{{ $item->namaKaryawan }}"
                                                                data-tanggal_masuk="{{ $item->tanggalMasuk }}"
                                                                data-waktu_masuk="{{ $item->waktuMasuk }}"
                                                                data-status="{{ $item->status }}"
                                                                data-waktu_Keluar="{{ $item->waktuKeluar }}">
                                                                <i class='fa fa-edit'></i> Edit
                                                            </button>
                                                            <!-- <form action="titipan/{{ $item->id }}" method="post" style="display :inline"> -->
                                                            <form action="{{ route('absensi.destroy', $item->id) }}"
                                                                method="POST" class="d-inline form-delete"
                                                                style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-danger delete-data">
                                                                    <i class='fa fa-trash'></i> Delete
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('absensi.modal')
                @include('absensi.data')
            @endsection
            @push('script')
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    $(document).ready(function() {
                        $('#data-absensi tbody').on('dblclick', 'td', function() {
                            var column_num = parseInt($(this).index()) + 1;
                            var row_num = parseInt($(this).closest('tr').find('button[data-mode=edit]').data('id'));
                            console.log(row_num)
                            var col_name = $(this).closest('table').find('th').eq(column_num - 1).text();
                            if (col_name === 'Status') {
                                var current_data = $(this).text();
                                $(this).html('<select class="form-control select-status" data-id="' + row_num + '">' +
                                    '<option value="Masuk">Masuk</option>' +
                                    '<option value="Sakit">Sakit</option>' +
                                    '<option value="Cuti">Cuti</option>' +
                                    '</select>');
                                $(this).find('.select-status').val(current_data);

                            }
                        });

                        $('#data-absensi tbody').on('change', '.select-status', function() {
                            var new_status = $(this).val();
                            var row_num = $(this).data('id');
                            var valid_statuses = ['Masuk', 'Sakit', 'Cuti']; // Daftar status yang valid

                            if (!valid_statuses.includes(new_status)) {
                                var confirm_custom_status = confirm(
                                    'Status tidak valid. Apakah Anda ingin menggunakan status kustom?');
                                if (confirm_custom_status) {
                                    var input_status = prompt('Masukkan status baru:');
                                    if (input_status !== null && input_status.trim() !== '') {
                                        new_status = input_status.trim();
                                    } else {
                                        $(this).val($(this).data(
                                            'prev-status'
                                        )); // Kembalikan ke status sebelumnya jika status kustom tidak valid
                                        return;
                                    }
                                } else {
                                    $(this).val($(this).data(
                                        'prev-status'
                                    )); // Kembalikan ke status sebelumnya jika tidak ingin menggunakan status kustom
                                    return;
                                }
                            }

                            // Send the new status to the backend using AJAX
                            $.ajax({
                                type: "POST",
                                url: "update-status",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    row_num: row_num,
                                    new_status: new_status
                                },
                                success: function(response) {
                                    // Handle the response
                                    console.log(response);
                                },
                                error: function(error) {
                                    // Handle the error
                                    console.log(error);
                                }
                            });

                            $(this).parent().text(new_status);
                        });


                    });
                </script>

                <script>
                    console.log('absensi')
                    // $('#dataTable').DataTable();

                    $('.alert-success').fadeTo(2000, 500).slideUp(500, function() {
                        $('.alert-success').slideUp(500)
                    });

                    $('.delete-data').on('click', function(e) {
                        e.preventDefault()
                        let nama_absensi = $(this).closest('tr').find('td:eq(1)').text()
                        Swal.fire({
                            title: `Apakah data ${nama_absensi} akan dihapus ?`,
                            text: 'Data tidak bisa dikembalikan!',
                            icon: 'error',
                            showDenyButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: 'd33',
                            confirmButtonText: 'Ya, hapus data ini!'
                        }).then((result) => {
                            if (result.isConfirmed)
                                $(e.target).closest('form').submit()
                            else swal.close()
                        });
                    });

                    $('#formInputAbsensi').on('show.bs.modal', function(e) {
                        console.log('modal')
                        const btn = $(e.relatedTarget)
                        const mode = btn.data('mode')
                        const namaKaryawan = btn.data('nama_karyawan')
                        const tanggalMasuk = btn.data('tanggal_masuk')
                        const waktuMasuk = btn.data('waktu_masuk')
                        const status = btn.data('status')
                        const waktuKeluar = btn.data('waktu_keluar')
                        const id = btn.data('id')
                        const modal = $(this)
                        console.log(status)
                        if (mode === 'edit') {
                            modal.find('.modal-title').text('Edit Karyawan')
                            modal.find('#namaKaryawan').val(namaKaryawan)
                            modal.find('#tanggalMasuk').val(tanggalMasuk)
                            modal.find('#waktuMasuk').val(waktuMasuk)
                            modal.find('#status').val(status)
                            modal.find('#waktuKeluar').val(waktuKeluar)
                            modal.find('.modal-body form').attr('action', '{{ url('absensi') }}/' + id)
                            modal.find('#method').html('@method('PATCH')')
                        } else {
                            modal.find('.modal-title').text('Input Absen')
                            modal.find('#namaKaryawan').val('')
                            modal.find('#tanggalMasuk').val('')
                            modal.find('#nama_supplier').val('')
                            modal.find('#status').val('')
                            modal.find('#waktuKeluar').val('')
                            modal.find('#method').html('')
                            modal.find('.modal-body form').attr('action', '{{ url('absensi') }}')
                        }
                    })
                </script>
                <script>
                    $(document).ready(function() {
                        // Memeriksa apakah DataTable sudah diinisialisasi sebelumnya
                        if (!$.fn.DataTable.isDataTable('#absensi')) {
                            $('#absensi').DataTable();
                        }
                    });
                </script>

                <script>
                    $(document).ready(function() {
                        // Mengubah stok menjadi input teks saat didouble klik
                        $('#data-absensi').on('dblclick', 'td:nth-child(7)', function() {
                            var value = $(this).text();
                            $(this).html('<input type="number" class="form-control" value="' + value + '">');
                        });

                        // Mengirim perubahan stok ke database saat tombol enter ditekan
                        $('#data-absensi').on('keypress', 'input[type="number"]', function(e) {
                            if (e.which == 13) { // Tombol enter ditekan
                                var newValue = $(this).val();
                                var id = $(this).closest('tr').find('[data-mode="edit"]')[0].dataset
                                    .id; // Ambil ID dari baris yang diperbarui
                                console.log(id);
                                $.ajax({
                                    type: 'PATCH',
                                    url: 'absensi/' + id,
                                    data: {
                                        "_token": "{{ csrf_token() }}",
                                        stok: newValue
                                    },
                                    success: function(response) {
                                        // Tambahkan kode untuk menangani respons jika perlu
                                        console.log('Stok berhasil diperbarui');
                                    },
                                    error: function(xhr, status, error) {
                                        // Tambahkan kode untuk menangani kesalahan jika perlu
                                        console.error(xhr);
                                    }
                                });
                            }
                        });
                    });
                </script>

                <script>
                    $(document).ready(function() {
                        $('#data-absensi').DataTable({
                            "paging": true, // Menampilkan paging
                            "lengthChange": true, // Memungkinkan pengguna mengubah jumlah entri per halaman
                            "searching": true, // Memungkinkan pencarian data
                            "ordering": true, // Mengaktifkan pengurutan
                            "info": true, // Menampilkan informasi halaman dan jumlah data
                            "autoWidth": false, // Menonaktifkan penyesuaian otomatis lebar kolom
                            // Atur kolom tertentu untuk disorot saat menggunakan fitur pencarian
                            "columnDefs": [{
                                "searchable": false,
                                "orderable": false,
                                "targets": 0
                            }]
                        });
                    });
                </script>
            @endpush
