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
      <span class="navbar-brand">{{companyName}}</span>
    </div>

    <template slot="navbar-menu">

      <form id="logout-form" action="/logout" method="POST" style="display: none;" ref="logoutForm">
        <input type="hidden" name="_token" v-bind:value="csrf">
      </form>

<!--      <p-button type="primary" size="sm" @click="logout">Exit</p-button>-->
      <a class="nav-link btn-magnify" href="#" @click="logout">
        <i class="nc-icon nc-button-power"></i>
        <p>
          <span class="d-lg d-md-block" v-text="trans('Logout')"></span>
        </p>
      </a>

    </template>
  </navbar>
</template>
<script>
  import { Navbar, NavbarToggleButton } from '../../../components/UIComponents'
  import swal from 'sweetalert2'

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
        companyName: this.$root.companyName
      }
    },
    methods: {
      logout() {
        swal({
          title: this.trans('Want to log out?'),
          type: 'question',
          showCancelButton: true,
          confirmButtonClass: 'btn btn-success btn-fill',
          cancelButtonClass: 'btn btn-danger btn-fill',
          confirmButtonText: this.trans('Yes, good to go!'),
          cancelButtonText: this.trans('Cancel'),
          buttonsStyling: true,
          reverseButtons: true,
        }).then(result => {
          if (result) {
            axios.get('/session')
                    .then(response => response.data)
                    .then(data => {
                      this.csrf = data.csrf
                      this.$refs.logoutForm.submit();
                    });
          }
        }).catch(swal.noop)
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
