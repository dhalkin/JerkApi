<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        {{ trans('Branches') }}
                    </div>

                    <div class="card-body">

                        <transition>
                        <table class="table" v-if="this.branches.length > 0">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">{{trans('Name')}}</th>
                                <th scope="col">{{trans('Address')}}</th>
                                <th scope="col">Handle</th>
                            </tr>
                            </thead>
                            <tbody>

                            <tr v-for="branch in this.branches">
                                <td>
                                    {{branch.name}}
                                </td>
                                <td>
                                    {{branch.address}}
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary">
                                        <span class="glyphicon glyphicon-plus"></span>
                                        {{ trans('Create') }}
                                    </button>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                        <p class="h3" v-else>{{trans('Nothing to show')}}</p>
                        </transition>


                        <form>
                            <div class="row">
                                <div class="col-5">
                                    <input class="form-control mb-2"
                                           id="name" name="name" type="text"
                                           v-bind:placeholder="trans('Name')">
                                </div>
                                <div class="col-5">
                                    <input class="form-control mb-2"
                                           id="address" name="address" type="text"
                                           v-bind:placeholder="trans('Address')">
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
    export default {

        props: ['apiToken'],

        data() {
            return {
                name: '',
                address: '',
                branches: [],
               // errors: new Errors()
            }
        },

        mounted() {

        },

        created() {

            axios.defaults.headers.common['Authorization'] = 'Bearer '+ this.apiToken;

            // get branches
            axios.get('/api/branches')
                .then(response => response.data)
                .then(data => {
                    this.branches = data;
                });

        }

    }
</script>
