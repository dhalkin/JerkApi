<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card bg-light mb-3">
                    <div class="card-header" v-text="trans('Halls')"></div>
                    <div class="card-body">

                        <transition>
                        <table class="table table-striped table-sm" v-if="this.halls.length > 0">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">{{trans('Name')}}</th>
                                <th scope="col">{{trans('Address')}}</th>
                                <th scope="col">Handle</th>
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
                                    <button class="btn btn-primary btn-sm" @click="goToHall(hall.unique_id)">
                                        {{ trans('Edit') }}
                                    </button>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                        <p class="h3" v-else v-text="trans('Nothing to show')"></p>
                        </transition>


                        <form method="POST" action="/hall" @submit.prevent="createHall" @keydown="errors.clear($event.target.name)">
                            <div class="d-sm-flex">
                                <div class="col-5">
                                    <input class="form-control mb-2"
                                           id="name" name="name" type="text"
                                           v-model="name"
                                           v-bind:class="{ 'is-invalid': errors.has('name') }"
                                           v-bind:placeholder="trans('Name')">
                                    <div class="invalid-feedback" v-if="errors.has('name')" v-text="errors.get('name')"></div>
                                </div>
                                <div class="col-5">
                                    <input class="form-control mb-2"
                                           id="address" name="address" type="text"
                                           v-model="address"
                                           v-bind:class="{ 'is-invalid': errors.has('address') }"
                                           v-bind:placeholder="trans('Address')">
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

            createHall(){
                this.errors.clearAll();
                axios.post('/api/hall/create', this.prepareSubmit())
                    .then(response => {
                        this.flash(this.trans('Saved'), 'success', {
                            timeout: 3000
                        });
                        this.$router.push({ path: '/hall/' + response.data.uuid});
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
