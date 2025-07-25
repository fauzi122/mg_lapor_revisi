<!-- input Penjualan LNG -->
<div class="modal fade" tabindex="-1" id="input_jualLNG">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Penjualan LNG/CNG/BBG</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/simpan_lng') }}" enctype="multipart/form-data">
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
                        <label for="example-text-input" class="form-label">Konsumen</label>
                        <input class="form-control" type="text" id="example-text-input" name="konsumen"
                            value="{{ old('konsumen') }}">
                        @error('konsumen')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Sektor</label>
                        <select class="form-select nama_sektor" name="sektor" id="">
                            <option>Pilih Kota</option>
                        </select>
                        @error('sektor')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Volume</label>
                        <input class="form-control" type="number" id="example-text-input" name="volume"
                            value="{{ old('volume') }}">
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Biaya Kompresi</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="biaya_kompresi"
                                value="{{ old('biaya_kompresi') }}">
                            <div class="input-group-append">
                                <select class="form-select" name="satuan_biaya_kompresi">
                                    <option disabled selected>Pilih Satuan Tarif</option>
                                    <option value="USD">USD</option>
                                    <option value="IDR">IDR</option>
                                </select>
                            </div>
                        </div>
                        @error('biaya_kompresi')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                        @error('satuan_biaya_kompresi')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Biaya Penyimpanan</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="biaya_penyimpanan"
                                value="{{ old('biaya_penyimpanan') }}">
                            <div class="input-group-append">
                                <select class="form-select" name="satuan_biaya_penyimpanan">
                                    <option disabled selected>Pilih Satuan Tarif</option>
                                    <option value="USD">USD</option>
                                    <option value="IDR">IDR</option>
                                </select>
                            </div>
                        </div>
                        @error('biaya_penyimpanan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                        @error('satuan_biaya_penyimpanan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Biaya Pengangkutan</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="biaya_pengangkutan"
                                value="{{ old('biaya_pengangkutan') }}">
                            <div class="input-group-append">
                                <select class="form-select" name="satuan_biaya_pengangkutan">
                                    <option disabled selected>Pilih Satuan Tarif</option>
                                    <option value="USD">USD</option>
                                    <option value="IDR">IDR</option>
                                </select>
                            </div>
                        </div>
                        @error('biaya_pengangkutan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                        @error('satuan_biaya_pengangkutan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Biaya Niaga</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="biaya_niaga"
                                value="{{ old('biaya_niaga') }}">
                            <div class="input-group-append">
                                <select class="form-select" name="satuan_biaya_niaga">
                                    <option disabled selected>Pilih Satuan Tarif</option>
                                    <option value="USD">USD</option>
                                    <option value="IDR">IDR</option>
                                </select>
                            </div>
                        </div>
                        @error('biaya_niaga')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                        @error('satuan_biaya_niaga')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Harga Bahan Baku</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="harga_bahan_baku"
                                value="{{ old('harga_bahan_baku') }}">
                            <div class="input-group-append">
                                <select class="form-select" name="satuan_harga_bahan_baku">
                                    <option disabled selected>Pilih Satuan Tarif</option>
                                    <option value="USD">USD</option>
                                    <option value="IDR">IDR</option>
                                </select>
                            </div>
                        </div>
                        @error('harga_bahan_baku')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                        @error('satuan_harga_bahan_baku')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Pajak</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="pajak" value="{{ old('pajak') }}">
                            <div class="input-group-append">
                                <select class="form-select" name="satuan_pajak">
                                    <option disabled selected>Pilih Satuan Tarif</option>
                                    <option value="USD">USD</option>
                                    <option value="IDR">IDR</option>
                                </select>
                            </div>
                        </div>
                        @error('pajak')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                        @error('satuan_pajak')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Harga Jual</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="harga_jual"
                                value="{{ old('harga_jual') }}">
                            <div class="input-group-append">
                                <select class="form-select" name="satuan_harga_jual">
                                    <option disabled selected>Pilih Satuan Tarif</option>
                                    <option value="USD">USD</option>
                                    <option value="IDR">IDR</option>
                                </select>
                            </div>
                        </div>
                        @error('harga_jual')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                        @error('satuan_harga_jual')
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

<!-- edit Penjualan LNG -->
<div class="modal fade" tabindex="-1" id="edit_jualLNG">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Edit Penjualan LNG/CNG/BBG</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/update_lng') }}" class="form-material"
                enctype="multipart/form-data" id="form_lng">
                @method('PUT')
                @csrf
                <div class="modal-body">

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control flatpickr" name="bulan" id="bulan_penjualan" readonly>
                        @error('bulan')
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
                        <label for="example-text-input" class="form-label">Kabupaten / Kota</label>
                        <select class="form-select nama_kota" name="kabupaten_kota" id="kab_penjualan">
                            <option>Pilih Kota</option>
                        </select>
                        @error('kabupaten_kota')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <select class="form-select produk name_produk" name="produk" id="produk_penjualan">
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
                        <label for="example-text-input" class="form-label">Konsumen</label>
                        <input class="form-control" type="text" id="konsumen_penjualan" name="konsumen">
                        @error('konsumen')
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
                        <label for="example-text-input" class="form-label">Volume</label>
                        <input class="form-control" type="number" id="volume_penjualan" name="volume">
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Biaya Kompresi</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="biaya_kompresi"
                                value="{{ old('biaya_kompresi') }}" id="biaya_kompresi_penjualan">
                            <div class="input-group-append">
                                <select class="form-select" name="satuan_biaya_kompresi" id="satuan_biaya_kompresi">
                                    <option disabled selected>Pilih Satuan Tarif</option>
                                    <option value="USD">USD</option>
                                    <option value="IDR">IDR</option>
                                </select>
                            </div>
                        </div>
                        @error('biaya_kompresi')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                        @error('satuan_biaya_kompresi')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Biaya Penyimpanan</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="biaya_penyimpanan"
                                value="{{ old('biaya_penyimpanan') }}" id="biaya_penyimpanan_penjualan">
                            <div class="input-group-append">
                                <select class="form-select" name="satuan_biaya_penyimpanan"
                                    id="satuan_biaya_penyimpanan">
                                    <option disabled selected>Pilih Satuan Tarif</option>
                                    <option value="USD">USD</option>
                                    <option value="IDR">IDR</option>
                                </select>
                            </div>
                        </div>
                        @error('biaya_penyimpanan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                        @error('satuan_biaya_penyimpanan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Biaya Pengangkutan</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="biaya_pengangkutan"
                                value="{{ old('biaya_pengangkutan') }}" id="biaya_pengangkutan_penjualan">
                            <div class="input-group-append">
                                <select class="form-select" name="satuan_biaya_pengangkutan"
                                    id="satuan_biaya_pengangkutan">
                                    <option disabled selected>Pilih Satuan Tarif</option>
                                    <option value="USD">USD</option>
                                    <option value="IDR">IDR</option>
                                </select>
                            </div>
                        </div>
                        @error('biaya_pengangkutan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                        @error('satuan_biaya_pengangkutan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Biaya Niaga</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="biaya_niaga"
                                value="{{ old('biaya_niaga') }}" id="biaya_niaga_penjualan">
                            <div class="input-group-append">
                                <select class="form-select" name="satuan_biaya_niaga" id="satuan_biaya_niaga">
                                    <option disabled selected>Pilih Satuan Tarif</option>
                                    <option value="USD">USD</option>
                                    <option value="IDR">IDR</option>
                                </select>
                            </div>
                        </div>
                        @error('biaya_niaga')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                        @error('satuan_biaya_niaga')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Harga Bahan Baku</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="harga_bahan_baku"
                                value="{{ old('harga_bahan_baku') }}" id="harga_bahan_baku">
                            <div class="input-group-append">
                                <select class="form-select" name="satuan_harga_bahan_baku"
                                    id="satuan_harga_bahan_baku">
                                    <option disabled selected>Pilih Satuan Tarif</option>
                                    <option value="USD">USD</option>
                                    <option value="IDR">IDR</option>
                                </select>
                            </div>
                        </div>
                        @error('harga_bahan_baku')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                        @error('satuan_harga_bahan_baku')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Pajak</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="pajak" value="{{ old('pajak') }}"
                                id="pajak">
                            <div class="input-group-append">
                                <select class="form-select" name="satuan_pajak" id="satuan_pajak">
                                    <option disabled selected>Pilih Satuan Tarif</option>
                                    <option value="USD">USD</option>
                                    <option value="IDR">IDR</option>
                                </select>
                            </div>
                        </div>
                        @error('pajak')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                        @error('satuan_pajak')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Harga Jual</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="harga_jual"
                                value="{{ old('harga_jual') }}" id="harga_jual">
                            <div class="input-group-append">
                                <select class="form-select" name="satuan_harga_jual" id="satuan_harga_jual">
                                    <option disabled selected>Pilih Satuan Tarif</option>
                                    <option value="USD">USD</option>
                                    <option value="IDR">IDR</option>
                                </select>
                            </div>
                        </div>
                        @error('harga_jual')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                        @error('satuan_harga_jual')
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

<!-- lihat Penjualan LNG -->
<div class="modal fade" tabindex="-1" id="lihat_jualLNG">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Lihat Penjualan LNG/CNG/BBG</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body">

                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control flatpickr" name="bulan" id="lihat_bulan_penjualan" readonly>
                    @error('bulan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Provinsi</label>
                    <input class="form-control" type="text" name="provinsi" id="lihat_provinsi_penjualan"
                        readonly>
                    @error('provinsi')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Kabupaten / Kota</label>
                    <input class="form-control" type="text" name="kabupaten_kota" id="lihat_kab_penjualan"
                        readonly>
                    @error('kabupaten_kota')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Produk</label>
                    <input class="form-control" type="text" name="produk" id="lihat_produk_penjualan" readonly>
                    @error('produk')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Satuan</label>
                    <input class="form-control" type="text" name="satuan" id="lihat_satuan_penjualan" readonly>
                    @error('satuan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Konsumen</label>
                    <input class="form-control" type="text" id="lihat_konsumen_penjualan" name="konsumen"
                        readonly>
                    @error('konsumen')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Sektor</label>
                    <input class="form-control" type="text" id="lihat_sektor_penjualan" name="sektor" readonly>
                    @error('sektor')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Volume</label>
                    <input class="form-control" type="text" id="lihat_volume_penjualan" name="volume" readonly>
                    @error('volume')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Biaya Kompresi</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="biaya_kompresi"
                            value="{{ old('biaya_kompresi') }}" id="lihat_biaya_kompresi_penjualan" readonly>
                        <div class="input-group-append">
                            <select class="form-select" name="satuan_biaya_kompresi" id="lihat_satuan_biaya_kompresi"
                                disabled>
                                <option disabled selected>Pilih Satuan Tarif</option>
                                <option value="USD">USD</option>
                                <option value="IDR">IDR</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Biaya Penyimpanan</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="biaya_penyimpanan"
                            value="{{ old('biaya_penyimpanan') }}" id="lihat_biaya_penyimpanan_penjualan" readonly>
                        <div class="input-group-append">
                            <select class="form-select" name="satuan_biaya_penyimpanan"
                                id="lihat_satuan_biaya_penyimpanan" disabled>
                                <option disabled selected>Pilih Satuan Tarif</option>
                                <option value="USD">USD</option>
                                <option value="IDR">IDR</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Biaya Pengangkutan</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="biaya_pengangkutan"
                            value="{{ old('biaya_pengangkutan') }}" id="lihat_biaya_pengangkutan_penjualan" readonly>
                        <div class="input-group-append">
                            <select class="form-select" name="satuan_biaya_pengangkutan"
                                id="lihat_satuan_biaya_pengangkutan" disabled>
                                <option disabled selected>Pilih Satuan Tarif</option>
                                <option value="USD">USD</option>
                                <option value="IDR">IDR</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Biaya Niaga</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="biaya_niaga"
                            value="{{ old('biaya_niaga') }}" id="lihat_biaya_niaga_penjualan" readonly>
                        <div class="input-group-append">
                            <select class="form-select" name="satuan_biaya_niaga" disabled
                                id="lihat_satuan_biaya_niaga">
                                <option disabled selected>Pilih Satuan Tarif</option>
                                <option value="USD">USD</option>
                                <option value="IDR">IDR</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Harga Bahan Baku</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="harga_bahan_baku"
                            value="{{ old('harga_bahan_baku') }}" id="lihat_harga_bahan_baku" readonly>
                        <div class="input-group-append">
                            <select class="form-select" name="satuan_harga_bahan_baku" disabled
                                id="lihat_satuan_harga_bahan_baku">
                                <option disabled selected>Pilih Satuan Tarif</option>
                                <option value="USD">USD</option>
                                <option value="IDR">IDR</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Pajak</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="pajak" value="{{ old('pajak') }}"
                            id="lihat_pajak" readonly>
                        <div class="input-group-append">
                            <select class="form-select" name="satuan_pajak" disabled id="lihat_satuan_pajak">
                                <option disabled selected>Pilih Satuan Tarif</option>
                                <option value="USD">USD</option>
                                <option value="IDR">IDR</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Harga Jual</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="harga_jual"
                            value="{{ old('harga_jual') }}" id="lihat_harga_jual" readonly>
                        <div class="input-group-append">
                            <select class="form-select" name="satuan_harga_jual" disabled
                                id="lihat_satuan_harga_jual">
                                <option disabled selected>Pilih Satuan Tarif</option>
                                <option value="USD">USD</option>
                                <option value="IDR">IDR</option>
                            </select>
                        </div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- import Penjualan LNG -->
<div class="modal fade" tabindex="-1" id="excel_jualLNG">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Import Penjualan LNG/CNG/BBG</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/importlngpen') }}" class="form-material m-t-40"
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
                            <a href="{{ url('/storage') }}/template/niagaLNG_Penjualan.xlsx"
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

<!-- input Pasokan LNG -->
<div class="modal fade" tabindex="-1" id="input_pasokanLNG">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Input Pasokan LNG/CNG/BBG</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/simpan_pasokan_lng') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="npwp" value="{{ Auth::user()->npwp }}">
                <input type="hidden" name="id_permohonan" value="{{ $pecah[0] }}">
                <input type="hidden" name="id_sub_page" value="{{ $pecah[2] }}">

                <div class="modal-body">

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control flatpickr" id="bulanx" name="bulan"
                            value="{{ old('bulan') }}">
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <select class="form-select produk name_produk" name="produk" value="{{ old('produk') }}">
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
                        <select class="form-select produk satuan" name="satuan" value="{{ old('satuan') }}">
                            <option>Pilih Satuan</option>
                        </select>
                        @error('satuan')
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
                        <select class="form-select" name="kategori_pemasok">
                            <option>Pilih Kategori</option>
                            <option value="Kilang">Kilang</option>
                            <option value="BU Niaga">BU Niaga</option>
                            <option value="Impor">Impor</option>
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
                        <input class="form-control" type="number" id="example-text-input" name="volume"
                            value="{{ old('volume') }}">
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Harga Gas</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="harga_gas"
                                value="{{ old('harga_gas') }}">
                            <div class="input-group-append">
                                <select class="form-select" name="satuan_harga_gas">
                                    <option disabled selected>Pilih Satuan Tarif</option>
                                    <option value="USD">USD</option>
                                    <option value="IDR">IDR</option>
                                </select>
                            </div>
                        </div>
                        @error('harga_gas')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                        @error('satuan_harga_gas')
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

<!-- edit Pasokan LNG -->
<div class="modal fade" tabindex="-1" id="edit_pasokanLNG">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Edit Harga LNG/CNG/BBG</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/update_pasok_lng') }}" class="form-material"
                enctype="multipart/form-data" id="form_pasok">
                @method('PUT')
                @csrf
                <div class="modal-body">

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control flatpickr" name="bulan" id="bulan_pasok" readonly>
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <select class="form-select" id="produk_pasok" name="produk">
                            <option>Pilih Produk</option>
                            <option value="nilai1">Nilai 1</option>
                        </select>
                        @error('produk')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Satuan</label>
                        <select class="form-select produk satuan" id="satuan_pasok" name="satuan"
                            value="{{ old('satuan') }}">
                            <option>Pilih Satuan</option>
                        </select>
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Nama Pemasok</label>
                        <input class="form-control" type="text" id="nama_pemasok_pasok" name="nama_pemasok"
                            value="{{ old('nama_pemasok') }}">
                        @error('nama_pemasok')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Kategori Pemasok</label>
                        <select class="form-select" name="kategori_pemasok" id="kategori_pemasok_pasok">
                            <option>Pilih Kategori</option>
                            <option value="Kilang">Kilang</option>
                            <option value="BU Niaga">BU Niaga</option>
                            <option value="Impor">Impor</option>
                            <option value="KKKS">KKKS</option>
                        </select>
                        @error('kategori_pemasok')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Volume</label>
                        <input class="form-control" type="number" id="volume_pasok" name="volume"
                            value="{{ old('volume') }}">
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="example-text-input" class="form-label">Harga Gas</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="harga_gas"
                                value="{{ old('harga_gas') }}" id="harga_gas_pasok">
                            <div class="input-group-append">
                                <select class="form-select" name="satuan_harga_gas" id="satuan_harga_gas">
                                    <option disabled selected>Pilih Satuan Tarif</option>
                                    <option value="USD">USD</option>
                                    <option value="IDR">IDR</option>
                                </select>
                            </div>
                        </div>
                        @error('harga_gas')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                        @error('satuan_harga_gas')
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

<!-- lihat Pasokan LNG -->
<div class="modal fade" tabindex="-1" id="lihat_pasokanLNG">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Lihat Pasokan LNG/CNG/BBG</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control flatpickr" id="lihat_bulan_pasok" name="bulan" readonly>
                    @error('bulan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Produk</label>
                    <input class="form-control" type="text" id="lihat_produk_pasok" name="produk" readonly>
                    @error('produk')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Satuan</label>
                    <input class="form-control" type="text" id="lihat_satuan_pasok" name="satuan" readonly>
                    @error('satuan')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Nama Pemasok</label>
                    <input class="form-control" type="text" id="lihat_nama_pemasok_pasok" name="nama_pemasok"
                        value="{{ old('nama_pemasok') }}" readonly>
                    @error('nama_pemasok')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Kategori Pemasok</label>
                    <input class="form-control" type="text" id="lihat_kategori_pemasok_pasok"
                        name="kategori_pemasok" value="{{ old('kategori_pemasok') }}" readonly>

                    @error('kategori_pemasok')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Volume</label>
                    <input class="form-control" type="text" id="lihat_volume_pasok" name="volume"
                        value="{{ old('volume') }}" readonly>
                    @error('volume')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Harga Gas</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="harga_gas" value="{{ old('harga_gas') }}"
                            id="lihat_harga_gas_pasok" readonly>
                        <div class="input-group-append">
                            <select class="form-select" name="satuan_harga_gas" id="lihat_satuan_harga_gas" disabled>
                                <option disabled selected>Pilih Satuan Tarif</option>
                                <option value="USD">USD</option>
                                <option value="IDR">IDR</option>
                            </select>
                        </div>
                    </div>
                    @error('harga_gas')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                    @error('satuan_harga_gas')
                        <div class="form-group has-danger mb-0">
                            <div class="form-control-feedback">{{ $message }}</div>
                        </div>
                    @enderror
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- import Pasokan LNG -->
<div class="modal fade" tabindex="-1" id="excel_pasokanLNG">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Import Pasokan LNG/CNG/BBG</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/importlngpasok') }}" class="form-material m-t-40"
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
                            <a href="{{ url('/storage') }}/template/niagaLNG_Pasokan.xlsx"
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
