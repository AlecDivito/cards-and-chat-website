<template>
    <div class="columns">
        <div class="column">
            <p>maybe we should put a card here and tell everyone how millions of people have used this platform for playing games</p>
            <p>And about this and that, throw up some really happy people running around and being happy and stuff</p>
        </div>
        <div class="column">
            <h2 class="title">Register an account with us.</h2>
            <al-register-form></al-register-form>
        </div>
    </div>
</template>

<script>

    import RegisterForm from '../model/CreateUserForm.vue'

    export default {
        name: 'register',
        components: {
            'al-register-form': RegisterForm,
        }
    }

</script>