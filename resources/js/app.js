
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
import routes from './routes'
import VueLoading from 'vuejs-loading-plugin'
import VueFlashMessage from 'vue-flash-message/src';
import ModalPlugin  from 'bootstrap-vue';



Vue.use(VueRouter);
//Vue.use(VueLoading);
Vue.use(VueLoading, {
    //dark: true, // default false
    //text: 'Ladataan', // default 'Loading'
   // loading: true, // default false
    //customLoader: myVueComponent, // replaces the spinner and text with your own
    //background: 'rgb(255,255,255)', // set custom background
    //classes: ['myclass'] // array, object or string
});
Vue.use(VueFlashMessage);
Vue.use(ModalPlugin);
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
// Vue.component(
//     'passport-clients',
//     require('./components/passport/Clients.vue').default
// );
//
// Vue.component(
//     'passport-authorized-clients',
//     require('./components/passport/AuthorizedClients.vue').default
// );
//
// Vue.component(
//     'passport-personal-access-tokens',
//     require('./components/passport/PersonalAccessTokens.vue').default
// );

// translators
Vue.prototype.trans = (string, args) => {
    let value = _.get(window.i18n, string);
    if (typeof value !== 'undefined') return value;

    return string;
};

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
let app = new Vue({
    el: '#app',
    router: new VueRouter(routes),

    beforeCreate: function () {
        // before a request is made start the progress
        axios.interceptors.request.use(config => {
            this.$loading(true);
            return config
        }, error => {
            console.log(error);
        });

        // before a response is returned stop progress
        axios.interceptors.response.use(response => {
            // Any status code that lie within the range of 2xx cause this function to trigger
            // Do something with response data
            this.$loading(false);
            //console.log(response);
            //this.showFlashMessage(response);
            return response
        }, error => {
            // Any status codes that falls outside the range of 2xx cause this function to trigger
            this.showFlashMessage(error.response);
            this.$loading(false);
            return Promise.reject(error);
        });
    },

    methods: {
        showFlashMessage(response) {
            switch (response.status) {
                case 400:
                case 401:
                    // need to logout user and redirect
                case 402:
                case 403:
                case 404:
                case 500:
                    console.log(response);
                    this.flash(response.statusText, 'error', {
                        timeout: 3000
                    });
                    break;
                default:
                    console.log(response);
            }
        }
    }
});

