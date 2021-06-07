var ctx4 = document.getElementById('myChart4');
$( document ).ready(function() {
    let project = $('#id_project_global').val();
    let progress_project = $('#progress_project').val();
    console.log(progress_project);
    axios.get('/getProgressProject?project='+project).then((res) => {
        let foo = res.data
        console.log(foo)
        myChart4 = new Chart(ctx4, {
            type: 'line',
            animationEnabled: true,
            data: {
                labels: foo.taskName,
                datasets: [{
                    label: 'Detail Proyek Progress',
                    data: foo.progress,
                    backgroundColor: [
                        '#d9ba4c',
                        '#a0ba4b',
                        '#b9ba8c',
                        '#d9ba4c',
                        '#d9ba4c',
                        '#d9ba4c',
                        '#d9ba4c',
                        '#d9ba4c',
                        '#d9ba4c',
                        '#d9ba4c',
                    ],
                    borderColor: [
                        '#d9ba4c',
                        '#a0ba4b',
                        '#b9ba8c',
                        '#d9ba4c',
                        '#d9ba4c',
                        '#d9ba4c',
                        '#d9ba4c',
                        '#d9ba4c',
                        '#d9ba4c',
                        '#d9ba4c',
                        '#d9ba4c',
                        '#d9ba4c',
                        '#d9ba4c',
                    ],
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        // display: true,
                        ticks: {
                            callback: function(value, index, values) {
                                return moment(value).format('DD-MM-YYYY')
                            }
                        }
                    }],
                    yAxes: [{
                        display: true
                    }]
                }
            }
        });
    });
});



window.handleDeleteTask = (input, evt) => {
    evt.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const idProject = $(input).attr('data-project')
    Swal.fire({
        title: 'Apakah anda yakin',
        text: "Task dan subtask akan dihapus secara permanen",
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
            axios.delete('/task/' + $(input).attr('data'))
                .then(response => {
                    alert(response.data.message, '/project/'+idProject);
                })
                .catch(error => {
                    Swal.fire('Gagal', error.response.data.message, 'error');
                })
        }
    })
}

window.handleUpdateTask = (input, evt) => {
    evt.preventDefault();

    const id_employe            = $('#id_employe_edit').val();
    const id_task               = $('#id_task_edit').val();
    const id_project            = $('#id_project_edit').val();
    const label_task            = $('#label_task_edit').val();
    const description_task      = $('#description_task_edit').val();
    const start_date_plan_task  = $('#start_date_plan_task_edit').val();
    const end_date_plan_task    = $('#end_date_plan_task_edit').val();
    const start_date_actual_task= $('#start_date_actual_task_edit').val();
    const end_date_actual_task  = $('#end_date_actual_task_edit').val();
    const progress_task         = $('#progress_task_edit').val();
    const status                = $('#status_task_edit').val();

    const data = {
        status: status,
        id_employe: id_employe,
        id: id_task,
        id_project: id_project,
        label_task: label_task,
        description_task: description_task,
        start_date_plan_task: start_date_plan_task,
        end_date_plan_task: end_date_plan_task,
        start_date_actual_task: start_date_actual_task,
        end_date_actual_task: end_date_actual_task,
        progress_task: progress_task,
    }


    axios.put('/task/'+id_task, data).then(res => {
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




window.handleEditTask = (input, evt) => {
    evt.preventDefault();

    let id = $(input).attr('data')
    axios.get('/task/' + id +'/edit').then(res => {
        let ProjectDetail = $('#modal-edit-task');
        let divProject = $('#appendDetailEditTask');
        ProjectDetail.modal('show');
        divProject.empty().append();
        divProject.append(res.data.data.content)
        $("#id_employe_edit").select2({
            width: "100%",
            dropdownParent: "#modal-edit-task"
        });
        let ori = $('#employee_edit').val();
        let cat = JSON.parse("[" + ori + "]");
        $('#id_employe_edit').val(cat).trigger('change');
    })
}



window.handleSubmitTask = (input, evt) => {
    evt.preventDefault();
    const id_employe            = $('#id_employe').val();
    const id_project            = $('#id_project').val();
    const label_task            = $('#label_task').val();
    const description_task      = $('#description_task').val();
    const start_date_plan_task  = $('#start_date_plan_task').val();
    const end_date_plan_task    = $('#end_date_plan_task').val();
    // const start_date_actual_task= $('#start_date_actual_task').val();
    // const end_date_actual_task  = $('#end_date_actual_task').val();
    const progress_task         = $('#progress_task').val();

    const data = {
        id_employe: id_employe,
        id_project: id_project,
        label_task: label_task,
        description_task: description_task,
        start_date_plan_task: start_date_plan_task,
        end_date_plan_task: end_date_plan_task,
        // start_date_actual_task: start_date_actual_task,
        // end_date_actual_task: end_date_actual_task,
        progress_task: progress_task,
    }

    axios.post('/task', data).then(res => {
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

window.filterTask = (input) => {
    let project = $(input).attr('data-project');
    let date = $('#date').val()
    let dateStr = date.split("-")
    const start = dateStr[0].trim()
    const end = dateStr[1].trim()
    window.location.href = '/project/'+project+'?start='+start+'&end='+end+'&filter=harian'
}

window.handleCreateTask = (input, evt) => {
    evt.preventDefault();
    $('#modal-create-task').modal('show');
    $(".id_employe_task").select2({
        width: "100%",
        dropdownParent: "#modal-create-task"
    });
}
