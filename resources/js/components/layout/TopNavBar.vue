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

                <span class="top-create-new-form">
                  <button class="btn btn-sm btn-info" id="create-new-button"
                          data-toggle="modal" data-target="#createNewEntity">
                      <span class="btn-label">
                    <i class="nc-icon nc-button-play"></i>
                  </span>
                  {{trans('Create new')}}
                </button>
                </span>

            </div>

            <div class="row navbar-wrapper justify-content-end">

                <top-nav-lang></top-nav-lang>

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
