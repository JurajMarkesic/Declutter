<template>
    <div class="effect8">
        <div class="innerWrap">
            <div>
               <div id="imgWrap"> <img :src="imagePath" alt="user avatar" id="profileImg"></div>
                <h3 class="mt-3 font-weight-bold" style="color: seagreen">{{ user.name }}</h3>

                <hr class="styled">

                <div class="row mt-5">
                    <div class="col-6">
                        <h6 class="font-weight-bold">Declutters:</h6>
                        <p class="ml-4">{{ user.declutters }}</p>
                    </div>

                    <div class="col-6">
                        <h6 class="font-weight-bold">Average Cost:</h6>
                        <p class="ml-3">${{ cost | round(2) }}</p>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div  class="col-6">
                    <h6 class="font-weight-bold" style="color: seagreen">Followers:</h6>
                    <a href="/profile/followers" ><p class="ml-4 lead" style="color: seagreen">{{ followerCount}}</p></a>
                </div>

                <div  class="col-6">
                    <h6 class="font-weight-bold" style="color: seagreen">Following:</h6>
                    <a href="/profile/followings"><p class="ml-4 lead" style="color: seagreen">{{ followingCount}}</p></a>
                </div>

            </div>
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
                cost: ''
            }
        },
        created() {
            this.getCost();
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
        },
        methods: {
            getCost() {
                axios.get('/cost/' + this.user.id)
                    .then((response) => {
                        this.cost = response.data.cost;
                    })
            }
        }
    }
</script>

<style>
    #profileImg {
        height: 130px;
        border-radius: 50%;
        max-width: 100%;
    }

    #imgWrap {
        width: 75%;
        margin: 0 auto;
    }

    .effect8
    {
        position:relative;
        box-shadow:0 1px 1px rgba(0, 0, 0, 0.2), 0 0 5px rgba(0, 0, 0, 0.1) inset;
    }
    .effect8:before, .effect8:after
    {
        content:"";
        position:absolute;
        z-index:-1;
        box-shadow:0 0 20px rgba(0,0,0,0);
        top:10px;
        bottom:10px;
        left:0;
        right:0;
        border-radius:100px / 10px;
    }
    .effect8:after
    {
        right:10px;
        left:auto;
        transform:skew(8deg) rotate(3deg);
    }
    .innerWrap {
        padding: 20px;
    }

    hr.styled {
        border: 0;
        height: 1px;
        background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0));
    }
</style>