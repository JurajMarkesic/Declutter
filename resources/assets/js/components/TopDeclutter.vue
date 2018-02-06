<template>
    <div>
        <tr v-for="item in items">
            <td>{{ item.name }}</td>
            <td>{{ item.declutters }}</td>
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