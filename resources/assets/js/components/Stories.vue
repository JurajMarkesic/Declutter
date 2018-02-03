<template>
    <div>
        <story v-for="story in stories" :story="story" :key="story.id"></story>
        <div v-if="shouldOfferSignup">
           <h4 class="text-warning"> Signup to see more stories!</h4>
        </div>
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
              stories: [],
              notLoggedIn: false
          }
        },
        methods: {
            fetch() {                                                   //TODO pagination
                axios.get('/items/stories/' + this.item.id)
                    .then((response) => {
                        if(response.data.isLoggedIn) {
                            this.stories = response.data.stories;
                        }else {
                            this.stories = response.data.stories.slice(0,3);
                            this.notLoggedIn = true;
                        }
                    })
            }
        },
        computed: {
          shouldOfferSignup() {
              return (this.notLoggedIn) && (this.stories.length === 3);
          }
        },
        created() {
            this.fetch();
            eventBus.$on('story-added', this.fetch);
            eventBus.$on('story-deleted', this.fetch);
        }
    }
</script>

<style>

</style>