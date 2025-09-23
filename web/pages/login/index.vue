
<script lang="ts" setup>
    import { nextTick, onMounted, ref } from "vue";

    const login = useLogin()
    const auth = useSanctumUser();
    const router = useRouter()

    definePageMeta({
        layout: 'registration',
    })

    const isLoading = ref(false)

    const form = ref({
        email: '',
        password: ''
    })

    async function loginUser() {
        isLoading.value = true
        await login.loginUser(form.value)
        isLoading.value = false
    }

    async function checkLogin() {
        if (auth.value && auth.value.id) {
            router.push({
                path: '/dashboard'
            })
        }
    }

    onMounted(async ()=> {
        await nextTick()
        await checkLogin()
    })

</script>

<template>
    <div class="login-container d-flex align-items-center justify-content-center">
        <div class="border shadow rounded p-4 w-100 max-width-400">
            <b-form @submit.stop.prevent="loginUser">
                <div class="mb-4">
                    <label class="mb-2" for="email">Email:</label>
                    <b-input v-model="form.email" id="email" class="nitro-input w-100"></b-input>
                </div>
                <div class="mb-4">
                    <label class="mb-2" for="password">Password:</label>
                    <b-input v-model="form.password" type="password" id="password" class="nitro-input w-100"></b-input>
                </div>

                <b-button type="submit" variant="primary" class="w-100 py-2" :disabled="isLoading">LOGIN</b-button>
            </b-form>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .login-container {
        height: 100vh;
    }
</style>
