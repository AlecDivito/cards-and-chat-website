/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

import Vue from 'vue';
import VueRouter from 'vue-router';
import Echo from 'laravel-echo';
import Axios from 'axios';
import Form from './util/Form';

window.Vue = Vue;
Vue.use(VueRouter);

// Global laravel-echo
window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: 'http://cardgames.local:6001',
    auth: {
        headers: {
            Authorization: 'Bearer ' + window.Laravel.csrfToken
        }
    }
});


/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = Axios;
window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest',
};

window.Form = Form;