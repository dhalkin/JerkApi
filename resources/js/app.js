
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
import routes from './routes'

//window.Vue = require('vue');

Vue.use(VueRouter);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

// translators
Vue.prototype.trans = (string, args) => {
    let value = _.get(window.i18n, string);
    if (typeof value !== 'undefined') return value;

    return string;
};

// Seems like we get some Error class, but it doesn't work yet
class Errors {

    constructor() {
        this.errors = {};
    }

    get(field) {
        if (this.errors[field]) {
            return this.errors[field][0];
        }
    }
}

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
let app = new Vue({
    el: '#app',

    router: new VueRouter(routes),

    computed: {
        isMobileViewImg: function () {
            return {
                straight100: window.app.clientWidth < 400,
            }
        },
        isMobileViewFormControl: function () {
            return {
                'form-control-sm': window.app.clientWidth < 400,
            }
        },
        isMobileViewFormLabel: function () {
            return {
                'col-form-label-sm': window.app.clientWidth < 400,
            }
        }
    }
});

