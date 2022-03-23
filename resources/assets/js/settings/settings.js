'use strict';

let tableName = '#settingsTable';
$(tableName).DataTable({
    scrollX: true,
    deferRender: true,
    scroller: true,
    processing: true,
    serverSide: true,
    'order': [
        [0, 'asc']
    ],
    ajax: {
        url: recordsURL,
    },
    columnDefs: [{
        'targets': [5],
        'orderable': false,
        'className': 'text-center',
        'width': '8%',
    }, ],
    columns: [{
            className: "dt-center align-middle",
            data: function(row) {
                return `<div style="background-color:${row.main_color};">${row.main_color}</div>`
            },
            name: 'main_color'
        }, {
            className: "dt-center align-middle",
            data: function(row) {
                return `<div style="background-color:${row.text_color};">${row.text_color}</div>`
            },
            name: 'text_color'
        }, {
            className: "dt-center align-middle",
            data: function(row) {
                return `<img src="data:image/png;base64,${row.logo}" width="32"/>`
            },
            name: 'logo'
        }, {
            className: "dt-center align-middle",
            data: 'ip_check_middleware',
            name: 'ip_check_middleware'
        }, {
            className: "dt-center align-middle",
            data: function(row) {
                return row.active == 1 ? 'Activo' : 'Inactivo';
            },
            name: 'active'
        },
        {
            data: function(row) {
                let url = recordsURL + row.id;
                let data = [{
                    'id': row.id,
                    'url': url + '/edit',
                }];

                return prepareTemplateRender('#settingsTemplate',
                    data);
            },
            name: 'id',
        },
    ],
});

$(document).on('click', '.delete-btn', function(event) {
    let recordId = $(event.currentTarget).data('id');
    deleteItem(recordsURL + recordId, tableName, 'Setting');
});