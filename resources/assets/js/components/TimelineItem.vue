<template>
    <div>
        <p>{{ story.owner.name }} got rid of a {{ story.item.name }}.</p>
        <p class="text-muted">{{ story.created_at }}</p>
    </div>
</template>

<script>
    export default {
        props: [
            'story'
        ]
    }
</script>

<style>

</style>