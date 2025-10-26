import { defineStore } from 'pinia';
import {} from '@/endpoints/endpoints'
export const useEventCategoryStore = defineStore('eventCategoryStore', {
    state: () => ({
        category: {}
    }),
    getters: {
        event_category(state) {
            return state.categories
        }
    },
    actions: {
        async createCategory(payloads: any) {
            const response = await useApi().post(`${EVENT_CATEGORY}`, payloads)
            const resData = response.data.value
            this.$state.category = resData
            
            useNuxtApp().$toast(resData.message, {type: resData.status});

            return resData
        }
    },
});
