<!-- input Penjualan LPG -->
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Penjualan LPG</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/simpan_lpg" class="form-material m-t-40" enctype="multipart/form-data">
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
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="month" id="bulanx" name="bulan"
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
                        <label for="example-text-input" class="form-label">Volume</label>
                        <input class="form-control" type="number" id="example-text-input" name="volume"
                            value="{{ old('volume') }}" required>
                        @error('volume')
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
                            value="0">
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
                            <option value="">Pilih Kota</option>
                        </select>
                        @error('kabupaten_kota')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Sektor</label>
                        <select class="form-select nama_sektor" name="sektor" id="" required>
                            <option value="">Pilih Sektor</option>
                        </select>
                        @error('sektor')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Kemasan</label>
                        <select class="form-select" name="kemasan" id="kemasan" required>
                            <option value="">Pilih Kemasan</option>
                            <option value="3 Kg">3 Kg</option>
                            <option value="4.5 Kg">4.5 Kg</option>
                            <option value="5.5 Kg">5.5 Kg</option>
                            <option value="9 Kg">9 Kg</option>
                            <option value="12 Kg">12 Kg</option>
                            <option value="50 Kg">50 Kg</option>
                            <option value="Bulk">Bulk</option>
                            <option value="HAP">HAP</option>
                        </select>
                        @error('kemasan')
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

<!-- import Penjualan LPG -->
<div id="excelpho" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Penjualan LPG</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/importLPG" class="form-material m-t-40" enctype="multipart/form-data">
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
                    <a href="https://lapor.duniasakha.com/storage/template/niagaLPG_Penjualan.xlsx" id="tombol"
                        class="btn btn-success waves-effect waves-light">Download Template</a>
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- edit Penjualan LPG -->
<div id="modal-edit" class="modal fade" tabindex="-1" aria-labelledby="editjholbxLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editjholbxLabel">Edit Penjualan LPG</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_lpg/" id="form_lpg" class="form-material m-t-40"
                enctype="multipart/form-data" id="form_penjualan">`
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input class="form-control" type="hidden" name="id" id="id_penjualan">
                        <input class="form-control" type="hidden" id="example-text-input" name="badan_usaha_id"
                            value="{{ Auth::user()->badan_usaha_id }}">
                        <input class="form-control" type="hidden" name="izin_id" id="izin_id_penjualan">
                        @error('badan_usaha_id')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="month" name="bulan" id="bulan_penjualan">
                        @error('bulan')
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
                        <label for="example-text-input" class="form-label">Volume</label>
                        <input class="form-control" type="number" name="volume" id="volume_penjualan">
                        @error('volume')
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
                        <label for="example-text-input" class="form-label">Kemasan</label>
                        <select class="form-select" name="kemasan" id="kemasan_penjualan" required>
                            <option value="">Pilih Kemasan</option>
                            <option value="3 Kg">3 Kg</option>
                            <option value="4.5 Kg">4.5 Kg</option>
                            <option value="5.5 Kg">5.5 Kg</option>
                            <option value="9 Kg">9 Kg</option>
                            <option value="12 Kg">12 Kg</option>
                            <option value="50 Kg">50 Kg</option>
                            <option value="Bulk">Bulk</option>
                            <option value="HAP">HAP</option>
                        </select>
                        @error('kemasan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input class="form-control" type="hidden" name="status" id="status_penjualan">
                        <input class="form-control" type="hidden" name="catatan" id="catatan_penjualan">
                        <input class="form-control" type="hidden" name="petugas" id="petugas_penjualan">
                        @error('satuan')
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

<!-- lihat Penjualan LPG -->
<div id="lihatPenjualanLPG" class="modal fade" tabindex="-1" aria-labelledby="editjholbxLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editjholbxLabel">Lihat Penjualan LPG</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="lihat_bulan_penjualan" class="form-label">Bulan</label>
                    <input class="form-control" type="month" name="" id="lihat_bulan_penjualan" readonly>
                </div>
                
                <div class="mb-3">
                    <label for="lihat_produk_penjualan" class="form-label">Produk</label>
                    <input class="form-control" type="text" name="" id="lihat_produk_penjualan" readonly>
                </div>

                <div class="mb-3">
                    <label for="lihat_volume_penjualan" class="form-label">Volume</label>
                    <input class="form-control" type="number" name="" id="lihat_volume_penjualan" readonly>
                </div>

                <div class="mb-3">
                    <label for="lihat_satuan_penjualan" class="form-label">Satuan</label>
                    <input class="form-control" type="text" name="" id="lihat_satuan_penjualan" readonly>
                </div>
                
                <div class="mb-3">
                    <label for="lihat_provinsi_penjualan" class="form-label">Provinsi</label>
                    <input class="form-control" type="text" name="" id="lihat_provinsi_penjualan" readonly>
                </div>
                
                <div class="mb-3">
                    <label for="lihat_kab_penjualan" class="form-label">Kabupaten / Kota</label>
                    <input class="form-control" type="text" name="" id="lihat_kab_penjualan" readonly>
                </div>

                <div class="mb-3">
                    <label for="lihat_sektor_penjualan" class="form-label">Sektor</label>
                    <input class="form-control" type="text" name="" id="lihat_sektor_penjualan" readonly>
                </div>
                
                <div class="mb-3">
                    <label for="lihat_kemasan_penjualan" class="form-label">Kemasan</label>
                    <input class="form-control" type="text" name="" id="lihat_kemasan_penjualan" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- input Pasokan LPG -->
<div id="inputPasokanLPG" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Pasokan LPG</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/simpan_pasokanLPG" class="form-material m-t-40"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input class="form-control" type="hidden" id="example-text-input" name="badan_usaha_id"
                            value="{{ Auth::user()->badan_usaha_id }}">
                        <input class="form-control" type="hidden" id="example-text-input" name="izin_id"
                            value="1">
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="month" id="bulanxx" name="bulan"
                            value="{{ old('bulan') }}">
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Nama Pemasok</label>
                        <input class="form-control" type="text" id="" name="nama_pemasok"
                            value="{{ old('nama_pemasok') }}">
                        @error('nama_pemasok')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Kategori Pemasok</label>
                        <select class="form-control" name="kategori_pemasok" id="">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Kilang">Kilang</option>
                            <option value="BU Niaga">BU Niaga</option>
                            <option value="Import">Import</option>
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
                        <label for="example-text-input" class="form-label">Satuan</label>
                        <input class="form-control" type="text" id="example-text-input" name="satuan"
                            value="{{ old('satuan') }}">
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input class="form-control" type="hidden" id="" name="status" value="0">
                        <input class="form-control" type="hidden" id="" name="catatan" value="-">
                        <input class="form-control" type="hidden" id="" name="petugas" value="jjp">
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

<!-- import Pasokan LPG -->
<div id="excelPasokanLPG" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Import Pasokan LPG</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/importpasokanLPG" class="form-material m-t-40"
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
                    <a href="https://lapor.duniasakha.com/storage/template/niagaLPG_Pasokan.xlsx" id="tombol" class="btn btn-success waves-effect waves-light">Download
                        Template</a>
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- edit Pasokan LPG -->
<div id="editPasokanLPG" class="modal fade" tabindex="-1" aria-labelledby="editjholbxLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editjholbxLabel">Edit Pasokan LPG</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_pasokanLPG/" class="form-material m-t-40"
                enctype="multipart/form-data" id="form_pasokan">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        {{-- <input class="form-control" type="hidden" name="id" id="id_pasokan"> --}}
                        <input class="form-control" type="hidden" id="example-text-input" name="badan_usaha_id"
                            value="{{ Auth::user()->badan_usaha_id }}">
                        <input class="form-control" type="hidden" name="izin_id" id="izin_id_pasokan">
                        @error('badan_usaha_id')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="month" name="bulan" id="bulan_pasokan">
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Nama Pemasok</label>
                        <input class="form-control" type="text" name="nama_pemasok" id="nama_pemasok">
                        @error('nama_pemasok')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Kategori Pemasok</label>
                        <select class="form-control" name="kategori_pemasok" id="kategori_pemasok">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Kilang">Kilang</option>
                            <option value="BU Niaga">BU Niaga</option>
                            <option value="Import">Import</option>
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
                        <input class="form-control" type="number" name="volume" id="volume_pasokan">
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Satuan</label>
                        <input class="form-control" type="text" name="satuan" id="satuan_pasokan">
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <input class="form-control" type="hidden" name="status" id="status_pasokan">
                        <input class="form-control" type="hidden" name="catatan" id="catatan_pasokan">
                        <input class="form-control" type="hidden" name="petugas" id="petugas_pasokan">
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

<!-- lihat Pasokan LPG -->
<div id="lihatPasokanLPG" class="modal fade" tabindex="-1" aria-labelledby="editjholbxLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editjholbxLabel">Lihat Pasokan LPG</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="lihat_bulan_pasokan" class="form-label">Bulan</label>
                    <input class="form-control" type="month" name="" id="lihat_bulan_pasokan" readonly>
                </div>

                <div class="mb-3">
                    <label for="lihat_nama_pemasok" class="form-label">Nama Pemasok</label>
                    <input class="form-control" type="text" name="" id="lihat_nama_pemasok" readonly>
                </div>

                <div class="mb-3">
                    <label for="lihat_kategori_pemasok" class="form-label">Kategori Pemasok</label>
                    <input class="form-control" type="text" name="" id="lihat_kategori_pemasok" readonly>
                </div>

                <div class="mb-3">
                    <label for="lihat_volume_pasokan" class="form-label">Volume</label>
                    <input class="form-control" type="number" name="volume" id="lihat_volume_pasokan" readonly>
                </div>

                <div class="mb-3">
                    <label for="lihat_satuan_pasokan" class="form-label">Satuan</label>
                    <input class="form-control" type="text" name="satuan" id="lihat_satuan_pasokan" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
