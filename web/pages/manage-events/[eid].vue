<script lang="ts" setup>
    import { nextTick, onMounted, ref } from "vue";
    
    definePageMeta({
        middleware: ['sanctum:auth'],
    });

    const auth = useSanctumUser();
    const es = useEventStore()
    const ecs = useEventCategoryStore()
    const event = useEvent()
    const router = useRouter()
    const { $swal } = useNuxtApp()

    const form = ref({
        id: '',
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

    const isLoadingUpdate = ref(false)

    const openCategoryForm = ref(false)
    const openPickupForm = ref(false)
    const openShirtForm = ref(false)
    const openAgeForm = ref(false)

    const shirts = ref([])

    onMounted(async () => {
        await nextTick()
        if (auth.value.role_id != 1) {
            router.push({
                path: '/dashboard'
            })

            return
        }
        
        await getSelectedEvent()

        handleUpdateSize()
    })

    async function getSelectedEvent() {
        await event.getSelectedEvent({
            id: router.currentRoute.value.params.eid
        })

        let data = form.value
        const selected = es.selected
        data.id = selected.id
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

    async function updateSelectedEvent() {
        isLoadingUpdate.value = true
        const response = await event.updateSelectedEvent(form.value)
        isLoadingUpdate.value = false
    }

    function handleUpdateSize() {
        if (es.getShirts) {
            shirts.value = es.getShirts
            shirts.value = es.getShirts.map((n: any) => {
                if (!Array.isArray(n.shirt_sizes)) {
                    n.shirt_sizes = n.shirt_sizes.replace('[', '').replace(']', '').replace(/['"]+/g, '')
                    n.shirt_sizes = n.shirt_sizes.split(',')
                }
                n.isAlreadySelect = false
                n.selected_size = ''
                return n
            })
        }
    }

    async function deleteRecord(item: any, idx: any, type: any) {
        $swal.fire({
            title: 'Delete record?',
            text: `Do you want to delete selected ${type} record?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                await event.deleteRecord(item, idx, type)
                if (type == 'shirt') {
                    handleUpdateSize()
                }
            },
            allowOutsideClick: () => !$swal.isLoading(),
        })
        .then(async (result: any) => {
            if (result.isConfirmed) {
            }
        });
    }
</script>

<template>
    <div class="selected-event-container">
        <div class="d-flex align-items-center justify-content-between gap-16 mb-4">
            <b-button variant="primary" @click="backToEventList">Back to event list</b-button>
        </div>

        <card-container class="mb-4">
            <div class="mb-3 d-flex align-items-center justify-content-between gap-16">
                <h3 class="fw-bold">Event Information</h3>
                <b-button variant="primary" @click="updateSelectedEvent">
                    <span v-if="!isLoadingUpdate">Update</span>
                    <span v-else><b-spinner variant="light" small></b-spinner></span>
                </b-button>

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
                
            <b-row class="mb-3">
                <b-col>
                    <b-form-group label="Pickup note" label-for="pickup_notes">
                        <b-form-input id="pickup_notes" v-model="form.pickup_notes"></b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
            
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
        
        <template v-if="es.selected">
            <card-container class="mb-4">
                <div class="mb-3 d-flex align-items-center justify-content-between gap-16">
                    <h3 class="fw-bold">Event Categories</h3>
                    <b-button variant="primary" @click="openCategoryForm = true">Add category</b-button>
                </div>

                <b-row class="mb-3">
                    <b-col>
                        <card-container>
                            <b-table-simple responsive>
                                <b-thead>
                                    <b-tr>
                                        <b-th class="text-center">#</b-th>
                                        <b-th class="text-center">Category</b-th>
                                        <b-th class="text-center">Remarks</b-th>
                                        <b-th class="text-center">Original Price</b-th>
                                        <b-th class="text-center">Current Price</b-th>
                                        <b-th class="text-center">Action</b-th>
                                    </b-tr>
                                </b-thead>

                                <b-tbody v-if="es.selected && es.selected.categories">
                                    <b-tr v-for="(category, i) in es.selected.categories" :key="`category-${i}`">
                                        <b-td class="text-center">{{ i+1 }}</b-td>
                                        <b-td class="text-center">{{ category.name }}</b-td>
                                        <b-td class="text-center">{{ category.sub_name }}</b-td>
                                        <b-td class="text-center">{{ category.original_price }}</b-td>
                                        <b-td class="text-center fw-bold">{{ category.current_price }}</b-td>
                                        <b-td class="text-center">
                                            <b-button @click="deleteRecord(category, i, 'category')" variant="danger">Remove</b-button>
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
                    <b-button variant="primary" @click="openPickupForm = true">Add pickup</b-button>
                </div>
                <b-row>
                    <b-col>
                        <card-container>
                            <b-table-simple responsive>
                                <b-thead>
                                    <b-tr>
                                        <b-th class="text-center">#</b-th>
                                        <b-th class="text-center">Pick up option</b-th>
                                        <b-th></b-th>
                                    </b-tr>
                                </b-thead>

                                <b-tbody v-if="es.selected && es.selected.pickups">
                                    <b-tr v-for="(pickup, i) in es.selected.pickups" :key="`pickup-${i}`">
                                        <b-td class="text-center">{{ i+1 }}</b-td>
                                        <b-td class="text-center">{{ pickup.pickup_lists }}</b-td>
                                        <b-td class="text-center">
                                            <b-button @click="deleteRecord(pickup, i, 'pickup')" variant="danger">Remove</b-button>
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
        
            <div class="mb-3 d-flex align-items-center justify-content-between gap-16">
                <h3 class="fw-bold">T-Shirt types</h3>
                <b-button variant="primary" @click="openShirtForm = true">Add t-shirt Type</b-button>
            </div>
            <b-row>
                <b-col>
                    <card-container>
                        <b-table-simple responsive>
                            <b-thead>
                                <b-tr>
                                    <b-th class="text-center">#</b-th>
                                    <b-th class="text-center">Title</b-th>
                                    <b-th class="text-center">Description</b-th>
                                    <b-th class="text-center">Sizes</b-th>
                                    <b-th></b-th>
                                </b-tr>
                            </b-thead>

                            <b-tbody v-if="es.selected && es.selected">
                                <b-tr v-for="(shirt, i) in shirts" :key="`shirts-${i}`">
                                    <b-td class="text-center">{{ i+1 }}</b-td>
                                    <b-td class="text-center">{{ shirt.shirt_title }}</b-td>
                                    <b-td class="text-center">{{ shirt.shirt_description }}</b-td>

                                    <b-td class="text-center">
                                        <div class="d-flex justify-content-center gap-10 w-100">
                                            <b-badge v-for="size in shirt.shirt_sizes" :key="size" variant="primary">{{ size }}</b-badge>
                                        </div>
                                    </b-td>
                                    <b-td class="text-center">
                                        <b-button @click="deleteRecord(shirt, i, 'shirt')" variant="danger">Remove</b-button>
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
                <h3 class="fw-bold">Age filter</h3>
                <b-button variant="primary" @click="openAgeForm = true">New age filter</b-button>
            </div>
            <b-row>
                <b-col>
                    <card-container>
                        <b-table-simple responsive>
                            <b-thead>
                                <b-tr>
                                    <b-th class="text-center">#</b-th>
                                    <b-th class="text-center">Age from</b-th>
                                    <b-th class="text-center">Age to</b-th>
                                    <b-th></b-th>
                                </b-tr>
                            </b-thead>

                            <b-tbody v-if="es.selected && es.selected.ages">
                                <b-tr v-for="(age, i) in es.selected.ages" :key="`shirts-${i}`">
                                    <b-td class="text-center">{{ i+1 }}</b-td>
                                    <b-td class="text-center">{{ age.age_from }}</b-td>
                                    <b-td class="text-center">{{ age.age_to }}</b-td>
                                    <b-td class="text-center">
                                        <b-button @click="deleteRecord(age, i, 'age')" variant="danger">Remove</b-button>
                                    </b-td>
                                </b-tr>
                            </b-tbody>
                        </b-table-simple>
                    </card-container>
                </b-col>
            </b-row>
        </card-container>

        <modal-category-form v-model="openCategoryForm" @close="openCategoryForm = false"></modal-category-form>
        <modal-pickup-form v-model="openPickupForm" @close="openPickupForm = false"></modal-pickup-form>
        <modal-shirt-form v-model="openShirtForm" @updateSize="handleUpdateSize" @close="openShirtForm = false"></modal-shirt-form>
        <modal-age-form v-model="openAgeForm" @close="openAgeForm = false"></modal-age-form>
    </div>
</template>

<style lang="scss" scoped>
    
</style>
