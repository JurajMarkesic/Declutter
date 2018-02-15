<template>
    <div>
        <div v-if="!results.length">
            <h3 class="text-warning">No items match your query.</h3>
        </div>
        <result v-for="result in results" :result="result" :key="result.id"></result>
    </div>
</template>

<script>
    export default {
        props: [
            'results'
        ],
    }
</script>

<style>

</style>