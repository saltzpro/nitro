export function useApi() {

    async function post(url: any, payloads: any) {
        const response = await useSanctumFetch(url, {
            method: 'post',
            body: payloads,
            headers: {
                'selected-event': localStorage.getItem('selected-event')
            }
        })

        return response
    }

    async function get(url: any, payloads: any) {
        const response = await useSanctumFetch(url, {
            params: payloads,
            headers: {
                'selected-event': localStorage.getItem('selected-event')
            }
        })
        
        return response
    }

    async function put(url: any, payloads: any) {
        const response = await useSanctumFetch(url, {
            method: 'put',
            body: payloads,
            headers: {
                'selected-event': localStorage.getItem('selected-event')
            }
        })

        return response
    }

    async function del(url: any, payloads: any) {
        const response = await useSanctumFetch(url, {
            method: 'delete',
            body: payloads,
            headers: {
                'selected-event': localStorage.getItem('selected-event')
            }
        })

        return response
    }

    return {
        post, get, put, del
    }

}