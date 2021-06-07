/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*********************************!*\
  !*** ./public/app/src/tasks.js ***!
  \*********************************/
var ctx4 = document.getElementById('myChart4');
$(document).ready(function () {
  var project = $('#id_project_global').val();
  var progress_project = $('#progress_project').val();
  console.log(progress_project);
  axios.get('/getProgressProject?project=' + project).then(function (res) {
    var foo = res.data;
    console.log(foo);
    myChart4 = new Chart(ctx4, {
      type: 'line',
      animationEnabled: true,
      data: {
        labels: foo.taskName,
        datasets: [{
          label: 'Detail Proyek Progress',
          data: foo.progress,
          backgroundColor: ['#d9ba4c', '#a0ba4b', '#b9ba8c', '#d9ba4c', '#d9ba4c', '#d9ba4c', '#d9ba4c', '#d9ba4c', '#d9ba4c', '#d9ba4c'],
          borderColor: ['#d9ba4c', '#a0ba4b', '#b9ba8c', '#d9ba4c', '#d9ba4c', '#d9ba4c', '#d9ba4c', '#d9ba4c', '#d9ba4c', '#d9ba4c', '#d9ba4c', '#d9ba4c', '#d9ba4c']
        }]
      },
      options: {
        scales: {
          xAxes: [{
            // display: true,
            ticks: {
              callback: function callback(value, index, values) {
                return moment(value).format('DD-MM-YYYY');
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

window.handleDeleteTask = function (input, evt) {
  evt.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  var idProject = $(input).attr('data-project');
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
  }).then(function (result) {
    if (result.value) {
      axios["delete"]('/task/' + $(input).attr('data')).then(function (response) {
        alert(response.data.message, '/project/' + idProject);
      })["catch"](function (error) {
        Swal.fire('Gagal', error.response.data.message, 'error');
      });
    }
  });
};

window.handleUpdateTask = function (input, evt) {
  evt.preventDefault();
  var id_employe = $('#id_employe_edit').val();
  var id_task = $('#id_task_edit').val();
  var id_project = $('#id_project_edit').val();
  var label_task = $('#label_task_edit').val();
  var description_task = $('#description_task_edit').val();
  var start_date_plan_task = $('#start_date_plan_task_edit').val();
  var end_date_plan_task = $('#end_date_plan_task_edit').val();
  var start_date_actual_task = $('#start_date_actual_task_edit').val();
  var end_date_actual_task = $('#end_date_actual_task_edit').val();
  var progress_task = $('#progress_task_edit').val();
  var status = $('#status_task_edit').val();
  var data = {
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
    progress_task: progress_task
  };
  axios.put('/task/' + id_task, data).then(function (res) {
    if (res.data.status) {
      alert(res.data.message, '/project/' + id_project);
    } else {
      Swal.fire({
        icon: 'error',
        info: 'error',
        title: 'Oops...',
        text: 'Please fill form'
      });
    }
  })["catch"](function (error) {
    Swal.fire({
      icon: 'error',
      info: 'error',
      title: 'Oops...',
      text: error.response.data.message
    });
  });
};

window.handleUpdateProject = function (input, evt) {
  evt.preventDefault();
  var id = $('#id_edit').val();
  var name = $('#name_edit').val();
  var start_date_plan = $('#start_date_plan_edit').val();
  var end_date_plan = $('#end_date_plan_edit').val();
  var start_date_actual = $('#start_date_actual_edit').val();
  var end_date_actual = $('#end_date_actual_edit').val();
  var status = $('#status_edit').val();
  var data = {
    name: name,
    start_date_plan: start_date_plan,
    end_date_plan: end_date_plan,
    start_date_actual: start_date_actual,
    end_date_actual: end_date_actual,
    status: status,
    id: id
  };
  console.log(data);
  axios.put('/project/' + id, data).then(function (res) {
    if (res.data.status) {
      alert(res.data.message, '/project');
    } else {
      Swal.fire({
        icon: 'error',
        info: 'error',
        title: 'Oops...',
        text: 'Please fill form'
      });
    }
  })["catch"](function (error) {
    Swal.fire({
      icon: 'error',
      info: 'error',
      title: 'Oops...',
      text: error.response.data.message
    });
  });
};

window.handleEditTask = function (input, evt) {
  evt.preventDefault();
  var id = $(input).attr('data');
  axios.get('/task/' + id + '/edit').then(function (res) {
    var ProjectDetail = $('#modal-edit-task');
    var divProject = $('#appendDetailEditTask');
    ProjectDetail.modal('show');
    divProject.empty().append();
    divProject.append(res.data.data.content);
    $("#id_employe_edit").select2({
      width: "100%",
      dropdownParent: "#modal-edit-task"
    });
    var ori = $('#employee_edit').val();
    var cat = JSON.parse("[" + ori + "]");
    $('#id_employe_edit').val(cat).trigger('change');
  });
};

window.handleSubmitTask = function (input, evt) {
  evt.preventDefault();
  var id_employe = $('#id_employe').val();
  var id_project = $('#id_project').val();
  var label_task = $('#label_task').val();
  var description_task = $('#description_task').val();
  var start_date_plan_task = $('#start_date_plan_task').val();
  var end_date_plan_task = $('#end_date_plan_task').val(); // const start_date_actual_task= $('#start_date_actual_task').val();
  // const end_date_actual_task  = $('#end_date_actual_task').val();

  var progress_task = $('#progress_task').val();
  var data = {
    id_employe: id_employe,
    id_project: id_project,
    label_task: label_task,
    description_task: description_task,
    start_date_plan_task: start_date_plan_task,
    end_date_plan_task: end_date_plan_task,
    // start_date_actual_task: start_date_actual_task,
    // end_date_actual_task: end_date_actual_task,
    progress_task: progress_task
  };
  axios.post('/task', data).then(function (res) {
    if (res.data.status) {
      alert(res.data.message, '/project/' + id_project);
    } else {
      Swal.fire({
        icon: 'error',
        info: 'error',
        title: 'Oops...',
        text: 'Isi form dengan lengkap'
      });
    }
  })["catch"](function (error) {
    Swal.fire({
      icon: 'error',
      info: 'error',
      title: 'Oops...',
      text: error.response.data.message
    });
  });
};

window.filterTask = function (input) {
  var project = $(input).attr('data-project');
  var date = $('#date').val();
  var dateStr = date.split("-");
  var start = dateStr[0].trim();
  var end = dateStr[1].trim();
  window.location.href = '/project/' + project + '?start=' + start + '&end=' + end + '&filter=harian';
};

window.handleCreateTask = function (input, evt) {
  evt.preventDefault();
  $('#modal-create-task').modal('show');
  $(".id_employe_task").select2({
    width: "100%",
    dropdownParent: "#modal-create-task"
  });
};
/******/ })()
;