<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        {{ trans('Trainers')}}
                    </div>

                    <div class="card-body">
                        <fieldset>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Trainers mounted.')
        }
    }
</script>
