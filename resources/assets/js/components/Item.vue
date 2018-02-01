<template>
    <div>
        <img v-if="!noImage" :src="imagePath" alt="item image">
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
                noImage: false
            }
        },
        computed: {
            imagePath() {
                if(this.item.image === 'placeholder.jpg') {
                    this.noImage = true;
                }
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