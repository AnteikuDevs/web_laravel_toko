
let uploadImageAdd = new FileUpload('#uploadImageAdd',{
    title: "Upload Foto",
    lang: 'id',
    accept: [
        'jpg',
        'jpeg',
        'png',
    ],
    maxFile: 1,
    maxSize: 3,
    customs: {
        primary: '#0d6efd',
        secondary: '#f6f9ff',
        background: '#fff',
        tertiary: '#0d6efd'
    }
})
let uploadImageEdit = new FileUpload('#uploadImageEdit',{
    title: "Upload Foto",
    lang: 'id',
    accept: [
        'jpg',
        'jpeg',
        'png',
    ],
    maxFile: 1,
    maxSize: 3,
    customs: {
        primary: '#0d6efd',
        secondary: '#f6f9ff',
        background: '#fff',
        tertiary: '#0d6efd'
    }
})

let Product = new class {
    constructor()
    {
        this.render()
        this.category()
    }
    async category()
    {
        let category = await Http.get('admin/category/list')

        if(category.status)
        {
            let data = category.data
            let option = '<option value="">Pilih kategori</option>'
            $.each(data, function(i,key){
                option += '<option value="'+key.id+'">'+key.name+'</option>'
            })

            $('#modalAdd [name=category]').html(option)
            $('#modalEdit [name=category]').html(option)
        }
    }
    render()
    {
        FetchDataTable({
            selector: '#dt-content',
            ajax: {
                url: 'admin/product'
            },
            columns: [
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1 + '.';
                    }
                },
                {
                    data: null,
                    render: function(val){
                        return `<img src="${url(val.image)}" alt="Foto" width="120px"/>`
                    }
                },
                {
                    data: null,
                    render: function(val){
                        return `<small class="text-muted">${val.category.name}</small><br>
                        <h5>${val.name}</h5>`
                    }
                },
                {
                    data: null,
                    render: function(val){
                        return 'Rp. '+toIdr(val.price)
                    }
                },
                {
                    data: 'stock',
                    default: 'Stok kosong'
                },
                {
                    data: null,
                    render: function(val){
                        let btnDetail = '__'+randId(7),
                            btnEdit = '__'+randId(8),
                            btnDelete = '__'+randId(9)

                        $(document).on('click','['+btnDetail+']', function(e){
                            Product.show(val)
                        })

                        $(document).on('click','['+btnEdit+']', function(e){
                            Product.edit(val)
                        })
                        
                        $(document).on('click','['+btnDelete+']', function(e){
                            Product.delete(val)
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
        uploadImageEdit.clear()
        uploadImageEdit.deletedIds = []
        uploadImageEdit.setValue([
            {
                id: '-',
                data: data.image
            }
        ])
        $('#modalEdit').attr('data-id',data.id)
        $('#modalEdit [name=category]').val(data.category_id).trigger('change')
        $('#modalEdit [name=name]').val(data.name)
        $('#modalEdit [name=price]').val(data.price)
        $('#modalEdit [name=stock]').val(data.stock)
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
    data.image = uploadImageAdd.getValue(true)

    errorReset('#modalAdd form')
    
    let response = await Http.post('admin/product',data)
    if(response.errors){
        errorShows('#modalAdd form',response.errors)
    }else{
        if(response.status)
        {
            $('#modalAdd').modal('hide')
            // reset form
            resetForm('#modalAdd form')
            uploadImageAdd.clear()
            Product.render()
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
    data.image = uploadImageEdit.getValue(true)
    data.image_deleted = uploadImageEdit.deletedIds.length? 1 : 0

    errorReset('#modalAdd form')
    
    let response = await Http.put('admin/product/'+$('#modalEdit').attr('data-id'),data)
    if(response.errors){
        errorShows('#modalEdit form',response.errors)
    }else{
        if(response.status)
        {
            $('#modalEdit').modal('hide')
            // reset form
            resetForm('#modalEdit form')
            uploadImageEdit.clear()
            Product.render()
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
    
    let response = await Http.delete('admin/product/'+id)
    if(response.errors){
        errorShows('#modalDelete form',response.errors)
    }else{
        if(response.status)
        {
            $('#modalDelete').modal('hide')
            Product.render()
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
    