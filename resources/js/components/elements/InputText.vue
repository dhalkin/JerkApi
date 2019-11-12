<template>
    <div class="form-group" v-bind:class="{ 'has-danger': errors.has(name) }">
        <label v-text="capitalize(label)"></label>
        <input class="form-control"
               v-bind:id="name" v-bind:name="name" type="text"
               v-bind:value="value"
               v-on:input="$emit('input', $event.target.value)"
               v-bind:placeholder="capitalize(label)"
               v-bind:class="{ 'form-control-danger': errors.has(name) }"
               v-bind:required="required">
    </div>
</template>

<script>
    export default {
        props: ['label', 'value', 'name', 'errors', 'required']
    }
</script>
