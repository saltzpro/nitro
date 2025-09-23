<script lang="ts" setup>
import { nextTick, onMounted, ref } from "vue";
    
    definePageMeta({
        middleware: ['sanctum:auth'],
    });

    const auth = useSanctumUser();
    const es = useEventStore()
    const event = useEvent()
    const router = useRouter()

    onMounted(async () => {
        await nextTick()
        if (auth.value.role_id != 1) {
            router.push({
                path: '/dashboard'
            })
        }

        await allEvents({
            search: ''
        })
    })

    async function allEvents(payloads: any) {
        await event.allEvents(payloads)
    }

    function redirectToEvent(event: any) {
        router.push({
            path: `/manage-events/${event.id}`
        })
    }

</script>

<template>
    <div class="all-event-list-container">
        <div class="mb-5 mt-2">
            <h1 class="fw-bold">EVENTS LIST</h1>
        </div>

        <div class="all-event-list">
            <!-- <card-event v-for="(item, i) in es.all_event_list" :key="`event-${i}`" :info="item"></card-event> -->
            <card-container>
                <b-table-simple>
                    <b-thead>
                        <b-tr>
                            <b-th>#</b-th>
                            <b-th>Event Title</b-th>
                            <b-th>Category</b-th>
                            <b-th>Location</b-th>
                            <b-th>Event Start</b-th>
                            <b-th></b-th>
                        </b-tr>
                    </b-thead>
                    <b-tbody>
                        <b-tr v-for="(item, i) in es.all_event_list" :key="`event-${i}`">
                            <b-td>{{ item.id }}</b-td>
                            <b-td>{{ item.title }}</b-td>
                            <b-td>
                                <div v-if="item.categories && item.categories.length" class="d-flex gap-10">
                                    <b-badge v-for="category in item.categories" :key="`category=${category}`" variant="primary">{{ category.name }}</b-badge>
                                </div>
                                <div v-else>
                                    <b-badge variant="danger">No category display</b-badge>
                                </div>
                            </b-td>
                            <b-td>
                                <span v-if="item.location">{{ item.location }}</span>
                                <span v-else>No location yet</span>
                            </b-td>
                            <b-td>
                                <span v-if="item.event_start">{{ item.event_start }}</span>
                                <span v-else>No dates yet</span>
                            </b-td>
                            <b-td>
                                <div class="d-flex gap-10">
                                    <b-button variant="primary" class="text-nowrap" @click="redirectToEvent(item)">View event</b-button>
                                    <b-button variant="danger" class="text-nowrap">Deactivate</b-button>
                                </div>
                            </b-td>
                        </b-tr>
                    </b-tbody>
                </b-table-simple>
            </card-container>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .all-event-list-container {
        .all-event-list {
        }
    }
</style>
