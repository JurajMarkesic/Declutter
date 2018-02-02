<template>
    <div>
        <img :src="imagePath" alt="result image">
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
            }
        },
        computed: {
            imagePath() {

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