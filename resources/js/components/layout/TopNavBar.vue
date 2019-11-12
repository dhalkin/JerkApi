<template>
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
                <span class="navbar-brand" v-text="this.title"></span>
            </div>

            <div class="row navbar-wrapper justify-content-end">

                <top-nav-lang></top-nav-lang>

                <a class="nav-link btn-magnify" href="/app/profile">
                    <i class="nc-icon nc-circle-10"></i>
                    <p>
                        <span class="d-lg d-md-block" v-text="trans('Profile')"></span>
                    </p>
                </a>

                <logout-form v-bind:csrf="this.csrf"></logout-form>

            </div>

        </div>
    </nav>
</template>

<script>

    import LogoutForm from "./LogoutForm";
    import TopNavLang from "./TopNavLang";

    export default {
        props: ['csrf', 'title'],
        components: {LogoutForm, TopNavLang},
    }
</script>
