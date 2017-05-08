<template>

    <form v-on:submit.prevent="onSubmit">
        <p class="help is-danger"  v-text="alert"></p>
        <div class="field">
            <label for="email" class="label">Email</label>
            <p class="control has-icons has-icon has-icon-right is-expanded">
                <input id="email" type="email" class="input" name="email" placeholder="example@test.com" v-model="form.email" required @onkeydown="clearWarning('email')">
                <span class="icon is-small is-left">
                    <i class="fa fa-envelope"></i>
                </span>
            </p>
            <p class="help is-danger" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></p>
        </div>

        <div class="field">
            <label for="password" class="label">Password</label>
            <p class="control has-icon has-icons-left">
                <input class="input" type="password" name="password" id="password" placeholder="Password" v-model="form.password" required @onkeydown="clearWarning('password')">
                <span class="icon is-small is-left">
                  <i class="fa fa-lock"></i>
                </span>
            </p>
            <p class="help is-danger" v-if="form.errors.has('password')" v-text="form.errors.get('password')"></p>
        </div>

        <div class="field">
            <p class="control">
                <button class="button is-primary">Submit</button>
                <small>Don't have an account yet? <router-link to="/register">Create One!</router-link></small>
            </p>
        </div>
    </form>

</template>

<script>
    export default {
        props: [],
        data() {
            return {
                alert: '',
                form: new Form({
                    email: '',
                    password: '',
                }),
            };
        },
        methods: {
            onSubmit() {
                this.form.submit('post', '/login')
                    .then(response => {
                        if (response.auth === true) {
                            this.$emit('login-success');
                        } else if(response.auth === false) {
                            this.$emit('login-fail');
                            this.alert = 'Sorry that was not the correct email or password';
                        }
                    })
                    .catch(errors => console.log(errors));
            },
            clearWaring(name) {
                this.form.errors.clear(name);
                this.alert = '';
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