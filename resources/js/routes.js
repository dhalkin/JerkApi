
//import Home from './components/Home';
import Company from './components/Company';
import Halls from './components/Halls';
import HallsEditor from './components/HallsEditor';
import Trainers from './components/Trainers';
import Customers from './components/Customers';
import Profile from './components/Profile';

export default {

    mode: 'history',
    base: '/app',

    linkActiveClass: 'active',

    // scrollBehavior: (to) => {
    //     if (to.hash) {
    //         return {selector: to.hash}
    //     } else {
    //         return { x: 0, y: 0 }
    //     }
    // },

    routes:[
        // {
        //     path: '/home',
        //     component: Home
        // },
        {
            path: '/company',
            component: Company
        },
        {
            path: '/halls',
            component: Halls
        },
        {
            path: '/hall/:hallUui',
            component: HallsEditor
        },
        {
            path: '/trainers',
            component: Trainers
        },
        {
            path: '/customers',
            component: Customers
        },
        {
            path: '/profile',
            component: Profile
        }
    ]
}
