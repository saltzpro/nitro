<script lang="ts" setup>
    import { onMounted, ref, watch } from "vue"
    const router = useRouter()
    interface Props {
        info: any,
    }

    const props = withDefaults(defineProps<Props>(), {
        info: null,
    })

    watch(() => props.info, async(val: any) => {
        if (val) {
            console.log(val)
        }
    })

    function redirectToEvent() {
        router.push({
            path: `/event/${props.info.id}`
        })
    }

</script>

<template>
    <div class="card-event-container cursor-pointer">
        <card-container class="h-100" v-if="info" @click="redirectToEvent()">
            <div class="card-event-banner">
                <img src="~assets/images/events/no-image-available.png" width="450" height="150" class="object-fit-contain" alt="no-image-available">
            </div>

            <div class="card-event-listing mt-3">
                <div class="title mb-1">
                    <span class="fw-bold truncate truncate--1">{{ info.title }}</span>
                </div>
                <div v-if="info.categories && info.categories.length" class="categories mb-2 d-flex gap-10 align-items-center">
                    <b-badge v-for="category in info.categories" :key="`category=${category}`" variant="primary">{{ category.name }}</b-badge>
                </div>
                <div v-else class="categories mb-2 d-flex gap-10 align-items-center">
                    <b-badge variant="danger">No category display</b-badge>
                </div>
                <div class="location d-flex align-items-center gap-6">
                    <img src="~assets/images/events/location.png" height="20" class="object-fit-contain" alt="">
                    <span v-if="info.location">{{ info.location }}</span>
                    <span v-else>No location yet</span>
                </div>
                <div class="location d-flex align-items-center gap-6">
                    <img src="~assets/images/events/calendar.png" height="20" class="object-fit-contain" alt="">
                    <span v-if="info.event_start">{{ info.event_start }}</span>
                    <span v-else>No dates yet</span>
                </div>
            </div>
        </card-container>
    </div>
</template>

<style lang="scss" scoped>
    .card-event-container {
        max-width: 500px;
        .card-event-listing {
            .title {
                font-size: 20px;
            
            }

            .location {
                font-size: 16px;
                color: $gray2;
            }
        }
    }
</style>
