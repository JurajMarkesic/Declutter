<template>
    <div>
        <label><h4>Edit Bio:</h4></label>
        <textarea v-model="user.bio" cols="30" rows="10" class="form-control"></textarea>

        <button class="btn btn-success"  @click="edit">Edit</button>

        <br>

        <div v-if="isUpdated" class="alert alert-success">
            Bio updated!
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'user'
        ],
        data() {
            return {
                isUpdated: false
            }
        },
        methods: {
            edit() {
                axios.patch('/profile', {
                    bio: this.user.bio
                }).then(() => {
                    this.isUpdated = true;
                })
            }
        }
    }
</script>

<style>

</style>