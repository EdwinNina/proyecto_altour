require('./bootstrap');

window.Vue = require('vue');

Vue.component('dashboard-component', require('./components/DashboardComponent.vue').default);
Vue.component('category-component', require('./components/CategoryComponent.vue').default);
Vue.component('attractive-component', require('./components/AttractiveComponent.vue').default);
Vue.component('form-component', require('./components/FormComponent.vue').default);
Vue.component('table-component', require('./components/TableComponent.vue').default);

new Vue({
    el: '#app',
    data:{
        menu:0
    }
});








