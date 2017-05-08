<template>

    <form @submit.prevent="onSubmit()">
        <div class="field">
            <label for="name" class="label">Name</label>
            <p class="control">
                <input type="text" id="name" class="input" placeholder="John Doe" v-model="form.name" required>
            </p>
            <p class="help is-danger" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></p>
        </div>

        <div class="field">
            <label for="username" class="label">Username</label>
            <p class="control has-icons has-icon has-icon-right is-expanded">
                <input type="text" id="username" class="input is-success" placeholder="Username" v-model="form.username" required>
                <span class="icon is-small is-left">
                    <i class="fa fa-user"></i>
                </span>
            </p>
            <p class="help is-danger" v-if="form.errors.has('username')" v-text="form.errors.get('username')"></p>
        </div>

        <div class="field">
            <label for="email" class="label">Email</label>
            <p class="control has-icons has-icon has-icon-right is-expanded">
                <input type="email" id="email" class="input" placeholder="example@test.com" v-model="form.email" required>
                <span class="icon is-small is-left">
                    <i class="fa fa-envelope"></i>
                </span>
            </p>
            <p class="help is-danger" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></p>
        </div>

        <div class="field">
            <label for="password" class="label">Password</label>
            <p class="control has-icon has-icons-left">
                <input class="input" type="password" id="password" placeholder="Password" v-model="form.password" required>
                <span class="icon is-small is-left">
                  <i class="fa fa-lock"></i>
                </span>
            </p>
            <p class="help is-danger" v-if="form.errors.has('password')" v-text="form.errors.get('password')"></p>
        </div>

        <div class="field">
            <label for="password_confirmation" class="label">Password Confirmation</label>
            <p class="control has-icon has-icons-left">
                <input class="input" type="password" id="password_confirmation" placeholder="Password Confirmation" v-model="form.password_confirmation" required>
                <span class="icon is-small is-left">
                  <i class="fa fa-lock"></i>
                </span>
            </p>
            <p class="help is-danger" v-if="form.errors.has('password_confirmation')" v-text="form.errors.get('password_confirmation')"></p>
        </div>

        <div class="field">
            <p class="control">
                <input  type="submit" class="button is-primary" value="Submit">
            </p>
        </div>
    </form>

</template>

<script>
    export default {
        data() {
            return {
                form: new Form({
                    name: '',
                    username: '',
                    password: '',
                    password_confirmation: '',
                    email: '',
                }),
            }
        },
        methods: {
            onSubmit() {
                this.form.submit('post', '/register')
                    .then(this.$route.redirect('/games'))
                    .catch(console.log(data));
            }
        }
    }
</script>

<style>
    .control.has-icon.has-icon-right .input {
        padding-right: 2.25em;
        padding-left: 2.25em;
    }

    .control.has-icon:not(.has-icon-right) .icon {
        right: 0;
    }

    .is-left {
        left: 0;
    }
</style>