/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import { createApp } from 'vue';
import CryptoAnalyzer from './components/Crypto/Analyzer.vue';
import Backtest from './components/Crypto/Backtest.vue';
import Superadmin from './components/Dashboard/Superadmin.vue';
import Superadmin_branch from './components/Dashboard/Superadmin_branch.vue';
import BasefunctionTikets from './components/Basefunctions/Tikets.vue';
import Patdashboard from './components/Patient/Patdashboard.vue';
import patascustomer from './components/Patient/patascustomer.vue';
import affiliate from './components/Affiliate/affiliate.vue';
import shafateldashboard from './components/Dashboard/Shafatel_dashboard.vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({})
    .component('CryptoAnalyzer', CryptoAnalyzer)
    .component('Backtest', Backtest)
    .component('Superadmin', Superadmin)
    .component('Superadmin_branch', Superadmin_branch)
    .component('BasefunctionTikets', BasefunctionTikets)
    .component('Patdashboard', Patdashboard)
    .component('patascustomer', patascustomer)
    .component('affiliate', affiliate)
    .component('shafatel_dashboard', shafateldashboard)
    .mount('#app')

const alertapp = createApp({})
    .component('BasefunctionTikets', BasefunctionTikets)
    .mount('#myapp')




/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

