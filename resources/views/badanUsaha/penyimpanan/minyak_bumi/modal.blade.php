<!-- input simpan_Penyimpanan Minyak Bumi -->
<div class="modal fade" tabindex="-1" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Penyimpanan Minyak Bumi..</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/simpan_pmb') }}" enctype="multipart/form-data">
                @csrf
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
                        <label class="form-label">Kapasitas Tangki</label>
                        <input class="form-control" type="number" step="0.01" id="" name="kapasitas_tangki"
                            value="{{ old('kapasitas_tangki') }}" required>
                        @error('kapasitas_tangki')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Pengguna</label>
                        <input class="form-control" type="text" id="" name="pengguna"
                            value="{{ old('pengguna') }}" required>
                        @error('pengguna')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Jenis Fasilitas</label>
                        <select class="form-select" name="jenis_fasilitas" id="" required>
                            <option selected disabled>Pilih Jenis Fasilitas</option>
                            <option value="Darat">Darat</option>
                            <option value="Floating Storage">Floating Storage</option>
                        </select>
                        @error('jenis_fasilitas')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Jenis Komoditas</label>
                        <div class="col-lg-12 d-flex flex-wrap gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="minyak_bumi"
                                    name="jenis_komoditas[]" value="Minyak Bumi">
                                <label class="form-check-label" for="minyak_bumi"> Minyak Bumi</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="bbm" name="jenis_komoditas[]"
                                    value="BBM">
                                <label class="form-check-label" for="bbm"> BBM</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="hasil_olahan"
                                    name="jenis_komoditas[]" value="Hasil Olahan">
                                <label class="form-check-label" for="hasil_olahan"> Hasil Olahan</label>
                            </div>
                        </div>
                        @error('jenis_komoditas')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Produk</label>
                        <select class="form-select produk name_produk" name="produk" id="name_produk">
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
                        <label class="form-label">Provinsi</label>
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
                        <label class="form-label">Kabupaten Kota</label>
                        <select class="form-select nama_kota" name="kab_kota" id="nama_kota">
                            <option>Pilih Kab / Kota</option>
                        </select>
                        @error('kab_kota')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Kategori Supplai</label>
                        <select class="form-select" name="kategori_supplai" id="">
                            <option selected disabled>Pilih Kategori Supplai</option>
                            <option value="Domestik">Domestik</option>
                            <option value="Impor">Impor</option>
                        </select>
                        @error('kategori_supplai')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Volume Stok Awal</label>
                        <input class="form-control" type="number" step="0.01" id=""
                            name="volume_stok_awal" value="{{ old('volume_stok_awal') }}" required>
                        @error('volume_stok_awal')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Volume Supply</label>
                        <input class="form-control" type="number" step="0.01" id=""
                            name="volume_supply" value="{{ old('volume_supply') }}" required>
                        @error('volume_supply')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Volume Output</label>
                        <input class="form-control" type="number" step="0.01" id=""
                            name="volume_output" value="{{ old('volume_output') }}" required>
                        @error('volume_output')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Volume Stok Akhir</label>
                        <input class="form-control" type="number" step="0.01" id="volume_stok_akhir"
                            name="volume_stok_akhir" value="{{ old('volume_stok_akhir') }}" required>
                        @error('volume_stok_akhir')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Kapasitas Penyewaan</label>
                        <input class="form-control" type="number" step="0.01" id="kapasitas_penyewaan"
                            name="kapasitas_penyewaan" value="{{ old('kapasitas_penyewaan') }}" required>
                        @error('kapasitas_penyewaan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Dokumen Kontrak Sewa</label>
                        <input class="form-control" type="file" name="kontrak_sewa"
                            value="{{ old('kontrak_sewa') }}" required>
                        @error('kontrak_sewa')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Utilisasi Tangki <span class="text-danger">(%)</span></label>
                        <input class="form-control" type="number" name="utilisasi_tangki"
                            value="{{ old('utilisasi_tangki') }}" id="utilisasi_tangki" min="0"
                            max="100" required readonly>
                        @error('utilisasi_tangki')
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
                                <input class="form-control" type="date" value="{{ old('tanggal_akhir') }}"
                                    name="tanggal_akhir">
                                @error('tanggal_akhir')
                                    <div class="form-group has-danger mb-0">
                                        <div class="form-control-feedback">{{ $message }}</div>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Tarif Penyimpanan</label>
                        <input class="form-control" type="number" step="0.01" name="tarif_penyimpanan"
                            value="{{ old('tarif_penyimpanan') }}" required>
                        @error('tarif_penyimpanan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Satuan Tarif</label>
                        <select class="form-select" name="satuan_tarif" id="">
                            <option selected disabled>Pilih Satuan Tarif</option>
                            <option value="USD">USD</option>
                            <option value="IDR">IDR</option>
                        </select>
                        @error('satuan_tarif')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">keterangan</label>
                        <input class="form-control" type="text" id="" name="keterangan"
                            value="{{ old('keterangan') }}" required>
                        @error('keterangan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Commingle</label>
                        <select class="form-select" name="commingle" id="commingle" required>
                            <option selected disabled>Pilih Commingle</option>
                            <option value="ya">Ya</option>
                            <option value="tidak">Tidak</option>
                        </select>
                        @error('commingle')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        @error('jumlah_bu')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                        @error('nama_penyewa')
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

<!-- edit simpan_Penyimpanan Minyak Bumi -->
<div class="modal fade" tabindex="-1" id="edit-pmb">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Edit Penyimpanan Minyak Bumi</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/update_pmb') }}" class="form-material"
                enctype="multipart/form-data" id="form_pmb">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="npwp" value="1">
                    <input type="hidden" name="id_permohonan" value="1">

                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Bulan</label>
                        <input class="form-control" type="month" id="bulan_pmb" name="bulan"
                            value="{{ old('bulan') }}" readonly>
                        @error('bulan_peb')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">No Tangki</label>
                        <input class="form-control" type="text" id="no_tangki_pmb" name="no_tangki" required>
                        @error('no_tangki')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Kapasitas Tangki</label>
                        <input class="form-control" type="number" step="0.01" id="kapasitas_tangki_pmb"
                            name="kapasitas_tangki" value="{{ old('kapasitas_tangki') }}" required>
                        @error('kapasitas_tangki')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Pengguna</label>
                        <input class="form-control" type="text" id="pengguna_pmb" name="pengguna" required>
                        @error('pengguna')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Jenis Fasilitas</label>
                        <select class="form-select" name="jenis_fasilitas" id="jenis_fasilitas_pmb" required>
                            <option selected disabled>Pilih Jenis Fasilitas</option>
                            <option value="Darat">Darat</option>
                            <option value="Floating Storage">Floating Storage</option>
                        </select>
                        @error('jenis_fasilitas')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Jenis Komoditas</label>
                        <div class="col-lg-12 d-flex flex-wrap gap-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit_minyak_bumi"
                                    name="jenis_komoditas[]" value="Minyak Bumi">
                                <label class="form-check-label" for="edit_minyak_bumi">Minyak Bumi</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit_bbm"
                                    name="jenis_komoditas[]" value="BBM">
                                <label class="form-check-label" for="edit_bbm">BBM</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="edit_hasil_olahan"
                                    name="jenis_komoditas[]" value="Hasil Olahan">
                                <label class="form-check-label" for="edit_hasil_olahan">Hasil Olahan</label>
                            </div>
                        </div>
                        @error('jenis_komoditas')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Produk</label>
                        <select class="form-select produk name_produk" name="produk" id="produk_pmb">
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
                        <select class="form-select produk satuan" name="satuan" id="satuan_pmb">
                            <option>Pilih Satuan</option>
                        </select>
                        @error('satuan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Provinsi</label>
                        <select class="form-select provinsi name_provinsi" name="provinsi" id="provinsi_pmb">
                            <option>Pilih Provinsi</option>
                        </select>
                        @error('provinsi')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Kabupaten Kota</label>
                        <select class="form-select nama_kota" name="kab_kota" id="kab_kota_pmb">
                            <option>Pilih Kab / Kota</option>
                        </select>
                        @error('kab_kota')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Kategori Supplai</label>
                        <select class="form-select" name="kategori_supplai" id="kategori_supplai_pmb">
                            <option selected disabled>Pilih Kategori Supplai</option>
                            <option value="Domestik">Domestik</option>
                            <option value="Impor">Impor</option>
                        </select>
                        @error('kategori_supplai')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Volume Stok Awal</label>
                        <input class="form-control" type="number" step="0.01" id="volume_stok_awal_pmb"
                            name="volume_stok_awal" value="{{ old('volume_stok_awal') }}" required>
                        @error('volume_stok_awal')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Volume Supply</label>
                        <input class="form-control" type="number" step="0.01" id="volume_supply_pmb"
                            name="volume_supply" value="{{ old('volume_supply') }}" required>
                        @error('volume_supply')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Volume Output</label>
                        <input class="form-control" type="number" step="0.01" id="volume_output_pmb"
                            name="volume_output" value="{{ old('volume_output') }}" required>
                        @error('volume_output')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Volume Stok Akhir</label>
                        <input class="form-control" type="number" step="0.01" id="volume_stok_akhir_pmb"
                            name="volume_stok_akhir" value="{{ old('volume_stok_akhir') }}" required>
                        @error('volume_stok_akhir')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Kapasitas Penyewaan</label>
                        <input class="form-control" type="number" step="0.01" id="kapasitas_penyewaan_pmb"
                            name="kapasitas_penyewaan" value="{{ old('kapasitas_penyewaan') }}" required>
                        @error('kapasitas_penyewaan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="example-text-input" class="form-label">Dokumen Kontrak Sewa</label>
                        <input class="form-control" type="file" name="kontrak_sewa" required>
                        @error('kontrak_sewa')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Utilisasi Tangki <span class="text-danger">(%)</span></label>
                        <input class="form-control" type="number" name="utilisasi_tangki"
                            value="{{ old('utilisasi_tangki') }}" id="utilisasi_tangki_pmb" min="0"
                            max="100" required readonly>
                        @error('utilisasi_tangki')
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
                                <input class="form-control" type="date" id="tanggal_awal_pmb" name="tanggal_awal"
                                    value="{{ old('tanggal_awal') }}">
                                @error('tanggal_awal')
                                    <div class="form-group has-danger mb-0">
                                        <div class="form-control-feedback">{{ $message }}</div>
                                    </div>
                                @enderror
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Tanggal Berakhir</label>
                                <input class="form-control" type="date" id="tanggal_akhir_pmb"
                                    value="{{ old('tanggal_akhir') }}" name="tanggal_akhir">
                                @error('tanggal_akhir')
                                    <div class="form-group has-danger mb-0">
                                        <div class="form-control-feedback">{{ $message }}</div>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Tarif Penyimpanan</label>
                        <input class="form-control" type="number" step="0.01" name="tarif_penyimpanan"
                            id="tarif_penyimpanan_pmb" value="{{ old('tarif_penyimpanan') }}" required>
                        @error('tarif_penyimpanan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Satuan Tarif</label>
                        <select class="form-select" name="satuan_tarif" id="satuan_tarif_pmb">
                            <option selected disabled>Pilih Satuan Tarif</option>
                            <option value="USD">USD</option>
                            <option value="IDR">IDR</option>
                        </select>
                        @error('satuan_tarif')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">keterangan</label>
                        <input class="form-control" type="text" id="keterangan_pmb" name="keterangan"
                            value="{{ old('keterangan') }}" required>
                        @error('keterangan')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label class="form-label">Commingle</label>
                        <select class="form-select" name="commingle" id="commingle_pmb" required>
                            <option selected disabled>Pilih Commingle</option>
                            <option value="ya">Ya</option>
                            <option value="tidak">Tidak</option>
                        </select>
                        @error('commingle')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-6">
                        @error('jumlah_bu')
                            <div class="form-group has-danger mb-0">
                                <div class="form-control-feedback">{{ $message }}</div>
                            </div>
                        @enderror
                        @error('nama_penyewa')
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

<!-- lihat pmb -->
<div class="modal fade" tabindex="-1" id="lihat-pmb">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Lihat Penyimpanan Minyak Bumi</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div class="modal-body">
                <div class="mb-6">
                    <label class="form-label">Bulan</label>
                    <input class="form-control" type="month" id="bulan_pmb_lihat" name="bulan"
                        value="{{ old('bulan') }}" readonly>
                </div>
                <div class="mb-6">
                    <label class="form-label">No Tangki</label>
                    <input class="form-control" type="text" id="no_tangki_pmb_lihat" name="no_tangki"
                        value="{{ old('no_tangki') }}" readonly>
                </div>
                <div class="mb-6">
                    <label class="form-label">Kapasitas Tangki</label>
                    <input class="form-control" type="number" id="kapasitas_tangki_pmb_lihat"
                        name="kapasitas_tangki" value="{{ old('kapasitas_tangki') }}" readonly>
                </div>
                <div class="mb-6">
                    <label class="form-label">Pengguna</label>
                    <input class="form-control" type="text" id="pengguna_pmb_lihat" name="pengguna" readonly>
                </div>
                <div class="mb-6">
                    <label class="form-label">Jenis Fasilitas</label>
                    <input class="form-control" type="text" id="jenis_fasilitas_pmb_lihat" name="jenis_fasilitas"
                        value="{{ old('jenis_fasilitas') }}" readonly>
                </div>
                <div class="mb-6">
                    <label class="form-label">Jenis Komoditas</label>
                    <div class="col-lg-12 d-flex flex-wrap gap-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="lihat_minyak_bumi"
                                name="jenis_komoditas[]" value="Minyak Bumi" disabled>
                            <label class="form-check-label" for="minyak_bumi"> Minyak Bumi</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="lihat_bbm" name="jenis_komoditas[]"
                                value="BBM" disabled>
                            <label class="form-check-label" for="bbm"> BBM</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="lihat_hasil_olahan"
                                name="jenis_komoditas[]" value="Hasil Olahan" disabled>
                            <label class="form-check-label" for="hasil_olahan"> Hasil Olahan</label>
                        </div>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="form-label">Produk</label>
                    <input class="form-control" type="text" id="produk_pmb_lihat" name="produk"
                        value="{{ old('produk') }}" readonly>
                </div>
                <div class="mb-6">
                    <label class="form-label">Satuan</label>
                    <input class="form-control" type="text" id="satuan_pmb_lihat" name="satuan"
                        value="{{ old('satuan') }}" readonly>
                </div>
                <div class="mb-6">
                    <label class="form-label">Provinsi</label>
                    <input class="form-control" type="text" id="provinsi_pmb_lihat" name="provinisi" readonly>
                </div>
                <div class="mb-6">
                    <label class="form-label">Kabupaten Kota</label>
                    <input class="form-control" type="text" id="kab_kota_pmb_lihat" name="kab_kota" readonly>
                </div>
                <div class="mb-6">
                    <label class="form-label">Kategori Supplai</label>
                    <input class="form-control" type="text" id="kategori_supplai_pmb_lihat"
                        name="kategori_supplai" readonly>
                </div>
                <div class="mb-6">
                    <label class="form-label">Volume Stok Awal</label>
                    <input class="form-control" type="text" id="volume_stok_awal_pmb_lihat"
                        name="volume_stok_awal" readonly>
                </div>
                <div class="mb-6">
                    <label class="form-label">Volume Supply</label>
                    <input class="form-control" type="text" id="volume_supply_pmb_lihat" name="volume_supply"
                        readonly>
                </div>
                <div class="mb-6">
                    <label class="form-label">Volume Output</label>
                    <input class="form-control" type="text" id="volume_output_pmb_lihat" name="volume_output"
                        readonly>
                </div>
                <div class="mb-6">
                    <label class="form-label">Volume Stok Akhir</label>
                    <input class="form-control" type="text" id="volume_stok_akhir_pmb_lihat"
                        name="volume_stok_akhir" readonly>
                </div>
                <div class="mb-6">
                    <label class="form-label">Kapasitas Penyewaan</label>
                    <input class="form-control" type="number" id="kapasitas_penyewaan_pmb_lihat"
                        name="kapasitas_penyewaan" value="{{ old('kapasitas_penyewaan') }}" readonly>
                </div>
                <div class="mb-6">
                    <label class="form-label">Dokumen Kontrak Sewa</label>
                    <input class="form-control" type="file" name="kontrak_sewa"
                        value="{{ old('kontrak_sewa') }}" readonly>
                </div>
                <div class="mb-6">
                    <label class="form-label">Utilisasi Tangki <span class="text-danger">(%)</span></label>
                    <input class="form-control" type="number" name="utilisasi_tangki"
                        value="{{ old('utilisasi_tangki') }}" id="utilisasi_tangki_pmb_lihat" min="0"
                        max="100" readonly>
                </div>
                <div class="mb-6">
                    <label class="form-label">Jangka Waktu Penggunaan</label>
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Tanggal Awal</label>
                            <input class="form-control" type="date" name="tanggal_awal"
                                id="tanggal_awal_pmb_lihat" value="{{ old('tanggal_awal') }}" readonly>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Tanggal Berakhir</label>
                            <input class="form-control" type="date" value="{{ old('tanggal_akhir') }}"
                                name="tanggal_akhir" id="tanggal_akhir_pmb_lihat" readonly>
                        </div>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="form-label">Tarif Penyimpanan</label>
                    <input class="form-control" type="text" id="tarif_penyimpanan_pmb_lihat"
                        name="tarif_penyimpanan" readonly>
                </div>
                <div class="mb-6">
                    <label class="form-label">Satuan Tarif</label>
                    <input class="form-control" type="text" id="satuan_tarif_pmb_lihat" name="satuan_tarif"
                        readonly>
                </div>
                <div class="mb-6">
                    <label class="form-label">keterangan</label>
                    <input class="form-control" type="text" id="keterangan_pmb_lihat" name="keterangan" readonly>
                </div>
                <div class="mb-6">
                    <label class="form-label">Commingle</label>
                    <input class="form-control" id="commingle_pmb_lihat" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- import simpan_pmb -->
<div class="modal fade" tabindex="-1" id="excelpmb">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">Import Penyimpanan Minyak Bumi..</h5>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <form method="post" action="{{ url('/import_pmb') }}" class="form-material m-t-40"
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
                            <a href="{{ url('/storage') }}/template/penyimpananMinyakBumi.xlsx"
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
