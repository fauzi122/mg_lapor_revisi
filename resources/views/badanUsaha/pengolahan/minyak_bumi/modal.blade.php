<!-- input Pengolahan Minyak Bumi [Produksi Kilang] -->
<div class="modal fade" tabindex="-1" id="buat-pengolahan-produksi-mb">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Tambah Pengolahan Minyak Bumi [Produksi Kilang]</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/simpan_pengolahan_minyak_bumi_produksi') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="badan_usaha_id" value="{{ Auth::user()->badan_usaha_id }}">
                <input type="hidden" name="izin_id" value="{{ $pecah[0] }}">

                <div class="modal-body">
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="month" id="bulanx" name="bulan" value="{{ old('bulan') }}" required>
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
                        <input class="form-control" type="hidden" id="" name="jenis" value="Minyak Bumi">
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
                        <input class="form-control" type="number" step="0.01" id="example-text-input" name="volume" value="{{ old('volume') }}" required>
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Keterangan</label>
                        <input class="form-control" type="text" id="example-text-input" name="keterangan" value="{{ old('keterangan') }}" required>
                        @error('keterangan')
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

<!-- edit Pengolahan Minyak Bumi [Produksi Kilang] -->
<div class="modal fade" tabindex="-1" id="edit-pengolahan-produksi-mb">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Edit Pengolahan Minyak Bumi [Produksi Kilang]</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/update_pengolahan_minyak_bumi_produksi') }}" class="form-material" enctype="multipart/form-data" id="form_updatePengolahanProduksiMB">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="badan_usaha_id" value="{{ Auth::user()->badan_usaha_id }}">
                    {{-- <input type="hidden" id="izin_id" name="izin_id" value=""> --}}

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="month" id="bulan_produksi" name="bulan" value="{{ old('bulan') }}" required readonly>
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
                        <select class="form-select produk satuan" name="satuan" id="satuan_pengolahanProduksi" required>
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
                        <select class="form-select nama_kota" name="kabupaten_kota" id="nama_kota_pengolahaProduksi" required>
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
                        <input class="form-control" type="number" step="0.01" id="volume_pengolahanProduksi" name="volume">
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Keterangan</label>
                        <input class="form-control" type="text" id="keterangan_pengolahanProduksi" name="keterangan">
                        @error('keterangan')
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

<!-- lihat Pengolahan Minyak Bumi [Produksi Kilang] -->
<div class="modal fade" tabindex="-1" id="lihat-pengolahan-produksi-mb">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Lihat Pengolahan Minyak Bumi [Produksi Kilang]</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control lihat_bulan" type="month" id="" name="bulan" value="{{ old('bulan') }}" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Produk</label>
                    <input class="form-control lihat_produk" type="text" id="" name="produk" value="" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Satuan</label>
                    <input class="form-control lihat_satuan" type="text" id="" name="satuan" value="" readonly>
                    <input class="form-control lihat_status" type="hidden" id="t" name="status" value="0">
                    <input class="form-control lihat_catatan" type="hidden" id="t" name="catatan" value="-">
                    <input class="form-control lihat_petugas" type="hidden" id="t" name="petugas" value="jjp">
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Provinsi</label>
                    <input class="form-control lihat_provinsi" type="text" id="" name="provinsi" value="" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Kabupaten / Kota</label>
                    <input class="form-control lihat_kabupaten_kota" type="text" id="" name="kabupaten_kota" value="" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Volume</label>
                    <input class="form-control lihat_volume" type="number" id="" name="volume" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Keterangan</label>
                    <input class="form-control lihat_keterangan" type="text" id="" name="keterangan" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->

<!-- import Pengolahan Minyak Bumi [Produksi Kilang]  -->
<div class="modal fade" tabindex="-1" id="excelPengolahanMBProduksi">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Import Laporan Pengolahan Minyak Bumi [Produksi Kilang]</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/importPengolahanMBProduksi') }}" class="form-material m-t-40" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="izin_id" value="{{ $pecah[0] }}">
                <div class="modal-body">
                    <div class="mb-6">
                        <label class="form-label">Bulan </label>
                        <input class="form-control" type="month" name="bulan" id="bulan_import" required>
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
                            <a href="{{ url('/storage') }}/template/pengolahanMinyakBumi_ProduksiKilang.xlsx" class="btn btn-success">Download Template</a>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <button type="button" class="btn btn-outline btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>                
            </form>
        </div>
    </div>
</div><!-- /.modal -->

{{-- ======================================================================================== --}}

<!-- input Pengolahan Minyak Bumi [Pasokan Kilang] -->
<div class="modal fade" tabindex="-1" id="buat-pengolahan-pasokan-mb">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Tambah Pengolahan Minyak Bumi [Pasokan Kilang]</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/simpan_pengolahan_minyak_bumi_pasokan') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="badan_usaha_id" value="{{ Auth::user()->badan_usaha_id }}">
                <input type="hidden" name="izin_id" value="{{ $pecah[0] }}">

                <div class="modal-body">
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="month" id="bulan_pas" name="bulan" value="{{ old('bulan') }}" required>
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Kategori Pemasok</label>
                        <select class="form-select" name="kategori_pemasok" required>
                            <option value="">Pilih Kategori Pemasok</option>
                            <option value="Domestik">Domestik</option>
                            <option value="Impor">Impor</option>
                        </select>
                        @error('kategori_pemasok')
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
                        <input class="form-control" type="hidden" id="" name="jenis" value="Minyak Bumi">
                        <input class="form-control" type="hidden" id="" name="tipe" value="Pasokan">
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
                        <label for="kabupaten_kota" class="form-label">Kabupaten / Kota</label>
                        <select class="form-select nama_kota" name="kabupaten_kota[]" id="kabupaten_kota" placeholder="This is a placeholder" multiple>
                        </select>
                        @error('kabupaten_kota')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Volume</label>
                        <input class="form-control" type="number" step="0.01" id="example-text-input" name="volume" value="{{ old('volume') }}" required>
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Keterangan</label>
                        <input class="form-control" type="text" id="example-text-input" name="keterangan" value="{{ old('keterangan') }}" required>
                        @error('keterangan')
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

<!-- edit Pengolahan Minyak Bumi [Pasokan Kilang] -->
<div class="modal fade" tabindex="-1" id="edit-pengolahan-pasokan-mb">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Edit Pengolahan Minyak Bumi [Pasokan Kilang]</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/update_pengolahan_minyak_bumi_pasokan') }}" class="form-material" enctype="multipart/form-data" id="form_updatePengolahanPasokanMB">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="badan_usaha_id" value="{{ Auth::user()->badan_usaha_id }}">
                    {{-- <input type="hidden" id="izin_id_pasokan" name="izin_id" value=""> --}}

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="month" id="bulan_pasokan" name="bulan" value="{{ old('bulan') }}" required readonly>
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Kategori Pemasok</label>
                        <select class="form-select" name="kategori_pemasok" id="kategori_pemasokPasokan">
                            <option value="">Pilih Kategori Pemasok</option>
                            <option value="Domestik">Domestik</option>
                            <option value="Impor">Impor</option>
                        </select>
                        @error('kategori_pemasok')
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
                        <select class="form-select produk satuan" name="satuan" id="satuan_pengolahanPasokan" required>
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
                        <select class="form-select nama_kota" name="kabupaten_kota" id="nama_kota_pengolahaPasokan" required>
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
                        <input class="form-control" type="number" step="0.01" id="volume_pengolahanPasokan" name="volume">
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Keterangan</label>
                        <input class="form-control" type="text" id="keterangan_pengolahanPasokan" name="keterangan">
                        @error('keterangan')
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

<!-- lihat Pengolahan Minyak Bumi [Pasokan Kilang] -->
<div class="modal fade" tabindex="-1" id="lihat-pengolahan-pasokan-mb">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Lihat Pengolahan Minyak Bumi [Pasokan Kilang]</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control lihat_bulan" type="month" id="" name="bulan" value="{{ old('bulan') }}" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Kategori Pemasok</label>
                    <input class="form-control lihat_kategori_pemasok" type="text" id="" name="kategori_pemasok" value="" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Intake Kilang</label>
                    <input class="form-control lihat_intake_kilang" type="text" id="" name="intake_kilang" value="" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Satuan</label>
                    <input class="form-control lihat_satuan" type="text" id="" name="satuan" value="" readonly>
                    <input class="form-control lihat_status" type="hidden" id="t" name="status" value="0">
                    <input class="form-control lihat_catatan" type="hidden" id="t" name="catatan" value="-">
                    <input class="form-control lihat_petugas" type="hidden" id="t" name="petugas" value="jjp">
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Provinsi</label>
                    <input class="form-control lihat_provinsi" type="text" id="" name="provinsi" value="" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Kabupaten / Kota</label>
                    <input class="form-control lihat_kabupaten_kota" type="text" id="" name="kabupaten_kota" value="" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Volume</label>
                    <input class="form-control lihat_volume" type="number" id="" name="volume" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Keterangan</label>
                    <input class="form-control lihat_keterangan" type="text" id="" name="keterangan" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->

<!-- import Pengolahan Minyak Bumi [Pasokan Kilang]  -->
<div class="modal fade" tabindex="-1" id="excelPengolahanMBPasokan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Import Laporan Pengolahan Minyak Bumi [Pasokan Kilang]</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/importPengolahanMBPasokan') }}" class="form-material m-t-40" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="izin_id" value="{{ $pecah[0] }}">
                <div class="modal-body">
                    <div class="mb-6">
                        <label class="form-label">Bulan </label>
                        <input class="form-control" type="month" name="bulan" id="bulan_import_pas" required>
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
                            <a href="{{ url('/storage') }}/template/pengolahanMinyakBumi_PasokanKilang.xlsx" class="btn btn-success">Download Template</a>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <button type="button" class="btn btn-outline btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>                
            </form>
        </div>
    </div>
</div><!-- /.modal -->

{{-- ==================================================================================== --}}
<!-- input Pengolahan Minyak Bumi [Distribusi Kilang] -->
<div class="modal fade" tabindex="-1" id="buat-pengolahan-distribusi-mb">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Tambah Pengolahan Minyak Bumi [Distribusi Kilang]</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/simpan_pengolahan_minyak_bumi_distribusi') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="badan_usaha_id" value="{{ Auth::user()->badan_usaha_id }}">
                <input type="hidden" name="izin_id" value="{{ $pecah[0] }}">

                <div class="modal-body">
                    <div class="mb-6">
                        <label for="bulan" class="form-label">Bulan</label>
                        <input class="form-control" type="month" id="bulan_dis" name="bulan" value="{{ old('bulan') }}" required>
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
                        <input class="form-control" type="hidden" id="" name="jenis"
                            value="Minyak Bumi">
                        <input class="form-control" type="hidden" id="" name="tipe" value="Distribusi">
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
                        <input class="form-control" type="number" step="0.01" id="volume" name="volume" value="{{ old('volume') }}" required>
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input class="form-control" type="text" id="keterangan" name="keterangan" value="{{ old('keterangan') }}" required>
                        @error('keterangan')
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

<!-- edit Pengolahan Minyak Bumi [Distribusi Kilang] -->
<div class="modal fade" tabindex="-1" id="edit-pengolahan-distribusi-mb">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Edit Pengolahan Minyak Bumi [Pasokan Kilang]</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/update_pengolahan_minyak_bumi_distribusi') }}" class="form-material" enctype="multipart/form-data" id="form_updatePengolahanDistribusiMB">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="badan_usaha_id" value="{{ Auth::user()->badan_usaha_id }}">
                    {{-- <input type="hidden" id="izin_id_distribusi" name="izin_id" value=""> --}}

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="month" id="bulan_distribusi" name="bulan" value="{{ old('bulan') }}" required readonly>
                        @error('bulan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Produk</label>
                        <select class="form-select produk name_produk" name="produk" id="produk_pengolahanDistribusi">
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
                        <select class="form-select produk satuan" name="satuan" id="satuan_pengolahanDistribusi" required>
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
                        <select class="form-select nama_kota" name="kabupaten_kota" id="nama_kota_pengolahaDistribusi" required>
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
                        <select class="form-select nama_sektor" name="sektor" value="{{ old('sektor') }}" id="sektor_pengolahanDistribusi" required>
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
                        <input class="form-control" type="number" step="0.01" id="volume_pengolahanDistribusi" name="volume">
                        @error('volume')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Keterangan</label>
                        <input class="form-control" type="text" id="keterangan_pengolahanDistribusi" name="keterangan">
                        @error('keterangan')
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

<!-- lihat Pengolahan Minyak Bumi [Distribusi Kilang] -->
<div class="modal fade" tabindex="-1" id="lihat-pengolahan-distribusi-mb">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Lihat Pengolahan Minyak Bumi [Distribusi Kilang]</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Bulan</label>
                    <input class="form-control lihat_bulan" type="month" id="" name="bulan" value="{{ old('bulan') }}" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Produk</label>
                    <input class="form-control lihat_produk" type="text" id="" name="produk" value="" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Satuan</label>
                    <input class="form-control lihat_satuan" type="text" id="" name="satuan" value="" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Provinsi</label>
                    <input class="form-control lihat_provinsi" type="text" id="" name="provinsi" value="" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Kabupaten / Kota</label>
                    <input class="form-control lihat_kabupaten_kota" type="text" id="" name="kabupaten_kota" value="" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Sektor</label>
                    <input class="form-control lihat_sektor" type="text" id="" name="sektor" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Volume</label>
                    <input class="form-control lihat_volume" type="number" id="" name="volume" readonly>
                </div>
                <div class="mb-6">
                    <label for="example-text-input" class="form-label">Keterangan</label>
                    <input class="form-control lihat_keterangan" type="text" id="" name="keterangan" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->

<!-- import Pengolahan Minyak Bumi [Distribusi Kilang]  -->
<div class="modal fade" tabindex="-1" id="excelPengolahanMBDistribusi">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Import Laporan Pengolahan Minyak Bumi [Distribusi Kilang]</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/importPengolahanMBDistribusi') }}" class="form-material m-t-40" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="izin_id" value="{{ $pecah[0] }}">
                <div class="modal-body">
                    <div class="mb-6">
                        <label class="form-label">Bulan </label>
                        <input class="form-control" type="month" name="bulan" id="bulan_import_dis" required>
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
                            <a href="{{ url('/storage') }}/template/pengolahanMinyakBumi_DistribusiKilang.xlsx" class="btn btn-success">Download Template</a>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <button type="button" class="btn btn-outline btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>                
            </form>
        </div>
    </div>
</div><!-- /.modal -->
