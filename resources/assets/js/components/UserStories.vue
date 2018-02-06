<template>
    <div>
        <user-story v-for="story in reverseStories" :story="story" :user="user" :isLogged="isLoggedIn" :key="story.id"></user-story>
    </div>
</template>

<script>
    export default {
        props: [
            'stories', 'isLoggedIn', 'user'
        ],
        computed: {
            reverseStories() {
                return this.stories.slice().reverse();
            }
        }

    }
</script>

<style>

</style>