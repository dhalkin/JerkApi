<template>
    <div>
        <modal
            v-bind:show="showRegister"
            v-on:close="showRegister = false"
            >
            <span class="h3" slot="header" v-text="trans('Register')"></span>
            <form-register
                v-on:wannaCloseModal="showRegister = false"
                v-on:wannaOpenModal="showRegister = true"
                v-on:userRegistered="getEvents"
                :company-uid="companyUid"
            >
            </form-register>
        </modal>

        <modal
            v-bind:show="showLogin"
            v-on:close="showLogin = false"
            >
            <span class="h3" slot="header" v-text="trans('Login')"></span>
            <form-login
                v-on:wannaCloseModal="showLogin = false"
                v-on:wannaOpenModal="showLogin = true"
                v-on:userLoggedIn="getEvents"
                :company-uid="companyUid"
            >
            </form-login>
        </modal>

        <calendar-header
            v-on:click-register="showRegister = true"
            v-on:click-login="showLogin = true"
            v-on:user-logout="getEvents"
            v-bind:company-name="companyName"
            v-bind:user-logged="userLogged"
            v-bind:user-name="userName"
            >
        </calendar-header>

        <calendar
            :lang=lang
            :events=events
            :userName=userName
            :companyUid=companyUid
            :company-timezone="companyTimezone"
            v-on:need-refresh="getEvents"
            @range-changed="rangeChanged"
        >
        </calendar>
    </div>
</template>

<script>

    import Calendar from "./elements/CalendarPublic"
    import CalendarHeader from "./elements/CalendarHeader"
    import Modal from "./UIComponents/Modal"
    import FormRegister from "./elements/FormRegister";
    import FormLogin from "./elements/FormLogin";
    import ErrorHelper from "./utils/ErrorHelper";

export default {
    props: ['companyUid', 'companyName', 'companyTimezone'],
    components: {FormLogin, FormRegister, Calendar, CalendarHeader, Modal},
    mixins:[ErrorHelper],
    data() {
        return {
            lang: this.$parent.lang,
            showRegister: false,
            showLogin: false,
            events: [],
            userLogged: false,
            userName: '',
            apiToken: '',
            csrf: '',
            dataRange: {start: new Date(), stop: new Date()}
        }
    },
    mounted() {
        //this.getSession();
    },
    watch: {
        apiToken: function(val, oldVal) {
            if (typeof val == "string" && val.length > 6) {
                this.userLogged = true
            }else {
                this.userLogged = false
            }
        },
        dataRange: function (val, oldVal) {
           this.getEvents()
        }
    },
    methods: {
        rangeChanged(range){
            this.dataRange = range
        },
        getSession() {
            axios.get('/session')
                .then(response => response.data)
                .then(data => {
                    // axios.defaults.headers.common['Authorization'] = 'Bearer ' + data.apiToken;
                    axios.defaults.headers.common['X-CSRF-TOKEN'] = data.csrf;
                    this.apiToken = data.apiToken;
                    this.csrf = data.csrf;
                    this.userName = data.userName;
                    this.getEvents();
                });
        },
        clearSession() {
            this.apiToken = '';
            this.csrf = '';
            // delete axios.defaults.headers.common['Authorization'];
            // delete axios.defaults.headers.common['X-CSRF-TOKEN'];

        },
        getEvents() {
            axios.post('/company/' + this.companyUid + '/events', this.dataRange)
                .then(response => response.data)
                .then(data => {
                    axios.defaults.headers.common['X-CSRF-TOKEN'] = data.csrf;
                    this.apiToken = data.apiToken;
                    this.csrf = data.csrf;
                    this.userName = data.userName;
                    this.events = data.events;
                })
                .catch(error => {
                    this.processErr(error);
                });
        }
    }
}
</script>
