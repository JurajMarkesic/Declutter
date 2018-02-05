<template>
    <div v-if="!deleted">
        <p>{{ story.body }}</p>
        <p>{{ story.cost }}</p>
        <p>{{ story.created_at }}</p>

        <button  v-if="isLogged" class="btn btn-danger" @click="del">Delete</button>
        <hr>
    </div>
</template>

<script>
    export default {
        props: [
            'story', 'isLogged'
        ],
        data() {
            return {
                deleted: false
            }
        },
        methods: {
            del() {
                axios.delete('/stories/' + this.story.id)
                    .then(() => {
                        this.deleted = true;
                    })
            }
        }
    }
</script>

<style>

</style>