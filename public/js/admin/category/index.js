

let Category = new class {
    constructor()
    {
        this.render()
    }
    render()
    {
        FetchDataTable({
            selector: '#dt-content',
            ajax: {
                url: 'admin/category'
            },
            columns: [
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1 + '.';
                    }
                },
                {
                    data: 'name'
                },
                {
                    data: null,
                    render: function(val){
                        let btnDetail = '__'+randId(7),
                            btnEdit = '__'+randId(8),
                            btnDelete = '__'+randId(9)

                        $(document).on('click','['+btnDetail+']', function(e){
                            Category.show(val)
                        })

                        $(document).on('click','['+btnEdit+']', function(e){
                            Category.edit(val)
                        })
                        
                        $(document).on('click','['+btnDelete+']', function(e){
                            Category.delete(val)
                        })

                        return `<button class="btn btn-primary btn-sm" ${btnEdit}><i class="ri-edit-2-fill"></i></button>
                                <button class="btn btn-danger btn-sm" ${btnDelete}><i class="ri-delete-bin-2-fill"></i></button>`
                    }
                }
            ]
        })
    }
    edit(data)
    {
        $('#modalEdit').attr('data-id',data.id)
        $('#modalEdit [name=name]').val(data.name)
        $('#modalEdit').modal('show')
    }
    delete(data)
    {
        $('#modalDelete').attr('data-id',data.id)
        $('#modalDelete').modal('show')
    }
}

async function addSubmit() {
    let data = getFormData('#modalAdd form')

    errorReset('#modalAdd form')
    
    let response = await Http.post('admin/category',data)
    if(response.errors){
        errorShows('#modalAdd form',response.errors)
    }else{
        if(response.status)
        {
            $('#modalAdd').modal('hide')
            // reset form
            resetForm('#modalAdd form')
            Category.render()
        }else{
            _notif('#modalAdd .alert-message','danger',response.message)
        }
    }
}

$(document).on('submit', '#modalAdd form', async function(e){
    e.preventDefault();
    $('#modalAdd form button[type=submit]').prop('disabled',true)
    await addSubmit()
    $('#modalAdd form button[type=submit]').prop('disabled',false)
})


async function editSubmit() {
    let data = getFormData('#modalEdit form')

    errorReset('#modalAdd form')
    
    let response = await Http.put('admin/category/'+$('#modalEdit').attr('data-id'),data)
    if(response.errors){
        errorShows('#modalEdit form',response.errors)
    }else{
        if(response.status)
        {
            $('#modalEdit').modal('hide')
            // reset form
            resetForm('#modalEdit form')
            Category.render()
        }else{
            _notif('#modalEdit .alert-message','danger',response.message)
        }
    }
}

$(document).on('submit', '#modalEdit form', async function(e){
    e.preventDefault();
    $('#modalEdit form button[type=submit]').prop('disabled',true)
    await editSubmit()
    $('#modalEdit form button[type=submit]').prop('disabled',false)
})

async function deleteSubmit() {
    let id = $('#modalDelete').attr('data-id')
    
    let response = await Http.delete('admin/category/'+id)
    if(response.errors){
        errorShows('#modalDelete form',response.errors)
    }else{
        if(response.status)
        {
            $('#modalDelete').modal('hide')
            Category.render()
        }else{
            _notif('#modalDelete ._alert-message','danger',response.message)
        }
    }
}

$(document).on('submit', '#modalDelete form', async function(e){
    e.preventDefault();
    $('#modalDelete form button[type=submit]').prop('disabled',true)
    await deleteSubmit()
    $('#modalDelete form button[type=submit]').prop('disabled',false)
})
    