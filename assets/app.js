/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

import "bootstrap/dist/js/bootstrap.js";

//Font awesome
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

// start the Stimulus application
import './bootstrap';


let sidebarToggle = document.querySelector('.sidebarToggle');


sidebarToggle.addEventListener("click", function () {
    document.querySelector("body").classList.toggle("active")
    document.getElementById("sidebarToggle").classList.toggle("active")
});
