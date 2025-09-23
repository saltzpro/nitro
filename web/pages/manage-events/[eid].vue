<script lang="ts" setup>
    import { nextTick, onMounted, ref } from "vue";
    
    definePageMeta({
        middleware: ['sanctum:auth'],
    });

    const auth = useSanctumUser();
    const es = useEventStore()
    const event = useEvent()
    const router = useRouter()

    const form = ref({
        title: '',
        description: '',
        event_start: '',
        event_end: '',
        location: '',
        fb_link: '',
        event_waiver: '',
        terms_and_condition: '',
        pickup_notes: '',
    })

    onMounted(async () => {
        await nextTick()
        if (auth.value.role_id != 1) {
            router.push({
                path: '/dashboard'
            })

            return
        }
        
        await getSelectedEvent()
    })

    async function getSelectedEvent() {
        await event.getSelectedEvent({
            id: router.currentRoute.value.params.eid
        })

        let data = form.value
        const selected = es.selected.data
        data.title = selected.title
        data.description = selected.description
        data.location = selected.location,
        data.event_end = selected.event_end
        data.event_start = selected.event_start_at
        data.fb_link = selected.fb_link
        data.event_waiver = selected.event_waiver
        data.terms_and_condition = selected.terms_and_condition
        data.pickup_notes = selected.pickup_notes
    }

    function backToEventList() {
        router.back()
    }
</script>

<template>
    <div class="selected-event-container">
        <div class="d-flex align-items-center justify-content-between gap-16 mb-4">
            <b-button variant="primary" @click="backToEventList">Back to event list</b-button>
        </div>

        <card-container class="mb-4">
            <div class="mb-3">
                <h3 class="fw-bold">Event Information</h3>
            </div>
            <b-row class="mb-3">
                <b-col>
                    <b-form-group label="Event Title" label-for="title">
                        <b-form-input id="title" v-model="form.title"></b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
            
            <b-row class="mb-3">
                <b-col>
                    <b-form-group label="Event Description" label-for="description">
                        <b-form-textarea id="description" v-model="form.description" rows="1" max-rows="5"></b-form-textarea>
                    </b-form-group>
                </b-col>
            </b-row>

            <b-row class="mb-3">
                <b-col md="4">
                    <b-form-group class="w-100" label="Facebook Link" label-for="fb_link">
                        <b-form-input id="fb_link" v-model="form.fb_link"></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group class="w-100" label="Event End" label-for="event_end">
                        <b-form-input id="event_end" v-model="form.event_end"></b-form-input>
                    </b-form-group>
                </b-col>
                <b-col md="4">
                    <b-form-group class="w-100" label="Event End" label-for="event_end">
                        <b-form-input id="event_end" v-model="form.event_end"></b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
            
            <b-row>
                <b-col>
                    <b-form-group class="mb-3" label="Event Location" label-for="location">
                        <b-form-input id="location" v-model="form.location"></b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
        </card-container>
        
        <template v-if="es.selected">
            <card-container class="mb-4">
                <div class="mb-3 d-flex align-items-center justify-content-between gap-16">
                    <h3 class="fw-bold">Event Categories</h3>
                    <b-button variant="primary">Add category</b-button>
                </div>

                <b-row class="mb-3">
                    <b-col>
                        <card-container>
                            <b-table-simple responsive>
                                <b-thead>
                                    <b-tr>
                                        <b-th class="text-center">Categorys</b-th>
                                        <b-th class="text-center">Remarks</b-th>
                                        <b-th class="text-center">Original Price</b-th>
                                        <b-th class="text-center">Current Price</b-th>
                                        <b-th class="text-center">Action</b-th>
                                    </b-tr>
                                </b-thead>

                                <b-tbody v-if="es.selected.data && es.selected.data.categories">
                                    <b-tr v-for="category in es.selected.data.categories" :key="category">
                                        <b-td class="text-center">{{ category.name }}</b-td>
                                        <b-td class="text-center">{{ category.sub_name }}</b-td>
                                        <b-td class="text-center">{{ category.original_price }}</b-td>
                                        <b-td class="text-center fw-bold">{{ category.current_price }}</b-td>
                                        <b-td class="text-center">
                                            <b-button variant="danger">Remove</b-button>
                                        </b-td>
                                    </b-tr>
                                </b-tbody>
                            </b-table-simple>
                        </card-container>
                    </b-col>
                </b-row>
            </card-container>
            <card-container class="mb-4">
                <div class="mb-3 d-flex align-items-center justify-content-between gap-16">
                    <h3 class="fw-bold">Event Pick-up List</h3>
                    <b-button variant="primary">Add pickup</b-button>
                </div>
                
                <b-row class="mb-3">
                    <b-col>
                        <b-form-group label="Pickup note" label-for="pickup_notes">
                            <b-form-input id="pickup_notes" v-model="form.pickup_notes"></b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>
                <b-row>
                    <b-col>
                        <card-container>
                            <b-table-simple responsive>
                                <b-thead>
                                    <b-tr>
                                        <b-th class="text-center">Pick up option</b-th>
                                        <b-th></b-th>
                                    </b-tr>
                                </b-thead>

                                <b-tbody v-if="es.selected.data && es.selected.data.pickups">
                                    <b-tr v-for="pickup in es.selected.data.pickups" :key="pickup">
                                        <b-td class="text-center">{{ pickup.pickup_lists }}</b-td>
                                        <b-td class="text-center">
                                            <b-button variant="danger">Remove</b-button>
                                        </b-td>
                                    </b-tr>
                                </b-tbody>
                            </b-table-simple>
                        </card-container>
                    </b-col>
                </b-row>
            </card-container>
        </template>

           

        <card-container class="mb-4">
            <div class="mb-3">
                <h3 class="fw-bold">Event Waiver and Terms and Condition</h3>
            </div>
            <b-row class="mb-3">
                <b-col>
                    <b-form-group label="Event waiver" label-for="event_waiver">
                        <b-form-textarea id="event_waiver" v-model="form.event_waiver" rows="2" max-rows="30"></b-form-textarea>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row class="mb-3">
                <b-col>
                    <b-form-group label="Terms and Condition" label-for="terms_and_condition">
                        <b-form-textarea id="terms_and_condition" v-model="form.terms_and_condition" rows="2" max-rows="30"></b-form-textarea>
                    </b-form-group>
                </b-col>
            </b-row>
        </card-container>
    </div>
</template>

<style lang="scss" scoped>
    
</style>
