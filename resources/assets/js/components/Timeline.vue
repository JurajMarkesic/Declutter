<template>
    <div>
        <h3 class="mb-2 ml-1 pt-3" id="timelineTitle">See what people you follow got rid of</h3>


        <div v-if="!stories.length">
            <h4> No follower stories available. You should follow more people!</h4>
        </div>
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

    #timelineTitle {
        font-family: Arial, sans-serif;
        font-weight: 700;
        font-size: 1.3rem;
    }
</style>