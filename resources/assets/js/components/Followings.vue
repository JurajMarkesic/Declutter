<template>
    <div>
        <tiny-followee v-for="user in followings" :user="user" :key="user.id"></tiny-followee>
    </div>
</template>

<script>
    export default {
        props: [
            'followings'
        ],
    }
</script>

<style>

</style>