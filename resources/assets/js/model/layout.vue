<template>
    <section class="hero is-primary is-medium">
        <div class="hero-head">
            <header class="nav">
                <div class="container">
                    <div class="nav-left">
                        <router-link :to="`/about`" class="nav-item">
                            <!-- <img src="#" alt="Logo"> -->
                            Alec Divito
                        </router-link>
                    </div>
                    <span class="nav-toggle" @click="toggleNav()">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                    <div class="nav-right nav-menu" id="nav-menu">
                        <router-link :to="`/`" class="nav-item">
                            Home
                        </router-link>
                        <a class="nav-item">
                            Other Projects
                        </a>
                        <span class="nav-item">
                            <a class="button is-primary is-inverted">
                                <span class="icon">
                                    <i class="fa fa-github"></i>
                                </span>
                                <span>Github Portfolio</span>
                            </a>
                        </span>
                    </div>
                </div>
            </header>
        </div>

        <div class="hero-body">
            <div class="container">
                <h1 class="title">Alec Divito Vue Projects</h1>
                <h2 class="subtitle">Card Games</h2>
            </div>
        </div>

        <div class="hero-foot">
            <nav class="tabs is-centered is-boxed">
                <div class="container">
                    <ul>
                        <al-link-item
                                v-for="link in links"
                                :link="link"
                                :key="link.url">
                        </al-link-item>
                    </ul>
                </div>
            </nav>
        </div>
    </section>
</template>

<script>
    import LayoutLink from './layoutLinks.vue';

    export default {
        name: 'al-hero',
        data() {
            return {
                tag: 'li',
                links: [
                    {url:'/about', name:'About'},
                    {url:'/contact', name:'Contact'},
                    {url:'/games', name:'Games'},
                    {url:'/chatroom', name:'ChatRoom'},
                    {url:'/test', name:'Test Sockets'},
                ],
            };
        },
        created() {

        },
        components: {
            'al-link-item': LayoutLink
        },
        methods: {
            toggleNav() {
                var nav = document.getElementById("nav-menu");
                var className = nav.getAttribute("class");
                if(className == "nav-right nav-menu") {
                    nav.className = "nav-right nav-menu is-active";
                } else {
                    nav.className = "nav-right nav-menu";
                }
            }
        }
    }

</script>
