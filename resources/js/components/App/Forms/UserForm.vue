<template>
    <form>
        <div class="row">
            <div class="col-md-6">
                <fg-input type="text"
                          name="first_name"
                          v-bind:label="trans('First Name')"
                          v-bind:placeholder="trans('First Name')"
                          v-model="item.first_name"
                          v-validate="itemValidations.first_name"
                          :error="getError('first_name')"
                >
                </fg-input>
            </div>
            <div class="col-md-6">
                <fg-input type="text"
                          name="last_name"
                          v-bind:label="trans('Second Name')"
                          v-bind:placeholder="trans('Second Name')"
                          v-model="item.second_name"
                          v-validate="itemValidations.second_name"
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
                          v-model="item.phone"
                          v-validate="itemValidations.phone"
                          :error="getError('phone')"
                >
                </fg-input>
            </div>
            <div class="col-md-6">
                <fg-input type="email"
                          name="email"
                          label="Email"
                          placeholder="Email"
                          v-model="item.email"
                          v-validate="itemValidations.email"
                          :error="getError('email')"
                >
                </fg-input>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label>{{trans('Role')}}</label>
                <b-form-select
                        name="role_id"
                        v-model="item.role_id"
                        :options="roles">

                </b-form-select>
            </div>
            <div class="col-md-6">

            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <p-button v-if="item.id === parseInt(item.id, 10)"
                    type="danger" block
                    v-text="trans('Delete')"
                    class="mt-4"
                    @click.prevent="$emit('delete', {id: item.id})"
                >
                </p-button>
                <p-button v-else
                          type="default" block
                          v-text="trans('Close')"
                          class="mt-4"
                          @click.prevent="$emit('close')"
                >
                </p-button>
            </div>
            <div class="col-md-6">
                <p-button
                    type="primary" block
                    v-text="trans('Save')"
                    class="mt-4"
                    @click="validate"
                >
                </p-button>
            </div>
        </div>
        <div class="clearfix"></div>
    </form>
</template>
<script>

    import ErrorHelper from "../../utils/ErrorHelper"
    import {BFormTextarea, BFormSelect} from 'bootstrap-vue'

    export default {
        props:['item', 'roles'],
        mixins: [ErrorHelper],
        components: {BFormTextarea, BFormSelect},
        data(){
            return {
                itemValidations: {
                    first_name: {
                        required: true,
                        min:2
                    },
                    second_name: {
                        required: false,
                        min:2
                    },
                    phone:{
                        required: true,
                        digits: 12

                    },
                    role_id:{
                        required:true,
                        numeric:true
                    }
                }
            }
        },
        methods:{
            getError(fieldName) {
                return this.errors.first(fieldName)
            },
            validate() {
                this.$validator.validateAll().then(isValid => {
                    if (isValid) {
                        this.$emit('save')
                    }
                })
            },
            reset() {
                this.$validator.reset()
            }
        }
    }
</script>
