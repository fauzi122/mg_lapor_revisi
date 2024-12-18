function editPenjualan(id, produk, kabupaten_kota) {
    // $('.editPenjualan').click(function () {
    //   let id = $(this).attr('data-id')
    // Kirim data melalui Ajax
    $.ajax({
        url: "/get-penjualan-ho/" + id,
        method: "GET",
        data: {
            id: id,
        },
        success: function (response) {
            // Tangkap pesan dari server dan tampilkan ke user
            let bulanx = response.data.find.bulan.substring(0, 7);
            // console.log(response);

            $("#form_penjualan").attr(
                "action",
                "/update_jholb/" + response.data.find.id
            );
            $("#id_penjualan").val(response.data.find.id);
            // $('#bulan_penjualan').val(response.data.find.bulan)
            $("#bulan_penjualan").val(bulanx);
            $("#produk_penjualan").val(response.data.find.produk);
            $("#provinsi_penjualan").val(response.data.find.provinsi);
            $("#sektor_penjualan").val(response.data.find.sektor);
            $("#kab_penjualan").val(response.data.find.kabupaten_kota);
            $("#volume_penjualan").val(response.data.find.volume);
            $("#satuan_penjualan").val(response.data.find.satuan);
            $("#status_penjualan").val(response.data.find.status);
            $("#catatan_penjualan").val(response.data.find.catatan);
            $("#petugas_penjualan").val(response.data.find.petugas);
            $("#badan_usaha_id_penjualan").val(
                response.data.find.badan_usaha_id
            );
            $("#izin_id_penjualan").val(response.data.find.izin_id);

            let produkSelect = response.data.find.produk;
            let satuanSelect = response.data.find.satuan;
            let provinsiSelect = response.data.find.provinsi;
            let kotaSelect = response.data.find.kabupaten_kota;
            let sektorSelect = response.data.find.sektor;

            $("#produk_penjualan").empty();
            $("#produk_penjualan").append(` <option>Pilih Produk</option>`);
            $.each(response.data.produk, function (i, value) {
                let isSelected = produkSelect == value.name ? "selected" : "";

                $("#produk_penjualan").append(
                    `<option value="` +
                        value.name +
                        `"` +
                        isSelected +
                        `>` +
                        value.name +
                        `</option>`
                );
            });

            $("#sektor_penjualan").empty();
            $("#sektor_penjualan").append(` <option>Pilih Sektor</option>`);
            $.each(response.data.sektor, function (i, value) {
                let isSelected =
                    sektorSelect == value.nama_sektor ? "selected" : "";

                $("#sektor_penjualan").append(
                    `<option value="` +
                        value.nama_sektor +
                        `"` +
                        isSelected +
                        `>` +
                        value.nama_sektor +
                        `</option>`
                );
            });

            $.ajax({
                url: "/get-satuan/" + produk,
                method: "GET",
                data: {},
                success: function (response) {
                    // console.log(response);
                    // Loop melalui data dan tambahkan opsi ke dalam select
                    $("#satuan_penjualan").empty();
                    $("#satuan_penjualan").append(
                        ` <option>Pilih Satuan</option>`
                    );
                    $.each(response.data, function (i, value) {
                        let isSelected =
                            satuanSelect == value.satuan ? "selected" : "";
                        $("#satuan_penjualan").append(
                            `<option value="` +
                                value.satuan +
                                `" ` +
                                isSelected +
                                `>` +
                                value.satuan +
                                `</option>`
                        );
                    });
                },
                error: function (xhr, status, error) {
                    // Tangkap pesan error jika ada
                    alert("Terjadi kesalahan saat mengirim data.");
                },
            });

            // alert(kabupaten_kota)
            // console.log(response.data.provinsi);

            $("#provinsi_penjualan").empty();
            $("#provinsi_penjualan").append(` <option>Pilih Provinsi</option>`);
            $.each(response.data.provinsi, function (i, value) {
                let isSelected =
                    provinsiSelect.toLowerCase() == value.name.toLowerCase()
                        ? "selected"
                        : "";

                $("#provinsi_penjualan").append(
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
                url: "/get_kota_lng/" + kabupaten_kota,
                method: "GET",
                data: {},
                success: function (response) {
                    // console.log(response);
                    // console.log(kabupaten_kota);
                    // Loop melalui data dan tambahkan opsi ke dalam select
                    $("#kab_penjualan").empty();
                    $("#kab_penjualan").append(
                        ` <option>Pilih Kab / Kota</option>`
                    );
                    $.each(response.data, function (i, value) {
                        let isSelected =
                            kotaSelect == value.nama_kota ? "selected" : "";
                        $("#kab_penjualan").append(
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
                    alert("Terjadi kesalahan saat mengirim data.");
                },
            });

            // Contoh: Lakukan tindakan selanjutnya setelah data berhasil dikirim
            // window.location.href = '/success-page';
        },
        error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert("Terjadi kesalahan saat mengirim data.");
        },
    });
    // })
}

function lihat_jholb(id, produk, kabupaten_kota) {
    // $('.editPenjualan').click(function () {
    //   let id = $(this).attr('data-id')
    // Kirim data melalui Ajax
    $.ajax({
        url: "/get-penjualan-ho/" + id,
        method: "GET",
        data: {
            id: id,
        },
        success: function (response) {
            // Tangkap pesan dari server dan tampilkan ke user
            let bulanx = response.data.find.bulan.substring(0, 7);

            $("#form_penjualan").attr(
                "action",
                "/update_jholb/" + response.data.find.id
            );
            $("#lihat_id_penjualan").val(response.data.find.id);
            // $('#lihat_bulan_penjualan').val(response.data.find.bulan)
            $("#lihat_bulan_penjualan").val(bulanx);
            $("#lihat_produk_penjualan").val(response.data.find.produk);
            $("#lihat_provinsi_penjualan").val(response.data.find.provinsi);
            $("#lihat_sektor_penjualan").val(response.data.find.sektor);
            $("#lihat_kab_penjualan").val(response.data.find.kabupaten_kota);
            $("#lihat_volume_penjualan").val(response.data.find.volume);
            $("#lihat_satuan_penjualan").val(response.data.find.satuan);
            $("#lihat_status_penjualan").val(response.data.find.status);
            $("#lihat_catatan_penjualan").val(response.data.find.catatan);
            $("#lihat_petugas_penjualan").val(response.data.find.petugas);
            $("#lihat_badan_usaha_id_penjualan").val(
                response.data.find.badan_usaha_id
            );
            $("#lihat_izin_id_penjualan").val(response.data.find.izin_id);

            let produkSelect = response.data.find.produk;
            let satuanSelect = response.data.find.satuan;
            let provinsiSelect = response.data.find.provinsi;
            let kotaSelect = response.data.find.kabupaten_kota;

            $("#produk_penjualan").empty();
            $("#produk_penjualan").append(` <option>Pilih Produk</option>`);
            $.each(response.data.produk, function (i, value) {
                let isSelected = produkSelect == value.name ? "selected" : "";

                $("#produk_penjualan").append(
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
                url: "/get-satuan/" + produk,
                method: "GET",
                data: {},
                success: function (response) {
                    // console.log(response);
                    // Loop melalui data dan tambahkan opsi ke dalam select
                    $("#satuan_penjualan").empty();
                    $("#satuan_penjualan").append(
                        ` <option>Pilih Satuan</option>`
                    );
                    $.each(response.data, function (i, value) {
                        let isSelected =
                            satuanSelect == value.satuan ? "selected" : "";
                        $("#satuan_penjualan").append(
                            `<option value="` +
                                value.satuan +
                                `" ` +
                                isSelected +
                                `>` +
                                value.satuan +
                                `</option>`
                        );
                    });
                },
                error: function (xhr, status, error) {
                    // Tangkap pesan error jika ada
                    alert("Terjadi kesalahan saat mengirim data.");
                },
            });

            // alert(kabupaten_kota)
            // console.log(response.data.provinsi);

            $("#provinsi_penjualan").empty();
            $("#provinsi_penjualan").append(` <option>Pilih Provinsi</option>`);
            $.each(response.data.provinsi, function (i, value) {
                let isSelected =
                    provinsiSelect.toLowerCase() == value.name.toLowerCase()
                        ? "selected"
                        : "";

                $("#provinsi_penjualan").append(
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
                url: "/get_kota_lng/" + kabupaten_kota,
                method: "GET",
                data: {},
                success: function (response) {
                    // console.log(response);
                    // console.log(kabupaten_kota);
                    // Loop melalui data dan tambahkan opsi ke dalam select
                    $("#kab_penjualan").empty();
                    $("#kab_penjualan").append(
                        ` <option>Pilih Kab / Kota</option>`
                    );
                    $.each(response.data, function (i, value) {
                        let isSelected =
                            kotaSelect == value.nama_kota ? "selected" : "";
                        $("#kab_penjualan").append(
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
                    alert("Terjadi kesalahan saat mengirim data.");
                },
            });

            // Contoh: Lakukan tindakan selanjutnya setelah data berhasil dikirim
            // window.location.href = '/success-page';
        },
        error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert("Terjadi kesalahan saat mengirim data.");
        },
    });
    // })
}

function editPasokan(id, produk, kabupaten_kota) {
    // $('.editPasokan').click(function () {
    //   let id = $(this).attr('data-id')
    // Kirim data melalui Ajax
    $.ajax({
        url: "/get-pasokan-ho/" + id,
        method: "GET",
        data: {
            id: id,
        },
        success: function (response) {
            // console.log(response);
            // Tangkap pesan dari server dan tampilkan ke user
            let bulanx = response.data.find.bulan.substring(0, 7);

            $("#form_pasokan").attr(
                "action",
                "/update_pasokan/" + response.data.find.id
            );
            $("#id_pasokan").val(response.data.find.id);
            // $('#bulan_pasokan').val(response.data.find.bulan)
            $("#bulan_pasokan").val(bulanx);
            $("#produk_pasokan").val(response.data.find.produk);
            $("#nama_pemasok_pasokan").val(response.data.find.nama_pemasok);
            $("#kategori_pemasok_pasokan").val(
                response.data.find.kategori_pemasok
            );
            // $('#provinsi_pasokan').val(response.data.find.provinsi)
            // $('#sektor_pasokan').val(response.data.find.sektor)
            // $('#kab_pasokan').val(response.data.find.kabupaten_kota)
            $("#volume_pasokan").val(response.data.find.volume);
            // $('#satuan_pasokan').val(response.data.find.satuan)
            $("#status_pasokan").val(response.data.find.status);
            $("#catatan_pasokan").val(response.data.find.catatan);
            $("#petugas_pasokan").val(response.data.find.petugas);
            $("#badan_usaha_id_pasokan").val(response.data.find.badan_usaha_id);
            $("#izin_id_pasokan").val(response.data.find.izin_id);

            let produkSelect = response.data.find.produk;
            let satuanSelect = response.data.find.satuan;
            let provinsiSelect = response.data.find.provinsi;
            let kotaSelect = response.data.find.kabupaten_kota;
            // console.log(produk);

            $("#produk_pasokan").empty();
            $("#satuan_pasokan").append(` <option>Pilih Produk</option>`);
            $.each(response.data.produk, function (i, value) {
                let isSelected = produkSelect == value.name ? "selected" : "";

                $("#produk_pasokan").append(
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
                url: "/get-satuan/" + produk,
                method: "GET",
                data: {},
                success: function (response) {
                    // console.log(response);
                    // Loop melalui data dan tambahkan opsi ke dalam select
                    $("#satuan_pasokan").empty();
                    $("#satuan_pasokan").append(
                        ` <option>Pilih Satuan</option>`
                    );
                    $.each(response.data, function (i, value) {
                        let isSelected =
                            satuanSelect == value.satuan ? "selected" : "";
                        $("#satuan_pasokan").append(
                            `<option value="` +
                                value.satuan +
                                `" ` +
                                isSelected +
                                `>` +
                                value.satuan +
                                `</option>`
                        );
                    });
                },
                error: function (xhr, status, error) {
                    // Tangkap pesan error jika ada
                    alert("Terjadi kesalahan saat mengirim data.");
                },
            });

            // $('#provinsi_pasokan').empty()
            // $('#provinsi_pasokan').append(` <option>Pilih Provinsi</option>`)
            // $.each(response.data.provinsi, function (i, value) {
            //   let isSelected = provinsiSelect.toLowerCase() == value.name.toLowerCase() ? 'selected' : ''

            //   $('#provinsi_pasokan').append(
            //     `<option data-id="` + value.id + `" value="` + value.name + `"` + isSelected + `>` + value.name + `</option>`
            //   )
            // });

            // console.log(kabupaten_kota);
            // $.ajax({
            //   url: '/get_kota_lng/' + kabupaten_kota,
            //   method: 'GET',
            //   data: {},
            //   success: function (response) {
            //     // console.log(response);
            //     // console.log(kabupaten_kota);
            //     // Loop melalui data dan tambahkan opsi ke dalam select
            //     $('#kab_pasokan').empty()
            //     $('#kab_pasokan').append(` <option>Pilih Kab / Kota</option>`)
            //     $.each(response.data, function (i, value) {
            //       let isSelected = kotaSelect.toLowerCase() == value.nama_kota.toLowerCase() ? 'selected' : ''
            //       $('#kab_pasokan').append(
            //         `<option data-id="` + value.id + `" value="` + value.nama_kota + `" ` + isSelected + `>` + value.nama_kota + `</option>`
            //       )
            //     });
            //   },
            //   error: function (xhr, status, error) {
            //     // Tangkap pesan error jika ada
            //     alert('Terjadi kesalahan saat mengirim data.');
            //   }
            // });

            // Contoh: Lakukan tindakan selanjutnya setelah data berhasil dikirim
            // window.location.href = '/success-page';
        },
        error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert("Terjadi kesalahan saat mengirim data.");
        },
    });
    // })
}

function lihatPasokan(id, produk, kabupaten_kota) {
    // $('.lihatPasokan').click(function () {
    //   let id = $(this).attr('data-id')
    // Kirim data melalui Ajax
    $.ajax({
        url: "/get-pasokan-ho/" + id,
        method: "GET",
        data: {
            id: id,
        },
        success: function (response) {
            // console.log(response);
            // Tangkap pesan dari server dan tampilkan ke user
            let bulanx = response.data.find.bulan.substring(0, 7);

            $("#form_pasokan").attr(
                "action",
                "/update_pasokan/" + response.data.id
            );
            $("#lihat_id_pasokan").val(response.data.id);
            // $('#lihat_bulan_pasokan').val(response.data.find.bulan)
            $("#lihat_bulan_pasokan").val(bulanx);
            $("#lihat_produk_pasokan").val(response.data.find.produk);
            $("#lihat_nama_pemasok_pasokan").val(
                response.data.find.nama_pemasok
            );
            $("#lihat_kategori_pemasok_pasokan").val(
                response.data.find.kategori_pemasok
            );
            // $('#lihat_provinsi_pasokan').val(response.data.find.provinsi)
            // $('#lihat_sektor_pasokan').val(response.data.find.sektor)
            // $('#lihat_kab_pasokan').val(response.data.find.kabupaten_kota)
            $("#lihat_volume_pasokan").val(response.data.find.volume);
            // $('#lihat_satuan_pasokan').val(response.data.find.satuan)
            // $('#lihat_status_pasokan').val(response.data.find.status)
            // $('#lihat_catatan_pasokan').val(response.data.find.catatan)
            // $('#lihat_petugas_pasokan').val(response.data.find.petugas)
            // $('#lihat_badan_usaha_id_pasokan').val(response.data.find.badan_usaha_id)
            // $('#lihat_izin_id_pasokan').val(response.data.find.izin_id)

            // Contoh: Lakukan tindakan selanjutnya setelah data berhasil dikirim
            // window.location.href = '/success-page';
        },
        error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert("Terjadi kesalahan saat mengirim data.");
        },
    });
    // })
}

function edit_hargabbmx(id) {
    // alert(id)
    // $('.editHarga').click(function () {
    // let id = $(this).attr('data-id')
    // Kirim data melalui Ajax
    $.ajax({
        url: "/get-harga-bbm/" + id,
        method: "GET",
        data: {
            id: id,
        },
        success: function (response) {
            // console.log(response);
            // Tangkap pesan dari server dan tampilkan ke user
            let produkSelect = response.data.find.produk;
            let provinsiSelect = response.data.find.provinsi;
            let sektorSelect = response.data.find.sektor;
            let bulanx = response.data.find.bulan.substring(0, 7);

            $("#produk_hargabbm").empty();
            $("#produk_hargabbm").append(` <option>Pilih Produk</option>`);
            $.each(response.data.produk, function (i, value) {
                let isSelected =
                    produkSelect.toLowerCase() == value.name.toLowerCase()
                        ? "selected"
                        : "";

                $("#produk_hargabbm").append(
                    `<option value="` +
                        value.name +
                        `"` +
                        isSelected +
                        `>` +
                        value.name +
                        `</option>`
                );
            });

            $("#provinsi_hargabbm").empty();
            $("#provinsi_hargabbm").append(` <option>Pilih Provinsi</option>`);
            $.each(response.data.provinsi, function (i, value) {
                let isSelected =
                    provinsiSelect.toLowerCase() == value.name.toLowerCase()
                        ? "selected"
                        : "";

                $("#provinsi_hargabbm").append(
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

            $("#sektor_hargabbm").empty();
            $("#sektor_hargabbm").append(` <option>Pilih Sektor</option>`);
            $.each(response.data.sektor, function (i, value) {
                let isSelected =
                    sektorSelect.toLowerCase() ==
                    value.nama_sektor.toLowerCase()
                        ? "selected"
                        : "";

                $("#sektor_hargabbm").append(
                    `<option value="` +
                        value.nama_sektor +
                        `"` +
                        isSelected +
                        `>` +
                        value.nama_sektor +
                        `</option>`
                );
            });

            $("#form_hargabbm").attr(
                "action",
                "/harga-bbm-jbu/" + response.data.find.id
            );
            $("#id_hargabbm").val(response.data.find.id);
            // $('#bulan_hargabbmx').val(response.data.find.bulan)
            $("#bulan_hargabbmx").val(bulanx);
            $("#produk_hargabbm").val(response.data.find.produk);
            // $('#sektor_hargabbm').val(response.data.find.sektor)
            $("#provinsi_hargabbm").val(response.data.find.provinsi);
            $("#volume_hargabbm").val(response.data.find.volume);
            $("#biaya_perolehan_hargabbm").val(
                response.data.find.biaya_perolehan
            );
            $("#biaya_distribusi_hargabbm").val(
                response.data.find.biaya_distribusi
            );
            $("#biaya_penyimpanan_hargabbm").val(
                response.data.find.biaya_penyimpanan
            );
            $("#margin_hargabbm").val(response.data.find.margin);
            $("#ppn_hargabbm").val(response.data.find.ppn);
            $("#pbbkp_hargabbm").val(response.data.find.pbbkp);
            $("#harga_jual_hargabbm").val(response.data.find.harga_jual);
            $("#formula_harga_hargabbm").val(response.data.find.formula_harga);
            $("#keterangan_hargabbm").val(response.data.find.keterangan);
            $("#status_hargabbm").val(response.data.find.status);
            $("#catatan_hargabbm").val(response.data.find.catatan);
            $("#petugas_hargabbm").val(response.data.find.petugas);
            $("#badan_usaha_id_hargabbm").val(
                response.data.find.badan_usaha_id
            );
            $("#izin_id_hargabbm").val(response.data.find.izin_id);

            // Contoh: Lakukan tindakan selanjutnya setelah data berhasil dikirim
            // window.location.href = '/success-page';
        },
        error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert("Terjadi kesalahan saat mengirim data.!");
        },
    });
    // })
}

function lihatHargaBBM(id) {
    // $('.lihatPasokan').click(function () {
    //   let id = $(this).attr('data-id')
    // Kirim data melalui Ajax
    $.ajax({
        url: "/get-harga-bbm/" + id,
        method: "GET",
        data: {
            id: id,
        },
        success: function (response) {
            // console.log(response);
            // Tangkap pesan dari server dan tampilkan ke user
            let bulanx = response.data.find.bulan.substring(0, 7);

            $("#id_hargabbm").val(response.data.id);
            $("#badan_usaha_id_hargabbm").val(response.data.badan_usaha_id);
            $("#izin_id_hargabbm").val(response.data.izin_id);
            // $('#lihat_bulan_hargabbmx').val(response.data.find.bulan)
            $("#lihat_bulan_hargabbmx").val(bulanx);
            $("#lihat_produk_hargabbm").val(response.data.find.produk);
            $("#lihat_sektor_hargabbm").val(response.data.find.sektor);
            $("#lihat_provinsi_hargabbm").val(response.data.find.provinsi);
            $("#lihat_volume_hargabbm").val(response.data.find.volume);
            $("#lihat_status_hargabbm").val(response.data.find.status);
            $("#lihat_catatan_hargabbm").val(response.data.find.catatan);
            $("#lihat_petugas_hargabbm").val(response.data.find.petugas);
            $("#lihat_biaya_perolehan_hargabbm").val(
                response.data.find.biaya_perolehan
            );
            $("#lihat_biaya_distribusi_hargabbm").val(
                response.data.find.biaya_distribusi
            );
            $("#lihat_biaya_penyimpanan_hargabbm").val(
                response.data.find.biaya_penyimpanan
            );
            $("#lihat_margin_hargabbm").val(response.data.find.margin);
            $("#lihat_ppn_hargabbm").val(response.data.find.ppn);
            $("#lihat_pbbkp_hargabbm").val(response.data.find.pbbkp);
            $("#lihat_harga_jual_hargabbm").val(response.data.find.harga_jual);
            $("#lihat_formula_harga_hargabbm").val(
                response.data.find.formula_harga
            );
            $("#lihat_keterangan_harga_hargabbm").val(
                response.data.find.keterangan
            );

            // Contoh: Lakukan tindakan selanjutnya setelah data berhasil dikirim
            // window.location.href = '/success-page';
        },
        error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert("Terjadi kesalahan saat mengirim data.");
        },
    });
    // })
}

function edit_hargaLPG(id, kabupaten_kota) {
    // alert(id)
    // $('.editHarga').click(function () {
    // let id = $(this).attr('data-id')
    // Kirim data melalui Ajax
    $.ajax({
        url: "/get-harga-lpg/" + id,
        method: "GET",
        data: {
            id: id,
        },
        success: function (response) {
            // console.log(response);
            // Tangkap pesan dari server dan tampilkan ke user
            let sektorSelect = response.data.find.sektor;
            let bulanx = response.data.find.bulan.substring(0, 7);

            $("#form_hargaLPG").attr(
                "action",
                "/updateHargaLPG/" + response.data.find.id
            );
            $("#id_hargaLPG").val(response.data.find.id);
            // $('#bulan_hargaLPG').val(response.data.find.bulan)
            $("#bulan_hargaLPG").val(bulanx);
            $("#sektor_hargaLPG").val(response.data.find.sektor);
            $("#provinsi_hargaLPG").val(response.data.find.provinsi);
            $("#volume_hargaLPG").val(response.data.find.volume);
            $("#biaya_perolehan_hargaLPG").val(
                response.data.find.biaya_perolehan
            );
            $("#biaya_distribusi_hargaLPG").val(
                response.data.find.biaya_distribusi
            );
            $("#biaya_penyimpanan_hargaLPG").val(
                response.data.find.biaya_penyimpanan
            );
            $("#margin_hargaLPG").val(response.data.find.margin);
            $("#ppn_hargaLPG").val(response.data.find.ppn);
            $("#harga_jual_hargaLPG").val(response.data.find.harga_jual);
            $("#formula_harga_hargaLPG").val(response.data.find.formula_harga);
            $("#keterangan_hargaLPG").val(response.data.find.keterangan);
            $("#status_hargaLPG").val(response.data.find.status);
            $("#catatan_hargaLPG").val(response.data.find.catatan);
            $("#petugas_hargaLPG").val(response.data.find.petugas);
            $("#badan_usaha_id_hargaLPG").val(
                response.data.find.badan_usaha_id
            );
            $("#izin_id_hargaLPG").val(response.data.find.izin_id);

            let provinsiSelect = response.data.find.provinsi;
            let kotaSelect = response.data.find.kabupaten_kota;

            $("#provinsi_hargaLPG").empty();
            $("#provinsi_hargaLPG").append(` <option>Pilih Provinsi</option>`);
            $.each(response.data.provinsi, function (i, value) {
                let isSelected =
                    provinsiSelect.toLowerCase() == value.name.toLowerCase()
                        ? "selected"
                        : "";

                $("#provinsi_hargaLPG").append(
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

            $("#sektor_hargaLPG").empty();
            $("#sektor_hargaLPG").append(` <option>Pilih Sektor</option>`);
            $.each(response.data.sektor, function (i, value) {
                let isSelected =
                    sektorSelect.toLowerCase() ==
                    value.nama_sektor.toLowerCase()
                        ? "selected"
                        : "";

                $("#sektor_hargaLPG").append(
                    `<option value="` +
                        value.nama_sektor +
                        `"` +
                        isSelected +
                        `>` +
                        value.nama_sektor +
                        `</option>`
                );
            });

            $.ajax({
                url: "/get_kota_lng/" + kabupaten_kota,
                method: "GET",
                data: {},
                success: function (response) {
                    // console.log(response);
                    // console.log(kabupaten_kota);
                    // Loop melalui data dan tambahkan opsi ke dalam select
                    $("#nama_kota_hargaLPG").empty();
                    $("#nama_kota_hargaLPG").append(
                        ` <option>Pilih Kabupaten / Kota</option>`
                    );
                    $.each(response.data, function (i, value) {
                        let isSelected =
                            kotaSelect.toLowerCase() ==
                            value.nama_kota.toLowerCase()
                                ? "selected"
                                : "";
                        $("#nama_kota_hargaLPG").append(
                            `<option data-id="` +
                                value.id +
                                `" value="` +
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
                    alert("Terjadi kesalahan saat mengirim data.");
                },
            });

            // Contoh: Lakukan tindakan selanjutnya setelah data berhasil dikirim
            // window.location.href = '/success-page';
        },
        error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert("Terjadi kesalahan saat mengirim data.!");
        },
    });
    // })
}

function lihatHargaLPG(id) {
    // $('.lihatPasokan').click(function () {
    //   let id = $(this).attr('data-id')
    // Kirim data melalui Ajax
    $.ajax({
        url: "/get-harga-lpg/" + id,
        method: "GET",
        data: {
            id: id,
        },
        success: function (response) {
            // console.log(response);
            // Tangkap pesan dari server dan tampilkan ke user
            let bulanx = response.data.find.bulan.substring(0, 7);

            $("#id_hargaLPG").val(response.data.id);
            $("#badan_usaha_id_hargaLPG").val(response.data.badan_usaha_id);
            $("#izin_id_hargaLPG").val(response.data.izin_id);
            // $('#lihat_bulan_hargaLPGx').val(response.data.find.bulan)
            $("#lihat_bulan_hargaLPGx").val(bulanx);
            $("#lihat_sektor_hargaLPG").val(response.data.find.sektor);
            $("#lihat_provinsi_hargaLPG").val(response.data.find.provinsi);
            $("#lihat_kabupaten_kota_hargaLPG").val(
                response.data.find.kabupaten_kota
            );
            $("#lihat_volume_hargaLPG").val(response.data.find.volume);
            $("#lihat_status_hargaLPG").val(response.data.find.status);
            $("#lihat_catatan_hargaLPG").val(response.data.find.catatan);
            $("#lihat_petugas_hargaLPG").val(response.data.find.petugas);
            $("#lihat_biaya_perolehan_hargaLPG").val(
                response.data.find.biaya_perolehan
            );
            $("#lihat_biaya_distribusi_hargaLPG").val(
                response.data.find.biaya_distribusi
            );
            $("#lihat_biaya_penyimpanan_hargaLPG").val(
                response.data.find.biaya_penyimpanan
            );
            $("#lihat_margin_hargaLPG").val(response.data.find.margin);
            $("#lihat_ppn_hargaLPG").val(response.data.find.ppn);
            $("#lihat_harga_jual_hargaLPG").val(response.data.find.harga_jual);
            $("#lihat_formula_harga_hargaLPG").val(
                response.data.find.formula_harga
            );
            $("#lihat_keterangan_harga_hargaLPG").val(
                response.data.find.keterangan
            );

            // Contoh: Lakukan tindakan selanjutnya setelah data berhasil dikirim
            // window.location.href = '/success-page';
        },
        error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert("Terjadi kesalahan saat mengirim data.");
        },
    });
    // })
}

function produk(jenis_komuditas = "") {
    // alert(jenis_komuditas)
    // $('#satuan_produk').val("")
    // $('#prov').val("11111")
    $(".form-reset").trigger("reset");
    // Kirim data melalui Ajax
    $.ajax({
        url: "/get-produk/",
        method: "GET",
        data: {
            jenis_komuditas: jenis_komuditas,
        },
        success: function (response) {
            // console.log(response);
            // Loop melalui data dan tambahkan opsi ke dalam select
            $(".name_produk").empty();
            $(".name_produk").append(
                ` <option selected disabled>Pilih Produk</option>`
            );
            $.each(response.data, function (i, value) {
                $(".name_produk").append(
                    `<option value="` +
                        value.name +
                        `">` +
                        value.name +
                        `</option>`
                );
            });
        },
        error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert("Terjadi kesalahan saat mengirim data.");
        },
    });
}

$(".name_produk").change(function () {
    let elemen = $(this).find("option:selected");
    let value = elemen.val();

    $.ajax({
        url: "/get-satuan/" + value,
        method: "GET",
        data: {},
        success: function (response) {
            // console.log(response);
            // Loop melalui data dan tambahkan opsi ke dalam select
            $(".satuan").empty();
            $(".satuan").append(
                ` <option selected disabled>Pilih Satuan</option>`
            );
            $.each(response.data, function (i, value) {
                $(".satuan").append(
                    `<option value="` +
                        value.satuan +
                        `">` +
                        value.satuan +
                        `</option>`
                );
            });

            // Distribusi/Penjualan Domestik Kilang modal
            if (
                value.replace(/\s+/g, "").toLowerCase() ===
                "bahanbakarspesifikasitertentu"
            ) {
                $(".produk_pengolahan")
                    .parent()
                    .after(
                        `
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input class="form-control" type="text" id="nama" name="nama" required>
                    </div>
                    `
                    );
            }
        },
        error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert("Terjadi kesalahan saat mengirim data.");
        },
    });
    // alert(value)
});

function provinsi() {
    // alert('test')
    // $('#satuan_produk').val("")
    // $('#prov').val("11111")
    $(".form-reset").trigger("reset");
    // Kirim data melalui Ajax
    $.ajax({
        url: "/get-provinsi/",
        method: "GET",
        data: {},
        success: function (response) {
            // console.log(response);
            // Loop melalui data dan tambahkan opsi ke dalam select
            $(".name_provinsi").empty();
            $(".name_provinsi").append(
                ` <option selected disabled >Pilih Provinsi</option>`
            );
            $.each(response.data, function (i, value) {
                $(".name_provinsi").append(
                    `<option data-id="` +
                        value.id +
                        `" value="` +
                        value.name +
                        `">` +
                        value.name +
                        `</option>`
                );
            });
        },
        error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert("Terjadi kesalahan saat mengirim data.");
        },
    });
}

$(".name_provinsi").change(function () {
    let elemen = $(this).find("option:selected");
    // let value = elemen.val()
    let value = elemen.attr("data-id");

    $.ajax({
        url: "/get_kota/" + value,
        method: "GET",
        data: {},
        success: function (response) {
            // console.log(response);
            // Loop melalui data dan tambahkan opsi ke dalam select
            $(".nama_kota").empty();
            $(".nama_kota").append(
                ` <option selected disabled>Pilih Kabupaten / Kota</option>`
            );
            // $(".nama_kab").empty();
            // $(".nama_kab").append(` <p>Pilih Kabupaten / Kota</p>`);
            $.each(response.data, function (i, value) {
                $(".nama_kota").append(
                    `<option value="` +
                        value.nama_kota +
                        `">` +
                        value.nama_kota +
                        `</option>`
                );
                // $(".nama_kab").append(
                //     `<label><input type="checkbox" name="kabupaten_kota[]" value="${value.nama_kota}"/><span>${value.nama_kota}</span></label>`
                // );
            });
        },
        error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert("Terjadi kesalahan saat mengirim data.");
        },
    });
    // alert(value)
});

// Choices js pengolahan minyak => pasokan modal
$(document).ready(function () {
    const choices = new Choices("#kabupaten_kota", { removeItemButton: true });

    // Event listener untuk menangani perubahan pada elemen trigger
    $(".name_provinsi").change(function () {
        let elemen = $(this).find("option:selected");
        let value = elemen.attr("data-id");

        // Hapus opsi yang ada sebelumnya
        $("#kabupaten_kota").empty();
        choices.clearStore(); // Clear Choices.js store

        $.ajax({
            url: "/get_kota/" + value,
            method: "GET",
            data: {},
            success: function (response) {
                // Tambahkan opsi baru berdasarkan kategori yang dipilih
                $.each(response.data, function (i, item) {
                    $("#kabupaten_kota").append(
                        new Option(item.nama_kota, item.nama_kota)
                    );

                    choices.setValue([item.nama_kota]);
                });

                // Update Choices.js untuk mencerminkan perubahan
                choices.passedElement.value = $("#kabupaten_kota").val();
                choices.init(); // Inisialisasi ulang Choices.js
            },
            error: function (xhr, status, error) {
                // Tangkap pesan error jika ada
                alert("Terjadi kesalahan saat mengirim data.");
            },
        });
    });
});

function intake_kilang() {
    $(".form-reset").trigger("reset");
    // Kirim data melalui Ajax
    $.ajax({
        url: "/get_intakeKilang/",
        method: "GET",
        data: {},
        success: function (response) {
            // Loop melalui data dan tambahkan opsi ke dalam select
            $(".intake_kilang").empty();
            $(".intake_kilang").append(
                ` <option selected disabled>Pilih Intake Kilang</option>`
            );
            $.each(response.data, function (i, value) {
                $(".intake_kilang").append(
                    `<option value="` +
                        value.nm_produk +
                        `">` +
                        value.nm_produk +
                        `</option>`
                );
            });
        },
        error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert("Terjadi kesalahan saat mengirim data.");
        },
    });
}

$(".intake_kilang").change(function () {
    let elemen = $(this).find("option:selected");
    let value = elemen.val();

    $.ajax({
        url: "/get_satuanIntakeKilang/" + value,
        method: "GET",
        data: {},
        success: function (response) {
            // console.log(response);
            // Loop melalui data dan tambahkan opsi ke dalam select
            $(".satuan").empty();
            $(".satuan").append(
                ` <option selected disabled>Pilih Satuan</option>`
            );
            $.each(response.data, function (i, value) {
                $(".satuan").append(
                    `<option value="` +
                        value.satuan +
                        `">` +
                        value.satuan +
                        `</option>`
                );
            });
        },
        error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert("Terjadi kesalahan saat mengirim data.");
        },
    });
    // alert(value)
});

$("#myForm").on("submit", function (e) {
    e.preventDefault();
    Swal.fire({
        title: "Kirim Data",
        text: "Apakah yakin ingin mengirim data?",
        icon: "question",
        showCancelButton: !0,
        confirmButtonColor: "#2ab57d",
        cancelButtonColor: "#fd625e",
        confirmButtonText: "Ya, kirim!",
    }).then(function (result) {
        if (result.value) {
            setTimeout(function () {
                $(".myForm")[0].submit();
            }, 10);
        }
    });
});

$(".myHapus").on("submit", function (e) {
    e.preventDefault();
    Swal.fire({
        title: "Hapus Data",
        text: "Apakah yakin ingin menghapus data?",
        icon: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#2ab57d",
        cancelButtonColor: "#fd625e",
        confirmButtonText: "Ya, Hapus!",
    }).then(function (result) {
        if (result.value) {
            setTimeout(function () {
                $(".myHapus")[0].submit();
            }, 10);
        }
    });
});

$(".kirim-data").click(function () {
    var form = $(this).closest("form");
    Swal.fire({
        title: "Kirim Data",
        text: "Apakah yakin ingin mengirim data?",
        icon: "question",
        showCancelButton: !0,
        confirmButtonColor: "#2ab57d",
        cancelButtonColor: "#fd625e",
        confirmButtonText: "Ya, kirim!",
    }).then(function (result) {
        if (result.value) {
            form.submit();
        }
    });
});

$(".hapus-data").click(function () {
    var form = $(this).closest("form");
    // console.log(form);
    Swal.fire({
        title: "Hapus Data",
        text: "Apakah yakin ingin menghapus data?",
        icon: "question",
        showCancelButton: !0,
        confirmButtonColor: "#2ab57d",
        cancelButtonColor: "#fd625e",
        confirmButtonText: "Ya, hapus!",
    }).then(function (result) {
        if (result.value) {
            form.submit();
        }
    });
});

function hapusData(form) {
    Swal.fire({
        title: "Hapus Data",
        text: "Apakah yakin ingin menghapus data?",
        icon: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#2ab57d",
        cancelButtonColor: "#fd625e",
        confirmButtonText: "Ya, hapus!",
    }).then(function (result) {
        if (result.value) {
            form.submit();
        }
    });
}

function kirimData(form) {
    Swal.fire({
        title: "Kirim Data",
        text: "Apakah yakin ingin mengirim data?",
        icon: "question",
        showCancelButton: !0,
        confirmButtonColor: "#2ab57d",
        cancelButtonColor: "#fd625e",
        confirmButtonText: "Ya, Kirim !",
    }).then(function (result) {
        if (result.value) {
            form.submit();
        }
    });
}

function negara() {
    // alert('test')
    // $('#satuan_produk').val("")
    // $('#prov').val("11111")
    $(".form-reset").trigger("reset");
    // Kirim data melalui Ajax
    $.ajax({
        url: "/get-negara/",
        method: "GET",
        data: {},
        success: function (response) {
            // Loop melalui data dan tambahkan opsi ke dalam select

            $(".nm_negara").empty();
            $(".nm_negara").append(
                ` <option selected disabled>Pilih Negara</option>`
            );
            $.each(response.data, function (i, value) {
                $(".nm_negara").append(
                    `<option value="` +
                        value.nm_negara +
                        `">` +
                        value.nm_negara +
                        `</option>`
                );
            });
        },
        error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert("Terjadi kesalahan saat mengirim data.");
        },
    });
}

function kab_kota() {
    // alert('test')
    // $('#satuan_produk').val("")
    // $('#prov').val("11111")
    $(".form-reset").trigger("reset");
    // Kirim data melalui Ajax
    $.ajax({
        url: "/get-kab-kota/",
        method: "GET",
        data: {},
        success: function (response) {
            // console.log(response);
            // Loop melalui data dan tambahkan opsi ke dalam select
            $(".nama_kota").empty();
            $(".nama_kota").append(
                ` <option selected disabled>Pilih Kab / Kota</option>`
            );
            $.each(response.data, function (i, value) {
                $(".nama_kota").append(
                    `<option value="` +
                        value.nama_kota +
                        `">` +
                        value.nama_kota +
                        `</option>`
                );
            });
        },
        error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert("Terjadi kesalahan saat mengirim data.");
        },
    });
}

function sektor() {
    // alert('test')
    // $('#satuan_produk').val("")
    // $('#prov').val("11111")
    $(".form-reset").trigger("reset");
    // Kirim data melalui Ajax
    $.ajax({
        url: "/get-sektor/",
        method: "GET",
        data: {},
        success: function (response) {
            // console.log(response);
            // Loop melalui data dan tambahkan opsi ke dalam select
            $(".nama_sektor").empty();
            $(".nama_sektor").append(
                ` <option selected disabled>Pilih Sektor</option>`
            );
            $.each(response.data, function (i, value) {
                $(".nama_sektor").append(
                    `<option value="` +
                        value.nama_sektor +
                        `">` +
                        value.nama_sektor +
                        `</option>`
                );
            });
        },
        error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert("Terjadi kesalahan saat mengirim data.");
        },
    });
}

$(".nama_sektor").change(function () {
    let elemen = $(this).find("option:selected");
    let value = elemen.val();

    // Distribusi/Penjualan Domestik Kilang modal
    if (value.replace(/\s+/g, "").toLowerCase() === "badanusahaniaga") {
        $(".sektor_pengolahan")
            .parent()
            .after(
                `
            <div class="mb-3">
                <label for="nama_bu_niaga" class="form-label">Nama Badan Usaha Niaga</label>
                <input class="form-control" type="text" id="nama_bu_niaga" name="nama_bu_niaga" required>
            </div>
            `
            );
    }
});

function pelabuhan() {
    $(".form-reset").trigger("reset");
    // Kirim data melalui Ajax
    $.ajax({
        url: "/get-pelabuhan/",
        method: "GET",
        data: {},
        success: function (response) {
            // console.log(response);
            // Loop melalui data dan tambahkan opsi ke dalam select
            $(".pelabuhan").empty();
            $(".pelabuhan").append(
                ` <option selected disabled>Pilih Pelabuhan</option>`
            );
            $.each(response.data, function (i, value) {
                $(".pelabuhan").append(
                    `<option value="` +
                        value.nm_port +
                        ` - ` +
                        value.lokasi +
                        `">` +
                        value.lokasi +
                        `</option>`
                );
            });
        },
        error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert("Terjadi kesalahan saat mengirim data.");
        },
    });
}

function incoterms() {
    $(".form-reset").trigger("reset");
    // Kirim data melalui Ajax
    $.ajax({
      
        url: "/pelaporan-hilir/get-incoterms/",
        method: "GET",
        data: {},
        success: function (response) {
            // console.log(response);
            // Loop melalui data dan tambahkan opsi ke dalam select
            $(".incoterms").empty();
            $(".incoterms").append(
                ` <option selected disabled>Pilih Incoterms</option>`
            );
            $.each(response.data, function (i, value) {
                $(".incoterms").append(
                    `<option value="` +
                        value.incoterm +
                        `">` +
                        value.ket +
                        `</option>`
                );
            });
        },
        error: function (xhr, status, error) {
            // Tangkap pesan error jika ada
            alert("Terjadi kesalahan saat mengirim data.");
        },
    });
}


function getCommingle(target, option, jumlah_bu = " ", nama_penyewa = " ") {
    let commingle = $(target).val();
    if (nama_penyewa == null) {
        nama_penyewa = " ";
    }
    const comElement = `<div class="my-3">
                    <label for="example-text-input" class="form-label">Jumlah Badan Usaha</label>
                    <input class="form-control" type="number" name="jumlah_bu" id="jumlah_bu" value="${jumlah_bu}" ${option}>
                    
                </div>
                <div class="mb-3">
                    <label for="example-text-input" class="form-label">Nama Penyewa</label>
                    <input class="form-control" type="text" name="nama_penyewa" id="nama_penyewa" value="${nama_penyewa}" ${option}>
                    
                </div>`;

    if (commingle == "ya") {
        $(target).parent().append(comElement);
    }

    $(target).change(function () {
        let elemen = $(this).find("option:selected");
        let value = elemen.val();

        if (value == "ya") {
            $(target).parent().append(comElement);
        } else {
            $("#jumlah_bu").parent().remove();
            $("#nama_penyewa").parent().remove();
        }
    });
}

$(document).ready(function () {
    getCommingle("#commingle", "required");
});

easyNumberSeparator({
    selector: ".number-separator",
    separator: ".",
});

function formatHSCode(input) {
    // Menghapus semua karakter yang bukan angka
    const cleanedInput = input.replace(/\D/g, "");
    let formattedCode = "";

    // Memformat sesuai pola XXXX.XX.XX
    for (let i = 0; i < cleanedInput.length; i++) {
        if (i === 4 || i === 6) {
            formattedCode += "."; // Menambahkan titik di posisi yang tepat
        }
        formattedCode += cleanedInput[i];
    }

    return formattedCode;
}

document.addEventListener("DOMContentLoaded", function () {
    const inputFields = document.querySelectorAll(".hsCode"); // Mengambil semua elemen dengan kelas hsCode

    inputFields.forEach((inputField) => {
        inputField.addEventListener("input", function () {
            const formatted = formatHSCode(inputField.value);
            inputField.value = formatted; // Mengembalikan hasil format ke input
        });
    });
});
