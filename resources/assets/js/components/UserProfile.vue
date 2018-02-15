<template>
    <div>
        <button @click="directToEdit" class="float-right btn btn-primary mt-4">Edit profile</button><br>

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a href="/profile/followers" class="nav-link ">Followers: {{ followerCount}}</a>
            </li>
            <li class="nav-item">
                <a href="/profile/followings" class="nav-link ">Following: {{ followingCount}}</a>
            </li>
        </ul>

        <div class="row mt-5">
            <img :src="imagePath" alt="user avatar" class=" col-12 col-md-3">
            <span class="display-4 ml-5 col-11 col-md-7" style="color: seagreen">{{ user.name }}</span>
        </div>
        <p class="mb-5">{{ user.bio }}</p>

        <user-stories  :isLoggedIn="true" :user="user"></user-stories>
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
            },
        },
        computed: {
            imagePath() {
                return '/storage/uploads/' + this.user.image;
            },
            followerCount() {
                return this.user.followers.length;
            },
            followingCount() {
                return this.user.followings.length;
            }
        }
    }
</script>

<style>
    img {
        height: 130px;
        border-radius: 50%;
    }
</style>