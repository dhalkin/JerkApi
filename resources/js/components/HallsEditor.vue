<template>
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-10">

                <div class="card bg-light mb-3">
                    <div class="card-header text-left h5" v-text="trans('Hall') + ' - ' + this.hall.name"></div>

                    <div class="card-body">
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
            hall:''
        }
    },

    computed: {
        uniqueId() {
            // We will see what `params` is shortly
            return this.$route.params.hallUui
        }
    },

    mounted() {
        axios.defaults.headers.common['Authorization'] = 'Bearer '+ this.apiToken;

        // get
        axios.get('/api/hall/' + this.uniqueId)
            .then(response => {
                this.hall = response.data
            });

    },

    created() {

    },

    methods:{


    }
    }

    // that's something...
    class Errors {

        constructor() {
            this.errors = {};
        }

        get(field) {
            if (this.errors[field]) {
                return this.errors[field][0];
            }
        }

        has(field){
            return this.errors.hasOwnProperty(field);
        }

        any(){
            return Object.keys(this.errors).length > 0;
        }

        record(errors) {
            this.errors = errors;
        }

        clear(field) {
            delete this.errors[field]
        }

        clearAll(){
            this.errors = {};
        }
    }

</script>
