<template>
    <form>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{trans('Select a day')}}</label>
                    <el-date-picker v-model="datePicker" type="date" placeholder="Pick a day"
                                    :picker-options="pickerOptionsDate">
                    </el-date-picker>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{trans('Time Start')}}</label>
                    <div class="form-group">
                        <el-time-select
                                v-model="timePickerStart"
                                :picker-options="pickerOptionsTime"
                                placeholder="Select  a time">
                        </el-time-select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">

            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{trans('Time End')}}</label>
                    <div class="form-group">
                        <el-time-select
                                v-model="timePickerStop"
                                :picker-options="pickerOptionsTime"
                                placeholder="Select  a time">
                        </el-time-select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <label>{{trans('Group')}}</label>
                <div class="form-group">
                    <b-form-select v-model="item.group_id" :options="groups"></b-form-select>
                </div>
            </div>
            <div class="col-md-6">
                <label>{{trans('Trainer')}}</label>
                <div class="form-group">
                    <b-form-select v-model="item.trainer_id" :options="trainers"></b-form-select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">

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
    import {DatePicker, TimeSelect} from 'element-ui'

    import 'element-ui/packages/theme-chalk/src/date-picker.scss'
    import 'element-ui/packages/theme-chalk/src/time-picker.scss'
    import 'element-ui/packages/theme-chalk/src/time-select.scss'

    export default {
        props:['item', 'roles', 'groups', 'trainers'],
        mixins: [ErrorHelper],
        components: {BFormTextarea, BFormSelect, [DatePicker.name]: DatePicker,  [TimeSelect.name]: TimeSelect},
        data(){
            return {
                datePicker: '',
                timePickerStart:'',
                timePickerStop:'',
                pickerOptionsTime: {
                    start: '07:00',
                    step: '00:30',
                    end: '22:00'
                },
                pickerOptionsDate: {
                    shortcuts: [{
                        text: 'Today',
                        onClick (picker) {
                            picker.$emit('pick', new Date())
                        }
                    },
                    {
                        text: 'Yesterday',
                        onClick (picker) {
                            const date = new Date()
                            date.setTime(date.getTime() - 3600 * 1000 * 24)
                            picker.$emit('pick', date)
                        }
                    },
                    {
                        text: 'A week ago',
                        onClick (picker) {
                            const date = new Date()
                            date.setTime(date.getTime() - 3600 * 1000 * 24 * 7)
                            picker.$emit('pick', date)
                        }
                    }]
                },
                itemValidations: {
                    date: {
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
        watch:{
            item: function(val, oldval) {
                const d = val.start
                const z = val.stop
                let loc = this.$root.lang
                const ye = new Intl.DateTimeFormat(loc, { year: 'numeric' }).format(d)
                const mo = new Intl.DateTimeFormat(loc, { month: '2-digit' }).format(d)
                const da = new Intl.DateTimeFormat(loc, { day: '2-digit' }).format(d)
                const hoStart = new Intl.DateTimeFormat(loc, { hour: '2-digit' }).format(d)
                const miStart = new Intl.DateTimeFormat(loc, { minute: '2-digit' }).format(d)
                const hoStop = new Intl.DateTimeFormat(loc, { hour: '2-digit' }).format(z)
                const miStop = new Intl.DateTimeFormat(loc, { minute: '2-digit' }).format(z)

                this.datePicker = `${ye}-${mo}-${da}`
                this.timePickerStart = `${hoStart}:00`
                this.timePickerStop = `${hoStop}:00`
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
        },
        mounted() {
            console.log('event form')
        }
    }
</script>
