<template>
    <div>
        <user-story v-for="story in stories" :story="story" :user="user" :isLogged="isLoggedIn" :key="story.id"></user-story>
    </div>
</template>

<script>
    export default {
        props: [
            'stories', 'isLoggedIn', 'user'
        ],

    }
</script>

<style>

</style>