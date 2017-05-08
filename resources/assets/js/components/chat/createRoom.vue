<template>

        <form v-on:submit.prevent="onSubmit">
            <p class="help is-danger"  v-text="alert"></p>

            <div class="field">
                <label for="name" class="label">Name</label>
                <p class="control has-icons has-icon has-icon-right is-expanded">
                    <input id="name" type="text" class="input" name="name" placeholder="AwesomeChatRoom" v-model="form.name" required @onkeydown="clearWarning('email')">
                    <span class="icon is-small is-left">
                        <i class="fa  fa-group"></i>
                    </span>
                </p>
                <p class="help is-danger" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></p>
            </div>

            <div class="field">
                <p class="control">
                    <label class="radio">
                        <input type="radio" name="status" value="public" v-model="form.status" checked>
                        Public
                    </label>
                    <label class="radio">
                        <input type="radio" name="status" value="private" v-model="form.status" >
                        Private
                    </label>
                </p>
            </div>

            <div class="field" v-if="form.status === 'private'">
                <label for="password" class="label">Password</label>
                <p class="control has-icon has-icons-left">
                    <input class="input" type="password" name="password" id="password" placeholder="Password" v-model="form.password" @onkeydown="clearWarning('password')">
                    <span class="icon is-small is-left">
                      <i class="fa fa-lock"></i>
                    </span>
                </p>
                <p class="help is-danger" v-if="form.errors.has('password')" v-text="form.errors.get('password')"></p>
            </div>

            <div class="field is-grouped">
                <p class="control">
                    <button class="button is-primary">Create Chat Room</button>
                </p>
            </div>
        </form>

</template>

<script>
    import Form from '../../util/Form';

    export default {
        data() {
            return {
                form: new Form({
                    name:'',
                    status:'public', // if the chat room is marked as private
                    password: '',
                }),
                alert: ''
            }
        },
        methods: {
            onSubmit() {
                this.form.submit('post', '/api/chatrooms')
                    .then(response => {
                        alert(response.message);
                    })
                    .catch(errors => console.log(errors));
            },
            clearWaring(name) {
                this.form.errors.clear(name);
            }
        }
    }
</script>