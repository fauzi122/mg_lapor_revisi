<!-- input simpan_PGB -->
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Pengangkutan Gas Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/simpan_pgb" class="form-material m-t-40" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                
                    <input class="form-control" type="hidden" id="example-text-input" name="badan_usaha_id" value="{{ Auth::user()->badan_usaha_id }}">

                    <input class="form-control" type="hidden" id="example-text-input" name="izin_id" value="1">
                    @error('badan_usaha_id')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control" type="month" id="bulanx" name="bulan" value="{{ old('bulan') }}">
                    @error('bulan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Produk</label>
                    <select class="form-select produk name_produk" name="produk" id="produk_pggb">
                        <option>Pilih Produk</option>
                    </select>
                    @error('produk')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Node Asal</label>
                    <input class="form-control" type="text" id="example-text-input" name="node_asal">
                    @error('kab_kota')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Provinsi Asal</label>
                    <select class="form-select provinsi name_provinsi" name="provinsi_asal" id="name_provinsi">
                        <option>Pilih Provinsi</option>
                    </select>
                    @error('provinsi_asal')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Node Tujuan</label>
                    <input class="form-control" type="text" id="example-text-input" name="node_tujuan">
                    @error('node_tujuan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Provinsi Tujuan</label>
                    <select class="form-select provinsi name_provinsi" name="provinsi_tujuan" id="name_provinsi">
                        <option>Pilih Provinsi</option>
                    </select>
                    @error('provinsi_tujuan')
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
                    <label for="example-text-input" class="form-label">Satuan Volume Supply</label>
                    {{-- <input class="form-control" type="text" id="" name="satuan_volume_supply"> --}}
                    <select class="form-select satuan" name="satuan_volume_supply" id="">
                        <option>Pilih Satuan</option>
                    </select>
                    @error('satuan_volume_supply')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Volume Angkut</label>
                    <input class="form-control" type="number" id="" name="volume_angkut">
                    @error('volume_angkut')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Satuan Volume Angkut</label>
                    {{-- <input class="form-control" type="text" id="" name="satuan_volume_angkut"> --}}
                    <select class="form-select satuan" name="satuan_volume_angkut" id="">
                        <option>Pilih Satuan</option>
                    </select>
                    @error('satuan_volume_angkut')
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


<!-- edit simpan_pgb -->
<div id="modal-edit-pgb" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Pengangkutan Gas Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_pgb" class="form-material m-t-40" enctype="multipart/form-data" id="form_pgb">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                
                    <input class="form-control" type="hidden" id="example-text-input" name="badan_usaha_id" value="{{ Auth::user()->badan_usaha_id }}">
                    <input class="form-control" type="hidden" id="example-text-input" name="izin_id" value="1">
                    @error('badan_usaha_id')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control" type="month" id="bulan_gb" name="bulan" value="{{ old('bulan') }}" readonly>
                    @error('bulan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Produk</label>
                    <select class="form-select produk name_produk" name="produk" id="produk_pgb">
                        <option>Pilih Produk</option>
                    </select>
                    @error('produk')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Node Asal</label>
                    <input class="form-control" type="text" id="node_asal_pgb" name="node_asal">
                    <input class="form-control" type="hidden" id="example-text-input" name="status" value="0">
                    <input class="form-control" type="hidden" id="example-text-input" name="catatan" value="-">
                    <input class="form-control" type="hidden" id="example-text-input" name="petugas" value="jjp">
                    @error('kab_kota')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Provinsi Asal</label>
                    <select class="form-select provinsi name_provinsi" name="provinsi_asal" id="provinsi_asal_pgb">
                        <option>Pilih Provinsi</option>
                    </select>
                    @error('provinsi_asal')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Node Tujuan</label>
                    <input class="form-control" type="text" id="node_tujuan_pgb" name="node_tujuan">
                    @error('node_tujuan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Provinsi Tujuan</label>
                    <select class="form-select provinsi name_provinsi" name="provinsi_tujuan" id="provinsi_tujuan_pgb">
                        <option>Pilih Provinsi</option>
                    </select>
                    @error('provinsi_tujuan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Volume Supply</label>
                    <input class="form-control" type="text" id="volume_supply_pgb" name="volume_supply">
                    @error('volume_supply')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Satuan Volume Supply</label>
                    {{-- <input class="form-control" type="text" id="satuan_volume_supply_pgb" name="satuan_volume_supply"> --}}
                    <select class="form-select satuan" name="satuan_volume_supply" id="satuan_volume_supply_pgb">
                        <option>Pilih Satuan</option>
                    </select>
                    @error('satuan_volume_supply')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Volume Angkut</label>
                    <input class="form-control" type="text" id="volume_angkut_pgb" name="volume_angkut">
                    @error('volume_angkut')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Satuan Volume Angkut</label>
                    {{-- <input class="form-control" type="text" id="satuan_volume_angkut_pgb" name="satuan_volume_angkut"> --}}
                    <select class="form-select satuan" name="satuan_volume_angkut" id="satuan_volume_angkut_pgb">
                        <option>Pilih Satuan</option>
                    </select>
                    @error('satuan_volume_angkut')
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


<!-- lihat simpan_pgb -->
<div id="lihat-pgb" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Lihat Pengangkutan Gas Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/simpan_pggb" class="form-material m-t-40" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                
                    <input class="form-control" type="hidden" id="example-text-input" name="badan_usaha_id" value="{{ Auth::user()->badan_usaha_id }}">

                    <input class="form-control" type="hidden" id="example-text-input" name="izin_id" value="1">
                    @error('badan_usaha_id')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control" type="month" id="lihat_bulan_gb" name="bulan" value="" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Produk</label>
                    <input class="form-control" type="text" id="lihat_produk_pgb" name="produk" readonly>
                    @error('produk')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Node Asal</label>
                    <input class="form-control" type="text" id="lihat_node_asal_pgb" name="node_asal" readonly>
                    @error('kab_kota')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Provinsi Asal</label>
                    <input class="form-control" type="text" id="lihat_provinsi_asal_pgb" name="provinsi_asal" readonly>
                    @error('provinsi_asal')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Node Tujuan</label>
                    <input class="form-control" type="text" id="lihat_node_tujuan_pgb" name="node_tujuan" readonly>
                    @error('node_tujuan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Provinsi Tujuan</label>
                    <input class="form-control" type="text" id="lihat_provinsi_tujuan_pgb" name="provinsi_tujuan" readonly>
                    @error('provinsi_tujuan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Volume Supply</label>
                    <input class="form-control" type="text" id="lihat_volume_supply_pgb" name="volume_supply" readonly>
                    @error('volume_supply')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Satuan Volume Supply</label>
                    <input class="form-control" type="text" id="lihat_satuan_volume_supply_pgb" name="satuan_volume_supply" readonly>
                    @error('satuan_volume_supply')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Volume Angkut</label>
                    <input class="form-control" type="text" id="lihat_volume_angkut_pgb" name="volume_angkut" readonly>
                    @error('volume_angkut')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Satuan Volume Angkut</label>
                    <input class="form-control" type="text" id="lihat_satuan_volume_angkut_pgb" name="satuan_volume_angkut" readonly>
                    @error('satuan_volume_angkut')
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


<!-- import Pengangkutan Gas Bumi -->
<div id="excelPengangkutanGB" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Import Laporan Pengangkutan Gas Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/importPengangkutanGB" class="form-material m-t-40" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <input class="form-control" type="month" name="bulan" id="bulan_import">
                        <br>
                    <input type="file" name="file" required="required" accept=".xlsx">
                </div>
            </div>
            <div class="modal-footer">
                <a href="https://lapor.duniasakha.com/storage/template/pengangkutanGasBumi.xlsx" id="tombol" class="btn btn-success waves-effect waves-light">Download Template</a>
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
            </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->