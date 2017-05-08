<template>
    <div>
        <div class="columns">
            <div class="box column" id="chat-room-box">
                <ul id="messages">
                    <li v-for="d in chatStack" :key="chatStack.id">
                        <p>{{d}}</p>
                    </li>
                </ul>
            </div>
            <div class="column box chat-room-box">
                <h1>Current Room Users</h1>
                <hr>
                <ul>
                    <li v-for="u in users" :key="users">
                        <p>{{u}}</p>
                    </li>
                </ul>
            </div>
        </div>
        <input type="text" id="m" autocomplete="off" /><button @click="sendMessage()">Send</button>
    </div>

</template>

<script>
    export default {
        created() {
            this.id = this.$route.params.id;
        },
        mounted() {
            this.listenToChatRoom();
        },
        destroyed() {
            this.leaveChatRoom();
        },
        data() {
            return {
                maxChatLength: 700,
                chatStack: [],
                users: [],
                id: -1,
            }
        },
        watch: {
            '$route' (to, from) {
                // console.log('to = ' + to.params.id + ",  from = " + from.params.id);
                // first leave the chat room with the current id
                this.leaveChatRoom();
                // set the id for the new chat room
                this.id = to.params.id;
                // clear all data stacks
                this.chatStack = [];
                this.users = [];
                // try and connect to the new chat room
                this.listenToChatRoom();
            }  ,
        },
        methods: {
            listenToChatRoom() {
/*                window.Echo.private('private-chat-room.' + this.id)
                    .listen('ChatRoomBroadcaster', data => {
                        this.pushToStack(data);
                    });*/

                window.Echo.join('private-chat-room.' + this.id)
                    .here((users) => {
                        for (var i = 0, len = users.length; i < len; i++) {
                            this.users.push(users[i].username);
                        }                    })
                    .joining((user) => {
                        this.pushToStack(user.username + " has joined the chat room!");
                        this.users.push(user.username);

                    })
                    .leaving((user) => {
                        this.pushToStack(user.username + " has left the chat room!");
                        this.users.pop(user.username);

                    })
                    .listen('ChatRoomBroadcaster', data => {
                        this.pushToStack(data.user.username + ": " + data.message);
                    });
            },
            leaveChatRoom() {
                window.Echo.leave('private-chat-room.'+this.id);
            },
            pushToStack(item) {
                if (this.chatStack.length > this.maxChatLength){
                    this.chatStack.pop();
                }
                this.chatStack.push(item);
            },
            sendMessage() {
                var message = document.getElementById('m').value;
                document.getElementById('m').value = '';
                axios.post('/api/fire/'+this.$route.params.id, {message:message})
                    .then(response => {
                        console.log('successful');
                    })
                    .catch(error => {
                        console.log('unseccsessful');
                    });
                document.getElementById('m').focus();
            }
        }
    }
</script>

<style>
    .chat-room-box {
        height:300px;
        overflow-y: scroll;
    }
</style>