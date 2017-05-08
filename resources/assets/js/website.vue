<template>
    <div>
        <al-header></al-header>

        <section class="section" id="content">
            <router-view></router-view>
        </section>
    </div>
</template>

<script>
    import Header from './model/layout.vue'

    export default {
        name: 'app',
        components: {
            'al-header':Header,
        }
    }
</script>