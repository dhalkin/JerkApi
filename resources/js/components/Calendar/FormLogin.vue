<template>
    <form @submit.prevent ref="goLogin" method="post" action="/fakelogin">
    <div class="row">
        <div class="col">

            <fg-input
                v-bind:label="trans('Phone')"
                required
                name="tel"
                v-model="model.tel"
                v-validate="modelValidations.tel"
                :error="getErrorPhone()"
                autocomplete="on"
            >
            </fg-input>

            <fg-input
                v-bind:placeholder="trans('Enter Password')"
                v-bind:label="trans('Password')"
                type="password"
                required
                name="password"
                v-model="model.password"
                v-validate="modelValidations.password"
                :error="getError('password')"
                autocomplete="on"
            >
            </fg-input>

            <p-button
                type="primary" block
                v-text="trans('Login')"
                class="mt-4"
                @click="validate"
            >
            </p-button>

        </div>
    </div>
    </form>
</template>

<script>

    //import {mask} from 'vue-the-mask'
    import ErrorHelper from "../utils/ErrorHelper";

    export default {
        props:['companyUid'],
        mixins: [ErrorHelper],
       // directives: {mask},
        data(){
            return{
                model: {
                    tel: '',
                    password: ''
                },
                modelValidations: {
                    tel: {
                        required: true,
                        min: 13,
                        max: 13
                    },
                    password: {
                        required: true,
                        min: 4
                    }
                },
                interfereValidator: false,
                interfereValidatorMessage: null,
                uaNumbers: ['38094', '38092', '38091', '38063', '38093', '38099', '38095', '38066', '38050', '38098',
                    '38097', '38096', '38068', '38067', '38039']
            }
        },
        methods: {
            getError(fieldName) {
                return this.errors.first(fieldName)
            },
            getErrorPhone() {
                let err = this.getError('tel')
                let message = this.trans('Only Ukrainian phone numbers')

                if(this.interfereValidator){
                    return (this.interfereValidatorMessage) ? this.interfereValidatorMessage : message
                }else{
                    return err ? message : '' //err.replace(/[^+\d]/g, '-');
                }
            },
            validate() {
                this.$validator.validateAll().then(isValid => {
                    if (isValid) {
                        if(this.whatIsWrongWithNumber() === false){
                            this.login()
                        }

                    }
                })
            },
            prepareData() {
                return {
                    phone: this.model.tel.replace(/[^\d]/g, ''),
                    password: this.model.password,
                    companyUid: this.companyUid
                }
            },
            login() {
                this.$emit('wannaCloseModal');
                axios.post('/login-again', this.prepareData())
                    .then(response => {
                        this.model = { tel: '', password: ''};
                        this.$validator.reset();
                        this.$refs.goLogin.submit();
                        this.$notify({
                            message: this.trans('Successfully logged'),
                            type: 'success'
                        });

                    })
                    .catch(error => {
                        this.$emit('wannaOpenModal');
                        this.interfereValidatorMessage = error.response.data.message;
                        this.interfereValidator = true;
                        this.hideInterfereValidator();
                        this.processErr(error);
                    });

            },
            whatIsWrongWithNumber() {
                let num = this.model.tel.replace(/[^\d]/g, '');
                let enteredNum = num.slice(0, 5);
                if (this.uaNumbers.includes(enteredNum) == false) {
                    this.interfereValidator = true
                    this.hideInterfereValidator()
                } else {

                    return false;
                }

                return true
            },
            hideInterfereValidator() {
                setTimeout(
                    () => {
                        this.interfereValidator = false;
                        this.interfereValidatorMessage = null;
                    },
                    4 * 1000
                )
            }
        }
    }
</script>
