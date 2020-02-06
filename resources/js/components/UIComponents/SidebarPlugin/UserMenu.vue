<template>
  <div class="user">
    <div class="photo">
      <img src="/static/img/faces/face-0.jpg" alt="user avatar"/>
    </div>
    <div class="info">
      <a data-toggle="collapse" :aria-expanded="!isClosed" @click="toggleMenu" href="#">
         <span>
           {{userName}}
           <b class="caret"></b>
        </span>
      </a>
      <div class="clearfix"></div>
      <div>
        <collapse-transition>
          <ul class="nav nav-menu" v-show="!isClosed">
            <li>
              <router-link  name="User profile" to="/user/profile">
                <span class="sidebar-mini-icon">Mp</span>
                <span class="sidebar-normal" v-text="trans('My Profile')"></span>
              </router-link>
            </li>
            <li>
              <router-link  name="User Company" to="/user/company">
                <span class="sidebar-mini-icon">Mc</span>
                <span class="sidebar-normal" v-text="trans('My Company')"></span>
              </router-link>
            </li>
          </ul>
        </collapse-transition>
      </div>
    </div>
  </div>
</template>
<script>
  import { CollapseTransition } from 'vue2-transitions'

  export default {
    components: {
      CollapseTransition
    },
    data() {
      return {
        isClosed: true,
        userName: this.$root.userName
      }
    },
    methods: {
      toggleMenu() {
        this.isClosed = !this.isClosed
      }
    }
  }
</script>
<style scoped>
  .nav.nav-menu {
    margin-top: 0;
  }
</style>
