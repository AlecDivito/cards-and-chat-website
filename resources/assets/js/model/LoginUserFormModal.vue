<template>
    <div  class="modal is-active" v-show="showLoginModal">
        <div class="modal-background"></div>
        <div class="modal-content">
            <div class="box">
                <h1 class="title">Login Now!!</h1>
                <p>You can't access this page unless your authenticated!</p>
                <al-login-form v-on:login-success="LoginSuccess()" v-on:login-fail="LoginFailer()"></al-login-form>
            </div>
        </div>
        <div class="modal-close" @click="showLoginModal = false"></div>
    </div>
</template>

<script>
    import LoginUserForm from './LoginUserForm.vue';

    export default {
        components: {
            'al-login-form':LoginUserForm
        },
        data() {
            return {
                showLoginModal:true,
            }
        },
        methods: {
            LoginSuccess() {
                this.showLoginModal = false;
                this.$emit('login-success');
            },
            LoginFailer() {
                this.$emit('login-fail');
            }
        }
    }
</script>