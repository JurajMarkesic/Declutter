<template>
    <div>
        <div class="row mb-4">
            <div id="imgWrap" class="col-12 col-md-4">
                <img :src="imagePath" alt="item image">
            </div>
             <span class="display-4 col-11 col-md-7">{{ item.name }}</span>
        </div>

        <div v-if="noStory && isLoggedIn" class="mb-5">
            <button v-if="isDecluttered" class="btn btn-danger" @click="undoDeclutter">Undo</button>
            <button v-else class="btn btn-success" @click="declutter">Declutter</button>
        </div>

        <h3>Declutters: <b>{{ declutters }}</b></h3>
        <h3 v-if="avgCost">Average cost: <b>${{ avgCost | round(2) }}</b></h3>
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
                isLoggedIn: false,
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
                        this.isLoggedIn = response.data.isLoggedIn;
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

    #imgWrap {
        overflow: hidden;
    }

    img {
        display: block;
        height: 200px;
        width: auto;
    }

    @media (max-width: 768px) {
        img {
            height: 160px;
        }
    }


</style>