@extends('layouts.blackand.app')

@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h3 class="text-dark fw-bold">Input Izin</h3>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ url('/master') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Master Data</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="#" class="text-muted text-hover-primary">Jenis Izin</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <li class="breadcrumb-item text-muted">Input Izin</li>
                    </li>
                    
                </ul>
            </div>
        </div>
    </div>
</div>

<div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="card mb-5 mb-xl-8 shadow">
            <div class="card-body p-4">
                <form method="post" action="{{ url('/master/meping/izin') }}" class="form-material m-t-40" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_induk_izin" value="{{ $id }}">
                    <input type="hidden" name="jenis_izin" value="{{ $jenis_izin }}">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Kategori</label>
                                <select
                                    class="form-control select20 mb-2"
                                    style="width: 100%;"
                                    name="kategori"
                                    id="kategori_select"
                                    required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="1" {{ old('kategori', $meping->kategori ?? '') == '1' ? 'selected' : '' }}>Gas</option>
                                    <option value="2" {{ old('kategori', $meping->kategori ?? '') == '2' ? 'selected' : '' }}>Minyak</option>
                                </select>
                                @error('kategori')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div>
                                <div class="mb-3">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Nama Opsi</label>
                                    <input class="form-control form-control-solid" id="nama_opsi_input" placeholder="Nama Opsi dari izin usaha otomatis" type="text" name="nama_opsi" value="{{ old('nama_opsi') }}" readonly>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Id Sub Page</label>
                                <select name="id_sub_page" id="id_sub_page_select" class="form-control" required>
                                    <option value="">Pilih Jenis Izin</option>
                                </select>
                                @error('id_sub_page')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>   
                        
                
                        <div class="col-lg-6">
                            <div class="mt-3 mt-lg-0">
                                <div class="mb-3">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Nama Menu</label>
                                    <select class="form-control form-control-solid" name="nama_menu" id="nama_menu_select" required>
                                        <option value="">Pilih Nama Menu</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="mt-3 mt-lg-0">
                                <div class="mb-3">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Id Template</label>
                                    <input class="form-control form-control-solid" id="id_template_input" placeholder="Id Template dari table izin usaha otomatis" type="text" name="id_template" value="{{ old('id_template') }}" readonly>
                                </div>
                            </div>
                        </div>

                        
                
                        <div class="col-lg-6">
                            <div class="mt-3 mt-lg-0">
                                <div class="mb-3">
                                    <label class="d-flex align-items-center fs-6 fw-semibold mb-2">Url</label>
                                    <input class="form-control form-control-solid" placeholder="Url Dari Table Menu Item otomatis" type="text" name="url" value="{{ old('url') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary w-md">Submit</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    const izinUsahaData = @json($izin_usaha);
    const menuItemsData = @json($menu_items);
    const oldSelectedKategori = "{{ old('kategori', $meping->kategori ?? '') }}";
    const oldSelectedSubPage = "{{ old('id_sub_page', $meping->id_sub_page ?? '') }}";
    const oldSelectedNamaMenu = "{{ old('nama_menu', $meping->nama_menu ?? '') }}";
    const jenisIzinFromServer = "{{ $jenis_izin }}"; // dari URL hidden input

    document.addEventListener("DOMContentLoaded", function () {
        const kategoriSelect = document.getElementById('kategori_select');
        const idSubPageSelect = document.getElementById('id_sub_page_select');
        const idTemplateInput = document.getElementById('id_template_input');
        const namaOpsiInput = document.getElementById('nama_opsi_input');
        const namaMenuSelect = document.getElementById('nama_menu_select');
        const urlInput = document.querySelector('input[name="url"]');

        function populateJenisIzin(kategoriValue) {
            const kategoriText = kategoriValue === "1" ? "GAS" :
                                 kategoriValue === "2" ? "BBM" : "";

            idSubPageSelect.innerHTML = '<option value="">Pilih Jenis Izin</option>';

            const filtered = izinUsahaData.filter(item => item.jenis === kategoriText);

            filtered.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id_sub_page;
                option.textContent = `${item.id_sub_page} - ${item.jenis_izin}`;
                if (item.id_sub_page == oldSelectedSubPage) {
                    option.selected = true;
                }
                idSubPageSelect.appendChild(option);
            });

            if (oldSelectedSubPage) {
                const selectedIzin = izinUsahaData.find(item => item.id_sub_page == oldSelectedSubPage);
                if (selectedIzin) {
                    idTemplateInput.value = selectedIzin.id_template || '';
                    namaOpsiInput.value = selectedIzin.nama_opsi || '';
                }
            }

            // Panggil update Nama Menu juga
            populateNamaMenu(kategoriValue);
        }

        function populateNamaMenu(kategoriValue) {
            const kategoriText = kategoriValue === "1" ? "Gas" :
                                 kategoriValue === "2" ? "Minyak" : "";

            namaMenuSelect.innerHTML = '<option value="">Pilih Nama Menu</option>';

            const filteredMenus = menuItemsData.filter(item =>
                item.kategori.trim().toLowerCase() === kategoriText.toLowerCase() &&
                item.jenis_izin.trim() === jenisIzinFromServer
            );

            filteredMenus.forEach(item => {
                const option = document.createElement('option');
                option.value = item.nama_menu;
                option.textContent = item.nama_menu;
                if (item.nama_menu == oldSelectedNamaMenu) {
                    option.selected = true;
                }
                namaMenuSelect.appendChild(option);
            });
        }

        kategoriSelect.addEventListener('change', function () {
            populateJenisIzin(this.value);
            idTemplateInput.value = '';
            namaOpsiInput.value = '';
            urlInput.value = '';
        });

        idSubPageSelect.addEventListener('change', function () {
            const selectedIdSubPage = this.value;
            const selectedIzin = izinUsahaData.find(item => item.id_sub_page == selectedIdSubPage);

            if (selectedIzin) {
                idTemplateInput.value = selectedIzin.id_template || '';
                namaOpsiInput.value = selectedIzin.nama_opsi || '';
            } else {
                idTemplateInput.value = '';
                namaOpsiInput.value = '';
            }
        });

        namaMenuSelect.addEventListener('change', function () {
            const selected = menuItemsData.find(item =>
                item.nama_menu === this.value &&
                item.jenis_izin.trim() === jenisIzinFromServer
            );

            if (selected) {
                urlInput.value = selected.url || '';
            } else {
                urlInput.value = '';
            }
        });

        // Inisialisasi saat halaman pertama kali dimuat
        if (oldSelectedKategori) {
            populateJenisIzin(oldSelectedKategori);
        }
    });
</script>
@endsection
