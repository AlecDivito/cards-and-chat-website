<template>
    <router-link tag="li" :to="link.url" ><a v-text="link.name"></a></router-link>
</template>

<script>
    export default {
        name: 'al-link-item',
        props: ['link'],

    }
</script>