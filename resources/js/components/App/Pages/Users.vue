import swal from "sweetalert2";
<template>
    <div class="container-fluid">

   <span class="card-title d-inline">
   <span class="h4">{{trans('Users')}}</span>
   <span class="text-primary ml-3">
       <p-button size="sm" type="primary" @click="openEditor('new')">
              <i slot="label" class="fa fa-edit"></i>{{trans('Create')}}
       </p-button>
   </span>
   </span>

        <!--modal for child elem -->
        <modal
            v-bind:show="showForm"
            v-on:close="showForm = false"
            headerClasses="p-2"
            bodyClasses="p-3"
        >
            <span class="h4" slot="header">{{trans('User')}} {{modalEntity.first_name}}</span>
            <user-form ref="form"
               :item=modalEntity
               :roles=selectRoles
               v-on:save="saveEntity"
               v-on:delete="deleteEntity"
               v-on:close="showForm = false"
            >
            </user-form>

        </modal>

        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-sm-6">
                        <!--filter -->
                        <div class="input-group" style="flex-wrap: nowrap;">
                            <input type="search" class="form-control form-control-sm"
                                   v-bind:placeholder="trans('Type to Search')"
                                   aria-describedby="button-addon2"
                                   v-model="filter"
                                   id="filterInput"
                                   style="min-width:130px">
                            <div class="input-group-append">
                                <button class="btn btn-outline-default btn-sm mt-0"
                                        type="button"
                                        id="button-addon2"
                                        :disabled="!filter"
                                        @click="filter = ''"
                                        style="height: 31px"
                                        v-text="trans('Clear')"
                                ></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 text-right">

                        <div class="btn-group">
                            <p-button v-for="role in roles"
                                      v-bind:id="role.uid"
                                      type="info"
                                      size="sm"
                                      class="m-0"
                                      v-bind:class="{ active: role.uid == currentRole}"
                                      @click="clickSelectRole(role.uid, $event.target)"
                                      v-text="role.name"
                            ></p-button>
                        </div>

                    </div>

                </div>
                <!--data block -->
                <div v-if="this.items.length > 0">
                    <b-table striped hover
                         sticky-header
                         responsive="sm"
                         :items="items"
                         :fields="fields"
                         :current-page="currentPage"
                         :per-page="perPage"
                         :filter="filter"
                         :filterIncludedFields="filterOn"
                         :sort-by.sync="sortBy"
                         :sort-desc.sync="sortDesc"
                         :sort-direction="sortDirection"
                         @filtered="onFiltered"
                         sort-icon-left
                         :tbody-tr-class="rowClass"
                    >

                        <template v-slot:cell(name)="row">
                            <span>{{ row.item.first_name}} </span> <span>{{ row.item.second_name }}</span>
                        </template>

                        <template v-slot:cell(actions)="row">
                            <p-button size="sm" @click="openEditor(row.item.id)" class="mr-1">
                                <i class="fa fa-edit"></i> {{trans('Edit')}}
                            </p-button>
                        </template>

                        <template v-slot:cell(active)="data">
                            <div class="custom-control custom-switch">
                                <input
                                        type="checkbox"
                                        class="custom-control-input"
                                        :id="data.item.id"
                                        v-model="data.item.active"
                                        @click="clickActive(data.item.id, data.item.active)"
                                >
                                <label class="custom-control-label" :for="data.item.id"></label>
                            </div>
                        </template>

                        <template v-slot:table-caption>{{trans('Total records')}}: {{totalRows}}</template>
                    </b-table>
                </div>
                <div class="mt-2" v-else>
                    {{trans('Seems, you do not have any users here.')}}
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    import {Button, Card} from '../../../components/UIComponents'
    import {BTable} from "bootstrap-vue"
    import {BFormSelect} from "bootstrap-vue"
    import {BPagination} from "bootstrap-vue"
    import PButton from "../../UIComponents/Button"
    import ErrorHelper from "../../utils/ErrorHelper"
    import UserForm from "../Forms/UserForm"
    import Modal from "../../../components/UIComponents/Modal"
    import swal from 'sweetalert2'

    export default {
        mixins: [ErrorHelper],
        refs:['form'],
        components: {
            [Button.name]: Button,
            Card,
            BTable,
            BFormSelect,
            BPagination,
            PButton,
            UserForm,
            Modal
        },
        data() {
            return {
                urls: {
                    'getItems': `/api/company/${this.$root.companyUid}/users`,
                    'updateItem': `/api/company/${this.$root.companyUid}/user`,
                },
                items: [],
                roles: [],
                currentRole: null,
                fields: [
                    {key: 'name', label: this.trans('Full Name'), sortable: true, stickyColumn: true},
                    {key: 'phone', label: this.trans('Phone'), sortable: false},
                    {key: 'active', label: this.trans('Active'), class: 'text-center', sortable: false},
                    {key: 'actions', label: this.trans('Actions'), class: 'text-right'}
                ],
                filterOn: ['first_name', 'second_name', 'phone'],
                sortBy: 'name',
                totalRows: 1,
                currentPage: null,
                perPage: null,
                pageOptions: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                showForm:false,
                modalEntity: {id: null, first_name:'', second_name:'', email:'', phone:'', role_id:''},
                selectRoles: []
            }
        },
        watch: {
            items: function (val) {
                // Set the initial number of items
                this.totalRows = val.length
            },
            currentRole: function () {
                this.getUsers()
            },
            roles: function () {
                if (this.roles && this.roles.length > 0) {
                    this.currentRole = this.roles[0].uid
                    this.roles.forEach( item => {
                        this.selectRoles.push({value: item.id, text: item.name})
                    })
                }
            }
        },
        computed: {
            sortOptions() {
                // Create an options list from our fields
                return this.fields
                    .filter(f => f.sortable)
                    .map(f => {
                        return {text: f.label, value: f.key}
                    })
            }
        },
        methods: {
            clickActive(id, active) {
                axios.post(this.urls.updateItem, {id: id, active: !active})
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
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            openEditor(val) {
                if (val === 'new') {
                   this.modalEntity = {id: null, first_name:'', second_name:'', email:'', phone:'', role_id: this.currentRole}
                   this.$refs.form.reset()
                   this.showForm = true;
                } else {
                    this.modalEntity = this.getClone(this.items.find(o => o.id === val))
                    this.showForm = true;
                }
            },
            getClone(obj) {
                return Object.assign({}, obj);
            },
            saveEntity() {
                this.showForm = false
                delete this.modalEntity.active
                axios.post(this.urls.updateItem, this.modalEntity)
                    .then(response => {
                        this.$notify({
                            //icon: 'nc-icon nc-bell-55',
                            horizontalAlign: 'right',
                            verticalAlign: 'top',
                            type: 'success',
                            message: this.trans('Done'),
                        })
                        this.getUsers()
                    })
                    .catch(error => {
                        this.processErr(error)
                        this.showForm = true
                    });
            },
            deleteEntity(uid){
                swal({
                    title: this.modalEntity.first_name + ' ' + this.modalEntity.second_name,
                    html: `<span class="h5">${this.trans('Delete User')}?</span>`,
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
                        axios.delete(this.urls.updateItem, { data: uid })
                            .then(response => {
                                this.$notify({
                                    //icon: 'nc-icon nc-bell-55',
                                    horizontalAlign: 'right',
                                    verticalAlign: 'top',
                                    type: 'success',
                                    message: this.trans('Done')
                                })

                                this.showForm = false;
                            })
                            .catch(error => {
                                this.processErr(error)
                            });
                    }
                }).catch(swal.noop)
            },
            rowClass(item, type) {
                return
                // if (!item || type !== 'row') return
                // if (item.role_id === 1) return 'table-moccasin'
                // else return 'table-wheat'
            },
            clickSelectRole(val, em) {
                this.currentRole = val
            },
            getUsers() {
                axios.get(this.urls.getItems, {
                    params: {
                        role: this.currentRole
                    }
                })
                .then(response => {
                    this.items = response.data.users
                    //this.roles = response.data.roles
                }).catch(error => {
                    this.processErr(error)
                });
            }
        },
        mounted() {
            // @todo here a problem
            if (this.$root.roles) {
                this.roles = this.$root.roles
               // this.getUsers()
            }
        }
    }
</script>
