<template>
    <div v-if="!deleted">
        <p class="font-weight-bold">{{ user.name }} got rid of a {{ story.item.name }} and it costed around ${{ story.cost }}.</p>
        <p>{{ story.body }}</p>
        <p class="text-muted">{{ story.created_at }}</p>

        <button  v-if="isLogged" class="btn btn-danger" @click="del">Delete</button>
        <hr>
    </div>
</template>

<script>
    export default {
        props: [
            'story', 'isLogged', 'user'
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