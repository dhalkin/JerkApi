<template>
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-10">

                <div class="card bg-light mb-3">
                    <div class="card-header text-left h5">{{ trans('Company Settings') }}</div>

                    <div class="card-body">

                        <div class="row justify-content-between ml-1 mr-1">
                            <div class="col-5 shadow-sm p-3">
                                <div class="media">
                                    <img src="/pictures/100x100.jpg" class="align-self-start rounded-circle mr-4">
                                    <div class="media-body">
                                        <h5 class="mt-0">Logo</h5>
                                        <p>Put a logo for your organization, it will be easier for your customers. <br/>
                                            You can select .jpg, .png file.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 shadow-sm p-3">
                                <div class="media">
                                    <h1 class="align-self-start mr-4">12:13</h1>
                                    <div class="media-body">
                                        <h5 class="mt-0">Your current time</h5>
                                        <p>Select the time zone where is your business located, this is necessary for the scheduler to work correctly.</p>
                                        <select class="form-control" id="timezone" name="timezone" v-model="timezone">
                                            <option v-for="item in timezones" v-bind:value="item.id">
                                                {{ item.zone }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="/company" @submit.prevent="onSubmit">
                        <div class="form-group">
                            <fieldset>
                                <label class="col-form-label" for="company-name" v-bind:class="isMobileViewFormLabel">Company name *</label>
                                <input class="form-control mb-2" v-bind:class="isMobileViewFormControl" id="name" name="name" type="text" v-model="name" required>
<!--                                <span class="is-invalid" v-text="errors.get('name')"></span>-->

                                <label class="control-label" for="location" v-bind:class="isMobileViewFormLabel">Location</label>
                                <input class="form-control mb-2" v-bind:class="isMobileViewFormControl" id="location" type="text" v-model="location">

                                <label class="control-label" for="email" v-bind:class="isMobileViewFormLabel">Email</label>
                                <input class="form-control mb-2" v-bind:class="isMobileViewFormControl" id="email" type="email" v-model="email">

                            </fieldset>
                            <button type="submit" class="btn btn-primary">Submit</button>
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

        props: ['someData'],

        data() {
            return {
                timezones: [],
                name: '',
                location: '',
                email: '',
                timezone: '',
                errors: ''
            }
        },

        mounted() {
            console.log('Company mounted.');
        },

        created() {
            // need some solution
            axios.defaults.headers.common['Authorization'] = 'Bearer '+ this.someData;
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
                    this.timezone = data.timezone
                });
        },

        methods:{

            onSubmit(){
                axios.post('/api/company', this.$data)
                    .then(response => alert('Success'))
                    .catch(error => {
                        console.log(error.response)
                    })
            }
        }
    }
</script>
