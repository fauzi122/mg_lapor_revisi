<?php

namespace App\Http\Controllers\bu;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\auth\AuthBuController;
use App\Http\Controllers\auth\AuthEvaluatorController;
use App\Http\Controllers\RealTimeDataController;

use App\Http\Controllers\{
	IncotermController,
	PortController,
	MepingController,
	IndukizinController,
	NegaraController,
	IntakeController,
	ProdukController,
	DashboardController,
    EmailMasterController,
    JabatanController,
	PenyMinyakbumiController,
	PengangkutanmgController,
	PengolahanController,
	SubsidilpgController,
	ProgresPembangunanController,
	IzinMigasController,
	testEmailController,
	IzinController,
	IzinUsahaController,
    LogsEvController,
	LogsEvaluatorController,
    SektorController
};

use App\Http\Controllers\Evaluator\{
	EvHasilOlahController,
	EvPasokHasilOlahController,
	EvHargaBBMController,
	EvHargaLpgController,
	EvJualLng_Bbg_Cng_Controller,
	EvPasokLng_Bbg_Cng_Controller,
	EvJualLpgController,
	EvPasokLpgController,
	EvJualGasBumiController,
	EvPasokGasBumiController,
	EvProduksiMinyakBumiController,
	EvPasokanMinyakBumiController,
	EvPenyimpananMinyakBumiController,
	EvPenyimpananGasBumiController,
	EvPengangkutanMinyakBumiController,
	EvPengangkutanGasBumiController,
	EvDistribusiMinyakBumiController,
	EvProduksiGasBumiController,
	EvPasokanGasBumiController,
	EvDistribusiGasBumiController,
	EvExporController,
	EvImporController,
	DataIzinBuController,
	DataUserController,
	EvBphPasokanGasBumi,
	EvBphPengangkutanGas,
	EvBphPenjualanGasBumi,
	EvKuotaJbkp,
	EvKuotaJbt,
	EvPenjualanBbm,
	EvPenjualanJbkp,
	EvPenjualanJbt,
	EvPenjualanJbu,
    EvProgresPembangunanController,
    SubsidiLpg
};
use App\Http\Controllers\user\PermissionController;
use App\Http\Controllers\user\RoleController;
use App\Http\Controllers\user\UserController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/redirect-laporan/{q}', [AuthController::class, 'postloginIzin'])->name('post.izin'); //Redirect from izin
//auth BU

//route test email
Route::controller(testEmailController::class)->group(function () {
	Route::get('/test-email', 'index');
	Route::post('/test-email/send', 'send');
});

Route::get('/real-time-data', [RealTimeDataController::class, 'getData']);
Route::get('/real-time-data-view', [RealTimeDataController::class, 'index']);
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login/post-login', [AuthBuController::class, 'postloginIzin']);
// Route::get('badan-usaha/login/{dataNPWP}', [AuthBuController::class, 'postloginIzinByURL']); //Redirect from izin
Route::get('badan-usaha/login', [AuthBuController::class, 'postloginIzinByURL']);


//auth Evaluator
Route::get('/evaluator/login', [AuthEvaluatorController::class, 'index']);
//Route::get('/evaluator/login-sso', [AuthEvaluatorController::class, 'index_sso']);
// Route::post('/evaluator/login/post-login', [AuthEvaluatorController::class, 'postloginEvaluator']);
Route::post('/evaluator/login/post-login', [AuthEvaluatorController::class, 'postLogin']);
Route::post('/login/generate-otp', [AuthEvaluatorController::class, 'genOTP']);
Route::get('/evaluator/login_sso', [AuthEvaluatorController::class, 'login_sso']);


// Konten yang hanya dapat diakses oleh pengguna dengan peran "Badan Usaha"
Route::middleware(['auth', 'checkRoleBu'])->group(function () {


	Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

	// bu hasil olahan penjualan
	Route::controller(HasilolahController::class)->group(function () {
		Route::get('/hasil-olahan/minyak-bumi/{id}', 'index');
		Route::post('/simpan_jholb', 'simpan_jholbx');
		Route::put('/update_jholb/{id}', 'update_jholbx');
		Route::get('/show/hasil-olahan/minyak-bumi/{id}/{hasilolah}', 'show_jholbx');
		Route::delete('/hapus_jholb/{id}', 'hapus_jholbx');
		Route::delete('/hapus_bulan_jholb/{bulan}', 'hapus_bulan_jholbx');
		Route::post('/importjholb', 'importjholbx');
		Route::get('/get-produk', 'get_produk');
		Route::get('/get-satuan/{name}', 'get_satuan');
		Route::get('/get-provinsi', 'get_provinsi');
		Route::get('/get_kota/{id_prov}', 'get_kota');
		Route::put('/submit_jholb/{id}', 'submit_jholbx');
		Route::put('/submit_bulan_jholb/{bulan}', 'submit_bulan_jholbx');
		Route::get('/get-penjualan-ho/{id}', 'get_penjualan_ho');
	});

	// bu hasil olahan Pasokan 
	Route::resource('/pasokan-olah', PasokanHasilolahController::class);
	Route::controller(PasokanHasilolahController::class)->group(function () {
		Route::post('/importpasokan', 'importpasokanx');
		Route::get('/get-pasokan-ho/{id}', 'get_pasokan_ho');
		Route::put('/update_pasokan/{id}', 'update_pasokan');
		Route::put('/submit_pasokan-olah/{id}', 'submit_pasokan_olahx');
		Route::put('/submit_bulan_pasokan-olah/{bulan}', 'submit_bulan_pasokan_olahx');
		Route::delete('/hapus_bulan_pasokan/{bulan}', 'hapus_bulan_pasokanx');
	});

	// bu hasil olahan harga 
	// Route::resource('/harga-bbm-jbu', HargabbmController::class);
	Route::prefix('/harga-bbm-jbu')->group(function () {
		Route::controller(HargabbmController::class)->group(function () {
			Route::get('/{id}', 'index');
			Route::post('/', 'store');
			Route::delete('/{id}', 'destroy');
		});
	});
	Route::controller(HargabbmController::class)->group(function () {
		Route::post('/importhargajbu', 'importhargajbux');
		Route::get('/get-harga-ho/{id}', 'get_harga_ho');
		Route::put('/submit_harga-bbm-jbu/{id}', 'submit_harga_bbm_jbux');
		Route::put('/submit_bulan_harga-bbm-jbu/{id}', 'submit_bulan_harga_bbm_jbux');
		Route::delete('/hapus_bulan_harga-bbm-jbu/{bulan}', 'hapus_bulan_harga_bbm_jbux');
	});

	// LNG/CNG
	Route::controller(LngController::class)->group(function () {
		route::get('/lng/cng/{id}', 'index');
		route::get('/lng/cng/show/{id}/{lng}/{filter?}', 'show_lngx');
		Route::post('/simpan_lng', 'simpan_lngx');
		Route::put('/update_lng/{id}', 'update_lngx');
		Route::delete('/hapus_lng/{id}', 'hapus_lngx');
		Route::delete('/hapus_bulan_lng/{id}', 'hapus_bulan_lngx');
		Route::get('/get-penjualan-lng/{id}', 'get_penjualan_lng');
		Route::post('/simpan_pasokan_lng', 'simpan_pasokan_lngx');
		Route::delete('/hapus_pasok_lng/{id}', 'hapus_pasok_lngx');
		Route::delete('/hapus_bulan_pasok_lng/{id}', 'hapus_bulan_pasok_lngx');
		Route::get('/get-pasok-lng/{id}', 'get_pasok_lng');
		Route::put('/update_pasok_lng/{id}', 'update_pasok_lngx');
		Route::get('/get_kota_lng/{kabupaten_kota}', 'get_kota');
		Route::put('/submit_lng/{id}', 'submit_lngx');
		Route::put('/submit_bulan_lng/{id}', 'submit_bulan_lngx');
		Route::put('/submit_pasok_lng/{id}', 'submit_pasok_lngx');
		Route::put('/submit_bulan_pasok_lng/{id}', 'submit_bulan_pasok_lngx');
		Route::post('/importlngpen', 'importlngpenx');
		Route::post('/importlngpasok', 'importlngpasokx');
	});

	// bu hasil olahan penjualan

	Route::controller(LpgController::class)->group(function () {
		Route::get('/niaga/lpg/{id}', 'index');
		Route::get('/niaga/lpg/show/{id}/{lpg}/{filter?}', 'show_lpg');
		Route::post('/simpan_lpg', 'simpan_lpg');
		Route::put('/update_lpg/{id}', 'update_lpg');
		Route::delete('/hapus_lpg/{id}', 'hapus_lpg');
		Route::delete('/hapus_bulan_lpg/{id}', 'hapus_bulan_lpg');
		Route::put('/submit_penjualan_lpg/{id}', 'submit_penjualan_lpg');
		Route::put('/submit_bulan_penjualan_lpg/{id}', 'submit_bulan_penjualan_lpgx');

		Route::post('/simpan_pasokanLPG', 'simpan_pasokanLPG');
		Route::put('/update_pasokanLPG/{id}', 'update_pasokanLPG');
		Route::delete('/hapus_pasokanLPG/{id}', 'hapus_pasokanLPG');
		Route::delete('/hapus_bulan_pasokanLPG/{id}', 'hapus_bulan_pasokanLPG');
		Route::put('/submit_pasokan_lpg/{id}', 'submit_pasokan_lpg');
		Route::put('/submit_bulan_pasokan_lpg/{id}', 'submit_bulan_pasokan_lpgx');

		Route::get('/get-penjualan-lpg/{id}', 'get_penjualan_lpg');
		Route::get('/getPasokanLPG/{id}', 'getPasokanLPG');
		Route::post('/importlpg', 'importlpgx');
		Route::post('/importlpg_pasok', 'importlpg_pasokx');
		Route::get('/get-produk', 'get_produk');
		Route::get('/get-satuan/{name}', 'get_satuan');
		Route::get('/get-provinsi', 'get_provinsi');
		Route::get('/get_kota_penjualan_lpg/{kabupaten_kota}', 'get_kota');
	});

	// gas bumi pipa

	Route::controller(GBPController::class)->group(function () {
		Route::get('/gas-bumi-pipa', 'index');
		route::get('/gas-bumi-pipa/show/{id}/{gbpx}', 'show_gbpx');
		Route::post('/simpan_gbp', 'simpan_gbpx');
		Route::put('/update_gbp/{id}', 'update_gbpx');
		Route::delete('/hapus_gbp/{id}', 'hapus_gbpx');
		Route::delete('/hapus_bulan_gbp/{bulan}', 'hapus_bulan_gbpx');
		Route::get('/get-penjualan-gbp/{id}', 'get_penjualan_gbp');
		Route::post('/simpan_pasokan_gbp', 'simpan_pasokan_gbpx');
		Route::delete('/hapus_pasok_gbp/{id}', 'hapus_pasok_gbpx');
		Route::delete('/hapus_pasok_bulan_gbp/{bulan}', 'hapus_pasok_bulan_gbpx');
		Route::get('/get-pasok-gbp/{id}', 'get_pasok_gbp');
		Route::put('/update_pasok_gbp/{id}', 'update_pasok_gbpx');
		Route::get('/get_kota_gbp/{kabupaten_kota}', 'get_kota');
		Route::put('/submit_pasok_gbp/{id}', 'submit_pasok_gbpx');
		Route::put('/submit_bulan_pasok_gbp/{bulan}', 'submit_bulan_pasok_gbpx');
		Route::put('/submit_gbp/{id}', 'submit_gbpx');
		Route::put('/submit_bulan_gbp/{bulan}', 'submit_bulan_gbpx');
		Route::post('/import_gbp', 'import_gbpx');
		Route::post('/import_gbp_pasok', 'import_gbp_pasokx');
	});

	include __DIR__ . '/badan_usaha/EksporImpor.php';

	// Penyimpanan Gas

	Route::controller(PenyMinyakbumiController::class)->group(function () {
		Route::get('/penyimpananMinyakBumi/{id}', 'index');
		route::get('/penyimpanan-minyak-bumi/show/{id}/{filter?}', 'show_pmbx');
		Route::post('/simpan_pmb', 'simpan_pmbx');
		Route::put('/update_pmb/{id}', 'update_pmbx');
		Route::delete('/hapus_pmb/{id}', 'hapus_pmbx');
		Route::delete('/hapus_bulan_pmb/{id}', 'hapus_bulan_pmbx');
		Route::get('/get-pmb/{id}', 'get_pmb');
		Route::put('/submit_pmb/{id}', 'submit_pmbx');
		Route::put('/submit_bulan_pmb/{id}', 'submit_bulan_pmbx');

		Route::get('/penyimpanan-gas-bumi/{id}', 'index_pggb');
		// route::get('/penyimpanan-gas-bumi/show/{filter}/{id}', 'show_pggbx');
		route::get('/penyimpanan-gas-bumi/show/{id}/{filter?}', 'show_pggbx');
		Route::post('/simpan_pggb', 'simpan_pggbx');
		Route::put('/update_pggb/{id}', 'update_pggbx');
		Route::delete('/hapus_pggb/{id}', 'hapus_pggbx');
		Route::delete('/hapus_bulan_pggb/{id}', 'hapus_bulan_pggbx');
		Route::get('/get-pggb/{id}', 'get_pggb');
		Route::put('/submit_pggb/{id}', 'submit_pggbx');
		Route::put('/submit_bulan_pggb/{id}', 'submit_bulan_pggbx');
		Route::post('/import_pmb', 'import_pmbx');
		Route::post('/import_pggb', 'import_pggbx');
		Route::get('/get-kab-kota', 'get_kab_kota');
		Route::get('/get-sektor', 'get_sektor');
		Route::get('/get-kab-kota-mb/{kab_kota}', 'get_kab_kota_mb');
	});

	// bu hasil olahan harga 
	Route::resource('/harga-bbm-jbu', HargabbmController::class);
	Route::controller(HargabbmController::class)->group(function () {
		Route::get('/niaga/harga', 'index');
		Route::get('/niaga/harga/show/{id}/{harga}/{filter?}', 'show_niagahargax');
		Route::post('/importhargajbu', 'importhargajbux');
		Route::get('/get-harga-bbm/{id}', 'get_harga_bbm');
		Route::put('/submit_harga-bbm-jbu/{id}', 'submit_harga_bbm_jbux');
		Route::put('/submit_bulan_harga-bbm-jbu/{id}', 'submit_bulan_harga_bbm_jbux');
		Route::delete('/hapusbulanHargabbmjbu/{id}', 'hapusbulanHargabbmjbux');

		Route::post('/simpanHargaLPG', 'simpan_harga_lpg');
		Route::get('/get-harga-lpg/{id}', 'get_harga_lpg');
		Route::put('/updateHargaLPG/{id}', 'update_harga_lpg');
		Route::get('/get_kota_lpg_harga/{kabupaten_kota}', 'get_kota');
		Route::delete('/hapusHargaLPG/{id}', 'hapus_harga_lpg');
		Route::put('/submitHargaLPG/{id}', 'submit_harga_lpg');
		Route::delete('/hapusbulanHargaLPG/{id}', 'hapus_bulan_harga_lpg');
		Route::put('/submitbulanHargaLPG/{id}', 'submit_bulan_harga_lpg');
		Route::post('/importHargaLPG', 'importhargalpgx');
	});

	// Subsidi lpg
	Route::controller(SubsidilpgController::class)->group(function () {
		Route::get('/lpg-subsidi', 'index');
		route::get('/lpg-subsidi/show/{id}/{subsidix}', 'show_lgpsubx');
		Route::post('/simpan_lgpsub', 'simpan_lgpsubx');
		Route::put('/update_lgpsub/{id}', 'update_lgpsubx');
		Route::delete('/hapus_lgpsub/{id}', 'hapus_lgpsubx');
		Route::delete('/hapus_bulan_lgpsub/{bulan}', 'hapus_bulan_lgpsubx');
		Route::get('/get-lgpsub/{id}', 'get_lgpsub');
		Route::put('/submit_lgpsub/{id}', 'submit_lgpsubx');
		Route::put('/submit_bulan_lgpsub/{bulan}', 'submit_bulan_lgpsubx');

		Route::get('/kuota-lpg-subsidi', 'index_klpgs');
		route::get('/kuota-lpg-subsidi/show', 'show_klpgsx');
		Route::post('/simpan_klpgs', 'simpan_klpgsx');
		Route::put('/update_klpgs/{id}', 'update_klpgsx');
		Route::delete('/hapus_klpgs/{id}', 'hapus_klpgsx');
		Route::delete('/hapus_bulan_klpgs/{bulan}', 'hapus_bulan_klpgsx');
		Route::get('/get-klpgs/{id}', 'get_klpgs');
		Route::put('/submit_klpgs/{id}', 'submit_klpgsx');
		Route::put('/submit_bulan_klpgs/{id}', 'submit_bulan_klpgsx');
		Route::get('/get_kota_subsidi/{kabupaten_kota}', 'get_kota');
		Route::post('/import_lgpsub', 'import_lgpsubx');
		Route::post('/import_klpgs', 'import_klpgsx');
	});

	// Progress Pembangunan
	Route::controller(ProgresPembangunanController::class)->group(function () {
		route::get('/progres-pembangunan/show/{id}', 'show_izinSementara');
		Route::post('/simpan_izinSementara', 'simpan_izinSementara');
		Route::put('/update_izinSementara/{id}', 'update_izinSementara');
		Route::delete('/hapus_izinSementara/{id}', 'hapus_izinSementara');
		Route::get('/get-izinSementara/{id}', 'get_izinSementara');
		Route::put('/submit_izinSementara/{id}', 'submit_izinSementara');
	});

	// Pengangkutan Minyak dan Gas
	Route::controller(PengangkutanmgController::class)->group(function () {
		Route::get('/pengangkutan-minyak-bumi/{id}', 'index');
		route::get('/pengangkutan-minyak-bumi/show/{id}', 'show_pengmbx');
		Route::post('/simpan_pengmb', 'simpan_pengmbx');
		Route::put('/update_pengmb/{id}', 'update_pengmbx');
		Route::delete('/hapus_pengmb/{id}', 'hapus_pengmbx');
		Route::delete('/hapus_bulan_pengmb/{id}', 'hapus_bulan_pengmbx');
		Route::get('/get-pengmb/{id}', 'get_pengmb');
		Route::put('/submit_pengmb/{id}', 'submit_pengmbx');
		Route::put('/submit_bulan_pengmb/{id}', 'submit_bulan_pengmbx');
		Route::post('/importPengangkutanMB', 'importPengangkutanMB');

		Route::get('/pengangkutan-gas-bumi/{id}', 'index_pgb');
		route::get('/pengangkutan-gas-bumi/show/{id}', 'show_pgbx');
		Route::post('/simpan_pgb', 'simpan_pgbx');
		Route::put('/update_pgb/{id}', 'update_pgbx');
		Route::delete('/hapus_pgb/{id}', 'hapus_pgbx');
		Route::delete('/hapus_bulan_pgb/{id}', 'hapus_bulan_pgbx');
		Route::get('/get-pgb/{id}', 'get_pgb');
		Route::put('/submit_pgb/{id}', 'submit_pgbx');
		Route::put('/submit_bulan_pgb/{id}', 'submit_bulan_pgbx');
		Route::post('/importPengangkutanGB', 'importPengangkutanGB');
	});


	include __DIR__ . '/badan_usaha/Pengolahan.php';

	Route::get('/logoutBU', [AuthBuController::class, 'logoutBU']);
});


// Konten yang hanya dapat diakses oleh pengguna dengan peran "ADM/Evaluator"
Route::middleware(['auth', 'checkRole'])->group(function () {

	// meping	
	Route::controller(MepingController::class)->group(function () {
		Route::get('/master/meping', 'index');
		Route::get('/master/meping/create', 'create');
		Route::post('/master/meping', 'store');
		Route::get('/master/meping/edit/{id}', 'edit');
		Route::put('/master/meping/update/{id}', 'update');
		Route::delete('/master/meping/destroy_izin/{id}', 'destroy_Dizin');


		Route::get('/master/meping/{id}/show/{jenis}', 'show');
		Route::get('/master/meping/create/{id}/jenis-izin/{jenis_izin}', 'create_Jizin');
		Route::post('/master/meping/izin', 'store_JIzin');
		Route::get('/master/meping/izin/{id}/edit', 'edit_Jizin');
		Route::put('/master/meping/izin/{id}', 'update_Jizin');
		Route::post('/update-status', 'updateStatus')->name('update-status');
		Route::delete('/master/meping/{id}/destroy', 'destroy');
	});
	// Data Badan Usaha	
	Route::controller(DataIzinBuController::class)->group(function () {
		Route::get('/data-izin/badan-usaha/minyak-bumi', 'index_minyak');
		Route::get('/data-izin/badan-usaha/gas', 'index_gas');
	});

	// Subsidi lpg dan kuota subsidi

	Route::controller(SubsidiLpg::class)->group(function () {
		Route::get('/get-kabkot/{provinceName}', 'getKabkot');
		Route::get('/data-subsidi-lpg/verified', 'index');
		Route::post('/lpg/subsidi/store', 'store')->name('lpg.store');
		Route::post('/lpg/storeSubsidi_excel', 'storeSubsidi_excel')->name('lpg.storeSubsidi_excel');
		Route::put('/lpg/subsidi/update/{id}', 'update');
		Route::post('/lpg/subsidi/delete/{id}', 'delete');
		Route::get('/download/kuota-lpg', 'downloadFilekuota')->name('download.kuota-lpg');
		Route::get('/download/subsidi-lpg', 'downloadFilesubsidi')->name('download.subsidi-lpg');

		Route::get('/data-kuota-subsidi-lpg', 'index_kuota');
		Route::post('/lpg/kuota/store', 'storekuota')->name('lpg.store');
		Route::post('/lpg/storekuota_excel', 'storekuota_excel')->name('lpg.storekuota_excel');
		Route::put('/lpg/kuota/update/{id}', 'updatekuota');
		Route::get('/lpg/kuota/kabkot/{id}', 'getKabkot');
		Route::post('/lpg/kuota/delete/{id}', 'deletekuota');
	});


	Route::controller(IndukizinController::class)->group(function () {
		Route::get('/master', 'index_evaluator');
		Route::post('/master', 'index_evaluator');
		Route::get('/master/chart-detail/{series}/{category}/{date}', 'chartDetail')->name('chart.detail');
		// Route::get('/master/izin/create', 'create');
		// Route::post('/master/izin', 'store');

		// Route::post('/update-status', 'updateStatus')->name('update-status');
		// Route::delete('/master/izin/{id}/destroy', 'destroy');
	});

	// admin master data 
	Route::resource('/master/inco-term', IncotermController::class);
	Route::resource('/master/port', PortController::class);
	Route::resource('/master/negara', NegaraController::class);
	Route::resource('/master/intake_kilangs', IntakeController::class);
	Route::resource('/master/produk', ProdukController::class);
	Route::resource('/master/jabatan', JabatanController::class);
	Route::resource('/master/izin-usaha', IzinUsahaController::class);
	Route::resource('/master/email', EmailMasterController::class);
	Route::resource('/master/sektor', SektorController::class);
	//Evaluator hasil olahan bbm

	Route::controller(EvHasilOlahController::class)->group(function () {

		Route::get('/laporan/jual-hasil-olahan/', 'index');
		Route::get('/laporan/jual-hasil-olahan/periode/{kode}', 'periode');
		Route::get('/laporan/jual-hasil-olahan/{kode}', 'show');
		Route::get('/laporan/jual-hasil-olahan-cek/', 'test');
		Route::get('/laporan/jual-hasil-olahan-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/jual-hasil-olahan-lihat-semua-data', 'filterData');
		Route::post('/laporan/jual-hasil-olahan/update-revision', 'updateRevisionNotes');
		Route::post('/laporan/jual-hasil-olahan/update-revision-all', 'updateRevisionNotesAll');
		Route::post('/laporan/jual-hasil-olahan/selesai-periode-all', 'selesaiPeriodeAll');
		Route::post('/laporan/jual-hasil-olahan/selesai-periode', 'selesaiPeriode');
		Route::post('/laporan/jual-hasil-olahan/cetak-periode', 'cetakperiode');
	});

	//Evaluator pasokan olahan bbm
	Route::controller(EvPasokHasilOlahController::class)->group(function () {
		//		Route::post('/laporan/pasokan-hasil-olahan', 'index');
		//		Route::get('/laporan/pasokan-hasil-olahan', 'index');
		//		Route::put('/laporan/pasokan-hasil-olahan/update-revision/{id}', 'updateRevisionNotes');

		Route::get('/laporan/pasokan-hasil-olahan', 'index');
		Route::get('/laporan/pasokan-hasil-olahan/periode/{kode}', 'periode');
		Route::get('/laporan/pasokan-hasil-olahan/{kode}', 'show');
		Route::get('/laporan/pasokan-hasil-olahan-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/pasokan-hasil-olahan-lihat-semua-data', 'filterData');
		Route::post('/laporan/pasokan-hasil-olahan/update-revision', 'updateRevisionNotes');
		Route::post('/laporan/pasokan-hasil-olahan/update-revision-all', 'updateRevisionNotesAll');
		Route::post('/laporan/pasokan-hasil-olahan/selesai-periode-all', 'selesaiPeriodeAll');
		Route::post('/laporan/pasokan-hasil-olahan/selesai-periode', 'selesaiPeriode');
		Route::post('/laporan/pasokan-hasil-olahan/cetak-periode', 'cetakperiode');
	});

	// harga bbm
	Route::controller(EvHargaBBMController::class)->group(function () {
		//		Route::get('/laporan/harga-bbm', 'index');
		//		Route::post('/laporan/harga-bbm', 'index');
		//		Route::put('/laporan/harga-bbm/update-revision/{id}', 'updateRevisionNotes')->name('revision-harga-bbm');

		Route::get('/laporan/harga-bbm', 'index');
		Route::get('/laporan/harga-bbm/periode/{kode}', 'periode');
		Route::get('/laporan/harga-bbm/{kode}', 'show');
		Route::get('/laporan/harga-bbm-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/harga-bbm-lihat-semua-data', 'filterData');
		Route::post('/laporan/harga-bbm/update-revision', 'updateRevisionNotes');
		Route::post('/laporan/harga-bbm/update-revision-all', 'updateRevisionNotesAll');
		Route::post('/laporan/harga-bbm/selesai-periode-all', 'selesaiPeriodeAll');
		Route::post('/laporan/harga-bbm/selesai-periode', 'selesaiPeriode');
		Route::post('/laporan/harga-bbm/cetak-periode', 'cetakperiode');
	});

	// harga LPG
	Route::controller(EvHargaLpgController::class)->group(function () {
		//		Route::get('/laporan/harga-lpg', 'index');
		//		Route::post('/laporan/harga-lpg', 'index');
		//		Route::put('/laporan/harga-lpg/update-revision/{id}', 'updateRevisionNotes')->name('revision-harga-lpg');

		Route::get('/laporan/harga-lpg', 'index');
		Route::get('/laporan/harga-lpg/periode/{kode}', 'periode');
		Route::get('/laporan/harga-lpg/{kode}', 'show');
		Route::get('/laporan/harga-lpg-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/harga-lpg-lihat-semua-data', 'filterData');
		Route::post('/laporan/harga-lpg/update-revision', 'updateRevisionNotes');
		Route::post('/laporan/harga-lpg/update-revision-all', 'updateRevisionNotesAll');
		Route::post('/laporan/harga-lpg/selesai-periode-all', 'selesaiPeriodeAll');
		Route::post('/laporan/harga-lpg/selesai-periode', 'selesaiPeriode');
		Route::post('/laporan/harga-lpg/cetak-periode', 'cetakperiode');
	});

	// Penjualan LNG/CNG/BBG
	Route::controller(EvJualLng_Bbg_Cng_Controller::class)->group(function () {
		//		Route::get('/laporan/jual/lng-cng-bbg', 'index');
		//		Route::post('/laporan/jual/lng-cng-bbg', 'index');
		//		Route::put('/laporan/jual/lng-cng-bbg/update-revision/{id}', 'updateRevisionNotes')->name('revision-jual-lng');

		Route::get('/laporan/jual/lng-cng-bbg', 'index');
		Route::get('/laporan/jual/lng-cng-bbg/periode/{kode}', 'periode');
		Route::get('/laporan/jual/lng-cng-bbg/{kode}', 'show');
		Route::get('/laporan/jual/lng-cng-bbg-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/jual/lng-cng-bbg-lihat-semua-data', 'filterData');
		Route::post('/laporan/jual/lng-cng-bbg/update-revision', 'updateRevisionNotes');
		Route::post('/laporan/jual/lng-cng-bbg/update-revision-all', 'updateRevisionNotesAll');
		Route::post('/laporan/jual/lng-cng-bbg/selesai-periode-all', 'selesaiPeriodeAll');
		Route::post('/laporan/jual/lng-cng-bbg/selesai-periode', 'selesaiPeriode');
		Route::post('/laporan/jual/lng-cng-bbg/cetak-periode', 'cetakperiode');
	});

	// pasokan LNG/CNG/BBG
	Route::controller(EvPasokLng_Bbg_Cng_Controller::class)->group(function () {
		//		Route::get('/laporan/pasok/lng-cng-bbg', 'index');
		//		Route::post('/laporan/pasok/lng-cng-bbg', 'index');
		//		Route::put('/laporan/pasok/lng-cng-bbg/update-revision/{id}', 'updateRevisionNotes')->name('revision-pasok-lng');

		Route::get('/laporan/pasok/lng-cng-bbg', 'index');
		Route::get('/laporan/pasok/lng-cng-bbg/periode/{kode}', 'periode');
		Route::get('/laporan/pasok/lng-cng-bbg/{kode}', 'show');
		Route::get('/laporan/pasok/lng-cng-bbg-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/pasok/lng-cng-bbg-lihat-semua-data', 'filterData');
		Route::post('/laporan/pasok/lng-cng-bbg/update-revision', 'updateRevisionNotes');
		Route::post('/laporan/pasok/lng-cng-bbg/update-revision-all', 'updateRevisionNotesAll');
		Route::post('/laporan/pasok/lng-cng-bbg/selesai-periode-all', 'selesaiPeriodeAll');
		Route::post('/laporan/pasok/lng-cng-bbg/selesai-periode', 'selesaiPeriode');
		Route::post('/laporan/pasok/lng-cng-bbg/cetak-periode', 'cetakperiode');
	});

	// jual lpg
	Route::controller(EvJualLpgController::class)->group(function () {
		//		Route::get('/laporan/jual/lpg', 'index');
		//		Route::post('/laporan/jual/lpg', 'index');
		//		Route::put('/laporan/jual/lpg/update-revision/{id}', 'updateRevisionNotes')->name('revision-jual-lpg');

		Route::get('/laporan/jual/lpg', 'index');
		Route::get('/laporan/jual/lpg/periode/{kode}', 'periode');
		Route::get('/laporan/jual/lpg/{kode}', 'show');
		Route::get('/laporan/jual/lpg-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/jual/lpg-lihat-semua-data', 'filterData');
		Route::post('/laporan/jual/lpg/update-revision', 'updateRevisionNotes');
		Route::post('/laporan/jual/lpg/update-revision-all', 'updateRevisionNotesAll');
		Route::post('/laporan/jual/lpg/selesai-periode-all', 'selesaiPeriodeAll');
		Route::post('/laporan/jual/lpg/selesai-periode', 'selesaiPeriode');
		Route::post('/laporan/jual/lpg/cetak-periode', 'cetakperiode');
	});

	// pasok lpg
	Route::controller(EvPasokLpgController::class)->group(function () {
		//		Route::get('/laporan/pasok/lpg', 'index');
		//		Route::post('/laporan/pasok/lpg', 'index');
		//		Route::put('/laporan/pasok/lpg/update-revision/{id}', 'updateRevisionNotes')->name('revision-pasok-lpg');

		Route::get('/laporan/pasok/lpg', 'index');
		Route::get('/laporan/pasok/lpg/periode/{kode}', 'periode');
		Route::get('/laporan/pasok/lpg/{kode}', 'show');
		Route::get('/laporan/pasok/lpg-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/pasok/lpg-lihat-semua-data', 'filterData');
		Route::post('/laporan/pasok/lpg/update-revision', 'updateRevisionNotes');
		Route::post('/laporan/pasok/lpg/update-revision-all', 'updateRevisionNotesAll');
		Route::post('/laporan/pasok/lpg/selesai-periode-all', 'selesaiPeriodeAll');
		Route::post('/laporan/pasok/lpg/selesai-periode', 'selesaiPeriode');
		Route::post('/laporan/pasok/lpg/cetak-periode', 'cetakperiode');
	});

	//jualgbmp
	Route::controller(EvJualGasBumiController::class)->group(function () {
		//		Route::get('/laporan/jual/gbmp', 'index');
		//		Route::post('/laporan/jual/gbmp', 'index');
		//		Route::put('/laporan/jual/gbmp/update-revision/{id}', 'updateRevisionNotes')->name('revision-jual-gbmp');

		Route::get('/laporan/jual/gbmp', 'index');
		Route::get('/laporan/jual/gbmp/periode/{kode}', 'periode');
		Route::get('/laporan/jual/gbmp/{kode}', 'show');
		Route::get('/laporan/jual/gbmp-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/jual/gbmp-lihat-semua-data', 'filterData');
		Route::post('/laporan/jual/gbmp/update-revision', 'updateRevisionNotes');
		Route::post('/laporan/jual/gbmp/update-revision-all', 'updateRevisionNotesAll');
		Route::post('/laporan/jual/gbmp/selesai-periode-all', 'selesaiPeriodeAll');
		Route::post('/laporan/jual/gbmp/selesai-periode', 'selesaiPeriode');
		Route::post('/laporan/jual/gbmp/cetak-periode', 'cetakperiode');
	});

	//pasokgbmp
	Route::controller(EvPasokGasBumiController::class)->group(function () {
		//		Route::get('/laporan/pasok/gbmp', 'index');
		//		Route::post('/laporan/pasok/gbmp', 'index');
		//		Route::put('/laporan/pasok/gbmp/update-revision/{id}', 'updateRevisionNotes')->name('revision-pasok-gbmp');

		Route::get('/laporan/pasok/gbmp', 'index');
		Route::get('/laporan/pasok/gbmp/periode/{kode}', 'periode');
		Route::get('/laporan/pasok/gbmp/{kode}', 'show');
		Route::get('/laporan/pasok/gbmp-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/pasok/gbmp-lihat-semua-data', 'filterData');
		Route::post('/laporan/pasok/gbmp/update-revision', 'updateRevisionNotes');
		Route::post('/laporan/pasok/gbmp/update-revision-all', 'updateRevisionNotesAll');
		Route::post('/laporan/pasok/gbmp/selesai-periode-all', 'selesaiPeriodeAll');
		Route::post('/laporan/pasok/gbmp/selesai-periode', 'selesaiPeriode');
		Route::post('/laporan/pasok/gbmp/cetak-periode', 'cetakperiode');
	});

	//produksi minyak bumi
	Route::controller(EvProduksiMinyakBumiController::class)->group(function () {
		//		Route::get('/laporan/produksi/mb', 'index');
		//		Route::post('/laporan/produksi/mb', 'index');
		//		Route::put('/laporan/produksi/mb/update-revision/{id}', 'updateRevisionNotes')->name('revision-produksi-mb');

		Route::get('/laporan/produksi/mb', 'index');
		Route::get('/laporan/produksi/mb/periode/{kode}', 'periode');
		Route::get('/laporan/produksi/mb/{kode}/{filter?}', 'show');
		Route::get('/laporan/produksi/mb-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/produksi/mb-lihat-semua-data', 'filterData');
		Route::post('/laporan/produksi/mb/update-revision', 'updateRevisionNotes');
		Route::post('/laporan/produksi/mb/update-revision-all', 'updateRevisionNotesAll');
		Route::post('/laporan/produksi/mb/selesai-periode-all', 'selesaiPeriodeAll');
		Route::post('/laporan/produksi/mb/selesai-periode', 'selesaiPeriode');
		Route::post('/laporan/produksi/mb/cetak-periode', 'cetakperiode');
	});

	//pasokan minyak bumi
	Route::controller(EvPasokanMinyakBumiController::class)->group(function () {
		//		Route::get('/laporan/pasokan/mb', 'index');
		//		Route::post('/laporan/pasokan/mb', 'index');
		//		Route::put('/laporan/pasokan/mb/update-revision/{id}', 'updateRevisionNotes')->name('revision-pasokan-mb');

		Route::get('/laporan/pasokan/mb', 'index');
		Route::get('/laporan/pasokan/mb/periode/{kode}', 'periode');
		Route::get('/laporan/pasokan/mb/{kode}/{filter?}', 'show');
		Route::get('/laporan/pasokan/mb-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/pasokan/mb-lihat-semua-data', 'filterData');
		Route::post('/laporan/pasokan/mb/update-revision', 'updateRevisionNotes');
		Route::post('/laporan/pasokan/mb/update-revision-all', 'updateRevisionNotesAll');
		Route::post('/laporan/pasokan/mb/selesai-periode-all', 'selesaiPeriodeAll');
		Route::post('/laporan/pasokan/mb/selesai-periode', 'selesaiPeriode');
		Route::post('/laporan/pasokan/mb/cetak-periode', 'cetakperiode');
	});

	//distribusi minyak bumi
	Route::controller(EvDistribusiMinyakBumiController::class)->group(function () {
		//		Route::get('/laporan/distribusi/mb', 'index');
		//		Route::post('/laporan/distribusi/mb', 'index');
		//		Route::put('/laporan/distribusi/mb/update-revision/{id}', 'updateRevisionNotes')->name('revision-distribusi-mb');

		Route::get('/laporan/distribusi/mb', 'index');
		Route::get('/laporan/distribusi/mb/periode/{kode}', 'periode');
		Route::get('/laporan/distribusi/mb/{kode}/{filter?}', 'show');
		Route::get('/laporan/distribusi/mb-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/distribusi/mb-lihat-semua-data', 'filterData');
		Route::post('/laporan/distribusi/mb/update-revision', 'updateRevisionNotes');
		Route::post('/laporan/distribusi/mb/update-revision-all', 'updateRevisionNotesAll');
		Route::post('/laporan/distribusi/mb/selesai-periode-all', 'selesaiPeriodeAll');
		Route::post('/laporan/distribusi/mb/selesai-periode', 'selesaiPeriode');
		Route::post('/laporan/distribusi/mb/cetak-periode', 'cetakperiode');
	});

	//produksi gas bumi
	Route::controller(EvProduksiGasBumiController::class)->group(function () {
		//		Route::get('/laporan/produksi/gb', 'index');
		//		Route::post('/laporan/produksi/gb', 'index');
		//		Route::put('/laporan/produksi/gb/update-revision/{id}', 'updateRevisionNotes')->name('revision-produksi-gb');

		Route::get('/laporan/produksi/gb', 'index');
		Route::get('/laporan/produksi/gb/periode/{kode}', 'periode');
		Route::get('/laporan/produksi/gb/{kode}/{filter?}', 'show');
		Route::get('/laporan/produksi/gb-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/produksi/gb-lihat-semua-data', 'filterData');
		Route::post('/laporan/produksi/gb/update-revision', 'updateRevisionNotes');
		Route::post('/laporan/produksi/gb/update-revision-all', 'updateRevisionNotesAll');
		Route::post('/laporan/produksi/gb/selesai-periode-all', 'selesaiPeriodeAll');
		Route::post('/laporan/produksi/gb/selesai-periode', 'selesaiPeriode');
		Route::post('/laporan/produksi/gb/cetak-periode', 'cetakperiode');
	});

	//pasokan gas bumi
	Route::controller(EvPasokanGasBumiController::class)->group(function () {
		//		Route::get('/laporan/pasokan/gb', 'index');
		//		Route::post('/laporan/pasokan/gb', 'index');
		//		Route::put('/laporan/pasokan/gb/update-revision/{id}', 'updateRevisionNotes')->name('revision-pasokan-gb');
		Route::get('/laporan/pasokan/gb', 'index');
		Route::get('/laporan/pasokan/gb/periode/{kode}', 'periode');
		Route::get('/laporan/pasokan/gb/{kode}/{filter?}', 'show');
		Route::get('/laporan/pasokan/gb-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/pasokan/gb-lihat-semua-data', 'filterData');
		Route::post('/laporan/pasokan/gb/update-revision', 'updateRevisionNotes');
		Route::post('/laporan/pasokan/gb/update-revision-all', 'updateRevisionNotesAll');
		Route::post('/laporan/pasokan/gb/selesai-periode-all', 'selesaiPeriodeAll');
		Route::post('/laporan/pasokan/gb/selesai-periode', 'selesaiPeriode');
		Route::post('/laporan/pasokan/gb/cetak-periode', 'cetakperiode');
	});

	//distribusi gas bumi
	Route::controller(EvDistribusiGasBumiController::class)->group(function () {
		//		Route::get('/laporan/distribusi/gb', 'index');
		//		Route::post('/laporan/distribusi/gb', 'index');
		//		Route::put('/laporan/distribusi/gb/update-revision/{id}', 'updateRevisionNotes')->name('revision-distribusi-gb');

		Route::get('/laporan/distribusi/gb', 'index');
		Route::get('/laporan/distribusi/gb/periode/{kode}', 'periode');
		Route::get('/laporan/distribusi/gb/{kode}/{filter?}', 'show');
		Route::get('/laporan/distribusi/gb-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/distribusi/gb-lihat-semua-data', 'filterData');
		Route::post('/laporan/distribusi/gb/update-revision', 'updateRevisionNotes');
		Route::post('/laporan/distribusi/gb/update-revision-all', 'updateRevisionNotesAll');
		Route::post('/laporan/distribusi/gb/selesai-periode-all', 'selesaiPeriodeAll');
		Route::post('/laporan/distribusi/gb/selesai-periode', 'selesaiPeriode');
		Route::post('/laporan/distribusi/gb/cetak-periode', 'cetakperiode');
	});

	//export
	Route::controller(EvExporController::class)->group(function () {
		//		Route::get('/laporan/expor/exim', 'index');
		//		Route::post('/laporan/expor/exim', 'index');
		//		Route::put('/laporan/expor/exim/update-revision/{id}', 'updateRevisionNotes')->name('revision-expor-exim');

		Route::get('/laporan/expor/exim', 'index');
		Route::get('/laporan/expor/exim/periode/{kode}', 'periode');
		Route::get('/laporan/expor/exim/{kode}', 'show');
		Route::get('/laporan/expor/exim-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/expor/exim-lihat-semua-data', 'filterData');
		Route::post('/laporan/expor/exim/update-revision', 'updateRevisionNotes');
		Route::post('/laporan/expor/exim/update-revision-all', 'updateRevisionNotesAll');
		Route::post('/laporan/expor/exim/selesai-periode-all', 'selesaiPeriodeAll');
		Route::post('/laporan/expor/exim/selesai-periode', 'selesaiPeriode');
		Route::post('/laporan/expor/exim/cetak-periode', 'cetakperiode');
	});

	//export
	Route::controller(EvImporController::class)->group(function () {
		//		Route::get('/laporan/impor/exim', 'index');
		//		Route::post('/laporan/impor/exim', 'index');
		//		Route::put('/laporan/impor/exim/update-revision/{id}', 'updateRevisionNotes')->name('revision-impor-exim');

		Route::get('/laporan/impor/exim', 'index');
		Route::get('/laporan/impor/exim/periode/{kode}', 'periode');
		Route::get('/laporan/impor/exim/{kode}', 'show');
		Route::get('/laporan/impor/exim-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/impor/exim-lihat-semua-data', 'filterData');
		Route::post('/laporan/impor/exim/update-revision', 'updateRevisionNotes');
		Route::post('/laporan/impor/exim/update-revision-all', 'updateRevisionNotesAll');
		Route::post('/laporan/impor/exim/selesai-periode-all', 'selesaiPeriodeAll');
		Route::post('/laporan/impor/exim/selesai-periode', 'selesaiPeriode');
		Route::post('/laporan/impor/exim/cetak-periode', 'cetakperiode');
	});

	//penyimpanan minyak bumi
	Route::controller(EvPenyimpananMinyakBumiController::class)->group(function () {
		Route::get('/laporan/penyimpanan/mb', 'index');
		Route::get('/laporan/penyimpanan/mb/periode/{kode}', 'periode');
		Route::get('/laporan/penyimpanan/mb/{kode}', 'show');
		Route::get('/laporan/penyimpanan/mb-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/penyimpanan/mb-lihat-semua-data', 'filterData');
		Route::post('/laporan/penyimpanan/mb/update-revision', 'updateRevisionNotes');
		Route::post('/laporan/penyimpanan/mb/update-revision-all', 'updateRevisionNotesAll');
		Route::post('/laporan/penyimpanan/mb/selesai-periode-all', 'selesaiPeriodeAll');
		Route::post('/laporan/penyimpanan/mb/selesai-periode', 'selesaiPeriode');
		Route::post('/laporan/penyimpanan/mb/cetak-periode', 'cetakperiode');
	});

	//penyimpanan gas bumi
	Route::controller(EvPenyimpananGasBumiController::class)->group(function () {
		Route::get('/laporan/penyimpanan/gb', 'index');
		Route::get('/laporan/penyimpanan/gb/{kode}', 'show');
		Route::get('/laporan/penyimpanan/gb-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/penyimpanan/gb-lihat-semua-data', 'filterData');
		Route::get('/laporan/penyimpanan/gb/periode/{kode}', 'periode');
		Route::post('/laporan/penyimpanan/gb/update-revision', 'updateRevisionNotes');
		Route::post('/laporan/penyimpanan/gb/update-revision-all', 'updateRevisionNotesAll');
		Route::post('/laporan/penyimpanan/gb/selesai-periode-all', 'selesaiPeriodeAll');
		Route::post('/laporan/penyimpanan/gb/selesai-periode', 'selesaiPeriode');
		Route::post('/laporan/penyimpanan/gb/cetak-periode', 'cetakperiode');
	});

	//pengangkutan minyak bumi
	Route::controller(EvPengangkutanMinyakBumiController::class)->group(function () {
		Route::get('/laporan/pengangkutan/mb', 'index');
		Route::get('/laporan/pengangkutan/mb/periode/{kode}', 'periode');
		Route::get('/laporan/pengangkutan/mb/{kode}', 'show');
		Route::get('/laporan/pengangkutan/mb-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/pengangkutan/mb-lihat-semua-data', 'filterData');
		Route::post('/laporan/pengangkutan/mb/update-revision', 'updateRevisionNotes');
		Route::post('/laporan/pengangkutan/mb/update-revision-all', 'updateRevisionNotesAll');
		Route::post('/laporan/pengangkutan/mb/selesai-periode-all', 'selesaiPeriodeAll');
		Route::post('/laporan/pengangkutan/mb/selesai-periode', 'selesaiPeriode');
		Route::post('/laporan/pengangkutan/mb/cetak-periode', 'cetakperiode');
	});

	// Progres pembangunan
	Route::controller(EvProgresPembangunanController::class)->group(function () {
		Route::get('/laporan/progres-pembangunan', 'index');
		Route::post('/laporan/progres-pembangunan/lihat-semua-data', 'filterData');
		Route::get('/laporan/progres-pembangunan/lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/progres-pembangunan/cetak-periode', 'cetakperiode');
		Route::get('/laporan/progres-pembangunan/{kode}', 'show');
		Route::post('/laporan/progres-pembangunan/update-revision', 'updateRevisionNotes');
		Route::post('/laporan/progres-pembangunan/update-revision-all', 'updateRevisionNotesAll');
		Route::post('/laporan/progres-pembangunan/selesai-periode-all', 'selesaiPeriodeAll');
		Route::post('/laporan/progres-pembangunan/selesai-periode', 'selesaiPeriode');
	});


	// Permissions route group
	Route::controller(PermissionController::class)->group(function () {
		Route::get('/permission', 'index')->name('permission.index');
		Route::get('/permission/json', 'jsonpermission')->name('permission.json');
		Route::get('/permission/create', 'create')->name('permission.create');
		Route::post('/permission', 'store')->name('permission.store');
	});

	// Logs Evaluator User Management
	// routes/web.php
	Route::controller(LogsEvController::class)->group(function () {
		Route::get('/logs', 'index')->name('logs.index');
		Route::get('/logs/periode/{bu_id}', 'periode')->name('logs.periode');
		Route::get('/logs/properties/{id}', 'properties')->name('logs.properties');
		Route::get('/logs/old_properties/{id}', 'properties_old')->name('logs.properties_old');
		// Route::get('/logs/show/{filter?}/{value?}', 'show')->name('logs.show');
		Route::get('/logs/show/{bu_id?}/{filter?}/{value?}', 'show')->name('logs.show');
	});

		Route::controller(LogsEvaluatorController::class)->group(function () {
		Route::get('/logs-ev', 'index')->name('logs-ev.index');
		Route::get('/logs-ev/periode/{bu_id}', 'periode')->name('logs-ev.periode');
		Route::get('/logs-ev/properties/{id}', 'properties')->name('logs-ev.properties');
		Route::get('/logs-ev/old_properties/{id}', 'properties_old')->name('logs-ev.properties_old');
		Route::get('/logs-ev/show/{bu_id?}/{filter?}/{value?}', 'show')->name('logs-ev.show');
	});


	// Role access management route group
	Route::controller(RoleController::class)->group(function () {
		Route::get('/role', 'index')->name('role.index');
		Route::get('/role/create', 'create')->name('role.create');
		Route::post('/role', 'store')->name('role.store');
		Route::get('/role/edit/{role}', 'edit')->name('role.edit');
		Route::patch('/role/update/{role}', 'update')->name('role.update');
	});

	Route::controller(UserController::class)->group(function () {
		Route::get('/user', 'index')->name('user.index');
		Route::get('/user-badan-usaha', 'index_bu')->name('user.index_bu');
		Route::get('/user-admin', 'create')->name('user.create');
		Route::post('/user-admin-store', 'store')->name('user.store');
		Route::get('/user/edit/admin/{user}', 'edit')->name('user.edit');
		Route::put('/user/update/admin', 'update');
		Route::delete('/hapus-user/admin/{id}', 'destroy');
	});
	//pengangkutan Gas bumi
	Route::controller(EvPengangkutanGasBumiController::class)->group(function () {
		Route::get('/laporan/pengangkutan/gb', 'index');
		Route::get('/laporan/pengangkutan/gb/{kode}', 'show');
		Route::get('/laporan/pengangkutan/gb-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/pengangkutan/gb-lihat-semua-data', 'filterData');
		Route::get('/laporan/pengangkutan/gb/periode/{kode}', 'periode');
		Route::post('/laporan/pengangkutan/gb/update-revision', 'updateRevisionNotes');
		Route::post('/laporan/pengangkutan/gb/update-revision-all', 'updateRevisionNotesAll');
		Route::post('/laporan/pengangkutan/gb/selesai-periode-all', 'selesaiPeriodeAll');
		Route::post('/laporan/pengangkutan/gb/selesai-periode', 'selesaiPeriode');
		Route::post('/laporan/pengangkutan/gb/cetak-periode', 'cetakperiode');
	});

	//Penjualan JBKP
	Route::controller(EvPenjualanJbkp::class)->group(function () {
		Route::get('/laporan/penjualan-jbkp', 'index');
		Route::get('/laporan/penjualan-jbkp/periode/{kode}', 'periode');
		Route::get('/laporan/penjualan-jbkp/{kode}', 'show');
		Route::get('/laporan/penjualan-jbkp-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/penjualan-jbkp-lihat-semua-data', 'filterData');
		Route::post('/laporan/penjualan-jbkp/cetak-periode', 'cetakperiode');
		Route::get('/laporan/sinkronisasi-data/penjualan-jbkp', 'sinkronisasiData');
	});
	//Penjualan JBT
	Route::controller(EvPenjualanJbt::class)->group(function () {
		Route::get('/laporan/penjualan-jbt', 'index');
		Route::get('/laporan/penjualan-jbt/{kode}', 'show');
		Route::get('/laporan/penjualan-jbt-lihat-semua-data', 'lihatSemuaData');

		
		// Route::post('/laporan/penjualan-jbt-lihat-semua-data', 'filterData');
		Route::get('/laporan/penjualan-jbt-lihat-semua-data', 'filterData');

		Route::get('/laporan/penjualan-jbt/periode/{kode}', 'periode');
		Route::post('/laporan/penjualan-jbt/cetak-periode', 'cetakperiode');
		Route::get('/laporan/sinkronisasi-data/penjualan-jbt', 'sinkronisasiData');
	});
	//Penjualan JBU
	Route::controller(EvPenjualanJbu::class)->group(function () {
		Route::get('/laporan/penjualan-jbu', 'index');
		Route::get('/laporan/penjualan-jbu/{kode}', 'show');
		Route::get('/laporan/penjualan-jbu-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/penjualan-jbu-lihat-semua-data', 'filterData');
		Route::get('/laporan/penjualan-jbu/periode/{kode}', 'periode');
		Route::post('/laporan/penjualan-jbu/cetak-periode', 'cetakperiode');
		Route::get('/laporan/sinkronisasi-data/penjualan-jbu', 'sinkronisasiData');
	});
	//Penjualan BBM
	Route::controller(EvPenjualanBbm::class)->group(function () {
		Route::get('/laporan/penjualan-bbm', 'index');
		Route::get('/laporan/penjualan-bbm/{kode}', 'show');
		Route::get('/laporan/penjualan-bbm-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/penjualan-bbm-lihat-semua-data', 'filterData');
		Route::get('/laporan/penjualan-bbm/periode/{kode}', 'periode');
		Route::post('/laporan/penjualan-bbm/cetak-periode', 'cetakperiode');
		Route::get('/laporan/sinkronisasi-data/penjualan-bbm', 'sinkronisasiData');
	});
	//Kuota JBT
	Route::controller(EvKuotaJbt::class)->group(function () {
		Route::get('/laporan/kuota-jbt', 'index');
		Route::get('/laporan/kuota-jbt/{kode}', 'show');
		Route::get('/laporan/kuota-jbt-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/kuota-jbt-lihat-semua-data', 'filterData');
		Route::get('/laporan/kuota-jbt/periode/{kode}', 'periode');
		Route::post('/laporan/kuota-jbt/cetak-periode', 'cetakperiode');
		Route::get('/laporan/sinkronisasi-data/kuota-jbt', 'sinkronisasiData');
	});
	//Kuota JBKP
	Route::controller(EvKuotaJbkp::class)->group(function () {
		Route::get('/laporan/kuota-jbkp', 'index');
		Route::get('/laporan/kuota-jbkp/{kode}', 'show');
		Route::get('/laporan/kuota-jbkp-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/kuota-jbkp-lihat-semua-data', 'filterData');
		Route::get('/laporan/kuota-jbkp/periode/{kode}', 'periode');
		Route::post('/laporan/kuota-jbkp/cetak-periode', 'cetakperiode');
		Route::get('/laporan/sinkronisasi-data/kuota-jbkp', 'sinkronisasiData');
	});
	//Penjualan Gas Bumi
	Route::controller(EvBphPenjualanGasBumi::class)->group(function () {
		Route::get('/laporan/penjualan-gas-bumi', 'index');
		Route::get('/laporan/penjualan-gas-bumi/{kode}', 'show');
		Route::get('/laporan/penjualan-gas-bumi-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/penjualan-gas-bumi-lihat-semua-data', 'filterData');
		Route::get('/laporan/penjualan-gas-bumi/periode/{kode}', 'periode');
		Route::post('/laporan/penjualan-gas-bumi/cetak-periode', 'cetakperiode');
		Route::get('/laporan/sinkronisasi-data/penjualan-gas-bumi', 'sinkronisasiData');
	});
	//Pasokan Gas Bumi
	Route::controller(EvBphPasokanGasBumi::class)->group(function () {
		Route::get('/laporan/pasokan-gas-bumi', 'index');
		Route::get('/laporan/pasokan-gas-bumi/{kode}', 'show');
		Route::get('/laporan/pasokan-gas-bumi-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/pasokan-gas-bumi-lihat-semua-data', 'filterData');
		Route::get('/laporan/pasokan-gas-bumi/periode/{kode}', 'periode');
		Route::post('/laporan/pasokan-gas-bumi/cetak-periode', 'cetakperiode');
		Route::get('/laporan/sinkronisasi-data/pasokan-gas-bumi', 'sinkronisasiData');
	});
	//Pengangkutan Gas
	Route::controller(EvBphPengangkutanGas::class)->group(function () {
		Route::get('/laporan/pengangkutan-gas', 'index');
		Route::get('/laporan/pengangkutan-gas/{kode}', 'show');
		Route::get('/laporan/pengangkutan-gas-lihat-semua-data', 'lihatSemuaData');
		Route::post('/laporan/pengangkutan-gas-lihat-semua-data', 'filterData');
		Route::get('/laporan/pengangkutan-gas/periode/{kode}', 'periode');
		Route::post('/laporan/pengangkutan-gas/cetak-periode', 'cetakperiode');
		Route::get('/laporan/sinkronisasi-data/pengangkutan-gas', 'sinkronisasiData');
	});

	



	Route::get('/logout', [AuthEvaluatorController::class, 'logout']);
});
Route::controller(IzinMigasController::class)->group(function () {
	Route::get('/izin-migas/simpan', 'store');
});
