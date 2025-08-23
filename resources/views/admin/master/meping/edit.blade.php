@extends('layouts.blackand.app')

@section('content')
<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h3 class="text-dark fw-bold">Edit Izin</h3>
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
                    <li class="breadcrumb-item text-muted">Jenis Izin</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Edit Izin</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div id="kt_app_content" class="app-content flex-column-fluid mt-n5">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="card mb-5 mb-xl-8 shadow">
            <div class="card-body p-4">
                <form method="POST" action="{{ url('/master/meping/izin/' . $meping->id) }}" class="form-material m-t-40" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_induk_izin" value="{{ $meping->id_induk_izin }}">
                    <input type="hidden" name="jenis_izin" value="{{ $meping->jenis_izin }}">
                    <input type="hidden" name="kategori" value="{{ $meping->kategori }}">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Kategori</label>
                                <select class="form-control select20 mb-2" id="kategori_select" disabled>
                                    <option value="1" {{ $meping->kategori == '1' ? 'selected' : '' }}>Gas</option>
                                    <option value="2" {{ $meping->kategori == '2' ? 'selected' : '' }}>Minyak</option>
                                </select>
                                @error('kategori')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Opsi</label>
                                <input type="text" class="form-control" id="nama_opsi_input" name="nama_opsi" readonly value="{{ old('nama_opsi', $meping->nama_opsi) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Id Sub Page</label>
                                <select name="id_sub_page" id="id_sub_page_select" class="form-control select20" style="width:100%;" required>
                                    <option value="">--Pilih Jenis Izin--</option>
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
                                    <option value="">--Pilih Nama Menu--</option>
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
                                <input type="text" class="form-control" id="id_template_input" name="id_template" readonly value="{{ old('id_template', $meping->id_template) }}">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Url</label>
                                <input type="text" class="form-control" id="url_input" name="url" readonly value="{{ old('url', $meping->url) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Apakah ini memiliki fasilitas booting plants?</label>

                                <!-- default kalau ga dicentang -->
                                <input type="hidden" name="kusus" value="0">

                                <div class="form-check">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        name="kusus" 
                                        id="ya" 
                                        value="2"
                                        {{ old('kusus', $meping->kusus) == 2 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="ya">Ya</label>
                                </div>

                                @error('kusus')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>



                    <div class="mt-4">
                        <button type="submit" class="btn btn-warning w-md">Update</button>
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
    // Inisialisasi Select2
    $('.select20').select2({
        placeholder: 'Pilih opsi',
        width: '100%'
    });

    const izinUsahaData = @json($izin_usaha);
    const menuItemsData = @json($menu_items);
    const oldSelectedSubPage = "{{ old('id_sub_page', $meping->id_sub_page) }}";
    const oldSelectedNamaMenu = "{{ old('nama_menu', $meping->nama_menu) }}";
    const jenisIzinFromServer = "{{ $meping->jenis_izin }}";
    const kategori = "{{ $meping->kategori }}";

    const $idSubPage = $('#id_sub_page_select');
    const $namaMenu = $('#nama_menu_select');
    const $idTemplate = $('#id_template_input');
    const $namaOpsi = $('#nama_opsi_input');
    const $url = $('#url_input');

    function populateJenisIzin() {
        const kategoriText = kategori === "1" ? "GAS" : "BBM";
        $idSubPage.empty().append('<option value="">--Pilih Jenis Izin--</option>');

        izinUsahaData.filter(item => item.jenis === kategoriText && item.kategori_izin == jenisIzinFromServer)
            .forEach(item => {
                $idSubPage.append(`<option value="${item.id_sub_page}" ${item.id_sub_page==oldSelectedSubPage?'selected':''}>${item.id_sub_page} - ${item.jenis_izin}</option>`);
            });
        $idSubPage.trigger('change.select2');

        if(oldSelectedSubPage){
            const selected = izinUsahaData.find(i => i.id_sub_page==oldSelectedSubPage);
            if(selected){
                $idTemplate.val(selected.id_template || '');
                $namaOpsi.val(selected.nama_opsi || '');
            }
        }

        populateNamaMenu();
    }

    function populateNamaMenu() {
        const kategoriText = kategori === "1" ? "Gas" : "Minyak";
        $namaMenu.empty().append('<option value="">--Pilih Nama Menu--</option>');

        menuItemsData.filter(item => item.kategori.trim().toLowerCase() === kategoriText.toLowerCase() && item.jenis_izin.trim()===jenisIzinFromServer)
            .forEach(item => {
                $namaMenu.append(`<option value="${item.nama_menu}" ${item.nama_menu==oldSelectedNamaMenu?'selected':''}>${item.nama_menu}</option>`);
            });
        $namaMenu.trigger('change.select2');

        if(oldSelectedNamaMenu){
            const selected = menuItemsData.find(i => i.nama_menu===oldSelectedNamaMenu && i.jenis_izin.trim()===jenisIzinFromServer);
            if(selected) $url.val(selected.url || '');
        }
    }

    $idSubPage.on('change', function(){
        const selected = izinUsahaData.find(i => i.id_sub_page==$(this).val());
        if(selected){
            $idTemplate.val(selected.id_template || '');
            $namaOpsi.val(selected.nama_opsi || '');
        } else {
            $idTemplate.val('');
            $namaOpsi.val('');
        }
    });

    $namaMenu.on('change', function(){
        const selected = menuItemsData.find(i => i.nama_menu==$(this).val() && i.jenis_izin.trim()===jenisIzinFromServer);
        $url.val(selected ? selected.url || '' : '');
    });

    populateJenisIzin();
});
</script>
@endsection
