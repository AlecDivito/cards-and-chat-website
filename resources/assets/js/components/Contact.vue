<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Contact Page</div>

                    <div class="panel-body">
                        <button @click="broadcastAuth()">Test Broadcasting/Auth</button>
                        <button @click="test()">test api When Logged in</button>
                        <p v-text="text"></p>
                        <button @click="logout()">Logout</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="box">
                <button @click="testDeck()">Shuffle Deck</button>
                <pre v-text="JSON.stringify(deck.deckInfo)"></pre>
                <button @click="drawCard()">Draw a card</button>
                <pre v-text="JSON.stringify(cards)"></pre>
                <button @click="addAChannel">Click me to add a channel</button>
                <input type="text" v-model="channel">
                <pre v-text="text"></pre>

                <h1>Get info on the server</h1>
                <button @click="test1">Status</button>
                <pre v-text="var1"></pre>
                <button @click="test2">channels</button>
                <pre v-text="var2"></pre>
                <button @click="test3">info on particualr channel</button>
                <input type="text" v-model="channel">
                <pre v-text="var3"></pre>
                <button @click="test4">list of users on particular channel</button>
                <pre v-text="var4"></pre>

            </div>
        </div>
    </div>
</template>

<script>
    import Deck from '../util/Deck';

    export default {
        data() {
            return {
                var1: '',
                var2: '',
                var3: '',
                var4: '',
                text: '',
                cards:[],
                deck: new Deck(),
                channel:'',
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            broadcastAuth() {
                axios['post']('broadcasting/auth', {'channel_name':'chat-channel'})
                    .then(resp => {
                        console.log(resp);
                    })
                    .catch(resp => {
                        console.log(resp);
                    })
            },
            test1() {
                axios['get']('http://www.cardgames.local:3000/apps/6d6f033297665726/status', {auth_key:'e9503714a9bad5a8c90c6fc003fbd1b2'})
                    .then(resp => {
                        this.var1 = resp;
                    })
                    .catch(resp => {
                        this.var1 = resp + 'FAIled';
                    });

            },
            test2() {
                axios['get']('http://www.cardgames.local:3000/apps/6d6f033297665726/channels', {auth_key:'e9503714a9bad5a8c90c6fc003fbd1b2'})
                    .then(resp => {
                        this.var2 = resp;
                    })
                    .catch(resp => {
                        this.var2 = resp + 'FAIled';
                    });

            },
            test3() {
                axios['get']('http://www.cardgames.local:3000/apps/6d6f033297665726/channels/'+this.channel, {auth_key:'e9503714a9bad5a8c90c6fc003fbd1b2'})
                    .then(resp => {
                        this.var3 = resp;
                    })
                    .catch(resp => {
                        this.var3 = resp + 'FAIled';
                    });

            },
            test4() {
                axios['get']('http://www.cardgames.local:3000/apps/6d6f033297665726/channels'+this.channel+'/users', {auth_key:'e9503714a9bad5a8c90c6fc003fbd1b2'})
                    .then(resp => {
                        this.var4 = resp;
                    })
                    .catch(resp => {
                        this.var4 = resp + 'FAIled';
                    });

            },
            addAChannel() {
                axios['post']('http://www.cardgames.local:3000/apps/6d6f033297665726/events', {auth_key:'e9503714a9bad5a8c90c6fc003fbd1b2'})
                    .then(resp => {
                        this.text = resp;
                    })
                    .catch(resp => {
                        this.text = resp + 'FAIled';
                    });
            },
            test() {
                axios['get']('/api/test')
                    .then(response => {
                        this.text = response.data;
                    })
                    .catch(error => {
                        this.text = error.data;
                    });
            },
            testDeck() {
                this.deck.shuffled(1);
            },
            drawCard() {
                this.deck.draw(1);
                this.cards = this.deck.getHand();
            },
            logout() {
                axios['post']('/logout')
                    .then(response => {
                        this.text = response.data;
                    })
                    .catch(error => {
                        this.text = error.data;
                    });
            }
        }
    }
</script>