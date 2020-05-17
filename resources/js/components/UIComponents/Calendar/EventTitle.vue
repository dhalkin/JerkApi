<template>
    <span class="group">{{group}}</span><br/>
    <span class="trainer">{{trainer}}</span><br/>
    <span class="hall">{{hall}}</span><br/>
    <span class="people-stats">{{peopleStats}}</span>
</template>
<script>
    export default {
        data() {
            return {
                group:'',
                trainer:'',
                hall:'',
                peopleStats:''
            }
        }
    }
</script>
