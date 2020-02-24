<template>
    <div class="container-fluid">
        <h4 class="card-title" v-text="trans('Branches')"></h4>

      <modal
          v-bind:show="showForm"
          v-on:close="showForm = false"
      >
        <span class="h4" slot="header" v-text="trans('Branch')"></span>
        <branch-form ref="form"
            :item=modalBranch
            v-on:save="save"
        >
        </branch-form>
      </modal>

        <div class="places-sweet-alerts">
            <div class="row">
                <!--items -->
                <div class="col-sm-4" v-for="branch in branches">
                    <card card-body-classes="text-center">
                        <span style="position: absolute; top:0px; right:6px;">
                            <a href="#" @click.prevent="openDeleteDialog(branch.id)"><i class="fa fa-times fa-lg text-danger"></i></a>
                        </span>
                        <p class="card-text h5">{{branch.name}}</p>
                        <p class="card-text">{{branch.address}}</p>

                        <div class="row">
                            <div class="col-6 pt-3">
                                <p-switch
                                        v-model=branch.active
                                        type="success"
                                        :on-text="switches.on"
                                        :off-text="switches.off"
                                        @input="updateBranch({id:branch.id, active:branch.active})"
                                ></p-switch>
                            </div>
                            <div class="col-6">
                                <p-button type="default" size="sm" outline round @click="openEditor(branch.id)" class="w-100">
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
                        <p-button type="success" outline @click="newBranch">
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
                showForm:false,
                branches: [],
                switches: {
                    on: this.trans('ON'),
                    off: this.trans('OFF')
                },
                modalBranch: {id:'', name:'', address:'', active:'', about:''}
            }
        },
        watch: {},
        methods: {
            newBranch() {
                this.modalBranch = {id:'', name:'', address:'', active:'', about:''}
                this.$refs.form.reset()
                this.showForm = true
            },
            save() {
                this.showForm = false
                this.updateBranch(this.modalBranch)
            },
            updateBranch(data) {
                axios.post('/api/branch', data)
                    .then(response => {
                       // this.getBranches()
                        this.modalBranch = {id:'', name:'', address:'', about:'', active:''}
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
            getBranches() {
                // get branches
                axios.get('/api/branches') // , {withCredentials: true}
                    .then(response => {
                        this.branches = response.data
                    });
            },
            openEditor(val) {
                this.modalBranch = this.branches.find(o => o.id === val);
                this.showForm = true;
            },
            openDeleteDialog(val) {
                let delBranch = this.branches.find(o => o.id === val);
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
                        axios.delete('/api/branch', { data: { id: val }})
                            .then(response => {
                                // this.getBranches()
                                this.branches =  this.branches.filter(function(el) { return el.id != val; });
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
            this.getBranches();
        }
    }
</script>
<style>
</style>
