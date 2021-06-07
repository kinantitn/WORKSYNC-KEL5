window.handleChangePassword = (input, evt) => {
    evt.preventDefault();
    const old_password      = $('#old_password').val();
    const new_password      = $('#new_password').val();
    const confirm_password  = $('#confirm_password').val();

    const data = {
        old_password: old_password,
        new_password: new_password,
        confirm_password: confirm_password,
    }

    axios.post('/changePassword', data).then(res => {
        if (res.data.status) {
            alert(res.data.message, '/home');
        } else {
            Swal.fire({
                icon: 'error',
                info: 'error',
                title: 'Oops...',
                text: res.data ? res.data.message : 'Isi form dengan lengkap' ,
            })
        }
    })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                info: 'error',
                title: 'Oops...',
                text: error.response.data.message,
            })
        })
}
