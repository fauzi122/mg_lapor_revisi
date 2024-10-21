@extends('layouts.blackand.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- Page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Data Subsidi LPG</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tabel</a></li>
                            <li class="breadcrumb-item active"> Data Subsidi LPG</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success message -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif



        <!-- Form: Tambah Data Kuota LPG Subsidi -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-sm-0 font-size-18">Form Tambah Data Kuota LPG Subsidi</h4>
                    </div>
                    <div class="card-body">
                        <form action="/lpg/subsidi/store" method="post" id="myform" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <label for="bulan">Tahun*</label>
                                <input class="form-control mb-2" type="month" id="bulan" name="bulan" required>

                                <label for="provinsi">Provinsi*</label>
                                <select name="provinsi" id="provinsi" class="form-control mb-2">
                                    <option value="">--Pilih Provinsi--</option>
                                    @foreach ($provinsi as $prov)
                                        <option value="{{ $prov['name'] }}">{{ $prov['name'] }}</option>
                                    @endforeach
                                </select>

                                <label for="kabupaten">Kabupaten/Kota*</label>
                                <select name="kabupaten" id="kabupaten" class="form-control mb-2">
                                    <option value="">--Pilih Kabupaten/Kota--</option>
                                    {{-- Please populate this select input --}}
                                </select>

                                <label for="volume">Volume*</label>
                                <input class="form-control mb-2" type="number" id="volume" name="volume" required>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
