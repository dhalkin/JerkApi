<template>
    <div>
        <div class="row mb-2">
            <div class="col-4 text-right">{{this.trans('Beginning')}}</div>
            <div class="col text-left">{{this.capitalize(eventCard.startDate)}}</div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                eventCard: {
                    startDate:''
                }
            }
        }
    }
</script>
