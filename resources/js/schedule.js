/*
Public calendar
Schedule board for certain company
 */
window._ = require('lodash');
//window.$ = window.jQuery = require('jquery');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Vue from 'vue';
import GlobalComponents from './globalComponents';
import VueNotify from 'vue-notifyjs';
import VeeValidate, {Validator} from 'vee-validate';
import ru from 'vee-validate/dist/locale/ru';
import PublicSchedule  from './components/Calendar/PublicSchedule';
import VueLoading from 'vuejs-loading-plugin';
import VueSweetalert2 from 'vue-sweetalert2';


// langs for validator
let lang =  document.querySelector('html').lang;
if (lang !== 'en') {
    Validator.localize('ru', ru);
}

Vue.use(VeeValidate, {
    locale: lang
});

Vue.use(GlobalComponents);
Vue.use(VueNotify);
Vue.use(VueLoading);
Vue.use(VueSweetalert2);

// translators
Vue.prototype.trans = (string, args) => {
    let value = _.get(window.i18n, string);
    if (typeof value !== 'undefined') return value;

    return string;
};

Vue.prototype.capitalize = function(string) {
    return string.charAt(0).toUpperCase() + string.slice(1)
};

let app = new Vue({
    el: '#app',
    components:{PublicSchedule, VueLoading},
    beforeCreate(){
        // before a request is made start the progress
        axios.interceptors.request.use(config => {
            this.$loading(true);
            return config
        }, error => {
            console.log(error);
        });

        // before a response is returned stop progress
        axios.interceptors.response.use(response => {
            this.$loading(false);
            return response
        }, error => {
            // Any status codes that falls outside the range of 2xx cause this function to trigger
            this.showFlashMessage(error.response);
            this.$loading(false);
            return Promise.reject(error);
        });

    },
    data(){
        return {
            lang: lang
        }
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
                    this.$notify({
                        message: response.statusText,
                        type: 'danger'
                    });
                    break;
                default:
                    console.log(response);
            }
        }
    }
});
