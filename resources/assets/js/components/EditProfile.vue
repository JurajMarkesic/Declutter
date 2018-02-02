<template>
    <div>
        <label><h4>Edit Bio:</h4></label>
        <textarea v-model="user.bio" cols="30" rows="10" class="form-control"></textarea>

        <button class="btn btn-success"  @click="edit">Edit</button>

        <br>

        <div v-if="bioUpdated" class="alert alert-success">
            Bio updated!
        </div>
        <br>

        <label>Profile Visibility:</label><br>
        <h5 v-if="isVisible">Public</h5>
        <h5 v-else>Private</h5>
        <br>
        <button v-if="isVisible" class="btn btn-success" @click="toggleVisibility">Make Private</button>
        <button v-else class="btn btn-success" @click="toggleVisibility">Make Public</button>
    </div>
</template>

<script>
    export default {
        props: [
            'user'
        ],
        data() {
            return {
                bioUpdated: false,
                isVisible: true
            }
        },
        methods: {
            edit() {
                axios.patch('/profile', {
                    bio: this.user.bio
                }).then(() => {
                    this.bioUpdated = true;
                })
            },
            toggleVisibility() {
                axios.get('/profile/visibility')
                    .then(() => {
                        this.isVisible = !this.isVisible;
                    })
            }
        },
        created() {
            this.isVisible = this.user.public;
        }
    }
</script>

<style>

</style>