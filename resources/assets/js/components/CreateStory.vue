<template>
    <div v-if="notDecluttered">
        <label>Your Story:</label>
        <input type="text" v-model="body" class="form-control">

        <label>Approximate Cost:</label>
        <input type="number" v-model="cost" class="form-control">$

        <button class="btn btn-primary" @click="post">Post</button>
    </div>
</template>

<script>
    import { eventBus } from '../app.js';

    export default {
        props: [
            'item_id'
        ],
        data() {
            return {
                body: '',
                cost: '',
                notDecluttered: false
            }
        },
        methods: {
            post() {
                axios.post('/stories', {
                    body: this.body,
                    cost: this.cost,
                    item_id: this.item_id
                }).then((response) => {
                    console.log(response.data);
                    eventBus.$emit('story-added');
                })

                axios.get('/items/declutter/' + this.item_id)
                    .then(() => {
                        eventBus.$emit('item-decluttered');
                    })
            },
            checkDeclutter() {
                axios.get('/items/check/' + this.item_id)
                    .then((response) => {
                        this.notDecluttered = !response.data.isDecluttered;
                    })
            }

        },
        created() {
            this.checkDeclutter();

            eventBus.$on('item-decluttered', () => {
                this.notDecluttered = false;
            });

            eventBus.$on('item-recluttered', () => {
                this.notDecluttered = true;
            });
        }
    }
</script>

<style>

</style>