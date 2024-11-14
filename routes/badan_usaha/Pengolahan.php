<?php
// routes/badan_usaha/EksporImpor.php

use App\Http\Controllers\PengolahanController;

// Pengolahan Minyak Bumi/Hasil Olahan dan Gas Bumi
Route::controller(PengolahanController::class)->group(function () {
  // Pengolahan Minyak Bumi
  Route::get('/pengolahan-minyak-bumi-hasil-olah/{id}', 'index');
  route::get('/pengolahan-minyak-bumi-hasil-olah/show/{id}/{pengolahan}/{filter?}', 'show_mb_ho');
  // Route::get('/pengolahan-gas-bumi', 'show_gb');
  route::get('/pengolahan-gas-bumi/show/{id}/{pengolahan}/{filter?}', 'show_gb');

  // Fungsi AJAX
  Route::get('/get_intakeKilang', 'get_intakeKilang');
  Route::get('/get_satuanIntakeKilang/{name}', 'get_satuanIntakeKilang');
  Route::get('/get_kota_pengolahan/{kabupaten_kota}', 'get_kota_pengolahan'); //Ambil Kota
  Route::get('/get_satuan/{produk}', 'get_satuan'); //Ambil Kota
  Route::get('/get_Pengolahan/{id}', 'get_Pengolahan'); //Ambil data berdasrkan ID

  // Pengolahan Minyak Bumi Produksi Kilang
  Route::post('/simpan_pengolahan_minyak_bumi_produksi', 'simpan_pengolahan_minyak_bumi_produksi');
  Route::put('/update_pengolahan_minyak_bumi_produksi/{id}', 'update_pengolahan_minyak_bumi_produksi');
  Route::delete('/hapus_pengolahan_minyak_bumi_produksi/{id}', 'hapus_pengolahan_minyak_bumi_produksi');
  Route::delete('/hapus_bulan_pengolahan_minyak_bumi_produksi/{id}', 'hapus_bulan_pengolahan_minyak_bumi_produksi');
  Route::put('/submit_pengolahan_minyak_bumi_produksi/{id}', 'submit_pengolahan_minyak_bumi_produksi');
  Route::put('/submit_bulan_pengolahan_minyak_bumi_produksi/{id}', 'submit_bulan_pengolahan_minyak_bumi_produksi');
  Route::post('/importPengolahanMBProduksi', 'import_pengolahan_minyak_bumi_produksi');

  // Pengolahan Minyak Bumi Pasokan Kilang
  Route::post('/simpan_pengolahan_minyak_bumi_pasokan', 'simpan_pengolahan_minyak_bumi_pasokan');
  Route::put('/update_pengolahan_minyak_bumi_pasokan/{id}', 'update_pengolahan_minyak_bumi_pasokan');
  Route::delete('/hapus_pengolahan_minyak_bumi_pasokan/{id}', 'hapus_pengolahan_minyak_bumi_pasokan');
  Route::delete('/hapus_bulan_pengolahan_minyak_bumi_pasokan/{id}', 'hapus_bulan_pengolahan_minyak_bumi_pasokan');
  Route::put('/submit_pengolahan_minyak_bumi_pasokan/{id}', 'submit_pengolahan_minyak_bumi_pasokan');
  Route::put('/submit_bulan_pengolahan_minyak_bumi_pasokan/{id}', 'submit_bulan_pengolahan_minyak_bumi_pasokan');
  Route::post('/importPengolahanMBPasokan', 'import_pengolahan_minyak_bumi_pasokan');

  // Pengolahan Minyak Bumi Distribusi Kilang
  Route::post('/simpan_pengolahan_minyak_bumi_distribusi', 'simpan_pengolahan_minyak_bumi_distribusi');
  Route::put('/update_pengolahan_minyak_bumi_distribusi/{id}', 'update_pengolahan_minyak_bumi_distribusi');
  Route::delete('/hapus_pengolahan_minyak_bumi_distribusi/{id}', 'hapus_pengolahan_minyak_bumi_distribusi');
  Route::delete('/hapus_bulan_pengolahan_minyak_bumi_distribusi/{id}', 'hapus_bulan_pengolahan_minyak_bumi_distribusi');
  Route::put('/submit_pengolahan_minyak_bumi_distribusi/{id}', 'submit_pengolahan_minyak_bumi_distribusi');
  Route::put('/submit_bulan_pengolahan_minyak_bumi_distribusi/{id}', 'submit_bulan_pengolahan_minyak_bumi_distribusi');
  Route::post('/importPengolahanMBDistribusi', 'import_pengolahan_minyak_bumi_distribusi');

  // Pengolahan Gas Bumi Produksi Kilang
  Route::post('/simpan_pengolahan_gas_bumi_produksi', 'simpan_pengolahan_gas_bumi_produksi');
  Route::put('/update_pengolahan_gas_bumi_produksi/{id}', 'update_pengolahan_gas_bumi_produksi');
  Route::delete('/hapus_pengolahan_gas_bumi_produksi/{id}', 'hapus_pengolahan_gas_bumi_produksi');
  Route::delete('/hapus_bulan_pengolahan_gas_bumi_produksi/{id}', 'hapus_bulan_pengolahan_gas_bumi_produksi');
  Route::put('/submit_pengolahan_gas_bumi_produksi/{id}', 'submit_pengolahan_gas_bumi_produksi');
  Route::put('/submit_bulan_pengolahan_gas_bumi_produksi/{id}', 'submit_bulan_pengolahan_gas_bumi_produksi');
  Route::post('/importPengolahanGBProduksi', 'import_pengolahan_gas_bumi_produksi');

  // Pengolahan Gas Bumi Pasokan Kilang
  Route::post('/simpan_pengolahan_gas_bumi_pasokan', 'simpan_pengolahan_gas_bumi_pasokan');
  Route::put('/update_pengolahan_gas_bumi_pasokan/{id}', 'update_pengolahan_gas_bumi_pasokan');
  Route::delete('/hapus_pengolahan_gas_bumi_pasokan/{id}', 'hapus_pengolahan_gas_bumi_pasokan');
  Route::delete('/hapus_bulan_pengolahan_gas_bumi_pasokan/{id}', 'hapus_bulan_pengolahan_gas_bumi_pasokan');
  Route::put('/submit_pengolahan_gas_bumi_pasokan/{id}', 'submit_pengolahan_gas_bumi_pasokan');
  Route::put('/submit_bulan_pengolahan_gas_bumi_pasokan/{id}', 'submit_bulan_pengolahan_gas_bumi_pasokan');
  Route::post('/importPengolahanGBPasokan', 'import_pengolahan_gas_bumi_pasokan');

  // Pengolahan Gas Bumi Distribusi Kilang
  Route::post('/simpan_pengolahan_gas_bumi_distribusi', 'simpan_pengolahan_gas_bumi_distribusi');
  Route::put('/update_pengolahan_gas_bumi_distribusi/{id}', 'update_pengolahan_gas_bumi_distribusi');
  Route::delete('/hapus_pengolahan_gas_bumi_distribusi/{id}', 'hapus_pengolahan_gas_bumi_distribusi');
  Route::delete('/hapus_bulan_pengolahan_gas_bumi_distribusi/{id}', 'hapus_bulan_pengolahan_gas_bumi_distribusi');
  Route::put('/submit_pengolahan_gas_bumi_distribusi/{id}', 'submit_pengolahan_gas_bumi_distribusi');
  Route::put('/submit_bulan_pengolahan_gas_bumi_distribusi/{id}', 'submit_bulan_pengolahan_gas_bumi_distribusi');
  Route::post('/importPengolahanGBDistribusi', 'import_pengolahan_gas_bumi_distribusi');
});
