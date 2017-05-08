<template>
    <div class="container">
        <div class="columns">
            <div class="column">
                <h1 class="title">Login Now!!</h1>
                <al-Login-form></al-Login-form>
            </div>
        </div>
    </div>
</template>

<script>

    import LoginForm from '../model/LoginUserForm.vue'

    export default {
        name: 'Login',
        components: {
            'al-Login-form': LoginForm,
        }
    }

</script>