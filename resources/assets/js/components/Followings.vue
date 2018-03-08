<template>
    <div class="mt-5">
        <div v-if="!followings.length">No followers.</div>
        <tiny-followee v-for="user in followings" :user="user" :key="user.id" class="col-6 col-md-2 float-left mb-3"></tiny-followee>
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