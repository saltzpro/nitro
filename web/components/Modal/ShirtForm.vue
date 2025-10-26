
<script lang="ts" setup>
    import { ref } from "vue"

    const emit = defineEmits(['updateSize'])

    const event = useEvent()
    const es = useEventStore()
    const router = useRouter()

    const form = ref({
        event_id: router.currentRoute.value.params.eid,
        shirt_title: '',
        shirt_description: '',
        shirt_sizes: ['18', 'S', 'M', 'L', 'XL', '2XL', '3XL'],
    })

    const size = ref('')

    const isLoading = ref(false)

    async function createShirt() {
        isLoading.value = true
        
        const response = await event.createShirt(form.value)

        form.value = {
            event_id: router.currentRoute.value.params.eid,
            shirt_title: '',
            shirt_description: '',
            shirt_sizes: ['18', 'S', 'M', 'L', 'XL', '2XL', '3XL'],
        }

        
        isLoading.value = false
        emit('updateSize')
    }

    function addNewShirt() {
        if (size.value == '') {
            useNuxtApp().$toast(`Please input size to add`, {type: 'error'});
            return
        }
        const isExisting = form.value.shirt_sizes.find(n => n == size.value)
        if (isExisting) {
            useNuxtApp().$toast(`Inputted size ${size.value} has already added`, {type: 'error'});
            return
        }

        form.value.shirt_sizes.push(size.value.toUpperCase())
        size.value = ''

    }

    function removeShirt(idx: any) {
        form.value.shirt_sizes.splice(idx, 1)
    }
</script>

<template>
    <b-modal size="md" no-footer title="Create new shirt type" centered id="new-category-form" class="ss-default-modal">
        <b-container>
            <b-row>
                <b-col>
                    <b-form-group class="mb-3" label="Shirt Title" label-for="shirt_title">
                        <b-form-input v-model="form.shirt_title" id="shirt_title"></b-form-input>
                    </b-form-group>
                </b-col>
            </b-row>
            
            <b-row>
                <b-col>
                    <b-form-group class="mb-3" label="Shirt description" label-for="shirt_description">
                        <b-form-textarea v-model="form.shirt_description" id="shirt_description" rows="10" max-rows="10"></b-form-textarea>
                    </b-form-group>
                </b-col>
            </b-row>
            
            <b-row class="mb-3">
                <b-col>
                    <div class="d-flex align-items-end gap-10 w-100 mb-2">
                        <b-form-group label="Input shirt size" label-for="size">
                            <b-form-input v-model="size" id="size"></b-form-input>
                        </b-form-group>

                        <b-button @click="addNewShirt" variant="primary" class="text-nowrap text-upper">Add shirt</b-button>
                    </div>
                    <div class="d-flex gap-10 w-100 flex-wrap">
                        <div v-for="(size, i) in form.shirt_sizes" :key="`shirt-${i}`" class="d-flex align-items-center gap-10 border shadow-sm border-radius-10 px-2 py-1">
                            <span class="fw-bold">{{ size }}</span>
                            <b-badge @click="removeShirt(i)" variant="danger" class="cursor-pointer rounded-circle">x</b-badge>
                        </div>
                    </div>
                </b-col>
            </b-row>
            
            <b-row>
                <b-col>
                    <b-button v-if="!isLoading" @click="createShirt" variant="primary" class="height-50 w-100">CREATE NEW SHIRT TYPE</b-button>
                    <b-button v-else variant="primary" class="height-50 w-100 cursor-notallowed" disabled><b-spinner variant="light" small></b-spinner></b-button>
                </b-col>
            </b-row>
        </b-container>
    </b-modal>
</template>

<style lang="scss" scoped>
    
</style>
