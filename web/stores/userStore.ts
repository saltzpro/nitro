import { defineStore } from 'pinia';
import { LOGIN_URL, LOGOUT_URL } from '@/endpoints/endpoints'

export const useUserStore  = defineStore('user', {
    state: () => {
        return {
            user: {},
        }
    },
    getters: {
        getUser(state) {
            return state.user
        },
    },
    actions: {
        
        async login(payload) {
            const { login, isAuthenticated } = useSanctumAuth()
            
            try {
                const user = await login(payload)
                return user;
            } catch (e) {
                const error = useApiError(e);
                var errorBody = ''
                if (error.code == 422) {
                    errorBody = 'These credentials do not match our records.'
                } else if (error.code == 429) {
                    errorBody = 'Too Many Attempts.'
                } else if (error.code == 401) {
                    errorBody = 'Invalid login details, please try again'
                } else {
                    errorBody = 'Error, connection failed.'
                }
                useNuxtApp().$toast(errorBody, {type: 'error'});
                
                return false
            }
        },

        async logoutUser() {
            const response = await useSanctumFetch(LOGOUT_URL, {
                method: 'post'
            })
            
            const resData = response.data.value
            
            useNuxtApp().$toast(resData.message, {type: 'success'});
            // await reloadNuxtApp()
            return resData
        },
        
    },
});

