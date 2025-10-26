// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  
  app: {
    pageTransition: { name: 'fade', mode: 'out-in' },
    layoutTransition: { name: 'layout', mode: 'out-in' },
    head: {
      charset: 'utf-8',
      viewport: 'width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0',
    },
    title: 'Nitro'
  },

  ssr: false,

  compatibilityDate: '2024-11-01',
  devtools: { enabled: true },
  modules: [
    '@pinia/nuxt',
    '@bootstrap-vue-next/nuxt',
    'nuxt-auth-sanctum',
    'nuxt-countdown',
    '@nuxt/image',
  ],
  css: [
    '@/assets/scss/global.scss',
    '@/assets/scss/global/inputs.scss',
    '@/assets/scss/global/registration.scss',
    'bootstrap/dist/css/bootstrap.min.css'
  ],
  vite: {
    css: {
      preprocessorOptions: {
        scss: {
          
          api: 'modern',
          silenceDeprecations: ['mixed-decls'],
          additionalData: `@use "~/assets/scss/_media-queries.scss" as *; 
                            @use "~/assets/scss/_colors.scss" as *;
                            @use "~/assets/scss/_fonts.scss" as *;`,
        },
      },
    },
  },
  imports: {
    dirs: [
      // Scan top-level modules
      'composables',
      // ... or scan modules nested one level deep with a specific name and file extension
      'composables/*/index.{ts,js,mjs,mts}',
      // ... or scan all modules within given directory
      'composables/**'
    ]
  },

  sanctum: {
    baseUrl: process.env.ENDPOINT_BASE_URL, // Laravel API
    redirect: {
        // onLogin: '/dashboard', // Custom route after successful login
        onLogin: '/user-events', // Custom route after successful login
        onAuthOnly: '/login',
    },
    endpoints: {
      csrf: '/sanctum/csrf-cookie',
      login: '/login',
      logout: '/logout',
      user: '/api/user',
    },
    csrf: {
        cookie: 'XSRF-TOKEN',
        header: 'X-XSRF-TOKEN',
    },
  },
  runtimeConfig: {
    public: {
      baseURL: process.env.ENDPOINT_BASE_URL || 'http://localhost:8000',

      webUrl: process.env.CLIENT_BASE_URL || 'http://localhost:3000',
    },

  },
})