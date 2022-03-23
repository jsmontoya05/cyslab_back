'use strict';

let tableName = '#credentialsTable';
let credentialURL = window.location.origin + '/credentials/';

let dataTable = $(tableName).DataTable({
    scrollX: true,
    deferRender: true,
    scroller: true,
    processing: true,
    serverSide: true,
    'order': [
        [0, 'asc']
    ],
    ajax: {
        url: credentialURL,
    },
    columnDefs: [{
        'targets': [7],
        'orderable': false,
        'className': 'text-center',
        'width': '8%',
    }, ],
    columns: [{
            className: "dt-center align-middle",
            data: 'client_id',
            name: 'client_id'
        }, {
            className: "dt-center align-middle",
            data: 'client_secret',
            name: 'client_secret'
        }, {
            className: "dt-center align-middle",
            data: 'resource',
            name: 'resource'
        }, {
            className: "dt-center align-middle",
            data: 'grant_type',
            name: 'grant_type'
        }, {
            className: "dt-center align-middle",
            data: 'subscription_id',
            name: 'subscription_id'
        }, {
            className: "dt-center align-middle",
            data: 'tenant',
            name: 'tenant'
        }, {
            className: "dt-center align-middle",
            data: function(row) {
                return row.active == 1 ? 'Activo' : 'Inactivo';
            },
            name: 'active'
        },
        {
            data: function(row) {
                let url = credentialURL + row.id;
                let data = [{
                    'id': row.id,
                    'url': url + '/edit',
                }];

                return prepareTemplateRender('#credentialsTemplate',
                    data);
            },
            name: 'id',
        },
    ],
});

$(document).on('click', '.delete-btn', function(event) {
    let recordId = $(event.currentTarget).data('id');
    deleteItem(credentialURL + recordId, tableName, 'Credential');
});