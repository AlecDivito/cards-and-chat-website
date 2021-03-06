import './bootstrap';
import router from './routes';
import Website from './website';


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

new Vue({
    el: '#app',

    router: router,

    render: h => h(Website)
});
