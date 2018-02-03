<template>
    <div>
        <span>{{ category.name }}</span>
        <button class="btn btn-danger" @click="remove">Remove</button>
        <br><br>
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