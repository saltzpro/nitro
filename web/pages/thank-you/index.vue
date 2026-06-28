<script lang="ts" setup>
    import { inject, nextTick, onMounted, ref } from 'vue'

    definePageMeta({
        layout: 'registration',
    });

    const router = useRouter()
    const config = useRuntimeConfig()
    const es = useEventStore()
    const event = useEvent()

    const webUrl = ref(config.public.webUrl)

    async function getTransactionOrders() {
        const transactionNumber: any = router.currentRoute.value.query.transaction_number

        await event.transactionDetails({ transactionNumber: transactionNumber })
        await event.getTransactionOrders({ transactionNumber: transactionNumber })
    
    }

    onMounted(async () => {
        await nextTick()
        await getTransactionOrders()
    })
</script>

<template>
    <div class="thank-you-container w-100 d-flex align-items-center justify-content-center">
        <div v-if="es.getTransaction" class="max-width-700 shadow border-radius-10 p-4">
            <div class="card-title mb-3 py-2">
                <h1 class="display-5 fw-bold text-center">Thank You for Registering our event!</h1>
            </div>
            <div class="card-title py-2 d-flex w-100 justify-content-center align-items-center flex-column gap-6">
                <span>Transaction number</span>
                <h3 class="fw-bold">{{ router.currentRoute.value.query.transaction_number }}</h3>
            </div>

            <div class="card-title py-2 d-flex w-100 justify-content-center align-items-center flex-column gap-6">
                <span>Status</span>
                <b-badge pill class="px-3 py-2 rounded" :variant="es.getTransaction.event_status == 'pending' ? 'danger' : 'success'">
                    <h6 class="m-0 text-capitalize">{{ es.getTransaction.event_status != 'fullfil' ? es.getTransaction.event_status : 'Paid' }}</h6>
                </b-badge>
            </div>
            

            <div v-if="es.getTransaction.event_status == 'pending'" class="mb-4">
                <p>Your registration has been successfully submitted. To complete your registration, please proceed with payment using Maya Checkout.</p>

                <b-button :href="es.getTransaction.maya_checkout_url" variant="success">Pay Now via Maya</b-button>
            </div>

            <div v-if="es.getTransaction.event_status == 'fullfil'" class="mb-4">
                <p>We have successfully received your payment and your transaction has been marked as <b>PAID</b>.</p>

                <p>Thank you for your payment. Your registration is now complete and no further action is required. A confirmation email has been sent to your registered email address for your records.</p>

                <b-button :href="es.getTransaction.maya_checkout_url" variant="success">View payment via maya</b-button>
            </div>

            <div class="mt-3">

                <h3>🛒 Order Summary</h3>

                <b-table-simple>
                    <b-thead>
                        <b-th class="padding-all-8">#</b-th>
                        <b-th class="padding-all-8">Item</b-th>
                        <b-th class="padding-all-8">Amount</b-th>
                    </b-thead>
                    <b-tbody>
                        <b-tr v-for="(item, i) in es.orders" :key="i">
                            <b-td class="text-center">{{ `${i}` }}</b-td>
                            <b-td><span class="text-primary">{{ item.order }}</span></b-td>
                            <b-td class="text-end">{{ item.amount }}</b-td>
                        </b-tr>
                    </b-tbody>
                    <b-tbody>
                        <b-tr>
                            <b-td colspan="2">Total Orders</b-td>
                            <b-td class="text-end fw-bold">{{ es.totalOrderSum }}</b-td>
                        </b-tr>
                    </b-tbody>
                </b-table-simple>
            </div>

        </div>
    </div>
</template>

<style lang="scss">
    .thank-you-container {
            
    }
</style>
