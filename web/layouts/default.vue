<script lang="ts" setup>
    import { nextTick, onMounted, ref } from "vue";
    import { getData, setData } from 'nuxt-storage/local-storage';

    const login = useLogin()
    const auth = useSanctumUser()
    const us = useUserStore()
    const event = useEvent()
    
    const isLoading = ref(false)


    onMounted(async () => {
        await nextTick()
    })

</script>

<template>
    <div class="default-container admin position-relative">

        <card-header></card-header>

        <div class="sidebar-menu-container position-absolute shadow-sm d-flex flex-column">
            <nuxt-link to="/dashboard" class="menu w-100 py-2 cursor-pointer d-flex">
                <img src="~assets/images/menu/dashboard.png" height="50" class="m-auto object-fit-contain" alt="">
            </nuxt-link>
            <nuxt-link to="/report" class="menu w-100 py-2 cursor-pointer d-flex">
                <img src="~assets/images/menu/reports.png" height="40" class="m-auto object-fit-contain" alt="">
            </nuxt-link>
        </div>
        
        <div class="main-container">
            <slot></slot>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .admin {

        .sidebar-menu-container {
            height: 100vh;
            width: 110px;
            left: 0;
            top: 0;
            background-color: $white1;
            padding-top: 80px;

            .menu {
                height: 70px;
                transition: 0.3s;
                &:hover {
                    background-color: $black5;
                }
            }
        }

        .main-container {
            padding-left: 130px;
            padding-top: 1rem;
            padding-right: 1rem;
        }
    }
</style>
