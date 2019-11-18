<template>
    <div class="main-panel">
        <!-- Top Navbar -->
        <top-nav-bar v-bind:csrf="this.csrf" v-bind:title="trans('Halls')"></top-nav-bar>
        <!-- End Navbar -->


    <div class="content">

        <div class="modal fade" id="createNewEntity">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <form method="POST" action="#" @submit.prevent="createHall"
                              @keydown="errors.clear($event.target.name)">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <input-text
                                        v-bind:label="trans('Hall name') + ' *'"
                                        v-model.trim="name"
                                        v-bind:errors="errors"
                                        name="name"
                                        required="required">
                                    </input-text>
                                </div>
                                <div class="col-md-6">
                                    <input-text
                                        v-bind:label="trans('Address') + ' *'"
                                        v-model.trim="address"
                                        v-bind:errors="errors"
                                        name="address"
                                        required="required">
                                    </input-text>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="comment" v-text="trans('About')"></label>
                                        <textarea class="form-control" rows="3"
                                                  id="about" name="about"
                                        v-model.trim="about"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary w-100"
                                            style="min-width: 115px;"
                                            v-text="trans('Create')">
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


            <div class="card">
                <div class="card-body">

<!--                    <transition>-->
<!--                        <div class="table-responsive" v-if="this.halls.length > 0">-->
<!--                        <table class="table" id="hallsTable">-->
<!--                            <thead class="">-->
<!--                            <tr>-->
<!--                                <th scope="col">{{trans('Name')}}</th>-->
<!--                                <th scope="col">{{trans('Address')}}</th>-->
<!--                                <th scope="col" class="text-md-right">{{trans('Active')}}</th>-->
<!--                                <th scope="col" class="text-md-right">{{trans('Actions')}}</th>-->
<!--                            </tr>-->
<!--                            </thead>-->
<!--                            <tbody>-->
<!--                            <tr v-for="hall in this.halls">-->
<!--                                <td class="text-md-left">-->
<!--                                    {{hall.name}}-->
<!--                                </td>-->
<!--                                <td class="text-md-left">-->
<!--                                    {{hall.address}}-->
<!--                                </td>-->
<!--                                <td class="text-md-right">-->
<!--                                    <div class="custom-control custom-switch">-->
<!--                                    <input-->
<!--                                        type="checkbox"-->
<!--                                        class="custom-control-input"-->
<!--                                        :id="hall.unique_id"-->
<!--                                        v-model="hall.active"-->
<!--                                        @change="setActiveStatus(hall.unique_id, hall.active)">-->
<!--                                     <label class="custom-control-label" :for="hall.unique_id"></label>-->
<!--                                    </div>-->
<!--                                </td>-->
<!--                                <td class="text-md-right">-->
<!--                                    <button type="button" rel="tooltip" class="btn btn-success btn-icon btn-sm"-->
<!--                                            @click="goToHall(hall.unique_id)">-->
<!--                                        <i class="fa fa-edit"></i>-->
<!--                                    </button>-->
<!--                                    <button type="button" rel="tooltip" class="btn btn-danger btn-icon btn-sm ">-->
<!--                                        <i class="fa fa-times"></i>-->
<!--                                    </button>-->
<!--                                </td>-->
<!--                            </tr>-->
<!--                            </tbody>-->
<!--                        </table>-->
<!--                        </div>-->
<!--                        <p class="h3 p-4" v-else v-text="trans('Nothing to show')"></p>-->
<!--                    </transition>-->

                    <div>


                                <div class="row">
                                    <div class="col-md-3 align-middle">
                                        Filter

                                            <input type="text" class="form-control" placeholder=".col-md-3">

                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder=".col-md-4">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder=".col-md-5">
                                        </div>
                                    </div>
                                </div>


                            <b-row>
                                <b-col sm="6" md="6" lg="6">
                                    <b-form-group
                                        label="Filter"
                                        label-cols-sm="3"
                                        label-align-sm="right"
                                        label-size="sm"
                                        label-for="filterInput"
                                        class="mb-0"
                                    >
                                        <b-input-group size="sm">
                                            <b-form-input
                                                v-model="filter"
                                                type="search"
                                                id="filterInput"
                                                placeholder="Type to Search"
                                            ></b-form-input>
                                            <b-input-group-append>
                                                <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                                            </b-input-group-append>
                                        </b-input-group>
                                    </b-form-group>
                                </b-col>

                                <b-col sm="2" md="2" lg="1" class="">
                                        <b-form-select
                                            v-model="perPage"
                                            id="perPageSelect"
                                            size="sm"
                                            :options="pageOptions"
                                        ></b-form-select>
                                </b-col>

                                <b-col sm="7" md="7" lg="5" class="">
                                    <b-pagination
                                        v-model="currentPage"
                                        :total-rows="totalRows"
                                        :per-page="perPage"
                                        align="fill"
                                        size="sm"
                                        class="my-0"
                                    ></b-pagination>
                                </b-col>
                            </b-row>
                        <b-table
                            striped hover
                            :items="halls"
                            :fields="hallsFields"
                            :current-page="currentPage"
                            :per-page="perPage"
                            :filter="filter"
                            :filterIncludedFields="filterOn"
                            :sort-by.sync="sortBy"
                            :sort-desc.sync="sortDesc"
                            :sort-direction="sortDirection"
                            @filtered="onFiltered">
                            <!-- A custom formatted column -->
                            <template v-slot:cell(active)="data">
                                <div class="custom-control custom-switch">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    :id="data.item.unique_id"
                                    v-model="data.item.active"
                                    @change="setActiveStatus(data.item.unique_id, data.item.active)">
                                 <label class="custom-control-label" :for="data.item.unique_id"></label>
                                </div>
                            </template>
                        </b-table>


                    </div>

                </div>
            </div>


    </div>
        <footer-bar></footer-bar>

    </div>
</template>

<script>
    import Errors from "./utils/Errors";
    import RequestHelper from "./utils/RequestHelper";
    import TopNavBar from "./layout/TopNavBar";
    import FooterBar from "./layout/FooterBar";
    import InputText from "./elements/InputText";

    export default {
        components: {TopNavBar, TopNavBarWithSelect, FooterBar, InputText},
        mixins: [Errors, RequestHelper, TopNavBar, TopNavBarWithSelect],
        data: function () {
            return {
                name: '',
                address: '',
                about:'',
                halls: [],
                hallsFields: [
                    { key: 'name', label: this.trans('Name'), sortable: true, sortDirection: 'desc' },
                    { key: 'address', label: this.trans('Address'), sortable: false },
                    { key: 'active', label: this.trans('Active'), sortable: true, sortDirection: 'desc' },
                ],
                filteredFields: ['name', 'address'],
                totalRows: 1,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15],
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                filterOn: ['name', 'address'],
            }
        },

        computed: {
            sortOptions() {
                // Create an options list from our fields
                return this.hallsFields
                    .filter(f => f.sortable)
                    .map(f => {
                        return { text: f.label, value: f.key }
                    })
            }
        },

        mounted() {
            // get halls
            axios.get('/api/halls')
                .then(response => response.data)
                .then(data => {
                    this.halls = data;
                    // Set the initial number of items
                    this.totalRows = this.halls.length
                });
        },

        methods: {
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },

            goToHall(uuid){
                this.$router.push({ path: '/hall/' + uuid})
            },

            // ???
            deleteHall(uuid){

            },

            setActiveStatus(uuid, status){
                axios.post('/api/hall/' + uuid + '/update', this.prepareData(uuid))
                    .then(response => {
                        this.flash(this.trans('Saved'), 'success', {
                            timeout: 3000
                        });

                    })
                    .catch(error => {
                        this.processErr(error);
                    });
            },

            prepareData(uuid){
                let edithall = this.halls.find(o => o.unique_id === uuid);
                if( typeof edithall === 'object' && edithall !== null){
                    return { active:edithall.active };
                }

                return null;
            },

            createHall(){

                this.errors.clearAll();
                $('#createNewEntity').modal("hide");
                axios.post('/api/hall/create', this.prepareSubmit())
                    .then(response => {
                        this.flash(this.trans('Saved'), 'success', {
                            timeout: 3000
                        });
                        //this.$router.go();
                        this.halls.push(this.prepareSubmit())
                    })
                    .catch(error => {
                        this.processErr(error);
                    });
            },

            prepareSubmit(){
                return {
                    name: this.name,
                    address: this.address,
                    about: this.about,
                }
            }
        }
    }
</script>
