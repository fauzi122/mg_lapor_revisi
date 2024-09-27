@extends('layouts.blackand.app')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Laporan Distribusi/Penjualan Domestik Kilang Minyak Bumi</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tabel</a></li>
                            <li class="breadcrumb-item active">Laporan Distribusi/Penjualan Domestik Kilang Minyak Bumi</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-end mb-3">

                        </div>
                        <ul class="nav nav-tabs">
                         
                           
                        </ul>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(function(){
	  $("#datepicker").datepicker({
		 changeMonth : true,
                 changeYear : true
	  });
	});
</script>
@endsection
