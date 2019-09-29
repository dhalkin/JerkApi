<template>
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-10">

                <div class="card bg-light mb-3">
                    <div class="card-header text-left h5">{{ trans('Company Settings') }}</div>

                    <div class="card-body">

                        <div class="d-sm-flex">

                            <div class="mr-5">
                                <span class="h1">
                                    <span>{{hours}}</span>
                                    <span class="blink_me">:</span>
                                    <span>{{minutes}}</span>
                                </span>
                                <br />
                                <span class="h4">{{fullDate}}</span>
                            </div>


                            <div class="">
                                <label class="col-form-label" for="timezone">Timezone *</label>
                                <select class="form-control" id="timezone" name="timezone" v-model="timezone" v-on:change="pickTimezone">
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

        export default {

        props: ['apiToken'],

        data() {
            return {
                timezones: [],
                name: '',
                location: '',
                email: '',
                timezone: '',
                errors: new Errors(),
                hours:'',
                minutes:'',
                fullDate:'',
                week: ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'],
                uiTimezone: Intl.DateTimeFormat().resolvedOptions().timeZone // set initial timezone
            }
        },

        mounted() {
            let timerID = setInterval(this.updateTime, 10000);
        },

        created() {
            // need some solution
            // if (this.errors.hasOwnProperty(field))

            axios.defaults.headers.common['Authorization'] = 'Bearer '+ this.apiToken;
            // get timezones
            axios.get('/api/timezones')
                .then(response => response.data)
                .then(data => {
                    this.timezones = data;
                });
            // get company
            axios.get('/api/company')
                .then(response => response.data)
                .then(data => {
                    this.name = data.name;
                    this.location = data.location;
                    this.email = data.email;
                    this.timezone = data.timezone;

                    if(!data.timezone) {
                        this.timezone = this.uiTimezone;
                    }

                    this.updateTime();
                });
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

    // that's something...
        class Errors {

            constructor() {
                this.errors = {};
            }

            get(field) {
                if (this.errors[field]) {
                    return this.errors[field][0];
                }
            }

            has(field){
                return this.errors.hasOwnProperty(field);
            }

            any(){
                return Object.keys(this.errors).length > 0;
            }

            record(errors) {
                this.errors = errors;
            }

            clear(field) {
                delete this.errors[field]
            }

            clearAll(){
                this.errors = {};
            }
        }

</script>
