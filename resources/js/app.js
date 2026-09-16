import "./bootstrap";

import "../css/app.css";

import * as bootstrap from "bootstrap";

import toastr from "toastr";

import "toastr/build/toastr.min.css";

window.toastr = toastr;
window.bootstrap = bootstrap;

toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: "toast-top-right",
    preventDuplicates: true,
    newestOnTop: true,
    timeOut: 4000,
    extendedTimeOut: 1000,
    showDuration: 300,
    hideDuration: 300,
};
//import './bootstrap';

//import Alpine from 'alpinejs';

//window.Alpine = Alpine;

//Alpine.start();
