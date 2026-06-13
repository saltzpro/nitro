<script lang="ts" setup>
    import { onMounted, ref } from "vue"

    definePageMeta({
        layout: 'registration',
    });

    const router = useRouter()
    const config = useRuntimeConfig()

    const form = ref({
        name: '',
        phone: '',
        reference: '',
        amount: '',
    })

    const imageUrl = ref(null)
    const fileInput = ref(null)

    function onFileChange(event: any) {
        const file = event.target.files[0]
        if (!file) return

        // Create a temporary URL for preview
        imageUrl.value = URL.createObjectURL(file)
    }

    function triggerFileInput() {
        fileInput.value.click()
    }
</script>

<template>
    <div class="transaction-number-container d-flex align-items-center justify-content-center w-100 py-5 px-2">
        <div class="p-4 border-radius-10 shadow max-width-700">
            <div class="card-title mb-3 py-2">
                <h2 class="display-6 fw-bold text-center">Transaction Confirmation</h2>
            </div>
            <b-form>
                <b-form-group class="mb-3" id="name-group" label="Name" label-for="name">
                    <b-form-input id="name" v-model="form.name" placeholder="Enter name" required></b-form-input>
                </b-form-group>
                <b-form-group class="mb-3" id="phone-group" label="Phone Number" label-for="phone">
                    <b-form-input id="phone" v-model="form.phone" placeholder="Enter phone number" required></b-form-input>
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
                <b-button class="mb-3" variant="primary" @click="$refs.profileImage.click()">Upload transaction proof</b-button>
                
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
