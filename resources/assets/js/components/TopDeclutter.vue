<template>
    <div>
        <h2>Items with the most declutters:</h2>
        <div v-for="item in items">
            <h4>{{ item.name }}</h4>
            <p>Declutters: {{ item.declutters }}</p>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'items'
        ],
    }
</script>

<style>

</style>