
<script lang="ts" setup>

    import { ref } from "vue";

    const event = useEvent()
    const es = useEventStore()

    const router = useRouter()

    const form = ref({
        event_id: router.currentRoute.value.params.eid,
        name: null,
        sub_name: null,
        original_price: null,
        current_price: null,
        category_image: null,
    })

    const isLoading = ref(false)

    async function createCategory() {
        isLoading.value = true
        const response = await event.createCategory(form.value)

        form.value = {
            event_id: router.currentRoute.value.params.eid,
            name: null,
            sub_name: null,
            original_price: null,
            current_price: null,
            category_image: null,
        }

        
        isLoading.value = false
        
    }
</script>

<template>
    <b-modal size="md" no-footer title="New Event Category" centered id="new-category-form" class="ss-default-modal">
        <b-container>
            <b-row>
                <b-col>
                    <b-form-group class="mb-3" label="Category" label-for="category">
                        <b-form-input v-model="form.name" id="category"></b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
            
            <b-row>
                <b-col>
                    <b-form-group class="mb-3" label="Remarks" label-for="remarks">
                        <b-form-textarea v-model="form.sub_name" id="remarks" rows="10" max-rows="10"></b-form-textarea>
                    </b-form-group>
                </b-col>
            </b-row>
            
            <b-row class="mb-3">
                <b-col sm="6">
                    <b-form-group class="mb-3" label="Original Price" label-for="originalPrice">
                        <b-form-input v-model="form.original_price" id="originalPrice"></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col sm="6">
                    <b-form-group class="mb-3" label="Current Price" label-for="currentPrice">
                        <b-form-input v-model="form.current_price" id="currentPrice"></b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
            
            <b-row class="mb-2">
                <b-col>
                    <b-button v-if="!isLoading" @click="createCategory" variant="primary" class="height-50 w-100">CREATE NEW CATEGORY</b-button>
                    <b-button v-else variant="primary" class="height-50 w-100 cursor-notallowed" disabled><b-spinner variant="light" small></b-spinner></b-button>
                </b-col>
            </b-row>
        </b-container>
    </b-modal>
</template>

<style lang="scss" scoped>
    
</style>
