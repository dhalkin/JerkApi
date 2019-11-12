<template>
    <div class="main-panel">
        <!-- Top Navbar -->
        <top-nav-bar v-bind:csrf="this.csrf" v-bind:title="trans('User Profile')"></top-nav-bar>
        <!-- End Navbar -->

        <div class="content col-10">

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title" v-text="trans('Edit Profile')"></h4>
                </div>

                <div class="card-body">



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
        mounted() {
            console.log('Profile mounted.')
        },

    }
</script>
