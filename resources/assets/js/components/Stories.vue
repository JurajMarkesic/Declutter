<template>
    <div>
        <create-story :item_id="item.id"></create-story>


        <story v-for="story in stories" :story="story" :key="story.id"></story>
    </div>
</template>

<script>
    import { eventBus } from '../app.js';

    export default {
        props: [
            'item'
        ],
        data() {
          return {
                stories: []
          }
        },
        methods: {
            fetch() {                                                   //TODO pagination
                axios.get('/items/stories/' + this.item.id)
                    .then((response) => {
                        console.log(response.data);
                        this.stories = response.data;
                    })
            }
        },
        created() {
            this.fetch();
            eventBus.$on('story-added', this.fetch);
        }
    }
</script>

<style>

</style>