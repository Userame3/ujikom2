<div class="modal fade" id="formInputAbsensi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLabel">Tambah Barang</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div id="method"></div>
                    {{-- <div class="form-group row">
                        <label for="kategori_id" class="col-sm-4 col-form-label">Jenis</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="kategori_id" id="kategori_id" required>
                                <option value="">Pilih Jenis</option>
                                @foreach ($kategori as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}

                    <div class="form-group row">
                        <label for="namaKaryawan" class="col-sm-4 col-form-label">Nama Karyawan</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="namaKaryawan" id="namaKaryawan">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tanggalMasuk" class="col-sm-4 col-form-label">Tanggal Masuk</label>
                        <div class="col-sm-8">
                            <input type="date" class="form-control" name="tanggalMasuk" id="tanggalMasuk">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="waktuMasuk" class="col-sm-4 col-form-label">Waktu Masuk</label>
                        <div class="col-sm-8">
                            <input type="time" class="form-control" id="waktuMasuk" name="waktuMasuk"
                                placeholder="Harga Beli" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-sm-4 col-form-label">Status</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="status" id="status" required>
                                <option value="Masuk">Masuk</option>
                                <option value="Sakit">Sakit</option>
                                <option value="Cuti">Cuti</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="waktuKeluar" class="col-sm-4 col-form-label">Waktu Keluar</label>
                        <div class="col-sm-8">
                            <input type="time" class="form-control" name="waktuKeluar" value=""
                                id="waktuKeluar">
                        </div>
                    </div>


            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </form>
        </div>
    </div>
</div>
</div>
