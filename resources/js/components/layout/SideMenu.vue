<template>
    <div class="sidebar" data-color="brown" data-active-color="danger">
        <div class="sidebar-wrapper">
            <div class="logo text-md-center font-weight-bold">
                <a v-bind:href="appUrl" class="simple-text logo-normal" v-text="appName"></a>
            </div>
            <!--  -->
            <ul class="nav">
                <li>
                    <router-link name="Company" to="/company">
                        <i class="nc-icon nc-single-02"></i>
                        <p v-text="trans('My Company')"></p>
                    </router-link>
                </li>
                <li>
                    <router-link name="Halls" to="/halls">
                        <i class="nc-icon nc-single-02"></i>
                        <p v-text="trans('Halls')"></p>
                    </router-link>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['appUrl', 'appName'],

        data() {
            return {
                items: []
            }
        },

        created() {
            this.$router.options.routes.forEach(route => {
                this.items.push({
                    name: route.name,
                    path: route.path
                })
            })
        },

        mounted() {
            // set current active
            $('a[name="' + this.$router.history.current.name + '"]').parent('li').addClass('active');
            this.$router.afterEach((to, from) => {

                $('a[name="' + from.name + '"]').parent('li').removeClass('active');
                $('a[name="' + to.name + '"]').parent('li').addClass('active');

                // deal with toggler
                if (paperDashboard.misc.navbar_menu_visible == 1) {
                    $('html').removeClass('nav-open');
                    paperDashboard.misc.navbar_menu_visible = 0;
                    setTimeout(function() {
                        $('.navbar-toggle').removeClass('toggled');
                        $('#bodyClick').remove();
                    }, 550);

                }
            })
        },

    }
</script>
