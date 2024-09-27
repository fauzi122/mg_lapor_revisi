<!-- input simpan_Penyimpanan Minyak Bumi -->
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Penyimpanan Minyak Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/simpan_pmb" class="form-material m-t-40" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">

                        <input class="form-control" type="hidden" id="example-text-input" name="badan_usaha_id"
                            value="{{ Auth::user()->badan_usaha_id }}">
                        <input class="form-control" type="hidden" id="example-text-input" name="izin_id"
                            value="1">
                        @error('badan_usaha_id')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Bulan </label>
                        <input class="form-control" type="month" id="bulanx" name="bulan">
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Jenis Fasilitas</label>
                        <select class="form-select" name="jenis_fasilitas" id="">
                            <option>Pilih Jenis Fasilitas</option>
                            <option value="Darat">Darat</option>
                            <option value="Floating Storage">Floating Storage</option>
                        </select>
                        @error('jenis_fasilitas')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">No Tangki</label>
                        <input class="form-control" type="text" id="" name="no_tangki"
                            value="{{ old('no_tangki') }}">
                        @error('no_tangki')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Jenis Komoditas</label>
                        <div class="col-lg-12 d-flex flex-wrap gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="minyak_bumi"
                                    name="jenis_komoditas[]" value="Minyak Bumi">
                                <label class="form-check-label" for="minyak_bumi">
                                    Minyak Bumi
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="bbm" name="jenis_komoditas[]"
                                    value="BBM">
                                <label class="form-check-label" for="bbm">
                                    BBM
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="hasil_olahan"
                                    name="jenis_komoditas[]" value="Hasil Olahan">
                                <label class="form-check-label" for="hasil_olahan">
                                    Hasil Olahan
                                </label>
                            </div>
                        </div>
                        <!-- <input class="form-control" type="text" id="example-text-input" name="jenis_komoditas"
                            value="{{ old('jenis_komoditas') }}"> -->
                        @error('jenis_komoditas')
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
                        <label for="example-text-input" class="form-label">Kabupaten Kota</label>
                        <select class="form-select nama_kota" name="kab_kota" id="nama_kota">
                            <option>Pilih Kab / Kota</option>
                        </select>
                        @error('kab_kota')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Kategori Supplai</label>
                        <select class="form-select" name="kategori_supplai" id="">
                            <option>Pilih Kategori Supplai</option>
                            <option value="Domestik">Domestik</option>
                            <option value="Impor">Impor</option>
                        </select>
                        @error('kategori_supplai')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume Stok Awal</label>
                        <input class="form-control" type="number" id="" name="volume_stok_awal">
                        @error('volume_stok_awal')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume Supply</label>
                        <input class="form-control" type="number" id="" name="volume_supply">
                        @error('volume_supply')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume Output</label>
                        <input class="form-control" type="number" id="" name="volume_output">
                        @error('volume_output')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume Stok Akhir</label>
                        <input class="form-control" type="number" id="" name="volume_stok_akhir">
                        @error('volume_stok_akhir')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Utilasi Tangki</label>
                        <input class="form-control" type="text" id="" name="utilasi_tangki">
                        @error('utilasi_tangki')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Pengguna</label>
                        <input class="form-control" type="text" id="" name="pengguna">
                        @error('pengguna')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Jangka Waktu Penggunaan</label>
                        <input class="form-control" type="date" id="" name="jangka_waktu_penggunaan">
                        @error('jangka_waktu_penggunaan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Tarif Penyimpanan</label>
                        <input class="form-control" type="text" id="" name="tarif_penyimpanan">
                        @error('tarif_penyimpanan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Satuan Tarif</label>
                        <select class="form-select" name="satuan_tarif" id="">
                            <option>Pilih Satuan Tarif</option>
                            <option value="USD">USD</option>
                            <option value="IDR">IDR</option>
                        </select>
                        @error('satuan_tarif')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">keterangan</label>
                        <input class="form-control" type="text" id="" name="keterangan">
                        @error('keterangan')
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


<!-- edit simpan_Penyimpanan Minyak Bumi -->
<div id="edit-pmb" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Penyimpanan Minyak Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_pmb" class="form-material m-t-40" enctype="multipart/form-data"
                id="form_pmb">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="mb-3">

                        <input class="form-control" type="hidden" id="example-text-input" name="badan_usaha_id"
                            value="1">
                        <input class="form-control" type="hidden" id="example-text-input" name="izin_id"
                            value="1">
                        @error('badan_usaha_id')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="month" id="bulan_pmb" name="bulan"
                            value="{{ old('bulan') }}" readonly>
                        @error('bulan_peb')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Jenis Fasilitas</label>
                        {{-- <input class="form-control" type="text" id="jenis_fasilitas_pmb" name="jenis_fasilitas"
                            value="{{ old('jenis_fasilitas') }}"> --}}
                        <select class="form-select" name="jenis_fasilitas" id="jenis_fasilitas_pmb">
                            <option>Pilih Jenis Fasilitas</option>
                            <option value="Darat">Darat</option>
                            <option value="Floating Storage">Floating Storage</option>
                        </select>
                        @error('jenis_fasilitas')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">No Tangki</label>
                        <input class="form-control" type="text" id="no_tangki_pmb" name="no_tangki"
                            value="{{ old('no_tangki') }}">
                        @error('no_tangki')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Jenis Komoditas</label>
                        <div class="col-lg-12 d-flex flex-wrap gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit_minyak_bumi"
                                    name="jenis_komoditas[]" value="Minyak Bumi">
                                <label class="form-check-label" for="edit_minyak_bumi">
                                    Minyak Bumi
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit_bbm"
                                    name="jenis_komoditas[]" value="BBM">
                                <label class="form-check-label" for="edit_bbm">
                                    BBM
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit_hasil_olahan"
                                    name="jenis_komoditas[]" value="Hasil Olahan">
                                <label class="form-check-label" for="edit_hasil_olahan">
                                    Hasil Olahan
                                </label>
                            </div>
                        </div>
                        @error('jenis_komoditas')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <select class="form-select produk name_produk" name="produk" id="produk_pmb">
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
                        <select class="form-select produk satuan" name="satuan" id="satuan_pmb">
                            <option>Pilih Satuan</option>
                        </select>
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Provinsi</label>
                        <select class="form-select provinsi name_provinsi" name="provinsi" id="provinsi_pmb">
                            <option>Pilih Provinsi</option>
                        </select>
                        @error('provinsi')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Kabupaten Kota</label>
                        <select class="form-select kab_kota nama_kota" name="kab_kota" id="kab_kota_pmb">
                            <option>Pilih Kab / Kota</option>
                        </select>
                        @error('kab_kota')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Kategori Supplai</label>
                        {{-- <input class="form-control" type="text" id="kategori_supplai_pmb"
                            name="kategori_supplai"> --}}
                        <select class="form-select" name="kategori_supplai" id="kategori_supplai_pmb">
                            <option>Pilih Kategori Supplai</option>
                            <option value="Domestik">Domestik</option>
                            <option value="Impor">Impor</option>
                        </select>
                        @error('kategori_supplai')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume Stok Awal</label>
                        <input class="form-control" type="text" id="volume_stok_awal_pmb"
                            name="volume_stok_awal">
                        @error('volume_stok_awal')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume Supply</label>
                        <input class="form-control" type="text" id="volume_supply_pmb" name="volume_supply">
                        @error('volume_supply')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume Output</label>
                        <input class="form-control" type="text" id="volume_output_pmb" name="volume_output">
                        @error('volume_output')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume Stok Akhir</label>
                        <input class="form-control" type="text" id="volume_stok_akhir_pmb"
                            name="volume_stok_akhir">
                        @error('volume_stok_akhir')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Utilasi Tangki</label>
                        <input class="form-control" type="text" id="utilasi_tangki_pmb" name="utilasi_tangki">
                        @error('utilasi_tangki')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Pengguna</label>
                        <input class="form-control" type="text" id="pengguna_pmb" name="pengguna">
                        @error('pengguna')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Jangka Waktu Penggunaan</label>
                        <input class="form-control" type="date" id="jangka_waktu_penggunaan_pmb"
                            name="jangka_waktu_penggunaan">
                        @error('jangka_waktu_penggunaan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Tarif Penyimpanan</label>
                        <input class="form-control" type="text" id="tarif_penyimpanan_pmb"
                            name="tarif_penyimpanan">
                        @error('tarif_penyimpanan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Satuan Tarif</label>
                        {{-- <input class="form-control" type="text" id="satuan_tarif_pmb" name="satuan_tarif"> --}}
                        <select class="form-select" name="satuan_tarif" id="satuan_tarif_pmb">
                            <option>Pilih Satuan Tarif</option>
                            <option value="USD">USD</option>
                            <option value="IDR">IDR</option>
                        </select>
                        @error('satuan_tarif')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">keterangan</label>
                        <input class="form-control" type="text" id="keterangan_pmb" name="keterangan">
                        <input class="form-control" type="hidden" id="example-text-input" name="status"
                            value="0">
                        @error('keterangan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- lihat pmb -->
<div id="lihat-pmb" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Lihat Penyimpanan Minyak Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_pmb" class="form-material m-t-40" enctype="multipart/form-data"
                id="form_pmb">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="mb-3">

                        <input class="form-control" type="hidden" id="example-text-input" name="badan_usaha_id"
                            value="1">
                        <input class="form-control" type="hidden" id="example-text-input" name="izin_id"
                            value="1">
                        @error('badan_usaha_id')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="month" id="bulan_pmb_lihat" name="bulan"
                            value="{{ old('bulan') }}" readonly>
                        @error('bulan_peb')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Jenis Fasilitas</label>
                        <input class="form-control" type="text" id="jenis_fasilitas_pmb_lihat"
                            name="jenis_fasilitas" value="{{ old('jenis_fasilitas') }}" readonly>
                        @error('jenis_fasilitas')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">No Tangki</label>
                        <input class="form-control" type="text" id="no_tangki_pmb_lihat" name="no_tangki"
                            value="{{ old('no_tangki') }}" readonly>
                        @error('no_tangki')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Jenis Komoditas</label>
                        <div class="col-lg-12 d-flex flex-wrap gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="lihat_minyak_bumi"
                                    name="jenis_komoditas[]" value="Minyak Bumi" disabled>
                                <label class="form-check-label" for="lihat_minyak_bumi">
                                    Minyak Bumi
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="lihat_bbm"
                                    name="jenis_komoditas[]" value="BBM" disabled>
                                <label class="form-check-label" for="lihat_bbm">
                                    BBM
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="lihat_hasil_olahan"
                                    name="jenis_komoditas[]" value="Hasil Olahan" disabled>
                                <label class="form-check-label" for="lihat_hasil_olahan">
                                    Hasil Olahan
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <input class="form-control" type="text" id="produk_pmb_lihat" name="produk"
                            value="{{ old('produk') }}" readonly>
                        @error('produk')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Satuan</label>
                        <input class="form-control" type="text" id="satuan_pmb_lihat" name="satuan"
                            value="{{ old('satuan') }}" readonly>
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Provinsi</label>
                        <input class="form-control" type="text" id="provinsi_pmb_lihat" name="provinisi"
                            readonly>
                        @error('provinisi')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Kabupaten Kota</label>
                        <input class="form-control" type="text" id="kab_kota_pmb_lihat" name="kab_kota" readonly>
                        @error('kab_kota')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Kategori Supplai</label>
                        <input class="form-control" type="text" id="kategori_supplai_pmb_lihat"
                            name="kategori_supplai" readonly>
                        @error('kategori_supplai')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume Stok Awal</label>
                        <input class="form-control" type="text" id="volume_stok_awal_pmb_lihat"
                            name="volume_stok_awal" readonly>
                        @error('volume_stok_awal')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume Supply</label>
                        <input class="form-control" type="text" id="volume_supply_pmb_lihat" name="volume_supply"
                            readonly>
                        @error('volume_supply')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume Output</label>
                        <input class="form-control" type="text" id="volume_output_pmb_lihat" name="volume_output"
                            readonly>
                        @error('volume_output')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume Stok Akhir</label>
                        <input class="form-control" type="text" id="volume_stok_akhir_pmb_lihat"
                            name="volume_stok_akhir" readonly>
                        @error('volume_stok_akhir')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Utilasi Tangki</label>
                        <input class="form-control" type="text" id="utilasi_tangki_pmb_lihat"
                            name="utilasi_tangki" readonly>
                        @error('utilasi_tangki')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Pengguna</label>
                        <input class="form-control" type="text" id="pengguna_pmb_lihat" name="pengguna" readonly>
                        @error('pengguna')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Jangka Waktu Penggunaan</label>
                        <input class="form-control" type="date" id="jangka_waktu_penggunaan_pmb_lihat"
                            name="jangka_waktu_penggunaan" readonly>
                        @error('jangka_waktu_penggunaan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Tarif Penyimpanan</label>
                        <input class="form-control" type="text" id="tarif_penyimpanan_pmb_lihat"
                            name="tarif_penyimpanan" readonly>
                        @error('tarif_penyimpanan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Satuan Tarif</label>
                        <input class="form-control" type="text" id="satuan_tarif_pmb_lihat" name="satuan_tarif"
                            readonly>
                        @error('satuan_tarif')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">keterangan</label>
                        <input class="form-control" type="text" id="keterangan_pmb_lihat" name="keterangan"
                            readonly>
                        <input class="form-control" type="hidden" id="example-text-input" name="status"
                            value="0">
                        @error('keterangan')
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


<!-- import simpan_pmb -->
<div id="excelpmb" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Penyimpanan Minyak Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/import_pmb" class="form-material m-t-40" enctype="multipart/form-data">
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
                    <a href="https://lapor.duniasakha.com/storage/template/penyimpananMinyakBumi.xlsx" id="tombol"
                        class="btn btn-success waves-effect waves-light">Download Template</a>
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
