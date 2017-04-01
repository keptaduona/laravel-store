
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import VueRouter from 'vue-router';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(VueRouter);


const router = new VueRouter({
    mode: 'history'
});

new Vue({
    el: '#app',

    router,

    data: {

    },

    components: {
        'create': require('./components/admin/manage/Create.vue'),
        'products': require('./components/admin/manage/Products.vue'),
        'update': require('./components/admin/manage/Update.vue'),

    },

    methods: {

    }
});

$(document).ready(function() {

    $(".update").click(function() {
        window.location.href = "/admin/update?id=" + $(this).parent().attr('id');
    });

    $(".delete").click(function() {
        axios.post('/admin/products/delete', {
            id: $(this).parent().attr('id')
        })
        .then(reponse => window.location.href = "/admin?deleted=true");
    });

    if(getQueryStringValue('updated')) {
        $('.updated').show();
    }

    if(getQueryStringValue('deleted')) {
        $('.deleted').show();
    }

    function getQueryStringValue (key) {
        return decodeURIComponent(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + encodeURIComponent(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));
    }

    $("#content-slider").lightSlider({
        loop:true,
        keyPress:true
    });
    $('#image-gallery').lightSlider({
        gallery:true,
        item:1,
        thumbItem:9,
        slideMargin: 0,
        speed:500,
        auto:true,
        loop:true,
        onSliderLoad: function() {
            $('#image-gallery').removeClass('cS-hidden');
        }
    });

    if ($(document).height() <= $(window).height()) {
        $(".footer").show();
    }

    $('#content-slider li').click(function() {
        window.location.href = "/store?product=" + $(this).attr('id');
    });

    $(window).scroll(function() {
      if ($(this).scrollTop() < $(document).height() - $(window).height()) {
        $(".footer").slideUp();
          }
      else {
        $(".footer").slideDown();
          }
    });


});
