
<script lang="ts" setup>
    import { ref } from "vue"

    const event = useEvent()
    const es = useEventStore()
    const router = useRouter()

    const form = ref({
        event_id: router.currentRoute.value.params.eid,
        pickup_lists: '',
    })

    const isLoading = ref(false)

    async function createPickup() {
        isLoading.value = true
        
        const response = await event.createPickup(form.value)

        form.value = {
            event_id: router.currentRoute.value.params.eid,
            pickup_lists: '',
        }

        
        isLoading.value = false
    }
</script>

<template>
    <b-modal size="md" no-footer title="Create Pickup option" centered id="new-category-form" class="ss-default-modal">
        <b-container>
            <b-row>
                <b-col>
                    <b-form-group class="mb-3" label="Pickup option" label-for="Pickup">
                        <b-form-input v-model="form.pickup_lists" id="category"></b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
            
            <b-row>
                <b-col>
                    <b-button v-if="!isLoading" @click="createPickup" variant="primary" class="height-50 w-100">CREATE NEW CATEGORY</b-button>
                    <b-button v-else variant="primary" class="height-50 w-100 cursor-notallowed" disabled><b-spinner variant="light" small></b-spinner></b-button>
                </b-col>
            </b-row>
        </b-container>
    </b-modal>
</template>

<style lang="scss" scoped>
    
</style>
