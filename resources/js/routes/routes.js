import DashboardLayout from '../components/Dashboard/Layout/DashboardLayout.vue'
// GeneralViews
import NotFound from '../components/GeneralViews/NotFoundPage.vue'

// Pages
import User from '../components/App/UserProfile.vue'
import UserCompany from "../components/App/UserCompany.vue"


// Components pages
import Branches from '../components/App/Pages/Branches'
import Roles from '../components/App/Pages/Roles'
import Halls from '../components/App/Pages/Halls'
import Groups from '../components/App/Pages/Groups'
import Users from '../components/App/Pages/Users'
import Group from '../components/App/Pages/Group'

// Calendar
import Calendar from '../components/Dashboard/Views/Calendar/CalendarRoute.vue'

let peopleMenu = {
  path: '/people',
  component: DashboardLayout,
  redirect: '/people/roles',
  children: [
    {
      path: 'roles',
      name: 'Roles',
      component: Roles
    },
    {
      path: 'users',
      name: 'Users',
      component: Users
    }
  ]
}

let componentsMenu = {
  path: '/classes',
  component: DashboardLayout,
  redirect: '/classes/branches',
  children: [
    {
      path: 'branches',
      name: 'Branches',
      component: Branches
    },
    {
      path: 'branch/:uid/halls',
      name: 'Halls',
      component: Halls
    },
    {
      path: 'groups',
      name: 'Groups',
      component: Groups
    },
    {
      path: 'group/:uid',
      name: 'GroupEditor',
      component: Group
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

const routes = [
  {
    path: '/',
    component: DashboardLayout,
    redirect: '/calendar',
    children: [
      {
        path: 'calendar',
        name: 'Calendar',
        component: Calendar
      }
    ]
  },
  peopleMenu,
  componentsMenu,
  userMenu,
  {path: '*', component: NotFound}
];

export default routes
