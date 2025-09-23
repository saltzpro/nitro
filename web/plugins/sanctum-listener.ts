
export default defineNuxtPlugin((nuxtApp) => {
  const errorStore = useErrorStore()
  nuxtApp.hook('sanctum:error', (error) => {
    if (error) {
      errorStore.getError(error)
    } else {
      errorStore.getError(null)
    }
  })

  
  
})