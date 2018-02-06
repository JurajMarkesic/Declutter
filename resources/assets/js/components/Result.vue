<template>
    <div>
        <div class="row mb-4">
            <img :src="imagePath" alt="result image" class="col-4 col-md-2">
            <a :href="'/items/' + result.id" class="display-4 ml-3 col-7" >{{ result.name }}</a>
        </div>
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