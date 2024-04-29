@extends('templates.layout')

@section('content')
    <div class="transaksi-container">
        <ul class="item content menu-container">
            @foreach ($jenis as $j)
                <li>
                    <h3>{{ $j->nama_jenis }}</h3>
                    <ul class="menu-item" style="cursor: pointer;">
                        @if (isset($j->menu) && count($j->menu) > 0)
                            @foreach ($j->menu as $menu)
                                <li data-barang="menu" data-harga="{{ $menu->harga }}" data-id="{{ $menu->id }}"
                                    data-stok="{{ $menu->stok }}" data-images="{{ $menu->images }}">
                                    <img width="50px" src="{{ asset('storage/menu-images') }}/{{ $menu->images }}"
                                        alt="">
                                    <div>{{ $menu->nama_menu }}</div>
                                    <div>Stok: {{ $menu->stok->jumlah }}</div>
                                </li>
                            @endforeach
                        @endif

                        @if (isset($j->titipan) && count($j->titipan) > 0)
                            @foreach ($j->titipan as $titipan)
                                <li data-barang="produkTitipan" data-harga="{{ $titipan->harga_jual }}"
                                    data-id="{{ $titipan->id }}" data-stok="{{ $titipan->stok }}">
                                    <div>{{ $titipan->nama_produk }}</div>
                                    <div>Stok: {{ $titipan->$stok->stok }}</div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </li>
            @endforeach
        </ul>
        <div class="item sidebar">
            <ul class="ordered-list"></ul>
            <div>
                <p>Total Bayar :</p>
                <h2 id="total"><i class="fa fa-usd"></i> 0,00 </h2>
                <button id="btn-bayar">Bayar</button>
            </div>
            <div>
            </div>
        </div>
        <div class="item footer">Footer</div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // Code initialization saat dokumen telah dimuat
        });

        $(function() {
            const orderedList = [];
            let total = 0;

            function sum() {
                return orderedList.reduce((accumulator, object) => {
                    return accumulator + (object.harga * object.qty);
                }, 0);
            };

            const changeQty = (el, inc) => {
                const data = $(el).closest('li')[0].dataset;
                const id = data.id + data.jenisBarang;
                const index = orderedList.findIndex(list => list.id == id);

                const txt_subtotal = $(el).closest('li').find('.subtotal')[0];
                const txt_qty = $(el).closest('li').find('.qty-item')[0];

                if (orderedList[index].qty == 1 && inc == -1) {
                    txt_qty.value = 1;
                    orderedList[index].qty = 1;
                } else if (orderedList[index].qty == orderedList[index].stok && inc == 1) {
                    // Jika jumlah pesanan sama dengan stok dan ingin menambah satu lagi
                    // Dapat ditambahkan logika khusus di sini
                } else {
                    txt_qty.value = parseInt(txt_qty.value) + inc;
                    orderedList[index].qty += inc;
                }

                txt_subtotal.innerHTML = orderedList[index].harga * orderedList[index].qty;
                $('#total').html(sum());
            };

            $('.ordered-list').on('click', '.btn-dec', function() {
                changeQty(this, -1);
            });

            $('.ordered-list').on('click', '.btn-inc', function() {
                changeQty(this, 1);
            });

            $('.ordered-list').on('click', '.remove-item', function() {
                const item = $(this).closest('li')[0];
                let index = orderedList.findIndex(list => list.id == (item.dataset.id + item.dataset
                    .jenisBarang));
                orderedList.splice(index, 1);
                $(item).remove();
                $('#total').html(sum());
            });

            $('#btn-bayar').on('click', function() {
                $.ajax({
                    url: "{{ route('transaksi.store') }}",
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        orderedList: orderedList,
                        total: sum()
                    },
                    success: function(data) {
                        Swal.fire({
                            title: data.message,
                            showDenyButton: true,
                            confirmButtonText: "Cetak Nota",
                            denyButtonText: `Ok`
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.open(`{{ url('nota') }}/${data.nota}`);
                                location.reload();
                            } else if (result.isDenied) {
                                location.reload();
                            }
                        });
                    },
                    error: function(request, status, error) {
                        console.log(request, status, error);
                        Swal.fire('Pemesanan Gagal!');
                    }
                });
            });

            $(".menu-item li").click(function() {
                const data = $(this)[0].dataset;
                const jenisBarang = data.barang;
                const menu_clicked = $(this).text();
                const harga = parseFloat(data.harga);
                const stok = parseFloat(data.stok);
                const id = parseInt(data.id);

                if (stok == 0) {
                    return;
                }

                if (orderedList.every(list => list.id !== id + jenisBarang)) {
                    let dataN = {
                        'id': id + jenisBarang,
                        'barang_id': id,
                        'barang': jenisBarang,
                        "menu": menu_clicked,
                        'harga': harga,
                        'stok': stok,
                        "qty": 1
                    };
                    orderedList.push(dataN);

                    let listOrder =
                        `<li data-jenis-barang="${jenisBarang}" data-id="${id}" data-stok="${stok}"> <h3>${menu_clicked}</h3>`;
                    listOrder += `<button class="btn-dec"> - </button>`;
                    listOrder +=
                        `<input class="qty-item" type="number" value="1" style="width: 3rem;" readonly/>`;
                    listOrder += `<button class="btn-inc">+</button><br>`;
                    listOrder += `<button class="remove-item">Hapus</button>`;
                    listOrder += `<span class="subtotal">${harga * 1}</span>`;
                    listOrder += `</li>`;
                    $(".ordered-list").append(listOrder);
                }

                $("#total").html(sum());
            });

        });
    </script>
@endpush
