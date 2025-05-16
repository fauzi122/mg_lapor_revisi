<!-- input simpan_penjualan gbp -->
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Penjualan Gas Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/simpan_gbp" class="form-material m-t-40" enctype="multipart/form-data" id="form_penjualan">
            @csrf
            <div class="modal-body">
              
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control" type="hidden" id="example-text-input" name="badan_usaha_id" value="{{ Auth::user()->badan_usaha_id }}">
                    <input class="form-control" type="month" id="bulanx" name="bulan" value="{{ old('bulan') }}">
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
                    <label for="example-text-input" class="form-label">Sektor</label>
                    <select class="form-select nama_sektor" name="sektor" id="">
                        <option>Pilih Sektor</option>
                    </select>
                    @error('sektor')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Konsumen</label>
                    <input class="form-control" type="text" id="example-text-input" name="konsumen" value="{{ old('konsumen') }}">
                    @error('konsumen')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Jumlah Hari Penyaluran</label>
                    <input class="form-control" type="text" id="example-text-input" name="jumlah_hari_penyaluran" value="{{ old('jumlah_hari_penyaluran') }}">
                    @error('jumlah_hari_penyaluran')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">GHV</label>
                    <input class="form-control" type="text" id="example-text-input" name="ghv" value="{{ old('ghv') }}">
                    @error('ghv')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">volume mmbtu</label>
                    <input class="form-control" type="number" id="example-text-input" name="volume_mmbtu" value="{{ old('volume_mmbtu') }}">
                    @error('volume_mmbtu')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">volume mscf</label>
                    <input class="form-control" type="number" id="example-text-input" name="volume_mscf" value="{{ old('volume_mscf') }}">
                    @error('volume_mscf')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">volume m3</label>
                    <input class="form-control" type="number" id="example-text-input" name="volume_m3" value="{{ old('volume_m3') }}">
                    @error('volume_m3')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Harga</label>
                    <input class="form-control" type="number" id="example-text-input" name="harga" value="{{ old('harga') }}">
                    @error('harga')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Keterangan</label>
                    <input class="form-control" type="text" id="example-text-input" name="keterangan" value="{{ old('keterangan') }}">
                    @error('keterangan')
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


<!-- edit simpan_penjualan gbp -->
<div id="modal-edit" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Update Penjualan Gas Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_export" class="form-material m-t-40" enctype="multipart/form-data" id="form_penjualan_gbp">
            @method('PUT')
            @csrf
            <div class="modal-body">
              
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control" type="month" id="bulan_penjualan_gbp" name="bulan" value="{{ old('bulan') }}">
                    @error('bulan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Provinsi</label>
                    <select class="form-select provinsi name_provinsi" name="provinsi" id="provinsi_penjualan_gbp">
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
                    <select class="form-select nama_kota" name="kabupaten_kota" id="kab_penjualan_gbp">
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
                    <select class="form-select nama_sektor" name="sektor" id="sektor_penjualan_gbp">
                        <option>Pilih Sektor</option>
                    </select>
                    @error('sektor')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Konsumen</label>
                    <input class="form-control" type="text" id="konsumen_penjualan_gbp" name="konsumen" value="{{ old('konsumen') }}">
                    @error('konsumen')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Jumlah Hari Penyaluran</label>
                    <input class="form-control" type="text" id="jhp_penjualan_gbp" name="jumlah_hari_penyaluran" value="{{ old('jumlah_hari_penyaluran') }}">
                    @error('jumlah_hari_penyaluran')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">GHV</label>
                    <input class="form-control" type="text" id="ghv_penjualan_gbp" name="ghv" value="{{ old('ghv') }}">
                    @error('ghv')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">volume mmbtu</label>
                    <input class="form-control" type="number" id="volume_mmbtu_penjualan_gbp" name="volume_mmbtu" value="{{ old('volume_mmbtu') }}">
                    @error('volume_mmbtu')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">volume mscf</label>
                    <input class="form-control" type="number" id="volume_mscf_penjualan_bp" name="volume_mscf" value="{{ old('volume_mscf') }}">
                    @error('volume_mscf')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">volume m3</label>
                    <input class="form-control" type="number" id="volume_m3_penjualan_gbp" name="volume_m3" value="{{ old('volume_m3') }}">
                    @error('volume_m3')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Harga</label>
                    <input class="form-control" type="number" id="harga_penjualan_gbp" name="harga" value="{{ old('harga') }}">
                    @error('harga')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Keterangan</label>
                    <input class="form-control" type="text" id="keterangan_penjualan_gbp" name="keterangan" value="{{ old('keterangan') }}">
                    @error('keterangan')
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


<!-- lihat penjualan gbp -->
<div id="lihat-penjualan" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Lihat Penjualan Gas Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_gbp" class="form-material m-t-40" enctype="multipart/form-data" id="form_penjualan_gbp">
            @method('PUT')
            @csrf
            <div class="modal-body">
              
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control" type="month" id="lihat_bulan_penjualan_gbp" name="bulan" value="{{ old('bulan') }}" readonly>
                    @error('bulan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Provinsi</label>
                    <input class="form-control" type="text" id="lihat_provinsi_penjualan_gbp" name="provinsi_penjualan_gbp" value="{{ old('provinsi_penjualan_gbp') }}" readonly>
                    @error('provinsi_penjualan_gbp')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Kabupaten / Kota</label>
                    <input class="form-control" type="text" id="lihat_kab_penjualan_gbp" name="kabupaten_kota" value="{{ old('kabupaten_kota') }}" readonly>
                    @error('kabupaten_kota')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Sektor</label>
                    <input class="form-control" type="text" id="lihat_sektor_penjualan_gbp" name="sektor" value="{{ old('sektor') }}" readonly>
                    @error('sektor')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Konsumen</label>
                    <input class="form-control" type="text" id="lihat_konsumen_penjualan_gbp" name="konsumen" value="{{ old('konsumen') }}" readonly>
                    @error('konsumen')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Jumlah Hari Penyaluran</label>
                    <input class="form-control" type="text" id="lihat_jhp_penjualan_gbp" name="jumlah_hari_penyaluran" value="{{ old('jumlah_hari_penyaluran') }}" readonly>
                    @error('jumlah_hari_penyaluran')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">GHV</label>
                    <input class="form-control" type="text" id="lihat_ghv_penjualan_gbp" name="ghv" value="{{ old('ghv') }}" readonly>
                    @error('ghv')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">volume mmbtu</label>
                    <input class="form-control" type="text" id="lihat_volume_mmbtu_penjualan_gbp" name="volume_mmbtu" value="{{ old('volume_mmbtu') }}" readonly>
                    @error('volume_mmbtu')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">volume mscf</label>
                    <input class="form-control" type="text" id="lihat_volume_mscf_penjualan_bp" name="volume_mscf" value="{{ old('volume_mscf') }}" readonly>
                    @error('volume_mscf')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">volume m3</label>
                    <input class="form-control" type="text" id="lihat_volume_m3_penjualan_gbp" name="volume_m3" value="{{ old('volume_m3') }}" readonly>
                    @error('volume_m3')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Harga</label>
                    <input class="form-control" type="text" id="lihat_harga_penjualan_gbp" name="harga" value="{{ old('harga') }}" readonly>
                    @error('harga')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Keterangan</label>
                    <input class="form-control" type="text" id="lihat_keterangan_penjualan_gbp" name="keterangan" value="{{ old('keterangan') }}" readonly>
                    @error('keterangan')
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


<!-- input simpan_pasok gbp -->
<div id="inputpasokgbp" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Pasokan Gas Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/simpan_pasokan_gbp" class="form-material m-t-40" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
              
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control" type="hidden" id="" name="badan_usaha_id" value="{{ Auth::user()->badan_usaha_id }}">
                    <input class="form-control" type="month" id="bulanxx" name="bulan" value="{{ old('bulan') }}">
                    @error('bulan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Nama Pemasok</label>
                    <input class="form-control" type="text" id="example-text-input" name="nama_pemasok" value="{{ old('nama_pemasok') }}">
                    @error('nama_pemasok')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">volume mmbtu</label>
                    <input class="form-control" type="number" id="example-text-input" name="volume_mmbtu" value="{{ old('volume_mmbtu') }}">
                    @error('volume_mmbtu')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">volume mscf</label>
                    <input class="form-control" type="number" id="example-text-input" name="volume_mscf" value="{{ old('volume_mscf') }}">
                    @error('volume_mscf')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">volume m3</label>
                    <input class="form-control" type="number" id="example-text-input" name="volume_m3" value="{{ old('volume_m3') }}">
                    @error('volume_m3')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Harga</label>
                    <input class="form-control" type="number" id="example-text-input" name="harga" value="{{ old('harga') }}">
                    @error('harga')
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


<!-- edit simpan_pasok gbp -->
<div id="edit-pasokan" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Update Pasokan Gas Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_pasok_gbp" class="form-material m-t-40" enctype="multipart/form-data" id="form_pasok_gbp">
            @method('PUT')
            @csrf
            <div class="modal-body">
              
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control" type="month" id="bulan_pasok_gbp" name="bulan" value="{{ old('bulan') }}">
                    @error('bulan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Nama Pemasok</label>
                    <input class="form-control" type="text" id="nm_pemasok_pasok_gbp" name="nama_pemasok" value="{{ old('nama_pemasok') }}">
                    @error('nama_pemasok')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">volume mmbtu</label>
                    <input class="form-control" type="number" id="volume_mmbtu_pasok_gbp" name="volume_mmbtu" value="{{ old('volume_mmbtu') }}">
                    @error('volume_mmbtu')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">volume mscf</label>
                    <input class="form-control" type="number" id="volume_mscf_pasok_bp" name="volume_mscf" value="{{ old('volume_mscf') }}">
                    @error('volume_mscf')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">volume m3</label>
                    <input class="form-control" type="number" id="volume_m3_pasok_gbp" name="volume_m3" value="{{ old('volume_m3') }}">
                    @error('volume_m3')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Harga</label>
                    <input class="form-control" type="number" id="harga_pasok_gbp" name="harga" value="{{ old('harga') }}">
                    @error('harga')
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


<!-- lihat_pasok gbp -->
<div id="lihat-pasokan" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Lihat Pasokan Gas Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_pasok_gbp" class="form-material m-t-40" enctype="multipart/form-data" id="form_pasok_gbp">
            @method('PUT')
            @csrf
            <div class="modal-body">
              
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control" type="month" id="lihat_bulan_pasok_gbp" name="bulan" value="{{ old('bulan') }}" readonly>
                    @error('bulan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Nama Pemasok</label>
                    <input class="form-control" type="text" id="lihat_nm_pemasok_pasok_gbp" name="nama_pemasok" value="{{ old('nama_pemasok') }}" readonly>
                    @error('nama_pemasok')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">volume mmbtu</label>
                    <input class="form-control" type="text" id="lihat_volume_mmbtu_pasok_gbp" name="volume_mmbtu" value="{{ old('volume_mmbtu') }}" readonly>
                    @error('volume_mmbtu')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">volume mscf</label>
                    <input class="form-control" type="text" id="lihat_volume_mscf_pasok_bp" name="volume_mscf" value="{{ old('volume_mscf') }}" readonly>
                    @error('volume_mscf')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">volume m3</label>
                    <input class="form-control" type="text" id="lihat_volume_m3_pasok_gbp" name="volume_m3" value="{{ old('volume_m3') }}" readonly>
                    @error('volume_m3')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Harga</label>
                    <input class="form-control" type="text" id="lihat_harga_pasok_gbp" name="harga" value="{{ old('harga') }}" readonly>
                    @error('harga')
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

<!-- import simpan_gbp_penjualan -->
<div id="excelgbp" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Penjualan Gas Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/import_gbp" class="form-material m-t-40" enctype="multipart/form-data">
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
                <a href="{{ url('/storage') }}/template/penjualan_gbp.xlsx" id="tombol" class="btn btn-success waves-effect waves-light">Download Template</a>
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
            </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- import simpan_gbp_pasok -->
<div id="excelgbppasok" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Pasokan Gas Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/import_gbp_pasok" class="form-material m-t-40" enctype="multipart/form-data">
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
                <a href="{{ url('/storage') }}/template/pasokan_gbp.xlsx" id="tombol" class="btn btn-success waves-effect waves-light">Download Template</a>
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
            </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->