<!-- input simpan_pengangkutan -->
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Pengangkutan Minyak Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ url('simpan_pengmb') }}" class="form-material m-t-40"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">

                        <input class="form-control" type="hidden" id="example-text-input" name="badan_usaha_id"
                            value="{{ Auth::user()->badan_usaha_id }}">
                        <input class="form-control" type="hidden" id="example-text-input" name="izin_id"
                            value="{{ $pecah[2] }}">
                        @error('badan_usaha_id')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="month" id="bulanx" name="bulan"
                            value="{{ old('bulan') }}">
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
                        <label for="example-text-input" class="form-label">Jenis Moda</label>
                        <div class="col-lg-12 d-flex flex-wrap gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="darat" name="jenis_moda[]"
                                    value="Darat">
                                <label class="form-check-label" for="darat">
                                    Darat
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="laut" name="jenis_moda[]"
                                    value="Laut">
                                <label class="form-check-label" for="laut">
                                    Laut
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="sungai_danau" name="jenis_moda[]"
                                    value="Sungai/Danau">
                                <label class="form-check-label" for="sungai_danau">
                                    Sungai/Danau
                                </label>
                            </div>
                        </div>


                        {{-- <input class="form-control" type="text" id="" name="jenis_moda"
                            value="{{ old('jenis_moda') }}"> --}}
                        @error('jenis_moda')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Node Asal</label>
                        <input class="form-control" type="text" id="" name="node_asal"
                            value="{{ old('node_asal') }}">
                        @error('node_asal')
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
                        <input class="form-control" type="text" id="" name="node_tujuan">
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
                        {{-- <input class="form-control" type="text" id="example-text-input"
                            name="satuan_volume_angkut"> --}}
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
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- edit simpan_pengangkutan -->
<div id="edit-pengmb" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Pengangkutan Minyak Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_pengmb" class="form-material m-t-40" enctype="multipart/form-data"
                id="form_pengmb">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="mb-3">

                        <input class="form-control" type="hidden" id="example-text-input" name="badan_usaha_id"
                            value="{{ Auth::user()->badan_usaha_id }}">
                        <input class="form-control" type="hidden" id="example-text-input" name="izin_id">
                        @error('badan_usaha_id')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="month" id="bulan_pengmb" name="bulan"
                            value="{{ old('bulan') }}" readonly>
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <select class="form-select produk name_produk" name="produk" id="produk_pengmb">
                            <option>Pilih Produk</option>
                        </select>
                        @error('produk')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Jenis Moda</label>
                        <div class="col-lg-12 d-flex flex-wrap gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit-darat" name="jenis_moda[]"
                                    value="Darat">
                                <label class="form-check-label" for="edit-darat">
                                    Darat
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit-laut" name="jenis_moda[]"
                                    value="Laut">
                                <label class="form-check-label" for="edit-laut">
                                    Laut
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit-sungai-danau"
                                    name="jenis_moda[]" value="Sungai/Danau">
                                <label class="form-check-label" for="edit-sungai-danau">
                                    Sungai/Danau
                                </label>
                            </div>
                        </div>

                        {{-- <input class="form-control" type="text" id="jenis_moda_pengmb" name="jenis_moda"> --}}
                        @error('jenis_moda')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Node Asal</label>
                        <input class="form-control" type="text" id="node_asal_pengmb" name="node_asal">
                        @error('node_asal')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Provinsi Asal</label>
                        <select class="form-select provinsi name_provinsi" name="provinsi_asal"
                            id="provinsi_asal_pengmb">
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
                        <input class="form-control" type="text" id="node_tujuan_pengmb" name="node_tujuan">
                        <input class="form-control" type="hidden" id="example-text-input" name="status"
                            value="0">
                        <input class="form-control" type="hidden" id="example-text-input" name="catatan"
                            value="-">
                        <input class="form-control" type="hidden" id="example-text-input" name="petugas"
                            value="jjp">
                        @error('node_tujuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Provinsi Tujuan</label>
                        <select class="form-select provinsi name_provinsi" name="provinsi_tujuan"
                            id="provinsi_tujuan_pengmb">
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
                        <input class="form-control" type="text" id="volume_supply_pengmb" name="volume_supply">
                        @error('volume_supply')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Satuan Volume Supply</label>
                        {{-- <input class="form-control" type="text" id="satuan_volume_supply_pengmb"
                            name="satuan_volume_supply"> --}}
                        <select class="form-select satuan" name="satuan_volume_supply"
                            id="satuan_volume_supply_pengmb">
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
                        <input class="form-control" type="text" id="volume_angkut_pengmb" name="volume_angkut">
                        @error('volume_angkut')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Satuan Volume Angkut</label>
                        {{-- <input class="form-control" type="text" id="satuan_volume_angkut_pengmb"
                            name="satuan_volume_angkut"> --}}
                        <select class="form-select satuan" name="satuan_volume_supply"
                            id="satuan_volume_angkut_pengmb">
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
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Update</button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- lihat pgb -->
<div id="lihat-pengmb" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Lihat Pengangkutan Minyak Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_pmb" class="form-material m-t-40" enctype="multipart/form-data"
                id="form_pmb">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="mb-3">

                        <input class="form-control" type="hidden" id="example-text-input" name="badan_usaha_id"
                            value="{{ Auth::user()->badan_usaha_id }}">
                        <input class="form-control" type="hidden" id="example-text-input" name="izin_id">
                        @error('badan_usaha_id')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="month" id="lihat_bulan_pengmb" name="bulan"
                            value="" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <input class="form-control" type="text" id="lihat_produk_pengmb" name="produk" readonly>
                        @error('produk')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Jenis Moda</label>
                        <div class="col-lg-12 d-flex flex-wrap gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="lihat-darat" disabled>
                                <label class="form-check-label" for="lihat-darat">
                                    Darat
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="lihat-laut" disabled>
                                <label class="form-check-label" for="lihat-laut">
                                    Laut
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="lihat-sungai-danau" disabled>
                                <label class="form-check-label" for="lihat-sungai-danau">
                                    Sungai/Danau
                                </label>
                            </div>
                        </div>

                        {{-- <input class="form-control" type="text" id="lihat_jenis_moda_pengmb" name="jenis_moda"
                            readonly> --}}
                        @error('jenis_moda')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Node Asal</label>
                        <input class="form-control" type="text" id="lihat_node_asal_pengmb" name="node_asal"
                            readonly>
                        @error('node_asal')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Provinsi Asal</label>
                        <input class="form-control" type="text" id="lihat_provinsi_asal_pengmb"
                            name="provinsi_asal" readonly>
                        @error('provinsi_asal')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Node Tujuan</label>
                        <input class="form-control" type="text" id="lihat_node_tujuan_pengmb" name="node_tujuan"
                            readonly>
                        <input class="form-control" type="hidden" id="example-text-input" name="status"
                            value="0">
                        <input class="form-control" type="hidden" id="example-text-input" name="catatan"
                            value="-">
                        <input class="form-control" type="hidden" id="example-text-input" name="petugas"
                            value="jjp">
                        @error('node_tujuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Provinsi Tujuan</label>
                        <input class="form-control" type="text" id="lihat_provinsi_tujuan_pengmb"
                            name="provinsi_tujuan" readonly>
                        @error('provinsi_tujuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume Supply</label>
                        <input class="form-control" type="text" id="lihat_volume_supply_pengmb"
                            name="volume_supply" readonly>
                        @error('volume_supply')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Satuan Volume Supply</label>
                        <input class="form-control" type="text" id="lihat_satuan_volume_supply_pengmb"
                            name="satuan_volume_supply" readonly>
                        @error('satuan_volume_supply')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume Angkut</label>
                        <input class="form-control" type="text" id="lihat_volume_angkut_pengmb"
                            name="volume_angkut" readonly>
                        @error('volume_angkut')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Satuan Volume Angkut</label>
                        <input class="form-control" type="text" id="lihat_satuan_volume_angkut_pengmb"
                            name="satuan_volume_angkut" readonly>
                        @error('satuan_volume_angkut')
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


<!-- import Pengangkutan Minyak Bumi -->
<div id="excelPengangkutanMB" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Import Laporan Pengangkutan Minyak Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/importPengangkutanMB" class="form-material m-t-40"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input class="form-control" type="hidden" id="example-text-input" name="izin_id"
                            value="{{ $pecah[2] }}">
                        <input class="form-control" type="month" name="bulan" id="bulan_import">
                        <br>
                        <input type="file" name="file" required="required" accept=".xlsx">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="/storage/template/pengangkutanMinyakBumi.xlsx" id="tombol"
                        class="btn btn-success waves-effect waves-light">Download Template</a>
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
