<!DOCTYPE html>
<html>

<head>
    <title>Real Time Data</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <table id="data-table" border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Bulan</th>
                <th>Provinsi</th>
                <th>Kabupaten Kota</th>
                <th>Volume</th>
                <th>Satuan</th>
                <th>Keterangan</th>
                <th>Jenis</th>
                <th>Tipe</th>
                <!-- Tambahkan lebih banyak <th> sesuai dengan data Anda -->
            </tr>
        </thead>
        <tbody>
            <!-- Data akan diisikan di sini melalui AJAX -->
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            setInterval(function() {
                $.ajax({
                    url: '/real-time-data',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var html = '';
                        for (var i = 0; i < data.length; i++) {
                            html += '<tr>';
                            html += '<td>' + (i + 1) + '</td>';
                            html += '<td>' + data[i].bulan + '</td>';
                            html += '<td>' + data[i].provinsi + '</td>';
                            html += '<td>' + data[i].kabupaten_kota + '</td>';
                            html += '<td>' + data[i].volume + '</td>';
                            html += '<td>' + data[i].satuan + '</td>';
                            html += '<td>' + data[i].keterangan + '</td>';
                            html += '<td>' + data[i].jenis + '</td>';
                            html += '<td>' + data[i].tipe + '</td>';
                            // Tambahkan lebih banyak kolom sesuai dengan data Anda
                            html += '</tr>';
                        }
                        $('#data-table tbody').html(html);
                    }
                });
            }, 500); // Update data setiap 3 detik
        });
    </script>
</body>

</html>
