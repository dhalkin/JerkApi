<template>
    <div class="main-panel">
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">

            <div class="navbar-wrapper">
                <!-- for mobile fiew -->
                <div class="navbar-toggle">
                    <button type="button" class="navbar-toggler">
                        <span class="navbar-toggler-bar bar1"></span>
                        <span class="navbar-toggler-bar bar2"></span>
                        <span class="navbar-toggler-bar bar3"></span>
                    </button>
                </div>
                <span class="navbar-brand" v-text="trans('You need to log in to continue')"></span>
            </div>

            <div class="navbar-wrapper justify-content-end">
                <a class="ml-2" href="/lang/ru">Ru</a>
                <a class="ml-2" href="/lang/en">En</a>

                <a class="ml-3" v-text="trans('Logout')" href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                </a>
                <form id="logout-form" action="/'logout" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>

        </div>
    </nav>
    <!-- End Navbar -->

    <div class="content">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card bg-light mb-3">
                    <div class="card-header text-left h5" v-text="trans('Halls')"></div>
                    <div class="card-body p-0">

                        <transition>
                        <table class="table table-striped table-sm" v-if="this.halls.length > 0">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">{{trans('Name')}}</th>
                                <th scope="col">{{trans('Address')}}</th>
                                <th scope="col" class="text-md-right">{{trans('Active')}}</th>
                                <th scope="col" class="text-md-right">{{trans('Actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr v-for="hall in this.halls">
                                <td class="text-md-left">
                                    {{hall.name}}
                                </td>
                                <td class="text-md-left">
                                    {{hall.address}}
                                </td>
                                <td class="text-md-right">
                                    <div class="custom-control custom-switch">
                                    <input
                                        type="checkbox"
                                        class="custom-control-input"
                                        :id="hall.unique_id"
                                        v-model="hall.active"
                                        @change="setActiveStatus(hall.unique_id, hall.active)">
                                    <label class="custom-control-label" :for="hall.unique_id"></label>
                                </div>
                                </td>
                                <td class="text-md-right">
                                    <button class="btn btn-secondary btn-sm" @click="goToHall(hall.unique_id)" v-text="trans('Edit')"></button>
<!--                                    <button class="btn btn-danger btn-sm" @click="goToHall(hall.unique_id)" v-text="trans('Delete')"></button>-->
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <p class="h3 p-3" v-else v-text="trans('Nothing to show')"></p>
                        </transition>

                        <form method="POST" action="/hall" @submit.prevent="createHall" @keydown="errors.clear($event.target.name)">
                            <div class="d-sm-flex">
                                <div class="col-5">
                                    <input class="form-control mb-2"
                                           id="name" name="name" type="text"
                                           v-model="name"
                                           v-bind:class="{ 'is-invalid': errors.has('name') }"
                                           v-bind:placeholder="trans('Name')" required>
                                    <div class="invalid-feedback" v-if="errors.has('name')" v-text="errors.get('name')"></div>
                                </div>
                                <div class="col-5">
                                    <input class="form-control mb-2"
                                           id="address" name="address" type="text"
                                           v-model="address"
                                           v-bind:class="{ 'is-invalid': errors.has('address') }"
                                           v-bind:placeholder="trans('Address')" required>
                                    <div class="invalid-feedback" v-if="errors.has('address')" v-text="errors.get('address')"></div>
                                </div>
                                <div class="col-2">
                                    <button type="submit" class="btn btn-primary w-100">{{ trans('Create') }}</button>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>

    </div>

    <footer class="footer footer-black">
        <div class="container-fluid">
            <div class="pull-left">
                <a class="" href="/" v-text="trans('Back')"></a>
            </div>
            <div class="copyright pull-right">
                &copy; 2019 made with <i class="fa fa-heart heart"></i> by <a href="/">DanceZilla</a>
            </div>
        </div>
    </footer>

    </div>
</template>

<script>
    import Errors from "./utils/Errors";
    import RequestHelper from "./utils/RequestHelper";
    export default {

        mixins: [Errors, RequestHelper],
        data() {
            return {
                name: '',
                address: '',
                halls: []
            }
        },

        mounted() {
            // get halls
            axios.get('/api/halls')
                .then(response => response.data)
                .then(data => {
                    this.halls = data;
                });
        },

        methods: {
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
                axios.post('/api/hall/create', this.prepareSubmit())
                    .then(response => {
                        this.flash(this.trans('Saved'), 'success', {
                            timeout: 3000
                        });
                        this.goToHall(response.data.uuid);
                    })
                    .catch(error => {
                        this.processErr(error);
                    });
            },

            prepareSubmit(){
                return {
                    name: this.name,
                    address: this.address
                }
            }
        }
    }
</script>
