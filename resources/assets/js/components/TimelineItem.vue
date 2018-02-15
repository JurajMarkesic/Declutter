<template>
    <div class="mb-3" id="timelineItem">
        <p class="lead"><img :src="imagePath" alt="user avatar"><span style="color: seagreen" class="ml-2">{{ story.owner.name }}</span>
            got rid of a {{ story.item.name }}.</p>
        <timeago :since="time" :auto-update="60"></timeago>


    </div>
</template>

<script>
    export default {
        props: [
            'story'
        ],
        data() {
            return {
                time: this.story.created_at
            }
        },
        computed: {
            imagePath() {
                return '/storage/uploads/' + this.story.owner.image;
            }
        }
    }
</script>

<style>

    #timelineItem {
        /*background-color: #f6f8fa;*/
        padding: 10px;
        width: 80%;
    }

    /*#whiteHr {*/
        /*border-color: white;*/
        /*border-width: 3px;*/
    /*}*/

    img {
        height: 30px;
        border-radius: 50%;
    }
</style>