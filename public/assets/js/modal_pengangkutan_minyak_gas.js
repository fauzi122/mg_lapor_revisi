// Tentukan apakah situs diakses dari localhost
var isLocalhost = window.location.hostname === '127.0.0.1:8000' || window.location.hostname === 'localhost';

// Atur baseUrl berdasarkan apakah situs diakses dari localhost
var baseUrl = isLocalhost ? "/" : "/pelaporan-hilir/";

function editpengmb(id, produk, kabupaten_kota) {
  // $('.editPenjualan').click(function () {
  //   let id = $(this).attr('data-id')
  // Kirim data melalui Ajax
  // $('input:checkbox').removeAttr('checked');
  $('#edit-darat').prop('checked', false);
  $('#edit-laut').prop('checked', false);
  $('#edit-sungai-danau').prop('checked', false);
  $.ajax({
    url:baseUrl + 'get-pengmb/' + id,
    method: 'GET',
    data: {
      id: id
    },
    success: function (response) {
      // console.log(response.data.find.jenis_moda);
      // console.log(typeof(response.data.find.jenis_moda));
      // console.log(response);
      let bulanx = response.data.find.bulan.substring(0, 7)

      if ($.inArray('Darat', response.data.find.jenis_moda) != -1) {
        // $('#edit-darat').attr("checked", "checked")
        $('#edit-darat').prop('checked', true);
      }
      if ($.inArray('Laut', response.data.find.jenis_moda) != -1) {
        // $('#edit-laut').attr("checked", "checked")
        $('#edit-laut').prop("checked", true)
      }
      if ($.inArray('Sungai/Danau', response.data.find.jenis_moda) != -1) {
        // $('#edit-sungai-danau').attr("checked", "checked")
        $('#edit-sungai-danau').prop("checked", true)
      }
      // Tangkap pesan dari server dan tampilkan ke user
      $('#form_pengmb').attr('action', '/update_pengmb/' + response.data.find.id)
      $('#id_pengmb').val(response.data.find.id)
      $('#produk_pengmb').val(response.data.find.produk)
      $('#bulan_pengmb').val(bulanx)
      // $('#jenis_moda_pengmb').val(response.data.find.jenis_moda)
      $('#node_asal_pengmb').val(response.data.find.node_asal)
      $('#provinsi_asal_pengmb').val(response.data.find.provinsi_asal)
      $('#node_tujuan_pengmb').val(response.data.find.node_tujuan)
      $('#provinsi_tujuan_pengmb').val(response.data.find.provinsi_tujuan)
      $('#volume_supply_pengmb').val(response.data.find.volume_supply)
      // $('#satuan_volume_supply_pengmb').val(response.data.find.satuan_volume_supply)
      $('#volume_angkut_pengmb').val(response.data.find.volume_angkut)
      // $('#satuan_volume_angkut_pengmb').val(response.data.find.satuan_volume_angkut)

      let produkSelect = response.data.find.produk
      let provinsiSelect = response.data.find.provinsi_asal
      let provinsi_tujuanSelect = response.data.find.provinsi_tujuan
      let satuan_volume_supplySelectted = response.data.find.satuan_volume_supply
      let satuan_volume_angkutSelectted = response.data.find.satuan_volume_angkut

      $('#produk_pengmb').empty()
      $('#produk_pengmb').append(` <option>Pilih Produk</option>`)
      $.each(response.data.produk, function (i, value) {
        let isSelected = produkSelect == value.name ? 'selected' : ''

        $('#produk_pengmb').append(
          `<option value="` + value.name + `"` + isSelected + `>` + value.name + `</option>`
        )
      });

      $.ajax({
        url:baseUrl + 'get-satuan/' + produk,
        method: 'GET',
        data: {},
        success: function (response) {
          // Loop melalui data dan tambahkan opsi ke dalam select
          $('#satuan_volume_supply_pengmb').empty()
          $('#satuan_volume_supply_pengmb').append(` <option>Pilih Satuan</option>`)
          $.each(response.data, function (i, value) {
            let isSelected = satuan_volume_supplySelectted == value.satuan ? 'selected' : ''
            $('#satuan_volume_supply_pengmb').append(
              `<option value="` + value.satuan + `" ` + isSelected + `>` + value.satuan + `</option>`
            )
          });

          $('#satuan_volume_angkut_pengmb').empty()
          $('#satuan_volume_angkut_pengmb').append(` <option>Pilih Satuan</option>`)
          $.each(response.data, function (i, value) {
            let isSelected = satuan_volume_angkutSelectted == value.satuan ? 'selected' : ''
            $('#satuan_volume_angkut_pengmb').append(
              `<option value="` + value.satuan + `" ` + isSelected + `>` + value.satuan + `</option>`
            )
          });
        },
        error: function (xhr, status, error) {
          // Tangkap pesan error jika ada
          alert('Terjadi kesalahan saat mengirim data.');
        }
      });


      // alert(kabupaten_kota)
      // console.log(response.data.provinsi);

      $('#provinsi_asal_pengmb').empty()
      $('#provinsi_asal_pengmb').append(` <option>Pilih Provinsi</option>`)
      $.each(response.data.provinsi, function (i, value) {
        let isSelected = provinsiSelect.toLowerCase() == value.name.toLowerCase() ? 'selected' : ''

        $('#provinsi_asal_pengmb').append(
          `<option value="` + value.name + `"` + isSelected + `>` + value.name + `</option>`
        )
      });

      $('#provinsi_tujuan_pengmb').empty()
      $('#provinsi_tujuan_pengmb').append(` <option>Pilih Provinsi</option>`)
      $.each(response.data.provinsi, function (i, value) {
        let isSelected = provinsi_tujuanSelect.toLowerCase() == value.name.toLowerCase() ? 'selected' : ''

        $('#provinsi_tujuan_pengmb').append(
          `<option value="` + value.name + `"` + isSelected + `>` + value.name + `</option>`
        )
      });


      $.ajax({
        url:baseUrl + 'get_kota_lng/' + kabupaten_kota,
        method: 'GET',
        data: {},
        success: function (response) {
          // console.log(response);
          // console.log(kabupaten_kota);
          // Loop melalui data dan tambahkan opsi ke dalam select
          $('#kab_pengmb').empty()
          $('#kab_pengmb').append(` <option>Pilih Kab / Kota</option>`)
          $.each(response.data, function (i, value) {
            let isSelected = kotaSelect == value.nama_kota ? 'selected' : ''
            $('#kab_pengmb').append(
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

function lihat_pengmb(id) {
  // $('.editPenjualan').click(function () {
  //   let id = $(this).attr('data-id')
  $('input:checkbox').removeAttr('checked');
  // Kirim data melalui Ajax
  $.ajax({
    url:baseUrl + 'get-pengmb/' + id,
    method: 'GET',
    data: {
      id: id
    },
    success: function (response) {
      if ($.inArray('Darat', response.data.find.jenis_moda) != -1) {
        $('#lihat-darat').attr("checked", "checked")
      }
      if ($.inArray('Laut', response.data.find.jenis_moda) != -1) {
        $('#lihat-laut').attr("checked", "checked")
      }
      if ($.inArray('Sungai/Danau', response.data.find.jenis_moda) != -1) {
        $('#lihat-sungai-danau').attr("checked", "checked")
      }
      // Tangkap pesan dari server dan tampilkan ke user
      let bulanx = response.data.find.bulan.substring(0, 7)

      $('#form_pengmb').attr('action', '/update_pengmb/' + response.data.find.id)
      $('#lihat_id_pengmb').val(response.data.find.id)
      $('#lihat_produk_pengmb').val(response.data.find.produk)
      $('#lihat_bulan_pengmb').val(bulanx)
      // $('#lihat_jenis_moda_pengmb').val(response.data.find.jenis_moda)
      $('#lihat_node_asal_pengmb').val(response.data.find.node_asal)
      $('#lihat_provinsi_asal_pengmb').val(response.data.find.provinsi_asal)
      $('#lihat_node_tujuan_pengmb').val(response.data.find.node_tujuan)
      $('#lihat_provinsi_tujuan_pengmb').val(response.data.find.provinsi_tujuan)
      $('#lihat_volume_supply_pengmb').val(response.data.find.volume_supply)
      $('#lihat_satuan_volume_supply_pengmb').val(response.data.find.satuan_volume_supply)
      $('#lihat_volume_angkut_pengmb').val(response.data.find.volume_angkut)
      $('#lihat_satuan_volume_angkut_pengmb').val(response.data.find.satuan_volume_angkut)


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

function editpgb(id, kabupaten_kota, produk) {
  // $('.editPenjualan').click(function () {
  //   let id = $(this).attr('data-id')
  // Kirim data melalui Ajax
  $.ajax({
    url:baseUrl + 'get-pgb/' + id,
    method: 'GET',
    data: {
      id: id
    },
    success: function (response) {
      // Tangkap pesan dari server dan tampilkan ke user
      let bulanx = response.data.find.bulan.substring(0, 7)

      $('#form_pgb').attr('action', '/update_pgb/' + response.data.find.id)
      $('#id_pgb').val(response.data.find.id)
      $('#bulan_gb').val(bulanx)
      $('#produk_pgb').val(response.data.find.produk)
      $('#node_asal_pgb').val(response.data.find.node_asal)
      $('#provinsi_asal_pgb').val(response.data.find.provinsi_asal)
      $('#node_tujuan_pgb').val(response.data.find.node_tujuan)
      $('#provinsi_tujuan_pgb').val(response.data.find.provinsi_tujuan)
      $('#volume_supply_pgb').val(response.data.find.volume_supply)
      // $('#satuan_volume_supply_pgb').val(response.data.find.satuan_volume_supply)
      $('#volume_angkut_pgb').val(response.data.find.volume_angkut)
      // $('#satuan_volume_angkut_pgb').val(response.data.find.satuan_volume_angkut)

      let produkSelect = response.data.find.produk
      let provinsiSelect = response.data.find.provinsi_asal
      let provinsi_tujuanSelect = response.data.find.provinsi_tujuan
      let satuan_volume_supplySelected = response.data.find.satuan_volume_supply
      let satuan_volume_angkutSelected = response.data.find.satuan_volume_angkut

      $('#produk_pgb').empty()
      $('#produk_pgb').append(` <option>Pilih Produk</option>`)
      $.each(response.data.produk, function (i, value) {
        let isSelected = produkSelect == value.name ? 'selected' : ''

        $('#produk_pgb').append(
          `<option value="` + value.name + `"` + isSelected + `>` + value.name + `</option>`
        )
      });

      $.ajax({
        url:baseUrl + 'get-satuan/' + produk,
        method: 'GET',
        data: {},
        success: function (response) {
          // Loop melalui data dan tambahkan opsi ke dalam select
          $('#satuan_volume_supply_pgb').empty()
          $('#satuan_volume_supply_pgb').append(` <option>Pilih Satuan</option>`)
          $.each(response.data, function (i, value) {
            let isSelected = satuan_volume_supplySelected == value.satuan ? 'selected' : ''
            $('#satuan_volume_supply_pgb').append(
              `<option value="` + value.satuan + `" ` + isSelected + `>` + value.satuan + `</option>`
            )
          });

          $('#satuan_volume_angkut_pgb').empty()
          $('#satuan_volume_angkut_pgb').append(` <option>Pilih Satuan</option>`)
          $.each(response.data, function (i, value) {
            let isSelected = satuan_volume_angkutSelected == value.satuan ? 'selected' : ''
            $('#satuan_volume_angkut_pgb').append(
              `<option value="` + value.satuan + `" ` + isSelected + `>` + value.satuan + `</option>`
            )
          });
        },
        error: function (xhr, status, error) {
          // Tangkap pesan error jika ada
          alert('Terjadi kesalahan saat mengirim data.');
        }
      });

      // alert(kabupaten_kota)
      // console.log(response.data.provinsi);

      $('#provinsi_asal_pgb').empty()
      $('#provinsi_asal_pgb').append(` <option>Pilih Provinsi</option>`)
      $.each(response.data.provinsi, function (i, value) {
        let isSelected = provinsiSelect.toLowerCase() == value.name.toLowerCase() ? 'selected' : ''

        $('#provinsi_asal_pgb').append(
          `<option value="` + value.name + `"` + isSelected + `>` + value.name + `</option>`
        )
      });

      $('#provinsi_tujuan_pgb').empty()
      $('#provinsi_tujuan_pgb').append(` <option>Pilih Provinsi</option>`)
      $.each(response.data.provinsi, function (i, value) {
        let isSelected = provinsi_tujuanSelect.toLowerCase() == value.name.toLowerCase() ? 'selected' : ''

        $('#provinsi_tujuan_pgb').append(
          `<option value="` + value.name + `"` + isSelected + `>` + value.name + `</option>`
        )
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

function lihat_pgb(id) {
  // $('.editPenjualan').click(function () {
  //   let id = $(this).attr('data-id')
  // Kirim data melalui Ajax
  $.ajax({
    url:baseUrl + 'get-pgb/' + id,
    method: 'GET',
    data: {
      id: id
    },
    success: function (response) {
      // Tangkap pesan dari server dan tampilkan ke user
      let bulanx = response.data.find.bulan.substring(0, 7)

      $('#form_pgb').attr('action', '/update_pgb/' + response.data.find.id)
      $('#lihat_id_pgb').val(response.data.find.id)
      $('#lihat_bulan_gb').val(bulanx)
      $('#lihat_produk_pgb').val(response.data.find.produk)
      $('#lihat_jenis_moda_pgb').val(response.data.find.jenis_moda)
      $('#lihat_node_asal_pgb').val(response.data.find.node_asal)
      $('#lihat_provinsi_asal_pgb').val(response.data.find.provinsi_asal)
      $('#lihat_node_tujuan_pgb').val(response.data.find.node_tujuan)
      $('#lihat_provinsi_tujuan_pgb').val(response.data.find.provinsi_tujuan)
      $('#lihat_volume_supply_pgb').val(response.data.find.volume_supply)
      $('#lihat_satuan_volume_supply_pgb').val(response.data.find.satuan_volume_supply)
      $('#lihat_volume_angkut_pgb').val(response.data.find.volume_angkut)
      $('#lihat_satuan_volume_angkut_pgb').val(response.data.find.satuan_volume_angkut)


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