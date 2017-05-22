
// Load all dependencies.
require('./vendor/bootstrap');

// Landing page Vue.
const app = new Vue({
    el: '#landing > .pusher',
    data: {
        mobileMenuShown: false
    }
});
