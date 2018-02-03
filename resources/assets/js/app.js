
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
Vue.component('profile', require('./components/Profile.vue'));
Vue.component('user-profile', require('./components/UserProfile.vue'));
Vue.component('edit-profile', require('./components/EditProfile.vue'));
Vue.component('user-story', require('./components/UserStory.vue'));
Vue.component('user-stories', require('./components/UserStories.vue'));
Vue.component('followers', require('./components/Followers.vue'));
Vue.component('followings', require('./components/Followings.vue'));
Vue.component('tiny-followee', require('./components/TinyFollowee.vue'));
Vue.component('tiny-follower', require('./components/TinyFollower.vue'));
Vue.component('admin', require('./components/Admin.vue'));
Vue.component('category', require('./components/Category.vue'))
Vue.component('category-items', require('./components/CategoryItems.vue'));
Vue.component('category-item', require('./components/CategoryItem.vue'));



export const eventBus = new Vue();

// export const store = {
//
// };

const app = new Vue({
    el: '#app'
});
