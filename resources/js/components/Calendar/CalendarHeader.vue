<template>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col">
                    <span class="h3" v-text="companyName"></span>
                    <span v-text="trans('Timetable')"></span>
                </div>
                <div class="col">
                    <div class="justify-content-end show pull-right">
                        <span v-if="!userLogged">
                        <ul class="navbar-nav" style="flex-direction: row">
                            <li class="nav-item">
                                <a href="" class="nav-link pr-3"
                                   @click.prevent="$emit('click-login')"
                                >
                                    <i class="nc-icon nc-tap-01"></i><strong>{{trans('Login')}}</strong>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link pr-3"
                                   @click.prevent="$emit('click-register')"
                                >
                                    <i class="nc-icon nc-book-bookmark"></i> <strong>{{trans('Register')}}</strong>
                                </a>
                            </li>
                        </ul>
                        </span>
                        <span v-else>
                            <ul class="navbar-nav" style="flex-direction: row">
                                <li class="nav-item">

                                   <a href="" class="nav-link disabled pr-3"
                                      @click.prevent
                                   >
                                       <i class="nc-icon nc-tap-01"></i> <strong>{{userName}}</strong>
                                    </a>

                                </li>
                                <li class="nav-item">
                                    <a href="" class="nav-link"
                                       @click.prevent="logout"
                                    >
                                        <i class="nc-icon nc-user-run"></i> <strong>{{trans('Logout')}}</strong>
                                    </a>
                                </li>
                            </ul>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

    import ErrorHelper from "../utils/ErrorHelper";

    export default {
        mixins: [ErrorHelper],
        props: ['companyName', 'userLogged', 'userName'],
        data() {
            return {
            }
        },
        methods: {
            logout() {

                this.$swal({
                    title: this.trans('Want to log out?'),
                    type: 'question',
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success btn-fill',
                    cancelButtonClass: 'btn btn-danger btn-fill',
                    confirmButtonText: this.trans('Yes, good to go!'),
                    cancelButtonText: this.trans('Cancel'),
                    buttonsStyling: true,
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {

                        axios.post('/logout-again')
                            .then(response => {
                                this.$emit('user-logout');
                                this.$notify({
                                    message: this.trans('Successfully logged out'),
                                    type: 'success'
                                });

                            })
                            .catch(error => {
                                this.processErr(error);
                            });

                    }
                });
            }
        }
    }
</script>
