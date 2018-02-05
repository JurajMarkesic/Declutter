<template>
    <div>
        <timeline-item v-for="story in stories" :story="story" :key="story.id"></timeline-item>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                stories: []
            }
        },
        methods: {
            fetchStories() {
                axios.get('/timeline/stories')
                    .then((response) => {
                        this.stories = response.data.stories;
                    })
            }
        },
        created() {
            this.fetchStories();
        }
    }
</script>

<style>

</style>