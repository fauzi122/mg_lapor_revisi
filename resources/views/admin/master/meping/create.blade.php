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
                    <li class="breadcrumb-item text-muted">Input Izin</li>
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
                                <select class="form-control select20" name="kategori" id="kategori_select" style="width:100%;" required>
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
                            <div class="mb-3">
                                <label class="form-label">Nama Opsi</label>
                                <input type="text" class="form-control" id="nama_opsi_input" name="nama_opsi" placeholder="Nama Opsi otomatis" readonly value="{{ old('nama_opsi') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Id Sub Page</label>
                                <select name="id_sub_page" id="id_sub_page_select" class="form-control select20" style="width:100%;" required>
                                    <option value="">Pilih Jenis Izin</option>
                                </select>
                                @error('id_sub_page')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Menu</label>
                                <select name="nama_menu" id="nama_menu_select" class="form-control select20" style="width:100%;" required>
                                    <option value="">Pilih Nama Menu</option>
                                </select>
                                @error('nama_menu')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Id Template</label>
                                <input type="text" class="form-control" id="id_template_input" name="id_template" placeholder="Id Template otomatis" readonly value="{{ old('id_template') }}">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Url</label>
                                <input type="text" class="form-control" id="url_input" name="url" placeholder="Url otomatis" readonly value="{{ old('url') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Apakah ini memiliki fasilitas booting plants?</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="kusus" id="ya" value="2">
                                    <label class="form-check-label" for="ya">Ya</label>
                                </div>
                                @error('kusus')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
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
$(document).ready(function() {
    // Inisialisasi Select2 untuk semua select dengan class select20
    $('.select20').select2({
        // placeholder: 'Pilih opsi',
        // allowClear: true,
        width: '100%'
    });

    const izinUsahaData = @json($izin_usaha);
    const menuItemsData = @json($menu_items);
    const oldSelectedKategori = "{{ old('kategori', $meping->kategori ?? '') }}";
    const oldSelectedSubPage = "{{ old('id_sub_page', $meping->id_sub_page ?? '') }}";
    const oldSelectedNamaMenu = "{{ old('nama_menu', $meping->nama_menu ?? '') }}";
    const jenisIzinFromServer = "{{ $jenis_izin }}";

    const idTemplateInput = $('#id_template_input');
    const namaOpsiInput = $('#nama_opsi_input');
    const urlInput = $('#url_input');

    function populateJenisIzin(kategoriValue) {
        let kategoriText = kategoriValue === "1" ? "GAS" : kategoriValue === "2" ? "BBM" : "";
        const filtered = izinUsahaData.filter(item => item.jenis === kategoriText && item.kategori_izin == jenisIzinFromServer);

        let $idSubPage = $('#id_sub_page_select');
        $idSubPage.empty().append('<option value="">--Pilih Jenis Izin--</option>');
        filtered.forEach(item => {
            $idSubPage.append(`<option value="${item.id_sub_page}" ${item.id_sub_page==oldSelectedSubPage?'selected':''}>${item.id_sub_page} - ${item.jenis_izin}</option>`);
        });

        if(oldSelectedSubPage) {
            const selected = izinUsahaData.find(i => i.id_sub_page==oldSelectedSubPage);
            if(selected) {
                idTemplateInput.val(selected.id_template || '');
                namaOpsiInput.val(selected.nama_opsi || '');
            }
        }

        populateNamaMenu(kategoriValue);
        $idSubPage.trigger('change.select2'); // Refresh Select2
    }

    function populateNamaMenu(kategoriValue) {
        let kategoriText = kategoriValue === "1" ? "Gas" : kategoriValue === "2" ? "Minyak" : "";
        const filteredMenus = menuItemsData.filter(item => item.kategori.trim().toLowerCase()===kategoriText.toLowerCase() && item.jenis_izin.trim()===jenisIzinFromServer);

        let $namaMenu = $('#nama_menu_select');
        $namaMenu.empty().append('<option value="">--Pilih Nama Menu--</option>');
        filteredMenus.forEach(item => {
            $namaMenu.append(`<option value="${item.nama_menu}" ${item.nama_menu==oldSelectedNamaMenu?'selected':''}>${item.nama_menu}</option>`);
        });
        $namaMenu.trigger('change.select2');
    }

    $('#kategori_select').on('change', function(){
        idTemplateInput.val('');
        namaOpsiInput.val('');
        urlInput.val('');
        populateJenisIzin($(this).val());
    });

    $('#id_sub_page_select').on('change', function(){
        const selectedId = $(this).val();
        const selected = izinUsahaData.find(i => i.id_sub_page==selectedId);
        if(selected){
            idTemplateInput.val(selected.id_template || '');
            namaOpsiInput.val(selected.nama_opsi || '');
        } else {
            idTemplateInput.val('');
            namaOpsiInput.val('');
        }
    });

    $('#nama_menu_select').on('change', function(){
        const selectedNama = $(this).val();
        const selected = menuItemsData.find(i => i.nama_menu===selectedNama && i.jenis_izin.trim()===jenisIzinFromServer);
        if(selected){
            urlInput.val(selected.url || '');
        } else {
            urlInput.val('');
        }
    });

    if(oldSelectedKategori){
        populateJenisIzin(oldSelectedKategori);
    }
});
</script>
@endsection
