async function submit(){
    let data = getFormData('#login-form')
    await Http.post('login',data).then((res) => {
        if(res.errors){
            errorShows('#login-form',res.errors)
        }else{
            if(res.status)
            {
                setUserSigned(res.token)
                redirect(res.redirect)
            }else{
                _notif('#alert-message','danger',res.message)
            }
        }
    })
  }

$(document).on('submit','#login-form',async function(e){
    e.preventDefault();
    $('#login-form button[type=submit]').prop('disabled',true)
    await submit()
    $('#login-form button[type=submit]').prop('disabled',false)
})