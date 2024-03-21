@extends('templates.layout')

@push('style')
@endpush

@section('content')
@include('kategori.modal')

<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
      <div class="x_title">
        <h1>kategori </h1>
        <!-- <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Settings 1</a>
                            <a class="dropdown-item" href="#">Settings 2</a>
                        </div>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul> -->
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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formInputkategori"><i class="fa fa-plus-square"></i> Tambah kategori</button>

                <button class="btn btn-info" data-toggle="modal" data-target="#formKategori"><i class="fa fa-file-pdf-o"></i> Import</button>
                <a href="{{ route('export-pdf') }}" class="btn btn-primary"><i class="fa fa-file-pdf-o"></i>Export PDF</a>
                <a class="btn btn-success" href="{{route('export-kategori')}}"><i class="fa fa-file-excel-o"></i>Export</a>
              </div>
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Name kategori</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($kategori as $item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $item->nama_kategori }}</td>
                      <td>
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#formInputkategori" data-mode="edit" data-id="{{ $item->id }}" data-nama_kategori="{{ $item->nama_kategori }}">
                          <i class='fa fa-edit'></i> Edit
                        </button>
                        <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" class="d-inline form-delete" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="btn btn-danger delete-data" data-id="{{ $item->id }}" data-nama_kategori="{{ $item->nama_kategori }}">
                            <i class='fa fa-trash'></i> Delete
                          </button>
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
      @include('kategori.data')
      @push('script')
      <script>
        console.log('kategori')
        $('.alert-success').fadeTo(2000, 500).slideUp(500, function() {
          $('.alert-success').slideUp(500)
        })

        $('.delete-data').on('click', function(e) {
          e.preventDefault()
          let nama_kategori = $(this).closest('tr').find('td:eq(1)').text()
          Swal.fire({
            title: `Apakah data ${nama_kategori} akan dihapus ?`,
            text: 'Data tidak bisa dikembalikan!',
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: 'd33',
            confirmButtonText: 'Ya, hapus data ini!'
          }).then((result) => {
            if (result.isConfirmed) {
              $(e.target).closest('form').submit()
            } else {
              swal.close()
            }
          })
        })

        $('#formInputkategori').on('show.bs.modal', function(e) {
          console.log('modal')
          const btn = $(e.relatedTarget)
          const mode = btn.data('mode')
          const nama_kategori = btn.data('nama_kategori')
          const id = btn.data('id')
          const modal = $(this)
          if (mode === 'edit') {
            modal.find('.modal-title').text('Edit kategori')
            modal.find('#nama_kategori').val(nama_kategori)
            modal.find('.modal-body form').attr('action', '{{ url("kategori") }}/' + id)
            modal.find('#method').html('@method("PATCH")')
          } else {
            modal.find('.modal-title').text('Input kategori')
            modal.find('#nama_kategori').val('')
            modal.find('#method').html('')
            modal.find('.modal-body form').attr('action', '{{ url("kategori") }}')
          }
        })
      </script>
      @endpush