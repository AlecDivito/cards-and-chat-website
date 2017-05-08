<template>
    <div class="container">
        <div class="box">
            <p id="power">0</p>
            <ul id="messages">
                <li v-for="d in dataStack" :key="dataStack.id" v-text="d"></li>
            </ul>
        </div>
        <ul>
            <li v-for="u in users" :key="users.id" v-text="u"></li>
        </ul>
        <input type="text" id="m" autocomplete="off" /><button @click="sendMessage()">Send</button>
    </div>
</template>

<script>
    export default {
        mounted() {
            window.Echo.private('event-example')
                .listen('EventName', data => {
                    this.dataStack.push(data.message);
                });
            window.Echo.join('event-example-2')
                .here((users) => {
                    for (var i = 0, len = users.length; i < len; i++) {
                        this.users.push(users[i].username);
                    }
                })
                .joining((user) => {
                    this.dataStack.push(user.username + " has joined the chat room!");
                    this.users.push(user.username);
                })
                .leaving((user) => {
                    this.dataStack.push(user.username + " has leaving the chat room!");
                    this.users.pop(user.username);
                });
        },
        destroyed() {
            window.Echo.leave('event-example');
            window.Echo.leave('event-example-2')
        },
        data() {
            return {
                dataStack:[],
                users: [],
            }
        },
        methods: {
            clickButton(val) {
                // $socket is socket.io-client instance
                this.$socket.emit('emit_method', val);
            },
            sendMessage() {
                var message = document.getElementById('m').value;
                axios.post('/fire', {message:message})
                    .then(response => {
                        console.log('successful');
                    })
                    .catch(error => {
                        console.log('unseccsessful');
                    })
            }
        }
    }
</script>

<style scoped>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font: 13px Helvetica, Arial; }
    form { background: #000; padding: 3px; position: fixed; bottom: 0; width: 91%; }
    form input { border: 0; padding: 10px; width: 90%; margin-right: .5%; }
    form button { width: 9%; background: rgb(130, 224, 255); border: none; padding: 10px; }
    #messages { list-style-type: none; margin: 0; padding: 0; }
    #messages li { padding: 5px 10px; }
    #messages li:nth-child(odd) { background: #eee; }
    #messages {
        height: 100px;
        overflow-y: scroll;
    }
</style>