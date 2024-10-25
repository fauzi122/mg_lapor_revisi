<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Import Excel Kuota LPG Subsidi Verified</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/lpg/storekuota_excel" method="post" id="myform" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="bulan">Bulan*</label>
                        
                        <input class="form-control mb-2" type="month" id="bulan" name="tahun" required>
                    
                    </div>
                    <div class="mb-3">
                        <label for="file">File *</label>
                        <input class="form-control mb-2" type="file" id="file" name="file" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-rounded">Simpan</button>
                    <button type="button" class="btn btn-success btn-rounded">Download Templet Excel</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->    
<!-- Tambahkan link CSS dan JavaScript untuk Bootstrap dan Datepicker -->
