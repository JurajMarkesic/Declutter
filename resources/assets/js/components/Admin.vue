<template>
   <div>
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