<!-- input simpan_Penyimpanan Gas Bumi -->
<div class="modal fade" tabindex="-1" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Penyimpanan Gas Bumi</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/simpan_pggb') }}" enctype="multipart/form-data">
                @csrf
                {{-- <input type="hidden" name="badan_usaha_id" value="{{ Auth::user()->badan_usaha_id }}"> --}}
                {{-- <input type="hidden" name="izin_id" value="{{ $pecah[0] }}"> --}}
                <input type="hidden" name="npwp" value="{{ Auth::user()->npwp }}">
                <input type="hidden" name="id_permohonan" value="{{ $pecah[0] }}">
                <input type="hidden" name="id_sub_page" value="{{ $pecah[2] }}">

                <div class="modal-body">
                    <div class="mb-6">
                        <label class="form-label">Bulan </label>
                        <input class="form-control flatpickr" id="bulanx" name="bulan" required>
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">No Tangki</label>
                        <input class="form-control" type="text" id="" name="no_tangki"
                            value="{{ old('no_tangki') }}" required>
                        @error('no_tangki')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
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
                    <div class="mb-6">
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
                    <div class="mb-6">
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
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Volume Stok Awal</label>
                        <input class="form-control" type="number" step="0.01" id=""
                            name="volume_stok_awal">
                        @error('volume_stok_awal')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Volume Supply</label>
                        <input class="form-control" type="number" step="0.01" id="" name="volume_supply">
                        @error('volume_supply')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Volume Output</label>
                        <input class="form-control" type="number" step="0.01" id="" name="volume_output">
                        @error('volume_output')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Volume Stok Akhir</label>
                        <input class="form-control" type="number" step="0.01" id=""
                            name="volume_stok_akhir">
                        @error('volume_stok_akhir')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Utilisasi Tangki <span
                                class="text-danger">(%)</span></label>
                        <input class="form-control" type="number" min="0" max="100"
                            id="example-text-input" name="utilisasi_tangki" required>
                        @error('utilisasi_tangki')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Pengguna <span class="text-danger">(Badan
                                usaha yang menyewa fasilitas tangki)</span></label>
                        <input class="form-control" type="text" id="example-text-input" name="pengguna">
                        @error('pengguna')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Jangka Waktu Penggunaan</label>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Tanggal Awal</label>
                                <input class="form-control" type="date" name="tanggal_awal"
                                    value="{{ old('tanggal_awal') }}">
                                @error('tanggal_awal')
                                    <div class="form-group has-danger mb-0">
                                        <div class="form-control-feedback">{{ $message }}</div>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Tanggal Berakhir</label>
                                <input class="form-control" type="date" value="{{ old('tanggal_berakhir') }}"
                                    name="tanggal_berakhir">
                                @error('tanggal_berakhir')
                                    <div class="form-group has-danger mb-0">
                                        <div class="form-control-feedback">{{ $message }}</div>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Tarif Penyimpanan</label>
                        <input class="form-control" type="number" step="0.01" id="example-text-input"
                            name="tarif_penyimpanan">
                        @error('tarif_penyimpanan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
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
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- edit simpan_Penyimpanan Gas Bumi -->
<div class="modal fade" tabindex="-1" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Edit Penyimpanan Gas Bumi</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/update_pggb') }}" class="form-material"
                enctype="multipart/form-data" id="form_pggb">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="badan_usaha_id" value="1">
                    <input type="hidden" name="izin_id" value="1">

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control flatpickr" id="bulan_pggb" name="bulan"
                            value="{{ old('bulan') }}" readonly>
                        @error('bulan_peb')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">No Tangki</label>
                        <input class="form-control" type="text" id="no_tangki_pggb" name="no_tangki" required>
                        @error('no_tangki')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
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
                    <div class="mb-6">
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
                    <div class="mb-6">
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
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Volume Stok Awal</label>
                        <input class="form-control" type="number" step="0.01" id="volume_stok_awal_pggb"
                            name="volume_stok_awal">
                        @error('volume_stok_awal')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Volume Supply</label>
                        <input class="form-control" type="number" step="0.01" id="volume_supply_pggb"
                            name="volume_supply">
                        @error('volume_supply')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Volume Output</label>
                        <input class="form-control" type="number" step="0.01" id="volume_output_pggb"
                            name="volume_output">
                        @error('volume_output')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Volume Stok Akhir</label>
                        <input class="form-control" type="number" step="0.01" id="volume_stok_akhir_pggb"
                            name="volume_stok_akhir">
                        @error('volume_stok_akhir')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Utilisasi Tangki <span
                                class="text-danger">(%)</span></label>
                        <input class="form-control" type="number" min="0" max="100"
                            id="utilisasi_tangki_pggb" name="utilisasi_tangki" required>
                        @error('utilisasi_tangki')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Pengguna <span class="text-danger">(Badan
                                usaha yang menyewa fasilitas tangki)</span></label>
                        <input class="form-control" type="text" id="pengguna_pggb" name="pengguna">
                        @error('pengguna')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Jangka Waktu Penggunaan</label>
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Tanggal Awal</label>
                                <input class="form-control" type="date" id="tanggal_awal_pggb"
                                    name="tanggal_awal" value="{{ old('tanggal_awal') }}">
                                @error('tanggal_awal')
                                    <div class="form-group has-danger mb-0">
                                        <div class="form-control-feedback">{{ $message }}</div>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Tanggal Berakhir</label>
                                <input class="form-control" type="date" id="tanggal_berakhir_pggb"
                                    value="{{ old('tanggal_berakhir') }}" name="tanggal_berakhir">
                                @error('tanggal_berakhir')
                                    <div class="form-group has-danger mb-0">
                                        <div class="form-control-feedback">{{ $message }}</div>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Tarif Penyimpanan</label>
                        <input class="form-control" type="number" step="0.01" id="tarif_penyimpanan_pggb"
                            name="tarif_penyimpanan">
                        @error('tarif_penyimpanan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Satuan Tarif</label>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- lihat Penyimpanan Gas Bumi -->
<div class="modal fade" tabindex="-1" id="lihat-pggb">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Lihat Penyimpanan Gas Bumi</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control" type="month" id="bulan_pggb_lihat" name="bulan"
                        value="{{ old('bulan') }}" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">No Tangki</label>
                    <input class="form-control" type="text" id="no_tangki_pggb_lihat" name="no_tangki"
                        value="{{ old('no_tangki') }}" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Produk</label>
                    <input class="form-control" type="text" id="produk_pggb_lihat" name="produk"
                        value="{{ old('produk') }}" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Satuan</label>
                    <input class="form-control" type="text" id="satuan_pggb_lihat" name="satuan"
                        value="{{ old('satuan') }}" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Kabupaten Kota</label>
                    <input class="form-control" type="text" id="kab_kota_pggb_lihat" name="kab_kota" readonly>
                    <input class="form-control" type="hidden" id="example-text-input" name="status"
                        value="-">
                    <input class="form-control" type="hidden" id="example-text-input" name="catatan"
                        value="-">
                    <input class="form-control" type="hidden" id="example-text-input" name="petugas"
                        value="jjp">
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Volume Stok Awal</label>
                    <input class="form-control" type="text" id="volume_stok_awal_pggb_lihat"
                        name="volume_stok_awal" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Volume Supply</label>
                    <input class="form-control" type="text" id="volume_supply_pggb_lihat" name="volume_supply"
                        readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Volume Output</label>
                    <input class="form-control" type="text" id="volume_output_pggb_lihat" name="volume_output"
                        readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Volume Stok Akhir</label>
                    <input class="form-control" type="text" id="volume_stok_akhir_pggb_lihat"
                        name="volume_stok_akhir" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Utilisasi Tangki <span
                            class="text-danger">(%)</span></label>
                    <input class="form-control" type="number" min="0" max="100"
                        id="utilisasi_tangki_pggb_lihat" name="utilisasi_tangki" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Pengguna <span class="text-danger">(Badan
                            usaha yang menyewa fasilitas tangki)</span></label>
                    <input class="form-control" type="text" id="pengguna_pggb_lihat" name="pengguna" readonly>
                </div>
                <div class="mb-6">
                    <label class="form-label">Jangka Waktu Penggunaan</label>
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Tanggal Awal</label>
                            <input class="form-control" type="date" name="tanggal_awal"
                                id="lihat_tanggal_awal_pggb" value="{{ old('tanggal_awal') }}" readonly>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Tanggal Berakhir</label>
                            <input class="form-control" type="date" value="{{ old('tanggal_berakhir') }}"
                                name="tanggal_berakhir" id="lihat_tanggal_berakhir_pggb" readonly>
                        </div>
                    </div>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Tarif Penyimpanan</label>
                    <input class="form-control" type="text" id="tarif_penyimpanan_pggb_lihat"
                        name="tarif_penyimpanan" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Satuan Tarif</label>
                    <input class="form-control" type="text" id="satuan_tarif_pggb_lihat" name="satuan_tarif"
                        readonly>
                    <input class="form-control" type="hidden" id="example-text-input" name="status"
                        value="0">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- import simpan_pmb -->
<div class="modal fade" tabindex="-1" id="excelpggb">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Import Penyimpanan Gas Bumi</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/import_pggb') }}" class="form-material m-t-40"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="izin_id" value="{{ $pecah[0] }}">
                <div class="modal-body">
                    <div class="mb-6">
                        <label class="form-label">Bulan </label>
                        <input type="hidden" name="id_permohonan" value="{{ $pecah[0] }}">
                        <input type="hidden" name="id_sub_page" value="{{ $pecah[2] }}">
                        <input class="form-control flatpickr" name="bulan" id="bulan_import" required>
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">File Excel </label>
                        <input class="form-control" type="file" name="file" accept=".xlsx" required>
                        @error('file')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer text-start">
                    <div class="row w-100">
                        <div class="col-6">
                            <a href="{{ url('/storage') }}/template/penyimpananGasBumi.xlsx"
                                class="btn btn-success">Download Template</a>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <button type="button" class="btn btn-outline btn-light"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
