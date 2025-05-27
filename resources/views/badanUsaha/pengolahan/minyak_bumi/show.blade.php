@extends('layouts.main.master')
@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-4 py-lg-8">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack flex-wrap">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                <h3 class="text-dark fw-bold">Laporan Pengolahan Minyak Bumi/Hasil Olahan</h3>
            </div>
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="javascript:history.back()" type="button" class="btn btn-sm btn-secondary">
                    <i class="ki-duotone ki-left-square">
                        <span class="path1"></span><span class="path2"></span>
                    </i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>

@include('badanUsaha.pengolahan.minyak_bumi.modal')

@endsection