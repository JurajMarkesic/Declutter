<template>
   <div>
       <div class="card">
           <div class="card-header">Users</div>
           <div class="card-body">
                <h4>Search for a User:</h4>

               <label>Name:</label>
               <input type="text" v-model="username"><br>
               <button class="btn btn-primary" @click="searchUser">Search</button>
               <br><br>

               <div>
                   <span>{{user.name}}</span>
                   <button v-if="user" class="btn btn-danger" @click="deleteUser">Delete</button>
               </div>
           </div>
       </div>

        <div class="card">
            <div class="card-header">Categories</div>
            <div class="card-body">
                <h4>Add a Category:</h4>
                <label>Name:</label>
                <input type="text" v-model="name"><br>
                <button class="btn btn-primary" @click="addCategory">Add</button>
                <br><br>

                <category v-for="category in categories" :category="category" :key="category.id"></category>
            </div>
        </div>
   </div>
</template>

<script>
    import { eventBus } from '../app.js';

    export default {
        data() {
            return {
                categories: [],
                name: '',
                username: '',
                user: ''
            }
        },
        methods: {
            fetchCategories() {
                axios.get('/categories')
                    .then((response) => {
                        this.categories = response.data.categories;
                    })
            },
            addCategory() {
                axios.post('/categories', {
                    name: this.name
                }).then(() => {
                    this.fetchCategories();
                })
            },
            searchUser() {
                axios.post('/searchUser', {
                    'query': this.username
                }).then((response) => {
                    this.user = response.data.users[0];
                }).catch((e) => {
                    console.log(e);
                })
            },
            deleteUser() {
                axios.delete('/deleteUser/' + this.user.id)
                    .catch((e) => {
                        console.log(e.data);
                    })
            }
        },
        created() {
            this.fetchCategories();
            eventBus.$on('category-deleted', this.fetchCategories);
        }
    }
</script>

<style>

</style>