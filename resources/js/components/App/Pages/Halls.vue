<template>
    <div class="container-fluid">

        <!--modal for child elem -->
        <modal
            v-bind:show="showForm"
            v-on:close="showForm = false"
        >
            <span class="h4" slot="header" v-text="trans('Hall')"></span>
            <hall-form ref="form"
                 :item=modalEntity
                 v-on:save="saveEntity"
            >
            </hall-form>
        </modal>
        <!-- breadcrumbs-->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <router-link name="Branches" to="/classes/branches">{{trans('Branches')}}</router-link>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{rootEntity.name}}</li>
                <li class="breadcrumb-item active" aria-current="page">{{trans('Halls')}}</li>
            </ol>
        </nav>

        <div class="row">

            <!-- root entity -->
            <div class="col-5">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <branch-form
                                :item=rootEntity
                                v-on:save="saveRootEntity"
                        >
                        </branch-form>
                    </div>
                </div>
            </div>
            <div class="col-7">

                <div class="places-sweet-alerts">
                    <div class="row">
                        <!--items -->
                        <div class="col-sm-6" v-for="hall in children">
                            <card card-body-classes="text-center">
                        <span style="position: absolute; top:0px; right:6px;">
                            <a href="#" @click.prevent="openDeleteDialog(hall.uid)"><i
                                    class="fa fa-times fa-lg text-danger"></i></a>
                        </span>
                                <p class="card-text h5">{{hall.name}}</p>
                                <p class="card-text">{{hall.address}}</p>

                                <div class="row">
                                    <div class="col-6 pt-3">
                                        <p-switch
                                                v-model=hall.active
                                                type="success"
                                                :on-text="switches.on"
                                                :off-text="switches.off"
                                                @input="updateChildStatus({uid:hall.uid, active:hall.active})"
                                        ></p-switch>
                                    </div>
                                    <div class="col-6">
                                        <p-button type="default" size="sm" outline round @click="openEditor(hall.uid)"
                                                  class="w-100">
                                            <i slot="label" class="fa fa-edit"></i>{{trans('Edit')}}
                                        </p-button>
                                    </div>
                                </div>
                            </card>
                        </div>

                        <!-- new item -->
                        <div class="col-md-3">
                            <card card-body-classes="text-center">
                                <p class="card-text">{{this.trans('Add Hall')}}</p>
                                <p-button type="success" outline @click="openNewEntity">
                                    <i class="fa fa-plus-circle fa-3x"></i></p-button>
                            </card>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>

    import {Button, Card} from '../../../components/UIComponents'
    import BranchForm from '../../../components/App/Forms/BranchForm'
    import HallForm from "../../../components/App/Forms/HallForm"
    import PSwitch from '../../../components/UIComponents/Switch.vue'
    import Modal from "../../../components/UIComponents/Modal"
    import swal from 'sweetalert2'
    import ErrorHelper from "../../utils/ErrorHelper"

    export default {
        mixins: [ErrorHelper],
        refs: ['form'],
        components: {
            [Button.name]: Button,
            Card,
            BranchForm,
            HallForm,
            PSwitch,
            Modal
        },
        data() {
            return {
                urls: {
                    'getRoot': `/api/branch/${this.$route.params.uid}`,
                    'setRoot': `/api/company/${this.$root.companyUid}/branch`,
                    'getChildren': 'value3',
                    'setChildren': `/api/branch/${this.$route.params.uid}/hall`
                },
                modalEntity: {name: '', active: true, about: ''},
                showForm: false,
                children: [],
                rootEntity: {},
                switches: {
                    on: this.trans('ON'),
                    off: this.trans('OFF')
                },
            }
        },
        methods: {
            saveRootEntity() {
                let data = {
                    id: this.rootEntity.id,
                    name: this.rootEntity.name,
                    address: this.rootEntity.address,
                    about: this.rootEntity.about
                }
                axios.post(this.urls.setRoot, data)
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
            openNewEntity() {
                this.modalEntity = {name: '', active: true, about: ''}
                this.$refs.form.reset()
                this.showForm = true
            },
            saveEntity() {
                this.updateEntity(this.modalEntity)
            },
            updateChildStatus(data) {
                axios.post(this.urls.setChildren, data)
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
            updateEntity(data) {
                this.showForm = false
                axios.post(this.urls.setChildren, data)
                    .then(response => {
                        // if uid returns then push new child
                        if (typeof response.data.uid !== 'undefined') {
                            this.modalEntity.uid = response.data.uid
                            this.children.push(this.modalEntity)
                        } else {
                            // update child with new data
                            let index = this.children.findIndex((obj => obj.uid === data.uid))
                            this.children[index] = this.modalEntity
                        }
                        this.modalEntity = {name: '', about: '', active: true}
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
            openEditor(val) {
                this.modalEntity = this.getClone(this.children.find(o => o.uid === val))
                this.showForm = true;
            },
            getClone(obj) {
                return Object.assign({}, obj);
            },
            openDeleteDialog(val) {
                let delHall = this.children.find(o => o.uid === val);
                swal({
                    title: delHall.name,
                    html: `<span class="h5">${this.trans('Delete Hall')}?</span>`,
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
                        axios.delete(this.urls.setChildren, {data: {uid: val}})
                            .then(response => {
                                // remove item from child
                                this.children = this.children.filter(function (el) {
                                    //return el.uid !== val; for integer
                                    return el.uid.localeCompare(val) != 0
                                });
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
            // get all the Entities
            axios.get(this.urls.getRoot)
                .then(response => {
                    this.children = response.data[0].halls
                    this.rootEntity = response.data[0]
                });
        }
    }
</script>
