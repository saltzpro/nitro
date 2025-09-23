<script lang="ts" setup>
    import { inject, nextTick, onMounted, ref } from 'vue'
    const event = useEvent()
    const es = useEventStore()
    const router = useRouter()

    const erStore: any = useErrorStore()

    definePageMeta({
        layout: 'registration',
    });

    const isLoading = ref(false)
    const isLoadingSave = ref(false)
    const collapseWaiver = ref(true)
    const collapseRules = ref(true)

    const categoryChoice = ref(null)

    const registrationSteps = ref(1)

    const eventId = ref(1)

    const adminFee = 35.00

    const gender = ref([
        'male', 'female'
    ])

    const color = ref('red')

    const form = ref({
        event_id: eventId.value,
        category_id: '',
        first_name: '',
        middle_name: '',
        last_name: '',
        address: '',
        organization: '',
        email: '',
        contact_number: '',
        gender: '',
        dob: '',
        emergency_contact_person: '',
        emergency_relationship: '',
        emergency_contact_number: '',
        pickup_notes: '',
        total_amount: 0,
        shirts: [],
        admin_fees: adminFee
    })

    const shirts = ref(null)

    onMounted(async () => {
        isLoading.value = true
        await nextTick()
        await event.getEvent(eventId.value)
        isLoading.value = false
        
        if (es.getShirts) {
            shirts.value = es.getShirts
            shirts.value = es.getShirts.map((n: any) => {
                n.shirt_sizes = n.shirt_sizes.replace('[', '').replace(']', '').replace(/['"]+/g, '')
                n.shirt_sizes = n.shirt_sizes.split(',')
                n.isAlreadySelect = false
                n.selected_size = ''
                return n
            })
        }

        initRootColorStyle()
    })

    function selectedCategory(selected: any) {

        categoryChoice.value = selected
        form.value.category_id = selected.id

        registrationSteps.value = 2
    }

    function selectSize(idx: any, selected: any) {
        shirts.value.map((n: any) => {
            n.selected_size = ''
            return n
        })

        shirts.value[idx].selected_size = selected
        shirts.value[idx].isAlreadySelect = true

    }

    function totalOrder() {
        return parseFloat(categoryChoice.value.current_price) + adminFee
    }
    
    async function storeParticipant() {
        isLoadingSave.value = true
        const getNoneSelected = shirts.value.filter((n: any) => n.isAlreadySelect)

        if (!getNoneSelected.length) {
            useNuxtApp().$toast.error('Selecting tshirt size is required.')
            registrationSteps.value = 2
            return 
        }
        
        form.value.total_amount = totalOrder()
        form.value.shirts = shirts.value

        const response = await event.storeParticipant(form.value) 
        
        if (response && response.status == 'success') {
            useNuxtApp().$toast.success(response.message)
            form.value = {
                event_id: '1',
                category_id: '',
                first_name: '',
                middle_name: '',
                last_name: '',
                address: '',
                organization: '',
                email: '',
                contact_number: '',
                gender: '',
                dob: '',
                emergency_contact_person: '',
                emergency_relationship: '',
                emergency_contact_number: '',
                pickup_notes: '',
                total_amount: 0,
                shirts: [],
                admin_fees: adminFee
            }
            router.push({
                path: '/thank-you',
                query: {
                    transaction_number: response.data.transaction_number
                }
            })
            registrationSteps.value = 1
            categoryChoice.value = null
        } else {
            if (erStore.errorMessage) {
                switch (erStore.errorStatus) {
                    case 422:
                        registrationSteps.value = 2
                    default:
                        break;
                }
                useNuxtApp().$toast.error(erStore.errorMessage)
            }
        }

        
        isLoadingSave.value = false

    }

    function initRootColorStyle() {
        const rootElement = document.documentElement;
        // Set a new CSS custom property or modify an existing one
        rootElement.style.setProperty('--event-bg-color', '#ffffff');
        rootElement.style.setProperty('--event-primary-color', '#ff0000');
        rootElement.style.setProperty('--event-text-selected-color', '#ffffff');
    }
    
</script>

<template>
    <div v-if="es.selected" class="registration-container container padding-top-60" :class="color">
        <div class="d-flex justify-content-center mb-4">
            <b-button-group size="lg" class="tab-button-header w-100 shadow">
                <b-button variant="tab-select" class="fw-bold" :class="{'selected' : registrationSteps == 1}" @click="registrationSteps = 1">CATEGORY</b-button>
                <b-button variant="tab-select" class="fw-bold" :class="{'selected' : registrationSteps == 2}" @click="registrationSteps = 2">REGISTRATION</b-button>
                <b-button variant="tab-select" class="fw-bold" :class="{'selected' : registrationSteps == 3}" @click="registrationSteps = 3">AGREEMENTS</b-button>
                <b-button variant="tab-select" class="fw-bold" :class="{'selected' : registrationSteps == 4}" @click="registrationSteps = 4">CHECKOUT</b-button>
            </b-button-group>
        </div>
        
        <template v-if="registrationSteps == 1">
            <card-container class="mb-4">
                <b-row>
                    <b-col>
                        <div class="card-title mb-3 py-2">
                            CHOOSE A CATEGORY <span class="text-danger">*</span>
                        </div>
                    </b-col>
                </b-row>
                <b-row class="mb-3">
                    <b-col class="mb-2">
                        <card-container v-for="(item, i) in es.selected.categories" :key="`category-${i}`" class="category-container w-100 cursor-pointer mb-3" :class="{'selected-category' : categoryChoice && item.id == categoryChoice.id}">
                            <div class="card-title d-flex justify-content-between align-items-center mb-2">
                                <span>
                                    {{ item.name }} -
                                    <span class="fw-bold">{{ `Php ${item.current_price}` }}</span>
                                </span>
                                <div class="d-flex justify-content-between gap-10">
                                    <b-button @click="selectedCategory(item)" class="box-container with-bg">Select</b-button>
                                    <b-button class="box-container" v-b-toggle="`category-${i}`">Show details</b-button>
                                </div>
                            </div>
                            <b-collapse :id="`category-${i}`" v-if="item.sub_name && item.sub_name != ''">
                                <span class="fw-bold">
                                    Inclusion: 
                                    <span class="d-block fw-normal">
                                        {{ item.sub_name }}
                                    </span>
                                </span>
                            </b-collapse>
                        </card-container>
                    </b-col>
                </b-row>
                    
            </card-container>
        </template>
        <template v-if="registrationSteps == 2">
            <card-container class="mb-4">
                <b-row>
                    <b-col>
                        <div class="card-title mb-3 py-2">
                            PERSONAL INFORMATION
                        </div>
                    </b-col>
                </b-row>

                <b-row class="mb-3">
                    <b-col lg="4" class="mb-2">
                        <div class="d-flex flex-column gap-10" :class="{'text-danger' : erStore.error && erStore.error.first_name}">
                            <span>First name: <span class="text-danger">*</span></span>
                            <b-input v-model="form.first_name" class="nitro-input" :class="{'is-invalid' : erStore.error && erStore.error.first_name}"></b-input>
                            <div v-if="erStore.error && erStore.error.first_name" class="small">
                                {{ erStore.error && erStore.error.first_name[0] }}
                            </div>
                        </div>
                    </b-col>
                    <b-col lg="4" class="mb-2">
                        <div class="d-flex flex-column gap-10" :class="{'text-danger' : erStore.error && erStore.error.middle_name}">
                            <span>Middle name: <span class="text-danger">*</span></span>
                            <b-input v-model="form.middle_name" class="nitro-input" :class="{'is-invalid' : erStore.error && erStore.error.middle_name}"></b-input>
                            <div v-if="erStore.error && erStore.error.middle_name" class="small">
                                {{ erStore.error && erStore.error.middle_name[0] }}
                            </div>
                        </div>
                    </b-col>
                    <b-col lg="4" class="mb-2">
                        <div class="d-flex flex-column gap-10" :class="{'text-danger' : erStore.error && erStore.error.last_name}">
                            <span>Last name: <span class="text-danger">*</span></span>
                            <b-input v-model="form.last_name" class="nitro-input" :class="{'is-invalid' : erStore.error && erStore.error.last_name}"></b-input>
                            <div v-if="erStore.error && erStore.error.last_name" class="small">
                                {{ erStore.error && erStore.error.last_name[0] }}
                            </div>
                        </div>
                    </b-col>
                </b-row>

                <b-row class="mb-3">
                    <b-col lg="6" class="mb-2">
                        <div class="d-flex flex-column gap-10" :class="{'text-danger' : erStore.error && erStore.error.address}">
                            <span>Address: <span class="text-danger">*</span></span>
                            <b-input v-model="form.address" class="nitro-input" :class="{'is-invalid' : erStore.error && erStore.error.address}"></b-input>
                            <div v-if="erStore.error && erStore.error.address" class="small">
                                {{ erStore.error && erStore.error.address[0] }}
                            </div>
                        </div>
                    </b-col>
                    <b-col lg="6" class="mb-2">
                        <div class="d-flex flex-column gap-10">
                            <span>Team Name / Organization:</span>
                            <b-input v-model="form.organization" class="nitro-input"></b-input>
                        </div>
                    </b-col>
                </b-row>
                
                <b-row class="mb-3">
                    <b-col lg="6" class="mb-2">
                        <div class="d-flex flex-column gap-10" :class="{'text-danger' : erStore.error && erStore.error.email}">
                            <span>Email Address: <span class="text-danger">*</span></span>
                            <b-input v-model="form.email" class="nitro-input" :class="{'is-invalid' : erStore.error && erStore.error.email}"></b-input>
                            <div v-if="erStore.error && erStore.error.email" class="small">
                                {{ erStore.error && erStore.error.email[0] }}
                            </div>
                        </div>
                    </b-col>
                    
                    <b-col lg="6" class="mb-2">
                        <div class="d-flex flex-column gap-10" :class="{'text-danger' : erStore.error && erStore.error.contact_number}">
                            <span>Contact number: <span class="text-danger">*</span></span>
                            <b-input v-model="form.contact_number" class="nitro-input" :class="{'is-invalid' : erStore.error && erStore.error.contact_number}"></b-input>
                            <div v-if="erStore.error && erStore.error.contact_number" class="small">
                                {{ erStore.error && erStore.error.contact_number[0] }}
                            </div>
                        </div>
                    </b-col>
                </b-row>

                <b-row class="mb-3">
                    <b-col lg="6" class="mb-2">
                            <div class="d-flex flex-column gap-10" :class="{'text-danger' : erStore.error && erStore.error.gender}">

                            <span>Gender: <span class="text-danger">*</span></span>
                            <div class="d-flex align-items-center gap-10 flex-wrap">
                                <div v-for="(item, i) in gender" :key="`gender-${i}`" @click="form.gender = item" :class="{'selected' : form.gender == item}" class="box-container cursor-pointer px-3 py-2 border-radius-10">
                                    <span class="text-uppercase">{{ item }}</span>
                                </div>
                            </div>
                            <div v-if="erStore.error && erStore.error.gender" class="small">
                                {{ erStore.error && erStore.error.gender[0] }}
                            </div>
                        </div>
                    </b-col>
                    
                    <b-col lg="6" class="mb-2">
                        <div class="d-flex flex-column gap-10" :class="{'text-danger' : erStore.error && erStore.error.dob}">
                            <span>Date of birth: <span class="text-danger">*</span></span>
                            <b-input v-model="form.dob" type="date" class="nitro-input" :class="{'is-invalid' : erStore.error && erStore.error.dob}"></b-input>
                            <div v-if="erStore.error && erStore.error.dob" class="small">
                                {{ erStore.error && erStore.error.dob[0] }}
                            </div>
                        </div>
                    </b-col>
                </b-row>
                <b-row v-if="es.getShirts">
                    <b-col>
                        <card-container v-for="(item, i) in shirts" :key="`shirts-${i}`" class="mb-3" :class="{'border border-danger' : !item.isAlreadySelect}">
                            <div class="card-title mb-3 py-2">
                                <span :class="{'text-danger' : !item.isAlreadySelect}">{{ item.shirt_title }}</span>
                            </div>
                            <div class="d-flex flex-column gap-10">
                                <div class="d-flex align-items-center gap-10 flex-wrap">
                                    <div v-for="(shirt, idx) in item.shirt_sizes" :key="`shirt-size-${idx}`" :class="{'selected' : shirt == item.selected_size}" class="box-container cursor-pointer px-3 py-2 border-radius-10" @click="selectSize(i, shirt)">
                                        <span class="text-uppercase">{{ shirt }}</span>
                                    </div>
                                </div>
                            </div>
                        </card-container>
                    </b-col>
                </b-row>
                    
            </card-container>

            <card-container class="mb-4">
                <b-row>
                    <b-col>
                        <div class="card-title mb-3 py-2">
                            EMERGENCY CONTACT INFORMATION
                        </div>
                    </b-col>
                </b-row>
                <b-row class="mb-3">
                    <b-col lg="4" class="mb-2">
                        <div class="d-flex flex-column gap-10" :class="{'text-danger' : erStore.error && erStore.error.emergency_contact_person}">
                            <span>Contact person: <span class="text-danger">*</span></span>
                            <b-input v-model="form.emergency_contact_person" class="nitro-input" :class="{'is-invalid' : erStore.error && erStore.error.emergency_contact_person}"></b-input>
                            <div v-if="erStore.error && erStore.error.emergency_contact_person" class="small">
                                {{ erStore.error && erStore.error.emergency_contact_person[0] }}
                            </div>
                        </div>
                    </b-col>
                    <b-col lg="4" class="mb-2">
                        <div class="d-flex flex-column gap-10" :class="{'text-danger' : erStore.error && erStore.error.emergency_relationship}">
                            <span>Relationship: <span class="text-danger">*</span></span>
                            <b-input v-model="form.emergency_relationship" class="nitro-input" :class="{'is-invalid' : erStore.error && erStore.error.emergency_relationship}"></b-input>
                            <div v-if="erStore.error && erStore.error.emergency_relationship" class="small">
                                {{ erStore.error && erStore.error.emergency_relationship[0] }}
                            </div>
                        </div>
                    </b-col>
                    <b-col lg="4" class="mb-2">
                        <div class="d-flex flex-column gap-10" :class="{'text-danger' : erStore.error && erStore.error.emergency_contact_number}">
                            <span>Contact number: <span class="text-danger"><span class="text-danger">*</span></span></span>
                            <b-input v-model="form.emergency_contact_number" class="nitro-input" :class="{'is-invalid' : erStore.error && erStore.error.emergency_contact_number}"></b-input>
                            <div v-if="erStore.error && erStore.error.emergency_contact_number" class="small">
                                {{ erStore.error && erStore.error.emergency_contact_number[0] }}
                            </div>
                        </div>
                    </b-col>
                </b-row>
                    
            </card-container>
        </template>

        <card-container v-if="registrationSteps == 3" class="mb-4">
            <b-row>
                <b-col>
                    <div class="card-title mb-3 py-2">
                        AGREEMENTS
                    </div>
                </b-col>
            </b-row>
            
            <b-row>
                <b-col class="mb-3">
                    <card-container>
                        <div class="card-title py-2 d-flex align-items-center justify-content-between gap-10" :class="{'mb-3' : collapseWaiver}">
                            <span>EVENT RULES AND REGULATIONS</span>
                            <b-button @click="collapseRules = !collapseRules" class="box-container">{{ collapseRules ? 'HIDE' : 'SHOW' }}</b-button>
                        </div>
                        <b-collapse v-model="collapseRules">
                            <terms-rules-regulations></terms-rules-regulations>
                        </b-collapse>
                    </card-container>
                </b-col>
            </b-row>

            <b-row>
                <b-col class="mb-3">
                    <card-container>
                        <div class="card-title py-2 d-flex align-items-center justify-content-between gap-10" :class="{'mb-3' : collapseWaiver}">
                            <span>DECLARATION OF FITNESS WAIVER </span>
                            <b-button @click="collapseWaiver = !collapseWaiver" class="box-container">{{ collapseWaiver ? 'HIDE' : 'SHOW' }}</b-button>
                        </div>
                        <b-collapse v-model="collapseWaiver">
                            <terms-declaration></terms-declaration>
                        </b-collapse>
                    </card-container>
                </b-col>
            </b-row>
        </card-container>

        <card-container v-if="registrationSteps == 4">
            <b-row>
                <b-col>
                    <div class="card-title mb-3 py-2">
                        CHECKOUT
                    </div>
                </b-col>
            </b-row>
            <b-row>
                <b-col md="6" class="mb-3">
                    <card-container>
                        <div class="mb-3">
                            <span class="fw-bold">Pickup notes</span>
                        </div>
                        <card-container>
                            <div>
                                <p>
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book
                                </p>
                            </div>
                        </card-container>
                        
                        <div class="mt-3 d-flex flex-column gap-10" :class="{'text-danger' : erStore.error && erStore.error.pickup_notes}">
                            <div class="mb-3">
                                <span class="fw-bold">Choose pickup location</span>
                            </div>
                            <div>
                                <b-form-select v-model="form.pickup_notes" :class="{'is-invalid' : erStore.error && erStore.error.pickup_notes}">
                                    <template #first>
                                        <b-form-select-option :value="null" disabled>Select pickup location</b-form-select-option>
                                    </template>
                                    <b-form-select-option v-for="(item, i) in es.selected.pickups" :key="`selection-${i}`" :value="item.id">{{ item.pickup_lists }}</b-form-select-option>
                                </b-form-select>
                            </div>
                            <div v-if="erStore.error && erStore.error.pickup_notes" class="small">
                                {{ erStore.error && erStore.error.pickup_notes[0] }}
                            </div>
                        </div>
                    </card-container>
                </b-col>

                <b-col md="6" class="mb-3">
                    <card-container class="mb-3">
                        <div class="mb-3">
                            <span class="fw-bold">ORDER SUMMARY</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center gap-16 mb-2">
                            <span>{{ `${categoryChoice.name} category` }}</span>
                            <span class="fw-bold">{{ categoryChoice.current_price }}</span>
                        </div>

                        <div v-for="(item, i) in shirts" :key="`shirts-${i}`" class="d-flex justify-content-between align-items-center gap-16 mb-2">
                            <span>{{ `${item.shirt_title}` }}]
                                <span class="d-block">
                                    {{ `(size: ${item.selected_size})` }}
                                </span>
                            </span>
                            <span class="fw-bold">0</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center gap-16 mb-2">
                            <span>Admin fee</span>
                            <span class="fw-bold">{{ adminFee }}</span>
                        </div>
                    </card-container>

                    <card-container>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="fw-bold">TOTAL ORDER</span>

                            <span class="fw-bold">{{ totalOrder() }}</span>
                        </div>
                    </card-container>
                </b-col>
            </b-row>
        </card-container>
        
        <div v-if="registrationSteps != 5" class="d-flex justify-content-center align-items-center mt-3 gap-10">
            <b-button v-if="registrationSteps != 1" @click="registrationSteps--" variant="secondary" class="px-5 height-50 fw-bold">BACK</b-button>
            <b-button v-if="registrationSteps != 1 && registrationSteps != 4" @click="registrationSteps++" variant="primary" class="box-container px-5 height-50 fw-bold">NEXT</b-button>
            <b-button v-if="registrationSteps == 4" variant="primary" class="box-container px-5 height-50 fw-bold" @click="storeParticipant()">CHECKOUT NOW</b-button>
        </div>

    </div>
</template>

<style lang="scss" scoped>
    
    //box-container selected
    $boxBg: var(--event-bg-color);
    $boxText: var(--event-primary-color);
    $boxBorder: var(--event-primary-color);

    //box-container selected / hover
    $boxBgSelected: var(--event-primary-color);
    $boxTextSelected: var(--event-text-selected-color);
    

    //use for the tab selection

    .registration-container {

        .category-container {
            transition: 0.3s;
            &:hover, &.selected-category {
                border: 1px solid $boxBgSelected !important;
            }
        }

        input {
            box-shadow: none !important;
        }

        .box-container {
            background-color: $boxBg;
            color: $boxText;
            border: 1px solid $boxText;
            transition: 0.3s;
            &:hover, &.selected {
                background-color: $boxBgSelected;
                color: $boxTextSelected;
            }

            &.with-bg {
                background-color: $boxBgSelected;
                color: $boxTextSelected;
            }
        }

        .tab-button-header {
            .btn-tab-select {
                background-color: $boxBg;
                color: $boxText;
                border-color: $boxBorder;
                transition: 0.3s;

                &:hover, &.selected {
                    background-color: $boxBgSelected;
                    color: $boxTextSelected;
                }
            }
        }

    }
</style>
