<template>
    <div>
        <img :src="imagePath" alt="Item image">
        <a :href="'/items/' + item.id"><h4>{{ item.name }}</h4></a>
    </div>
</template>

<script>
    export default {
        props: [
            'item'
        ],
        computed: {
            imagePath() {
                return '/storage/uploads/' + this.item.image;
            }
        }
    }
</script>

<style>
    img {
        height: 70px;
        border-radius: 50%;
    }
</style>