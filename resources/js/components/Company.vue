<template>
    <div class="main-panel">
    <!-- Top Navbar -->
        <top-nav-bar v-bind:csrf="this.csrf" v-bind:title="trans('My Company')"></top-nav-bar>
    <!-- End Navbar -->

    <div class="content">
        <div class="row">
            <div class="col-md-10">

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" v-text="trans('Company Settings')"></h4>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-sm-flex">

                                    <div class="mr-5" style="min-width: 175px; min-height: 75px">
                                        <span class="h1">
                                            <span>{{hours}}</span>
                                            <span class="blink_me">:</span>
                                            <span>{{minutes}}</span>
                                        </span>
                                        <br/>
                                        <span class="h5">{{fullDate}}</span>
                                    </div>

                                    <div class="w-100">
                                        <label class="col-form-label" for="timezone">Timezone *</label>
                                        <select class="form-control w-100" id="timezone" name="timezone"
                                                v-model="company.timezone" v-on:change="pickTimezone">
                                            <option v-for="item in timezones" v-bind:value="item.name">
                                                {{ item.zone }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form method="POST" name="company" action="/company" @submit.prevent="onSubmit" @keydown="errors.clear($event.target.name)">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">

                                        <input-text
                                            v-bind:label="trans('Company name') + ' *'"
                                            v-model.trim="company.name"
                                            v-bind:errors="errors"
                                            name="name"
                                            required="required">
                                        </input-text>

                                        <input-text
                                            v-bind:label="trans('Address')"
                                            v-model.trim="company.address"
                                            v-bind:errors="errors"
                                            name="address">
                                        </input-text>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-5">
                                    <input-text
                                        v-bind:label="trans('City')"
                                        v-model.trim="company.city"
                                        v-bind:errors="errors"
                                        v-bind:name="'city'">
                                    </input-text>
                                </div>
                                <div class="col-md-5">
                                    <input-text
                                        v-bind:label="trans('Country')"
                                        v-model.trim="company.country"
                                        v-bind:errors="errors"
                                        v-bind:name="'country'">
                                    </input-text>
                                </div>
                                <div class="col-md-2">
                                    <input-text
                                        v-bind:label="trans('Postal code')"
                                        v-model.trim="company.zip"
                                        v-bind:errors="errors"
                                        v-bind:name="'zip'">
                                    </input-text>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                <label v-text="trans('About')"></label>
                                <div class="form-group">
                                    <textarea
                                        class="form-control"
                                        v-bind:placeholder="trans('About Company')"
                                        v-model.trim="company.about">
                                    </textarea>
                                </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                </div>
                                <div class="col-6">
                                    <button type="submit"
                                            class="btn btn-primary w-100"
                                            v-text="trans('Save')">
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <footer-bar></footer-bar>
    </div>
</template>

<script>

    import Errors from "./utils/Errors";
    import RequestHelper from "./utils/RequestHelper";
    import TopNavBar from "./layout/TopNavBar";
    import FooterBar from "./layout/FooterBar";
    import InputText from "./elements/InputText";

    export default {
        components: {TopNavBar, FooterBar, InputText},
        mixins: [Errors, RequestHelper, TopNavBar],

        data() {
            return {
                company:{name:'', address:'', city:'', country:'', zip:'', about:''},
                timezones: [],
                hours: '00',
                minutes: '00',
                fullDate:'01-06-1976 TUE',
                week: ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'],
                uiTimezone: Intl.DateTimeFormat().resolvedOptions().timeZone, // set initial timezone,
                isDirty:false,
            }
        },

        created() {

        },

        mounted() {
            let timerID = setInterval(this.updateTime, 10000);

            // check local storage
            if (localStorage.timezones) {
                this.timezones = JSON.parse(localStorage.timezones);
            } else {
                axios.get('/api/timezones')
                    .then(response => {
                       this.timezones = response.data;
                    });
            }


            axios.get('/api/company')
                .then(response => {
                    this.company = response.data;

                    if (
                        typeof response.data.timezone === 'undefined' ||
                        !response.data.timezone
                    ) {
                        this.company.timezone = this.uiTimezone;
                    }
                    // put to local storage, in purpose to check dirty status
                    localStorage.company = JSON.stringify(this.company);
                    this.updateTime();

                });


            // axios.all([
            //     axios.get('/api/timezones'),
            //     axios.get('/api/company')
            // ]).then(responseArr => {
            //
            //     this.timezones = responseArr[0].data;
            //     this.name = responseArr[1].data.name;
            //});

        },

        // hack to axios route
        beforeRouteLeave (to, from, next) {
            // dirty check  !! disputable
            if(this.isFormDirty){
                this.$bvModal.msgBoxConfirm('You have unsaved data. Want to leave the page and lose data?', {
                    title: this.trans('Please Confirm'),
                    size: 'sm',
                    okVariant: 'danger',
                    okTitle: 'YES, Leave',
                    cancelTitle: 'NO, Stay on this page',
                    footerClass: 'p-2',
                    hideHeaderClose: false,
                    centered: true,
                    noCloseOnBackdrop: true,
                    hideBackdrop: true,
                    contentClass: 'shadow',
                    headerBgVariant: 'dark',
                    headerTextVariant: 'light'
                }).then(value => {
                    if (value === true){
                        next();
                    }else{
                        next(false)
                    }
                }).catch(err => {
                    next(false);
                });

            }else{
                next();
            }
        },

        watch: {
            timezones(newTimezones) {
                localStorage.timezones = JSON.stringify(newTimezones);
            }
        },

        computed: {

        },

        methods:{
            // save the company
            onSubmit(){
                this.errors.clearAll();
                axios.post('/api/company', this.prepareSubmit())
                    .then(response => {
                        this.flash(this.trans('Saved'), 'success', {
                            timeout: 3000
                        });
                    })
                    .catch(error => {
                        this.processErr(error);
                    });
            },

            prepareSubmit(){
                return {
                    name: this.company.name,
                    address: this.company.address,
                    city: this.company.city,
                    timezone: this.company.timezone,
                    country: this.company.country,
                    zip: this.company.zip,
                    about: this.company.about
                }
            },

            pickTimezone(){
                this.updateTime();
            },

            updateTime(){
                let cd = new Date().toLocaleString("en-US", {timeZone: this.company.timezone});
                cd = new Date(cd);
                this.hours = this.zeroPadding(cd.getHours(), 2);
                this.minutes = this.zeroPadding(cd.getMinutes(), 2);
                this.fullDate = this.zeroPadding(cd.getDate(), 2) + '-' +
                    this.zeroPadding(cd.getMonth(), 2) + '-' + cd.getFullYear() + ' ' +
                    this.week[cd.getDay()];
            },

            zeroPadding(num, digit) {
                var zero = '';
                for(var i = 0; i < digit; i++) {
                    zero += '0';
                }
                return (zero + num).slice(-digit);
            }
        }
    }

</script>
