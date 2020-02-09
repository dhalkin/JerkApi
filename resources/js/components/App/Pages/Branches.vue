<template>
  <div class="container-fluid">
    <h4 class="card-title" v-text="trans('Branches')"></h4>

    <div class="places-sweet-alerts">
      <div class="row">
        <div class="col-md-3">
          <card card-body-classes="text-center">
              <p class="card-text">Basic example</p>
              <p-button type="default" round outline @click="">Try me!</p-button>
          </card>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

  import {Button, Card} from '../../../components/UIComponents'
  export default {
    components: {
      [Button.name]: Button,
      Card
    }
  }
</script>
<style>
</style>
