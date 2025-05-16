// Pengolahan Minyak Bumi Produksi Kilang
function editPengolahanProduksiMB(id, produk, kabupaten_kota) {
  // $('.editPenjualan').click(function () {
  //   let id = $(this).attr('data-id')
  // Kirim data melalui Ajax
  $.ajax({
    url: '/get_Pengolahan/' + id,
    method: 'GET',
    data: {
      id: id
    },
    success: function (response) {
      console.log(response);
      // Tangkap pesan dari server dan tampilkan ke user
      $('#form_updatePengolahanProduksiMB').attr('action', '/update_pengolahan_minyak_bumi_produksi/' + response.data.find.id)
      $('#badan_usaha_id').val(response.data.find.badan_usaha_id)
      $('#izin_id').val(response.data.find.izin_id)
      $('#bulan_produksi').val(response.data.find.bulan)
      $('#volume_pengolahanProduksi').val(response.data.find.volume)
      $('#keterangan_pengolahanProduksi').val(response.data.find.keterangan)
      $('#status_pengolahanProduksiMB').val(response.data.find.status)

      let produkSelect = response.data.find.produk
      let satuanSelect = response.data.find.satuan
      let provinsiSelect = response.data.find.provinsi
      let kotaSelect = response.data.find.kabupaten_kota

      $('#produk_pengolahanProduksi').empty()
      $('#produk_pengolahanProduksi').append(` <option>Pilih Produk</option>`)
      $.each(response.data.produk, function (i, value) {
        let isSelected = produkSelect == value.name ? 'selected' : ''

        $('#produk_pengolahanProduksi').append(
          `<option value="` + value.name + `"` + isSelected + `>` + value.name + `</option>`
        )
      });

      $.ajax({
        url: '/get_satuan_pengolahanProduksi/' + produk,
        method: 'GET',
        data: {},
        success: function (response) {
          // console.log(response);
          // Loop melalui data dan tambahkan opsi ke dalam select
          $('#satuan_pengolahanProduksi').empty()
          $('#satuan_pengolahanProduksi').append(` <option>Pilih Satuan</option>`)
          $.each(response.data, function (i, value) {
            let isSelected = satuanSelect == value.satuan ? 'selected' : ''
            $('#satuan_pengolahanProduksi').append(
              `<option value="` + value.satuan + `" ` + isSelected + `>` + value.satuan + `</option>`
            )
          });
        },
        error: function (xhr, status, error) {
          // Tangkap pesan error jika ada
          alert('Terjadi kesalahan saat mengirim data.');
        }
      });

      $('#provinsi_produksi').empty()
      $('#provinsi_produksi').append(` <option>Pilih Provinsi</option>`)
      $.each(response.data.provinsi, function (i, value) {
        let isSelected = provinsiSelect.toLowerCase() == value.name.toLowerCase() ? 'selected' : ''

        $('#provinsi_produksi').append(
          `<option data-id="` + value.id + `" value="` + value.name + `"` + isSelected + `>` + value.name + `</option>`
        )
      });

      $.ajax({
        url: '/get_kota_pengolahan/' + kabupaten_kota,
        method: 'GET',
        data: {},
        success: function (response) {
          // Loop melalui data dan tambahkan opsi ke dalam select
          $('#nama_kota_pengolahaProduksi').empty()
          $('#nama_kota_pengolahaProduksi').append(` <option>Pilih Kabupaten / Kota</option>`)
          $.each(response.data, function (i, value) {
            let isSelected = kotaSelect == value.nama_kota ? 'selected' : ''
            $('#nama_kota_pengolahaProduksi').append(
              `<option value="` + value.nama_kota + `" ` + isSelected + `>` + value.nama_kota + `</option>`
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
  // })
}

function lihatPengolahanProduksiMB(id) {
  // $('.editPenjualan').click(function () {
  //   let id = $(this).attr('data-id')
  // Kirim data melalui Ajax
  $.ajax({
    url: '/get_PengolahanProduksiMB/' + id,
    method: 'GET',
    data: {
      id: id
    },
    success: function (response) {
      // Tangkap pesan dari server dan tampilkan ke user
      $('.lihat_badan_usaha_id').val(response.data.find.badan_usaha_id)
      $('.lihat_izin_id').val(response.data.find.izin_id)
      $('.lihat_bulan').val(response.data.find.bulan)
      $('.lihat_produk').val(response.data.find.produk)
      $('.lihat_satuan').val(response.data.find.satuan)
      $('.lihat_provinsi').val(response.data.find.provinsi)
      $('.lihat_kabupaten_kota').val(response.data.find.kabupaten_kota)
      $('.lihat_volume').val(response.data.find.volume)
      $('.lihat_keterangan').val(response.data.find.keterangan)
    },
    error: function (xhr, status, error) {
      // Tangkap pesan error jika ada
      alert('Terjadi kesalahan saat mengirim data.');
    }
  });
  // })
}

// =======================================================================================
// Pengolahan Minyak Bumi Pasokan Kilang
function editPengolahanPasokanMB(id, produk, kabupaten_kota) {
  // $('.editPenjualan').click(function () {
  //   let id = $(this).attr('data-id')
  // Kirim data melalui Ajax
  $.ajax({
    url: '/get_PengolahanPasokanMB/' + id,
    method: 'GET',
    data: {
      id: id
    },
    success: function (response) {
      // console.log(response);
      // Tangkap pesan dari server dan tampilkan ke user
      $('#form_updatePengolahanPasokanMB').attr('action', '/update_pengolahan_minyak_bumi_pasokan/' + response.data.find.id)
      $('#badan_usaha_id_pasokan').val(response.data.find.badan_usaha_id)
      $('#izin_id_pasokan').val(response.data.find.izin_id)
      $('#bulan_pasokan').val(response.data.find.bulan)
      $('#kategori_pemasokPasokan').val(response.data.find.kategori_pemasok)
      $('#volume_pengolahanPasokan').val(response.data.find.volume)
      $('#keterangan_pengolahanPasokan').val(response.data.find.keterangan)
      $('#status_pengolahanPasokanMB').val(response.data.find.status)

      let produkSelect = response.data.find.intake_kilang
      let satuanSelect = response.data.find.satuan
      let provinsiSelect = response.data.find.provinsi
      let kotaSelect = response.data.find.kabupaten_kota

      $('#intake_kilangPasokan').empty()
      $('#intake_kilangPasokan').append(` <option>Pilih Intake Kilang</option>`)
      $.each(response.data.produk, function (i, value) {
        let isSelected = produkSelect.toLowerCase() == value.nm_produk.toLowerCase() ? 'selected' : ''

        $('#intake_kilangPasokan').append(
          `<option value="` + value.nm_produk + `"` + isSelected + `>` + value.nm_produk + `</option>`
        )
      });

      $.ajax({
        url: '/get_satuan_pengolahanPasokan/' + produk,
        method: 'GET',
        data: {},
        success: function (response) {
          // console.log(response);
          // Loop melalui data dan tambahkan opsi ke dalam select
          $('#satuan_pengolahanPasokan').empty()
          $('#satuan_pengolahanPasokan').append(` <option>Pilih Satuan</option>`)
          $.each(response.data, function (i, value) {
            let isSelected = satuanSelect == value.satuan ? 'selected' : ''
            $('#satuan_pengolahanPasokan').append(
              `<option value="` + value.satuan + `" ` + isSelected + `>` + value.satuan + `</option>`
            )
          });
        },
        error: function (xhr, status, error) {
          // Tangkap pesan error jika ada
          alert('Terjadi kesalahan saat mengirim data.');
        }
      });

      $('#provinsi_pasokan').empty()
      $('#provinsi_pasokan').append(` <option>Pilih Provinsi</option>`)
      $.each(response.data.provinsi, function (i, value) {
        let isSelected = provinsiSelect.toLowerCase() == value.name.toLowerCase() ? 'selected' : ''

        $('#provinsi_pasokan').append(
          `<option data-id="` + value.id + `" value="` + value.name + `"` + isSelected + `>` + value.name + `</option>`
        )
      });

      $.ajax({
        url: '/get_kota_pengolahan/' + kabupaten_kota,
        method: 'GET',
        data: {},
        success: function (response) {
          // Loop melalui data dan tambahkan opsi ke dalam select
          $('#nama_kota_pengolahaPasokan').empty()
          $('#nama_kota_pengolahaPasokan').append(` <option>Pilih Kabupaten / Kota</option>`)
          $.each(response.data, function (i, value) {
            let isSelected = kotaSelect == value.nama_kota ? 'selected' : ''
            $('#nama_kota_pengolahaPasokan').append(
              `<option value="` + value.nama_kota + `" ` + isSelected + `>` + value.nama_kota + `</option>`
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
  // })
}

function lihatPengolahanPasokanMB(id) {
  // $('.editPenjualan').click(function () {
  //   let id = $(this).attr('data-id')
  // Kirim data melalui Ajax
  $.ajax({
    url: '/get_PengolahanPasokanMB/' + id,
    method: 'GET',
    data: {
      id: id
    },
    success: function (response) {
      // Tangkap pesan dari server dan tampilkan ke user
      $('.lihat_badan_usaha_id').val(response.data.find.badan_usaha_id)
      $('.lihat_izin_id').val(response.data.find.izin_id)
      $('.lihat_bulan').val(response.data.find.bulan)
      $('.lihat_kategori_pemasok').val(response.data.find.kategori_pemasok)
      $('.lihat_intake_kilang').val(response.data.find.intake_kilang)
      $('.lihat_satuan').val(response.data.find.satuan)
      $('.lihat_provinsi').val(response.data.find.provinsi)
      $('.lihat_kabupaten_kota').val(response.data.find.kabupaten_kota)
      $('.lihat_volume').val(response.data.find.volume)
      $('.lihat_keterangan').val(response.data.find.keterangan)
    },
    error: function (xhr, status, error) {
      // Tangkap pesan error jika ada
      alert('Terjadi kesalahan saat mengirim data.');
    }
  });
  // })
}

// =======================================================================================

// Pengolahan Minyak Bumi Distribusi Kilang
function editPengolahanDistribusiMB(id, produk, kabupaten_kota) {
  // $('.editPenjualan').click(function () {
  //   let id = $(this).attr('data-id')
  // Kirim data melalui Ajax
  $.ajax({
    url: '/get_PengolahanDistribusiMB/' + id,
    method: 'GET',
    data: {
      id: id
    },
    success: function (response) {
      // Tangkap pesan dari server dan tampilkan ke user
      $('#form_updatePengolahanDistribusiMB').attr('action', '/update_pengolahan_minyak_bumi_distribusi/' + response.data.find.id)
      $('#badan_usaha_id_distribusi').val(response.data.find.badan_usaha_id)
      $('#izin_id_distribusi').val(response.data.find.izin_id)
      $('#bulan_distribusi').val(response.data.find.bulan)
      $('#sektor_pengolahanDistribusi').val(response.data.find.sektor)
      $('#volume_pengolahanDistribusi').val(response.data.find.volume)
      $('#keterangan_pengolahanDistribusi').val(response.data.find.keterangan)
      $('#status_pengolahanDistribusiMB').val(response.data.find.status)

      let produkSelect = response.data.find.produk
      let satuanSelect = response.data.find.satuan
      let provinsiSelect = response.data.find.provinsi
      let kotaSelect = response.data.find.kabupaten_kota

      $('#produk_pengolahanDistribusi').empty()
      $('#produk_pengolahanDistribusi').append(` <option>Pilih Produk</option>`)
      $.each(response.data.produk, function (i, value) {
        let isSelected = produkSelect == value.name ? 'selected' : ''

        $('#produk_pengolahanDistribusi').append(
          `<option value="` + value.name + `"` + isSelected + `>` + value.name + `</option>`
        )
      });

      $.ajax({
        url: '/get_satuan_pengolahanDistribusi/' + produk,
        method: 'GET',
        data: {},
        success: function (response) {
          // console.log(response);
          // Loop melalui data dan tambahkan opsi ke dalam select
          $('#satuan_pengolahanDistribusi').empty()
          $('#satuan_pengolahanDistribusi').append(` <option>Pilih Satuan</option>`)
          $.each(response.data, function (i, value) {
            let isSelected = satuanSelect == value.satuan ? 'selected' : ''
            $('#satuan_pengolahanDistribusi').append(
              `<option value="` + value.satuan + `" ` + isSelected + `>` + value.satuan + `</option>`
            )
          });
        },
        error: function (xhr, status, error) {
          // Tangkap pesan error jika ada
          alert('Terjadi kesalahan saat mengirim data.');
        }
      });

      $('#provinsi_distribusi').empty()
      $('#provinsi_distribusi').append(` <option>Pilih Provinsi</option>`)
      $.each(response.data.provinsi, function (i, value) {
        let isSelected = provinsiSelect.toLowerCase() == value.name.toLowerCase() ? 'selected' : ''

        $('#provinsi_distribusi').append(
          `<option data-id="` + value.id + `" value="` + value.name + `"` + isSelected + `>` + value.name + `</option>`
        )
      });

      $.ajax({
        url: '/get_kota_pengolahan/' + kabupaten_kota,
        method: 'GET',
        data: {},
        success: function (response) {
          // Loop melalui data dan tambahkan opsi ke dalam select
          $('#nama_kota_pengolahaDistribusi').empty()
          $('#nama_kota_pengolahaDistribusi').append(` <option>Pilih Kabupaten / Kota</option>`)
          $.each(response.data, function (i, value) {
            let isSelected = kotaSelect == value.nama_kota ? 'selected' : ''
            $('#nama_kota_pengolahaDistribusi').append(
              `<option value="` + value.nama_kota + `" ` + isSelected + `>` + value.nama_kota + `</option>`
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
  // })
}

function lihatPengolahanDistribusiMB(id) {
  // $('.editPenjualan').click(function () {
  //   let id = $(this).attr('data-id')
  // Kirim data melalui Ajax
  $.ajax({
    url: '/get_PengolahanDistribusiMB/' + id,
    method: 'GET',
    data: {
      id: id
    },
    success: function (response) {
      // Tangkap pesan dari server dan tampilkan ke user
      $('.lihat_badan_usaha_id').val(response.data.find.badan_usaha_id)
      $('.lihat_izin_id').val(response.data.find.izin_id)
      $('.lihat_bulan').val(response.data.find.bulan)
      $('.lihat_produk').val(response.data.find.produk)
      $('.lihat_satuan').val(response.data.find.satuan)
      $('.lihat_provinsi').val(response.data.find.provinsi)
      $('.lihat_kabupaten_kota').val(response.data.find.kabupaten_kota)
      $('.lihat_sektor').val(response.data.find.sektor)
      $('.lihat_volume').val(response.data.find.volume)
      $('.lihat_keterangan').val(response.data.find.keterangan)
    },
    error: function (xhr, status, error) {
      // Tangkap pesan error jika ada
      alert('Terjadi kesalahan saat mengirim data.');
    }
  });
  // })
}