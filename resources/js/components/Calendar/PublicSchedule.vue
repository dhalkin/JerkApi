<template>
    <div>
        <modal
            v-bind:show="showRules"
            v-on:close="showRules = false"
            >
            <span class="h3" slot="header" v-text="trans('Studio Rules')"></span>
            <div class="row">
                <div class="col text-muted" v-html="companyRules.rules"></div>
            </div>
            <div class="row">
                <div class="col">
                    <p-button
                            type="primary" block
                            v-text="trans('All clear')"
                            class="mt-4"
                            @click="showRules = false"
                    >
                    </p-button>
                </div>
            </div>
        </modal>
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
            v-on:click-rules="showRules = true"
            v-on:user-logout="getEvents"
            v-bind:company-name="companyName"
            v-bind:user-logged="userLogged"
            v-bind:user-name="userName"
            >
        </calendar-header>

        <calendar ref="calendar"
            :lang=lang
            :events=events
            :branches=branches
            :userName=userName
            :companyUid=companyUid
            :company-timezone="companyTimezone"
            :lastCallHours="companyRules.last_call_hours"
            :refuseInHours="companyRules.refuse_in_hours"
            v-on:need-refresh="getEvents"
            @range-changed="rangeChanged"
        >
        </calendar>
        <div class="row">
            <div class="col text-right">&copy; SportStation.club</div>
        </div>
    </div>
</template>

<script>

    import Calendar from "./CalendarPublic"
    import CalendarHeader from "./CalendarHeader2"
    import Modal from "../UIComponents/Modal"
    import FormRegister from "./FormRegister";
    import FormLogin from "./FormLogin";
    import ErrorHelper from "../utils/ErrorHelper";

export default {
    props: ['companyUid', 'companyName', 'companyTimezone'],
    components: {FormLogin, FormRegister, Calendar, CalendarHeader, Modal},
    mixins:[ErrorHelper],
    data() {
        return {
            lang: this.$parent.lang,
            showRegister: false,
            showLogin: false,
            showRules: false,
            events: [],
            branches:[
                {value: 0, text: this.trans('All Branches')}
            ],
            userLogged: false,
            userName: '',
            apiToken: '',
            csrf: '',
            dataRange: {start: new Date(), stop: new Date()},
            companyRules:{
                last_call_hours:'',
                refuse_in_hours:'',
                rules:''
            }
        }
    },
    mounted() {
        this.getEnvironment();
    },
    watch: {
        apiToken: function (val, oldVal) {
            if (typeof val == "string" && val.length > 6) {
                this.userLogged = true
            } else {
                this.userLogged = false
            }
        },
        dataRange: function (val, oldVal) {
            //prevent first init
            if (oldVal.start.getTime() !== oldVal.stop.getTime()) {
                this.getEvents()
            }
        }
    },
    methods: {
        rangeChanged(range){
            this.dataRange = range
        },
        // do not use this time
        getSession() {
            axios.get('/session')
                .then(response => response.data)
                .then(data => {
                    // axios.defaults.headers.common['Authorization'] = 'Bearer ' + data.apiToken;
                    //axios.defaults.headers.common['X-CSRF-TOKEN'] = data.csrf;
                    this.apiToken = data.apiToken;
                    this.csrf = data.csrf;
                    this.userName = data.userName;
                    this.getEvents();
                });
        },
        getEnvironment() {
            axios.get('/company/' + this.companyUid + '/environment')
                .then(response => response.data)
                .then(data => {
                    this.companyRules = data.company
                    this.apiToken = data.apiToken
                    this.userName = data.userName

                    data.company.branches.forEach((item) => {
                        this.branches.push({value: item.id, text: item.name})
                    });
                    // hey, how about user preferences
                    if (localStorage.preferedBranch && localStorage.preferedBranch > 0) {
                        this.$refs.calendar.currentBranch = localStorage.preferedBranch
                    } else {
                        this.getEvents()
                    }
                })
                .catch(error => {
                    this.processErr(error);
                });
        },
        getEvents() {
            axios.get('/company/' + this.companyUid + '/events', this.prepareEventsData())
                .then(response => response.data)
                .then(data => {
                    // axios.defaults.headers.common['X-CSRF-TOKEN'] = data.csrf;
                    this.csrf = data.csrf;
                    this.events = data.events;
                })
                .catch(error => {
                    this.processErr(error);
                });
        },
        prepareEventsData() {
            return {
                params: {
                    start: this.dataRange.start,
                    stop: this.dataRange.stop,
                    currentBranch: this.$refs.calendar.currentBranch
                }
            }
        }
    }
}
</script>
