<script lang="ts" setup>

    const router = useRouter()

    function redirectToLogin() {
        router.push({
            path: '/login'
        })
    }

</script>

<template>
    <div class="default-container">
        <div class="default-header px-5 d-flex justify-content-between align-items-center">
            <div class="header-logo">
                <nuxt-img src="/nitro-logo.png" height="50"></nuxt-img>
            </div>

            <div>
                <b-button variant="danger" class="px-3" @click="redirectToLogin">LOGIN</b-button>
            </div>
        </div>
        <slot></slot>
    </div>
</template>

<style lang="scss" scoped>
    .default-container {
        .default-header {
            height: 70px;
            .header-logo {
                
            }
        }
    }
</style>
