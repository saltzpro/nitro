import Vue3Toastify, { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

export default defineNuxtPlugin((nuxtApp) => {
  nuxtApp.vueApp.use(Vue3Toastify, {
    theme: "colored", 
    autoClose: 2000,
    position: "top-center",
    transition: "slide",
    hideProgressBar: true
  });

  return {
    provide: { toast },
  };
});