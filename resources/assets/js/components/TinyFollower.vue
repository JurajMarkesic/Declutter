<template>
    <div>
        <img :src="imagePath" alt="user avatar">
        <a :href="'/profile/' + user.id"><h4>{{user.name}}</h4></a>
        <button v-if="following" class="btn btn-primary" @click="followToggle">Unfollow</button>
        <button v-else class="btn btn-primary" @click="followToggle">Follow</button>
    </div>
</template>

<script>
    export default {
        props: [
            'user'
        ],
        data() {
            return {
                following: false
            }
        },
        methods: {
            followToggle() {
                axios.get('/profile/' + this.user.id + '/follow')
                    .then((response) => {
                        this.following = response.data.following;
                    })
            },
            checkFollow() {
                axios.get('/profile/' + this.user.id + '/check')
                    .then((response) => {
                        this.following = response.data.isFollowing;
                    })
            }
        },
        computed: {
            imagePath() {
                return 'https://storage.googleapis.com/declutter/images/' + this.user.image;
            }
        },
        created() {
            this.checkFollow();
        }
    }
</script>

<style>
    img {
        height: 50px;
        border-radius: 50%;
    }
</style>