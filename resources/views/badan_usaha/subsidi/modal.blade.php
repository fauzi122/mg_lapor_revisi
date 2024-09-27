<!-- input simpan_LPG Subsidi Verified -->
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">LPG Subsidi Verified</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/simpan_lgpsub" class="form-material m-t-40" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                
                    <input class="form-control" type="hidden" id="example-text-input" name="badan_usaha_id" value="{{ Auth::user()->badan_usaha_id }}">
                    <input class="form-control" type="hidden" id="example-text-input" name="izin_id" value="1">
                    <input class="form-control" type="hidden" id="example-text-input" name="jenis" value="LPG Subsidi Verified">
                    @error('badan_usaha_id')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control" type="month" id="example-text-input" name="bulan" value="{{ old('bulan') }}">
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
                    <label for="example-text-input" class="form-label">Volume (ton)</label>
                    <input class="form-control" type="number" id="example-text-input" name="volume">
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


<!-- input edit_LPG Subsidi Verified -->
<div id="modal-edit" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit LPG Subsidi Verified</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_lgpsub" class="form-material m-t-40" enctype="multipart/form-data" id="form_lgpsub">
            @method('PUT')
            @csrf
            <div class="modal-body">
            <div class="mb-3">
                
                <input class="form-control" type="hidden" id="example-text-input" name="badan_usaha_id" value="{{ Auth::user()->badan_usaha_id }}">
                <input class="form-control" type="hidden" id="example-text-input" name="izin_id" value="1">
                <input class="form-control" type="hidden" id="example-text-input" name="jenis" value="LPG Subsidi Verified">
                @error('badan_usaha_id')
                    <div class="form-group has-danger mb-0">
                        <div class="form-control-feedback">{{ $message }}</div>
                    </div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="example-text-input" class="form-label">Bulan</label>
                <input class="form-control" type="month" id="bulan_lgpsub" name="bulan" value="{{ old('bulan') }}">
                @error('bulan')
                    <div class="form-group has-danger mb-0">
                        <div class="form-control-feedback">{{ $message }}</div>
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="example-text-input" class="form-label">Provinsi</label>
                <select class="form-select provinsi name_provinsi" name="provinsi" id="provinsi_lgpsub">
                    <option>Pilih Provinsi</option>
                </select>
                @error('provinsi')
                    <div class="form-group has-danger mb-0">
                        <div class="form-control-feedback">{{ $message }}</div>
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="example-text-input" class="form-label">Volume (ton)</label>
                <input class="form-control" type="number" id="volume_lgpsub" name="volume">
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

<!-- lihat_LPG Subsidi Verified -->
<div id="lihat-lgpsub" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Lihat LPG Subsidi Verified</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_export" class="form-material m-t-40" enctype="multipart/form-data" id="form_ekpor">
            @method('PUT')
            @csrf
            <div class="modal-body">
            <div class="mb-3">
                
                <input class="form-control" type="hidden" id="example-text-input" name="badan_usaha_id" value="{{ Auth::user()->badan_usaha_id }}">
                <input class="form-control" type="hidden" id="example-text-input" name="izin_id" value="1">
                <input class="form-control" type="hidden" id="example-text-input" name="jenis" value="LPG Subsidi Verified">
                @error('badan_usaha_id')
                    <div class="form-group has-danger mb-0">
                        <div class="form-control-feedback">{{ $message }}</div>
                    </div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="example-text-input" class="form-label">Bulan</label>
                <input class="form-control" type="month" id="bulan_lgpsub_lihat" name="bulan" value="{{ old('bulan') }}" readonly>
                @error('bulan')
                    <div class="form-group has-danger mb-0">
                        <div class="form-control-feedback">{{ $message }}</div>
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="example-text-input" class="form-label">Provinsi</label>
                <input class="form-control" type="text" id="provinsi_lgpsub_lihat" name="provinsi" value="{{ old('provinsi') }}" readonly>
                @error('provinsi')
                    <div class="form-group has-danger mb-0">
                        <div class="form-control-feedback">{{ $message }}</div>
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="example-text-input" class="form-label">Volume (ton)</label>
                <input class="form-control" type="number" id="volume_lgpsub_lihat" name="volume" readonly>
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



<!-- input simpan_Kuota LPG Subsidi -->
<div id="inputklpg" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Kuota LPG Subsidi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/simpan_klpgs" class="form-material m-t-40" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
            <div class="mb-3">
                
                <input class="form-control" type="hidden" id="example-text-input" name="badan_usaha_id" value="{{ Auth::user()->badan_usaha_id }}">
                <input class="form-control" type="hidden" id="example-text-input" name="izin_id" value="1">
                <input class="form-control" type="hidden" id="example-text-input" name="jenis" value="Kuota LPG Subsidi">
                @error('badan_usaha_id')
                    <div class="form-group has-danger mb-0">
                        <div class="form-control-feedback">{{ $message }}</div>
                    </div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="example-text-input" class="form-label">Tahun</label>
                <input class="form-control" type="number" id="example-text-input" name="tahun" min="2023" max="2099" maxlength="4" value="{{ old('tahun') }}">
                @error('tahun')
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
                    <select class="form-select nama_kota" name="kab_kota" id="nama_kota">
                        <option>Pilih Kota</option>
                    </select>
                    @error('kab_kota')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
            </div>
            <div class="mb-3">
                <label for="example-text-input" class="form-label">Volume (ton)</label>
                <input class="form-control" type="number" id="example-text-input" name="volume">
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


<!-- edit simpan_Kuota LPG Subsidi -->
<div id="edit-klpg" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Kuota LPG Subsidi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_klpgs" class="form-material m-t-40" enctype="multipart/form-data" id="form_klpgs">
            @method('PUT')
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                
                    <input class="form-control" type="hidden" id="example-text-input" name="badan_usaha_id" value="{{ Auth::user()->badan_usaha_id }}">
                    <input class="form-control" type="hidden" id="example-text-input" name="izin_id" value="1">
                    <input class="form-control" type="hidden" id="example-text-input" name="jenis" value="Kuota LPG Subsidi">
                    @error('badan_usaha_id')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Tahun</label>
                    <input class="form-control" type="year" id="tahun_klpgs" name="tahun" value="{{ old('tahun') }}">
                    @error('tahun')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Provinsi</label>
                    <select class="form-select provinsi name_provinsi" name="provinsi" id="provinsi_klpgs">
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
                    <select class="form-select nama_kota" name="kab_kota" id="kab_kota_klpgs">
                        <option>Pilih Kota</option>
                    </select>
                    @error('kab_kota')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Volume (ton)</label>
                    <input class="form-control" type="number" id="volume_klpgs" name="volume">
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


<!-- lihat_Kuota LPG Subsidi -->
<div id="lihat-klpgs" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Lihat Kuota LPG Subsidi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_import" class="form-material m-t-40" enctype="multipart/form-data" id="form_impor">
            @method('PUT')
            @csrf
            <div class="modal-body">
            <div class="mb-3">
                
                <input class="form-control" type="hidden" id="example-text-input" name="badan_usaha_id" value="{{ Auth::user()->badan_usaha_id }}">
                <input class="form-control" type="hidden" id="example-text-input" name="izin_id" value="1">
                <input class="form-control" type="hidden" id="example-text-input" name="jenis" value="Kuota LPG Subsidi">
                @error('badan_usaha_id')
                    <div class="form-group has-danger mb-0">
                        <div class="form-control-feedback">{{ $message }}</div>
                    </div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="example-text-input" class="form-label">Tahun</label>
                <input class="form-control" type="year" id="tahun_klpgs_lihat" name="tahun" value="{{ old('tahun') }}" readonly>
                @error('tahun')
                    <div class="form-group has-danger mb-0">
                        <div class="form-control-feedback">{{ $message }}</div>
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="example-text-input" class="form-label">Provinsi</label>
                <input class="form-control" type="text" id="provinsi_klpgs_lihat" name="provinsi" value="{{ old('provinsi') }}" readonly>
                @error('provinsi')
                    <div class="form-group has-danger mb-0">
                        <div class="form-control-feedback">{{ $message }}</div>
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="example-text-input" class="form-label">Kabupaten / Kota</label>
                <input class="form-control" type="text" id="kab_kota_klpgs_lihat" name="kab_kota_klpgs" value="{{ old('kab_kota_klpgs') }}" readonly>
                @error('kab_kota')
                    <div class="form-group has-danger mb-0">
                        <div class="form-control-feedback">{{ $message }}</div>
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="example-text-input" class="form-label">Volume (ton)</label>
                <input class="form-control" type="number" id="volume_klpgs_lihat" name="volume" readonly>
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

<!-- import simpan_jholb -->
<div id="excellpgsubsidi" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">LPG Subsidi Verified</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/import_lgpsub" class="form-material m-t-40" enctype="multipart/form-data">
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

<!-- import simpan_jholb -->
<div id="excelkuotasubsidi" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Kuota LPG Subsidi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/import_klpgs" class="form-material m-t-40" enctype="multipart/form-data">
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