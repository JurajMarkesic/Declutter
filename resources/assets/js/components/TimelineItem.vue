<template>
    <div class="mb-3">
        <p class="lead">{{ story.owner.name }} got rid of a {{ story.item.name }}.</p>
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
        }
    }
</script>

<style>

</style>