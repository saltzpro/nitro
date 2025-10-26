<script lang="ts" setup>
    import { inject, nextTick, onMounted, ref } from 'vue'

    definePageMeta({
        layout: 'registration',
    });

    const router = useRouter()
    const config = useRuntimeConfig()

    const webUrl = ref(config.public.webUrl)

    onMounted(() => {
        console.log(router.currentRoute.value.query.transaction_number)
    })
</script>

<template>
    <div class="thank-you-container w-100 d-flex align-items-center justify-content-center">
        <div class="max-width-700 shadow border-radius-10 p-4">
            <div class="card-title mb-3 py-2">
                <h1 class="display-5 fw-bold text-center">Thank You for Registering our event!</h1>
            </div>

            <div class="mt-5 mb-4">
                <p>
                    Your registration (transaction Code: <span class="fw-bold">{{ router.currentRoute.value.query.transaction_number }}</span>) is now for review. To complete your payment via <span class="fw-bold">GCash</span> please follow <span class="fw-bold">GCash Payment Guide (Own Account or Someone Else’s)</span> 
                </p>


                <div>
                    <div class="mb-2">
                        <span class="fw-bold">How to pay via GCASH</span>
                    </div>
                    <ol>
                        <li>Open the GCash App on your phone.</li>
                        <li>Tap <strong>“Send Money.”</strong></li>
                        <li>Select <strong>“Express Send.”</strong></li>
                        <li>Enter the recipient’s <strong>GCash mobile number</strong>.</li>
                        <li>Enter the <strong>amount</strong> you want to pay.</li>
                        <li>Optional: Add a note (e.g., "Payment for Transaction <strong>#{{ router.currentRoute.value.query.transaction_number }}</strong>").</li>
                        <li>Tap <strong>“Next”</strong> and review the payment details.</li>
                        <li>Tap <strong>“Send.”</strong></li>
                        <li>Wait for the confirmation message with the <strong>Reference Number</strong>.</li>
                        <li><strong>Save</strong> or screenshot the confirmation.</li>
                    </ol>
                </div>

                <div>
                    <div class="mb-2">
                        <span class="fw-bold">💳 Pay via Bank Transfer</span>
                    </div>
                    <ol>
                        <li>
                            <div><span class="fw-bold">Bank of the Philippine Islands (BPI)</span></div>
                            <ul>
                                <li>Account number: 123456789</li>
                                <li>Juan Dela Cruz</li>
                            </ul>
                        </li>
                        <li>
                            <div><span class="fw-bold">Banco de Oro (BDO)</span></div>
                            <ul>
                                <li>Account number: 123456789</li>
                                <li>Juan Dela Cruz</li>
                            </ul>
                        </li>

                        <li>
                            <div><span class="fw-bold">Metrobank</span></div>
                            <ul>
                                <li>Account number: 123456789</li>
                                <li>Juan Dela Cruz</li>
                            </ul>
                        </li>
                        <li>
                            <div><span class="fw-bold">Land Bank of the Philippines (LANDBANK)</span></div>
                            <ul>
                                <li>Account number: 123456789</li>
                                <li>Juan Dela Cruz</li>
                            </ul>
                        </li>
                    </ol>

                </div>

                <div class="note mb-3">
                    <strong>After GCASH or Bank Transfer</strong><br>
                    ✅ Take a screenshot or photo of your payment confirmation. <br>
                    ✅ Send the proof of payment (with your <strong>Name</strong>, <strong>Amount</strong>, <strong>Reference Number</strong>) to this transaction page <a :href="`nitro.com/transaction-confirmation?transaction=${router.currentRoute.value.query.transaction_number}`">
                        {{ `${webUrl}/transaction-confirmation?transaction=${router.currentRoute.value.query.transaction_number}` }}
                    </a>.
                </div>

                <div class="note">
                    <strong>Sample Confirmation:</strong><br>
                    Name: <strong>Jesus Nazareno (09123456789)</strong>.<br>
                    Amount: <strong>2,500.00</strong>.<br>
                    Reference Number: <strong>GCASH123456789</strong><br>
                </div>
            </div>

        </div>
    </div>
</template>

<style lang="scss">
    .thank-you-container {
        height: 100vh;
    }
</style>
