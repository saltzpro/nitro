<script lang="ts" setup>
    import { onMounted, ref } from "vue"

    definePageMeta({
        layout: 'registration',
    });

    const es = useEventStore()
    const event = useEvent()

    const router = useRouter()
    const config = useRuntimeConfig()

    const form = ref({
        name: '',
        phone: '',
        paymentFrom: '',
        reference: '',
        amount: '',
        proof: null,
    })

    const imageUrl: any = ref(null)
    const fileInput: any = ref(null)
    const proofImage: any = ref(null)

    function onFileChange(event: any) {
        const file = event.target.files[0]
        if (!file) return

        proofImage.value = file
        // Create a temporary URL for preview
        imageUrl.value = URL.createObjectURL(proofImage.value)
    }

    function triggerFileInput() {
        fileInput.value.click()
    }

    async function submitUploadForm() {
        const transactionNumber: any = router.currentRoute.value.query.transaction
        const formData = new FormData()
        formData.append('name', form.value.name)
        formData.append('phone', form.value.phone)
        formData.append('paymentFrom', form.value.paymentFrom)
        formData.append('reference', form.value.reference)
        formData.append('amount', form.value.amount)
        formData.append('transaction_number', transactionNumber)

        if (proofImage.value) {
            formData.append('proof', proofImage.value)
        }

        const toSaveAndNavigate = await es.transactionSendProof(formData)
        
    }

    async function getTransactionOrders() {
        const transactionNumber: any = router.currentRoute.value.query.transaction

        await event.getTransactionOrders({ transactionNumber: transactionNumber })
    
    }

    async function getPaymentSources() {
        
        const transactionNumber: any = router.currentRoute.value.query.transaction
        await event.getPaymentSources({ transactionNumber: transactionNumber })
        
    }

    onMounted(async () => {
        await nextTick()

        await getTransactionOrders()
        await getPaymentSources()
    })
</script>

<template>
    <div class="transaction-number-container d-flex align-items-center justify-content-center w-100 py-5 px-2 gap-32 flex-column">

        <div class="p-4 border-radius-10 shadow max-width-600 w-100">
            <div class="card-title mb-3 py-2">
                <h2 class="display-6 fw-bold text-center">Order summary</h2>
            </div>

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
        
        <div class="p-4 border-radius-10 shadow max-width-600 w-100">
            <div class="card-title mb-3 py-2">
                <h2 class="display-6 fw-bold text-center">Proof of payment</h2>
            </div>
            <b-form @submit.prevent="submitUploadForm" enctype="multipart/form-data">
                <b-form-group class="mb-3" id="name-group" label="Name" label-for="name">
                    <b-form-input id="name" v-model="form.name" placeholder="Enter name" required></b-form-input>
                </b-form-group>
                <b-form-group class="mb-3" id="phone-group" label="Phone Number" label-for="phone">
                    <b-form-input id="phone" v-model="form.phone" placeholder="Enter phone number" required></b-form-input>
                </b-form-group>
                <b-form-group class="mb-3" id="payment-from-group" label="Payment Source" label-for="payment-from">
                    <b-form-select id="payment-from" v-model="form.paymentFrom">
                        <b-form-select-option :value="''">
                            Select event payment source
                        </b-form-select-option>

                        <b-form-select-option v-for="(item, i) in es.sources" :key="`source-${i}`" :value="`${item.source} (${item.account_number})`">
                            {{ `${item.source} (${item.account_number})` }}
                        </b-form-select-option>
                    </b-form-select>
                </b-form-group>
                <b-form-group class="mb-3" id="reference-group" label="Reference Number" label-for="reference">
                    <b-form-input id="reference" v-model="form.reference" placeholder="Enter reference number" required></b-form-input>
                </b-form-group>
                <b-form-group class="mb-3" id="amount-group" label="Amount" label-for="amount">
                    <b-form-input id="amount" v-model="form.amount" placeholder="Enter amount" required></b-form-input>
                </b-form-group>

                <div v-if="imageUrl" class="preview mb-3">
                    <p class="mb-1">Preview:</p>
                    <img :src="imageUrl" alt="Uploaded Image" />
                </div>
                
                <input type="file" ref="profileImage" @change="onFileChange" accept=".png, .jpeg, .jpg" class="d-none">
                <b-button class="mb-3" variant="primary" @click="$refs.profileImage.click()">Upload payment proof</b-button>
                
                <b-button type="submit" variant="primary" class="w-100">Submit</b-button>
            </b-form>
        </div>
    </div>
</template>

<style lang="scss" scoped>
    .transaction-number-container {
        .preview {
            margin-top: 1rem;
            text-align: center;

            img {
                max-width: 500px;
                height: auto;
                border-radius: 10px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }
        }
    }
</style>
