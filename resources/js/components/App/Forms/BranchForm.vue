<template>
    <form>
        <div class="row">
            <div class="col">
                <fg-input type="text"
                      name="name"
                      v-bind:label="trans('Name')"
                      v-bind:placeholder="trans('Input Name')"
                      v-model="item.name"
                      v-validate="itemValidations.name"
                      :error="getError('name')"
                >
                </fg-input>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <fg-input type="text"
                      name="address"
                      v-bind:label="trans('Address')"
                      v-bind:placeholder="trans('Input Address')"
                      v-model="item.address"
                      v-validate="itemValidations.address"
                      :error="getError('address')"
                >
                </fg-input>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label>{{trans('Notes')}}</label>
                <div class="form-group">
                <b-form-textarea
                        id="textarea"
                        name="about"
                        v-model="item.about"
                        v-bind:placeholder="trans('A note')"
                        rows="3"
                        max-rows="6"
                ></b-form-textarea>
                </div>
            </div>
        </div>
        <p-button
            type="primary" block
            v-text="trans('Save')"
            class="mt-4"
            @click="validate"
        >
        </p-button>
    </form>
</template>
<script>

    import ErrorHelper from "../../utils/ErrorHelper"
    import {BFormTextarea} from 'bootstrap-vue'

    export default {
        props:['item'],
        mixins: [ErrorHelper],
        components: {BFormTextarea},
        data(){
            return {
                itemValidations: {
                    name: {
                        required: true,
                        min:2,
                    },
                    address: {
                        required: true,
                        min: 5
                    },
                    about: {
                        required: false
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
