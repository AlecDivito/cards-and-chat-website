<template>
    <div class="container box">
        <template v-if="showLogin" >
            <al-login-form v-on:login-success="LoginSuccess()" v-on:login-fail="LoginFailer()"></al-login-form>
        </template>
        <template v-else>
            <div class="columns">
                <div class="column is-one-quarter">

                    <nav class="panel">
                        <p class="panel-heading">Chat Rooms</p>
                        <div class="panel-block">
                            <p class="control has-icons-left">
<!--                                <input type="text" class="input" placeholder="Search...">
                                <span class="icon is-small is-pulled-left">
                                    <i class="fa fa-search"></i>
                                </span>-->
                                seach text input
                            </p>
                        </div>
                        <p class="panel-tabs">
                            <a class="is-active">All</a>
<!--                            <a>Favorites</a>
                            <a>Public</a>
                            <a>Friends</a>-->
                        </p>

                        <router-link v-for="room in chatRooms"
                                     tag="a"
                                     class="panel-block"
                                     :to="'/chatroom/'+room.id"
                                     :key="chatRooms.id">
                            <span class="panel-icon">
                                <i class="fa fa-comments-o" aria-hidden="true"></i>
                            </span>
                            {{room.name}} <small>({{room.status}})</small>
                        </router-link>

                        <router-link to="/chatroom/create" class="panel-block">
                            <span class="panel-icon">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </span>
                            Create ChatRoom
                        </router-link>
                    </nav>

                </div>
                <div class="column is-half">
                    <router-view></router-view>
                    <!--  SO... right here is where router view will reside
                      what will happen is that when someone connects to a room
                      this router view will switch to that room<router-view></router-view>-->
                </div>
                <div class=" column auto box">
                    <h1>Current Global Users</h1>
                    <hr>
                    <ul id="user-box">
                        <li v-for="u in users" :key="users.id" v-text="u"></li>
                    </ul>
                </div>
            </div>
            <div id="message-box" class="box danger">
                <p>This is a message</p>
            </div>
        </template>
    </div>
</template>

<script>
    import Login from '../model/LoginUserFormModal.vue';

    export default {
        created() {
            this.getChatRooms();
        },
        mounted() {
            this.joinGlobalChat();
        },
        update() {

        },
        destroyed() {
            window.Echo.leave('chat-room');
        },
        data() {
            return {
                chatRooms: [],
                users:[],
                message:'',
                showLogin: false,
            }
        },
        components: {
            'al-login-form':Login,
        },
        methods: {
            joinGlobalChat() {
                window.Echo.join('presence-chat-room')
                    .here((users) => {
                        for (var i = 0, len = users.length; i < len; i++) {
                            this.users.push(users[i].username);
                        }
                    })
                    .joining((user) => {
                        this.message = user.username + " has joined the chat room!";
                        this.users.push(user.username);
                    })
                    .leaving((user) => {
                        this.message = user.username + " has left the chat room!";
                        this.users.pop(user.username);
                    });
            },
            getChatRooms() {
                if (this.chatRooms.length === 0) {
                    axios.get('/api/chatrooms')
                        .then(response => {
                            this.chatRooms = response.data;
                            this.showLogin = false;
                        })
                        .catch(error => {
                            this.showLogin = true;
                        });
                }
            },
            LoginSuccess() {
                if ( ! showLogin) {
                    this.getChatRooms();
                    this.joinGlobalChat();
                }
            },
            LoginFailer() {
                console.log('failer');
            }
        },
    }
</script>

<style scoped type="scss">
    #message-box {
        position: fixed;
        right: 15px;
        bottom: 15px;
        background-color:hsl(141, 71%, 48%) ;
    }
    #user-box {
        height: 250px;
        overflow-y: scroll;
    }
</style>