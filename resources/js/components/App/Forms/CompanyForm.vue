<template>
    <div class="card">
        <div class="card-header">
            <h4 class="title">{{trans('Company Details')}}</h4>
        </div>
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col">
                        <fg-input type="text"
                                  name="name"
                                  v-bind:label="trans('Company Name')"
                                  v-bind:placeholder="trans('Company Name')"
                                  v-model="company.name"
                                  v-validate="companyValidations.name"
                                  :error="getError('name')"
                        >
                        </fg-input>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <fg-input type="text"
                                  name="address"
                                  v-bind:label="trans('Company Address')"
                                  v-bind:placeholder="trans('Company Address')"
                                  v-model="company.address"
                                  v-validate="companyValidations.address"
                                  :error="getError('address')"
                        >
                        </fg-input>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <fg-input type="text"
                                  name="city"
                                  v-bind:label="trans('City')"
                                  v-bind:placeholder="trans('City')"
                                  v-model="company.city"
                                  v-validate="companyValidations.city"
                                  :error="getError('city')"
                        >
                        </fg-input>
                    </div>
                    <div class="col-md-5">
                        <fg-input type="text"
                                  name="country"
                                  v-bind:label="trans('Country')"
                                  v-bind:placeholder="trans('Country')"
                                  v-model="company.country"
                                  v-validate="companyValidations.country"
                                  :error="getError('country')"
                        >
                        </fg-input>
                    </div>
                    <div class="col-md-3">
                        <fg-input type="text"
                                  name="zip"
                                  v-bind:label="trans('Postal Code')"
                                  placeholder="00000"
                                  v-model="company.zip"
                                  v-validate="companyValidations.zip"
                                  :error="getError('zip')"
                        >
                        </fg-input>
                    </div>
                </div>

                <h4 class="title ml-3">{{trans('Visit Calendar Settings')}}</h4>
                <div class="row">
                    <label class="col-md-9 col-form-label text-right">{{trans('Online Calendar')}}</label>
                    <div class="col-md-3 form-group text-right">
                        <p-switch v-model="company.public_available" type="primary" :on-text="switches.on" :off-text="switches.off"></p-switch>
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">{{trans('Link to your calendar')}}</div>
                    <div class="col-8 text-muted badge badge-warning text-wrap mb-2 p-1">https://sportstation.club/company{{company.unique_id}}/public-schedule</div>
                    <div class="col-1"><a href="#" @click.prevent="clickCopyUrl"><i class="fa fa-copy"></i></a></div>
                </div>
                <div class="row">
                    <label class="col-md-9 col-form-label text-right">{{trans('Last call in')}}</label>
                    <div class="col-md-3 form-group">
                        <b-form-select v-model="company.last_call_hours" :options="selects.lastCalls"></b-form-select>
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-9 col-form-label text-right">{{trans('Cancel visit in')}}</label>
                    <div class="col-md-3 form-group">
                        <b-form-select v-model="company.refuse_in_hours" :options="selects.cancelIn"></b-form-select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label>{{trans('Class entry rules')}}</label>

                        <textarea rows="10" class="form-control border-input"
                                  name="rules"
                                  v-bind:placeholder="trans('Class entry rules')"
                                  v-model="company.rules"
                        >
                            </textarea>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{trans('About Company')}}</label>
                            <textarea rows="5" class="form-control border-input"
                                      name="about"
                                      v-bind:placeholder="trans('About Company')"
                                      v-model="company.about"
                            >
                            </textarea>
                        </div>
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

    import {BFormSelect} from 'bootstrap-vue'
    import ErrorHelper from '../../utils/ErrorHelper'
    import PSwitch from '../../../components/UIComponents/Switch.vue'

    export default {
        mixins: [ErrorHelper],
        components: {
            BFormSelect,
            PSwitch
        },
        data() {
            return {
                company: {
                    unique_id:'',
                    name: '',
                    address: '',
                    country: '',
                    city: '',
                    zip: '',
                    about: '',
                    last_call_hours: '',
                    refuse_in_hours: '',
                    rules: '',
                    timezone: '',
                    public_available: false
                },
                companyValidations: {
                    name: {
                        required: true,
                        min: 2,
                    },
                    address: {
                        required: true,
                        min: 2,
                    },
                    country: {
                        required: true,
                        min: 3
                    },
                    city: {
                        required: true
                    },
                    zip: {
                        required: true
                    }
                },
                selects: {
                    lastCalls: [
                        {value: '1', text: this.trans('1 hour')},
                        {value: '2', text: this.trans('2 hours')},
                        {value: '3', text: this.trans('3 hours')},
                        {value: '4', text: this.trans('4 hours')},
                        {value: '5', text: this.trans('5 hours')}
                    ],
                    cancelIn: [
                        {value: '12', text: this.trans('12 hours')},
                        {value: '8', text: this.trans('8 hours')},
                        {value: '4', text: this.trans('4 hours')}
                    ]
                },
                switches: {
                    on: this.trans('ON'),
                    off: this.trans('OFF')
                }
            }
        },
        mounted() {
            // enable editor

            // get company
            axios.get('/api/company') // , {withCredentials: true}
                .then(response => {
                    this.company = response.data;

                    // if (
                    //     typeof response.data.timezone === 'undefined' ||
                    //     !response.data.timezone
                    // ) {
                    //     this.company.timezone = this.uiTimezone;
                    // }
                    // this.updateTime();if (
                    //     typeof response.data.timezone === 'undefined' ||
                    //     !response.data.timezone
                    // ) {
                    //     this.company.timezone = this.uiTimezone;
                    // }
                    // this.updateTime();

                });
        },
        methods: {
            clickCopyUrl() {

            },
            getError(fieldName) {
                return this.errors.first(fieldName)
            },
            validate() {
                this.$validator.validateAll().then(isValid => {
                    if (isValid) {
                        this.updateCompany()
                    }

                })
            },
            updateCompany() {
                axios.post('/api/company', this.company)
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
            }
        },
        beforeDestroy() {

        },
    }
</script>
