<!-- input Pengolahan Gas Bumi [Produksi Kilang] -->
<div class="modal fade" tabindex="-1" id="buat-pengolahan-produksi-gb">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Tambah Pengolahan Gas Bumi [Produksi Kilang]</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/simpan_pengolahan_gas_bumi_produksi') }}"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="npwp" value="{{ Auth::user()->npwp }}">
                <input type="hidden" name="id_permohonan" value="{{ $pecah[0] }}">
                <input type="hidden" name="id_sub_page" value="{{ $pecah[2] }}">

                <div class="modal-body">
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control flatpickr" id="bulanx" name="bulan" value="{{ old('bulan') }}"
                            required>
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <select class="form-select produk name_produk" name="produk" id="name_produk" required>
                            <option value="">Pilih Produk</option>
                        </select>
                        @error('produk')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Satuan</label>
                        <select class="form-select produk satuan" name="satuan" id="satuan" required>
                            <option value="">Pilih Satuan</option>
                        </select>
                        <input class="form-control" type="hidden" id="" name="status" value="0">
                        <input class="form-control" type="hidden" id="" name="catatan" value="-">
                        <input class="form-control" type="hidden" id="" name="petugas" value="jjp">
                        <input class="form-control" type="hidden" id="" name="jenis" value="Gas Bumi">
                        <input class="form-control" type="hidden" id="" name="tipe" value="Produksi">
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Provinsi</label>
                        <select class="form-select provinsi name_provinsi" name="provinsi" id="name_provinsi" required>
                            <option value="">Pilih Provinsi</option>
                        </select>
                        @error('provinsi')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
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
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Volume</label>
                        <input class="form-control" type="number" step="0.01" id="example-text-input"
                            name="volume" value="{{ old('volume') }}" required>
                        @error('volume')
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
</div><!-- /.modal -->

<!-- edit Pengolahan Gas Bumi [Produksi Kilang] -->
<div class="modal fade" tabindex="-1" id="edit-pengolahan-produksi-gb">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Edit Pengolahan Gas Bumi [Produksi Kilang]</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/update_pengolahan_gas_bumi_produksi') }}" class="form-material"
                enctype="multipart/form-data" id="form_updatePengolahanProduksiGB">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="npwp" value="{{ Auth::user()->npwp }}">
                    <input type="hidden" id="id_permohonan" name="id_permohonan" value="">

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control flatpickr" id="bulan_produksi" name="bulan"
                            value="{{ old('bulan') }}" required readonly>
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <select class="form-select produk name_produk" name="produk" id="produk_pengolahanProduksi">
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
                        <select class="form-select produk satuan" name="satuan" id="satuan_pengolahanProduksi"
                            required>
                            <option value="">Pilih Satuan</option>
                        </select>
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Provinsi</label>
                        <select class="form-select provinsi name_provinsi" name="provinsi" id="provinsi_produksi">
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
                        <select class="form-select nama_kota" name="kabupaten_kota" id="nama_kota_pengolahaProduksi"
                            required>
                            <option value="">Pilih Kabupaten / Kota</option>
                        </select>
                        @error('kabupaten_kota')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Volume</label>
                        <input class="form-control" type="number" step="0.01" id="volume_pengolahanProduksi"
                            name="volume">
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
</div><!-- /.modal -->

<!-- lihat Pengolahan Gas Bumi [Produksi Kilang] -->
<div class="modal fade" tabindex="-1" id="lihat-pengolahan-produksi-gb">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Lihat Pengolahan Gas Bumi [Produksi Kilang]</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control lihat_bulan" id="" name="bulan"
                        value="{{ old('bulan') }}" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Produk</label>
                    <input class="form-control lihat_produk" type="text" id="" name="produk"
                        value="" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Satuan</label>
                    <input class="form-control lihat_satuan" type="text" id="" name="satuan"
                        value="" readonly>
                    <input class="form-control lihat_status" type="hidden" id="t" name="status"
                        value="0">
                    <input class="form-control lihat_catatan" type="hidden" id="t" name="catatan"
                        value="-">
                    <input class="form-control lihat_petugas" type="hidden" id="t" name="petugas"
                        value="jjp">
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Provinsi</label>
                    <input class="form-control lihat_provinsi" type="text" id="" name="provinsi"
                        value="" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Kabupaten / Kota</label>
                    <input class="form-control lihat_kabupaten_kota" type="text" id=""
                        name="kabupaten_kota" value="" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Volume</label>
                    <input class="form-control lihat_volume" type="number" id="" name="volume" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->

<!-- import Pengolahan Gas Bumi [Produksi Kilang]  -->
<div class="modal fade" tabindex="-1" id="excelPengolahanGBProduksi">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Import Laporan Pengolahan Gas Bumi [Produksi Kilang]</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/importPengolahanGBProduksi') }}" class="form-material m-t-40"
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
                            <a href="{{ url('/storage') }}/template/pengolahanGasBumi_ProduksiKilang.xlsx"
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
</div><!-- /.modal -->

{{-- ====================================================================================== --}}

<!-- input Pengolahan Gas Bumi [Pasokan Kilang] -->
<div class="modal fade" tabindex="-1" id="buat-pengolahan-pasokan-gb">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Tambah Pengolahan Gas Bumi [Pasokan Kilang]</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/simpan_pengolahan_gas_bumi_pasokan') }}"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="npwp" value="{{ Auth::user()->npwp }}">
                <input type="hidden" name="id_permohonan" value="{{ $pecah[0] }}">
                <input type="hidden" name="id_sub_page" value="{{ $pecah[2] }}">

                <div class="modal-body">
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control flatpickr" id="bulan_pas" name="bulan"
                            value="{{ old('bulan') }}" required>
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Intake Kilang</label>
                        <select class="form-select intake_kilang" name="intake_kilang" required>
                            <option value="">Pilih Intake Kilang</option>
                        </select>
                        @error('intake_kilang')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Satuan</label>
                        <select class="form-select produk satuan" name="satuan" id="satuan" required>
                            <option value="">Pilih Satuan</option>
                        </select>
                        <input class="form-control" type="hidden" id="" name="jenis" value="Gas Bumi">
                        <input class="form-control" type="hidden" id="" name="tipe" value="Pasokan">
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Provinsi</label>
                        <select class="form-select provinsi name_provinsi" name="provinsi" id="name_provinsi"
                            required>
                            <option value="">Pilih Provinsi</option>
                        </select>
                        @error('provinsi')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
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
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Volume</label>
                        <input class="form-control" type="number" step="0.01" id="example-text-input"
                            name="volume" value="{{ old('volume') }}" required>
                        @error('volume')
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
</div><!-- /.modal -->

<!-- edit Pengolahan Gas Bumi [Pasokan Kilang] -->
<div class="modal fade" tabindex="-1" id="edit-pengolahan-pasokan-gb">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Edit Pengolahan Gas Bumi [Pasokan Kilang]</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/update_pengolahan_gas_bumi_pasokan') }}" class="form-material"
                enctype="multipart/form-data" id="form_updatePengolahanPasokanGB">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="npwp" value="{{ Auth::user()->npwp }}">
                    <input type="hidden" id="id_permohonan_pasokan" name="id_permohonan" value="">

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control flatpickr" id="bulan_pasokan" name="bulan"
                            value="{{ old('bulan') }}" required readonly>
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Intake Kilang</label>
                        <select class="form-select intake_kilang" name="intake_kilang" id="intake_kilangPasokan">
                            <option>Pilih Intake Kilang</option>
                        </select>
                        @error('intake_kilang')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Satuan</label>
                        <select class="form-select produk satuan" name="satuan" id="satuan_pengolahanPasokan"
                            required>
                            <option value="">Pilih Satuan</option>
                        </select>
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Provinsi</label>
                        <select class="form-select provinsi name_provinsi" name="provinsi" id="provinsi_pasokan">
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
                        <select class="form-select nama_kota" name="kabupaten_kota" id="nama_kota_pengolahaPasokan"
                            required>
                            <option value="">Pilih Kabupaten / Kota</option>
                        </select>
                        @error('kabupaten_kota')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Volume</label>
                        <input class="form-control" type="number" step="0.01" id="volume_pengolahanPasokan"
                            name="volume">
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
</div><!-- /.modal -->

<!-- lihat Pengolahan Gas Bumi [Pasokan Kilang] -->
<div class="modal fade" tabindex="-1" id="lihat-pengolahan-pasokan-gb">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Lihat Pengolahan Gas Bumi [Pasokan Kilang]</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control lihat_bulan" id="" name="bulan"
                        value="{{ old('bulan') }}" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Intake Kilang</label>
                    <input class="form-control lihat_intake_kilang" type="text" id=""
                        name="intake_kilang" value="" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Satuan</label>
                    <input class="form-control lihat_satuan" type="text" id="" name="satuan"
                        value="" readonly>
                    <input class="form-control lihat_status" type="hidden" id="t" name="status"
                        value="0">
                    <input class="form-control lihat_catatan" type="hidden" id="t" name="catatan"
                        value="-">
                    <input class="form-control lihat_petugas" type="hidden" id="t" name="petugas"
                        value="jjp">
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Provinsi</label>
                    <input class="form-control lihat_provinsi" type="text" id="" name="provinsi"
                        value="" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Kabupaten / Kota</label>
                    <input class="form-control lihat_kabupaten_kota" type="text" id=""
                        name="kabupaten_kota" value="" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Volume</label>
                    <input class="form-control lihat_volume" type="number" id="" name="volume" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->

<!-- import Pengolahan Gas Bumi [Pasokan Kilang]  -->
<div class="modal fade" tabindex="-1" id="excelPengolahanGBPasokan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Import Laporan Pengolahan Gas Bumi [Pasokan Kilang]</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/importPengolahanGBPasokan') }}" class="form-material m-t-40"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_permohonan" value="{{ $pecah[0] }}">
                <input type="hidden" name="id_sub_page" value="{{ $pecah[2] }}">
                <div class="modal-body">
                    <div class="mb-6">
                        <label class="form-label">Bulan </label>
                        <input class="form-control flatpickr" name="bulan" id="bulan_import_pas" required>
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
                            <a href="{{ url('/storage') }}/template/pengolahanGasBumi_PasokanKilang.xlsx"
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
</div><!-- /.modal -->

{{-- ===================================================================================== --}}

<!-- input Pengolahan Gas Bumi [Distribusi Kilang] -->
<div class="modal fade" tabindex="-1" id="buat-pengolahan-distribusi-gb">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Tambah Pengolahan Gas Bumi [Distribusi Kilang]</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/simpan_pengolahan_gas_bumi_distribusi') }}"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="npwp" value="{{ Auth::user()->npwp }}">
                <input type="hidden" name="id_permohonan" value="{{ $pecah[0] }}">
                <input type="hidden" name="id_sub_page" value="{{ $pecah[2] }}">

                <div class="modal-body">
                    <div class="mb-6">
                        <label for="bulan" class="form-label">Bulan</label>
                        <input class="form-control flatpickr" id="bulan_dis" name="bulan"
                            value="{{ old('bulan') }}" required>
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="produk" class="form-label">Produk</label>
                        <select class="form-select produk name_produk" name="produk" id="produk" required>
                            <option value="">Pilih Produk</option>
                        </select>
                        @error('produk')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="satuan" class="form-label">Satuan</label>
                        <select class="form-select produk satuan" name="satuan" id="satuan" required>
                            <option value="">Pilih Satuan</option>
                        </select>
                        <input class="form-control" type="hidden" id="" name="jenis" value="Gas Bumi">
                        <input class="form-control" type="hidden" id="" name="tipe"
                            value="Distribusi">
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="provinsi" class="form-label">Provinsi</label>
                        <select class="form-select provinsi name_provinsi" name="provinsi" id="provinsi" required>
                            <option value="">Pilih Provinsi</option>
                        </select>
                        @error('provinsi')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="kabupaten_kota" class="form-label">Kabupaten / Kota</label>
                        <select class="form-select nama_kota" name="kabupaten_kota" id="kabupaten_kota" required>
                            <option value="">Pilih Kabupaten / Kota</option>
                        </select>
                        @error('kabupaten_kota')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="sektor" class="form-label">Sektor</label>
                        <select class="form-select nama_sektor" name="sektor" value="{{ old('sektor') }}" required>
                            <option>Pilih Sektor</option>
                        </select>
                        @error('sektor')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="volume" class="form-label">Volume</label>
                        <input class="form-control" type="number" step="0.01" id="volume" name="volume"
                            value="{{ old('volume') }}" required>
                        @error('volume')
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
</div><!-- /.modal -->

<!-- edit Pengolahan Gas Bumi [Distribusi Kilang] -->
<div class="modal fade" tabindex="-1" id="edit-pengolahan-distribusi-gb">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Edit Pengolahan Gas Bumi [Distribusi Kilang]</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/update_pengolahan_gas_bumi_distribusi') }}" class="form-material"
                enctype="multipart/form-data" id="form_updatePengolahanDistribusiGB">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="npwp" value="{{ Auth::user()->npwp }}">
                    <input type="hidden" id="id_permohonan_distribusi" name="id_permohonan" value="">

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control flatpickr" id="bulan_distribusi" name="bulan"
                            value="{{ old('bulan') }}" required readonly>
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <select class="form-select produk name_produk" name="produk"
                            id="produk_pengolahanDistribusi">
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
                        <select class="form-select produk satuan" name="satuan" id="satuan_pengolahanDistribusi"
                            required>
                            <option value="">Pilih Satuan</option>
                        </select>
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Provinsi</label>
                        <select class="form-select provinsi name_provinsi" name="provinsi" id="provinsi_distribusi">
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
                        <select class="form-select nama_kota" name="kabupaten_kota"
                            id="nama_kota_pengolahaDistribusi" required>
                            <option value="">Pilih Kabupaten / Kota</option>
                        </select>
                        @error('kabupaten_kota')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="sektor_pengolahanDistribusi" class="form-label">Sektor</label>
                        <select class="form-select nama_sektor" name="sektor" value="{{ old('sektor') }}"
                            id="sektor_pengolahanDistribusi" required>
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
                        <input class="form-control" type="number" step="0.01" id="volume_pengolahanDistribusi"
                            name="volume">
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
</div><!-- /.modal -->

<!-- lihat Pengolahan Gas Bumi [Distribusi Kilang] -->
<div class="modal fade" tabindex="-1" id="lihat-pengolahan-distribusi-gb">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Lihat Pengolahan Gas Bumi [Distribusi Kilang]</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control lihat_bulan" id="" name="bulan"
                        value="{{ old('bulan') }}" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Produk</label>
                    <input class="form-control lihat_produk" type="text" id="" name="produk"
                        value="" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Satuan</label>
                    <input class="form-control lihat_satuan" type="text" id="" name="satuan"
                        value="" readonly>
                    <input class="form-control lihat_status" type="hidden" id="t" name="status"
                        value="0">
                    <input class="form-control lihat_catatan" type="hidden" id="t" name="catatan"
                        value="-">
                    <input class="form-control lihat_petugas" type="hidden" id="t" name="petugas"
                        value="jjp">
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Provinsi</label>
                    <input class="form-control lihat_provinsi" type="text" id="" name="provinsi"
                        value="" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Kabupaten / Kota</label>
                    <input class="form-control lihat_kabupaten_kota" type="text" id=""
                        name="kabupaten_kota" value="" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Sektor</label>
                    <input class="form-control lihat_sektor" type="text" id="" name="sektor" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Volume</label>
                    <input class="form-control lihat_volume" type="number" id="" name="volume" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->

<!-- import Pengolahan Gas Bumi [Distribusi Kilang]  -->
<div class="modal fade" tabindex="-1" id="excelPengolahanGBDistribusi">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Import Laporan Pengolahan Gas Bumi [Distribusi Kilang]</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/importPengolahanGBDistribusi') }}" class="form-material m-t-40"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_permohonan" value="{{ $pecah[0] }}">
                <input type="hidden" name="id_sub_page" value="{{ $pecah[2] }}">
                <div class="modal-body">
                    <div class="mb-6">
                        <label class="form-label">Bulan </label>
                        <input class="form-control flatpickr" name="bulan" id="bulan_import_dis" required>
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
                            <a href="{{ url('/storage') }}/template/pengolahanGasBumi_DistribusiKilang.xlsx"
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
</div><!-- /.modal -->
