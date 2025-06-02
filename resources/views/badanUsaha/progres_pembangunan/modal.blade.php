<!-- input simpan_LPG Subsidi Verified -->
<div class="modal fade" tabindex="-1" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Izin Sementara Minyak Bumi / Gas Bumi</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/simpan_izinSementara') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="badan_usaha_id" value="{{ Auth::user()->badan_usaha_id }}">
                <input type="hidden" name="izin_id" value="1">

                <div class="modal-body">
                    <div class="mb-6">
                        <label for="prosentase_pembangunan" class="form-label">Prosentase Pembangunan</label>
                        <input class="form-control" type="number" id="prosentase_pembangunan" name="prosentase_pembangunan">
                        @error('prosentase_pembangunan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="realisasi_investasi" class="form-label">Realisasi Investasi</label>
                        <input class="form-control" type="number" id="realisasi_investasi" name="realisasi_investasi">
                        @error('realisasi_investasi')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="matrik_bobot_pembangunan" class="form-label">Matrik Bobot Pembangunan</label>
                        <input class="form-control" type="file" id="matrik_bobot_pembangunan" name="matrik_bobot_pembangunan"
                            accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                        @error('matrik_bobot_pembangunan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="bukti_progres_pembangunan" class="form-label">Bukti Progres Pembangunan</label>
                        <input class="form-control" type="file" id="bukti_progres_pembangunan" name="bukti_progres_pembangunan"
                            accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                        @error('bukti_progres_pembangunan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="tkdn" class="form-label">TKDN</label>
                        <input class="form-control" type="number" id="tkdn" name="tkdn">
                        @error('tkdn')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <input type="hidden" id="" name="status" value="0">
                    <input type="hidden" id="" name="catatan" value="-">
                    <input type="hidden" id="" name="petugas" value="jjp">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- input edit_LPG Subsidi Verified -->
<div class="modal fade" tabindex="-1" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Edit LPG Subsidi Verified</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/update_lgpsub') }}" class="form-material" enctype="multipart/form-data" id="form_lgpsub">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="badan_usaha_id" value="{{ Auth::user()->badan_usaha_id }}">
                    <input type="hidden" name="izin_id" value="1">
                    <input type="hidden" name="jenis" value="LPG Subsidi Verified">

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="month" id="bulan_lgpsub" name="bulan" value="{{ old('bulan') }}">
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
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
                    <div class="mb-6">
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>