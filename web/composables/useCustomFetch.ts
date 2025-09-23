export const useCustomFetch: typeof useFetch = (request, opts?) => {
    const config = useRuntimeConfig()
    // localStorage.setItem('token', 'iahsdjlkasjdlakshdklashdlkasdjklasdhjaklsdj')
    const token = localStorage.getItem('token')

    if (token) {
        opts = {opts , headers: { Authorization: token } }
    }
    
    return useFetch(request, { baseURL: config.public.baseURL, ...opts })
}