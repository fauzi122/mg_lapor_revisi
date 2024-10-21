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

        <!-- Form: Tambah Data Subsidi LPG Verified -->
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-sm-0 font-size-18">Form Tambah Data Subsidi LPG Verified</h4>
                    </div>
                    <div class="card-body">
                        <form action="/lpg/subsidi/store" method="post" id="myform" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                              <div class="mb-3">
                                <label for="bulan">Bulan*</label>
                                     <select class="form-control select2 select2-hidden-accessible mb-2" style="width: 100%;"
                                    tabindex="-1" aria-hidden="true" name="bulan">
                                     <option value="">--Pilih Bulan--</option>
                                    @php
                                        $currentMonth = now();
                                        $months = [];
                                        for ($i = 0; $i < 15; $i++) {
                                            $formattedMonth = $currentMonth->format('Y-m-01');
                                            $months[$formattedMonth] = dateIndonesia($currentMonth->format('Y-m-01'));
                                            $currentMonth->subMonth();
                                        }
                                    @endphp

                                    @foreach ($months as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                 </select>
                                 </div>
                                   <div class="mb-3">
                                <label for="provinsi">Provinsi*</label>
                                <select name="provinsi" id="provinsi" class="form-control select2 select2-hidden-accessible mb-2" style="width: 100%;"
                                    tabindex="-1" aria-hidden="true">
                                    <option value="">--Pilih Provinsi--</option>
                                    @foreach ($provinsi as $prov)
                                        <option value="{{ $prov['name'] }}">{{ $prov['name'] }}</option>
                                    @endforeach
                                </select>
    </div>
     <div class="mb-3">
                                <label for="volume">Volume*</label>
                                <input class="form-control mb-2" type="number" id="volume" name="volume" required>
                                </div>
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
