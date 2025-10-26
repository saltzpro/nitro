
<script lang="ts" setup>
    import { ref } from "vue"
    
    const auth = useSanctumUser()
    const us = useUserStore()
    const router = useRouter()
    const { $swal } = useNuxtApp()

    const isLoading = ref(false)

    const eventTitle = ref(localStorage.getItem('event-title'))
    
    async function logoutUser() {
        isLoading.value = true
        await us.logoutUser()
        isLoading.value = false
        router.refresh()
    }

    function redirectToUserEvent() {
        
        $swal.fire({
            title: "Go back to event list",
            text: 'Would you like to go back to your event list?',
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes",
            showLoaderOnConfirm: true,
            allowOutsideClick: false,
            allowEscapeKey : false
        }).then((result: any) => {
            if (result.isConfirmed) {
                localStorage.removeItem('selected-event')
                localStorage.removeItem('event-title')

                window.location.href = '/user-events'
            }
        })
    }
</script>

<template>
    <div class="header-container px-4 shadow-sm position-sticky d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-20">
            <div class="d-flex align-item-center gap-10 max-width-350">
                <span v-if="eventTitle">Event: </span>
                <span class="truncate truncate--1 fw-bold">{{ eventTitle }}</span>
            </div>
            <b-button variant="danger" size="sm" @click="redirectToUserEvent()">Select event</b-button>
        </div>
        <b-dropdown variant="nitro-header-dropdown">
            <template #button-content>
                <span class="fw-bold pr-4">{{ auth.name }}</span>
            </template>
            <b-dropdown-item>Account Information</b-dropdown-item>
            <b-dropdown-item @click="logoutUser">Logout</b-dropdown-item>
        </b-dropdown>
    </div>
</template>

<style lang="scss">
    .header-container {
        height: 70px;
        top: 0px;
        z-index: 10;
        background-color: $white1;
    }
</style>
