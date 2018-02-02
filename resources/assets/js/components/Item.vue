<template>
    <div>
        <img :src="imagePath" alt="item image">
        <h1>{{ item.name }}</h1>
    </div>
</template>

<script>
    export default {
        props: [
            'item'
        ],
        data() {
            return {

            }
        },
        computed: {
            imagePath() {
                return '/storage/uploads/' + this.item.image;
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