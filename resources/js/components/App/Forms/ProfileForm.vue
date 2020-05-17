<template>
    <div class="card">
        <div class="card-header">
            <h4 class="title">{{trans('Edit Profile')}}</h4>
        </div>
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-md-6">
                        <fg-input type="text"
                            name="first_name"
                            v-bind:label="trans('First Name')"
                            v-bind:placeholder="trans('First Name')"
                            v-model="user.first_name"
                            v-validate="userValidations.first_name"
                            :error="getError('first_name')"
                            >
                        </fg-input>
                    </div>
                    <div class="col-md-6">
                        <fg-input type="text"
                                  name="last_name"
                                  v-bind:label="trans('Second Name')"
                                  v-bind:placeholder="trans('Second Name')"
                                  v-model="user.second_name"
                                  v-validate="userValidations.second_name"
                                  :error="getError('second_name')"
                        >
                        </fg-input>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <fg-input type="text"
                                  name="phone"
                                  v-bind:label="trans('Phone')"
                                  v-bind:placeholder="trans('Phone')"
                                  v-model="user.phone"
                                  v-validate="userValidations.phone"
                                  :error="getError('phone')"
                        >
                        </fg-input>
                    </div>
                    <div class="col-md-6">
                        <fg-input type="email"
                                  name="email"
                                  label="Email"
                                  placeholder="Email"
                                  v-model="user.email"
                                  v-validate="userValidations.email"
                                  :error="getError('email')"
                        >
                        </fg-input>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-fill btn-wd" @click.prevent="validate">
                        {{trans('Save')}}
                    </button>
                </div>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
</template>
<script>

    import NotificationTemplate from './../../Dashboard/Views/Components/NotificationTemplate'
    import ErrorHelper from '../../utils/ErrorHelper'

    export default {
        mixins:['ErrorHelper'],
        components: {
            NotificationTemplate
        },
        data() {
            return {
                user: {
                    first_name: '',
                    second_name: '',
                    email: '',
                    phone: '',
                    aboutMe: ''
                },
                userValidations: {
                    first_name: {
                        required: true,
                        min:2,
                    },
                    second_name: {
                        required: true,
                        min: 2,
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    phone: {
                        required: true
                    }
                }
            }
        },
        mounted() {
          axios.get('/api/profile', {withCredentials: true})
                  .then(response => {
                    this.user = response.data;
                  });
        },
        methods: {
            updateProfile() {
                alert('Your data: ' + JSON.stringify(this.user))
            },
            getError(fieldName) {
                return this.errors.first(fieldName)
            },
            validate() {
                this.$validator.validateAll().then(isValid => {

                    axios.post('/api/profile', this.user)
                        .then(response => {
                            this.$notify({
                                    //icon: 'nc-icon nc-bell-55',
                                    horizontalAlign: 'right',
                                    verticalAlign: 'top',
                                    type: 'success',
                                    message: this.trans('Done'),
                                })
                        })
                        .catch(error => {
                            this.processErr(error);
                        });

                })
            }
        }
    }

</script>
<style>

</style>
