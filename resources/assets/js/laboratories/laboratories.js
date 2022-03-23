'use strict';

let tableName = '#laboratoriesTable';
let laboratoryURL = 'laboratories/';

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
        url: laboratoryURL,
    },
    columnDefs: [{
        'targets': [3],
        'orderable': false,
        'className': 'text-center',
        'width': '8%',
    }, ],
    columns: [{
            data: 'id',
            name: 'id'
        },
        {
            data: 'name',
            name: 'name'
        }, {
            data: 'location',
            name: 'location'
        },
        {
            data: function(row) {
                let url = laboratoryURL + row.id;
                let data = [{
                    'id': row.id,
                    'url': url + '/edit',
                }];

                return prepareTemplateRender('#laboratoriesTemplate',
                    data);
            },
            name: 'id',
        },
    ],
});

$(document).on('click', '.delete-btn', function(event) {
    let recordId = $(event.currentTarget).data('id');
    deleteItem(laboratoryURL + recordId, tableName, 'Laboratory');
});
