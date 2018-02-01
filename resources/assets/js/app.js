
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('item', require('./components/Item.vue'));
Vue.component('story', require('./components/Story.vue'));
Vue.component('stories', require('./components/Stories.vue'));
Vue.component('create-story', require('./components/CreateStory.vue'));
Vue.component('search-results', require('./components/SearchResults.vue'));
Vue.component('result', require('./components/Result.vue'));


export const eventBus = new Vue();

const app = new Vue({
    el: '#app'
});
