<template>
    <div class="container-fluid">
        <h4 class="card-title" v-text="trans('Roles')"></h4>

      <modal
          v-bind:show="showForm"
          v-on:close="showForm = false"
      >
        <span class="h4" slot="header" v-text="trans('Role')"></span>
        <role-form ref="form"
            :item=modalRole
            v-on:save="save"
        >
        </role-form>
      </modal>

        <div class="places-sweet-alerts">
            <div class="row">
                <!--items -->
                <div class="col-sm-4" v-for="role in roles">
                    <card card-body-classes="text-center">
                        <span style="position: absolute; top:0px; right:6px;">
                            <a class="invisible" href="#" @click.prevent="openDeleteDialog(role.id)"><i class="fa fa-times fa-lg text-danger"></i></a>
                        </span>
                        <p class="card-text h5">{{role.name}}</p>

                        <div class="row">
<!--                            <div class="col-6 pt-3">-->
<!--                                <p-switch-->
<!--                                        v-model=role.active-->
<!--                                        type="success"-->
<!--                                        :on-text="switches.on"-->
<!--                                        :off-text="switches.off"-->
<!--                                        @input="updateRole({id:role.id, active:role.active})"-->
<!--                                ></p-switch>-->
<!--                            </div>-->
                            <div class="col-12">
                                <p-button type="default" size="sm" outline round @click="openEditor(role.id)" class="w-75">
                                    <i slot="label" class="fa fa-edit"></i>{{trans('Edit')}}
                                </p-button>
                            </div>

                        </div>
                    </card>
                </div>

                <!-- new item -->
                <div class="col-md-3">
                    <card card-body-classes="text-center">
                        <p class="card-text">{{this.trans('Add Role')}}</p>
                        <p-button type="success" outline @click="newRole">
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
    import RoleForm from "../../../components/App/Forms/RoleForm"
    import PButton from "../../UIComponents/Button"
    import swal from 'sweetalert2'

    export default {
        mixins: [ErrorHelper],
        refs:['form'],
        components: {
            PButton,
            RoleForm,
            [Button.name]: Button,
            Card,
            PSwitch,
            Modal
        },
        data() {
            return {
                showForm:false,
                roles: [],
                switches: {
                    on: this.trans('ON'),
                    off: this.trans('OFF')
                },
                modalRole: {id:'', name:'', about:''}
            }
        },
        watch: {},
        methods: {
            newRole() {
                this.modalRole = {id:'', name:'', about:''}
                this.$refs.form.reset()
                this.showForm = true
            },
            save() {
                this.showForm = false
                this.updateRole(this.modalRole)
            },
            updateRole(data) {
                axios.post('/api/role', data)
                    .then(response => {
                        if (typeof response.data.id !== 'undefined') {
                            this.modalRole.id = response.data.id
                            this.roles.push(this.modalRole)
                        }else{
                            let index = this.roles.findIndex((obj => obj.id === data.id));
                            this.roles[index] = this.modalRole
                        }
                        this.modalRole = {id:'', name:'', about:''}
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
            getRoles() {
                // get roles
                axios.get('/api/roles') // , {withCredentials: true}
                    .then(response => {
                        this.roles = response.data
                    });
            },
            openEditor(val) {
                this.modalRole = this.getCloneRole(this.roles.find(o => o.id === val))
                this.showForm = true;
            },
            getCloneRole(role) {
                return Object.assign({}, role);
            },
            openDeleteDialog(val) {
                let delRole = this.roles.find(o => o.id === val);
                swal({
                    title: delRole.name,
                    html: `<span class="h5">${this.trans('Delete role')}?</span>`,
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
                        axios.delete('/api/role', { data: { id: val }})
                            .then(response => {
                                // this.getRoles()
                                this.roles =  this.roles.filter(function(el) { return el.id != val; });
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
            this.getRoles();
        }
    }
</script>
<style>
</style>
