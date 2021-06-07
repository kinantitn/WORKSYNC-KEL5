var ctx3 = document.getElementById('myChart3');
$( document ).ready(function() {
    axios.get('getProgressDashboard').then((res) => {
        let foo = res.data
        console.log(foo.progress)
        myChart3 = new Chart(ctx3, {
            type: 'line',
            animationEnabled: true,
            data: {
                labels: foo.project,
                datasets: [{
                    label: 'Proyek Progress',
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



window.handleCreateProject = (input, evt) => {
    evt.preventDefault();
    $('#modal-create-project').modal('show');
    $(".id_employe_project").select2({
        width: "100%",
        dropdownParent: "#modal-create-project"
    });
}


window.handleDeleteProject = (input, evt) => {
    evt.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    Swal.fire({
        title: 'Apakah anda yakin',
        text: "Project akan dihapus secara permanen",
        type: 'warning',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.value) {
            axios.delete('/project/' + $(input).attr('data'))
                .then(response => {
                    alert(response.data.message, '/project');
                })
                .catch(error => {
                    Swal.fire('Gagal', error.response.data.message, 'error');
                })
        }
    })
}

window.handleUpdateProjetcs = (input, evt) => {
    evt.preventDefault();

    const id                = $('#id').val();
    const name              = $('#name').val();
    const start_date_plan   = $('#start_date_plan').val();
    const end_date_plan     = $('#end_date_plan').val();
    const start_date_actual = $('#start_date_actual').val();
    const end_date_actual   = $('#end_date_actual').val();
    const status            = $('#status').val();
    const id_employe        = $('#id_employe').val();


    const data = {
        name: name,
        id_employe: id_employe,
        start_date_plan: start_date_plan,
        end_date_plan: end_date_plan,
        start_date_actual: start_date_actual,
        end_date_actual: end_date_actual,
        status: status,
        id: id,
    }

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


window.handleUpdateProject = (input, evt) => {
    evt.preventDefault();

    const id                = $('#id_edit').val();
    const name              = $('#name_edit').val();
    const id_employe        = $('#id_employe_edit').val();
    const start_date_plan   = $('#start_date_plan_edit').val();
    const end_date_plan     = $('#end_date_plan_edit').val();
    const start_date_actual = $('#start_date_actual_edit').val();
    const end_date_actual   = $('#end_date_actual_edit').val();
    const status            = $('#status_edit').val();


    const data = {
        name: name,
        id_employe: id_employe,
        start_date_plan: start_date_plan,
        end_date_plan: end_date_plan,
        start_date_actual: start_date_actual,
        end_date_actual: end_date_actual,
        status: status,
        id: id,
    }


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




window.handleEditProject = (input, evt) => {
    evt.preventDefault()
    let id = $(input).attr('data')
    axios.get('/project/' + id +'/edit').then(res => {
        let ProjectDetail = $('#modal-edit-project');
        let divProject = $('#appendProjectDetail');
        ProjectDetail.modal('show');
        divProject.empty().append();
        divProject.append(res.data.data.content)
        $("#id_employe_edit").select2({
            width: "100%",
            dropdownParent: "#modal-edit-project"
        });
        let ori = $('#employee_edit').val();
        let cat = JSON.parse("[" + ori + "]");
        $('#id_employe_edit').val(cat).trigger('change');
    })
}



window.handleSubmitProjects = (input, evt) => {
    evt.preventDefault();
    const name              = $('#name').val();
    const id_employe        = $('#id_employe').val();
    const start_date_plan   = $('#start_date_plan').val();
    const end_date_plan     = $('#end_date_plan').val();
    const start_date_actual = $('#start_date_actual').val();
    const end_date_actual   = $('#end_date_actual').val();
    const status            = $('#status').val();

    const data = {
        name: name,
        id_employe: id_employe,
        start_date_plan: start_date_plan,
        end_date_plan: end_date_plan,
        start_date_actual: start_date_actual,
        end_date_actual: end_date_actual,
        status: status,
    }

    axios.post('/project', data).then(res => {
        if (res.data.status) {
            alert(res.data.message, '/project');
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
