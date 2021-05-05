/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
window.VueRouter = require('vue-router').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/TaskListComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('task-list-component', require('./components/TaskListComponent.vue').default);
Vue.component('task-edit-component', require('./components/TaskEditComponent.vue').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('navbar-component', require('./components/NavbarComponent.vue').default);

const routes = [
    {path: '/task-list', component: require('./components/TaskListComponent.vue').default},
    {path: '/example', component: require('./components/ExampleComponent.vue').default},
    {path: '/login', component: require('./components/LoginComponent.vue').default},
    {path: '/sign-up', component: require('./components/RegisterComponent.vue').default}
];

const router = new VueRouter({
    mode: 'history',
    routes
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
