<!-- input HArga BBM JBU -->
<div id="input_HargaBBM" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Harga BBM JBU/Hasil Olahan/Minyak Bumi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ url('/harga-bbm-jbu') }}" class="form-material m-t-40"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input class="form-control" type="hidden" id="" name="badan_usaha_id"
                            value="{{ Auth::user()->badan_usaha_id }}">
                        <input class="form-control" type="hidden" id="" name="izin_id"
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
                        {{-- <input class="form-control" type="text" id="example-text-input" name="sektor"
                            value="{{ old('sektor') }}"> --}}
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
                        <label for="example-text-input" class="form-label">Volume <font color="red">(Satuan KL)
                            </font></label>
                        <input class="form-control" type="text" id="example-text-input" name="volume"
                            value="{{ old('volume') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '');">

                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Biaya Perolehan <font color="red">(Satuan
                                RP / KL)</font></label>
                        <input class="form-control" type="text" id="example-text-input" name="biaya_perolehan"
                            value="{{ old('biaya_perolehan') }}"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('biaya_perolehan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Biaya Distribusi <font color="red">(Satuan
                                RP / KL)</font></label>
                        <input class="form-control" type="text" id="example-text-input" name="biaya_distribusi"
                            value="{{ old('biaya_distribusi') }}"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('biaya_distribusi')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Biaya Penyimpanan <font color="red">
                                (Satuan RP / KL)</font></label>
                        <input class="form-control" type="text" id="example-text-input" name="biaya_penyimpanan"
                            value="{{ old('biaya_penyimpanan') }}"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('biaya_penyimpanan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Margin <font color="red">(Satuan RP /
                                KL)</font></label>
                        <input class="form-control" type="text" id="example-text-input" name="margin"
                            value="{{ old('margin') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('margin')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">PPN <font color="red">(Satuan RP / KL)
                            </font></label>
                        <input class="form-control" type="text" id="example-text-input" name="ppn"
                            value="{{ old('ppn') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('ppn')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">PBBKP <font color="red">(Satuan RP /
                                KL)</font></label>
                        <input class="form-control" type="text" id="example-text-input" name="pbbkp"
                            value="{{ old('pbbkp') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('pbbkp')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Harga Jual <font color="red">(Satuan
                                Rp/KL (ket : termasuk pajak - pajak))</font></label>
                        <input class="form-control" type="text" id="example-text-input" name="harga_jual"
                            value="{{ old('harga_jual') }}"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('harga_jual')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Formula Harga</label>
                        <input class="form-control" type="text" id="example-text-input" name="formula_harga"
                            value="{{ old('formula_harga') }}">
                        @error('formula_harga')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Keterangan</label>
                        <input class="form-control" type="text" id="example-text-input" name="keterangan"
                            value="{{ old('keterangan') }}">
                        @error('keterangan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    {{-- <div class="mb-3">
                        <input class="form-control" type="hidden" id="" name="status" value="0">
                        <input class="form-control" type="hidden" id="" name="catatan" value="-">
                        <input class="form-control" type="hidden" id="" name="petugas" value="jjp">
                    </div> --}}
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

<!-- import BBM JBU -->
<div id="excelhbjbu" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Import Harga BBM JBU</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ url('/importhargajbu') }}" class="form-material m-t-40"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input class="form-control" type="hidden" id="example-text-input" name="izin_id"
                            value="{{ $pecah[2] }}">
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
                    <a href="/storage/template/niagaHargaBBM_JBU-HasilOlahan_MinyakBumi.xlsx" id="tombol"
                        class="btn btn-success waves-effect waves-light">Download
                        Template</a>
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- edit Harga BBM JBU -->
<div id="edit-hargabbm" class="modal fade" tabindex="-1" aria-labelledby="editjholbxLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editjholbxLabel">Edit Harga BBM JBU/Hasil Olahan/Minyak Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ url('/harga-bbm-jbu/') }}" class="form-material m-t-40"
                enctype="multipart/form-data" id="form_hargabbm">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input class="form-control" type="hidden" name="id" id="id_hargabbm">
                        <input class="form-control" type="hidden" name="badan_usaha_id"
                            id="badan_usaha_id_hargabbm">
                        <input class="form-control" type="hidden" name="izin_id" id="izin_id_hargabbm">
                        @error('badan_usaha_id')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="month" name="bulan" id="bulan_hargabbmx" readonly>
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <select class="form-select produk name_produk" name="produk" id="produk_hargabbm">
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
                        {{-- <input class="form-control" type="text" name="sektor" id="sektor_hargabbm"> --}}
                        <select class="form-select nama_sektor" name="sektor" id="sektor_hargabbm">
                            <option>Pilih Sektor</option>
                        </select>
                        @error('sektor')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Provinsi</label>
                        <select class="form-select provinsi name_provinsi" name="provinsi" id="provinsi_hargabbm">
                            <option>Pilih Provinsi</option>
                        </select>
                        @error('provinsi')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume <font color="red">(Satuan KL)
                            </font></label>
                        <input class="form-control" type="text" name="volume" id="volume_hargabbm"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        {{-- <input class="form-control" type="hidden" name="status" id="status_hargabbm">
                        <input class="form-control" type="hidden" name="catatan" id="catatan_hargabbm">
                        <input class="form-control" type="hidden" name="petugas" id="petugas_hargabbm"> --}}
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Biaya Perolehan <font color="red">
                                (Satuan
                                RP / KL)</font></label>
                        <input class="form-control" type="text" name="biaya_perolehan"
                            id="biaya_perolehan_hargabbm" oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('biaya_perolehan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Biaya Distribusi <font color="red">
                                (Satuan
                                RP / KL)</font></label>
                        <input class="form-control" type="text" name="biaya_distribusi"
                            id="biaya_distribusi_hargabbm" oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('biaya_distribusi')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Biaya Penyimpanan <font color="red">
                                (Satuan RP / KL)</font></label>
                        <input class="form-control" type="text" name="biaya_penyimpanan"
                            id="biaya_penyimpanan_hargabbm"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('biaya_penyimpanan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Margin <font color="red">(Satuan RP /
                                KL)</font></label>
                        <input class="form-control" type="text" name="margin" id="margin_hargabbm"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('margin')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">PPN <font color="red">(Satuan RP / KL)
                            </font></label>
                        <input class="form-control" type="text" name="ppn" id="ppn_hargabbm"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('ppn')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">PBBKP <font color="red">(Satuan RP /
                                KL)</font></label>
                        <input class="form-control" type="text" name="pbbkp" id="pbbkp_hargabbm"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('pbbkp')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Harga Jual <font color="red">(Satuan
                                Rp/KL (ket : termasuk pajak - pajak))</font></label>
                        <input class="form-control" type="text" name="harga_jual" id="harga_jual_hargabbm"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('harga_jual')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Formula Harga</label>
                        <input class="form-control" type="text" id="formula_harga_hargabbm" name="formula_harga"
                            value="{{ old('formula_harga') }}">
                        @error('formula_harga')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Keterangan</label>
                        <input class="form-control" type="text" id="keterangan_hargabbm" name="keterangan"
                            value="{{ old('keterangan') }}">
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

<!-- lihat Harga BBM JBU -->
<div id="lihat-harga-bbm" class="modal fade" tabindex="-1" aria-labelledby="editjholbxLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editjholbxLabel">Lihat Harga BBM JBU/Hasil Olahan/Minyak Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control" type="month" name="bulan" id="lihat_bulan_hargabbmx" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Produk</label>
                    <input class="form-control" type="text" name="produk" id="lihat_produk_hargabbm" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Sektor</label>
                    <input class="form-control" type="text" name="sektor" id="lihat_sektor_hargabbm" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Provinsi</label>
                    <input class="form-control" type="text" name="provinsi" id="lihat_provinsi_hargabbm"
                        readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Volume <font color="red">(Satuan KL)
                        </font></label>
                    <input class="form-control" type="number" name="volume" id="lihat_volume_hargabbm" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Biaya Perolehan <font color="red">(Satuan
                            RP / KL)</font></label>
                    <input class="form-control" type="number" name="biaya_perolehan"
                        id="lihat_biaya_perolehan_hargabbm" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Biaya Distribusi <font color="red">(Satuan
                            RP / KL)</font></label>
                    <input class="form-control" type="number" name="biaya_distribusi"
                        id="lihat_biaya_distribusi_hargabbm" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Biaya Penyimpanan <font color="red">
                            (Satuan RP / KL)</font></label>
                    <input class="form-control" type="number" name="biaya_penyimpanan"
                        id="lihat_biaya_penyimpanan_hargabbm" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Margin <font color="red">(Satuan RP /
                            KL)</font></label>
                    <input class="form-control" type="number" name="margin" id="lihat_margin_hargabbm" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">PPN <font color="red">(Satuan RP / KL)
                        </font></label>
                    <input class="form-control" type="number" name="ppn" id="lihat_ppn_hargabbm" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">PBBKP <font color="red">(Satuan RP /
                            KL)</font></label>
                    <input class="form-control" type="number" name="pbbkp" id="lihat_pbbkp_hargabbm" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Harga Jual <font color="red">(Satuan
                            Rp/KL (ket : termasuk pajak - pajak))</font></label>
                    <input class="form-control" type="number" name="harga_jual" id="lihat_harga_jual_hargabbm"
                        readonly>
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Formula Harga</label>
                    <input class="form-control" type="text" name="lihat_formula_harga_hargabbm"
                        id="lihat_formula_harga_hargabbm" readonly>
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Keterangan</label>
                    <input class="form-control" type="text" name="lihat_keterangan_harga_hargabbm"
                        id="lihat_keterangan_harga_hargabbm" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{-- ======================================================================== --}}

<!-- input HArga LPG -->
<div id="inputHargaLPG" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Input Harga LPG</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ url('/simpanHargaLPG') }}" class="form-material m-t-40"
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
                        <input class="form-control" type="month" id="bulanxx" name="bulan"
                            value="{{ old('bulan') }}">
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Sektor</label>
                        {{-- <input class="form-control" type="text" id="example-text-input" name="sektor"
                            value="{{ old('sektor') }}"> --}}
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
                        <label for="example-text-input" class="form-label">Volume <font color="red">(Satuan Mton)
                            </font></label>
                        <input class="form-control" type="text" id="example-text-input" name="volume"
                            value="{{ old('volume') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Biaya Perolehan <font color="red">
                                (Satuan
                                RP / Mton)</font></label>
                        <input class="form-control" type="text" id="example-text-input" name="biaya_perolehan"
                            value="{{ old('biaya_perolehan') }}"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('biaya_perolehan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Biaya Distribusi <font color="red">
                                (Satuan
                                RP / Mton)</font></label>
                        <input class="form-control" type="text" id="example-text-input" name="biaya_distribusi"
                            value="{{ old('biaya_distribusi') }}"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('biaya_distribusi')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Biaya Penyimpanan <font color="red">
                                (Satuan
                                RP / Mton)</font></label>
                        <input class="form-control" type="text" id="example-text-input" name="biaya_penyimpanan"
                            value="{{ old('biaya_penyimpanan') }}"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('biaya_penyimpanan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Margin <font color="red">(Satuan
                                RP / Mton)</font></label>
                        <input class="form-control" type="text" id="example-text-input" name="margin"
                            value="{{ old('margin') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('margin')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">PPN <font color="red">(Satuan
                                RP / Mton)</font></label>
                        <input class="form-control" type="text" id="example-text-input" name="ppn"
                            value="{{ old('ppn') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('ppn')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Harga Jual <font color="red">(Satuan
                                Rp/Mton (ket : termasuk pajak - pajak))</font></label>
                        <input class="form-control" type="text" id="example-text-input" name="harga_jual"
                            value="{{ old('harga_jual') }}"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('harga_jual')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Formula Harga</label>
                        <input class="form-control" type="text" id="example-text-input" name="formula_harga"
                            value="{{ old('formula_harga') }}">
                        @error('formula_harga')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Keterangan</label>
                        <input class="form-control" type="text" id="example-text-input" name="keterangan"
                            value="{{ old('keterangan') }}">
                        @error('keterangan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    {{-- <div class="mb-3">
                        <input class="form-control" type="hidden" id="" name="status" value="0">
                        <input class="form-control" type="hidden" id="" name="catatan" value="-">
                        <input class="form-control" type="hidden" id="" name="petugas" value="jjp">
                    </div> --}}

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

<!-- import Harga LPG -->
<div id="excelHargaLPG" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Import Harga LPG</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ url('/importHargaLPG') }}" class="form-material m-t-40"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input class="form-control" type="hidden" id="example-text-input" name="izin_id"
                            value="{{ $pecah[0] }}">
                        <input class="form-control" type="month" name="bulan" id="bulan_importx">
                        <br>
                        <input type="file" name="file" required="required">
                    </div>

                </div>
                <div class="modal-footer">
                    <a href="/storage/template/niagaHargaLPG.xlsx" id="tombol"
                        class="btn btn-success waves-effect waves-light">Download
                        Template</a>
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- edit Harga LPG -->
<div id="editHargaLPG" class="modal fade" tabindex="-1" aria-labelledby="editjholbxLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editjholbxLabel">Edit Harga LPG</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ url('/updateHargaLPG/') }}" class="form-material m-t-40"
                enctype="multipart/form-data" id="form_hargaLPG">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input class="form-control" type="hidden" name="id" id="id_hargaLPG">
                        <input class="form-control" type="hidden" name="badan_usaha_id"
                            id="badan_usaha_id_hargaLPG">
                        <input class="form-control" type="hidden" name="izin_id" id="izin_id_hargaLPG">
                        @error('badan_usaha_id')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="month" name="bulan" id="bulan_hargaLPG">
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Sektor</label>
                        {{-- <input class="form-control" type="text" name="sektor" id="sektor_hargaLPG"> --}}
                        <select class="form-select nama_sektor" name="sektor" id="sektor_hargaLPG">
                            <option>Pilih Sektor</option>
                        </select>
                        @error('sektor')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Provinsi</label>
                        <select class="form-select provinsi name_provinsi" name="provinsi" id="provinsi_hargaLPG">
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
                        <select class="form-select nama_kota" name="kabupaten_kota" id="nama_kota_hargaLPG" required>
                            <option value="">Pilih Kabupaten / Kota</option>
                        </select>
                        @error('kabupaten_kota')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume <font color="red">(Satuan Mton)
                            </font></label>
                        <input class="form-control" type="text" name="volume" id="volume_hargaLPG"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        {{-- <input class="form-control" type="hidden" name="status" id="status_hargaLPG">
                        <input class="form-control" type="hidden" name="catatan" id="catatan_hargaLPG">
                        <input class="form-control" type="hidden" name="petugas" id="petugas_hargaLPG"> --}}
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Biaya Perolehan <font color="red">
                                (Satuan
                                RP / Mton)</font></label>
                        <input class="form-control" type="text" name="biaya_perolehan"
                            id="biaya_perolehan_hargaLPG" oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('biaya_perolehan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Biaya Distribusi <font color="red">
                                (Satuan
                                RP / Mton)</font></label>
                        <input class="form-control" type="text" name="biaya_distribusi"
                            id="biaya_distribusi_hargaLPG" oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('biaya_distribusi')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Biaya Penyimpanan <font color="red">
                                (Satuan
                                RP / Mton)</font></label>
                        <input class="form-control" type="text" name="biaya_penyimpanan"
                            id="biaya_penyimpanan_hargaLPG"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('biaya_penyimpanan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Margin <font color="red">(Satuan
                                RP / Mton)</font></label>
                        <input class="form-control" type="text" name="margin" id="margin_hargaLPG"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('margin')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">PPN <font color="red">(Satuan
                                RP / Mton)</font></label>
                        <input class="form-control" type="text" name="ppn" id="ppn_hargaLPG"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('ppn')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Harga Jual <font color="red">(Satuan
                                Rp/Mton (ket : termasuk pajak - pajak))</font></label>
                        <input class="form-control" type="text" name="harga_jual" id="harga_jual_hargaLPG"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('harga_jual')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Formula Harga</label>
                        <input class="form-control" type="text" id="formula_harga_hargaLPG" name="formula_harga"
                            value="{{ old('formula_harga') }}">
                        @error('formula_harga')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Keterangan</label>
                        <input class="form-control" type="text" id="keterangan_hargaLPG" name="keterangan"
                            value="{{ old('keterangan') }}">
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

<!-- lihat Harga LPG -->
<div id="lihat-harga-lpg" class="modal fade" tabindex="-1" aria-labelledby="editjholbxLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editjholbxLabel">Lihat Harga LPG</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control" type="month" name="bulan" id="lihat_bulan_hargaLPGx" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Sektor</label>
                    <input class="form-control" type="text" name="sektor" id="lihat_sektor_hargaLPG" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Provinsi</label>
                    <input class="form-control" type="text" name="provinsi" id="lihat_provinsi_hargaLPG"
                        readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Kabupaten / Kota</label>
                    <input class="form-control" type="text" name="kabupaten_kota"
                        id="lihat_kabupaten_kota_hargaLPG" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Volume <font color="red">(Satuan Mton)
                        </font></label>
                    <input class="form-control" type="number" name="volume" id="lihat_volume_hargaLPG" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Biaya Perolehan <font color="red">(Satuan
                            RP / Mton)</font></label>
                    <input class="form-control" type="number" name="biaya_perolehan"
                        id="lihat_biaya_perolehan_hargaLPG" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Biaya Distribusi <font color="red">(Satuan
                            RP / Mton)</font></label>
                    <input class="form-control" type="number" name="biaya_distribusi"
                        id="lihat_biaya_distribusi_hargaLPG" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Biaya Penyimpanan <font color="red">
                            (Satuan
                            RP / Mton)</font></label>
                    <input class="form-control" type="number" name="biaya_penyimpanan"
                        id="lihat_biaya_penyimpanan_hargaLPG" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Margin <font color="red">(Satuan
                            RP / Mton)</font></label>
                    <input class="form-control" type="number" name="margin" id="lihat_margin_hargaLPG"
                        readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">PPN <font color="red">(Satuan
                            RP / Mton)</font></label>
                    <input class="form-control" type="number" name="ppn" id="lihat_ppn_hargaLPG" readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Harga Jual <font color="red">(Satuan
                            Rp/Mton (ket : termasuk pajak - pajak))</font></label>
                    <input class="form-control" type="number" name="harga_jual" id="lihat_harga_jual_hargaLPG"
                        readonly>
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Formula Harga</label>
                    <input class="form-control" type="text" name="lihat_formula_harga_hargaLPG"
                        id="lihat_formula_harga_hargaLPG" readonly>
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Keterangan</label>
                    <input class="form-control" type="text" name="lihat_keterangan_harga_hargaLPG"
                        id="lihat_keterangan_harga_hargaLPG" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect"
                    data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
