<template>
    <div>
        <div v-if="isEdited">
            <p>{{ user.name }}</p>

            <label>Your Story:</label>
            <input type="text" v-model="body" class="form-control">

            <label>Approximate Cost:</label>
            <input type="number" v-model="cost" class="form-control">$
        </div>

        <div v-else>
            <p>{{ user.name }}</p>
            <p>{{ story.body }}</p>
            <p>{{ story.cost }}</p>
        </div>

        <div v-if="isUsersStory">
            <div v-if="isEdited">
                <button class="btn btn-success" @click="edit">Edit</button>
                <button class="btn btn-danger" @click="isEdited = false">Cancel</button>
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

</style>