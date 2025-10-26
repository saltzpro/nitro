<script lang="ts" setup>
import { nextTick, onMounted, ref } from "vue";
import { getData, setData } from 'nuxt-storage/local-storage';

    const event = useEvent()
    const es = useEventStore()
    const router = useRouter()
    const { $swal } = useNuxtApp()

    definePageMeta({
        layout: 'userevents',
    });

    const isLoading = ref(false)

    function selectEvent(item: any) {

        $swal.fire({
            title: "Redirect to the event?",
            text: 'Would you like to redirect to the selected event?',
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
                localStorage.setItem('selected-event', item.id.toString())
                localStorage.setItem('event-title', item.title)
                
                window.location.href = '/dashboard'
            }
        })
    }

    onMounted(async () => {
        await nextTick()
        await event.userAddedEvent()
    })
</script>

<template>
    <div class="user-events-container">
        <card-container class="event-container d-flex align-items-center justify-content-center flex-column p-3 gap-16 m-auto mt-5">
            <b-input class="nitro-input" placeholder="Search event"></b-input>
            <card-container class="w-100">
                <div v-for="(item, i) in es.linked_events" :key="`linked-event-${i}`" class="event-wrapper d-flex align-items-center justify-content-between px-2 py-3 border-bottom-black1-1 cursor-pointer gap-16">
                        <div><span class="fw-bold">Event title: </span><span class="truncate truncate--2">{{ item.title }}</span></div>

                        <b-button v-if="!isLoading" variant="primary" @click="selectEvent(item)">Select</b-button>
                </div>
            </card-container>
        </card-container>
        
    </div>
</template>

<style lang="scss" scoped>
    .user-events-container {
        max-width: 800px;
        width: 100%;
        .event-wrapper {

            transition: 0.3s;

            &:hover {
                background-color: $gray4;
            }
        }
    }
</style>
