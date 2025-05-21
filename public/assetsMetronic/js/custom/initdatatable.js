"use strict";

var KTDatatablesExample = function () {
    const initDatatableForTable = function (table, index) {
        const uniqueId = 'kt_datatable_' + index;
        table.setAttribute('data-dt-id', uniqueId); // assign a unique ID

        const parentCard = table.closest('.card');

        // === Create Search + Export DOM dynamically ===
        const header = parentCard.querySelector('.card-header .card-title');
        if (header) {
            // Create Search Input
            const searchWrapper = document.createElement('div');
            searchWrapper.className = 'd-flex align-items-center position-relative my-1';

            searchWrapper.innerHTML = `
                <span class="ki-duotone ki-magnifier fs-1 position-absolute ms-4">
                    <span class="path1"></span><span class="path2"></span>
                </span>
                <input type="text" data-kt-filter="search_${uniqueId}" class="form-control w-250px ps-14" placeholder="Search.."/>
            `;
            header.appendChild(searchWrapper);

            // Create Hidden Title (if not exists)
            if (!parentCard.querySelector('.export-title')) {
                const hiddenTitle = document.createElement('input');
                hiddenTitle.type = 'hidden';
                hiddenTitle.className = 'export-title';
                hiddenTitle.value = 'Exported Table ' + (index + 1);
                header.appendChild(hiddenTitle);
            }
        }

        // === Create Export Button & Menu ===
        const toolbar = parentCard.querySelector('.card-toolbar');
        if (toolbar) {
            const exportBtnGroup = document.createElement('div');
            exportBtnGroup.className = 'd-flex align-items-center gap-2';

            exportBtnGroup.innerHTML = `
                <button type="button" class="btn btn-sm btn-outline btn-secondary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                    <i class="ki-duotone ki-exit-down fs-2">
                        <span class="path1"></span><span class="path2"></span>
                    </i> Export Table
                </button>
                <div id="kt_datatable_export_menu_${index}" class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4" data-kt-menu="true">
                    <div class="menu-item px-3"><a href="#" class="menu-link px-3" data-kt-export="copy">Copy to clipboard</a></div>
                    <div class="menu-item px-3"><a href="#" class="menu-link px-3" data-kt-export="excel">Export as Excel</a></div>
                    <div class="menu-item px-3"><a href="#" class="menu-link px-3" data-kt-export="pdf">Export as PDF</a></div>
                    <div class="menu-item px-3"><a href="#" class="menu-link px-3" data-kt-export="print">Print</a></div>
                </div>
                <div id="kt_datatable_buttons_${index}" class="d-none"></div>
            `;
            toolbar.appendChild(exportBtnGroup);

            // ✅ Ensure the export menu works (Metronic)
            if (typeof KTMenu !== 'undefined') {
                KTMenu.createInstances();
            }
        }

        // === DataTable Initialization ===
        const datatable = $(table).DataTable({
            info: true,
            order: [],
            pageLength: 10
        });

        const exportTitleEl = parentCard.querySelector('.export-title');
        const documentTitle = exportTitleEl ? exportTitleEl.value || exportTitleEl.innerText : 'Exported Data';

        const buttonContainer = $('#kt_datatable_buttons_' + index);
        new $.fn.dataTable.Buttons(table, {
            buttons: [
                { extend: 'copyHtml5', title: documentTitle, className: 'buttons-copy' },
                { extend: 'excelHtml5', title: documentTitle, className: 'buttons-excel' },
                { extend: 'pdfHtml5', title: documentTitle, className: 'buttons-pdf' },
                { extend: 'print', title: documentTitle, className: 'buttons-print' },
                { extend: 'colvis', text: 'Column Visibility', className: 'buttons-colvis btn btn-light btn-sm' }
            ]
        }).container().appendTo(buttonContainer);

         // === Move Column Visibility Button beside Export
        const colvisBtn = buttonContainer.find('.buttons-colvis');
        if (colvisBtn.length) {
            const exportBtnGroup = parentCard.querySelector('.card-toolbar .d-flex');
            // Directly move the actual button to preserve DataTables menu behavior
            exportBtnGroup.appendChild(colvisBtn[0]);
        }

        // === Export Menu Click Handler ===
        const exportMenu = parentCard.querySelector(`#kt_datatable_export_menu_${index}`);
        if (exportMenu) {
            exportMenu.querySelectorAll('[data-kt-export]').forEach(exportButton => {
                exportButton.addEventListener('click', e => {
                    e.preventDefault();
                    const exportType = exportButton.getAttribute('data-kt-export');
                    const exportBtn = buttonContainer.find(`.buttons-${exportType}`);
                    if (exportBtn.length) {
                        exportBtn[0].click();
                    }
                });
            });
        }

        // === Search Handler ===
        const searchInput = parentCard.querySelector(`[data-kt-filter="search_${uniqueId}"]`);
        if (searchInput) {
            searchInput.addEventListener('keyup', function (e) {
                datatable.search(e.target.value).draw();
            });
        }
    };

    return {
        init: function () {
            const tables = document.querySelectorAll('table.kt-datatable');
            tables.forEach((table, index) => initDatatableForTable(table, index));
        }
    };
}();

KTUtil.onDOMContentLoaded(function () {
    KTDatatablesExample.init();
});
