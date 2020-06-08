require('./bootstrap');

window.Vue = require('vue');
window.Swal = require('sweetalert2');

import VueHasErrorLaravel from 'vue-has-error-laravel';
import fullCalendar from 'vue-fullcalendar';

Vue.use(VueHasErrorLaravel);
Vue.component('full-calendar',fullCalendar);

Vue.component('form-component', require('./components/FormComponent.vue').default);
Vue.component('table-component', require('./components/TableComponent.vue').default);
Vue.component('dashboard-component', require('./components/DashboardComponent.vue').default);
Vue.component('category-component', require('./components/CategoryComponent.vue').default);
Vue.component('attractive-component', require('./components/AttractiveComponent.vue').default);
Vue.component('place-component', require('./components/PlaceComponent.vue').default);
Vue.component('activity-component', require('./components/ActivityComponent.vue').default);
Vue.component('user-component', require('./components/UserComponent.vue').default);
Vue.component('calendar-component', require('./components/CalendarActivityComponent.vue').default);
Vue.component('role-component', require('./components/RoleComponent.vue').default);
Vue.component('tourist-component', require('./components/TouristComponent.vue').default);

new Vue({
    el: '#app',
    data:{
        menu:0
    }
});








