<!-- DangerButton.vue -->
<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  href: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <Link
    :href="href"
    class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-sm text-white tracking-widest hover:bg-red-600 focus:bg-red-600 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
  >
  
    <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" viewBox="0 0 24 24" class="mr-1 mb-1 flex">
      <path fill="white" d="M6 21h12V7H6zM19 4h-3.5l-1-1h-5l-1 1H5v2h14z"/>
    </svg>
    <slot />
  </Link>
</template>
