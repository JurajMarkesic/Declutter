<template>
    <div>
        <img v-if="!noImage" :src="imagePath" alt="result image">
        <h1><a :href="'/items/' + result.id" >{{ result.name }}</a></h1>
    </div>
</template>

<script>
    export default {
        props: [
            'result'
        ],
        data() {
            return {
                noImage: false
            }
        },
        computed: {
            imagePath() {
                if(this.result.image === 'placeholder.jpg') {
                    this.noImage = true;
                }
                return '/storage/uploads/' + this.result.image;
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