/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
const $ = require('jquery');
global.$ = global.jQuery = $;
import 'bootstrap';
// start the Stimulus application
import flasher from "@flasher/flasher";
window.flasher = flasher;

import {Property} from "./js/property";
import {Bill} from "./js/bill";
import {Notification} from "./js/notification";

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
    const property = new Property();
    const bill = new Bill();
    const notification = new Notification();
});
