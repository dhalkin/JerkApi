<template>
  <navbar v-model="showNavbar">
    <div class="navbar-wrapper">
      <div class="navbar-minimize">
        <button id="minimizeSidebar" class="btn btn-icon btn-round" @click="minimizeSidebar">
          <i class="nc-icon nc-minimal-right text-center visible-on-sidebar-mini"></i>
          <i class="nc-icon nc-minimal-left text-center visible-on-sidebar-regular"></i>
        </button>
      </div>
      <div class="navbar-toggle">
        <navbar-toggle-button @click.native="toggleSidebar">

        </navbar-toggle-button>
      </div>
      <a class="navbar-brand" href="#pablo">SportStation.club</a>
    </div>

    <template slot="navbar-menu">

      <form id="logout-form" action="/logout" method="POST" style="display: none;" ref="logoutForm">
        <input type="hidden" name="_token" v-bind:value="csrf">
      </form>

      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link btn-magnify" href="#pablo">
            <i class="nc-icon nc-layout-11"></i>
            <p>
              <span class="d-lg-none d-md-block">Stats</span>
            </p>
          </a>
        </li>
        <drop-down icon="nc-icon nc-bell-55" tag="li"
                   position="right"
                   direction="none"
                   class="nav-item btn-rotate dropdown">
          <a slot="title"
             slot-scope="{isOpen}"
             class="nav-link dropdown-toggle"
             data-toggle="dropdown"
             aria-haspopup="true"
             :aria-expanded="isOpen">
            <i class="nc-icon nc-bell-55"></i>
            <p>
              <span class="d-lg-none d-md-block">Some Actions</span>
            </p>
          </a>
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <a class="dropdown-item" href="#">Something else here</a>
        </drop-down>
        <li class="nav-item">
          <a class="nav-link btn-rotate" href="#pablo">
            <i class="nc-icon nc-settings-gear-65"></i>
            <p>
              <span class="d-lg-none d-md-block">Account</span>
            </p>
          </a>
        </li>
      </ul>
      <p-button type="primary" size="sm" @click="logout">Exit</p-button>
    </template>
  </navbar>
</template>
<script>
  import { Navbar, NavbarToggleButton } from '../../../components/UIComponents'

  export default {
    refs:['logoutForm'],
    components: {
      Navbar,
      NavbarToggleButton
    },
    data() {
      return {
        activeNotifications: false,
        showNavbar: false,
        csrf: this.$root.csrf,
      }
    },
    methods: {
      logout() {
        this.$refs.logoutForm.submit();
        //console.log(this.$root.csrf)
      },
      capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1)
      },
      toggleNotificationDropDown() {
        this.activeNotifications = !this.activeNotifications
      },
      closeDropDown() {
        this.activeNotifications = false
      },
      toggleSidebar() {
        this.$sidebar.displaySidebar(!this.$sidebar.showSidebar)
      },
      hideSidebar() {
        this.$sidebar.displaySidebar(false)
      },
      minimizeSidebar() {
        this.$sidebar.toggleMinimize()
      },
      toggleNavbar() {
        this.showNavbar = !this.showNavbar;
      }
    }
  }

</script>
<style>

</style>
