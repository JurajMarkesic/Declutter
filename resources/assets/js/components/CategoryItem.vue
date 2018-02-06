<template>
    <div class="row mb-4">
        <img :src="imagePath" alt="Item image" class="col-4 col-md-2">
        <a :href="'/items/' + item.id" class="display-4 ml-3 col-7">{{ item.name }}</a>
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
        height: 80px;
        border-radius: 50%;
    }
</style>