<template>
    <div>
        <div v-if="isEdited">
            <label class="lead">Your Story:</label>
            <textarea v-model="body" class="form-control mb-3" rows="3"></textarea>

            <label class="lead">Approximate Cost:</label>
            <input type="number" v-model="cost" class="form-control mb-2" placeholder="$">
        </div>

        <div v-else>
            <p class="font-weight-bold">{{ user.name }}</p>
            <p>{{ story.body }}</p>
            <p><b>Cost:</b> ${{ story.cost }}</p>
        </div>

        <div v-if="isUsersStory">
            <div v-if="isEdited">
                <button class="btn btn-success" @click="edit">Edit</button>
                <button class="btn btn-danger" @click="del">Delete</button>
                <button class="btn btn-warning" @click="isEdited = false">Cancel</button>
            </div>
            <button v-else @click="isEdited = true" class="btn btn-info">Edit</button>
        </div>

        <hr>

    </div>
</template>

<script>
    import { eventBus } from '../app.js';

    export default {
        props: [
            'story'
        ],
        data() {
            return {
                user: {},
                isUsersStory: false,
                isEdited: false,
                body: '',
                cost: '',
            }
        },
        methods: {
            getUser() {
                axios.get('/getuser/' + this.story.user_id)
                    .then((response) => {
                        console.log(response.data);
                        this.user = response.data.user;
                        this.isUsersStory = response.data.isUsersStory;
                    }).catch((error) => {
                        console.log(error.data);
                })
            },
            edit() {
                axios.patch('/stories/' + this.story.id, {
                    body: this.body,
                    cost: this.cost,
                }).then((response) => {
                    console.log(response.data);
                    this.isEdited = false;
                    eventBus.$emit('story-added');
                })
            },
            del() {
                axios.delete('/stories/' + this.story.id)
                    .then(() => {
                        eventBus.$emit('story-deleted');
                    })

                axios.get('/items/undoDeclutter/' + this.story.item_id)
                    .then(() => {
                        eventBus.$emit('item-recluttered');
                    })
            }
        },
        mounted() {
            this.getUser();
            this.body = this.story.body;
            this.cost = this.story.cost;
        }
    }
</script>

<style>
    p {
        word-break: break-all;
    }
</style>