import VueCarousel from '@chenfengyuan/vue-carousel';

window.Vue = require('vue');
window.Vue.component(VueCarousel.name, VueCarousel);

const app = new Vue({
    el: '#welcome',

    data: {
        // data for carousel
        carousel:[
            '<div class="carousel-slide">Always borrow money from a pessimist. He won’t expect it back.</div>',
            '<div class="carousel-slide">It is awfully hard work doing nothing.</div>',
            '<div class="carousel-slide">Be yourself, everyone else is already taken.</div>',
            '<div class="carousel-slide">Hey, want some more?</div>',
        ]
    }

});
