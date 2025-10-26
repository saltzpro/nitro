
<script lang="ts" setup>
    import { ref } from "vue"

    const event = useEvent()
    const es = useEventStore()
    const router = useRouter()

    const form = ref({
        event_id: router.currentRoute.value.params.eid,
        age_from: '',
        age_to: '',
    })

    const isLoading = ref(false)

    async function createAge() {
        isLoading.value = true
        
        const response = await event.createAge(form.value)

        form.value = {
            event_id: router.currentRoute.value.params.eid,
            age_from: '',
            age_to: '',
        }

        
        isLoading.value = false
    }
</script>

<template>
    <b-modal size="md" no-footer title="Create Pickup option" centered id="new-category-form" class="ss-default-modal">
        <b-container>
            <b-row>
                <b-col>
                    <div class="d-flex justify-content-center gap-10 w-100">
                        <b-form-group class="mb-3" label="Age from:" label-for="age_from">
                            <b-form-input type="number" v-model="form.age_from" id="age_from"></b-form-input>
                        </b-form-group>
                        
                        <b-form-group class="mb-3" label="Age to:" label-for="age_to">
                            <b-form-input type="number" v-model="form.age_to" id="age_to"></b-form-input>
                        </b-form-group>
                    </div>
                </b-col>
            </b-row>
            
            <b-row>
                <b-col>
                    <b-button v-if="!isLoading" @click="createAge" variant="primary" class="height-50 w-100">CREATE NEW CATEGORY</b-button>
                    <b-button v-else variant="primary" class="height-50 w-100 cursor-notallowed" disabled><b-spinner variant="light" small></b-spinner></b-button>
                </b-col>
            </b-row>
        </b-container>
    </b-modal>
</template>

<style lang="scss" scoped>
    
</style>
