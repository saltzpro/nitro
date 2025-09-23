<script lang="ts" setup>
import { nextTick, onMounted, ref } from "vue"
    const router = useRouter()
    const event = useEvent()
    const es = useEventStore()

    const eid = ref(router.currentRoute.value.params._eid)
    const countdownTime = ref('0000-00-00 00:00:00Z')
    const isLoading = ref(false)

    definePageMeta({
        layout: 'landingpage',
    });

    onMounted(async () => {
        isLoading.value = true
        await nextTick()
        await event.getEvent(eid.value)
        countdownTime.value = es.selected.event_start_at
        isLoading.value = false
    })

    function redirectToRegistration() {
        router.push({
            path: `/registration/${eid.value}`
        })
    }
</script>

<template>
    <div v-if="!isLoading && es.selected" class="registration-view-container">
        <div class="event-image-container">
            <img src="~assets/images/events/no-image-available.png" height="300" class="w-100 object-fit-contain" alt="no-image-available">
        </div>

        <b-container class="event-cd-container my-3 d-flex justify-content-center gap-16 w-100">
            <card-container class="w-100">
                <Countdown :date="new Date(countdownTime)" v-slot="{ days, hours, minutes, seconds }">
                    <div class="cd-container d-flex justify-content-center gap-16 mb-3">
                        <span class="cd-text py-2 fw-bold border-radius-10">{{ days }}
                            <span>Days</span>
                        </span>
                        <span class="cd-text py-2 fw-bold border-radius-10">{{ hours }}
                            <span>Hours</span>
                        </span>
                        <span class="cd-text py-2 fw-bold border-radius-10">{{ minutes }}
                            <span>Minutes</span>
                        </span>
                        <span class="cd-text py-2 fw-bold border-radius-10">{{ seconds }}
                            <span>Seconds</span>
                        </span>
                    </div>
                </Countdown>
                <div class="event-title">
                    <h3 class="truncate truncate--1">{{ es.selected.title }}</h3>
                </div>
                <div class="location d-flex align-items-center gap-6 mb-1">
                    <img src="~assets/images/events/location.png" height="20" class="object-fit-contain" alt="">
                    <span v-if="es.selected.location">{{ es.selected.location }}</span>
                    <span v-else>No location yet</span>
                </div>
                <div class="location d-flex align-items-center gap-6 mb-3">
                    <img src="~assets/images/events/calendar.png" height="20" class="object-fit-contain" alt="">
                    <span v-if="es.selected.event_start">{{ es.selected.event_start }}</span>
                    <span v-else>No dates yet</span>
                </div>
                <div class="d-flex gap-10">
                    <b-button variant="primary" class="px-4" size="md" @click="redirectToRegistration">REGISTER NOW</b-button>
                    <b-button variant="primary" class="px-4" size="md" @click="router.back()">Back to event list</b-button>
                </div>
            </card-container>
        </b-container>

        <b-container>
            <b-row>
                <b-col>
                    <card-container></card-container>
                </b-col>
            </b-row>
        </b-container>
    </div>
</template>

<style lang="scss" scoped>
    .registration-view-container {
        .event-cd-container {
            .card-container {

                .cd-container {
                    .cd-text {
                        @include poppins-font(24px, normal, 900, $black3);
                        background-color: $gray3;
                        max-width: 70px;
                        width: 100%;
                        text-align: center;

                        > span {
                            display: block;
                            font-size: 14px !important;
                            font-weight: 400;
                        }
                    }
                }
            }
        }
    }
</style>
