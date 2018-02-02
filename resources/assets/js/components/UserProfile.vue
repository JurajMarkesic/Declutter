<template>
    <div>

        <edit-profile v-if="isEdited"></edit-profile>

        <div v-else>
            <button @click="isEdited = true">Edit</button><br>

            <img :src="imagePath" alt="user avatar">
            <h3>{{ user.name }}</h3>
            <p class="mb-5">{{ user.bio }}</p>

            <user-stories :stories="user.stories"></user-stories>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'user'
        ],
        data() {
            return {
                isEdited: false
            }
        },
        methods: {

        },
        computed: {
            imagePath() {
                return '/storage/uploads/' + this.user.image;
            }
        }
    }
</script>

<style>
    img {
        height: 80px;
        border-radius: 50%;
    }
</style>