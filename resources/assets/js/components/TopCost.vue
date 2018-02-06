<template>
    <div>
        <tr v-for="item in items">
            <td>{{ item[0].name }}</td>
            <td>${{ item[1] }}</td>
        </tr>
    </div>
</template>

<script>
    export default {
        props: [
            'items'
        ],
    }
</script>

<style>

</style>