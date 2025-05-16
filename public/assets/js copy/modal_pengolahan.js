// Tentukan apakah situs diakses dari localhost atau lapor.duniasakha.com
var isLocalhost = window.location.hostname === '127.0.0.1' || window.location.hostname === 'localhost' || window.location.hostname === 'lapor.duniasakha.com';

// Atur baseUrl berdasarkan apakah situs diakses dari localhost atau lapor.duniasakha.com
var baseUrl = isLocalhost ? "/" : "/pelaporan-hilir/";

// Pengolahan Minyak Bumi
function editPengolahan(id, produk, kabupaten_kota) {
    // $('.editPenjualan').click(function () {
    //   let id = $(this).attr('data-id')
    // Kirim data melalui Ajax
    $.ajax({
        url: baseUrl +"get_Pengolahan/" + id,
        method: "GET",
        data: {
            id: id,
        },
        success: function (response) {
            // console.log(response);
            // console.log(response.data.find.tipe);
            // Tangkap pesan dari server dan tampilkan ke user
            let produkSelect = response.data.find.produk;
            let intakeSelect = response.data.find.intake_kilang;
            let satuanSelect = response.data.find.satuan;
            let provinsiSelect = response.data.find.provinsi;
            let kotaSelect = response.data.find.kabupaten_kota;
            let sektorSelect = response.data.find.sektor;
            let bulanx = response.data.find.bulan.substring(0, 7);

            if (
                response.data.find.jenis == "Minyak Bumi" &&
                response.data.find.tipe == "Produksi"
            ) {
                $("#form_updatePengolahanProduksiMB").attr(
                    "action",
                    baseUrl + "update_pengolahan_minyak_bumi_produksi/" +
                        response.data.find.id
                );
                $("#badan_usaha_id").val(response.data.find.badan_usaha_id);
                $("#izin_id").val(response.data.find.izin_id);
                // $('#bulan_produksi').val(response.data.find.bulan)
                $("#bulan_produksi").val(bulanx);
                $("#volume_pengolahanProduksi").val(response.data.find.volume);
                $("#keterangan_pengolahanProduksi").val(
                    response.data.find.keterangan
                );
                $("#status_pengolahanProduksiMB").val(
                    response.data.find.status
                );

                $("#produk_pengolahanProduksi").empty();
                $("#produk_pengolahanProduksi").append(
                    ` <option>Pilih Produk</option>`
                );
                $.each(response.data.produk, function (i, value) {
                    let isSelected =
                        produkSelect == value.name ? "selected" : "";
                    $("#produk_pengolahanProduksi").append(
                        `<option value="` +
                            value.name +
                            `"` +
                            isSelected +
                            `>` +
                            value.name +
                            `</option>`
                    );
                });

                $.ajax({
                    url: baseUrl +"get_satuan/" + produk,
                    method: "GET",
                    data: {},
                    success: function (response) {
                        // console.log(response);
                        // Loop melalui data dan tambahkan opsi ke dalam select
                        $("#satuan_pengolahanProduksi").empty();
                        $("#satuan_pengolahanProduksi").append(
                            ` <option>Pilih Satuan</option>`
                        );
                        $.each(
                            response.data.satuan_produk,
                            function (i, value) {
                                let isSelected =
                                    satuanSelect == value.satuan
                                        ? "selected"
                                        : "";
                                $("#satuan_pengolahanProduksi").append(
                                    `<option value="` +
                                        value.satuan +
                                        `" ` +
                                        isSelected +
                                        `>` +
                                        value.satuan +
                                        `</option>`
                                );
                            }
                        );
                    },
                    error: function (xhr, status, error) {
                        // Tangkap pesan error jika ada
                        alert("Terjadi kesalahan saat mengirim data SATUAN.");
                    },
                });

                $("#provinsi_produksi").empty();
                $("#provinsi_produksi").append(
                    ` <option>Pilih Provinsi</option>`
                );
                $.each(response.data.provinsi, function (i, value) {
                    let isSelected =
                        provinsiSelect.toLowerCase() == value.name.toLowerCase()
                            ? "selected"
                            : "";
                    $("#provinsi_produksi").append(
                        `<option data-id="` +
                            value.id +
                            `" value="` +
                            value.name +
                            `"` +
                            isSelected +
                            `>` +
                            value.name +
                            `</option>`
                    );
                });

                $.ajax({
                    url: baseUrl +"get_kota_pengolahan/" + kabupaten_kota,
                    method: "GET",
                    data: {},
                    success: function (response) {
                        // Loop melalui data dan tambahkan opsi ke dalam select
                        $("#nama_kota_pengolahaProduksi").empty();
                        $("#nama_kota_pengolahaProduksi").append(
                            ` <option>Pilih Kabupaten / Kota</option>`
                        );
                        $.each(response.data, function (i, value) {
                            let isSelected =
                                kotaSelect == value.nama_kota ? "selected" : "";
                            $("#nama_kota_pengolahaProduksi").append(
                                `<option value="` +
                                    value.nama_kota +
                                    `" ` +
                                    isSelected +
                                    `>` +
                                    value.nama_kota +
                                    `</option>`
                            );
                        });
                    },
                    error: function (xhr, status, error) {
                        // Tangkap pesan error jika ada
                        alert(
                            "Terjadi kesalahan saat mengirim data KABUPATEN / KOTA."
                        );
                    },
                });
            } else if (
                response.data.find.jenis == "Minyak Bumi" &&
                response.data.find.tipe == "Pasokan"
            ) {
                $("#form_updatePengolahanPasokanMB").attr(
                    "action",
                    baseUrl + "update_pengolahan_minyak_bumi_pasokan/" +
                        response.data.find.id
                );
                $("#badan_usaha_id_pasokan").val(
                    response.data.find.badan_usaha_id
                );
                $("#izin_id_pasokan").val(response.data.find.izin_id);
                // $('#bulan_pasokan').val(response.data.find.bulan)
                $("#bulan_pasokan").val(bulanx);
                $("#kategori_pemasokPasokan").val(
                    response.data.find.kategori_pemasok
                );
                $("#volume_pengolahanPasokan").val(response.data.find.volume);
                $("#keterangan_pengolahanPasokan").val(
                    response.data.find.keterangan
                );
                $("#status_pengolahanPasokanMB").val(response.data.find.status);

                $("#intake_kilangPasokan").empty();
                $("#intake_kilangPasokan").append(
                    ` <option>Pilih Intake Kilang</option>`
                );
                $.each(response.data.intake, function (i, value) {
                    let isSelected =
                        intakeSelect.toLowerCase() ==
                        value.nm_produk.toLowerCase()
                            ? "selected"
                            : "";
                    $("#intake_kilangPasokan").append(
                        `<option value="` +
                            value.nm_produk +
                            `"` +
                            isSelected +
                            `>` +
                            value.nm_produk +
                            `</option>`
                    );
                });

                $.ajax({
                    url: baseUrl +"get_satuan/" + produk,
                    method: "GET",
                    data: {},
                    success: function (response) {
                        // console.log(response);
                        // Loop melalui data dan tambahkan opsi ke dalam select
                        $("#satuan_pengolahanPasokan").empty();
                        $("#satuan_pengolahanPasokan").append(
                            ` <option>Pilih Satuan</option>`
                        );
                        $.each(
                            response.data.satuan_intake,
                            function (i, value) {
                                let isSelected =
                                    satuanSelect == value.satuan
                                        ? "selected"
                                        : "";
                                $("#satuan_pengolahanPasokan").append(
                                    `<option value="` +
                                        value.satuan +
                                        `" ` +
                                        isSelected +
                                        `>` +
                                        value.satuan +
                                        `</option>`
                                );
                            }
                        );
                    },
                    error: function (xhr, status, error) {
                        // Tangkap pesan error jika ada
                        alert("Terjadi kesalahan saat mengirim data SATUAN.");
                    },
                });

                $("#provinsi_pasokan").empty();
                $("#provinsi_pasokan").append(
                    ` <option>Pilih Provinsi</option>`
                );
                $.each(response.data.provinsi, function (i, value) {
                    let isSelected =
                        provinsiSelect.toLowerCase() == value.name.toLowerCase()
                            ? "selected"
                            : "";
                    $("#provinsi_pasokan").append(
                        `<option data-id="` +
                            value.id +
                            `" value="` +
                            value.name +
                            `"` +
                            isSelected +
                            `>` +
                            value.name +
                            `</option>`
                    );
                });

                $.ajax({
                    url: baseUrl +"get_kota_pengolahan/" + kabupaten_kota,
                    method: "GET",
                    data: {},
                    success: function (response) {
                        // Loop melalui data dan tambahkan opsi ke dalam select
                        $("#nama_kota_pengolahaPasokan").empty();
                        $("#nama_kota_pengolahaPasokan").append(
                            ` <option>Pilih Kabupaten / Kota</option>`
                        );
                        $.each(response.data, function (i, value) {
                            let isSelected =
                                kotaSelect == value.nama_kota ? "selected" : "";
                            $("#nama_kota_pengolahaPasokan").append(
                                `<option value="` +
                                    value.nama_kota +
                                    `" ` +
                                    isSelected +
                                    `>` +
                                    value.nama_kota +
                                    `</option>`
                            );
                        });
                    },
                    error: function (xhr, status, error) {
                        // Tangkap pesan error jika ada
                        alert(
                            "Terjadi kesalahan saat mengirim data KABUPATEN / KOTA."
                        );
                    },
                });
            } else if (
                response.data.find.jenis == "Minyak Bumi" &&
                response.data.find.tipe == "Distribusi"
            ) {
                $("#form_updatePengolahanDistribusiMB").attr(
                    "action",
                    baseUrl + "update_pengolahan_minyak_bumi_distribusi/" +
                        response.data.find.id
                );
                $("#badan_usaha_id_distribusi").val(
                    response.data.find.badan_usaha_id
                );
                $("#izin_id_distribusi").val(response.data.find.izin_id);
                // $('#bulan_distribusi').val(response.data.find.bulan)
                $("#bulan_distribusi").val(bulanx);
                $("#sektor_pengolahanDistribusi").val(
                    response.data.find.sektor
                );
                $("#volume_pengolahanDistribusi").val(
                    response.data.find.volume
                );
                $("#keterangan_pengolahanDistribusi").val(
                    response.data.find.keterangan
                );
                $("#status_pengolahanDistribusiMB").val(
                    response.data.find.status
                );

                $("#produk_pengolahanDistribusi").empty();
                $("#produk_pengolahanDistribusi").append(
                    ` <option>Pilih Produk</option>`
                );
                $.each(response.data.produk, function (i, value) {
                    let isSelected =
                        produkSelect == value.name ? "selected" : "";
                    $("#produk_pengolahanDistribusi").append(
                        `<option value="` +
                            value.name +
                            `"` +
                            isSelected +
                            `>` +
                            value.name +
                            `</option>`
                    );
                });

                $.ajax({
                    url: baseUrl +"get_satuan/" + produk,
                    method: "GET",
                    data: {},
                    success: function (response) {
                        // console.log(response);
                        // Loop melalui data dan tambahkan opsi ke dalam select
                        $("#satuan_pengolahanDistribusi").empty();
                        $("#satuan_pengolahanDistribusi").append(
                            ` <option>Pilih Satuan</option>`
                        );
                        $.each(
                            response.data.satuan_produk,
                            function (i, value) {
                                let isSelected =
                                    satuanSelect == value.satuan
                                        ? "selected"
                                        : "";
                                $("#satuan_pengolahanDistribusi").append(
                                    `<option value="` +
                                        value.satuan +
                                        `" ` +
                                        isSelected +
                                        `>` +
                                        value.satuan +
                                        `</option>`
                                );
                            }
                        );
                    },
                    error: function (xhr, status, error) {
                        // Tangkap pesan error jika ada
                        alert("Terjadi kesalahan saat mengirim data SATUAN.");
                    },
                });

                $("#provinsi_distribusi").empty();
                $("#provinsi_distribusi").append(
                    ` <option>Pilih Provinsi</option>`
                );
                $.each(response.data.provinsi, function (i, value) {
                    let isSelected =
                        provinsiSelect.toLowerCase() == value.name.toLowerCase()
                            ? "selected"
                            : "";
                    $("#provinsi_distribusi").append(
                        `<option data-id="` +
                            value.id +
                            `" value="` +
                            value.name +
                            `"` +
                            isSelected +
                            `>` +
                            value.name +
                            `</option>`
                    );
                });

                $.ajax({
                    url: baseUrl +"get_kota_pengolahan/" + kabupaten_kota,
                    method: "GET",
                    data: {},
                    success: function (response) {
                        // Loop melalui data dan tambahkan opsi ke dalam select
                        $("#nama_kota_pengolahaDistribusi").empty();
                        $("#nama_kota_pengolahaDistribusi").append(
                            ` <option>Pilih Kabupaten / Kota</option>`
                        );
                        $.each(response.data, function (i, value) {
                            let isSelected =
                                kotaSelect == value.nama_kota ? "selected" : "";
                            $("#nama_kota_pengolahaDistribusi").append(
                                `<option value="` +
                                    value.nama_kota +
                                    `" ` +
                                    isSelected +
                                    `>` +
                                    value.nama_kota +
                                    `</option>`
                            );
                        });
                    },
                    error: function (xhr, status, error) {
                        // Tangkap pesan error jika ada
                        alert(
                            "Terjadi kesalahan saat mengirim data KBAUPATEN / KOTA."
                        );
                    },
                });
            } else if (
                response.data.find.jenis == "Gas Bumi" &&
                response.data.find.tipe == "Produksi"
            ) {
                $("#form_updatePengolahanProduksiGB").attr(
                    "action",
                    baseUrl + "update_pengolahan_gas_bumi_produksi/" +
                        response.data.find.id
                );
                $("#badan_usaha_id").val(response.data.find.badan_usaha_id);
                $("#izin_id").val(response.data.find.izin_id);
                // $('#bulan_produksi').val(response.data.find.bulan)
                $("#bulan_produksi").val(bulanx);
                $("#volume_pengolahanProduksi").val(response.data.find.volume);
                $("#status_pengolahanProduksiGB").val(
                    response.data.find.status
                );

                $("#produk_pengolahanProduksi").empty();
                $("#produk_pengolahanProduksi").append(
                    ` <option>Pilih Produk</option>`
                );
                $.each(response.data.produk, function (i, value) {
                    let isSelected =
                        produkSelect == value.name ? "selected" : "";
                    $("#produk_pengolahanProduksi").append(
                        `<option value="` +
                            value.name +
                            `"` +
                            isSelected +
                            `>` +
                            value.name +
                            `</option>`
                    );
                });

                $.ajax({
                    url: baseUrl +"get_satuan/" + produk,
                    method: "GET",
                    data: {},
                    success: function (response) {
                        // console.log(response);
                        // Loop melalui data dan tambahkan opsi ke dalam select
                        $("#satuan_pengolahanProduksi").empty();
                        $("#satuan_pengolahanProduksi").append(
                            ` <option>Pilih Satuan</option>`
                        );
                        $.each(
                            response.data.satuan_produk,
                            function (i, value) {
                                let isSelected =
                                    satuanSelect == value.satuan
                                        ? "selected"
                                        : "";
                                $("#satuan_pengolahanProduksi").append(
                                    `<option value="` +
                                        value.satuan +
                                        `" ` +
                                        isSelected +
                                        `>` +
                                        value.satuan +
                                        `</option>`
                                );
                            }
                        );
                    },
                    error: function (xhr, status, error) {
                        // Tangkap pesan error jika ada
                        alert("Terjadi kesalahan saat mengirim data SATUAN.");
                    },
                });

                $("#provinsi_produksi").empty();
                $("#provinsi_produksi").append(
                    ` <option>Pilih Provinsi</option>`
                );
                $.each(response.data.provinsi, function (i, value) {
                    let isSelected =
                        provinsiSelect.toLowerCase() == value.name.toLowerCase()
                            ? "selected"
                            : "";
                    $("#provinsi_produksi").append(
                        `<option data-id="` +
                            value.id +
                            `" value="` +
                            value.name +
                            `"` +
                            isSelected +
                            `>` +
                            value.name +
                            `</option>`
                    );
                });

                $.ajax({
                    url: baseUrl +"get_kota_pengolahan/" + kabupaten_kota,
                    method: "GET",
                    data: {},
                    success: function (response) {
                        // Loop melalui data dan tambahkan opsi ke dalam select
                        $("#nama_kota_pengolahaProduksi").empty();
                        $("#nama_kota_pengolahaProduksi").append(
                            ` <option>Pilih Kabupaten / Kota</option>`
                        );
                        $.each(response.data, function (i, value) {
                            let isSelected =
                                kotaSelect == value.nama_kota ? "selected" : "";
                            $("#nama_kota_pengolahaProduksi").append(
                                `<option value="` +
                                    value.nama_kota +
                                    `" ` +
                                    isSelected +
                                    `>` +
                                    value.nama_kota +
                                    `</option>`
                            );
                        });
                    },
                    error: function (xhr, status, error) {
                        // Tangkap pesan error jika ada
                        alert(
                            "Terjadi kesalahan saat mengirim data KABUPATEN / KOTA."
                        );
                    },
                });
            } else if (
                response.data.find.jenis == "Gas Bumi" &&
                response.data.find.tipe == "Pasokan"
            ) {
                $("#form_updatePengolahanPasokanGB").attr(
                    "action",
                    baseUrl + "update_pengolahan_gas_bumi_pasokan/" +
                        response.data.find.id
                );
                $("#badan_usaha_id_pasokan").val(
                    response.data.find.badan_usaha_id
                );
                $("#izin_id_pasokan").val(response.data.find.izin_id);
                // $('#bulan_pasokan').val(response.data.find.bulan)
                $("#bulan_pasokan").val(bulanx);
                $("#volume_pengolahanPasokan").val(response.data.find.volume);
                $("#status_pengolahanPasokanGB").val(response.data.find.status);

                $("#intake_kilangPasokan").empty();
                $("#intake_kilangPasokan").append(
                    ` <option>Pilih Intake Kilang</option>`
                );
                $.each(response.data.intake, function (i, value) {
                    let isSelected =
                        intakeSelect.toLowerCase() ==
                        value.nm_produk.toLowerCase()
                            ? "selected"
                            : "";
                    $("#intake_kilangPasokan").append(
                        `<option value="` +
                            value.nm_produk +
                            `"` +
                            isSelected +
                            `>` +
                            value.nm_produk +
                            `</option>`
                    );
                });

                $.ajax({
                    url: baseUrl +"get_satuan/" + produk,
                    method: "GET",
                    data: {},
                    success: function (response) {
                        // console.log(response);
                        // Loop melalui data dan tambahkan opsi ke dalam select
                        $("#satuan_pengolahanPasokan").empty();
                        $("#satuan_pengolahanPasokan").append(
                            ` <option>Pilih Satuan</option>`
                        );
                        $.each(
                            response.data.satuan_intake,
                            function (i, value) {
                                let isSelected =
                                    satuanSelect == value.satuan
                                        ? "selected"
                                        : "";
                                $("#satuan_pengolahanPasokan").append(
                                    `<option value="` +
                                        value.satuan +
                                        `" ` +
                                        isSelected +
                                        `>` +
                                        value.satuan +
                                        `</option>`
                                );
                            }
                        );
                    },
                    error: function (xhr, status, error) {
                        // Tangkap pesan error jika ada
                        alert("Terjadi kesalahan saat mengirim data SATUAN.");
                    },
                });

                $("#provinsi_pasokan").empty();
                $("#provinsi_pasokan").append(
                    ` <option>Pilih Provinsi</option>`
                );
                $.each(response.data.provinsi, function (i, value) {
                    let isSelected =
                        provinsiSelect.toLowerCase() == value.name.toLowerCase()
                            ? "selected"
                            : "";
                    $("#provinsi_pasokan").append(
                        `<option data-id="` +
                            value.id +
                            `" value="` +
                            value.name +
                            `"` +
                            isSelected +
                            `>` +
                            value.name +
                            `</option>`
                    );
                });

                $.ajax({
                    url: baseUrl +"get_kota_pengolahan/" + kabupaten_kota,
                    method: "GET",
                    data: {},
                    success: function (response) {
                        // Loop melalui data dan tambahkan opsi ke dalam select
                        $("#nama_kota_pengolahaPasokan").empty();
                        $("#nama_kota_pengolahaPasokan").append(
                            ` <option>Pilih Kabupaten / Kota</option>`
                        );
                        $.each(response.data, function (i, value) {
                            let isSelected =
                                kotaSelect == value.nama_kota ? "selected" : "";
                            $("#nama_kota_pengolahaPasokan").append(
                                `<option value="` +
                                    value.nama_kota +
                                    `" ` +
                                    isSelected +
                                    `>` +
                                    value.nama_kota +
                                    `</option>`
                            );
                        });
                    },
                    error: function (xhr, status, error) {
                        // Tangkap pesan error jika ada
                        alert(
                            "Terjadi kesalahan saat mengirim data KABUPATEN / KOTA."
                        );
                    },
                });
            } else if (
                response.data.find.jenis == "Gas Bumi" &&
                response.data.find.tipe == "Distribusi"
            ) {
                $("#form_updatePengolahanDistribusiGB").attr(
                    "action",
                    baseUrl + "update_pengolahan_gas_bumi_distribusi/" +
                        response.data.find.id
                );
                $("#badan_usaha_id_distribusi").val(
                    response.data.find.badan_usaha_id
                );
                $("#izin_id_distribusi").val(response.data.find.izin_id);
                // $('#bulan_distribusi').val(response.data.find.bulan)
                $("#bulan_distribusi").val(bulanx);
                $("#sektor_pengolahanDistribusi").val(
                    response.data.find.sektor
                );
                $("#volume_pengolahanDistribusi").val(
                    response.data.find.volume
                );
                $("#status_pengolahanDistribusiMB").val(
                    response.data.find.status
                );

                $("#sektor_pengolahanDistribusi").empty();
                $("#sektor_pengolahanDistribusi").append(
                    ` <option>Pilih Sektor</option>`
                );
                $.each(response.data.sektor, function (i, value) {
                    let isSelected =
                        sektorSelect == value.nama_sektor ? "selected" : "";

                    $("#sektor_pengolahanDistribusi").append(
                        `<option value="` +
                            value.nama_sektor +
                            `"` +
                            isSelected +
                            `>` +
                            value.nama_sektor +
                            `</option>`
                    );
                });

                $("#produk_pengolahanDistribusi").empty();
                $("#produk_pengolahanDistribusi").append(
                    ` <option>Pilih Produk</option>`
                );
                $.each(response.data.produk, function (i, value) {
                    let isSelected =
                        produkSelect == value.name ? "selected" : "";
                    $("#produk_pengolahanDistribusi").append(
                        `<option value="` +
                            value.name +
                            `"` +
                            isSelected +
                            `>` +
                            value.name +
                            `</option>`
                    );
                });

                $.ajax({
                    url: baseUrl +"get_satuan/" + produk,
                    method: "GET",
                    data: {},
                    success: function (response) {
                        // console.log(response);
                        // Loop melalui data dan tambahkan opsi ke dalam select
                        $("#satuan_pengolahanDistribusi").empty();
                        $("#satuan_pengolahanDistribusi").append(
                            ` <option>Pilih Satuan</option>`
                        );
                        $.each(
                            response.data.satuan_produk,
                            function (i, value) {
                                let isSelected =
                                    satuanSelect == value.satuan
                                        ? "selected"
                                        : "";
                                $("#satuan_pengolahanDistribusi").append(
                                    `<option value="` +
                                        value.satuan +
                                        `" ` +
                                        isSelected +
                                        `>` +
                                        value.satuan +
                                        `</option>`
                                );
                            }
                        );
                    },
                    error: function (xhr, status, error) {
                        // Tangkap pesan error jika ada
                        alert("Terjadi kesalahan saat mengirim data SATUAN.");
                    },
                });

                $("#provinsi_distribusi").empty();
                $("#provinsi_distribusi").append(
                    ` <option>Pilih Provinsi</option>`
                );
                $.each(response.data.provinsi, function (i, value) {
                    let isSelected =
                        provinsiSelect.toLowerCase() == value.name.toLowerCase()
                            ? "selected"
                            : "";
                    $("#provinsi_distribusi").append(
                        `<option data-id="` +
                            value.id +
                            `" value="` +
                            value.name +
                            `"` +
                            isSelected +
                            `>` +
                            value.name +
                            `</option>`
                    );
                });

                $.ajax({
                    url: baseUrl +"get_kota_pengolahan/" + kabupaten_kota,
                    method: "GET",
                    data: {},
                    success: function (response) {
                        // Loop melalui data dan tambahkan opsi ke dalam select
                        $("#nama_kota_pengolahaDistribusi").empty();
                        $("#nama_kota_pengolahaDistribusi").append(
                            ` <option>Pilih Kabupaten / Kota</option>`
                        );
                        $.each(response.data, function (i, value) {
                            let isSelected =
                                kotaSelect == value.nama_kota ? "selected" : "";
                            $("#nama_kota_pengolahaDistribusi").append(
                                `<option value="` +
                                    value.nama_kota +
                                    `" ` +
                                    isSelected +
                                    `>` +
                                    value.nama_kota +
                                    `</option>`
                            );
                        });
                    },
                    error: function (xhr, status, error) {
                        // Tangkap pesan error jika ada
                        alert(
                            "Terjadi kesalahan saat mengirim data KBAUPATEN / KOTA."
                        );
                    },
                });
            }
            // Contoh: Lakukan tindakan selanjutnya setelah data berhasil dikirim
            // window.location.href = '/success-page';
        },
        error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert("Terjadi kesalahan saat mengirim data ID Pengolahan.");
        },
    });
    // })
}

function lihatPengolahan(id) {
    // $('.editPenjualan').click(function () {
    //   let id = $(this).attr('data-id')
    // Kirim data melalui Ajax
    $.ajax({
        url: baseUrl +"get_Pengolahan/" + id,
        method: "GET",
        data: {
            id: id,
        },
        success: function (response) {
            // Tangkap pesan dari server dan tampilkan ke user
            $(".lihat_badan_usaha_id").val(response.data.find.badan_usaha_id);
            $(".lihat_izin_id").val(response.data.find.izin_id);
            let bulanx = response.data.find.bulan.substring(0, 7);
            // $('.lihat_bulan').val(response.data.find.bulan)
            $(".lihat_bulan").val(bulanx);
            $(".lihat_kategori_pemasok").val(
                response.data.find.kategori_pemasok
            );
            $(".lihat_intake_kilang").val(response.data.find.intake_kilang);
            $(".lihat_produk").val(response.data.find.produk);
            $(".lihat_satuan").val(response.data.find.satuan);
            $(".lihat_provinsi").val(response.data.find.provinsi);
            $(".lihat_kabupaten_kota").val(response.data.find.kabupaten_kota);
            $(".lihat_sektor").val(response.data.find.sektor);
            $(".lihat_volume").val(response.data.find.volume);
            $(".lihat_keterangan").val(response.data.find.keterangan);
        },
        error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert("Terjadi kesalahan saat mengirim data ID Pengolahan.");
        },
    });
    // })
}
