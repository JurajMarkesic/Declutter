<template>
    <div>
        <user-story v-for="story in stories" :story="story" :isLogged="isLoggedIn" :key="story.id"></user-story>
    </div>
</template>

<script>
    export default {
        props: [
            'stories', 'isLoggedIn'
        ],

    }
</script>

<style>

</style>