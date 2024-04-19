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
    <slot />
  </Link>
</template>