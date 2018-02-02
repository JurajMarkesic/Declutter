<template>
    <div v-if="!unfollowed">
        <img :src="imagePath" alt="user avatar">
        <a :href="'/profile/' + user.id"><h4>{{user.name}}</h4></a>
        <button class="btn btn-primary" @click="unfollow">Unfollow</button>
    </div>
</template>

<script>
    export default {
        props: [
            'user'
        ],
        data() {
            return {
                unfollowed: false
            }
        },
        methods: {
            unfollow() {
                axios.get('/profile/' + this.user.id + '/follow')
                    .then(() => {
                        this.unfollowed = true;
                    })
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
        height: 50px;
        border-radius: 50%;
    }
</style>