<template>
    <div>
        <user-story v-for="story in stories" :story="story" :key="story.id"></user-story>
    </div>
</template>

<script>
    export default {
        props: [
            'stories'
        ],
    }
</script>

<style>

</style>