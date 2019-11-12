<template>
    <div>
        <label v-text="capitalize(label)"></label>
        <input class="form-control mb-2"
               v-bind:id="name" v-bind:name="name" type="text"
               v-bind:value="value"
               v-on:input="$emit('input', $event.target.value)"
               v-bind:class="{ 'is-invalid': errors.has(name) }"
               v-bind:placeholder="capitalize(label)"
               v-bind:required="required">
        <div class="invalid-feedback" v-if="errors.has(name)" v-text="errors.get(name)"></div>
    </div>
</template>

<script>
    export default {
        props: ['label', 'value', 'name', 'errors', 'required']
    }
</script>
