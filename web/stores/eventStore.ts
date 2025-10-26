import { defineStore } from 'pinia';
import { GET_EVENT, ADD_PARTICIPANTS, REGISTRATION_LIST, DASHBOARD_SUMMARY, RECENT_ACTIVITIES, STORE_COLLECTION, EVENTS_LIST,
    USER_EVENTS, ALL_EVENT_LIST, SELECTED_EVENT, USER_ADDED_EVENT, EVENT_CATEGORY, EVENT_PICKUP, EVENT_AGE,
    EVENT_SHIRT
 } from '@/endpoints/endpoints'
import { useApi } from '@/composables/useApi'

export const useEventStore = defineStore('event', {
    state: () => {
        return {
            selectedEvent: null,
            addParticipant: null,
            pendingRegistrations: null,
            recent: [],
            summary: {},
            ev: {},
            userEventList: [],
            allEventsList: [],

            linkedEvents: []
        }
    },
    getters: {
        selected(state) {
            return state.selectedEvent
        },

        getShirts(state) {
            if (state.selectedEvent && state.selectedEvent.shirts.length) {
                return state.selectedEvent.shirts
            } else {
                return false
            }
        },
        dashboardSummary(state) {
            return state.summary
        },

        recentAcivitiesList(state) {
            return state.recent.data
        },

        eventList(state) {
            if (state.ev) {
                return state.ev.data
            }
            return []
        },

        user_event_list(state) {
            if (state.ev) {
                return state.ev.userEventList
            }
            return []
        },

        all_event_list(state) {
            return state.allEventsList.data
        },

        linked_events(state) {
            if (state.linkedEvents) {
                return state.linkedEvents.data
            }
            return []
        }
    },
    actions: {
        async event(eventId: any) {
            const response = await useSanctumFetch(`${GET_EVENT}/${eventId}`)
            const resData = response.data.value
            this.$state.selectedEvent = resData.data
            return resData

        },

        async storeParticipant(payloads: any) {
            const response = await useSanctumFetch(`${ADD_PARTICIPANTS}`, {
                body: payloads,
                method: 'POST'
            })
            const resData = response.data.value

            
            return resData
        },

        async getPendingRegistration(type: any, event_id: any) {
            let params = {
                event_id: event_id
            }
            const response = await useApi().get(`${REGISTRATION_LIST}/${type}`, params)
            const resData = response.data.value
            return resData
        },

        async getDashboardSummary(event_id: any) {  
            let params = {
                event_id: event_id
            }
            const response = await useApi().get(`${DASHBOARD_SUMMARY}`, params)
            const resData = response.data.value
            this.$state.summary = resData
            return resData
        },

        async recentlyActivities(payloads: any) {
            let params = payloads
            const response = await useApi().get(`${RECENT_ACTIVITIES}`, params)
            const resData = response.data.value
            this.$state.recent = resData
            return resData
        },

        async storeCollection(payloads: any) {
            const response = await useSanctumFetch(`${STORE_COLLECTION}`, {
                method: 'post',
                body: payloads
            })
            const resData = response.data.value
            return resData
        },

        async events(payloads: any) {
            const response = await useSanctumFetch(`${EVENTS_LIST}`, {
                params: payloads
            })
            const resData = response.data.value
            this.$state.ev = resData

            return resData
        },

        async eventListForUser(payloads: any) {
            let params = payloads
            const response = await useApi().get(`${USER_EVENTS}`, params)
            const resData = response.data.value
            this.$state.userEventList = resData

            return resData
        },

        async allEvents(payloads: any) {
            const response = await useSanctumFetch(`${ALL_EVENT_LIST}`, {
                params: payloads
            })
            const resData = response.data.value
            this.$state.allEventsList = resData

            return resData
        },

        async getSelectedEvent(payloads: any) {
            const response = await useSanctumFetch(`${SELECTED_EVENT}/${payloads.id}`)
            const resData = response.data.value
            this.$state.selectedEvent = resData.data

            return resData
        },

        async userAddedEvent() {
            const response = await useSanctumFetch(`${USER_ADDED_EVENT}`)
            const resData = response.data.value
            this.$state.linkedEvents = resData
            return resData
        }, 

        async updateSelectedEvent(payloads: any) {
            let params = payloads
            const response = await useApi().put(`${ALL_EVENT_LIST}/${payloads.id}`, params)
            const resData = response.data.value
            useNuxtApp().$toast(resData.message, {type: resData.status});
            this.$state.selectedEvent = resData

            return resData
        },

        
        async createCategory(payloads: any) {
            const response = await useApi().post(`${EVENT_CATEGORY}`, payloads)
            const resData = response.data.value
            this.$state.selectedEvent.categories.push(resData.data)
            
            useNuxtApp().$toast(resData.message, {type: resData.status});

            return resData
        },

        async createPickup(payloads: any) {
            
            const response = await useApi().post(`${EVENT_PICKUP}`, payloads)
            const resData = response.data.value
            this.$state.selectedEvent.pickups.push(resData.data)
            
            useNuxtApp().$toast(resData.message, {type: resData.status});

            return resData
        },

        async createShirt(payloads: any) {
            
            const response = await useApi().post(`${EVENT_SHIRT}`, payloads)
            const resData = response.data.value
            this.$state.selectedEvent.shirts.push(resData.data)
            
            useNuxtApp().$toast(resData.message, {type: resData.status});

            return resData
        },

        async createAge(payloads: any) {
            
            const response = await useApi().post(`${EVENT_AGE}`, payloads)
            const resData = response.data.value
            this.$state.selectedEvent.ages.push(resData.data)
            
            useNuxtApp().$toast(resData.message, {type: resData.status});

            return resData
        },

        async deleteShirt(payloads: any, idx: any) {
            const response = await useApi().del(`${EVENT_SHIRT}/${payloads.id}`, payloads)
            const resData = response.data.value
            this.$state.selectedEvent.shirts.splice(idx, 1)
            useNuxtApp().$toast(resData.message, {type: resData.status});

            return resData
        },

        async deleteAge(payloads: any, idx: any) {
            const response = await useApi().del(`${EVENT_AGE}/${payloads.id}`, payloads)
            const resData = response.data.value
            this.$state.selectedEvent.ages.splice(idx, 1)
            useNuxtApp().$toast(resData.message, {type: resData.status});

            return resData
        },

        async deletePickup(payloads: any, idx: any) {
            const response = await useApi().del(`${EVENT_PICKUP}/${payloads.id}`, payloads)
            const resData = response.data.value
            this.$state.selectedEvent.pickups.splice(idx, 1)
            useNuxtApp().$toast(resData.message, {type: resData.status});

            return resData
        },

        async deleteCategory(payloads: any, idx: any) {
            const response = await useApi().del(`${EVENT_CATEGORY}/${payloads.id}`, payloads)
            const resData = response.data.value
            this.$state.selectedEvent.categories.splice(idx, 1)
            useNuxtApp().$toast(resData.message, {type: resData.status});

            return resData
        },

    },
});