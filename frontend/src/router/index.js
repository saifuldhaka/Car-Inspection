import Vue from 'vue';
import Vuex from 'vuex'
import Router from 'vue-router';


import welcome from '@/components/Views/Inspection/welcome';
import bookingList from '@/components/Views/Inspection/booking_list';
import bookingCreate from '@/components/Views/Inspection/create_booking';



import router from '@/router';
import store  from '@/store/store';

Vue.use(Router);
Vue.use(Vuex);

export default new Router({
  mode :'history',
  routes: [
    {
        path: '/',
        name: 'welcome',
        component: welcome,
        meta : {
            requiresVisitor : true
        }
    },
    {
        path: '/booking-list',
        name: 'bookingList',
        component: bookingList,
        meta : {
            requiresVisitor : true
        }
    },
    {
        path: '/create-booking',
        name: 'bookingCreate',
        component: bookingCreate,
        meta : {
            requiresVisitor : true
        }
    },
    {
        path: '*',
        component: welcome
    }

  ]
})


//validating router for
router.beforeEach((to, from, next) => {
    next()
});
