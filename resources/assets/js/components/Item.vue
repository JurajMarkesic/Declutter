<template>
    <div>
        <img :src="imagePath" alt="item image">
        <h1>{{ item.name }}</h1>
        <h3>Declutters: {{ declutters }}</h3>
        <h3 v-if="avgCost">Average cost: {{ avgCost }}</h3>
       <div v-if="noStory">
           <button v-if="isDecluttered" class="btn btn-danger" @click="undoDeclutter">Undo</button>
           <button v-else class="btn btn-success" @click="declutter">Declutter</button>
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
                isDecluttered: false,
                noStory: true,
                declutters: this.item.declutters,
            }
        },
        computed: {
            imagePath() {
                return '/storage/uploads/' + this.item.image;
            },
            avgCost() {
                let count = this.item.stories.length;

                let totalCost = 0;

                this.item.stories.forEach((story) => {
                    totalCost += story.cost;
                })

                return totalCost / count;
            }
        },
        methods: {
            declutter() {
                axios.get('/items/declutter/' + this.item.id)
                    .then(() => {
                        this.isDecluttered = true;
                        this.declutters++;
                        eventBus.$emit('item-decluttered');
                    })
            },
            undoDeclutter() {
                axios.get('/items/undoDeclutter/' + this.item.id)
                    .then(() => {
                        this.isDecluttered = false;
                        this.declutters--;
                        eventBus.$emit('item-recluttered');
                    })
            },
            checkDeclutter() {
                axios.get('/items/check/' + this.item.id)
                    .then((response) => {
                        this.isDecluttered = response.data.isDecluttered;
                    })
            }
        },
        created() {
            this.checkDeclutter();
            
            eventBus.$on('item-decluttered', () => {
                this.isDecluttered = true;
            });

            eventBus.$on('has-story', () => {
                this.noStory = false;
            });

            eventBus.$on('story-added', () => {
                this.declutters++;
            });

            eventBus.$on('story-deleted', () => {
                this.noStory = true;
                this.isDecluttered = false;
                this.declutters--;
            });
        }
    }
</script>

<style>
    img {
        height: 80px;
        border-radius: 50%;

    }
</style>