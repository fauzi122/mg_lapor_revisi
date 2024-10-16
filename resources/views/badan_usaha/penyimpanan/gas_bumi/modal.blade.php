<!-- input simpan_ekspor -->
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Penyimpanan Gas Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/simpan_pggb" class="form-material m-t-40" enctype="multipart/form-data">
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
                            value="{{ old('bulan') }}">
                        @error('bulan_peb')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">No Tangki</label>
                        <input class="form-control" type="text" id="" name="no_tangki"
                            value="{{ old('no_tangki') }}">
                        @error('no_tangki')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <select class="form-select produk name_produk" name="produk" id="">
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
                        <select class="form-select produk satuan" name="satuan" id="">
                            <option>Pilih Satuan</option>
                        </select>
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Kabupaten Kota</label>
                        <select class="form-select kab_kota nama_kota" name="kab_kota" id="">
                            <option>Pilih Kab / Kota</option>
                        </select>
                        @error('kab_kota')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume Stok Awal</label>
                        <input class="form-control" type="number" id="" name="volume_stok_awal">
                        @error('volume_stok_awal')
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
                        <label for="example-text-input" class="form-label">Volume Output</label>
                        <input class="form-control" type="number" id="" name="volume_output">
                        @error('volume_output')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume Stok Akhir</label>
                        <input class="form-control" type="number" id="" name="volume_stok_akhir">
                        @error('volume_stok_akhir')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Utilisasi Tangki <font color="red">(Persentase)</font></label>
                        <input class="form-control" type="text" id="example-text-input" name="utilisasi_tangki">
                        @error('utilisasi_tangki')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Pengguna <font color="red">(Badan usaha yang menyewa fasilitas tangki
)</font></label>
                        <input class="form-control" type="text" id="example-text-input" name="pengguna">
                        @error('pengguna')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Jangka Waktu Penggunaan</label>

                        <div class="ps-3 mt-2">
                            <div>
                                <label for="example-text-input" class="form-label">Tanggal Awal</label>
                                <input class="form-control" type="date"
                                    name="tanggal_awal">
                                @error('tanggal_awal')
                                    <div class="form-group has-danger mb-0">
                                        <div class="form-control-feedback">{{ $message }}</div>
                                    </div>
                                @enderror
                            </div>
                            <div>
                                <label for="example-text-input" class="form-label">Tanggal Berakhir</label>
                                <input class="form-control" type="date"
                                    name="tanggal_berakhir">
                                @error('tanggal_berakhir')
                                    <div class="form-group has-danger mb-0">
                                        <div class="form-control-feedback">{{ $message }}</div>
                                    </div>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Tarif Penyimpanan</label>
                        <input class="form-control" type="text" id="example-text-input" name="tarif_penyimpanan">
                        @error('tarif_penyimpanan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Satuan Tarif</label>
                        <select class="form-select" name="satuan_tarif" id="">
                            <option>Pilih Satuan Tarif</option>
                            <option value="USD">USD</option>
                            <option value="IDR">IDR</option>
                        </select>
                        @error('satuan_tarif')
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


<!-- edit simpan_pggb -->
<div id="modal-edit" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Penyimpanan Gas Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/update_pggb" class="form-material m-t-40" enctype="multipart/form-data"
                id="form_pggb">
                @method('PUT')
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
                        <input class="form-control" type="month" id="bulan_pggb" name="bulan"
                            value="{{ old('bulan') }}" readonly>
                        @error('bulan_peb')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">No Tangki</label>
                        <input class="form-control" type="text" id="no_tangki_pggb" name="no_tangki"
                            value="{{ old('no_tangki') }}">
                        @error('no_tangki')
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
                        <label for="example-text-input" class="form-label">Satuan</label>
                        <select class="form-select produk satuan" name="satuan" id="satuan_pggb">
                            <option>Pilih Satuan</option>
                        </select>
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Kabupaten Kota</label>
                        <select class="form-select kab_kota nama_kota" name="kab_kota" id="kab_kota_pggb">
                            <option>Pilih Kab / Kota</option>
                        </select>
                        @error('kab_kota')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume Stok Awal</label>
                        <input class="form-control" type="text" id="volume_stok_awal_pggb"
                            name="volume_stok_awal">
                        @error('volume_stok_awal')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume Supply</label>
                        <input class="form-control" type="text" id="volume_supply_pggb" name="volume_supply">
                        @error('volume_supply')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume Output</label>
                        <input class="form-control" type="text" id="volume_output_pggb" name="volume_output">
                        @error('volume_output')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume Stok Akhir</label>
                        <input class="form-control" type="text" id="volume_stok_akhir_pggb"
                            name="volume_stok_akhir">
                        @error('volume_stok_akhir')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Utilisasi Tangki <font color="red">(Persentase)</font></label>
                        <input class="form-control" type="text" id="utilisasi_tangki_pggb" name="utilisasi_tangki">
                        @error('utilisasi_tangki')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Pengguna <font color="red">(Badan usaha yang menyewa fasilitas tangki
)</font></label>
                        <input class="form-control" type="text" id="pengguna_pggb" name="pengguna">
                        @error('pengguna')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Jangka Waktu Penggunaan</label>

                        <div class="ps-3 mt-2">
                            <div>
                                <label for="example-text-input" class="form-label">Tanggal Awal</label>
                                <input class="form-control" type="date"
                                    name="tanggal_awal" id="tanggal_awal_pggb">
                                @error('tanggal_awal')
                                    <div class="form-group has-danger mb-0">
                                        <div class="form-control-feedback">{{ $message }}</div>
                                    </div>
                                @enderror
                            </div>
                            <div>
                                <label for="example-text-input" class="form-label">Tanggal Berakhir</label>
                                <input class="form-control" type="date"
                                    name="tanggal_berakhir" id="tanggal_berakhir_pggb">
                                @error('tanggal_berakhir')
                                    <div class="form-group has-danger mb-0">
                                        <div class="form-control-feedback">{{ $message }}</div>
                                    </div>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Tarif Penyimpanan</label>
                        <input class="form-control" type="text" id="tarif_penyimpanan_pggb"
                            name="tarif_penyimpanan">
                        @error('tarif_penyimpanan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Satuan Tarif</label>
                        {{-- <input class="form-control" type="text" id="satuan_tarif_pggb" name="satuan_tarif"> --}}
                        <select class="form-select" name="satuan_tarif" id="satuan_tarif_pggb">
                            <option>Pilih Satuan Tarif</option>
                            <option value="USD">USD</option>
                            <option value="IDR">IDR</option>
                        </select>
                        @error('satuan_tarif')
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



<!-- lihat simpan_ekspor -->
<div id="lihat-pggb" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Lihat Penyimpanan Gas Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

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
                    <input class="form-control" type="month" id="bulan_pggb_lihat" name="bulan"
                        value="{{ old('bulan') }}" readonly>
                    @error('bulan_peb')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">No Tangki</label>
                    <input class="form-control" type="text" id="no_tangki_pggb_lihat" name="no_tangki"
                        value="{{ old('no_tangki') }}" readonly>
                    @error('no_tangki')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Produk</label>
                    <input class="form-control" type="text" id="produk_pggb_lihat" name="produk"
                        value="{{ old('produk') }}" readonly>
                    @error('produk')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Satuan</label>
                    <input class="form-control" type="text" id="satuan_pggb_lihat" name="satuan"
                        value="{{ old('satuan') }}" readonly>
                    @error('satuan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Kabupaten Kota</label>
                    <input class="form-control" type="text" id="kab_kota_pggb_lihat" name="kab_kota" readonly>
                    <input class="form-control" type="hidden" id="example-text-input" name="status"
                        value="-">
                    <input class="form-control" type="hidden" id="example-text-input" name="catatan"
                        value="-">
                    <input class="form-control" type="hidden" id="example-text-input" name="petugas"
                        value="jjp">
                    @error('kab_kota')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Volume Stok Awal</label>
                    <input class="form-control" type="text" id="volume_stok_awal_pggb_lihat"
                        name="volume_stok_awal" readonly>
                    @error('volume_stok_awal')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Volume Supply</label>
                    <input class="form-control" type="text" id="volume_supply_pggb_lihat" name="volume_supply"
                        readonly>
                    @error('volume_supply')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Volume Output</label>
                    <input class="form-control" type="text" id="volume_output_pggb_lihat" name="volume_output"
                        readonly>
                    @error('volume_output')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Volume Stok Akhir</label>
                    <input class="form-control" type="text" id="volume_stok_akhir_pggb_lihat"
                        name="volume_stok_akhir" readonly>
                    @error('volume_stok_akhir')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Utilisasi Tangki <font color="red">(Persentase)</font></label>
                    <input class="form-control" type="text" id="utilisasi_tangki_pggb_lihat" name="utilisasi_tangki"
                        readonly>
                    @error('utilisasi_tangki')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Pengguna <font color="red">(Badan usaha yang menyewa fasilitas tangki
)</font></label>
                    <input class="form-control" type="text" id="pengguna_pggb_lihat" name="pengguna" readonly>
                    @error('pengguna')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Jangka Waktu Penggunaan</label>

                    <div class="ps-3 mt-2">
                        <div>
                            <label for="example-text-input" class="form-label">Tanggal Awal</label>
                            <input class="form-control" type="date"
                                name="tanggal_awal" id="lihat_tanggal_awal_pggb" readonly>
                            @error('tanggal_awal')
                                <div class="form-group has-danger mb-0">
                                    <div class="form-control-feedback">{{ $message }}</div>
                                </div>
                            @enderror
                        </div>
                        <div>
                            <label for="example-text-input" class="form-label">Tanggal Berakhir</label>
                            <input class="form-control" type="date"
                                name="tanggal_berakhir" id="lihat_tanggal_berakhir_pggb" readonly>
                            @error('tanggal_berakhir')
                                <div class="form-group has-danger mb-0">
                                    <div class="form-control-feedback">{{ $message }}</div>
                                </div>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Tarif Penyimpanan</label>
                    <input class="form-control" type="text" id="tarif_penyimpanan_pggb_lihat"
                        name="tarif_penyimpanan" readonly>
                    @error('tarif_penyimpanan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Satuan Tarif</label>
                    <input class="form-control" type="text" id="satuan_tarif_pggb_lihat" name="satuan_tarif"
                        readonly>
                    <input class="form-control" type="hidden" id="example-text-input" name="status"
                        value="0">
                    @error('satuan_tarif')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- import simpan_pmb -->
<div id="excelpggb" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    data-bs-scroll="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Penyimpanan Gas Bumi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="/import_pggb" class="form-material m-t-40" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input class="form-control" type="month" name="bulan" id="bulan_import">
                        <br>

                        <input type="file" name="file" required="required" accept=".xlsx">

                        @error('badan_usaha_id')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>


                </div>
                <div class="modal-footer">
                    <a href="https://lapor.duniasakha.com/storage/template/penyimpananGasBumi.xlsx" id="tombol"
                        class="btn btn-success waves-effect waves-light">Download Template</a>
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>

            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
