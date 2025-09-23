export function useEvent() {

    const es = useEventStore()

    async function getEvent(eventId: any) {
        await es.event(eventId)
    }

    async function storeParticipant(payloads: any) {
            const response = await es.storeParticipant(payloads)
            return response
    }

    async function getPendingRegistration(type: any, event_id: any) {
        const response = await es.getPendingRegistration(type, event_id)
        return response
    }

    async function getDashboardSummary(event_id: any) {
        const response = await es.getDashboardSummary(event_id)
        return response
    }

    async function recentlyActivities(payloads: any) {
        const response = await es.recentlyActivities(payloads)
        return response
    }

    async function storeCollection(payloads: any) {
        const response = await es.storeCollection(payloads)
        return response
    }

    async function getEventList(payloads: any) {
        const response = await es.events(payloads)
        return response
    } 

    async function eventListForUser(payloads: any) {
        const response = await es.eventListForUser(payloads)

        return response
    }

    async function allEvents(payloads: any) {
        const response = await es.allEvents(payloads)

        return response
    }

    async function getSelectedEvent(payloads: any) {
        const response = await es.getSelectedEvent(payloads)
        
        return response
    }


    return {
        getEvent, storeParticipant, getPendingRegistration, getDashboardSummary, recentlyActivities,
        storeCollection, getEventList, eventListForUser, allEvents, getSelectedEvent 
    }

}