<template>
    <div>
        <h2>Items with the highest average cost:</h2>
        <div v-for="item in items">
            <h4>{{ item[0].name }}</h4>
            <p>${{ item[1] }}</p>
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