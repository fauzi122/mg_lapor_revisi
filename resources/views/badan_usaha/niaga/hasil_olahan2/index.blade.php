@extends('layouts.frontand.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Hasil Olahan/Minyak Bumi</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                <li class="breadcrumb-item active">Hasil Olahan/Minyak Bumi</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        {{--  <div class="card-header">
                            <div class="d-flex justify-content-end mb-3">
                                <a href="/create/hasil-olahan/minyak-bumi" class="btn btn-primary">Buat Laporan</a>
                            </div>
                        </div>  --}}
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NO.Treking</th>
                                            <th>Tgl Pengajuan</th>
                                            <th>Jenis izin</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($izin as $izin )
                                        
                                    
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><a href="">{{$izin->key}}</a></td>
                                            <td>{{$izin->tgl_ajuan_izin}}</td>
                                            <td>{{$izin->jenis_izin}}</td>
                                          
                                            <td><a href="/show/hasil-olahan/minyak-bumi" class="btn btn-sm btn-primary">Buat Laporan</a></td>
                                        </tr>
                                    @endforeach
                                    
                                        <!-- Add more rows as needed -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
