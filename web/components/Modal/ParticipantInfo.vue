<script lang="ts" setup>

    const event = useEvent()
    const isLoading = ref(false)

    import { onMounted, ref, watch } from "vue"
    interface Props {
        info: any,
        isOpen: any, 
    }

    const props = withDefaults(defineProps<Props>(), {
        info: null,
        isOpen: false,
    })

    const emit = defineEmits(['close'])

    const form = ref(null)

    watch(() => props.info, async(val: any) => {
        if (val) {
            form.value = val
            console.log(val)
        }
    })

    async function moveToNextStatus() {
        let status = 'pending'
        if (props.info.event_status == 'pending') {
            status = 'confirmed'
        } else if (props.info.event_status == 'confirmed') {
            status = 'fulfil'
        }
        
        isLoading.value = true
        await event.storeCollection({
            registration_id: props.info.id,
            event_id: props.info.event_id,
            event_status: status
        })
        isLoading.value = false
        emit('close')
    }

</script>

<template>
    <b-modal size="md" no-footer title="Registration information" centered id="select-event-modal" class="ss-default-modal">
        
        <div v-if="form">
            <div class="mb-4 d-flex align-items-center justify-content-between gap-16">
                <div class="d-flex align-items-center gap-10">
                    <span>Status:</span>
                    <b-badge v-if="form.event_status == 'pending'" variant="danger" class="text-uppercase">{{ form.event_status }}</b-badge>
                    <b-badge v-if="form.event_status == 'confirmed'" variant="info" class="text-uppercase">{{ form.event_status }}</b-badge>
                    <b-badge v-if="form.event_status == 'fulfil'" variant="success" class="text-uppercase">{{ form.event_status }}</b-badge>
                </div>

                <b-button @click="moveToNextStatus()" v-if="form.event_status == 'pending' || form.event_status == 'confirm'" variant="primary" :disabled="isLoading">
                    <span v-if="form.event_status == 'pending'">Move to confirm</span>
                    <span v-if="form.event_status == 'confirm'">Move to fulfill</span>
                </b-button>
            </div>
            
            <div class="mb-2">
                <label class="mb-2" for="transaction_number">Transaction number:</label>
                <b-input v-model="form.transaction_number" id="transaction_number" class="nitro-input w-100 fw-bold" disabled></b-input>
            </div>

            
            <b-row class="mb-2">
                <b-col sm="6">
                    <label class="mb-2" for="transaction_number">Transaction number:</label>
                    <b-input v-model="form.transaction_number" id="transaction_number" class="nitro-input w-100" disabled></b-input>
                </b-col>
                <b-col sm="6">
                    <label class="mb-2" for="category">Category:</label>
                    <b-input v-model="form.category.name" id="category" class="nitro-input w-100" disabled></b-input>
                </b-col>
            </b-row>

            <b-row class="my-4">
                <b-col sm="4">
                    <label class="mb-2" for="event_category_total">Total Amount</label>
                    <b-input v-model="form.event_category_total" id="event_category_total" class="nitro-input w-100" disabled></b-input>
                </b-col>
                <b-col sm="4">
                    <label class="mb-2" for="admin_fees">Admin fees</label>
                    <b-input v-model="form.admin_fees" id="admin_fees" class="nitro-input w-100" disabled></b-input>
                </b-col>
                <b-col sm="4">
                    <label class="mb-2" for="total_payment">Total Paid</label>
                    <b-input v-model="form.total_payment" id="total_payment" class="nitro-input w-100" disabled></b-input>
                </b-col>
            </b-row>
            <b-row class="mb-2">
                <b-col sm="6">
                    <label class="mb-2" for="first_name">First name:</label>
                    <b-input v-model="form.first_name" id="first_name" class="nitro-input w-100" disabled></b-input>
                </b-col>
                <b-col sm="6">
                    <label class="mb-2" for="last_name">Last name:</label>
                    <b-input v-model="form.last_name" id="last_name" class="nitro-input w-100" disabled></b-input>
                </b-col>
            </b-row>
            <div class="mb-2">
                <label class="mb-2" for="email">Email:</label>
                <b-input v-model="form.email" id="email" class="nitro-input w-100" disabled></b-input>
            </div>
            <b-row class="mb-2">
                <b-col sm="6">
                    <label class="mb-2" for="contact_number">Contact number:</label>
                    <b-input v-model="form.contact_number" id="contact_number" class="nitro-input w-100" disabled></b-input>
                </b-col>
                <b-col sm="6">
                    <label class="mb-2" for="gender">Gender:</label>
                    <b-input v-model="form.gender" id="gender" class="nitro-input w-100 text-uppercase" disabled></b-input>
                </b-col>
            </b-row>

            <div class="mt-4 mb-2" v-for="(item, i) in form.tshirts" :key="`tshirt-${i}`">
                <div class="fw-bold text-center mb-2">TSHIRT INFORMATION</div>
                
                <div class="mb-2">
                    <label class="mb-2" for="email">{{ item.tshirt.shirt_title }}</label>
                    <b-input v-model="item.size" id="email" class="nitro-input w-100" disabled></b-input>
                </div>

                <div class="mb-2">
                        
                    <label class="mb-2" for="pickup_lists">Pickup area</label>
                    <b-input v-model="info.pickup_notes.pickup_lists" id="pickup_lists" class="nitro-input w-100" disabled></b-input>
                </div>
            </div>
            
            <b-row class="mt-4 mb-2">
                <div class="fw-bold text-center mb-2">IN CASE OF EMERGENCY DETAILS</div>
                <b-col sm="6">
                    <label class="mb-2" for="emergency_contact_person">Contact person:</label>
                    <b-input v-model="form.emergency_contact_person" id="emergency_contact_person" class="nitro-input w-100" disabled></b-input>
                </b-col>
                <b-col sm="6">
                    <label class="mb-2" for="emergency_relationship">Relationship:</label>
                    <b-input v-model="form.emergency_relationship" id="emergency_relationship" class="nitro-input w-100" disabled></b-input>
                </b-col>
                <b-col sm="6">
                    <label class="mb-2" for="emergency_contact_person">Contact number:</label>
                    <b-input v-model="form.emergency_contact_person" id="emergency_contact_person" class="nitro-input w-100" disabled></b-input>
                </b-col>
            </b-row>
        </div>
    </b-modal>
</template>

<style lang="scss" scoped>
    
</style>
