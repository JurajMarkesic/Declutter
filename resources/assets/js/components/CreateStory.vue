<template>
    <div>
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
                cost: ''
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
            }
        }
    }
</script>

<style>

</style>