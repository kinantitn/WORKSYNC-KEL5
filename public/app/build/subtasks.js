/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************!*\
  !*** ./public/app/src/subtasks.js ***!
  \************************************/
window.handleDeleteSubtask = function (input, evt) {
  evt.preventDefault();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  var idProject = $(input).attr('data-project');
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
  }).then(function (result) {
    if (result.value) {
      axios["delete"]('/subtask/' + $(input).attr('data')).then(function (response) {
        alert(response.data.message, '/project/' + idProject);
      })["catch"](function (error) {
        Swal.fire('Gagal', error.response.data.message, 'error');
      });
    }
  });
};

window.handleUpdateSubtask = function (input, evt) {
  evt.preventDefault();
  var id_employe = $('#id_employe_edit').val();
  var id_project = $('#id_project_edit').val();
  var id_task = $('#id_task_edit').val();
  var id_activity = $('#id_activity_edit').val();
  var label_activity = $('#label_activity_edit').val();
  var description_activity = $('#description_activity_edit').val();
  var start_date_plan_activity = $('#start_date_plan_activity_edit').val();
  var end_date_plan_activity = $('#end_date_plan_activity_edit').val();
  var start_date_actual_activity = $('#start_date_actual_activity_edit').val();
  var end_date_actual_activity = $('#end_date_actual_activity_edit').val();
  var progress_activity = $('#progress_activity_edit').val();
  var status_activity = $('#status_activity_edit').val();
  var data = {
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
  };
  axios.put('/subtask/' + id_activity, data).then(function (res) {
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

window.handleCreateSubtask = function (input, evt) {
  evt.preventDefault();
  var id = $(input).attr('data');
  axios.get('/subtask?task=' + id).then(function (res) {
    var SubtaskDetail = $('#modal-create-subtask');
    var divProject = $('#appendDetailCreateSubtask');
    SubtaskDetail.modal('show');
    divProject.empty().append();
    divProject.append(res.data.data.content);
    $(".id_employe_subtask").select2({
      width: "100%",
      dropdownParent: "#modal-create-subtask"
    });
  });
};

window.handleEditSubtask = function (input, evt) {
  evt.preventDefault();
  var id = $(input).attr('data');
  axios.get('/subtask/' + id + '/edit').then(function (res) {
    var SubtaskDetail = $('#modal-edit-subtask');
    var divProject = $('#appendDetailEditSubtask');
    SubtaskDetail.modal('show');
    divProject.empty().append();
    divProject.append(res.data.data.content);
    $("#id_employe_edit").select2({
      width: "100%",
      dropdownParent: "#modal-edit-subtask"
    });
    var ori = $('#employee_edit').val();
    var cat = JSON.parse("[" + ori + "]");
    $('#id_employe_edit').val(cat).trigger('change');
  });
};

window.handleSubmitSubtask = function (input, evt) {
  evt.preventDefault();
  var id_project = $('#id_project').val();
  var id_employe = $('#id_employe_subtask').val();
  var id_task = $('#id_task').val();
  var label_activity = $('#label_activity').val();
  var description_activity = $('#description_activity').val();
  var start_date_plan_activity = $('#start_date_plan_activity').val();
  var end_date_plan_activity = $('#end_date_plan_activity').val();
  var start_date_actual_activity = $('#start_date_actual_activity').val();
  var end_date_actual_activity = $('#end_date_actual_activity').val();
  var progress_activity = $('#progress_activity').val();
  var data = {
    id_task: id_task,
    id_employe: id_employe,
    label_activity: label_activity,
    description_activity: description_activity,
    start_date_plan_activity: start_date_plan_activity,
    end_date_plan_activity: end_date_plan_activity,
    start_date_actual_activity: start_date_actual_activity,
    end_date_actual_activity: end_date_actual_activity,
    progress_activity: progress_activity
  };
  axios.post('/subtask', data).then(function (res) {
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
/******/ })()
;