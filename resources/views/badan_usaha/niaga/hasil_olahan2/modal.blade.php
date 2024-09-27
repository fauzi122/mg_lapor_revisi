<!-- input simpan_jholb -->
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Penjualan Hasil Olahan/Minyak Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/simpan_jholb" class="form-material m-t-40" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                
                    <input class="form-control" type="hidden" id="example-text-input" name="badan_usaha_id" value="1">
                    <input class="form-control" type="hidden" id="example-text-input" name="izin_id" value="1">
                    @error('badan_usaha_id')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control" type="text" id="example-text-input" name="bulan" value="{{ old('bulan') }}">
                    @error('bulan')
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

                    <input class="form-control" type="hidden" id="example-text-input" name="status" value="-">
                    <input class="form-control" type="hidden" id="example-text-input" name="catatan" value="-">
                    <input class="form-control" type="hidden" id="example-text-input" name="petugas" value="jjp">
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
                    <label for="example-text-input" class="form-label">Sektor</label>
                    <input class="form-control" type="text" id="example-text-input" name="sektor" value="{{ old('sektor') }}">
                    @error('sektor')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Volume</label>
                    <input class="form-control" type="text" id="example-text-input" name="volume" value="{{ old('volume') }}">
                    @error('volume')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                
            
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
            </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- import simpan_jholb -->
<div id="excelpho" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Penjualan Hasil Olahan/Minyak Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/importjholb" class="form-material m-t-40" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                
                    <input type="file" name="file" required="required">
                    
                    @error('badan_usaha_id')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
            
                
            </div>
            <div class="modal-footer">
                <a href="https://lapor.duniasakha.com/storage/template/jualhasil.xlsx" id="tombol" class="btn btn-success waves-effect waves-light">Download Template</a>
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
            </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- edit simpan_jholb -->
<div id="modal-edit" class="modal fade" tabindex="-1" aria-labelledby="editjholbxLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editjholbxLabel">Penjualan Hasil Olahan/Minyak Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_jholb/" class="form-material m-t-40" enctype="multipart/form-data" id="form_penjualan">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                
                    <input class="form-control" type="hidden" name="id" id="id_penjualan">
                    <input class="form-control" type="hidden" name="badan_usaha_id" id="badan_usaha_id_penjualan">
                    <input class="form-control" type="hidden" name="izin_id" id="izin_id_penjualan">
                    @error('badan_usaha_id')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control" type="text" name="bulan" id="bulan_penjualan">
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
                    <label for="example-text-input" class="form-label">Satuan</label>
                    <select class="form-select produk satuan" name="satuan" id="satuan_penjualan">
                        <option>Pilih Satuan</option>
                    </select>
                    <input class="form-control" type="hidden" name="status" id="status_penjualan">
                    <input class="form-control" type="hidden" name="catatan" id="catatan_penjualan">
                    <input class="form-control" type="hidden" name="petugas" id="petugas_penjualan">
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
                    <select class="form-select nama_kota" name="kabupaten_kota" id="kab_penjualan" >
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
                    <input class="form-control" type="text" name="sektor" id="sektor_penjualan">
                    @error('sektor')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Volume</label>
                    <input class="form-control" type="text" name="volume" id="volume_penjualan">
                    @error('volume')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                
                
                

                
            
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
            </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- edit simpan_jholb -->
<div id="lihat-penjualan" class="modal fade" tabindex="-1" aria-labelledby="editjholbxLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editjholbxLabel">Lihat Hasil Olahan/Minyak Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_jholb/" class="form-material m-t-40" enctype="multipart/form-data" id="form_penjualan">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                
                    <input class="form-control" type="hidden" name="id" id="id_penjualan">
                    <input class="form-control" type="hidden" name="badan_usaha_id" id="badan_usaha_id_penjualan">
                    <input class="form-control" type="hidden" name="izin_id" id="izin_id_penjualan">
                    @error('badan_usaha_id')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control" type="text" name="bulan" id="lihat_bulan_penjualan" readonly>
                    @error('bulan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Produk</label>
                    <input class="form-control" type="text" name="produk" id="lihat_produk_penjualan" readonly>
                    @error('produk')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Satuan</label>
                    <input class="form-control" type="text" name="satuan" id="lihat_satuan_penjualan" readonly>
                    @error('satuan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Provinsi</label>
                    <input class="form-control" type="text" name="provinsi" id="lihat_provinsi_penjualan" readonly>
                    @error('provinsi')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Kabupaten / Kota</label>
                    <input class="form-control" type="text" name="kabupaten_kota" id="lihat_kab_penjualan" readonly>
                    @error('kabupaten_kota')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Sektor</label>
                    <input class="form-control" type="text" name="sektor" id="lihat_sektor_penjualan" readonly>
                    @error('sektor')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Volume</label>
                    <input class="form-control" type="text" name="volume" id="lihat_volume_penjualan" readonly>
                    @error('volume')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- input simpan_pholb -->
<div id="inputpho" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Pasokan Hasil Olahan/Minyak Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/pasokan-olah" class="form-material m-t-40" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                
                    <input class="form-control" type="hidden" id="example-text-input" name="badan_usaha_id" value="1">
                    <input class="form-control" type="hidden" id="example-text-input" name="izin_id" value="1">
                    @error('badan_usaha_id')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control" type="text" id="example-text-input" name="bulan" value="{{ old('bulan') }}">
                    @error('bulan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Produk</label>
                    <select class="form-select produk name_produk" name="produk" id="name_produk_pasokan">
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
                    <!-- <input class="form-control" type="text" id="satuan_pasokan" name="satuan" value="{{ old('satuan') }}"> -->
                    <select class="form-select produk satuan" name="satuan" id="satuan">
                        <option>Pilih Satuan</option>
                    </select>
                    <input class="form-control" type="hidden" id="example-text-input" name="status" value="0">
                    <input class="form-control" type="hidden" id="example-text-input" name="catatan" value="-">
                    <input class="form-control" type="hidden" id="example-text-input" name="petugas" value="jjp">
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
                    <label for="example-text-input" class="form-label">Sektor</label>
                    <input class="form-control" type="text" id="example-text-input" name="sektor" value="{{ old('sektor') }}">
                    @error('sektor')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Volume</label>
                    <input class="form-control" type="text" id="example-text-input" name="volume" value="{{ old('volume') }}">
                    @error('volume')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

            
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
            </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- import simpan_pholb -->
<div id="excelpholb" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Pasokan Hasil Olahan/Minyak Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/importpasokan" class="form-material m-t-40" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                
                    <input type="file" name="file" required="required">
                    
                    @error('badan_usaha_id')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
            
                
            </div>
            <div class="modal-footer">
                <a href="#" id="tombol" class="btn btn-success waves-effect waves-light">Download Template</a>
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
            </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- edit simpan_jholb -->
<div id="edit-pasokan" class="modal fade" tabindex="-1" aria-labelledby="editjholbxLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editjholbxLabel">Pasokan Hasil Olahan/Minyak Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_lng/" class="form-material m-t-40" enctype="multipart/form-data" id="form_pasokan">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                
                    <input class="form-control" type="hidden" name="id" id="id_pasokan">
                    <input class="form-control" type="hidden" name="badan_usaha_id" id="badan_usaha_id_pasokan">
                    <input class="form-control" type="hidden" name="izin_id" id="izin_id_pasokan">
                    @error('badan_usaha_id')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control" type="text" name="bulan" id="bulan_pasokan">
                    @error('bulan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Produk</label>
                    <select class="form-select produk name_produk" name="produk" id="produk_pasokan">
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
                    <select class="form-select produk satuan" name="satuan" id="satuan_pasokan">
                        <option>Pilih Satuan</option>
                    </select>
                    <input class="form-control" type="hidden" name="status" id="status_pasokan">
                    <input class="form-control" type="hidden" name="catatan" id="catatan_pasokan">
                    <input class="form-control" type="hidden" name="petugas" id="petugas_pasokan">
                    @error('satuan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Provinsi</label>
                    <select class="form-select name_provinsi" name="provinsi" id="provinsi_pasokan">
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
                    <select class="form-select nama_kota" name="kabupaten_kota" id="kab_pasokan">
                        <option>Pilih Kabupaten / Kota</option>
                    </select>
                    @error('kabupaten_kota')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Sektor</label>
                    <input class="form-control" type="text" name="sektor" id="sektor_pasokan">
                    @error('sektor')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Volume</label>
                    <input class="form-control" type="text" name="volume" id="volume_pasokan">
                    @error('volume')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                
                
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
            </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- edit simpan_jholb -->
<div id="lihat-pasokan-olah" class="modal fade" tabindex="-1" aria-labelledby="editjholbxLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editjholbxLabel">Lihat Pasokan Hasil Olahan/Minyak Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_lng/" class="form-material m-t-40" enctype="multipart/form-data" id="form_pasokan">
            @method('PUT')
            @csrf
            <div class="modal-body">
            
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control" type="text" name="bulan" id="lihat_bulan_pasokan" readonly>
                    @error('bulan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Produk</label>
                    <input class="form-control" type="text" name="produk" id="lihat_produk_pasokan" readonly>
                    @error('produk')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Provinsi</label>
                    <input class="form-control" type="text" name="provinsi" id="lihat_provinsi_pasokan" readonly>
                    @error('provinsi')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Kabupaten / Kota</label>
                    <input class="form-control" type="text" name="kabupaten_kota" id="lihat_kab_pasokan" readonly>
                    @error('kabupaten_kota')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Sektor</label>
                    <input class="form-control" type="text" name="sektor" id="lihat_sektor_pasokan" readonly>
                    @error('sektor')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Volume</label>
                    <input class="form-control" type="text" name="volume" id="lihat_volume_pasokan" readonly>
                    @error('volume')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Satuan</label>
                    <input class="form-control" type="text" name="satuan" id="lihat_satuan_pasokan" readonly>
                    @error('satuan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- input simpan_hbjbu -->
<div id="inputhbjbu" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Harga BBM JBU</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/harga-bbm-jbu" class="form-material m-t-40" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                
                    <input class="form-control" type="hidden" id="example-text-input" name="badan_usaha_id" value="1">
                    <input class="form-control" type="hidden" id="example-text-input" name="izin_id" value="1">
                    @error('badan_usaha_id')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control" type="text" id="example-text-input" name="bulan" value="{{ old('bulan') }}">
                    @error('bulan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Produk</label>
                    <select class="form-select produk name_produk" name="produk" id="name_produk_pasokan">
                        <option>Pilih Produk</option>
                    </select>
                    @error('produk')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Sektor</label>
                    <input class="form-control" type="text" id="example-text-input" name="sektor" value="{{ old('sektor') }}">
                    @error('sektor')
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
                    <label for="example-text-input" class="form-label">Volume</label>
                    <input class="form-control" type="text" id="example-text-input" name="volume" value="{{ old('volume') }}">
                    @error('volume')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Biaya Perolehan</label>
                    <input class="form-control" type="text" id="example-text-input" name="biaya_perolehan" value="{{ old('biaya_perolehan') }}">
                    @error('biaya_perolehan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Biaya Distribusi</label>
                    <input class="form-control" type="text" id="example-text-input" name="biaya_distribusi" value="{{ old('biaya_distribusi') }}">
                    @error('biaya_distribusi')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Biaya Penyimpanan</label>
                    <input class="form-control" type="text" id="example-text-input" name="biaya_penyimpanan" value="{{ old('biaya_penyimpanan') }}">
                    @error('biaya_penyimpanan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Margin</label>
                    <input class="form-control" type="text" id="example-text-input" name="margin" value="{{ old('margin') }}">
                    @error('margin')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">ppn</label>
                    <input class="form-control" type="text" id="example-text-input" name="ppn" value="{{ old('ppn') }}">
                    @error('ppn')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">pbbkp</label>
                    <input class="form-control" type="text" id="example-text-input" name="pbbkp" value="{{ old('pbbkp') }}">
                    @error('pbbkp')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Harga Jual</label>
                    <input class="form-control" type="text" id="example-text-input" name="harga_jual" value="{{ old('harga_jual') }}">
                    @error('harga_jual')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
            
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
            </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- import simpan_harga BBM JBU -->
<div id="excelhbjbu" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Harga BBM JBU</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/importhargajbu" class="form-material m-t-40" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                
                    <input type="file" name="file" required="required">
                    
                    @error('badan_usaha_id')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
            
                
            </div>
            <div class="modal-footer">
                <a href="#" id="tombol" class="btn btn-success waves-effect waves-light">Download Template</a>
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
            </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- edit simpan_jholb -->
<div id="edit-hargabbm" class="modal fade" tabindex="-1" aria-labelledby="editjholbxLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editjholbxLabel">Harga BBM JBU</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/harga-bbm-jbu/" class="form-material m-t-40" enctype="multipart/form-data" id="form_hargabbm">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                
                    <input class="form-control" type="hidden" name="id" id="id_hargabbm">
                    <input class="form-control" type="hidden" name="badan_usaha_id" id="badan_usaha_id_hargabbm">
                    <input class="form-control" type="hidden" name="izin_id" id="izin_id_hargabbm">
                    @error('badan_usaha_id')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control" type="text" name="bulan" id="bulan_hargabbmx">
                    @error('bulan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Produk</label>
                    <input class="form-control" type="text" name="produk" id="produk_hargabbm">
                    @error('produk')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Provinsi</label>
                    <input class="form-control" type="text" name="provinsi" id="provinsi_hargabbm">
                    @error('provinsi')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Sektor</label>
                    <input class="form-control" type="text" name="sektor" id="sektor_hargabbm">
                    @error('sektor')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Volume</label>
                    <input class="form-control" type="text" name="volume" id="volume_hargabbm">
                    <input class="form-control" type="hidden" name="status" id="status_hargabbm">
                    <input class="form-control" type="hidden" name="catatan" id="catatan_hargabbm">
                    <input class="form-control" type="hidden" name="petugas" id="petugas_hargabbm">
                    @error('volume')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Biaya Perolehan</label>
                    <input class="form-control" type="text" name="biaya_perolehan" id="biaya_perolehan_hargabbm">
                    @error('biaya_perolehan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Biaya Distribusi</label>
                    <input class="form-control" type="text" name="biaya_distribusi" id="biaya_distribusi_hargabbm">
                    @error('biaya_distribusi')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Biaya Penyimpanan</label>
                    <input class="form-control" type="text" name="biaya_penyimpanan" id="biaya_penyimpanan_hargabbm">
                    @error('biaya_penyimpanan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Margin</label>
                    <input class="form-control" type="text" name="margin" id="margin_hargabbm">
                    @error('margin')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">PPN</label>
                    <input class="form-control" type="text" name="ppn" id="ppn_hargabbm">
                    @error('ppn')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">PBBKP</label>
                    <input class="form-control" type="text" name="pbbkp" id="pbbkp_hargabbm">
                    @error('pbbkp')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Harga Jual</label>
                    <input class="form-control" type="text" name="harga_jual" id="harga_jual_hargabbm">
                    @error('harga_jual')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                
                
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
            </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

