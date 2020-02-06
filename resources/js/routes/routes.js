import DashboardLayout from '../components/Dashboard/Layout/DashboardLayout.vue'
// GeneralViews
import NotFound from '../components/GeneralViews/NotFoundPage.vue'
// Dashboard pages
const Overview = () => import(/* webpackChunkName: "widgets" */ '../components/Dashboard/Views/Dashboard/Overview.vue')
const Widgets = () => import(/* webpackChunkName: "widgets" */ '../components/Dashboard/Views/Dashboard/Widgets.vue')

// Pages
import User from '../components/App/UserProfile.vue'
import UserCompany from "../components/App/UserCompany.vue"

//import User from '../components/Dashboard/Views/Pages/Forms.vue'
import TimeLine from '../components/Dashboard/Views/Pages/TimeLinePage.vue'
import Login from '../components/Dashboard/Views/Pages/Login.vue'
import Register from '../components/Dashboard/Views/Pages/Register.vue'
import Lock from '../components/Dashboard/Views/Pages/Lock.vue'

// Components pages
import Buttons from '../components/Dashboard/Views/Components/Buttons.vue'
import GridSystem from '../components/Dashboard/Views/Components/GridSystem.vue'
import Panels from '../components/Dashboard/Views/Components/Panels.vue'
import SweetAlert from '../components/Dashboard/Views/Components/SweetAlert.vue'
import Notifications from '../components/Dashboard/Views/Components/Notifications.vue'
import Icons from '../components/Dashboard/Views/Components/Icons.vue'
import Typography from '../components/Dashboard/Views/Components/Typography.vue'

// Forms pages
const RegularForms  = () => import(/* webpackChunkName: "forms" */ '../components/Dashboard/Views/Forms/RegularForms.vue')
const ExtendedForms = () => import(/* webpackChunkName: "forms" */ '../components/Dashboard/Views/Forms/ExtendedForms.vue');
const ValidationForms = () => import(/* webpackChunkName: "forms" */ '../components/Dashboard/Views/Forms/ValidationForms.vue')
const Wizard = () => import(/* webpackChunkName: "forms" */ '../components/Dashboard/Views/Forms/Wizard.vue');

// TableList pages
const RegularTables = () => import(/* webpackChunkName: "tables" */ '../components/Dashboard/Views/Tables/RegularTables.vue')
const ExtendedTables = () => import(/* webpackChunkName: "tables" */ '../components/Dashboard/Views/Tables/ExtendedTables.vue')
const PaginatedTables = () => import(/* webpackChunkName: "tables" */ '../components/Dashboard/Views/Tables/PaginatedTables.vue')
// Maps pages
const GoogleMaps = () => import(/* webpackChunkName: "maps" */ '../components/Dashboard/Views/Maps/GoogleMaps.vue')
const FullScreenMap = () => import(/* webpackChunkName: "maps" */ '../components/Dashboard/Views/Maps/FullScreenMap.vue')
const VectorMaps = () => import(/* webpackChunkName: "maps" */ '../components/Dashboard/Views/Maps/VectorMapsPage.vue')

// Calendar
import Calendar from '../components/Dashboard/Views/Calendar/CalendarRoute.vue'
// Charts
const Charts = () => import(/* webpackChunkName: "widgets" */ '../components/Dashboard/Views/Charts.vue')

let componentsMenu = {
  path: '/components',
  component: DashboardLayout,
  redirect: '/components/buttons',
  children: [
    {
      path: 'buttons',
      name: 'Buttons',
      component: Buttons
    },
    {
      path: 'grid-system',
      name: 'Grid System',
      component: GridSystem
    },
    {
      path: 'panels',
      name: 'Panels',
      component: Panels
    },
    {
      path: 'sweet-alert',
      name: 'Sweet Alert',
      component: SweetAlert
    },
    {
      path: 'notifications',
      name: 'Notifications',
      component: Notifications
    },
    {
      path: 'icons',
      name: 'Icons',
      component: Icons
    },
    {
      path: 'typography',
      name: 'Typography',
      component: Typography
    }

  ]
}

let formsMenu = {
  path: '/forms',
  component: DashboardLayout,
  redirect: '/forms/regular',
  children: [
    {
      path: 'regular',
      name: 'Regular Forms',
      component: RegularForms
    },
    {
      path: 'extended',
      name: 'Extended Forms',
      component: ExtendedForms
    },
    {
      path: 'validation',
      name: 'Validation Forms',
      component: ValidationForms
    },
    {
      path: 'wizard',
      name: 'Wizard',
      component: Wizard
    }
  ]
}

let tablesMenu = {
  path: '/table-list',
  component: DashboardLayout,
  redirect: '/table-list/regular',
  children: [
    {
      path: 'regular',
      name: 'Regular Tables',
      component: RegularTables
    },
    {
      path: 'extended',
      name: 'Extended Tables',
      component: ExtendedTables
    },
    {
      path: 'paginated',
      name: 'Paginated Tables',
      component: PaginatedTables
    }]
}

let mapsMenu = {
  path: '/maps',
  component: DashboardLayout,
  redirect: '/maps/google',
  children: [
    {
      path: 'google',
      name: 'Google Maps',
      component: GoogleMaps
    },
    {
      path: 'full-screen',
      name: 'Full Screen Map',
      component: FullScreenMap
    },
    {
      path: 'vector-map',
      name: 'Vector Map',
      component: VectorMaps
    }
  ]
}

let pagesMenu = {
  path: '/pages',
  component: DashboardLayout,
  redirect: '/pages/user',
  children: [
    {
      path: 'user',
      name: 'User Page',
      component: User
    },
    {
      path: 'timeline',
      name: 'Timeline Page',
      component: TimeLine
    }
  ]
}

let userMenu = {
  path: '/user',
  component: DashboardLayout,
  redirect: '/user/profile',
  children: [
    {
      path: 'profile',
      name: 'User Profile',
      component: User
    },
    {
      path: 'company',
      name: 'User Company',
      component: UserCompany
    }
  ]
}

let loginPage = {
  path: '/login',
  name: 'Login',
  component: Login
}

let registerPage = {
  path: '/register',
  name: 'Register',
  component: Register
}

let lockPage = {
  path: '/lock',
  name: 'Lock',
  component: Lock
}

const routes = [
  {
    path: '/',
    component: DashboardLayout,
    redirect: '/admin/overview',
    children: [
      {
        path: 'calendar',
        name: 'Calendar',
        component: Calendar
      },
      {
        path: 'charts',
        name: 'Charts',
        component: Charts
      }
    ]
  },
  componentsMenu,
  formsMenu,
  tablesMenu,
  mapsMenu,
  pagesMenu,
  loginPage,
  registerPage,
  lockPage,
  {
    path: '/admin',
    component: DashboardLayout,
    redirect: '/admin/overview',
    children: [
      {
        path: 'overview',
        name: 'Overview',
        component: Overview
      },
      {
        path: 'widgets',
        name: 'Widgets',
        component: Widgets
      }
    ]
  },
  userMenu,
  {path: '*', component: NotFound}
];

export default routes
