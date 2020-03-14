<template>
    <div class="container-fluid">

   <span class="card-title d-inline">
   <span class="h4">{{trans('Users')}}</span>
   <span class="text-primary ml-3"><p-button size="sm" type="primary" @click="openEditor('new')">
              <i slot="label" class="fa fa-edit"></i>{{trans('Create')}}
            </p-button></span>
   </span>

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

                        <template v-slot:cell(name)="data">
                            <span>{{ data.value.first_name}}</span> <span>{{ data.value.last_name }}</span>
                        </template>

                        <template v-slot:cell(actions)="row">
                            <p-button size="sm" @click="openEditor(row.item)" class="mr-1">
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


    export default {
        mixins: [ErrorHelper],
        components: {
            [Button.name]: Button,
            Card,
            BTable,
            BFormSelect,
            BPagination,
            PButton
        },
        data() {
            return {
                urls: {
                    'getItems': `/api/company/${this.$root.companyUid}/users`,
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
                filterOn: ['name'],
                sortBy: 'name',
                totalRows: 1,
                currentPage: null,
                perPage: null,
                pageOptions: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null
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
                console.log(id)
                console.log(active)
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            openEditor(val) {
                if (val === 'new') {
                    this.$router.push({name: 'GroupEditor', params: {uid: 'new'}})
                } else {
                    this.$router.push({name: 'GroupEditor', params: {uid: val.uid}})
                }
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
                this.getUsers()
            }
        }
    }
</script>
