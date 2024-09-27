function lihat_penjualan_gbp(id, kabupaten_kota) {
  // $('.editPenjualan').click(function () {
  //     let id = $(this).attr('data-id')
  // Kirim data melalui Ajax
  $.ajax({
    url: '/get-penjualan-gbp/' + id,
    method: 'GET',
    data: {
      id: id
    },
    success: function (response) {
      // Tangkap pesan dari server dan tampilkan ke user
      let bulanx = response.data.find.bulan.substring(0, 7)
      $('#form_penjualan_gbp').attr('action', '/update_gbp/' + response.data.find.id)
      $('#lihat_id_penjualan').val(response.data.find.id)
      // $('#lihat_bulan_penjualan_gbp').val(response.data.find.bulan)
      $('#lihat_bulan_penjualan_gbp').val(bulanx)
      $('#lihat_provinsi_penjualan_gbp').val(response.data.find.provinsi)
      $('#lihat_kab_penjualan_gbp').val(response.data.find.kabupaten_kota)
      $('#lihat_sektor_penjualan_gbp').val(response.data.find.sektor)
      $('#lihat_konsumen_penjualan_gbp').val(response.data.find.konsumen)
      $('#lihat_jhp_penjualan_gbp').val(response.data.find.jumlah_hari_penyaluran)
      $('#lihat_ghv_penjualan_gbp').val(response.data.find.ghv)
      $('#lihat_volume_mmbtu_penjualan_gbp').val(response.data.find.volume_mmbtu)
      $('#lihat_volume_mscf_penjualan_bp').val(response.data.find.volume_mscf)
      $('#lihat_volume_m3_penjualan_gbp').val(response.data.find.volume_m3)
      $('#lihat_harga_penjualan_gbp').val(response.data.find.harga)
      $('#lihat_keterangan_penjualan_gbp').val(response.data.find.keterangan)

    
      let provinsiSelect = response.data.find.provinsi
      let kotaSelect = response.data.find.kabupaten_kota
      // console.log(response);

      $('#provinsi_penjualan_gbp').empty()
      $('#provinsi_penjualan_gbp').append(` <option>Pilih Provinsi</option>`)
      $.each(response.data.provinsi, function (i, value) {
        let isSelected = provinsiSelect == value.name ? 'selected' : ''

        $('#provinsi_penjualan_gbp').append(
          `<option data-id="`+ value.id +`" value="` + value.name + `"` + isSelected + `>` + value.name + `</option>`
        )
      });


      $.ajax({
        url: '/get_kota_gbp/' + kabupaten_kota,
        method: 'GET',
        data: {
        },
        success: function (response) {
          // console.log(response);
          // console.log(kabupaten_kota);
          // Loop melalui data dan tambahkan opsi ke dalam select
          $('#kab_penjualan_gbp').empty()
          $('#kab_penjualan_gbp').append(` <option>Pilih Kab / Kota</option>`)
          $.each(response.data, function (i, value) {
            let isSelected = kotaSelect == value.nama_kota ? 'selected' : ''
            $('#kab_penjualan_gbp').append(
              `<option value="` + value.nama_kota + `" `+ isSelected +`>` + value.nama_kota + `</option>`
            )
          });
        },
        error: function (xhr, status, error) {
          // Tangkap pesan error jika ada
          alert('Terjadi kesalahan saat mengirim data.');
        }
      });

      // Contoh: Lakukan tindakan selanjutnya setelah data berhasil dikirim
      // window.location.href = '/success-page';

    },
    error: function (xhr, status, error) {
      // Tangkap pesan error jika ada
      alert('Terjadi kesalahan saat mengirim data.');
    }
  });
  //   })
}

function edit_penjualan_gbp(id, kabupaten_kota) {
  // $('.editPenjualan').click(function () {
  //     let id = $(this).attr('data-id')
  // Kirim data melalui Ajax
  $.ajax({
    url: '/get-penjualan-gbp/' + id,
    method: 'GET',
    data: {
      id: id
    },
    success: function (response) {
      // Tangkap pesan dari server dan tampilkan ke user
      let bulanx = response.data.find.bulan.substring(0, 7)
      $('#form_penjualan_gbp').attr('action', '/update_gbp/' + response.data.find.id)
      $('#id_penjualan').val(response.data.find.id)
      // $('#bulan_penjualan_gbp').val(response.data.find.bulan)
      $('#bulan_penjualan_gbp').val(bulanx)
      $('#provinsi_penjualan_gbp').val(response.data.find.provinsi)
      $('#kab_penjualan_gbp').val(response.data.find.kabupaten_kota)
      $('#sektor_penjualan_gbp').val(response.data.find.sektor)
      $('#konsumen_penjualan_gbp').val(response.data.find.konsumen)
      $('#jhp_penjualan_gbp').val(response.data.find.jumlah_hari_penyaluran)
      $('#ghv_penjualan_gbp').val(response.data.find.ghv)
      $('#volume_mmbtu_penjualan_gbp').val(response.data.find.volume_mmbtu)
      $('#volume_mscf_penjualan_bp').val(response.data.find.volume_mscf)
      $('#volume_m3_penjualan_gbp').val(response.data.find.volume_m3)
      $('#harga_penjualan_gbp').val(response.data.find.harga)
      $('#keterangan_penjualan_gbp').val(response.data.find.keterangan)

    
      let provinsiSelect = response.data.find.provinsi
      let kotaSelect = response.data.find.kabupaten_kota
      let sektorSelect = response.data.find.sektor
      // console.log(response);

      $('#provinsi_penjualan_gbp').empty()
      $('#provinsi_penjualan_gbp').append(` <option>Pilih Provinsi</option>`)
      $.each(response.data.provinsi, function (i, value) {
        let isSelected = provinsiSelect == value.name ? 'selected' : ''

        $('#provinsi_penjualan_gbp').append(
          `<option data-id="`+ value.id +`" value="` + value.name + `"` + isSelected + `>` + value.name + `</option>`
        )
      });

      $('#sektor_penjualan_gbp').empty()
      $('#sektor_penjualan_gbp').append(` <option>Pilih Sektor</option>`)
      $.each(response.data.sektor, function (i, value) {
        let isSelected = sektorSelect == value.nama_sektor ? 'selected' : ''

        $('#sektor_penjualan_gbp').append(
          `<option value="` + value.nama_sektor + `"` + isSelected + `>` + value.nama_sektor + `</option>`
        )
      });


      $.ajax({
        url: '/get_kota_gbp/' + kabupaten_kota,
        method: 'GET',
        data: {
        },
        success: function (response) {
          // console.log(response);
          // console.log(kabupaten_kota);
          // Loop melalui data dan tambahkan opsi ke dalam select
          $('#kab_penjualan_gbp').empty()
          $('#kab_penjualan_gbp').append(` <option>Pilih Kab / Kota</option>`)
          $.each(response.data, function (i, value) {
            let isSelected = kotaSelect == value.nama_kota ? 'selected' : ''
            $('#kab_penjualan_gbp').append(
              `<option value="` + value.nama_kota + `" `+ isSelected +`>` + value.nama_kota + `</option>`
            )
          });
        },
        error: function (xhr, status, error) {
          // Tangkap pesan error jika ada
          alert('Terjadi kesalahan saat mengirim data.');
        }
      });

      // Contoh: Lakukan tindakan selanjutnya setelah data berhasil dikirim
      // window.location.href = '/success-page';

    },
    error: function (xhr, status, error) {
      // Tangkap pesan error jika ada
      alert('Terjadi kesalahan saat mengirim data.');
    }
  });
  //   })
}


function edit_pasokan_gbp(id) {
  // $('.editPenjualan').click(function () {
  //     let id = $(this).attr('data-id')
  // Kirim data melalui Ajax
  $.ajax({
    url: '/get-pasok-gbp/' + id,
    method: 'GET',
    data: {
      id: id
    },
    success: function (response) {
      // Tangkap pesan dari server dan tampilkan ke user
      let bulanx = response.data.find.bulan.substring(0, 7)
      $('#form_pasok_gbp').attr('action', '/update_pasok_gbp/' + response.data.find.id)
      $('#id_pasok').val(response.data.find.id)
      // $('#bulan_pasok_gbp').val(response.data.find.bulan)
      $('#bulan_pasok_gbp').val(bulanx)
      $('#nm_pemasok_pasok_gbp').val(response.data.find.nama_pemasok)
      $('#volume_mmbtu_pasok_gbp').val(response.data.find.volume_mmbtu)
      $('#volume_mscf_pasok_bp').val(response.data.find.volume_mscf)
      $('#volume_m3_pasok_gbp').val(response.data.find.volume_m3)
      $('#harga_pasok_gbp').val(response.data.find.harga)

      // Contoh: Lakukan tindakan selanjutnya setelah data berhasil dikirim
      // window.location.href = '/success-page';

    },
    error: function (xhr, status, error) {
      // Tangkap pesan error jika ada
      alert('Terjadi kesalahan saat mengirim data.');
    }
  });
  //   })
}


function lihat_pasokan_gbp(id) {
  // $('.editPenjualan').click(function () {
  //     let id = $(this).attr('data-id')
  // Kirim data melalui Ajax
  $.ajax({
    url: '/get-pasok-gbp/' + id,
    method: 'GET',
    data: {
      id: id
    },
    success: function (response) {
      // Tangkap pesan dari server dan tampilkan ke user
      let bulanx = response.data.find.bulan.substring(0, 7)
      $('#form_pasok_gbp').attr('action', '/update_pasok_gbp/' + response.data.find.id)
      $('#id_pasok').val(response.data.find.id)
      // $('#lihat_bulan_pasok_gbp').val(response.data.find.bulan)
      $('#lihat_bulan_pasok_gbp').val(bulanx)
      $('#lihat_nm_pemasok_pasok_gbp').val(response.data.find.nama_pemasok)
      $('#lihat_volume_mmbtu_pasok_gbp').val(response.data.find.volume_mmbtu)
      $('#lihat_volume_mscf_pasok_bp').val(response.data.find.volume_mscf)
      $('#lihat_volume_m3_pasok_gbp').val(response.data.find.volume_m3)
      $('#lihat_harga_pasok_gbp').val(response.data.find.harga)

      // Contoh: Lakukan tindakan selanjutnya setelah data berhasil dikirim
      // window.location.href = '/success-page';

    },
    error: function (xhr, status, error) {
      // Tangkap pesan error jika ada
      alert('Terjadi kesalahan saat mengirim data.');
    }
  });
  //   })
}


