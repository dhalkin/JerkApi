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
                                <span class="h4">{{fullDate}}</span>
                            </div>


                            <div class="w-100">
                                <label class="col-form-label" for="timezone">Timezone *</label>
                                <select class="form-control w-100" id="timezone" name="timezone" v-model="timezone" v-on:change="pickTimezone">
                                    <option v-for="item in timezones" v-bind:value="item.name">
                                        {{ item.zone }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <form method="POST" action="/company" @submit.prevent="onSubmit" @keydown="errors.clear($event.target.name)">
                            <div class="form-group">

                            <label class="col-form-label" for="company-name">Company name *</label>
                            <input class="form-control mb-2"
                                   id="name" name="name" type="text"
                                   v-model="name"
                                   v-bind:class="{ 'is-invalid': errors.has('name') }" required>
                            <div class="invalid-feedback" v-if="errors.has('name')" v-text="errors.get('name')"></div>

                            <label class="control-label" for="location">Location</label>
                            <input class="form-control mb-2"
                                   id="location" name="location" type="text"
                                   v-model="location"
                                   v-bind:class="{ 'is-invalid': errors.has('location') }"
                                   v-bind:placeholder="trans('Country, City, Street..')">
                            <div class="invalid-feedback" v-if="errors.has('location')" v-text="errors.get('location')"></div>

                            <label class="control-label" for="email">Email</label>
                            <input class="form-control mb-2"
                                   id="email" name="email" type="email"
                                   v-model="email"
                                   v-bind:class="{ 'is-invalid': errors.has('email') }"
                                   placeholder="company@domain.test">
                            </div>
                            <div class="invalid-feedback" v-if="errors.has('email')" v-text="errors.get('email')"></div>

                            <div class="row">
                                <div class="col-6">
                                </div>
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary w-100">{{ trans('Submit') }}</button>
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

    import Errors from "./utils/Errors.vue";
    export default {

        props: ['apiToken'],
        mixins: [Errors],

        data() {
            return {
                timezones: [],
                name: '',
                location: '',
                email: '',
                timezone: '',
                hours: '00',
                minutes: '00',
                fullDate:'01-06-1976 TUE',
                week: ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'],
                uiTimezone: Intl.DateTimeFormat().resolvedOptions().timeZone // set initial timezone
            }
        },

        mounted() {
            let timerID = setInterval(this.updateTime, 10000);

            axios.defaults.headers.common['Authorization'] = 'Bearer '+ this.apiToken;
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
                    this.name = response.data.name;
                    this.location = response.data.location;
                    this.email = response.data.email;
                    this.timezone = response.data.timezone;

                    if (!response.data.timezone) {
                        this.timezone = this.uiTimezone;
                    }

                    this.updateTime();
                });

            // axios.all([
            //     axios.get('/api/timezones'),
            //     axios.get('/api/company')
            // ]).then(responseArr => {
            //
            //     this.timezones = responseArr[0].data;
            //     this.name = responseArr[1].data.name;
            //     this.location = responseArr[1].data.location;
            //     this.email = responseArr[1].data.email;
            //     this.timezone = responseArr[1].data.timezone;
            //
            //     if (!responseArr[1].data.timezone) {
            //         this.timezone = this.uiTimezone;
            //     }
            //
            //     this.updateTime();

            //});

        },
        watch: {
            timezones(newTimezones) {
                // const parsed = JSON.stringify(newTimezones);
                // localStorage.setItem('timezones', parsed);
                localStorage.timezones = JSON.stringify(newTimezones);
            }
        },

        created() {

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
                        if (error.response) {
                            // The request was made and the server responded with a status code
                            // that falls out of the range of 2xx

                            // show flash with
                            this.flash(error.response.data.message, 'warning', {
                                timeout: 3000
                            });

                            this.errors.record(error.response.data.errors);

                            // console.log(error.response.data);
                            // console.log(error.response.status);
                            // console.log(error.response.headers);
                        } else if (error.request) {
                            // The request was made but no response was received
                            // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                            // http.ClientRequest in node.js
                            console.log(error.request);
                        } else {
                            // Something happened in setting up the request that triggered an Error
                            console.log('Error', error.message);
                        }
                        console.log(error.config);
                    });
            },

            prepareSubmit(){
                return {
                    name: this.name,
                    location: this.location,
                    email: this.email,
                    timezone: this.timezone
                }
            },

            pickTimezone(){
                this.updateTime();
            },

            updateTime(){
                let cd = new Date().toLocaleString("en-US", {timeZone: this.timezone});
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
