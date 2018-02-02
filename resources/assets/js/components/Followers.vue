<template>
    <div>
        <tiny-follower v-for="user in followers" :user="user" :key="user.id"></tiny-follower>
    </div>
</template>

<script>
    export default {
        props: [
            'followers'
        ],
    }
</script>

<style>

</style>