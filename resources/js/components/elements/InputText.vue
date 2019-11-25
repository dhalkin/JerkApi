<template>
    <div class="form-group" v-bind:class="{ 'has-danger': errors.has(name) }">
        <label v-text="capitalize(label)"></label>
        <input class="form-control"
               v-bind:id="name" v-bind:name="name" type="text"
               v-bind:value="value"
               v-on:input="$emit('input', $event.target.value)"
               v-bind:placeholder="capitalize(label)"
               v-bind:class="{ 'form-control-danger': errors.has(name) }"
               v-bind:required="required"
               @shown="focusMyElement">
    </div>
</template>

<script>
    export default {
        props: ['label', 'value', 'name', 'errors', 'required', 'setReferense'],

        computed:{
            ref: function (){
                return (this.setReferense ? this.setReferense : null);
            }
        },

        mounted: function () {
            this.focusMyElement();

        },

        methods: {
            focusMyElement(e) {
                if(this.setReferense){
                    document.getElementById(this.name).focus();
                }

            }
        }
    }
</script>
