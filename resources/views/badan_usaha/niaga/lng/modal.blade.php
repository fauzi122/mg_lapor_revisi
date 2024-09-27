<!-- input simpan_penjualan lng -->
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Penjualan LNG/CNG</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/simpan_lng" class="form-material m-t-40" enctype="multipart/form-data"
                id="form_penjualan">
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="hidden" id="" name="badan_usaha_id"
                            value="{{ Auth::user()->badan_usaha_id }}">
                        <input class="form-control" type="month" id="bulanx" name="bulan"
                            value="{{ old('bulan') }}">
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Provinsi</label>
                        <select class="form-select provinsi name_provinsi" name="provinsi" id="name_provinsi">
                            <option>Pilih Provinsi</option>
                        </select>
                        @error('provinsi')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Kabupaten / Kota</label>
                        <select class="form-select nama_kota" name="kabupaten_kota" id="nama_kota">
                            <option>Pilih Kota</option>
                        </select>
                        @error('kabupaten_kota')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <select class="form-select produk name_produk" name="produk" id="name_produk">
                            <option>Pilih Produk</option>
                        </select>
                        @error('produk')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Satuan</label>
                        <select class="form-select produk satuan" name="satuan" id="satuan">
                            <option>Pilih Satuan</option>
                        </select>

                        <input class="form-control" type="hidden" id="example-text-input" name="status"
                            value="-">
                        <input class="form-control" type="hidden" id="example-text-input" name="catatan"
                            value="-">
                        <input class="form-control" type="hidden" id="example-text-input" name="petugas"
                            value="jjp">
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Konsumen</label>
                        <input class="form-control" type="text" id="example-text-input" name="konsumen"
                            value="{{ old('konsumen') }}">
                        @error('konsumen')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Sektor</label>
                        <select class="form-select nama_sektor" name="sektor" id="">
                            <option>Pilih Kota</option>
                        </select>
                        @error('sektor')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume</label>
                        <input class="form-control" type="number" id="example-text-input" name="volume"
                            value="{{ old('volume') }}">
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Biaya Kompresi</label>
                        <input class="form-control" type="number" id="example-text-input" name="biaya_kompresi"
                            value="{{ old('biaya_kompresi') }}">
                        @error('biaya_kompresi')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Biaya Penyimpanan</label>
                        <input class="form-control" type="number" id="example-text-input" name="biaya_penyimpanan"
                            value="{{ old('biaya_penyimpanan') }}">
                        @error('biaya_penyimpanan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Biaya Pengangkutan</label>
                        <input class="form-control" type="number" id="example-text-input" name="biaya_pengangkutan"
                            value="{{ old('biaya_pengangkutan') }}">
                        @error('biaya_pengangkutan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Biaya Niaga</label>
                        <input class="form-control" type="number" id="example-text-input" name="biaya_niaga"
                            value="{{ old('biaya_niaga') }}">
                        @error('biaya_niaga')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Harga Jual</label>
                        <input class="form-control" type="number" id="example-text-input" name="harga_jual"
                            value="{{ old('harga_jual') }}">
                        @error('harga_jual')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>




                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- edit simpan_penjualan lng -->
<div id="modal-edit" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Penjualan LNG/CNG</h5>
                <input class="form-control" type="hidden" id="example-text-input" name="badan_usaha_id"
                    value="{{ Auth::user()->badan_usaha_id }}">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_lng" class="form-material m-t-40" enctype="multipart/form-data"
                id="form_lng">
                @method('PUT')
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="month" name="bulan" id="bulan_penjualan" readonly>
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Provinsi</label>
                        <select class="form-select provinsi name_provinsi" name="provinsi" id="provinsi_penjualan">
                            <option>Pilih Provinsi</option>
                        </select>
                        @error('provinsi')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Kabupaten / Kota</label>
                        <select class="form-select nama_kota" name="kabupaten_kota" id="kab_penjualan">
                            <option>Pilih Kota</option>
                        </select>
                        @error('kabupaten_kota')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <select class="form-select produk name_produk" name="produk" id="produk_penjualan">
                            <option>Pilih Produk</option>
                        </select>
                        @error('produk')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Satuan</label>
                        <select class="form-select produk satuan" name="satuan" id="satuan_penjualan">
                            <option>Pilih Satuan</option>
                        </select>
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Konsumen</label>
                        <input class="form-control" type="text" id="konsumen_penjualan" name="konsumen">
                        @error('konsumen')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Sektor</label>
                        <select class="form-select nama_sektor" name="sektor" id="sektor_penjualan">
                            <option>Pilih Sektor</option>
                        </select>
                        @error('sektor')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume</label>
                        <input class="form-control" type="number" id="volume_penjualan" name="volume">
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Biaya Kompresi</label>
                        <input class="form-control" type="number" id="biaya_kompresi_penjualan"
                            name="biaya_kompresi" value="{{ old('biaya_kompresi') }}">
                        @error('biaya_kompresi')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Biaya Penyimpanan</label>
                        <input class="form-control" type="number" id="biaya_penyimpanan_penjualan"
                            name="biaya_penyimpanan" value="{{ old('biaya_penyimpanan') }}">
                        @error('biaya_penyimpanan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Biaya Pengangkutan</label>
                        <input class="form-control" type="number" id="biaya_pengangkutan_penjualan"
                            name="biaya_pengangkutan" value="{{ old('biaya_pengangkutan') }}">
                        @error('biaya_pengangkutan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Biaya Niaga</label>
                        <input class="form-control" type="number" id="biaya_niaga_penjualan" name="biaya_niaga"
                            value="{{ old('biaya_niaga') }}">
                        @error('biaya_niaga')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Harga Jual</label>
                        <input class="form-control" type="number" id="harga_jual_penjualan" name="harga_jual"
                            value="{{ old('harga_jual') }}">
                        @error('harga_jual')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- lihat simpan_penjualan lng -->
<div id="lihat-lng" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Lihat Penjualan LNG/CNG</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_lng" class="form-material m-t-40" enctype="multipart/form-data"
                id="form_lng">
                @method('PUT')
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="month" name="bulan" id="lihat_bulan_penjualan"
                            readonly>
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Provinsi</label>
                        <input class="form-control" type="text" name="provinsi" id="lihat_provinsi_penjualan"
                            readonly>
                        @error('provinsi')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Kabupaten / Kota</label>
                        <input class="form-control" type="text" name="kabupaten_kota" id="lihat_kab_penjualan"
                            readonly>
                        @error('kabupaten_kota')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <input class="form-control" type="text" name="produk" id="lihat_produk_penjualan"
                            readonly>
                        @error('produk')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Satuan</label>
                        <input class="form-control" type="text" name="satuan" id="lihat_satuan_penjualan"
                            readonly>
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Konsumen</label>
                        <input class="form-control" type="text" id="lihat_konsumen_penjualan" name="konsumen"
                            readonly>
                        @error('konsumen')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Sektor</label>
                        <input class="form-control" type="text" id="lihat_sektor_penjualan" name="sektor"
                            readonly>
                        @error('sektor')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume</label>
                        <input class="form-control" type="text" id="lihat_volume_penjualan" name="volume"
                            readonly>
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Biaya Kompresi</label>
                        <input class="form-control" type="text" id="lihat_biaya_kompresi_penjualan"
                            name="biaya_kompresi" value="{{ old('biaya_kompresi') }}" readonly>
                        @error('biaya_kompresi')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Biaya Penyimpanan</label>
                        <input class="form-control" type="text" id="lihat_biaya_penyimpanan_penjualan"
                            name="biaya_penyimpanan" value="{{ old('biaya_penyimpanan') }}" readonly>
                        @error('biaya_penyimpanan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Biaya Pengangkutan</label>
                        <input class="form-control" type="text" id="lihat_biaya_pengangkutan_penjualan"
                            name="biaya_pengangkutan" value="{{ old('biaya_pengangkutan') }}" readonly>
                        @error('biaya_pengangkutan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Biaya Niaga</label>
                        <input class="form-control" type="text" id="lihat_biaya_niaga_penjualan"
                            name="biaya_niaga" value="{{ old('biaya_niaga') }}" readonly>
                        @error('biaya_niaga')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Harga Jual</label>
                        <input class="form-control" type="text" id="lihat_harga_jual_penjualan" name="harga_jual"
                            value="{{ old('harga_jual') }}" readonly>
                        @error('harga_jual')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Close</button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- input simpan_pasokan lng -->
<div id="pasokan_lng" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Pasokan LNG/CNG</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/simpan_pasokan_lng" class="form-material m-t-40"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="hidden" id="" name="badan_usaha_id"
                            value="{{ Auth::user()->badan_usaha_id }}">
                        <input class="form-control" type="month" id="bulanxx" name="bulan"
                            value="{{ old('bulan') }}">
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <select class="form-select produk name_produk" name="produk" value="{{ old('produk') }}">
                            <option>Pilih Produk</option>
                        </select>
                        @error('produk')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Satuan</label>
                        <select class="form-select produk satuan" name="satuan" value="{{ old('satuan') }}">
                            <option>Pilih Satuan</option>
                        </select>
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Nama Pemasok</label>
                        <input class="form-control" type="text" id="example-text-input" name="nama_pemasok"
                            value="{{ old('nama_pemasok') }}">
                        @error('nama_pemasok')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Kategori Pemasok</label>
                        <select class="form-select" name="kategori_pemasok">
                            <option>Pilih Kategori</option>
                            <option value="Kilang">Kilang</option>
                            <option value="BU Niaga">BU Niaga</option>
                            <option value="Impor">Impor</option>
                            <option value="KKKS">KKKS</option>
                        </select>
                        @error('kategori_pemasok')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume</label>
                        <input class="form-control" type="number" id="example-text-input" name="volume"
                            value="{{ old('volume') }}">
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Harga Gas</label>
                        <input class="form-control" type="number" id="example-text-input" name="harga_gas"
                            value="{{ old('harga_gas') }}">
                        @error('harga_gas')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- edit simpan_pasokan lng -->
<div id="modal-edit-pasok" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Pasokan LNG/CNG</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_pasok_lng" class="form-material m-t-40"
                enctype="multipart/form-data" id="form_pasok">
                @method('PUT')
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="hidden" id="example-text-input" name="badan_usaha_id"
                            value="{{ Auth::user()->badan_usaha_id }}">
                        <input class="form-control" type="month" id="bulan_pasok" name="bulan" readonly>
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <select class="form-select" id="produk_pasok" name="produk">
                            <option>Pilih Produk</option>
                            <option value="nilai1">Nilai 1</option>
                        </select>
                        @error('produk')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Satuan</label>
                        <select class="form-select produk satuan" id="satuan_pasok" name="satuan"
                            value="{{ old('satuan') }}">
                            <option>Pilih Satuan</option>
                        </select>
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Nama Pemasok</label>
                        <input class="form-control" type="text" id="nama_pemasok_pasok" name="nama_pemasok"
                            value="{{ old('nama_pemasok') }}">
                        @error('nama_pemasok')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Kategori Pemasok</label>
                        <select class="form-select" name="kategori_pemasok" id="kategori_pemasok_pasok">
                            <option>Pilih Kategori</option>
                            <option value="Kilang">Kilang</option>
                            <option value="BU Niaga">BU Niaga</option>
                            <option value="Impor">Impor</option>
                            <option value="KKKS">KKKS</option>
                        </select>
                        @error('kategori_pemasok')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume</label>
                        <input class="form-control" type="number" id="volume_pasok" name="volume"
                            value="{{ old('volume') }}">
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Harga Gas</label>
                        <input class="form-control" type="number" id="harga_gas_pasok" name="harga_gas"
                            value="{{ old('harga_gas') }}">
                        @error('harga_gas')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- lihat simpan_pasokan lng -->
<div id="lihat-pasok-lng" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Lihat Pasokan LNG/CNG</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_pasok_lng" class="form-material m-t-40"
                enctype="multipart/form-data" id="form_pasok">
                @method('PUT')
                @csrf
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="month" id="lihat_bulan_pasok" name="bulan" readonly>
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <input class="form-control" type="text" id="lihat_produk_pasok" name="produk" readonly>
                        @error('produk')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Satuan</label>
                        <input class="form-control" type="text" id="lihat_satuan_pasok" name="satuan" readonly>
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Nama Pemasok</label>
                        <input class="form-control" type="text" id="lihat_nama_pemasok_pasok" name="nama_pemasok"
                            value="{{ old('nama_pemasok') }}" readonly>
                        @error('nama_pemasok')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Kategori Pemasok</label>
                        <input class="form-control" type="text" id="lihat_kategori_pemasok_pasok"
                            name="kategori_pemasok" value="{{ old('kategori_pemasok') }}" readonly>

                        @error('kategori_pemasok')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume</label>
                        <input class="form-control" type="text" id="lihat_volume_pasok" name="volume"
                            value="{{ old('volume') }}" readonly>
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Harga Gas</label>
                        <input class="form-control" type="text" id="lihat_harga_gas_pasok" name="harga_gas"
                            value="{{ old('harga_gas') }}" readonly>
                        @error('harga_gas')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Close</button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- import simpan_lng_penjualan -->
<div id="excellng" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Penjualan LNG/CNG/BBG</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/importlngpen" class="form-material m-t-40" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input class="form-control" type="month" name="bulan" id="bulan_import">
                        <br>

                        <input type="file" name="file" required="required">

                        @error('badan_usaha_id')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>


                </div>
                <div class="modal-footer">
                    <a href="https://lapor.duniasakha.com/storage/template/niagaLNG_Penjualan.xlsx" id="tombol"
                        class="btn btn-success waves-effect waves-light">Download Template</a>
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- import simpan_lng_pasok -->
<div id="excellng_pasok" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Pasokan LNG/CNG/BBG</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/importlngpasok" class="form-material m-t-40"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input class="form-control" type="month" name="bulan" id="bulan_importx">
                        <br>

                        <input type="file" name="file" required="required">

                        @error('badan_usaha_id')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>


                </div>
                <div class="modal-footer">
                    <a href="https://lapor.duniasakha.com/storage/template/niagaLNG_Pasokan.xlsx" id="tombol"
                        class="btn btn-success waves-effect waves-light">Download Template</a>
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
