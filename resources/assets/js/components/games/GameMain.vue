<template>
    <div class="container">
        <template v-if="showLogin" >
            <al-login-form v-on:login-success="LoginSuccess()" v-on:login-fail="LoginFailer()"></al-login-form>
        </template>
        <template v-else>
            <header class="tabs is-medium">
                <ul>
                    <al-link-item
                            v-for="link in games"
                            :link="link"
                            :key="link.url">
                    </al-link-item>
                </ul>
            </header>
            <main id="gameContainer">
                <router-view></router-view>
            </main>
        </template>
    </div>
</template>

<script>
    import Login from '../../model/LoginUserFormModal.vue';
    import LinkItem from '../../model/layoutLinks.vue';
    import AlLinkItem from "../../model/layoutLinks";

    export default {
        data() {
            return {
                games: [],
                showLogin: false,
            }
        },
        components: {
            AlLinkItem,
            'al-login-form':Login,
            'al-link-item' :LinkItem,
        },
        methods: {
            getGames() {
                if (this.games.length === 0) {
                    axios.get('/api/games')
                        .then(response => {
                            this.games = response.data;
                            this.showLogin = false;
                        }).catch(error => {
                            this.showLogin = true;
                    });
                    return this.games.length === 0;
                } else {
                    return false;
                }
            },
            LoginSuccess() {
                this.getGames();
            },
            LoginFailer() {
                console.log('failer');
            }
        },
        created() {
            this.getGames();
        },
    }
</script>

<style>
    #content {
        padding-top: 6px;
    }
</style>