<!-- SuccessButton.vue -->
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
    class="inline-flex items-center px-4 py-2 bg-[#008B8B] border border-transparent rounded-md font-semibold text-sm text-white tracking-widest hover:bg-[#17a2b8] focus:bg-[#17a2b8] active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
  >
  <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" class="mr-1 mb-1 flex" viewBox="0 0 16 16"><path fill="white" d="M2.984 8.625v.003a.5.5 0 0 1-.612.355c-.431-.114-.355-.611-.355-.611l.018-.062s.026-.084.047-.145a6.7 6.7 0 0 1 1.117-1.982C4.096 5.089 5.605 4 8 4s3.904 1.089 4.802 2.183a6.7 6.7 0 0 1 1.117 1.982a4 4 0 0 1 .06.187l.003.013v.004l.001.002a.5.5 0 0 1-.966.258l-.001-.004l-.008-.025l-.035-.109a5.7 5.7 0 0 0-.945-1.674C11.286 5.912 10.045 5 8 5s-3.285.912-4.028 1.817a5.7 5.7 0 0 0-.945 1.674l-.035.109zM5.5 9.5a2.5 2.5 0 1 1 5 0a2.5 2.5 0 0 1-5 0"/></svg>    <slot />
  </Link>
</template>