<template>
    <div class="main-panel">
        <!-- Top Navbar -->
        <top-nav-bar v-bind:csrf="this.csrf" v-bind:title="trans('User Profile')"></top-nav-bar>
        <!-- End Navbar -->

        <div class="content">

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" v-text="trans('Edit Profile')"></h4>
                </div>

                <div class="card-body">

                    <form method="POST" name="profile" action="#" @submit.prevent="onSubmit" @keydown="errors.clear($event.target.name)">
                        <div class="row">
                            <div class="col">
                                <input-text
                                    v-bind:label="trans('First Name')"
                                    v-model.trim="user.first_name"
                                    v-bind:errors="errors"
                                    name="first_name">
                                </input-text>
                            </div>
                            <div class="col">
                                <input-text
                                    v-bind:label="trans('Second Name')"
                                    v-model.trim="user.second_name"
                                    v-bind:errors="errors"
                                    name="second_name">
                                </input-text>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input-text
                                    v-bind:label="trans('Phone')"
                                    v-model.trim="user.phone"
                                    v-bind:errors="errors"
                                    name="phone">
                                </input-text>
                            </div>
                            <div class="col">
                                <input-text
                                    v-bind:label="trans('Email')"
                                    v-model.trim="user.email"
                                    v-bind:errors="errors"
                                    name="email"
                                    required="required">
                                </input-text>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>

    </div>
</template>

<script>

    import Errors from "./utils/Errors";
    import RequestHelper from "./utils/RequestHelper";
    import TopNavBar from "./layout/TopNavBar";
    import FooterBar from "./layout/FooterBar";
    import InputText from "./elements/InputText";

    export default {
        components: {TopNavBar, FooterBar, InputText},
        mixins: [Errors, RequestHelper, TopNavBar],

        data() {
            return {
                user:{first_name:'', second_name:'', phone:'', email:''}
            }
        },

        mounted() {
            console.log('Profile mounted.')
        },

    }
</script>
