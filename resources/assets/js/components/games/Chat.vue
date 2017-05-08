<template>
    <div class="container">
        <div class="box">
            <p id="power">0</p>
            <ul id="messages">
                <li v-for="d in dataStack" :key="dataStack.id">
                    <p>{{d.username}}: {{d.message}}</p>
                </li>
            </ul>
        </div>
        <input type="text" id="m" autocomplete="off" /><button @click="sendMessage()">Send</button>
    </div>
</template>

<script>


    export default {
        created() {
            Echo.join('chat-channel')
                .listen('OnlineChat', data => {
                    this.dataStack.push(data);
                })
                .here((users) => {
                    users.forEach(function(cv, i, arr) {
                        this.push({message:cv + ' is in the channel'});
                    }, this.dataStack);
                })
                .joining((user) => {
                    this.dataStack.push({message:user.username + " is joining the channel"});
                })
                .leaving((user) => {
                    this.dataStack.push({message:user.username + " is leaving the channel"});
                });
        },
        data() {
            return {
                dataStack: [],
            }
        },
        methods: {
            sendMessage() {
                var message = document.getElementById('m').value;
                document.getElementById('m').value = '';
                axios.post('/api/fire', {message:message})
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