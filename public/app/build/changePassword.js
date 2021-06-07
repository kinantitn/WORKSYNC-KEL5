/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************************!*\
  !*** ./public/app/src/changePassword.js ***!
  \******************************************/
window.handleChangePassword = function (input, evt) {
  evt.preventDefault();
  var old_password = $('#old_password').val();
  var new_password = $('#new_password').val();
  var confirm_password = $('#confirm_password').val();
  var data = {
    old_password: old_password,
    new_password: new_password,
    confirm_password: confirm_password
  };
  axios.post('/changePassword', data).then(function (res) {
    if (res.data.status) {
      alert(res.data.message, '/home');
    } else {
      Swal.fire({
        icon: 'error',
        info: 'error',
        title: 'Oops...',
        text: res.data ? res.data.message : 'Isi form dengan lengkap'
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