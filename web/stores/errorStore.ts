import { defineStore } from 'pinia';

export const useErrorStore = defineStore('errorStore', {
    state: () => ({
        err: {}
    }),
    getters: {
        error(state) {
            if (state.err._data) {

                return state.err._data.errors
            } else {
                return null
            }
        },

        errorMessage(state) {
            if (state.err._data) {
                return state.err._data.message
            } else {
                return null
            }
        },

        errorStatus(state) {
            if (state.err.status) {
                return state.err.status
            } else {
                return null
            }
        }
    },
    actions: {
        getError(error: any) {
            this.$state.err = error
        }
    },
});
