<template>
    <div>
        <p>{{ category.name }}</p>
        <button class="btn btn-danger" @click="remove">Remove</button>
    </div>
</template>

<script>
    import { eventBus } from '../app.js';

    export default {
        props: [
            'category'
        ],
        methods: {
            remove() {
                axios.delete('/categories/' + this.category.id)
                    .then(() => {
                        eventBus.$emit('category-deleted');
                    })
            }
        }
    }
</script>

<style>

</style>