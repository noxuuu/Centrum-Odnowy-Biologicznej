/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

import('../css/app.scss');
import('../css/perfect-scrollbar.css');
import('../css/albums-app.css'); // albums app
import('../css/bootstrap-float-label.min.css'); // form inside input labels
import('../css/font/iconsmind/style.css'); // form inside input labels
import('../css/font/simple-line-icons/css/simple-line-icons.css'); // form inside input labels

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');
require('bootstrap');
require('moment');

// use jQuery in templates
global.$ = global.jQuery = $;
window.$ = $;
window.jQuery = $;

// ajax scripts
let app = require("./ajax");

// handle notification click
$(".notification-active").click(function (evt) {
    // pass id to read notification function
    app.readNotification(parseInt($(this).data('notification-id')))
});