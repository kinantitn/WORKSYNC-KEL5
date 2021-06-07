

window.handleDeleteSubtask = (input, evt) => {
    evt.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const idProject = $(input).attr('data-project');
    Swal.fire({
        title: 'Apakah anda yakin',
        text: "Subtask akan dihapus secara permanen",
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
            axios.delete('/subtask/' + $(input).attr('data'))
                .then(response => {
                    alert(response.data.message, '/project/'+idProject);
                })
                .catch(error => {
                    Swal.fire('Gagal', error.response.data.message, 'error');
                })
        }
    })
}

window.handleUpdateSubtask = (input, evt) => {
    evt.preventDefault();

    const id_employe                = $('#id_employe_edit').val();
    const id_project                = $('#id_project_edit').val();
    const id_task                   = $('#id_task_edit').val();
    const id_activity               = $('#id_activity_edit').val();
    const label_activity            = $('#label_activity_edit').val();
    const description_activity      = $('#description_activity_edit').val();
    const start_date_plan_activity  = $('#start_date_plan_activity_edit').val();
    const end_date_plan_activity    = $('#end_date_plan_activity_edit').val();
    const start_date_actual_activity= $('#start_date_actual_activity_edit').val();
    const end_date_actual_activity  = $('#end_date_actual_activity_edit').val();
    const progress_activity         = $('#progress_activity_edit').val();
    const status_activity           = $('#status_activity_edit').val();

    const data = {
        id_activity: id_activity,
        id_task: id_task,
        id_employe: id_employe,
        label_activity: label_activity,
        description_activity: description_activity,
        start_date_plan_activity: start_date_plan_activity,
        end_date_plan_activity: end_date_plan_activity,
        start_date_actual_activity: start_date_actual_activity,
        end_date_actual_activity: end_date_actual_activity,
        progress_activity: progress_activity,
        status_activity: status_activity
    }


    axios.put('/subtask/'+id_activity, data).then(res => {
        if (res.data.status) {
            alert(res.data.message, '/project/'+id_project);
        } else {
            Swal.fire({
                icon: 'error',
                info: 'error',
                title: 'Oops...',
                text: 'Please fill form',
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


window.handleUpdateProject = (input, evt) => {
    evt.preventDefault();

    const id                = $('#id_edit').val();
    const name              = $('#name_edit').val();
    const start_date_plan   = $('#start_date_plan_edit').val();
    const end_date_plan     = $('#end_date_plan_edit').val();
    const start_date_actual = $('#start_date_actual_edit').val();
    const end_date_actual   = $('#end_date_actual_edit').val();
    const status            = $('#status_edit').val();


    const data = {
        name: name,
        start_date_plan: start_date_plan,
        end_date_plan: end_date_plan,
        start_date_actual: start_date_actual,
        end_date_actual: end_date_actual,
        status: status,
        id: id,
    }

    console.log(data)

    axios.put('/project/'+id, data).then(res => {
        if (res.data.status) {
            alert(res.data.message, '/project');
        } else {
            Swal.fire({
                icon: 'error',
                info: 'error',
                title: 'Oops...',
                text: 'Please fill form',
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




window.handleCreateSubtask = (input, evt) => {
    evt.preventDefault();

    let id = $(input).attr('data')
    axios.get('/subtask?task=' + id).then(res => {
        let SubtaskDetail = $('#modal-create-subtask');
        let divProject = $('#appendDetailCreateSubtask');
        SubtaskDetail.modal('show');
        divProject.empty().append();
        divProject.append(res.data.data.content)
        $(".id_employe_subtask").select2({
            width: "100%",
            dropdownParent: "#modal-create-subtask"
        });
    })
}


window.handleEditSubtask = (input, evt) => {
    evt.preventDefault();
    let id = $(input).attr('data')
    axios.get('/subtask/' + id + '/edit').then(res => {
        let SubtaskDetail = $('#modal-edit-subtask');
        let divProject = $('#appendDetailEditSubtask');
        SubtaskDetail.modal('show');
        divProject.empty().append();
        divProject.append(res.data.data.content)
        $("#id_employe_edit").select2({
            width: "100%",
            dropdownParent: "#modal-edit-subtask"
        });
        let ori = $('#employee_edit').val();
        let cat = JSON.parse("[" + ori + "]");
        $('#id_employe_edit').val(cat).trigger('change');
    })
}



window.handleSubmitSubtask = (input, evt) => {
    evt.preventDefault();
    const id_project                = $('#id_project').val();
    const id_employe                = $('#id_employe_subtask').val();
    const id_task                   = $('#id_task').val();
    const label_activity            = $('#label_activity').val();
    const description_activity      = $('#description_activity').val();
    const start_date_plan_activity  = $('#start_date_plan_activity').val();
    const end_date_plan_activity    = $('#end_date_plan_activity').val();
    const start_date_actual_activity= $('#start_date_actual_activity').val();
    const end_date_actual_activity  = $('#end_date_actual_activity').val();
    const progress_activity         = $('#progress_activity').val();

    const data = {
        id_task: id_task,
        id_employe: id_employe,
        label_activity: label_activity,
        description_activity: description_activity,
        start_date_plan_activity: start_date_plan_activity,
        end_date_plan_activity: end_date_plan_activity,
        start_date_actual_activity: start_date_actual_activity,
        end_date_actual_activity: end_date_actual_activity,
        progress_activity: progress_activity
    }

    axios.post('/subtask', data).then(res => {
        if (res.data.status) {
            alert(res.data.message, '/project/'+id_project);
        } else {
            Swal.fire({
                icon: 'error',
                info: 'error',
                title: 'Oops...',
                text: 'Isi form dengan lengkap',
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
