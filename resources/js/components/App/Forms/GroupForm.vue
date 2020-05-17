<template>
    <div class="card">
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col">
                        <fg-input type="text"
                                  name="name"
                                  v-bind:label="trans('Group Name')"
                                  v-bind:placeholder="trans('Group Name')"
                                  v-model="item.name"
                                  v-validate="itemValidations.name"
                                  :error="getError('name')"
                        >
                        </fg-input>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>{{trans('Color on schedule')}}</label>
                        <b-form-select name="color_id" v-model="item.color_id" :options="colors"></b-form-select>
                    </div>
                    <div class="col-md-6 p-2">
                        <div class="w-100 h-100 rounded border" ref="colorBlock"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label>{{trans('Default trainer')}}</label>
                        <b-form-select name="default_trainer_id" v-model="item.default_trainer_id" :options="trainers"></b-form-select>
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <fg-input type="text"
                                  name="max_person"
                                  v-bind:label="trans('Max Person')"
                                  v-bind:placeholder="trans('Max Person')"
                                  v-model="item.max_person"
                                  v-validate="itemValidations.max_person"
                                  :error="getError('max_person')"
                        >
                        </fg-input>
                    </div>
                    <div class="col-md-6">
                        <fg-input type="text"
                                  name="duration_min"
                                  v-bind:label="trans('Duration') + ' min.'"
                                  v-bind:placeholder="trans('Duration')"
                                  v-model="item.duration_min"
                                  v-validate="itemValidations.duration_min"
                                  :error="getError('duration_min')"
                        >
                        </fg-input>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label>{{trans('Notes')}}</label>
                        <div class="form-group">
                            <b-form-textarea
                                    name="about"
                                    v-model="item.about"
                                    v-bind:placeholder="trans('A note')"
                                    rows="3"
                                    max-rows="6"
                            ></b-form-textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <p-button
                                type="danger" block
                                v-text="trans('Delete')"
                                class="mt-4"
                                @click.prevent="$emit('delete', {uid:item.uid})"
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

            </form>
        </div>
    </div>
</template>

<script>

    import ErrorHelper from '../../utils/ErrorHelper'
    import {BFormSelect} from 'bootstrap-vue'
    import {BFormTextarea} from 'bootstrap-vue'

    export default {
        refs:['colorBlock'],
        props:['item', 'colors','trainers'],
        mixins: [ErrorHelper],
        components:{
          BFormSelect, BFormTextarea
        },
        data() {
            return {
                itemValidations:{
                    name: {
                        required: true,
                        min: 2,
                    },
                    max_person: {
                        required: true,
                        integer: true,
                    },
                    duration_min: {
                        required: true,
                        integer: true,
                    },
                    color_id: {
                        required: true,
                        integer: true,
                    },
                    default_trainer_id: {
                        required: true,
                        integer: true,
                    }
                }
            }
        },
        watch:{
            'item.color_id': {
                handler: function(val) {
                    let color = this.colors.find(o => o.value === val)
                    this.$refs.colorBlock.style.backgroundColor = color.hex
                }
            }
        },
        methods: {
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
        },
    }
</script>
