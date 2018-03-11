<template>
    <div>
        <div class="row mb-4">
            <img :src="imagePath" alt="item image" class="col-3 col-md-2">
            <a :href="'/items/' + result.id" class="lead ml-3 col-7 green-link" id="catItem">{{ result.name }}</a>
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

                return 'https://storage.googleapis.com/declutter/images/' + this.result.image;
            }
        }
    }
</script>

<style>
    img {
        height: 120px;
        border-radius: 50%;
    }

    #catItem {
        font-size: 1.5rem;
    }

    .green-link {
        color: seagreen;
    }
</style>