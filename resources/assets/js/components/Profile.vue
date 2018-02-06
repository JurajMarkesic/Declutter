<template>
    <div>
        <button v-if="isFollowing" class="btn btn-secondary mb-3" @click="followToggle">Unfollow</button>
        <button v-else class="btn btn-primary" @click="followToggle">Follow</button>
        <br>

        <div class="row mt-5">
            <img :src="imagePath" alt="user avatar" class=" col-12 col-md-3">
            <span class="username ml-5 col-11 col-md-7">{{ user.name }}</span>
        </div>
        <p class="mb-5">{{ user.bio }}</p>

        <user-stories :stories="user.stories" :user="user"></user-stories>
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
        height: 130px;
        border-radius: 50%;
    }

    .username {
        font-size: 2.8rem;
    }
</style>