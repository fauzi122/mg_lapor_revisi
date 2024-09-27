<!-- input Pengolahan Minyak Bumi [Produksi Kilang] -->
<div id="buat-pengolahan-produksi-mb" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Tambah Pengolahan Minyak Bumi [Produksi Kilang]</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/simpan_pengolahan_minyak_bumi_produksi" class="form-material m-t-40"
                enctype="multipart/form-data">
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
                        <input class="form-control" type="date" id="example-text-input" name="bulan"
                            value="{{ old('bulan') }}" required>
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <select class="form-select produk name_produk" name="produk" id="name_produk" required>
                            <option value="">Pilih Produk</option>
                        </select>
                        @error('produk')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Satuan</label>
                        <select class="form-select produk satuan" name="satuan" id="satuan" required>
                            <option value="">Pilih Satuan</option>
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
                        <label for="example-text-input" class="form-label">Provinsi</label>
                        <select class="form-select provinsi name_provinsi" name="provinsi" id="name_provinsi" required>
                            <option value="">Pilih Provinsi</option>
                        </select>
                        @error('provinsi')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Kabupaten / Kota</label>
                        <select class="form-select nama_kota" name="kabupaten_kota" id="nama_kota" required>
                            <option value="">Pilih Kabupaten / Kota</option>
                        </select>
                        @error('kabupaten_kota')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume</label>
                        <input class="form-control" type="text" id="example-text-input" name="volume"
                            value="{{ old('volume') }}" required>
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Keterangan</label>
                        <input class="form-control" type="text" id="example-text-input" name="keterangan"
                            value="{{ old('keterangan') }}" required>
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

<!-- edit Pengolahan Minyak Bumi [Produksi Kilang] -->
<div id="edit-pengolahan-produksi-mb" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
    aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Pengolahan Minyak Bumi [Produksi Kilang]</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_pengolahan_minyak_bumi_produksi" class="form-material m-t-40"
                enctype="multipart/form-data" id="form_updatePengolahanProduksiMB">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input class="form-control" type="hidden" id="badan_usaha_id" name="badan_usaha_id"
                            value="">
                        <input class="form-control" type="hidden" id="izin_id" name="izin_id" value="">
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="date" id="bulan_produksi" name="bulan"
                            value="{{ old('bulan') }}" required>
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <select class="form-select produk name_produk" name="produk" id="produk_pengolahanProduksi">
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
                        <select class="form-select produk satuan" name="satuan" id="satuan_pengolahanProduksi"
                            required>
                            <option value="">Pilih Satuan</option>
                        </select>

                        <input class="form-control" type="hidden" id="status_pengolahanProduksiMB" name="status"
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
                        <label for="example-text-input" class="form-label">Provinsi</label>
                        <select class="form-select provinsi name_provinsi" name="provinsi" id="provinsi_produksi">
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
                        <select class="form-select nama_kota" name="kabupaten_kota" id="nama_kota_pengolahaProduksi"
                            required>
                            <option value="">Pilih Kabupaten / Kota</option>
                        </select>
                        @error('kabupaten_kota')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume</label>
                        <input class="form-control" type="text" id="volume_pengolahanProduksi" name="volume">
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Keterangan</label>
                        <input class="form-control" type="text" id="keterangan_pengolahanProduksi"
                            name="keterangan">
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

<!-- lihat Pengolahan Minyak Bumi [Produksi Kilang] -->
<div id="lihat-pengolahan-produksi-mb" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
    aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Lihat Pengolahan Minyak Bumi [Produksi Kilang]</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input class="form-control" type="hidden" id="lihat_badan_usaha_id" name="badan_usaha_id"
                        value="">
                    <input class="form-control" type="hidden" id="lihat_izin_id" name="izin_id" value="">
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control" type="date" id="lihat_bulan_produksi" name="bulan"
                        value="{{ old('bulan') }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Produk</label>
                    <input class="form-control" type="text" id="lihat_produk_pengolahanProduksi" name="produk"
                        value="" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Satuan</label>
                    <input class="form-control" type="text" id="lihat_satuan_pengolahanProduksi" name="satuan"
                        value="" readonly>

                    <input class="form-control" type="hidden" id="example-text-input" name="status"
                        value="-">
                    <input class="form-control" type="hidden" id="example-text-input" name="catatan"
                        value="-">
                    <input class="form-control" type="hidden" id="example-text-input" name="petugas"
                        value="jjp">
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Provinsi</label>
                    <input class="form-control" type="text" id="lihat_provinsi_produksi" name="provinsi"
                        value="" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Kabupaten / Kota</label>
                    <input class="form-control" type="text" id="lihat_nama_kota_pengolahaProduksi"
                        name="kabupaten_kota" value="" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Volume</label>
                    <input class="form-control" type="text" id="lihat_volume_pengolahanProduksi" name="volume"
                        readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Keterangan</label>
                    <input class="form-control" type="text" id="lihat_keterangan_pengolahanProduksi"
                        name="keterangan" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- input Pengolahan Minyak Bumi [Pasokan Kilang] -->
<div id="buat-pengolahan-pasokan-mb" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
    aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Tambah Pengolahan Minyak Bumi [Pasokan Kilang]</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/simpan_pengolahan_minyak_bumi_pasokan" class="form-material m-t-40"
                enctype="multipart/form-data">
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
                        <input class="form-control" type="date" id="example-text-input" name="bulan"
                            value="{{ old('bulan') }}" required>
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Kategori Pemasok</label>
                        <select class="form-select" name="kategori_pemasok" required>
                            <option value="">Pilih Kategori Pemasok</option>
                            <option value="Domestik">Domestik</option>
                            <option value="Impor">Impor</option>
                        </select>
                        @error('kategori_pemasok')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Intake Kilang</label>
                        <select class="form-select intake_kilang" name="intake_kilang" required>
                            <option value="">Pilih Intake Kilang</option>
                        </select>
                        @error('intake_kilang')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Satuan</label>
                        <select class="form-select produk satuan" name="satuan" id="satuan" required>
                            <option value="">Pilih Satuan</option>
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
                        <label for="example-text-input" class="form-label">Provinsi</label>
                        <select class="form-select provinsi name_provinsi" name="provinsi" id="name_provinsi"
                            required>
                            <option value="">Pilih Provinsi</option>
                        </select>
                        @error('provinsi')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Kabupaten / Kota</label>
                        <select class="form-select nama_kota" name="kabupaten_kota" id="nama_kota" required>
                            <option value="">Pilih Kabupaten / Kota</option>
                        </select>
                        @error('kabupaten_kota')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume</label>
                        <input class="form-control" type="text" id="example-text-input" name="volume"
                            value="{{ old('volume') }}" required>
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Keterangan</label>
                        <input class="form-control" type="text" id="example-text-input" name="keterangan"
                            value="{{ old('keterangan') }}" required>
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

<!-- edit Pengolahan Minyak Bumi [Produksi Kilang] -->
<div id="edit-pengolahan-pasokan-mb" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
    aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Pengolahan Minyak Bumi [Pasokan Kilang]</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_pengolahan_minyak_bumi_pasokan" class="form-material m-t-40"
                enctype="multipart/form-data" id="form_updatePengolahanPasokanMB">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input class="form-control" type="hidden" id="badan_usaha_id_pasokan" name="badan_usaha_id"
                            value="">
                        <input class="form-control" type="hidden" id="izin_id_pasokan" name="izin_id" value="">
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="date" id="bulan_pasokan" name="bulan"
                            value="{{ old('bulan') }}" required>
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Kategori Pemasok</label>
                        <select class="form-select" name="kategori_pemasok" id="kategori_pemasokPasokan">
                          <option value="">Pilih Kategori Pemasok</option>
                          <option value="Domestik">Domestik</option>
                          <option value="Impor">Impor</option>
                        </select>
                        @error('kategori_pemasok')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Intake Kilang</label>
                        <select class="form-select intake_kilang" name="intake_kilang" id="intake_kilangPasokan">
                            <option>Pilih Intake Kilang</option>
                        </select>
                        @error('intake_kilang')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Satuan</label>
                        <select class="form-select produk satuan" name="satuan" id="satuan_pengolahanPasokan"
                            required>
                            <option value="">Pilih Satuan</option>
                        </select>

                        <input class="form-control" type="hidden" id="status_pengolahanPasokanMB" name="status"
                            value="-">
                        <input class="form-control" type="hidden" id="catatan_pasokan" name="catatan"
                            value="-">
                        <input class="form-control" type="hidden" id="petugas_pasokan" name="petugas"
                            value="jjp">
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Provinsi</label>
                        <select class="form-select provinsi name_provinsi" name="provinsi" id="provinsi_pasokan">
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
                        <select class="form-select nama_kota" name="kabupaten_kota" id="nama_kota_pengolahaPasokan"
                            required>
                            <option value="">Pilih Kabupaten / Kota</option>
                        </select>
                        @error('kabupaten_kota')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume</label>
                        <input class="form-control" type="text" id="volume_pengolahanPasokan" name="volume">
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Keterangan</label>
                        <input class="form-control" type="text" id="keterangan_pengolahanPasokan"
                            name="keterangan">
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

<!-- lihat Pengolahan Minyak Bumi [Produksi Kilang] -->
<div id="lihat-pengolahan-pasokan-mb" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
    aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Lihat Pengolahan Minyak Bumi [Pasokan Kilang]</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input class="form-control" type="hidden" id="lihat_badan_usaha_id_pasokan" name="badan_usaha_id"
                        value="">
                    <input class="form-control" type="hidden" id="lihat_izin_id_pasokan" name="izin_id" value="">
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control" type="date" id="lihat_bulan_produksi" name="bulan"
                        value="{{ old('bulan') }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Produk</label>
                    <input class="form-control" type="text" id="lihat_produk_pengolahanProduksi" name="produk"
                        value="" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Satuan</label>
                    <input class="form-control" type="text" id="lihat_satuan_pengolahanProduksi" name="satuan"
                        value="" readonly>

                    <input class="form-control" type="hidden" id="example-text-input" name="status"
                        value="-">
                    <input class="form-control" type="hidden" id="example-text-input" name="catatan"
                        value="-">
                    <input class="form-control" type="hidden" id="example-text-input" name="petugas"
                        value="jjp">
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Provinsi</label>
                    <input class="form-control" type="text" id="lihat_provinsi_produksi" name="provinsi"
                        value="" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Kabupaten / Kota</label>
                    <input class="form-control" type="text" id="lihat_nama_kota_pengolahaProduksi"
                        name="kabupaten_kota" value="" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Volume</label>
                    <input class="form-control" type="text" id="lihat_volume_pengolahanProduksi" name="volume"
                        readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Keterangan</label>
                    <input class="form-control" type="text" id="lihat_keterangan_pengolahanProduksi"
                        name="keterangan" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
