/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************!*\
  !*** ./public/app/src/projects.js ***!
  \************************************/
var ctx3 = document.getElementById('myChart3');
$(document).ready(function () {
  axios.get('getProgressDashboard').then(function (res) {
    var foo = res.data;
    console.log(foo.progress);
    myChart3 = new Chart(ctx3, {
      type: 'line',
      animationEnabled: true,
      data: {
        labels: foo.project,
        datasets: [{
          label: 'Proyek Progress',
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

window.handleCreateProject = function (input, evt) {
  evt.preventDefault();
  $('#modal-create-project').modal('show');
  $(".id_employe_project").select2({
    width: "100%",
    dropdownParent: "#modal-create-project"
  });
};

window.handleDeleteProject = function (input, evt) {
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
  }).then(function (result) {
    if (result.value) {
      axios["delete"]('/project/' + $(input).attr('data')).then(function (response) {
        alert(response.data.message, '/project');
      })["catch"](function (error) {
        Swal.fire('Gagal', error.response.data.message, 'error');
      });
    }
  });
};

window.handleUpdateProjetcs = function (input, evt) {
  evt.preventDefault();
  var id = $('#id').val();
  var name = $('#name').val();
  var start_date_plan = $('#start_date_plan').val();
  var end_date_plan = $('#end_date_plan').val();
  var start_date_actual = $('#start_date_actual').val();
  var end_date_actual = $('#end_date_actual').val();
  var status = $('#status').val();
  var id_employe = $('#id_employe').val();
  var data = {
    name: name,
    id_employe: id_employe,
    start_date_plan: start_date_plan,
    end_date_plan: end_date_plan,
    start_date_actual: start_date_actual,
    end_date_actual: end_date_actual,
    status: status,
    id: id
  };
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

window.handleUpdateProject = function (input, evt) {
  evt.preventDefault();
  var id = $('#id_edit').val();
  var name = $('#name_edit').val();
  var id_employe = $('#id_employe_edit').val();
  var start_date_plan = $('#start_date_plan_edit').val();
  var end_date_plan = $('#end_date_plan_edit').val();
  var start_date_actual = $('#start_date_actual_edit').val();
  var end_date_actual = $('#end_date_actual_edit').val();
  var status = $('#status_edit').val();
  var data = {
    name: name,
    id_employe: id_employe,
    start_date_plan: start_date_plan,
    end_date_plan: end_date_plan,
    start_date_actual: start_date_actual,
    end_date_actual: end_date_actual,
    status: status,
    id: id
  };
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

window.handleEditProject = function (input, evt) {
  evt.preventDefault();
  var id = $(input).attr('data');
  axios.get('/project/' + id + '/edit').then(function (res) {
    var ProjectDetail = $('#modal-edit-project');
    var divProject = $('#appendProjectDetail');
    ProjectDetail.modal('show');
    divProject.empty().append();
    divProject.append(res.data.data.content);
    $("#id_employe_edit").select2({
      width: "100%",
      dropdownParent: "#modal-edit-project"
    });
    var ori = $('#employee_edit').val();
    var cat = JSON.parse("[" + ori + "]");
    $('#id_employe_edit').val(cat).trigger('change');
  });
};

window.handleSubmitProjects = function (input, evt) {
  evt.preventDefault();
  var name = $('#name').val();
  var id_employe = $('#id_employe').val();
  var start_date_plan = $('#start_date_plan').val();
  var end_date_plan = $('#end_date_plan').val();
  var start_date_actual = $('#start_date_actual').val();
  var end_date_actual = $('#end_date_actual').val();
  var status = $('#status').val();
  var data = {
    name: name,
    id_employe: id_employe,
    start_date_plan: start_date_plan,
    end_date_plan: end_date_plan,
    start_date_actual: start_date_actual,
    end_date_actual: end_date_actual,
    status: status
  };
  axios.post('/project', data).then(function (res) {
    if (res.data.status) {
      alert(res.data.message, '/project');
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