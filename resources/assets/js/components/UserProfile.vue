<template>
    <div>
        <button @click="directToEdit">Edit</button><br>

        <img :src="imagePath" alt="user avatar">
        <h3>{{ user.name }}</h3>
        <p class="mb-5">{{ user.bio }}</p>

        <user-stories :stories="user.stories"></user-stories>
    </div>
</template>

<script>
    export default {
        props: [
            'user'
        ],
        data() {
            return {

            }
        },
        methods: {
            directToEdit() {
                window.location.href = '/profile/edit';
            }
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