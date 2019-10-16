<template>
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-10">

                <div class="card bg-light mb-3">
                    <div class="card-header text-left h5">{{ trans('Company Settings') }}</div>

                    <div class="card-body">

                        <div class="d-sm-flex">

                            <div class="mr-5" style="min-width: 175px; min-height: 75px">
                                <span class="h1">
                                    <span>{{hours}}</span>
                                    <span class="blink_me">:</span>
                                    <span>{{minutes}}</span>
                                </span>
                                <br />
                                <span class="h5">{{fullDate}}</span>
                            </div>


                            <div class="w-100">
                                <label class="col-form-label" for="timezone">Timezone *</label>
                                <select class="form-control w-100" id="timezone" name="timezone" v-model="company.timezone" v-on:change="pickTimezone">
                                    <option v-for="item in timezones" v-bind:value="item.name">
                                        {{ item.zone }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <form method="POST" name="company" action="/company" @submit.prevent="onSubmit" @keydown="errors.clear($event.target.name)">
                            <div class="form-group">

                            <label class="col-form-label" for="company-name">Company name *</label>
                            <input class="form-control mb-2"
                                   id="name" name="name" type="text"
                                   v-model="company.name"
                                   v-bind:class="{ 'is-invalid': errors.has('name') }" required>
                            <div class="invalid-feedback" v-if="errors.has('name')" v-text="errors.get('name')"></div>

                            <label class="control-label" for="location">Location</label>
                            <input class="form-control mb-2"
                                   id="location" name="location" type="text"
                                   v-model="company.location"
                                   v-bind:class="{ 'is-invalid': errors.has('location') }"
                                   v-bind:placeholder="trans('Country, City, Street..')">
                            <div class="invalid-feedback" v-if="errors.has('location')" v-text="errors.get('location')"></div>

                            <label class="control-label" for="email">Email</label>
                            <input class="form-control mb-2"
                                   id="email" name="email" type="email"
                                   v-model="company.email"
                                   v-bind:class="{ 'is-invalid': errors.has('email') }"
                                   placeholder="company@domain.test">
                            </div>
                            <div class="invalid-feedback" v-if="errors.has('email')" v-text="errors.get('email')"></div>

                            <div class="row">
                                <div class="col-6">
                                </div>
                                <div class="col-6">
                                    <button type="submit"
                                            class="btn btn-primary w-100"
                                            v-text="trans('Submit')"
                                            v-bind:class="{ 'disabled': !this.isFormDirty }"
                                            :disabled="!this.isFormDirty">
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>

    import Errors from "./utils/Errors";
    import RequestHelper from "./utils/RequestHelper";

    export default {

        mixins: [Errors, RequestHelper],

        data() {
            return {
                company:{},
                timezones: [],
                hours: '00',
                minutes: '00',
                fullDate:'01-06-1976 TUE',
                week: ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'],
                uiTimezone: Intl.DateTimeFormat().resolvedOptions().timeZone, // set initial timezone,
                isDirty:false,
            }
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

                    if (typeof response.data.timezone === 'undefined') {
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

            // dirty check
            if(this.isFormDirty){
                console.log('dirty');
                // modal question
                this.$bvModal.show('okCancelModal');

                next(false);
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
            isFormDirty: function () {
                return localStorage.company !== JSON.stringify(this.company);
            }
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
                        localStorage.company = JSON.stringify(this.company);
                       // it might be needed
                       this.$recompute("isFormDirty");
                    })
                    .catch(error => {
                        this.processErr(error);
                    });
            },

            prepareSubmit(){
                return {
                    name: this.company.name,
                    location: this.company.location,
                    email: this.company.email,
                    timezone: this.company.timezone
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
