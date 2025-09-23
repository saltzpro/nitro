import { defineStore } from 'pinia';
import { GET_EVENT, ADD_PARTICIPANTS, REGISTRATION_LIST, DASHBOARD_SUMMARY, RECENT_ACTIVITIES, STORE_COLLECTION, EVENTS_LIST,
    USER_EVENTS, ALL_EVENT_LIST, SELECTED_EVENT 
 } from '@/endpoints/endpoints'

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
        }
    },
    getters: {
        selected(state) {
            return state.selectedEvent
        },

        getShirts(state) {
            if (state.selectedEvent.shirts.length) {
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
            const response = await useSanctumFetch(`${REGISTRATION_LIST}/${type}`, {
                params: {
                    event_id: event_id
                }
            })
            const resData = response.data.value
            return resData
        },

        async getDashboardSummary(event_id: any) {
            const response = await useSanctumFetch(`${DASHBOARD_SUMMARY}`, {
                params: {
                    event_id: event_id
                }
            })
            const resData = response.data.value
            this.$state.summary = resData
            return resData
        },

        async recentlyActivities(payloads: any) {
            const response = await useSanctumFetch(`${RECENT_ACTIVITIES}`, {
                params: {
                    event_id: payloads.event_id
                }
            })
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
            const response = await useSanctumFetch(`${USER_EVENTS}`, {
                params: payloads
            })
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
            this.$state.selectedEvent = resData

            return resData
        }



    },
});