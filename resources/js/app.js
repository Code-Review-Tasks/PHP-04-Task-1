/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import { createApp } from 'vue';
import { createRouter, createWebHashHistory } from 'vue-router';
import Create from './components/Create.vue';
import Links from './components/Links.vue';
import LinksId from './components/LinksId.vue';
import Stats from './components/Stats.vue';
import StatsId from './components/StatsId.vue';
import EditLink from './components/EditLink.vue';

const routes = [
    { path: '/', component: Links },
    { path: '/stats', component: Stats },
    { path: '/stats/:id', component: StatsId },
    { path: '/links/:id', component: LinksId },
    { path: '/create', component: Create },
    { path: '/edit/:id', component: EditLink}
  ]

const router = createRouter({
    history: createWebHashHistory(),
    linkActiveClass: 'active',
    routes, // short for `routes: routes`
})


import App from './App.vue';
const app = createApp(App);

app.use(router);

//app.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//app.mount('#app');


app.mount('#app');