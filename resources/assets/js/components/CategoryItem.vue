<template>
    <div class="row mb-4">
        <img :src="imagePath" alt="Item image" class="col-3 col-md-2">
        <a :href="'/items/' + item.id" class="ml-3 col-7 mt-1 green-link" id="catItem">{{ item.name }}</a>
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

    #catItem {
        font-size: 1.5rem;
    }

    .green-link {
        color: seagreen;
    }
</style>