// Tentukan apakah situs diakses dari localhost
var isLocalhost = window.location.hostname === '127.0.0.1:8000' || window.location.hostname === 'localhost';

// Atur baseUrl berdasarkan apakah situs diakses dari localhost
var baseUrl = isLocalhost ? "/" : "/pelaporan-hilir/";


function edit_lgpsub(id) {
    // $('.editPenjualan').click(function () {
    //     let id = $(this).attr('data-id')
    // Kirim data melalui Ajax
    $.ajax({
      url: baseUrl +'get-lgpsub/' + id,
      method: 'GET',
      data: {
        id: id
      },
      success: function (response) {

        let bulanx = response.data.find.bulan.substring(0, 7)
        // Tangkap pesan dari server dan tampilkan ke user
        $('#form_lgpsub').attr('action', '/update_lgpsub/' + response.data.find.id)
        $('#id_lgpsub').val(response.data.find.id)
        // $('#bulan_lgpsub').val(response.data.find.bulan)
        $('#bulan_lgpsub').val(bulanx)
        $('#provinsi_lgpsub').val(response.data.find.provinsi)
        $('#volume_lgpsub').val(response.data.find.volume)
  
    
        let provinsiSelect = response.data.find.provinsi
        
  
  
        $('#provinsi_lgpsub').empty()
        $('#provinsi_lgpsub').append(` <option>Pilih Provinsi</option>`)
        $.each(response.data.provinsi, function (i, value) {
          let isSelected = provinsiSelect == value.name ? 'selected' : ''
  
          $('#provinsi_lgpsub').append(
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
    //   })
}

function lihat_lgpsub(id) {
    // $('.editPenjualan').click(function () {
    //     let id = $(this).attr('data-id')
    // Kirim data melalui Ajax
    $.ajax({
      url: baseUrl +'get-lgpsub/' + id,
      method: 'GET',
      data: {
        id: id
      },
      success: function (response) {

        let bulanx = response.data.find.bulan.substring(0, 7)
        // Tangkap pesan dari server dan tampilkan ke user
        $('#form_lgpsub_lihat').attr('action', '/update_lgpsub/' + response.data.find.id)
        $('#id_lgpsub_lihat').val(response.data.find.id)
        // $('#bulan_lgpsub').val(response.data.find.bulan)
        $('#bulan_lgpsub_lihat').val(bulanx)
        $('#provinsi_lgpsub_lihat').val(response.data.find.provinsi)
        $('#volume_lgpsub_lihat').val(response.data.find.volume)
  

  
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


function edit_klpg(id, kab_kota) {
    // $('.editPenjualan').click(function () {
    //     let id = $(this).attr('data-id')
    // Kirim data melalui Ajax
    $.ajax({
      url: baseUrl +'get-klpgs/' + id,
      method: 'GET',
      data: {
        id: id
      },
      success: function (response) {

        // Tangkap pesan dari server dan tampilkan ke user
        $('#form_klpgs').attr('action', '/update_klpgs/' + response.data.find.id)
        $('#id_klpgs').val(response.data.find.id)
        $('#tahun_klpgs').val(response.data.find.tahun)
        $('#provinsi_klpgs').val(response.data.find.provinsi)
        $('#kab_kota_klpgs').val(response.data.find.kab_kota)
        $('#volume_klpgs').val(response.data.find.volume)
  
    
        let provinsiSelect = response.data.find.provinsi
        let kotaSelect = response.data.find.kab_kota
  
  
        $('#provinsi_klpgs').empty()
        $('#provinsi_klpgs').append(` <option>Pilih Provinsi</option>`)
        $.each(response.data.provinsi, function (i, value) {
          let isSelected = provinsiSelect == value.name ? 'selected' : ''
  
          $('#provinsi_klpgs').append(
            `<option value="` + value.name + `"` + isSelected + `>` + value.name + `</option>`
          )
        });
  
        $.ajax({
            url: baseUrl +'get_kota_subsidi/' + kab_kota,
            method: 'GET',
            data: {
            },
            success: function (response) {
              // console.log(response);
              // console.log(kabupaten_kota);
              // Loop melalui data dan tambahkan opsi ke dalam select
              $('#kab_kota_klpgs').empty()
              $('#kab_kota_klpgs').append(` <option>Pilih Kab / Kota</option>`)
              $.each(response.data, function (i, value) {
                let isSelected = kotaSelect == value.nama_kota ? 'selected' : ''
                $('#kab_kota_klpgs').append(
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

function lihat_klpg(id, kab_kota) {
  // $('.editPenjualan').click(function () {
  //     let id = $(this).attr('data-id')
  // Kirim data melalui Ajax
  $.ajax({
    url: baseUrl +'get-klpgs/' + id,
    method: 'GET',
    data: {
      id: id
    },
    success: function (response) {

      // Tangkap pesan dari server dan tampilkan ke user
      $('#form_klpgs_lihat').attr('action', '/update_klpgs/' + response.data.find.id)
      $('#id_klpgs_lihat').val(response.data.find.id)
      $('#tahun_klpgs_lihat').val(response.data.find.tahun)
      $('#provinsi_klpgs_lihat').val(response.data.find.provinsi)
      $('#kab_kota_klpgs_lihat').val(response.data.find.kab_kota)
      $('#volume_klpgs_lihat').val(response.data.find.volume)


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