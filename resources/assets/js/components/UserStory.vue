<template>
    <div v-if="!deleted">
        <p class="font-weight-bold">{{ user.name }} got rid of a {{ story.item.name}} and it cost around ${{ story.cost }}.</p>
        <p>{{ story.body }}</p>
        <div class="row">
            <timeago :since="time" :auto-update="60" class="col-6"></timeago>
            <button  v-if="isLogged" class="btn btn-danger col-3 offset-md-3 col-md-1 offset-md-8" @click="del">Delete</button>
        </div>

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
                deleted: false,
                time: this.story.created_at
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