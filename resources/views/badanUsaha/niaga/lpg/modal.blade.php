<!-- input Penjualan LPG -->
<div class="modal fade" tabindex="-1" id="input_jualLPG">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Penjualan LPG</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/simpan_lpg') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="npwp" value="{{ Auth::user()->npwp }}">
                <input type="hidden" name="id_permohonan" value="{{ $pecah[0] }}">
                <input type="hidden" name="id_sub_page" value="{{ $pecah[2] }}">

                <div class="modal-body">
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control flatpickr" id="bulanx" name="bulan" value="{{ old('bulan') }}">
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <select class="form-select produk name_produk" name="produk" id="name_produk" required>
                            <option>Pilih Produk</option>
                        </select>
                        @error('produk')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Volume</label>
                        <input class="form-control" type="text" id="example-text-input" name="volume"
                            value="{{ old('volume') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Satuan</label>
                        <select class="form-select produk satuan" name="satuan">
                            <option>Pilih Satuan</option>
                        </select>
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
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
                    <div class="mb-6">
                        <label class="form-label">Kabupaten / Kota</label>
                        <select class="form-select nama_kota" name="kabupaten_kota" id="nama_kota">
                            <option>Pilih Kab / Kota</option>
                        </select>
                        @error('kab_kota')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
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
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Kemasan</label>
                        <select class="form-select" name="kemasan" id="kemasan" required>
                            <option>Pilih Kemasan</option>
                            <option value="3 Kg">3 Kg</option>
                            <option value="4.5 Kg">4.5 Kg</option>
                            <option value="5.5 Kg">5.5 Kg</option>
                            <option value="9 Kg">9 Kg</option>
                            <option value="12 Kg">12 Kg</option>
                            <option value="50 Kg">50 Kg</option>
                            <option value="Bulk">Bulk</option>
                            <option value="HAP">HAP</option>
                        </select>
                        @error('kemasan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    {{-- <div class="mb-6">
                        <label for="example-text-input" class="form-label">Keterangan</label>
                        <input class="form-control" type="text" id="example-text-input" name="keterangan"
                            value="{{ old('keterangan') }}">
                        @error('keterangan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- edit Penjualan LPG -->
<div class="modal fade" tabindex="-1" id="edit_jualLPG">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Edit Penjualan LPG</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/update_lpg') }}" class="form-material"
                enctype="multipart/form-data" id="form_lpg">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="mb-6">
                        <input class="form-control" type="hidden" name="id" id="id_penjualan">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control flatpickr" id="bulan_penjualan" name="bulan"
                            value="{{ old('bulan') }}">
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <select class="form-select produk name_produk" name="produk" id="produk_penjualan" required>
                            <option>Pilih Produk</option>
                        </select>
                        @error('produk')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Volume</label>
                        <input class="form-control" type="text" id="volume_penjualan" name="volume"
                            value="{{ old('volume') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Satuan</label>
                        <select class="form-select produk satuan" name="satuan" id="satuan_penjualan">
                            <option>Pilih Satuan</option>
                        </select>
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
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
                    <div class="mb-6">
                        <label class="form-label">Kabupaten / Kota</label>
                        <select class="form-select nama_kota" name="kabupaten_kota" id="kab_penjualan">
                            <option>Pilih Kab / Kota</option>
                        </select>
                        @error('kab_kota')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Sektor</label>
                        <select class="form-select nama_sektor" name="sektor" id="sektor_penjualan">
                            <option>Pilih Sektor</option>
                        </select>
                        @error('sektor')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Kemasan</label>
                        <select class="form-select" name="kemasan" id="kemasan_penjualan" required>
                            <option>Pilih Kemasan</option>
                            <option value="3 Kg">3 Kg</option>
                            <option value="4.5 Kg">4.5 Kg</option>
                            <option value="5.5 Kg">5.5 Kg</option>
                            <option value="9 Kg">9 Kg</option>
                            <option value="12 Kg">12 Kg</option>
                            <option value="50 Kg">50 Kg</option>
                            <option value="Bulk">Bulk</option>
                            <option value="HAP">HAP</option>
                        </select>
                        @error('kemasan')
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

<!-- lihat Penjualan LPG -->
<div class="modal fade" tabindex="-1" id="lihat-jualLPG">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Lihat Penjualan LPG</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="mb-6">
                    <input class="form-control" type="hidden" name="id" id="id_penjualan">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control flatpickr" type="month" name="" id="lihat_bulan_penjualan"
                        readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Produk</label>
                    <input class="form-control" type="text" name="" id="lihat_produk_penjualan" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Volume</label>
                    <input class="form-control" type="text" id="lihat_volume_penjualan" name="volume" readonly>
                </div>
                <div class="mb-6">
                    <label class="form-label">Satuan</label>
                    <input class="form-control" type="text" name="" id="lihat_satuan_penjualan" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Provinsi</label>
                    <input class="form-control" type="text" name="" id="lihat_provinsi_penjualan"
                        readonly>
                </div>
                <div class="mb-6">
                    <label class="form-label">Kabupaten / Kota</label>
                    <input class="form-control" type="text" name="" id="lihat_kab_penjualan" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Sektor</label>
                    <input class="form-control" type="text" name="" id="lihat_sektor_penjualan" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Kemasan</label>
                    <input class="form-control" type="text" name="" id="lihat_kemasan_penjualan" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- import Penjualan LPG -->
<div class="modal fade" tabindex="-1" id="excel_jualLPG">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Import Penjualan LPG</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/importlpg') }}" class="form-material m-t-40"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_permohonan" value="{{ $pecah[0] }}">
                <input type="hidden" name="id_sub_page" value="{{ $pecah[2] }}">
                <div class="modal-body">
                    <div class="mb-6">
                        <label class="form-label">Bulan </label>
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
                            <a href="{{ url('/storage') }}/template/niagaLPG_Penjualan.xlsx"
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

{{-- ======================================================================== --}}

<!-- input Pasokan LPG -->
<div class="modal fade" tabindex="-1" id="input_pasokanLPG">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Input Pasokan LPG</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/simpan_pasokanLPG') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="npwp" value="{{ Auth::user()->npwp }}">
                <input type="hidden" name="id_permohonan" value="{{ $pecah[0] }}">
                <input type="hidden" name="id_sub_page" value="{{ $pecah[2] }}">

                <div class="modal-body">
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control flatpickr" id="bulanxx" name="bulan"
                            value="{{ old('bulan') }}">
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Nama Pemasok</label>
                        <input class="form-control" type="text" id="example-text-input" name="nama_pemasok"
                            value="{{ old('nama_pemasok') }}">
                        @error('nama_pemasok')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Kategori Pemasok</label>
                        <select class="form-select nama_kategori" name="kategori_pemasok" id="">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Kilang">Kilang</option>
                            <option value="BU Niaga">BU Niaga</option>
                            <option value="Import">Import</option>
                            <option value="KKKS">KKKS</option>
                        </select>
                        @error('kategori_pemasok')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Volume</label>
                        <input class="form-control" type="text" id="example-text-input" name="volume"
                            value="{{ old('volume') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Satuan</label>
                        <input class="form-control" type="text" name="satuan" value="{{ old('satuan') }}">
                        @error('satuan')
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

<!-- edit Pasokan LPG -->
<div class="modal fade" tabindex="-1" id="edit_pasokanLPG">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Edit Harga LPG</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/update_pasokanLPG') }}" class="form-material"
                enctype="multipart/form-data" id="form_pasokan">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control flatpickr" id="bulan_pasokan" name="bulan"
                            value="{{ old('bulan') }}">
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Nama Pemasok</label>
                        <input class="form-control" type="text" id="nama_pemasok" name="nama_pemasok"
                            value="{{ old('nama_pemasok') }}">
                        @error('nama_pemasok')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Kategori Pemasok</label>
                        <select class="form-select nama_kategori" name="kategori_pemasok" id="kategori_pemasok">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Kilang">Kilang</option>
                            <option value="BU Niaga">BU Niaga</option>
                            <option value="Import">Import</option>
                            <option value="KKKS">KKKS</option>
                        </select>
                        @error('kategori_pemasok')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Volume</label>
                        <input class="form-control" type="text" id="volume_pasokan" name="volume"
                            value="{{ old('volume') }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Satuan</label>
                        <input class="form-control" type="text" name="satuan" id="satuan_pasokan"
                            value="{{ old('satuan') }}">
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                </div>
                {{-- <div class="modal-body">
                    <input type="hidden" name="id" id="id_hargaLPG">
                    <input type="hidden" name="npwp" id="npwp_hargaLPG">
                    <input type="hidden" name="id_permohonan" id="id_permohonan_hargaLPG">
                    <input type="hidden" name="id_sub_page" id="id_sub_page_hargaLPG">

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="month" name="bulan" id="bulan_hargaLPG">
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Sektor</label>
                        <select class="form-select nama_sektor" name="sektor" id="sektor_hargaLPG">
                            <option>Pilih Sektor</option>
                        </select>
                        @error('sektor')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
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
                    <div class="mb-6">
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
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Volume <span class="text-danger">(Satuan
                                Mton)</span></label>
                        <input class="form-control" type="text" name="volume" id="volume_hargaLPG"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Biaya Perolehan <span
                                class="text-danger">(Satuan RP / Mton)</span></label>
                        <input class="form-control" type="text" name="biaya_perolehan"
                            id="biaya_perolehan_hargaLPG" oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('biaya_perolehan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Biaya Distribusi <span
                                class="text-danger">(Satuan RP / Mton)</span></label>
                        <input class="form-control" type="text" name="biaya_distribusi"
                            id="biaya_distribusi_hargaLPG" oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('biaya_distribusi')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Biaya Penyimpanan <span
                                class="text-danger">(Satuan RP / Mton)</span></label>
                        <input class="form-control" type="text" name="biaya_penyimpanan"
                            id="biaya_penyimpanan_hargaLPG"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('biaya_penyimpanan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Margin <span class="text-danger">(Satuan
                                RP / Mton)</span></label>
                        <input class="form-control" type="text" name="margin" id="margin_hargaLPG"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('margin')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">PPN <span class="text-danger">(Satuan RP /
                                Mton)</span></label>
                        <input class="form-control" type="text" name="ppn" id="ppn_hargaLPG"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('ppn')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Harga Jual <span
                                class="text-danger">(Satuan Rp/Mton (ket : termasuk pajak - pajak))</span></label>
                        <input class="form-control" type="text" name="harga_jual" id="harga_jual_hargaLPG"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '');">
                        @error('harga_jual')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Formula Harga</label>
                        <input class="form-control" type="text" id="formula_harga_hargaLPG" name="formula_harga"
                            value="{{ old('formula_harga') }}">
                        @error('formula_harga')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Keterangan</label>
                        <input class="form-control" type="text" id="keterangan_hargaLPG" name="keterangan"
                            value="{{ old('keterangan') }}">
                        @error('keterangan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                </div> --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- lihat Pasokan LPG -->
<div class="modal fade" tabindex="-1" id="lihat-pasokanLPG">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Lihat Pasokan LPG</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>

            <div class="modal-body">
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control flatpickr" type="month" name="" id="lihat_bulan_pasokan"
                        readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Nama Pemasok</label>
                    <input class="form-control" type="text" name="" id="lihat_nama_pemasok" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Kategori Pemasok</label>
                    <input class="form-control" type="text" name="" id="lihat_kategori_pemasok" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Volume</label>
                    <input class="form-control" type="number" name="volume" id="lihat_volume_pasokan" readonly>
                </div>
                <div class="mb-6">
                    <label class="form-label">Satuan</label>
                    <input class="form-control" type="text" name="satuan" id="lihat_satuan_pasokan" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- import Pasokan LPG -->
<div class="modal fade" tabindex="-1" id="excel_pasokanLPG">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Import Pasokan LPG</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/importlpg_pasok') }}" class="form-material m-t-40"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_permohonan" value="{{ $pecah[0] }}">
                <input type="hidden" name="id_sub_page" value="{{ $pecah[2] }}">
                <div class="modal-body">
                    <div class="mb-6">
                        <label class="form-label">Bulan </label>
                        <input class="form-control flatpickr" name="bulan" id="bulan_importx" required>
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
                            <a href="{{ url('/storage') }}/template/niagaLPG_Pasokan.xlsx"
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
