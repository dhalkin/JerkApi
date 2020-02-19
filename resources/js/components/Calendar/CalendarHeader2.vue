<template>
    <div>
        <div class="row">
            <div class="col new-header-title text-primary">{{companyName}} - {{trans('Timetable')}}</div>
        </div>
        <div class="row justify-content-between">
            <div class="col-3">
                <p-button type="warning" @click="$emit('click-rules')">
                    {{trans('Rules')}}
                </p-button>
            </div>
            <div class="col-9 text-right">
                <span v-if="!userLogged">
                    <p-button type="info" @click="$emit('click-login')">
                    {{trans('Login')}}
                    </p-button>
                    <p-button type="info" @click="$emit('click-register')">
                    {{trans('Register')}}
                    </p-button>
                </span>
                <span v-else>
                    <span class="text-muted">
                        <i class="nc-icon nc-single-02"></i>
                        {{userName}} |
                    </span>
                    <p-button type="info" @click="logout">
                    {{trans('Logout')}}
                    </p-button>
                </span>

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
                                //this.$emit('user-logout');
                                this.$notify({
                                    message: this.trans('Successfully logged out'),
                                    type: 'success'
                                });
                                location.reload();
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
