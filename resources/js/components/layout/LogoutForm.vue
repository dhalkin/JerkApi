<template>
    <div>
        <a class="nav-link btn-magnify" href="#" @click="letItGo($event)">
            <i class="nc-icon nc-button-power"></i>
            <p>
                <span class="d-lg d-md-block" v-text="trans('Logout')"></span>
            </p>
        </a>
        <form id="logout-form" action="/logout" method="POST" style="display: none;">
            <input type="hidden" name="_token" v-bind:value=csrf>
        </form>
    </div>
</template>
<script>

    export default {
        props: ['csrf'],

        methods: {
            letItGo(e) {
                e.preventDefault();
                document.getElementById('logout-form').submit();
            }
        }
    }
</script>
