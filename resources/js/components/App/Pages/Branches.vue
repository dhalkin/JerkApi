<template>
    <div class="container-fluid">
      <h4 class="card-title" v-text="trans('Branches')"></h4>

      <modal
          v-bind:show="showForm"
          v-on:close="showForm = false"
      >
        <span class="h4" slot="header" v-text="trans('Branch')"></span>
        <branch-form ref="form"
            :item=modalItem
            v-on:save="save"
        >
        </branch-form>
      </modal>

        <div class="places-sweet-alerts">
            <div class="row">
                <!--items -->
                <div class="col-sm-4" v-for="branch in items">
                    <card card-body-classes="text-center">
                        <span style="position: absolute; top:0px; right:6px;">
                            <a href="#" @click.prevent="openDeleteDialog(branch.uid)"><i class="fa fa-times fa-lg text-danger"></i></a>
                        </span>
                        <p class="card-text h5">{{branch.name}}</p>
                        <p class="card-text mb-0">{{branch.address}}</p>
                        <div class="card-text text-left">
                            <span v-for="hall in branch.halls">
                                <span class="badge badge-success p-1 ml-1 mr-1" v-show="hall.active">
                                    {{hall.name}}
                                </span>
                                 <span class="badge badge-secondary p-1 ml-1 mr-1"  v-show="!hall.active">
                                    {{hall.name}}
                                </span>
                            </span>
                            <span class="badge badge-warning p-1"  v-if="hall.active=false" v-for="hall in branch.halls">{{hall.name}}</span>
                        </div>
                        <div class="row">
                            <div class="col-6 pt-3">
                                <p-switch
                                        v-model=branch.active
                                        type="success"
                                        :on-text="switches.on"
                                        :off-text="switches.off"
                                        @input="updateItemActiveStatus({uid:branch.uid, active:branch.active})"
                                ></p-switch>
                            </div>
                            <div class="col-6">
                                <p-button type="default" size="sm" @click="openEditor(branch.uid)" class="w-100">
                                    <i slot="label" class="fa fa-edit"></i>{{trans('Edit')}}
                                </p-button>
                            </div>
                        </div>
                    </card>
                </div>

                <!-- new item -->
                <div class="col-md-3">
                    <card card-body-classes="text-center">
                        <p class="card-text">{{this.trans('Add Branch')}}</p>
                        <p-button type="success" outline @click="newItem">
                            <i class="fa fa-plus-circle fa-3x"></i></p-button>
                    </card>
                </div>

            </div>
        </div>

    </div>
</template>
<script>

    import {Button, Card} from '../../../components/UIComponents'
    import PSwitch from '../../../components/UIComponents/Switch.vue'
    import ErrorHelper from "../../utils/ErrorHelper"
    import Modal from "../../../components/UIComponents/Modal";
    import BranchForm from "../../../components/App/Forms/BranchForm"
    import PButton from "../../UIComponents/Button"
    import swal from 'sweetalert2'

    export default {
        mixins: [ErrorHelper],
        refs:['form'],
        components: {
            PButton,
            BranchForm,
            [Button.name]: Button,
            Card,
            PSwitch,
            Modal
        },
        data() {
            return {
                urls:{
                    'getItems': `/api/company/${this.$root.companyUid}/branches`,
                    'setItem': `/api/company/${this.$root.companyUid}/branch`,
                },
                showForm:false,
                items: [],
                switches: {
                    on: this.trans('ON'),
                    off: this.trans('OFF')
                },
                modalItem: {uid:'', name:'', address:'', active:true, about:''}
            }
        },
        watch: {},
        methods: {
            newItem() {
                this.modalItem = {uid:'', name:'', address:'', active:true, about:''}
                this.$refs.form.reset()
                this.showForm = true
            },
            save() {
                this.showForm = false
                this.updateItem(this.modalItem)
            },
            updateItem(data) {
                axios.post(this.urls.setItem, data)
                    .then(response => {
                        if (typeof response.data.uid !== 'undefined') {
                            this.modalItem.uid = response.data.uid
                            this.items.push(this.modalItem)
                        }else{
                            let indexBranch = this.items.findIndex((obj => obj.uid === data.uid))
                            this.items[indexBranch] = this.modalItem
                        }
                        this.modalItem = {uid:'', name:'', address:'', about:'', active:true}
                        this.$refs.form.reset()
                        this.$notify({
                            //icon: 'nc-icon nc-bell-55',
                            horizontalAlign: 'right',
                            verticalAlign: 'top',
                            type: 'success',
                            message: this.trans('Done'),
                        })
                    })
                    .catch(error => {
                        this.processErr(error)
                        this.showForm = true
                    });
            },
            updateItemActiveStatus(data) {
                axios.post(this.urls.setItem, data)
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
                        this.processErr(error)
                    });
            },
            openEditor(val) {
                this.$router.push({ name: 'Halls', params: { uid: val }})
                // this.modalItem = this.getCloneBranch(this.items.find(o => o.uid === val))
                //this.showForm = true;
            },
            getCloneBranch(branch) {
                return Object.assign({}, branch);
            },
            openDeleteDialog(val) {
                let delBranch = this.items.find(o => o.uid === val);
                swal({
                    title: delBranch.name,
                    html: `<span class="h5">${this.trans('Delete branch')}?</span>`,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-danger btn-fill',
                    cancelButtonClass: 'btn btn-default btn-fill',
                    confirmButtonText: this.trans('Yes, delete it!'),
                    cancelButtonText: this.trans('Cancel'),
                    buttonsStyling: true,
                    reverseButtons: true,
                }).then(result => {
                    if (result) {
                        axios.delete('/api/company/'+this.$root.companyUid+'/branch', { data: { uid: val }})
                            .then(response => {
                                this.items =  this.items.filter(function(el) { return el.uid != val; });
                                this.$notify({
                                    //icon: 'nc-icon nc-bell-55',
                                    horizontalAlign: 'right',
                                    verticalAlign: 'top',
                                    type: 'success',
                                    message: this.trans('Done'),
                                })
                            })
                            .catch(error => {
                                this.processErr(error)
                            });
                    }
                }).catch(swal.noop)
            }
        },
        mounted() {
            axios.get(this.urls.getItems) // , {withCredentials: true}
                .then(response => {
                    this.items = response.data
                });
        }
    }
</script>
<style>
</style>
