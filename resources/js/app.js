require('./bootstrap');

import Vue            from 'vue';


Vue.component('OrderCreate', require('./views/pages/Orders.vue').default);

const app = new Vue({
    el: "#app",
    data() {
        return {
        }
    },
    methods: {
        //
    },
});
