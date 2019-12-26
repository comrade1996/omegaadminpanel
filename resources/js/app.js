/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import {Form, HasError, AlertError} from 'vform'
import moment from 'moment'
import VueInternationalization from 'vue-i18n';
import Locale from './vue-i18n-locales.generated';

Vue.use(VueInternationalization);

const lang = document.documentElement.lang.substr(0, 2);
// or however you determine your current app locale

const i18n = new VueInternationalization({
    locale: lang,
    messages: Locale
});


Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
window.Form = Form;
import VueRouter from 'vue-router';

Vue.use(VueRouter);
import SmartTable from 'vuejs-smart-table'
Vue.use(SmartTable)
import Print from 'vue-print-nb'

Vue.use(Print);
import VueToastr2 from 'vue-toastr-2'
import 'vue-toastr-2/dist/vue-toastr-2.min.css'
window.toastr = require('toastr')
Vue.use(VueToastr2)


import Vue from 'vue'
import VueSpinners from 'vue-spinners'
Vue.use(VueSpinners)
/*
Vue.toasted.register('quantity', 'Oops.. Not enugh stock..', {
    theme: "bubble",
    fullWidth:true,
    duration:800
})*/
import VueProgressBar from 'vue-progressbar';

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '20px'
});

import swal from 'sweetalert2';

window.swal = swal;

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

window.toast = toast;

const routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/saledetails', component: require('./components/SaleDetails.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/categories', component: require('./components/Categories.vue').default },
    { path: '/developer', component: require('./components/Developer.vue').default },
    { path: '/products', component: require('./components/Products.vue').default },
    { path: '/expenses', component: require('./components/Expenses.vue').default },
    { path: '/units', component: require('./components/Units.vue').default },
    { path: '/sales', component: require('./components/Sales.vue').default },
    { path: '/expensescategories', component: require('./components/ExpensesCategories.vue').default },
    { path: '/missingitems', component: require('./components/MissingItems.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/pos', component: require('./components/POS.vue').default },
    { path: '/', component: require('./components/POS.vue').default }
  ];
const router = new VueRouter({
    mode: 'history',
    routes
});

Vue.filter('capitalize', function (value) {
    if (!value) return '';
    value = value.toString();
    return value.charAt(0).toUpperCase() + value.slice(1);
});

Vue.filter('readableDate', function (date) {
    return moment(date).format("MMM Do YY");
});

let Fire = new Vue();
window.Fire = Fire;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('pagination', require('laravel-vue-pagination'));

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    i18n,
    data:{
        search:''
    },
    methods:{
        searchit:_.debounce(()=>
        {
            Fire.$emit('searching')
        },500)
    }
});

