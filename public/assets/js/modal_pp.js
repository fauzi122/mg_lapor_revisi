// Tentukan apakah situs diakses dari localhost atau duniasakha.com
var isLocalhost = window.location.hostname === 'mg_lapor_revisi.test' || window.location.hostname === '127.0.0.1' || window.location.hostname === 'localhost' || window.location.hostname.endsWith('duniasakha.com');
// Atur baseUrl berdasarkan apakah situs diakses dari localhost atau duniasakha.com
var baseUrl = isLocalhost ? "/" : "/pelaporan-hilir/";

function edit_pp(id) {
    // $('.editPenjualan').click(function () {
    //     let id = $(this).attr('data-id')
    // Kirim data melalui Ajax
    $.ajax({
        url: baseUrl + "get-izinSementara/" + id,
        method: "GET",
        data: {
            id: id,
        },
        success: function (response) {
            console.log(response);
            // Tangkap pesan dari server dan tampilkan ke user
            $("#form_pp").attr(
                "action",
                baseUrl + "update_izinSementara/" + response.data.find.id
            );

            $("#edit_prosentase_pembangunan").val(response.data.find.prosentase_pembangunan);
            $("#edit_realisasi_investasi").val(response.data.find.realisasi_investasi);
            $("#edit_tkdn").val(response.data.find.tkdn);
        },
        error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert("Terjadi kesalahan saat mengirim data.");
        },
    });
    //   })
}
