<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 ml-auto mr-auto">
                <div class="card">
                    <div class="card-body">
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
                                                <i class="nc-icon nc-tap-01"></i> {{trans('Login')}}
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="" class="nav-link pr-3"
                                               @click.prevent="$emit('click-register')"
                                            >
                                                <i class="nc-icon nc-book-bookmark"></i> {{trans('Register')}}
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
                                                    <i class="nc-icon nc-tap-01"></i> {{userName}}
                                                </a>

                                            </li>
                                            <li class="nav-item">
                                                <a href="" class="nav-link"
                                                   @click.prevent="logout"
                                                >
                                                    <i class="nc-icon nc-user-run"></i> {{trans('Logout')}}
                                                </a>
                                            </li>
                                        </ul>
                                    </span>
                                </div>
                            </div>
                        </div>
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
                    confirmButtonText: 'Yes, good to go!',
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
