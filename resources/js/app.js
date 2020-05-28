/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import 'jquery-ui/ui/widgets/draggable';
import 'jquery-ui/ui/widgets/droppable';
import 'jquery-ui/ui/widgets/sortable';
import 'jquery-ui/ui/effect';
import flatpickr from "flatpickr";
import {Calendar} from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import {Timer} from 'easytimer.js';

require('select2');
import 'select2/dist/css/select2.css';

window.Pusher = require('pusher-js');
import Echo from "laravel-echo";

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: false
});
window.snake = require('to-snake-case');
window.intlTelInput = require('intl-tel-input');
window.flatpickr = flatpickr;
window.Calendar = Calendar;
window.dayGridPlugin = dayGridPlugin;
window.Timer = Timer;
window.humanizeDuration = require('humanize-duration');
window.Croppie = require('croppie');

import 'rm-emoji-picker/dist/emojipicker.css';
import EmojiPicker from "rm-emoji-picker";
window.picker = new EmojiPicker({
    sheets: {
        apple   : '/images/emoji_sheets/sheet_apple_64_indexed_128.png',
        google  : '/images/emoji_sheets/sheet_google_64_indexed_128.png',
        twitter : '/images/emoji_sheets/sheet_twitter_64_indexed_128.png',
        emojione: '/images/emoji_sheets/sheet_emojione_64_indexed_128.png'
    },
    show_icon_tooltips : false,
    positioning: "vertical",
    categories: [
        {
            title: "People",
            icon : '<i class="fas fa-smile" aria-hidden="true"></i>'
        },
        {
            title: "Nature",
            icon : '<i class="fas fa-leaf" aria-hidden="true"></i>'
        },
        {
            title: "Foods",
            icon : '<i class="fas fa-utensils" aria-hidden="true"></i>'
        },
        {
            title: "Activity",
            icon : '<i class="fas fa-futbol" aria-hidden="true"></i>'
        },
        {
            title: "Places",
            icon : '<i class="fas fa-globe" aria-hidden="true"></i>'
        },
        {
            title: "Symbols",
            icon : '<i class="fas fa-lightbulb" aria-hidden="true"></i>'
        },
        {
            title: "Flags",
            icon : '<i class="fa fa-flag-checkered" aria-hidden="true"></i>'
        }
    ],
});


window.Laravel = {};
// Enable pusher logging - don't include this in production
// Pusher.logToConsole = true;


// window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app',
// });
