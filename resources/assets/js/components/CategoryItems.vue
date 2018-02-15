<template>
    <div>
        <h3 v-if="!isNotEmpty">No items available in this category.</h3>
        <category-item v-else v-for="item in items" :item="item" :key="item.id"></category-item>
    </div>
</template>

<script>
    export default {   //TODO pagination
        props: [
            'items'
        ],
        computed: {
            isNotEmpty() {
                return this.items.length;
            }
        }
    }
</script>

<style>

</style>