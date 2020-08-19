import Vue from 'vue'
import vuetify from './plugins/vuetify';

// import the vuex for multi component communication
import Master from '@/components/Layouts/Master';
//icons import
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import '@/assets/css/boilerplate.css'
import '@/assets/css/app.css'
// define vue router
import router from './router';

// import the master component

import Vuex from 'vuex';
Vue.use(Vuex);
import store  from './store/store';

// vue validations
import Vuelidate from 'vuelidate';
Vue.use(Vuelidate);

// loading overlay
import 'vue-loading-overlay/dist/vue-loading.css';
import Loading from 'vue-loading-overlay';
Vue.use(Loading);

//sweetalert
import 'sweetalert2/dist/sweetalert2.min.css';
import VueSweetalert2 from 'vue-sweetalert2';
Vue.use(VueSweetalert2);

//axios
import axios from 'axios';
import VueAxios from 'vue-axios';
Vue.use(VueAxios, axios);

//charts
import VueApexCharts from 'vue-apexcharts';
Vue.component('apexchart', VueApexCharts);

//json to excel
import JsonExcel from 'vue-json-excel';
Vue.component('downloadExcel', JsonExcel);

Vue.config.productionTip = false;

new Vue({
	el: '#app',
	vuetify,
	render: h => h(Master),
	store,
	router,
	components: { Master },
	template: '<Master/>'
})

export default store;
