<script lang="ts" setup>
    import { nextTick, onMounted } from "vue";

    definePageMeta({
        layout: 'landingpage',
    });

    const event = useEvent()
    const es = useEventStore()

    onMounted(async () => {
        await nextTick()
        await event.getEventList({ limit: 10 })
    })
</script>

<template>
    <div class="events-container padding-top-30 padding-bottom-30">
        <div class="mb-5 mt-2">
            <h1 class="fw-bold text-center">EVENTS LIST</h1>
        </div>

        <div class="event-list-container d-flex gap-16 flex-wrap justify-content-center">
            <card-event v-for="(item, i) in es.eventList" :key="`event-${i}`" :info="item"></card-event>
        </div>
    </div>
</template>

<style lang="scss">
    .events-container {
        max-width: 1680px;
        margin: auto;
    }
</style>
