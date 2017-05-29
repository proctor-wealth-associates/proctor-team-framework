/*
|--------------------------------------------------------------------------
| Javascript Vendors
|--------------------------------------------------------------------------
*/

/* Lodash */
window._ = require('lodash');

/* JQuery */
window.$ = window.jQuery = require('jquery');

/* Semantic UI */
require('./semantic');
require('./semantic-init');

/* Axios */
window.axios = require('axios');
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/* VueJS */
window.Vue = require('vue');

/* Echo */
// import Echo from 'laravel-echo'
// window.Pusher = require('pusher-js');
// window.Echo = new Echo({ broadcaster: 'pusher', key: 'your-pusher-key' });
