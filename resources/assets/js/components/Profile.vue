<template>
    <div>
        <button v-if="isFollowing" class="btn btn-secondary" @click="followToggle">Unfollow</button>
        <button v-else class="btn btn-primary" @click="followToggle">Follow</button>
        <br>

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
                isFollowing: false
            }
        },
        methods: {
            followToggle() {
                axios.get('/profile/' + this.user.id + '/follow')
                    .then(() => {
                        this.isFollowing = !this.isFollowing;
                    })
            },
            checkIfFollowing() {
                axios.get('/profile/' + this.user.id + '/check')
                    .then((response) => {
                        this.isFollowing = response.data.isFollowing;
                    })
            }
        },
        computed: {
            imagePath() {
                return '/storage/uploads/' + this.user.image;
            }
        },
        created() {
            this.checkIfFollowing();
        }
    }
</script>

<style>
    img {
        height: 80px;
        border-radius: 50%;
    }
</style>