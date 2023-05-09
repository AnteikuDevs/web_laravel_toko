
FetchDataTable({
    selector: '#dt-content',
    ajax: {
        url: 'admin/admin-transaction'
    },
    columns: [
        {
            data: null,
            render: function(data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1 + '.';
            }
        },
        {
            data: 'created_at'
        },
        {
            data: 'order_id'
        },
        {
            data: null,
            render: function(val){
                return 'Rp. '+toIdr(val.total)
            }
        },
        {
            data: null,
            render: function(val){
                return `<a href="${url('admin/transaction/'+val.id)}" class="btn btn-primary btn-sm"><i class="ri-information-fill
                "></i></a>`
            }
        }
    ]
})