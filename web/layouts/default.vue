<script lang="ts" setup>
    import { nextTick, onMounted, ref } from "vue";
    import { getData, setData } from 'nuxt-storage/local-storage';

    const login = useLogin()
    const auth = useSanctumUser()
    const us = useUserStore()
    const event = useEvent()
    
    const isLoading = ref(false)

    async function logoutUser() {
        isLoading.value = true
        await us.logoutUser()
        isLoading.value = false
    }

    onMounted(async () => {
        await nextTick()
        const res = await event.eventListForUser()

        if (!getData('selected-event')) {
            setData('selected-event', auth.value.id, 1, 'd')
        }

    })

</script>

<template>
    <div class="default-container admin position-relative">
        <div class="header-container px-4 shadow-sm position-sticky d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-10">
                <span class="fw-bold">Event name: </span>
                <b-button variant="danger" size="sm">Select event</b-button>
            </div>
            <b-dropdown variant="nitro-header-dropdown">
                <template #button-content>
                    <span class="fw-bold pr-4">{{ auth.name }}</span>
                </template>
                <b-dropdown-item>Account Information</b-dropdown-item>
                <b-dropdown-item @click="logoutUser">Logout</b-dropdown-item>
            </b-dropdown>
        </div>

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
        .header-container {
            height: 70px;
            top: 0px;
            z-index: 10;
            background-color: $white1;
        }

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
