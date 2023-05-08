

let TransactionCreate = new class {
    constructor()
    {
        this.productCache = []
        this.getProduk()
    }
    async getProduk()
    {
        let product = await Http.get('kasir/product/list')

        if(product.status)
        {
            let data = product.data
            this.productCache = data   
            
            this.renderTable()
            
        }
    }

    renderTable()
    {
        let _that = this
        let tableRow = $('#list-produk tbody tr').length

        let productActive = []

        $('#list-produk tbody tr').each(function(i,el){
            if($(el).find('select').val())
            {
                productActive.push($(el).find('select').val())
            }
        })

        log(productActive)

        let option = ''

        $.each(this.productCache, function(i,key){
            if(!productActive.includes(key.id.toString()))
            {
                option += `<option value="${key.id}">${key.name} (Stok: ${key.stock})</option>`
            }
        })

        if(tableRow > 0)
        {
            if(productActive.length != tableRow || option == '')
            {
                return false
            }
            let no = tableRow + 1
            let rowId = 'row-'+randId(8)
            $('#list-produk tbody').append(`
                <tr id="${rowId}">
                    <td>${no}</td>
                    <td>
                        <select name="data[${tableRow}][product]" class="form-control">
                            <option value="">Pilih Produk</option>
                            ${option}
                        </select>
                        <div data-error="data.${tableRow}.product"></div>
                    </td>
                    <td>Rp. -</td>
                    <td>
                        <input type="number" name="data[${tableRow}][qty]" class="form-control" max="1" disabled>
                        <div data-error="data.${tableRow}.qty"></div>
                    </td>
                    <td>Rp. -</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm delete"><i class="bi bi-trash"></i></button>
                    </td>
                </tr>
            `)

            $(document).on('change','#'+rowId+' [name="data['+tableRow+'][product]"]', function(){
                let _this = $(this)
                let id = $(this).val()
                $.each(_that.productCache, function(i,key){
                    if(key.id == id)
                    {
                        _this.parents('#'+rowId).find('td:nth-child(3)').html('Rp. '+toIdr(key.price))
                        _this.parents('#'+rowId).find('td:nth-child(4) input').prop('disabled',false)
                        _this.parents('#'+rowId).find('td:nth-child(4) input').prop('max',key.stock)

                        _that.clearProductActive()
                        _that.calcTotal()
                    }
                })
            })

            $(document).on('input','#'+rowId+' [name="data['+tableRow+'][qty]"]', function(){
                let _this = $(this)
                let val = $(this).val()
                let id = $(this).parents('#'+rowId).find('select').val()
                $.each(_that.productCache, function(i,key){
                    if(key.id == id)
                    {
                        _this.parents('#'+rowId).find('td:nth-child(5)').html('Rp. '+toIdr(key.price * val))
                        _that.calcTotal()
                    }
                })
            })
           
            $(document).on('click','#'+rowId+' .delete', function(){
                $(this).parents('#'+rowId).remove()
                _that.clearProductActive()
                _that.calcTotal()
            })
        }else{
            let no = tableRow + 1
            let rowId = 'row-'+randId(8)
            $('#list-produk tbody').html(`
                <tr id="${rowId}">
                    <td>${no}</td>
                    <td>
                        <select name="data[${tableRow}][product]" class="form-control">
                            <option value="">Pilih Produk</option>
                            ${option}
                        </select>
                        <div data-error="data.${tableRow}.product"></div>
                    </td>
                    <td>Rp. -</td>
                    <td>
                        <input type="number" name="data[${tableRow}][qty]" class="form-control" max="1" disabled>
                        <div data-error="data.${tableRow}.qty"></div>
                    </td>
                    <td>Rp. -</td>
                    <td>
                    -
                    </td>
                </tr>
            `)

            $(document).on('change','#'+rowId+' [name="data['+tableRow+'][product]"]', function(){
                let _this = $(this)
                let id = $(this).val()
                $.each(_that.productCache, function(i,key){
                    if(key.id == id)
                    {
                        _this.parents('#'+rowId).find('td:nth-child(3)').html('Rp. '+toIdr(key.price))
                        _this.parents('#'+rowId).find('td:nth-child(4) input').prop('disabled',false)
                        _this.parents('#'+rowId).find('td:nth-child(4) input').prop('max',key.stock)

                        _that.clearProductActive()
                        _that.calcTotal()
                    }
                })
            })

            $(document).on('input','#'+rowId+' [name="data['+tableRow+'][qty]"]', function(){
                let _this = $(this)
                let val = $(this).val()
                let id = $(this).parents('#'+rowId).find('select').val()
                $.each(_that.productCache, function(i,key){
                    if(key.id == id)
                    {
                        _this.parents('#'+rowId).find('td:nth-child(5)').html('Rp. '+toIdr(key.price * val))
                        _that.calcTotal()
                    }
                })
            })
        }
    }

    calcTotal()
    {
        let _that = this
        let total = 0
        $('#list-produk tbody tr').each(function(i,el){
            let id = $(el).find('select').val()
            let qty = $(el).find('td:nth-child(4) input').val()
            if(qty > 0)
            {
                $.each(_that.productCache, function(i,key){
                    if(key.id == id)
                    {
                        total += (key.price * qty)
                    }
                })
            }
        })

        $('.total-all').html('Rp. '+toIdr(total))
    }

    clearProductActive()
    {
        let _that = this
        let productActive = []

        $('#list-produk tbody tr').each(function(i,el){
            if($(el).find('select').val())
            {
                productActive.push($(el).find('select').val())
            }
        })

        let no = 1
        $('#list-produk tbody tr').each(function(i,el){
            let id = $(el).find('select').val()
            let qty = $(el).find('td:nth-child(4) input').val()
            let option = '<option value="">Pilih Produk</option>'
            $.each(_that.productCache, function(i,key){
                if(key.id == id)
                {
                    $(el).find('td:nth-child(5)').html('Rp. '+toIdr(key.price * qty))
                    option += `<option value="${key.id}" ${key.id == id? 'selected' : ''}>${key.name} (Stok: ${key.stock})</option>`
                }else{

                    if(!productActive.includes(key.id.toString()))
                    {
                        option += `<option value="${key.id}">${key.name} (Stok: ${key.stock})</option>`
                    }
                }
            })
            $(el).find('select').html(option)
            $(el).find('td:first-child').html(no)
            no++
        })
    }
}

$(document).on('click','#add-product', function(e){
    e.preventDefault();
    TransactionCreate.renderTable()
})

async function addSubmit() {

    let listData = []
    $('#list-produk tbody tr').each(function(i,el){
        listData.push({
            product: $(el).find('select').val(),
            qty: $(el).find('input').val()
        })
    })

    let data = {
        data: listData
    }

    errorReset('#transaction-add')
    
    let response = await Http.post('kasir/transaction',data)
    if(response.errors){
        errorShows('#transaction-add',response.errors)
    }else{
        if(response.status)
        {
            // reset form
            redirect('kasir/transaction')
            
        }else{
            _notif('#modalAdd .alert-message','danger',response.message)
        }
    }
}

$(document).on('submit','#transaction-add', async function(e){
    e.preventDefault()
    $('#transaction-add button[type=submit]').prop('disabled',true)
    await addSubmit()
    $('#transaction-add button[type=submit]').prop('disabled',false)
})