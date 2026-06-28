<script lang="ts" setup>
    definePageMeta({
        middleware: ['sanctum:auth'],
    });

    const auth = useSanctumUser();
    const event = useEvent()
    const es = useEventStore()

    onMounted(async () => {
        await nextTick()
        await es.getOrganizerEvent({ event_id: localStorage.getItem('selected-event') })
    })  
</script>

<template>
    <div class="event-management-container">
        <h1 class="fw-bold mb-3">Event Management</h1>

        <b-row>
            <b-col>
                
                <div class="p-4 shadow-sm rounded border">

                </div>
            </b-col>
        </b-row>
    </div>
</template>

<style lang="scss" scoped>
    
</style>
