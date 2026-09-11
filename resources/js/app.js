import $ from 'jquery';
window.$ = window.jQuery = $;

import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

window.toastr = toastr;

toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: "toast-top-right",
    timeOut: 2000,
    extendedTimeOut: 1000,
};
