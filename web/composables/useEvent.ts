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
    
    async function userAddedEvent() {
        const response = await es.userAddedEvent()

        return response
    }

    async function updateSelectedEvent(payloads: any) {
        const response = await es.updateSelectedEvent(payloads)

        return response
    }

    async function createCategory(payloads: any) {
        const response = await es.createCategory(payloads)

        return response
    }

    async function createPickup(payloads: any) {
        const response = await es.createPickup(payloads)

        return response
    }

    async function createShirt(payloads: any) {
        const response = await es.createShirt(payloads)

        return response
    }

    async function createAge(payloads: any) {
        const response = await es.createAge(payloads)

        return response
    }

    async function deleteRecord(payloads: any, idx: any, type: any) {
        let response
        if (type == 'shirt') {
            response = await es.deleteShirt(payloads, idx)
        } else if (type == 'age') {
            response = await es.deleteAge(payloads, idx)
        } else if (type == 'pickup') {
            response = await es.deletePickup(payloads, idx)
        } else if (type == 'category') {
            response = await es.deleteCategory(payloads, idx)
        }

        return response
    }


    return {
        getEvent, storeParticipant, getPendingRegistration, getDashboardSummary, recentlyActivities,
        storeCollection, getEventList, eventListForUser, allEvents, getSelectedEvent, userAddedEvent,
        updateSelectedEvent, createCategory, createPickup, createShirt, createAge, deleteRecord
    }

}