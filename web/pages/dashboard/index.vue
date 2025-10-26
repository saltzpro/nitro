
<script lang="ts" setup>
import { nextTick, onMounted, ref, triggerRef } from "vue";

    definePageMeta({
        middleware: ['sanctum:auth'],
    });

    const event_id = ref(localStorage.getItem('selected-event'));
    
    const auth = useSanctumUser();
    const event = useEvent()
    const es = useEventStore()
    const utils = useUtils()

    const isBusyRecent = ref(false)
    const isBusyRegistration = ref(false)
    const isBusyConfirmed = ref(false)
    const isBusyFulfil = ref(false)
    const registrations = ref({})

    const openParticipantInformation = ref(false)
    const selectedParticipants = ref(null)

    async function getRegistrations(type: any) {
        registrations.value = await event.getPendingRegistration(type, event_id.value)
    }

    async function getDashboardSummary(payloads: any) {
        await event.getDashboardSummary(event_id.value)
    }

    async function getParticipantInformation(participant: any) {
        openParticipantInformation.value = true
        selectedParticipants.value = participant
    }

    async function recentlyActivities() {
        await event.recentlyActivities({
            event_id: event_id.value
        })
    }

    async function saveClose() {
        await initLoad()
        openParticipantInformation.value = false
    }

    async function initLoad() {
        isBusyRecent.value = true
        isBusyRegistration.value = true
        isBusyRecent.value = false
        await getRegistrations('all')
        isBusyRegistration.value = false
        await event.getDashboardSummary(event_id.value)
        await recentlyActivities()
    }

    onMounted(async () => {
        await nextTick()
        await initLoad()
    })
    
</script>

<template>
    <div class="dashboard-container">
        <h1 class="fw-bold mb-3">Dashboard</h1>
        
        <b-row class="mb-4">
            <b-col md="3">
                <div class="dashboard-overview p-3 shadow-sm border rounded d-flex flex-column align-items-center gap-16">
                    <span class="title text-primary">TOTAL AMOUNT COLLECTED</span>

                    <div class="">
                        <span class="amount">
                            {{ utils.currencyFormat(es.dashboardSummary.collected) }}
                        </span>
                    </div>

                    <div class="view cursor-pointer">
                        <span>View Balance</span>
                    </div>
                </div>
            </b-col>

            <b-col md="3">
                <div class="dashboard-overview p-3 shadow-sm border rounded d-flex flex-column align-items-center gap-16">
                    <span class="title text-warning">TOTAL REGISTRATIONS</span>

                    <div class="">
                        <span class="amount">
                            {{ utils.numberFormat(es.dashboardSummary.pending) }}
                        </span>
                    </div>

                    <div class="view cursor-pointer">
                        <span>View Registrations</span>
                    </div>
                </div>
            </b-col>

            <b-col md="3">
                <div class="dashboard-overview p-3 shadow-sm border rounded d-flex flex-column align-items-center gap-16">
                    <span class="title text-success">CONFIRMED PARTICIPANTS</span>

                    <div class="">
                        <span class="amount">
                            {{ utils.numberFormat(es.dashboardSummary.confirmed) }}
                        </span>
                    </div>

                    <div class="view cursor-pointer">
                        <span>View Participants</span>
                    </div>
                </div>
            </b-col>
            
            <b-col md="3">
                <div class="dashboard-overview p-3 shadow-sm border rounded d-flex flex-column align-items-center gap-16">
                    <span class="title text-info">FULFILLED ORDERS</span>

                    <div class="">
                        <span class="amount">
                            {{ utils.numberFormat(es.dashboardSummary.fullfil) }}
                        </span>
                    </div>

                    <div class="view cursor-pointer">
                        <span>View Orders</span>
                    </div>
                </div>
            </b-col>

        </b-row>

        <b-row class="mb-4">
            <b-col>
                <div class="p-4 shadow-sm rounded border">
                    <h4 class="fw-bold">RECENT ACTIVITIES</h4>
                    <div class="mt-4">
                        <b-table-simple striped hover :isBusy="isBusyRegistration">
                            <b-thead>
                                <b-th class="padding-all-8">#</b-th>
                                <b-th class="padding-all-8">Transaction number</b-th>
                                <b-th class="padding-all-8">Logs</b-th>
                            </b-thead>
                            <b-tbody>
                                <b-tr v-for="(item, i) in es.recentAcivitiesList" :key="i">
                                    <b-td>{{ item.registration_id }}</b-td>
                                    <b-td><span class="text-primary cursor-pointer" style="text-decoration: underline;">{{ item.transaction_number }}</span></b-td>
                                    <b-td>{{ item.logs }}</b-td>
                                </b-tr>
                            </b-tbody>
                        </b-table-simple>
                    </div>
                </div>
            </b-col>
        </b-row>

        <b-row class="mb-4">
            <b-col>
                <div class="p-4 shadow-sm rounded border">
                    <h4 class="fw-bold">REGISTRATION LIST</h4>

                    <div class="mt-4">
                        <b-table-simple striped hover :isBusy="isBusyRegistration">
                            <b-thead>
                                <b-th class="padding-all-8">#</b-th>
                                <b-th class="padding-all-8">First Name</b-th>
                                <b-th class="padding-all-8">Middle Name</b-th>
                                <b-th class="padding-all-8">Last Name</b-th>
                                <b-th class="padding-all-8">Email address</b-th>
                                <b-th class="text-center padding-all-8">Contact #</b-th>
                                <b-th class="text-center padding-all-8">Gender</b-th>
                                <b-th class="text-center padding-all-8">Category</b-th>
                                <b-th class="text-center padding-all-8">Total</b-th>
                                <b-th class="text-center padding-all-8">Status</b-th>
                                <b-th class="text-center padding-all-8">Action</b-th>
                            </b-thead>
                            <b-tbody>
                                <b-tr v-for="(item, i) in registrations.data" :key="i">
                                    <b-td>{{ item.id }}</b-td>
                                    <b-td>{{ item.first_name }}</b-td>
                                    <b-td>{{ item.middle_name }}</b-td>
                                    <b-td>{{ item.last_name }}</b-td>
                                    <b-td>{{ item.email }}</b-td>
                                    <b-td class="text-center">{{ item.contact_number }}</b-td>
                                    <b-td class="text-center">{{ item.gender }}</b-td>
                                    <b-td class="text-center">{{ item.category.name }}</b-td>
                                    <b-td class="text-center" v-if="item.event_category_total">{{ utils.currencyFormat(item.event_category_total) }}</b-td>
                                    <b-td class="text-center">
                                        <b-badge v-if="item.event_status == 'pending'" variant="danger" class="text-uppercase">{{ item.event_status }}</b-badge>
                                        <b-badge v-if="item.event_status == 'confirmed'" variant="info" class="text-uppercase">{{ item.event_status }}</b-badge>
                                        <b-badge v-if="item.event_status == 'fulfil'" variant="success" class="text-uppercase">{{ item.event_status }}</b-badge>
                                    </b-td>
                                    <b-td class="text-center">
                                        <div class="d-flex gap-10 justify-content-center">
                                            <b-button variant="primary" @click="getParticipantInformation(item)">View</b-button>
                                        </div>
                                    </b-td>
                                </b-tr>
                            </b-tbody>
                        </b-table-simple>
                    </div>
                </div>
                
            </b-col>
        </b-row>

        <modal-participant-info v-model="openParticipantInformation" @close="saveClose" :info="selectedParticipants"></modal-participant-info>
    </div>
</template>

<style lang="scss" scoped>
    .dashboard-container {
        .dashboard-overview {
            .title {
                font-size: 20px;
                font-weight: 700;
            }

            .amount {
                font-size: 32px;
                font-weight: 900; 
                
            }

            .view { 
                font-size: 16px;
                font-weight: 500;
                color: $black1;
            }
        }
    }
</style>
