<!-- input simpan_ekspor -->
{{-- tes --}}
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Ekspor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ url('/simpan_export') }}" class="form-material m-t-40"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">

                        <input class="form-control" type="hidden" id="" name="badan_usaha_id"
                            value="{{ Auth::user()->badan_usaha_id }}">
                        <input class="form-control" type="hidden" id="" name="izin_id"
                            value="{{ $pecah[0] }}">
                        @error('badan_usaha_id')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Bulan PEB</label>
                        <input class="form-control" type="month" id="bulanx" name="bulan_peb"
                            value="{{ old('bulan_peb') }}">
                        @error('bulan_peb')
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
                        <label for="example-text-input" class="form-label">HS Code</label>
                        <input class="form-control hsCode" type="text" id="example-text-input" name="hs_code">
                        <input class="form-control" type="hidden" id="example-text-input" name="status"
                            value="0">
                        <input class="form-control" type="hidden" id="example-text-input" name="catatan"
                            value="-">
                        <input class="form-control" type="hidden" id="example-text-input" name="petugas"
                            value="jjp">
                        @error('hs_code')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume PEB</label>
                        <input class="form-control number-separator" type="text" id="example-text-input"
                            name="volume_peb">
                        @error('volume_peb')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Invoice Amount Nilai Pabean</label>
                        <input class="form-control number-separator" type="text" id="example-text-input"
                            name="invoice_amount_nilai_pabean">
                        @error('invoice_amount_nilai_pabean')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Invoice Amount Final</label>
                        <input class="form-control number-separator" type="text" id="example-text-input"
                            name="invoice_amount_final">
                        @error('invoice_amount_final')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Nama Konsumen</label>
                        <input class="form-control" type="text" id="example-text-input" name="nama_konsumen">
                        @error('nama_konsumen')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Pelabuhan Muat</label>
                        <select class="form-select pelabuhan" name="pelabuhan_muat" id="pelabuhan_muat">
                            <option>Pilih Pelabuhan</option>
                        </select>
                        @error('pelabuhan_muat')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Negara Tujuan</label>
                        <select class="form-select negara nm_negara" name="negara_tujuan" id="nm_negara">
                            <option>Pilih Negara</option>
                        </select>
                        @error('negara_tujuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Vessel Name</label>
                        <input class="form-control" type="text" id="example-text-input" name="vessel_name">
                        @error('vessel_name')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Tanggal BL</label>
                        <input class="form-control" type="date" id="example-text-input" name="tanggal_bl">
                        @error('tanggal_bl')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">BL No</label>
                        <input class="form-control" type="text" id="example-text-input" name="bl_no">
                        @error('bl_no')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">No Pendaftaran PEB</label>
                        <input class="form-control" type="text" id="example-text-input" name="no_pendaf_peb">
                        @error('no_pendaf_peb')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Tanggal Pendaftaran PEB</label>
                        <input class="form-control" type="date" id="example-text-input"
                            name="tanggal_pendaf_peb">
                        @error('tanggal_pendaf_peb')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        
                        <label for="example-text-input" class="form-label">Incoterms</label>
                        <select class="form-select incoterms" name="incoterms" id="incoterms">
                            <option>Pilih Incoterms</option>
                        </select>
                        <input class="form-control" type="hidden" id="example-text-input" name="status"
                            value="0">
                        @error('incoterms')
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


<!-- input edit_ekspor -->
<div id="modal-edit" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Ekspor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ url('/update_export') }}" class="form-material m-t-40"
                enctype="multipart/form-data" id="form_ekpor">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="mb-3">

                        <input class="form-control" type="hidden" id="" name="badan_usaha_id"
                            value="{{ Auth::user()->badan_usaha_id }}">
                        <input class="form-control" type="hidden" id="" name="izin_id" value="1">
                        @error('badan_usaha_id')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Bulan PEB</label>
                        <input class="form-control" type="month" id="bulan_ekpor" name="bulan_peb"
                            value="{{ old('bulan_peb') }}">
                        @error('bulan_peb')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <select class="form-select produk name_produk" name="produk" id="produk_ekpor">
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
                        <select class="form-select produk satuan" name="satuan" id="satuan_ekpor">
                            <option>Pilih Satuan</option>
                        </select>
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">HS Code</label>
                        <input class="form-control hsCode" type="text" id="hs_code_ekpor" name="hs_code">
                        <input class="form-control" type="hidden" id="example-text-input" name="status"
                            value="0">
                        <input class="form-control" type="hidden" id="example-text-input" name="catatan"
                            value="-">
                        <input class="form-control" type="hidden" id="example-text-input" name="petugas"
                            value="jjp">
                        @error('hs_code')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume PEB</label>
                        <input class="form-control number-separator" type="text" id="volume_peb_ekpor"
                            name="volume_peb">
                        @error('volume_peb')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Invoice Amount Nilai Pabean</label>
                        <input class="form-control number-separator" type="text"
                            id="invoice_amount_nilai_pabean_ekpor" name="invoice_amount_nilai_pabean">
                        @error('invoice_amount_nilai_pabean')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Invoice Amount Final</label>
                        <input class="form-control number-separator" type="text" id="invoice_amount_final_ekpor"
                            name="invoice_amount_final">
                        @error('invoice_amount_final')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Nama Konsumen</label>
                        <input class="form-control" type="text" id="nama_konsumen_ekpor" name="nama_konsumen">
                        @error('nama_konsumen')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">pelabuhan Muat</label>
                        {{-- <input class="form-control" type="text" id="pelabuhan_muat_ekpor" name="pelabuhan_muat"> --}}
                        <select class="form-select pelabuhan" name="pelabuhan_muat" id="pelabuhan_muat_ekpor">
                            <option>Pilih Pelabuhan Muat</option>
                        </select>
                        @error('pelabuhan_muat')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Negara Tujuan</label>
                        <select class="form-select negara nm_negara" name="negara_tujuan" id="negara_tujuan_ekpor">
                            <option>Pilih Negara</option>
                        </select>
                        @error('negara_tujuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Vessel Name</label>
                        <input class="form-control" type="text" id="vessel_name_ekpor" name="vessel_name">
                        @error('vessel_name')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Tanggal BL</label>
                        <input class="form-control" type="date" id="tanggal_bl_ekpor" name="tanggal_bl">
                        @error('tanggal_bl')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">BL No</label>
                        <input class="form-control" type="text" id="bl_no_ekpor" name="bl_no">
                        @error('bl_no')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">No Pendaftaran PEB</label>
                        <input class="form-control" type="text" id="no_pendaf_peb_ekpor" name="no_pendaf_peb">
                        @error('no_pendaf_peb')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Tanggal Pendaftaran PEB</label>
                        <input class="form-control" type="date" id="tanggal_pendaf_peb_ekpor"
                            name="tanggal_pendaf_peb">
                        @error('tanggal_pendaf_peb')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Incoterms</label>
                        <input class="form-control" type="text" id="incoterms_ekpor" name="incoterms">
                        <input class="form-control" type="hidden" id="example-text-input" name="status"
                            value="0">
                        @error('incoterms')
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

<!-- lihat_ekspor -->
<div id="lihat-ekspor" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Lihat Ekspor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ url('/update_export') }}" class="form-material m-t-40"
                enctype="multipart/form-data" id="form_ekpor">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="mb-3">

                        <input class="form-control" type="hidden" id="" name="badan_usaha_id"
                            value="{{ Auth::user()->badan_usaha_id }}">
                        <input class="form-control" type="hidden" id="" name="izin_id" value="1">
                        @error('badan_usaha_id')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Bulan PEB</label>
                        <input class="form-control" type="month" id="bulan_ekpor_lihat" name="bulan_peb"
                            value="{{ old('bulan_peb') }}" readonly>
                        @error('bulan_peb')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <input class="form-control" type="text" id="produk_ekpor_lihat" name="produk"
                            value="{{ old('produk') }}" readonly>
                        @error('produk')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Satuan</label>
                        <input class="form-control" type="text" id="satuan_ekpor_lihat" name="satuan"
                            value="{{ old('satuan') }}" readonly>
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">HS Code</label>
                        <input class="form-control" type="text" id="hs_code_ekpor_lihat" name="hs_code" readonly>
                        <input class="form-control" type="hidden" id="example-text-input" name="status"
                            value="0">
                        <input class="form-control" type="hidden" id="example-text-input" name="catatan"
                            value="-">
                        <input class="form-control" type="hidden" id="example-text-input" name="petugas"
                            value="jjp">
                        @error('hs_code')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume PEB</label>
                        <input class="form-control" type="text" id="volume_peb_ekpor_lihat" name="volume_peb"
                            readonly>
                        @error('volume_peb')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Invoice Amount Nilai Pabean</label>
                        <input class="form-control" type="text" id="invoice_amount_nilai_pabean_ekpor_lihat"
                            name="invoice_amount_nilai_pabean" readonly>
                        @error('invoice_amount_nilai_pabean')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Invoice Amount Final</label>
                        <input class="form-control" type="text" id="invoice_amount_final_ekpor_lihat"
                            name="invoice_amount_final" readonly>
                        @error('invoice_amount_final')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Nama Konsumen</label>
                        <input class="form-control" type="text" id="nama_konsumen_ekpor_lihat"
                            name="nama_konsumen" readonly>
                        @error('nama_konsumen')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">pelabuhan Muat</label>
                        <input class="form-control" type="text" id="pelabuhan_muat_ekpor_lihat"
                            name="pelabuhan_muat" readonly>
                        @error('pelabuhan_muat')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Negara Tujuan</label>
                        <input class="form-control" type="text" id="negara_tujuan_ekpor_lihat"
                            name="negara_tujuan" readonly>
                        @error('negara_tujuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Vessel Name</label>
                        <input class="form-control" type="text" id="vessel_name_ekpor_lihat" name="vessel_name"
                            readonly>
                        @error('vessel_name')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Tanggal BL</label>
                        <input class="form-control" type="date" id="tanggal_bl_ekpor_lihat" name="tanggal_bl"
                            readonly>
                        @error('tanggal_bl')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">BL No</label>
                        <input class="form-control" type="text" id="bl_no_ekpor_lihat" name="bl_no" readonly>
                        @error('bl_no')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">No Pendaftaran PEB</label>
                        <input class="form-control" type="text" id="no_pendaf_peb_ekpor_lihat"
                            name="no_pendaf_peb" readonly>
                        @error('no_pendaf_peb')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Tanggal Pendaftaran PEB</label>
                        <input class="form-control" type="date" id="tanggal_pendaf_peb_ekpor_lihat"
                            name="tanggal_pendaf_peb" readonly>
                        @error('tanggal_pendaf_peb')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Incoterms</label>
                        <input class="form-control" type="text" id="incoterms_ekpor_lihat" name="incoterms"
                            readonly>
                        <input class="form-control" type="hidden" id="example-text-input" name="status"
                            value="0">
                        @error('incoterms')
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



<!-- input simpan_impor -->
<div id="inputimpor" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Impor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ url('/simpan_import') }}" class="form-material m-t-40"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">

                        <input class="form-control" type="hidden" id="" name="badan_usaha_id"
                            value="{{ Auth::user()->badan_usaha_id }}">
                        <input class="form-control" type="hidden" id="" name="izin_id"
                            value="{{ $pecah[0] }}">
                        @error('badan_usaha_id')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Bulan PIB</label>
                        <input class="form-control" type="month" id="bulanxx" name="bulan_pib"
                            value="{{ old('bulan_pib') }}">
                        @error('bulan_pib')
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
                        <label for="example-text-input" class="form-label">HS Code</label>
                        <input class="form-control hsCode" type="text" id="" name="hs_code">
                        <input class="form-control" type="hidden" id="" name="status" value="0">
                        <input class="form-control" type="hidden" id="" name="catatan" value="-">
                        <input class="form-control" type="hidden" id="" name="petugas" value="jjp">
                        @error('hs_code')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume PIB</label>
                        <input class="form-control number-separator" type="number" step="0.01"
                            id="example-text-input" name="volume_pib">
                        @error('volume_pib')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Invoice Amount Nilai Pabean</label>
                        <input class="form-control number-separator" type="text" id="example-text-input"
                            name="invoice_amount_nilai_pabean">
                        @error('invoice_amount_nilai_pabean')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Invoice Amount Final</label>
                        <input class="form-control number-separator" type="text" id="example-text-input"
                            name="invoice_amount_final">
                        @error('invoice_amount_final')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Nama Supplier</label>
                        <input class="form-control" type="text" id="example-text-input" name="nama_supplier">
                        @error('nama_supplier')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Negara Asal</label>
                        <select class="form-select negara nm_negara" name="negara_asal" id="nm_negara">
                            <option>Pilih Negara</option>
                        </select>
                        @error('negara_asal')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Pelabuhan Muat</label>
                        <select class="form-select pelabuhan" name="pelabuhan_muat" id="example-text-input">
                            <option>Pilih Pelabuhan</option>
                        </select>
                        @error('pelabuhan_muat')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Pelabuhan Bongkar</label>
                        <select class="form-select pelabuhan" name="pelabuhan_bongkar" id="pelabuhan_bongkar">
                            <option>Pilih Pelabuhan</option>
                        </select>
                        @error('pelabuhan_bongkar')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                        {{-- <input class="form-control" type="text" id="example-text-input" name="pelabuhan_bongkar">
                    @error('pelabuhan_bongkar')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror --}}
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Vessel Name</label>
                        <input class="form-control" type="text" id="example-text-input" name="vessel_name">
                        @error('vessel_name')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Tanggal BL</label>
                        <input class="form-control" type="date" id="example-text-input" name="tanggal_bl">
                        @error('tanggal_bl')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">BL No</label>
                        <input class="form-control" type="text" id="example-text-input" name="bl_no">
                        @error('bl_no')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">No Pendaftaran PIB</label>
                        <input class="form-control" type="text" id="example-text-input" name="no_pendaf_pib">
                        @error('no_pendaf_pib')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Tanggal Pendaftaran PIB</label>
                        <input class="form-control" type="date" id="example-text-input"
                            name="tanggal_pendaf_pib">
                        @error('tanggal_pendaf_pib')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Incoterms</label>
                        <input class="form-control" type="hidden" id="example-text-input" name="status"
                            value="0">
                        <select class="form-select incoterms" name="incoterms" id="incoterms">
                            <option>Pilih Incoterms</option>
                        </select>
                        <input class="form-control" type="hidden" id="example-text-input" name="status"
                            value="0">
                        @error('incoterms')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                        {{-- <input class="form-control" type="text" id="example-text-input" name="incoterms">
                    @error('incoterms')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror --}}
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


<!-- edit simpan_impor -->
<div id="edit-impor" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Impor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ url('/update_import') }}" class="form-material m-t-40"
                enctype="multipart/form-data" id="form_impor">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="mb-3">

                        <input class="form-control" type="hidden" id="" name="badan_usaha_id"
                            value="{{ Auth::user()->badan_usaha_id }}">
                        <input class="form-control" type="hidden" id="" name="izin_id" value="1">
                        @error('badan_usaha_id')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Bulan PIB</label>
                        <input class="form-control" type="month" id="bulan_impor" name="bulan_pib"
                            value="{{ old('bulan_pib') }}">
                        @error('bulan_pib')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <select class="form-select produk name_produk" name="produk" id="produk_impor">
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
                        <select class="form-select produk satuan" name="satuan" id="satuan_impor">
                            <option>Pilih Satuan</option>
                        </select>
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">HS Code</label>
                        <input class="form-control hsCode" type="text" id="hs_code_impor" name="hs_code">
                        <input class="form-control" type="hidden" id="example-text-input" name="status"
                            value="0">
                        <input class="form-control" type="hidden" id="example-text-input" name="catatan"
                            value="-">
                        <input class="form-control" type="hidden" id="example-text-input" name="petugas"
                            value="jjp">
                        @error('hs_code')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume PIB</label>
                        <input class="form-control number-separator" type="number" step="0.01"
                            id="volume_pib_impor" name="volume_pib">
                        @error('volume_pib')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Invoice Amount Nilai Pabean</label>
                        <input class="form-control number-separator" type="text"
                            id="invoice_amount_nilai_pabean_impor" name="invoice_amount_nilai_pabean">
                        @error('invoice_amount_nilai_pabean')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Invoice Amount Final</label>
                        <input class="form-control number-separator" type="text" id="invoice_amount_final_impor"
                            name="invoice_amount_final">
                        @error('invoice_amount_final')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Nama Supplier</label>
                        <input class="form-control" type="text" id="nama_supplier_impor" name="nama_supplier">
                        @error('nama_supplier')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Negara Asal</label>
                        <select class="form-select negara nm_negara" name="negara_asal" id="negara_asal_impor">
                            <option>Pilih Negara</option>
                        </select>
                        @error('negara_asal')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Pelabuhan Muat</label>
                        {{-- <input class="form-control" type="text" id="pelabuhan_muat_impor" name="pelabuhan_muat"> --}}
                        <select class="form-select pelabuhan" name="pelabuhan_muat" id="pelabuhan_muat_impor"
                            required>
                            <option>Pilih Pelabuhan</option>
                        </select>

                        @error('pelabuhan_muat')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Pelabuhan Bongkar</label>
                        {{-- <input class="form-control" type="text" id="pelabuhan_bongkar_impor" name="pelabuhan_bongkar"> --}}
                        <select class="form-select pelabuhan" name="pelabuhan_bongkar" id="pelabuhan_bongkar_impor">
                            <option>Pilih Pelabuhan</option>
                        </select>
                        @error('pelabuhan_bongkar')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Vessel Name</label>
                        <input class="form-control" type="text" id="vessel_name_impor" name="vessel_name">
                        @error('vessel_name')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Tanggal BL</label>
                        <input class="form-control" type="date" id="tanggal_bl_impor" name="tanggal_bl">
                        @error('tanggal_bl')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">BL No</label>
                        <input class="form-control" type="text" id="bl_no_impor" name="bl_no">
                        @error('bl_no')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">No Pendaftaran PIB</label>
                        <input class="form-control" type="text" id="no_pendaf_pib_impor" name="no_pendaf_pib">
                        @error('no_pendaf_pib')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Tanggal Pendaftaran PIB</label>
                        <input class="form-control" type="date" id="tanggal_pendaf_pib_impor"
                            name="tanggal_pendaf_pib">
                        @error('tanggal_pendaf_pib')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Incoterms</label>
                        <input class="form-control" type="text" id="incoterms_impor" name="incoterms">
                        <input class="form-control" type="hidden" id="example-text-input" name="status"
                            value="0">
                        @error('incoterms')
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


<!-- lihat_impor -->
<div id="lihat-import" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Lihat Impor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ url('/update_import') }}" class="form-material m-t-40"
                enctype="multipart/form-data" id="form_impor">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="mb-3">

                        <input class="form-control" type="hidden" id="" name="badan_usaha_id"
                            value="{{ Auth::user()->badan_usaha_id }}">
                        <input class="form-control" type="hidden" id="" name="izin_id"
                            value="1">
                        @error('badan_usaha_id')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Bulan PIB</label>
                        <input class="form-control" type="month" id="bulan_impor_lihat" name="bulan_pib"
                            value="{{ old('bulan_pib') }}" readonly>
                        @error('bulan_pib')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <input class="form-control" type="text" id="produk_impor_lihat" name="produk_pib"
                            value="{{ old('bulan_pib') }}" readonly>
                        @error('produk')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Satuan</label>
                        <input class="form-control" type="text" id="satuan_impor_lihat" name="satuan_pib"
                            value="{{ old('bulan_pib') }}" readonly>
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">HS Code</label>
                        <input class="form-control" type="text" id="hs_code_impor_lihat" name="hs_code"
                            readonly>
                        <input class="form-control" type="hidden" id="example-text-input" name="status"
                            value="0">
                        <input class="form-control" type="hidden" id="example-text-input" name="catatan"
                            value="-">
                        <input class="form-control" type="hidden" id="example-text-input" name="petugas"
                            value="jjp">
                        @error('hs_code')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume PIB</label>
                        <input class="form-control" type="text" id="volume_pib_impor_lihat" name="volume_pib"
                            readonly>
                        @error('volume_pib')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Invoice Amount Nilai Pabean</label>
                        <input class="form-control" type="text" id="invoice_amount_nilai_pabean_impor_lihat"
                            name="invoice_amount_nilai_pabean" readonly>
                        @error('invoice_amount_nilai_pabean')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Invoice Amount Final</label>
                        <input class="form-control" type="text" id="invoice_amount_final_impor_lihat"
                            name="invoice_amount_final" readonly>
                        @error('invoice_amount_final')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Nama Supplier</label>
                        <input class="form-control" type="text" id="nama_supplier_impor_lihat"
                            name="nama_supplier" readonly>
                        @error('nama_supplier')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Negara Asal</label>
                        <input class="form-control" type="text" id="negara_asal_impor_lihat"
                            name="negara_asal" readonly>
                        @error('negara_asal')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">pelabuhan Muat</label>
                        <input class="form-control" type="text" id="pelabuhan_muat_impor_lihat"
                            name="pelabuhan_muat" readonly>
                        @error('pelabuhan_muat')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Pelabuhan Bongkar</label>
                        <input class="form-control" type="text" id="pelabuhan_bongkar_impor_lihat"
                            name="pelabuhan_bongkar" readonly>
                        @error('pelabuhan_bongkar')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Vessel Name</label>
                        <input class="form-control" type="text" id="vessel_name_impor_lihat"
                            name="vessel_name" readonly>
                        @error('vessel_name')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Tanggal BL</label>
                        <input class="form-control" type="date" id="tanggal_bl_impor_lihat" name="tanggal_bl"
                            readonly>
                        @error('tanggal_bl')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">BL No</label>
                        <input class="form-control" type="text" id="bl_no_impor_lihat" name="bl_no"
                            readonly>
                        @error('bl_no')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">No Pendaftaran PIB</label>
                        <input class="form-control" type="text" id="no_pendaf_pib_impor_lihat"
                            name="no_pendaf_pib" readonly>
                        @error('no_pendaf_pib')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Tanggal Pendaftaran PIB</label>
                        <input class="form-control" type="date" id="tanggal_pendaf_pib_impor_lihat"
                            name="tanggal_pendaf_pib" readonly>
                        @error('tanggal_pendaf_pib')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Incoterms</label>
                        <input class="form-control" type="text" id="incoterms_impor_lihat" name="incoterms"
                            readonly>
                        <input class="form-control" type="hidden" id="example-text-input" name="status"
                            value="0">
                        @error('incoterms')
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


<!-- import simpan_lng_pasok -->
<div id="excelexpor" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Ekspor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ url('/import_eksport') }}" class="form-material m-t-40"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input class="form-control" type="hidden" id="example-text-input" name="izin_id"
                            value="{{ $pecah[0] }}">
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
                    <a href="{{ url('/storage') }}/template/templateExpor.xlsx" id="tombol"
                        class="btn btn-success waves-effect waves-light">Download Template</a>
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- import simpan_import -->
<div id="excelimport" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Impor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ url('/import_import') }}" class="form-material m-t-40"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input class="form-control" type="hidden" id="example-text-input" name="izin_id"
                            value="{{ $pecah[0] }}">
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
                    <a href="{{ url('/storage') }}/template/templateImpor.xlsx" id="tombol"
                        class="btn btn-success waves-effect waves-light">Download Template</a>
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
