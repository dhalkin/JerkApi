/*
Personal tool for company owners
Manage your company
 */
window._ = require('lodash');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found');
}
let userName = document.head.querySelector('meta[name="user-name"]');
let companyName = document.head.querySelector('meta[name="company-name"]');
let companyUid = document.head.querySelector('meta[name="company-uid"]');
let apiToken = document.head.querySelector('meta[name="secret"]');
if (apiToken) {
    window.axios.defaults.headers.common['Authorization'] = 'Bearer '+ atob(apiToken.content);
} else {
    console.error('ApiToken token not found');
}

import Vue from 'vue'
import './pollyfills'
import VueRouter from 'vue-router'
import VueRouterPrefetch from 'vue-router-prefetch'
import VueNotify from 'vue-notifyjs'
import VeeValidate, {Validator} from 'vee-validate'
import ru from "vee-validate/dist/locale/ru";
// import lang from 'element-ui/lib/locale/lang/en'
 //import locale from 'element-ui/lib/locale'
import VueLoading from 'vuejs-loading-plugin'
import App from './App.vue'

// langs for validator
let lang =  document.querySelector('html').lang;
if (lang !== 'en') {
    Validator.localize('ru', ru);
}
Vue.use(VeeValidate, {
    locale: lang
});
// translators
Vue.prototype.trans = (string, args) => {
    let value = _.get(window.i18n, string);
    if (typeof value !== 'undefined') return value;

    return string;
};

// Plugins
import GlobalComponents from './globalComponents'
import GlobalDirectives from './globalDirectives'
import SideBar from './components/UIComponents/SidebarPlugin'
import initProgress from './progressbar';

// router setup
import routes from './routes/routes'

// Style imports
import '../assets/sass/paper-dashboard.scss'
import '../assets/sass/demo.scss'

import sidebarLinks from './sidebarLinks'
//import './registerServiceWorker'
// plugin setup
Vue.use(VueRouter)
Vue.use(VueRouterPrefetch)
Vue.use(GlobalDirectives)
Vue.use(GlobalComponents)
Vue.use(VueNotify, {'timeout':3000})
Vue.use(SideBar, {sidebarLinks: sidebarLinks})
Vue.use(VueLoading, {
    //dark: true, // default false
    //text: 'Ladataan', // default 'Loading'
    // loading: true, // default false
    //customLoader: myVueComponent, // replaces the spinner and text with your own
    //background: 'rgb(255,255,255)', // set custom background
    //classes: ['myclass'] // array, object or string
})


//locale.use(lang)

// configure router
const router = new VueRouter({
    routes, // short for routes: routes
    linkActiveClass: 'active',
    scrollBehavior: (to) => {
        if (to.hash) {
            return {selector: to.hash}
        } else {
            return { x: 0, y: 0 }
        }
    }
})

initProgress(router);

/* eslint-disable no-new */
new Vue({
    el: '#app',
    render: h => h(App),
    router,
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
            //this.showFlashMessage(error.response);
            this.$loading(false);
            return Promise.reject(error);
        })
    },
    data(){
        return {
            csrf: token.content,
            lang: lang,
            userName: userName.content,
            companyName: companyName.content,
            companyUid: companyUid.content,
            apiToken: atob(apiToken.content)
        }
    }
})
