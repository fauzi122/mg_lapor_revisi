$(".tableWithExport").each(function () {
    let $table = $(this);

    $table.DataTable({
        dom:
            "<'d-flex justify-content-between align-items-center mb-3'Bf>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-6'i><'col-sm-6'p>>",
        buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
        info: true,
        paging: true,
        lengthChange: true,
        ordering: true,
        order: [],
        columnDefs: [
            { orderable: false, targets: 0 },
            { orderable: false, targets: -1 },
        ],
    });
});
