<template>
    <div class="mt-5">
        <div v-if="!followers.length">No followers.</div>
        <tiny-follower v-for="user in followers" :user="user" :key="user.id" class="col-6 col-md-2 float-left mb-3"></tiny-follower>
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