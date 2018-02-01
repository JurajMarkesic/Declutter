<template>
    <div>
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