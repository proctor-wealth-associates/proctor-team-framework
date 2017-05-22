
// Load all dependencies.
require('./vendor/bootstrap');


// Load VueJS components.
Vue.component('input-file', require('./components/shared/form/InputFile.vue'));

// Application Vue.
const app = new Vue({
    el: '#app',
    data: {
        mobileMenuShown: false
    }
});
